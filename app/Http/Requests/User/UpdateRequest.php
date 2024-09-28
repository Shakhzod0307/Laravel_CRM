<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
          'first_name'=>'nullable',
          'last_name'=>'nullable',
          'email'=>'nullable',
          'phone'=>'nullable',
          'image'=>'nullable',
          'organization'=>'nullable',
          'language'=>'nullable',
          'state'=>'nullable',
          'zip_code'=>'nullable',
          'address'=>'nullable',
          'country'=>'nullable',
          'currency'=>'nullable',
        ];
    }
}
