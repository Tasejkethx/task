<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class   EmployeeRequest extends FormRequest
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
            'name'=>'required|alpha|max:30',
            'surname'=>'required|alpha|max:30',
            'patronymic'=>'required|alpha|max:30',
            'sex' =>'required|in:male,female',
            'salary'=>'required|numeric|between:0,9999999',
            'department_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Введите :attribute',
            'name.max'=>':attribute должно содержать менее :max символов',
            'name.alpha'=>':attribute может содержать только буквы',
            'surname.required'=>'Введите :attribute',
            'surname.max'=>':attribute должна содержать менее :max символов',
            'surname.alpha'=>':attribute может содержать только буквы',
            'patronymic.required'=>'Введите :attribute',
            'patronymic.max'=>':attribute должно содержать менее :max символов',
            'patronymic.alpha'=>':attribute может содержать только буквы',
            'sex.required'=>'Укажите :attribute',
            'salary.required'=>'Введите :attribute',
            'department_id.required'=>'Укажите :attribute',
            'salary.numeric'=>'Введите число',
            'salary.between'=>':attribute должна быть в диапазоне :min - :max',
        ];
    }
}
