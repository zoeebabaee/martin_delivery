<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'source_mobile' => "required",
            'source_name' => 'required',
            'source_address' => 'required',
            'source_longitude' => 'required',
            'source_latitude' => 'required',

            'destination_mobile' => 'required',
            'destination_name' => 'required',
            'destination_address' => 'required',
            'destination_longitude' => 'required',
            'destination_latitude' => 'required',


        ];
    }
}
