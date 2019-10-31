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
            'name'=>'required|string|max:30',
            'surname'=>'required|string|max:30',
            'patronymic'=>'required|string|max:30',
            'sex' =>'required|in:male,female',
            'salary'=>'required|numeric',
            'department_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Введите имя',
            'name.max'=>'Слишком длинное имя',
            'name.string'=>'Имя может содержать только буквы',
            'surname.required'=>'Введите фамилию',
            'surname.max'=>'Слишком длинная фамилия',
            'surname.string'=>'Фамилия может содержать только буквы',
            'patronymic.required'=>'Введите отчество',
            'patronymic.max'=>'Слишком длинное отчетсво',
            'patronymic.string'=>'Отчество может содержать только буквы',
            'sex.required'=>'Укажите ваш пол',
            'salary.required'=>'Введите заработную плату',
            'department_id.required'=>'Укажите отделения в которых работает сотрудник',
            'salary.numeric'=>'Введите число',
        ];
    }
}
