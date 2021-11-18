<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubRequest extends FormRequest
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
            'unique_name' => 'string|alpha_dash|unique:clubs,unique_name|required',
            'name' => 'string|required',
            'password' => 'string|alpha_num|min:8|required',
        ];
    }
}
