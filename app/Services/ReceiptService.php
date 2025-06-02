<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\ReceiptDTO;
use App\DTO\ReceiptItemDTO;
use App\Models\Category;
use App\Models\Receipt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use OpenAI;
use Throwable;

class ReceiptService
{
    public function create(ReceiptDTO $dto): Receipt
    {
        $receipt = new Receipt();
        $receipt->shop_id = $dto->shop_id;
        $receipt->amount = $dto->amount;

        if ($dto->file) {
            $path = $dto->file->storePublicly('receipts');
            $receipt->file_path = $path;
        }

        $receipt->save();

        foreach($dto->items as $item){
            $receipt->items()->create([
                'category_id' => $item->category_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'sale_price' => $item->sale_price,
                'total_price' => $item->quantity * $item->price,
            ]);
        }

        return $receipt;
    }

    public function recognize(UploadedFile $file): ReceiptDTO|false
    {
        $image = ImageManager::imagick()->read($file->getRealPath());
        $image = $image->contrast(100)->toGif();

        $client = OpenAI::client(config('openai.api_key'));

        $result = $client->chat()->create([
            'model' => config('openai.model'),
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => $this->getReceiptDecoderPrompt(),
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => $image->toDataUri(),
                            ]
                        ]
                    ]
                ],
            ],
        ]);

        $defaultCategory = Category::query()->firstWhere('name', 'Other');
        try {
            $totalSum = 0;
            $items = json_decode(str_replace(['```', 'json'] , '', $result->choices[0]->message->content), true);
            $categories = Category::query()->pluck('id', 'name')->toArray();
            $itemDTOs = array_map(function(array $receiptItem) use ($categories, &$totalSum, $defaultCategory) {
                $totalSum += (float) $receiptItem['price'] * (float) $receiptItem['quantity'];
                return new ReceiptItemDTO([
                    'category_id' => (int) ($categories[$receiptItem['category']] ?? $defaultCategory->getKey()),
                    'name' => $receiptItem['product_name'],
                    'quantity' => (float) $receiptItem['quantity'],
                    'price' => (float) $receiptItem['price'],
                    'sale_price' => (float) $receiptItem['sale_price'] ?? null,
                ]);
            }, $items);
        } catch (Throwable $e) {
            Log::info('Receipt recognition error: ' . $e->getMessage(), $items);
            return false;
        }

        return new ReceiptDTO([
            'shop_id' => 1,
            'amount' => $totalSum,
            'created_at' => now(),
            'updated_at' => now(),
            'items' => $itemDTOs
        ]);
    }

    public function getAll(): Collection
    {
        return Receipt::query()
            ->with(['items', 'items.category'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById(string $id): Receipt
    {
        return Receipt::query()
            ->with(['items', 'items.category'])
            ->findOrFail($id);
    }

    private function getReceiptDecoderPrompt(): string
    {
        $categories = Category::all()->pluck('name')->implode(',');

        return sprintf(config('openai.prompts.receipt_decoder'), $categories);
    }
}
