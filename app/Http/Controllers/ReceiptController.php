<?php

namespace App\Http\Controllers;

use App\DTO\ReceiptDTO;
use App\Http\Requests\Receipt\CreateReceiptRequest;
use App\Http\Requests\Receipt\RecognizeReceiptRequest;
use App\Resources\ReceiptResource;
use App\Services\ReceiptService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ReceiptController extends Controller
{
    public function __construct(private readonly ReceiptService $receiptService)
    {
    }

    public function index()
    {
        return response()->json(ReceiptResource::collection(
            $this->receiptService->getAll()
        ));
    }

    /**
     * @throws UnknownProperties
     */
    public function store(CreateReceiptRequest $request): JsonResponse
    {
        $receipt = $this->receiptService->create($request->getDTO());

        return response()->json(ReceiptResource::make($receipt));
    }

    public function show(string $id)
    {
        $receipt = $this->receiptService->getById($id);
        return response()->json(ReceiptResource::make($receipt));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function recognize(RecognizeReceiptRequest $request): JsonResponse
    {
        $data = $this->receiptService->recognize($request->file('file'));

        if (! $data) {
            return response()->json(['success' => false, 'error' => 'Unable to recognize image. Please, try again']);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }
}
