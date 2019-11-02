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
            'salary'=>'required|numeric|max:10',
            'department_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Введите имя',
            'name.max'=>'Слишком длинное имя',
            'name.alpha'=>'Имя может содержать только буквы',
            'surname.required'=>'Введите фамилию',
            'surname.max'=>'Слишком длинная фамилия',
            'surname.alpha'=>'Фамилия может содержать только буквы',
            'patronymic.required'=>'Введите отчество',
            'patronymic.max'=>'Слишком длинное отчетсво',
            'patronymic.alpha'=>'Отчество может содержать только буквы',
            'sex.required'=>'Укажите ваш пол',
            'salary.required'=>'Введите заработную плату',
            'department_id.required'=>'Укажите отделения в которых работает сотрудник',
            'salary.numeric'=>'Введите число',
            'salary.max'=>'Ты столько не зарабатываешь)',
        ];
    }
}
