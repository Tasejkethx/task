<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name'=>'required',
            'surname'=>'required',
            'patronymic'=>'required',
            'sex' =>'required|in:male,female',
            'salary'=>'required|numeric',
            'department_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Введите имя',
            'surname.required'=>'Введите фамилию',
            'patronymic.required'=>'Введите отчество',
            'sex.required'=>'Укажите ваш пол',
            'salary.required'=>'Введите заработную плату',
            'department_id.required'=>'Укажите отделения в которых работает сотрудник',
            'salary.numeric'=>'Введите число',
        ];
    }
}
