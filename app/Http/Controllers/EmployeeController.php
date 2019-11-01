<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        try{
        $employees = Employee::paginate(5);
        $department_ids=[];
        $department_names=[];

        // for display departments
        foreach ($employees as & $employee){
            foreach(Employee::findOrFail($employee->id)->departments()->get()as $item){
                $department_ids[]=$item->pivot->department_id;
                $department_names[]=$item->pivot->department_name;
            }
            $employee['department_id'] = $department_ids;
            if (count($department_names)>1){
                $employee['department_name'] = join(', ', $department_names);
            } else {$employee['department_name']=$department_names[0];}
            unset($department_ids);
            unset($department_names);
        }
        //
        if($request->expectsJson()){
            return response()->json($employees);
        }
        }catch (\Exception $e){
            return response()->json(['doesNotExist'=>true]);
        }
    }


    public function create()
    {
        //
    }


    public function store(EmployeeRequest $request)
    {
        try{
        $employee = new Employee([
            'name'=>$request->get('name'),
            'surname'=>$request->get('surname'),
            'patronymic'=>$request->get('patronymic'),
            'sex' =>$request->get('sex'),
            'salary'=>$request->get('salary'),
        ]);

        $department_ids= $request->get('department_id');
        self::set_department_after_create($employee, $department_ids);
            $departments = Department::whereIn('id', $department_ids)->pluck('name')->toArray();
            $temp = array_map(function($department){
                return ['department_name' => $department];
            }, $departments);
            $pivotData = array_combine($department_ids, $temp);
        $employee->save();
        $employee=Employee::latest()->first();

        $employee->departments()->sync($pivotData);

        return response()->json(['success'=>true]);
        } catch (ModelNotFoundException $e){
            return response()->json(['doesNotExist'=>true]);
        }
    }


    public function show(Employee $employee)
    {
        //
    }


    public function edit(Request $request, $id)
    {
        try {
            $department_ids=[];
            $employee = Employee::findOrFail($id);

            foreach (Employee::findOrFail($id)->departments()->get() as $item) {
                $department_ids[] = $item->pivot->department_id;
            }
            $employee['department_id'] = $department_ids;
            return response()->json($employee);
        } catch (ModelNotFoundException $e){
            return response()->json(['doesNotExist'=>true]);
        }
    }


    public function update(EmployeeRequest $request, $id)
    {
        try{
        $employee = Employee::findOrFail($id);
        $employee->name=$request->get('name');
        $employee->surname=$request->get('surname');
        $employee->patronymic=$request->get('patronymic');
        $employee->sex =$request->get('sex');
        $employee->salary=$request->get('salary');

        $old_department_ids=[];
        foreach($employee->findOrFail($id)->departments()->get()as $item){
            $old_department_ids[]=$item->pivot->department_id;
        }

        $employee->save();
            $department_ids= $request->get('department_id');
            $departments = Department::whereIn('id', $department_ids)->pluck('name')->toArray();
            $temp = array_map(function($department){
                return ['department_name' => $department];
            }, $departments);
            $pivotData = array_combine($department_ids, $temp);

            $employee->departments()->sync($pivotData);
            self::set_department_after_edit($employee,$old_department_ids);

        return response()->json(['success'=>true]);
        } catch (ModelNotFoundException $e){
            return response()->json(['doesNotExist'=>true]);
        } catch (\Exception $e){
            return response()->json(['departmentDoestNotExist'=> true]);
        }
    }


    public function destroy($id)
    {
        try{
        $employee= Employee::findOrFail($id);

            $department_ids=[];
        foreach($employee->departments()->get()as $item){
            $department_ids[]=$item->pivot->department_id;
        }
        $tmp= clone $employee;
        $employee->delete();
        self::set_department_after_delete($tmp,$department_ids);

        return response()->json(['success'=>true]);

        } catch (ModelNotFoundException $e){
            return response()->json(['doesNotExist'=>true]);
        }
    }

       /// Update department table after create/edit/delete action
    public function set_department_after_create(Employee $employee, $department_id){
        try{
        for($i=0;$i<count($department_id);$i++) {
            $department = Department::findOrFail($department_id[$i]);
            if ($employee->salary > $department->max_salary) {
                Department::findOrFail($department_id[$i])->update([
                    'amount' => $department->amount + 1,
                    'max_salary' => $employee->salary,
                ]);
            } else {
                Department::findOrFail($department_id[$i])->update(['amount' => $department->amount + 1]);
            }
        }
        } catch (\Exception $e){
          throw new ModelNotFoundException();
        }
    }

    public function set_department_after_delete(Employee $employee, $department_id){
        try{
        for($i=0;$i<count($department_id);$i++) {
            $department = Department::findOrFail($department_id[$i]);
            if ($department->amount == 1){
                Department::findOrFail($department_id[$i])->update([
                    'amount' => $department->amount - 1,
                    'max_salary' => 0,
                ]);
            } else if ($employee->salary == $department->max_salary) {
                $mass=[];
                foreach ($department->employees()->get()as $item){
                    $mass[]=$item->pivot->employee_id;
                }
                $max_salary = Employee::whereIn('id',$mass)->max('salary');
                Department::findOrFail($department_id[$i])->update([
                    'amount' => $department->amount - 1,
                    'max_salary' => $max_salary,
                ]);
            } else {
                Department::findOrFail($department_id[$i])->update(['amount' => $department->amount -1]);
            }
        }
        } catch (\Exception $e){
            throw new ModelNotFoundException();
        }
    }

    public function set_department_after_edit(Employee $employee, $old_department_id){
        try{
        $new_department_id=[];
        foreach($employee->departments()->get()as $item){
            $new_department_id[]=$item->pivot->department_id;
        }
            self::set_department_after_delete($employee,$old_department_id);
            self::set_department_after_create($employee,$new_department_id);

        } catch (\Exception $e){
            throw new ModelNotFoundException();
        }
    }

}
