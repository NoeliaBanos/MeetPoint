<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
  public function rules(): array
{
    return [
        'name'       => ['required','string','max:255'],
        'apellidos'  => ['nullable','string','max:255'],
        'email'      => [
            'required',
            'email',
            'max:255',
            // sin regla lowercase, y excluimos el propio usuario en la validación unique:
            Rule::unique('users','email')->ignore($this->user()->id),
        ],
        'avatar'     => [
            'nullable',
            'image',          // sólo imágenes
            'mimes:jpg,jpeg,png,gif,svg,webp',
            'max:400',        // ≤ 400 KB
        ],
    ];
}

}
