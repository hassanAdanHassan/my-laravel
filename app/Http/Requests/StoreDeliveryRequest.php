<?php

namespace App\Http\Requests;

use App\Models\products;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreDeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id'          => 'required|exists:customers,id',
            'destination'          => 'required|string|max:255',
            'items'                => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.quantity'     => 'required|integer|min:1',
        ];
    }

    /**
     * Add stock availability check after standard validation passes.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $items = $this->input('items', []);

            foreach ($items as $index => $item) {
                $productId = $item['product_id'] ?? null;
                $quantity  = $item['quantity'] ?? null;

                if (!$productId || !$quantity) {
                    continue;
                }

                $product = products::find($productId);

                if ($product && $product->amount < $quantity) {
                    $validator->errors()->add(
                        "items.{$index}.quantity",
                        "Insufficient stock for product \"{$product->name}\": requested {$quantity}, available {$product->amount}."
                    );
                }
            }
        });
    }
}
