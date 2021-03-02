<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => 'required|json',
            'total_sum' => 'required',
            'payment' => 'required',
            'payment_method' => 'required',
            'delivery_method' => 'required',
            'customer_name' => 'required|min:2|regex:/^[\pL\s\-]+$/u',
            'customer_phone' => 'required|min:2',
            'customer_email' => 'required|min:2|regex:/^[a-z0-9-_\.]+@[a-z0-9-_]+\.[a-z]{1,10}$/i',
            'comment' => 'max:1000',
        ];
    }
}
