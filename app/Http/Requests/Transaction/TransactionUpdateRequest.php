<?php

namespace App\Http\Requests\Transaction;

use App\Enums\TransactionTypes;
use Illuminate\Validation\Rule;

class TransactionUpdateRequest extends TransactionStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => [Rule::enum(TransactionTypes::class)],
            'description' => ['string'],
            'amount' => ['decimal:2'],
        ];
    }
}
