<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Http\Requests\EmployeeRequest;
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
       // return view('employee.index');
    }


    public function create()
    {
        //
    }


    public function store(EmployeeRequest $request)
    {
        $employee = new Employee([
            'name'=>$request->get('name'),
            'surname'=>$request->get('surname'),
            'patronymic'=>$request->get('patronymic'),
            'sex' =>$request->get('sex'),
            'salary'=>$request->get('salary'),
        ]);

        $mass= $request->get('department_id');
        self::set_department_after_create($employee, $mass);

        $employee->save();
        $employee=Employee::latest()->first();
        $employee->departments()->sync($mass);

        return response()->json(['success'=>true]);
    }


    public function show(Employee $employee)
    {
        //
    }


    public function edit(Request $request, $id)
    {
        $mass=[];
        $employee = Employee::findOrFail($id);
        foreach(Employee::findOrFail($id)->departments()->get()as $item){
            $mass[]=$item->pivot->department_id;
        }

        $employee['department_id']= $mass;
        if($request->expectsJson()){
            return response()->json($employee);
        }
    }


    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->name=$request->get('name');
        $employee->surname=$request->get('surname');
        $employee->patronymic=$request->get('patronymic');
        $employee->sex =$request->get('sex');
        $employee->salary=$request->get('salary');

        $old_department_id=[];
        foreach($employee->findOrFail($id)->departments()->get()as $item){
            $old_department_id[]=$item->pivot->department_id;
        }

        $employee->save();
        $mass= $request->get('department_id');
        $employee->departments()->sync($mass);
        self::set_department_after_edit($employee,$old_department_id);

        return response()->json(['success'=>true]);
    }


    public function destroy($id)
    {
        $employee= Employee::findOrFail($id);

        $department_id=[];
        foreach($employee->departments()->get()as $item){
            $department_id[]=$item->pivot->department_id;
        }

        $tmp= clone $employee;
        $employee->delete();
        self::set_department_after_delete($tmp,$department_id);

        return response()->json(['success'=>true]);
    }

       /// Update department table after create/edit/delete action
    public function set_department_after_create(Employee $employee, $department_id){
        for($i=0;$i<count($department_id);$i++) {
            $department = Department::find($department_id[$i]);
            if ($employee->salary > $department->max_salary) {
                Department::findOrFail($department_id[$i])->update([
                    'amount' => $department->amount + 1,
                    'max_salary' => $employee->salary,
                ]);
            } else {
                Department::findOrFail($department_id[$i])->update(['amount' => $department->amount + 1]);
            }
        }
    }

    public function set_department_after_delete(Employee $employee, $department_id){
        for($i=0;$i<count($department_id);$i++) {
            $departm = Department::find($department_id[$i]);
            if ($departm->amount == 1){
                Department::findOrFail($department_id[$i])->update([
                    'amount' => $departm->amount - 1,
                    'max_salary' => 0,
                ]);
            } else if ($employee->salary == $departm->max_salary) {
                $mass=[];
                foreach ($departm->employees()->get()as $item){
                    $mass[]=$item->pivot->employee_id;
                }
                $max_salary = Employee::whereIn('id',$mass)->max('salary');
                Department::findOrFail($department_id[$i])->update([
                    'amount' => $departm->amount - 1,
                    'max_salary' => $max_salary,
                ]);
            } else {
                Department::findOrFail($department_id[$i])->update(['amount' => $departm->amount -1]);
            }
        }
    }

    public function set_department_after_edit(Employee $employee, $old_department_id){
        $new_department_id=[];
        foreach($employee->departments()->get()as $item){
            $new_department_id[]=$item->pivot->department_id;
        }

        self::set_department_after_delete($employee,$old_department_id);
        self::set_department_after_create($employee,$new_department_id);
    }
}
