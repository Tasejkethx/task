<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $employees = Employee::all();

        $mass=[];
        foreach ($employees as & $employee){
            foreach(Employee::findOrFail($employee->id)->departments()->get()as $item){
                $mass[]=$item->pivot->department_id;
            }
            $employee['department_id'] = $mass;
            unset($mass);
        }

        if($request->expectsJson()){
            return response()->json($employees);
        }
        return view('employee.index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Employee $employee)
    {
        //
    }


    public function edit(Employee $employee)
    {
        //
    }


    public function update(Request $request, Employee $employee)
    {
        //
    }


    public function destroy(Employee $employee)
    {
        //
    }
}
