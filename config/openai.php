<?php

return [
    'api_key' => env('OPENAI_API_KEY'),
    'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
    'prompts' => [
        'receipt_decoder' => '
            Image of a receipt is attached to the message.
            You need to get product_name, price, sale_price (price and sale_price per unit), quantity (or weight if it is specified), category from each product.
            If needed, extend product name to the full name.
            You should select categories only from the list: %s.
            Response message should be a valid JSON array of objects, where each object represents one position.
            Structure of the object:
            {
                "product_name": "product name",
                "price": 10.0,
                "sale_price": 5.0,
                "quantity": 1.0,
                "category": "category name"
            }
            '
    ]
];
