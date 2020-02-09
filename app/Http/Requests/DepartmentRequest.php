<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'name'=>'required|unique:departments|max:50',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Введите название отдела',
            'name.unique'=>'Такой отдел уже существует',
            'name.max'=>'Название отдела должно быть меньше :max символов',
        ];
    }
}
