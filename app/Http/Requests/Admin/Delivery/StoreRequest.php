<?php

namespace App\Http\Requests\Admin\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'status' => 'boolean',
            'title' => 'required|string',
            'show_description' => 'boolean',
            'description' => 'nullable',
            'area' => 'required|json',
            'position' => 'nullable|integer'
        ];
    }
}
