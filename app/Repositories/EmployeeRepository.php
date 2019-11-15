<?php


namespace App\Repositories;


use App\Department;
use App\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;


class EmployeeRepository
{

    public function paginate($index){
        return Employee::paginate($index);
    }

    public function findOrFail($id){
        return Employee::findOrFail($id);
    }

    public function destroy($id){
        return Employee::destroy($id);
    }

    public function update($id,EmployeeRequest $request)
    {
        $employee = Employee::findOrFail($id);
        $old_department_ids = [];
        foreach ($employee->findOrFail($id)->departments()->get() as $item) {
            $old_department_ids[] = $item->pivot->department_id;
        }
      $employee->update($request->only(['name','surname','patronymic','sex','salary']));
    //    $employee->save();
        $department_ids = $request->get('department_id');
        $employee->departments()->sync($department_ids);
        self::set_department_after_edit($employee, $old_department_ids);
    }


    public function set_department_after_create(Employee $employee, $department_id){
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
    }

    public function set_department_after_delete(Employee $employee, $department_id){
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
