<?php


namespace App\Repositories;


use App\Department;
use App\Employee;


class EmployeeRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $this->model->all();
    }

    public function paginate($size)
    {
        return $this->model->paginate($size);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function destroy($id)
    {
        $employee = $this->model->findOrFail($id);
        foreach ($employee->departments()->get() as $item) {
            $department_ids[] = $item->pivot->department_id;
        }
        $tmp = clone $employee;
        $status = $this->model->destroy($id);
        self::set_department_after_delete($tmp, $department_ids);
        return $status;
    }

    public function set_department_after_create(Employee $employee, $department_id)
    {
        for ($i = 0; $i < count($department_id); $i++) {
            $department = Department::findOrFail($department_id[$i]);
            if ($employee->salary > $department->max_salary) {
                $department->update([
                    'amount' => $department->amount + 1,
                    'max_salary' => $employee->salary,
                ]);
            } else {
                $department->update(['amount' => $department->amount + 1]);
            }
        }
    }

    public function set_department_after_delete(Employee $employee, $department_ids)
    {
        for ($i = 0; $i < count($department_ids); $i++) {
            $department = Department::findOrFail($department_ids[$i]);
            if ($department->amount == 1) {
                $department->update([
                    'amount' => $department->amount - 1,
                    'max_salary' => 0,
                ]);
            } else {
                if ($employee->salary == $department->max_salary) {
                    foreach ($department->employees()->get() as $item) {
                        $employeesInDepartment[] = $item->pivot->employee_id;
                    }
                    $max_salary = $this->model->whereIn('id', $employeesInDepartment)->max('salary');
                    $department->update([
                        'amount' => $department->amount - 1,
                        'max_salary' => $max_salary,
                    ]);
                } else {
                    $department->update(['amount' => $department->amount - 1]);
                }
            }
        }
    }

    public function set_department_after_edit(Employee $employee, $new_department_id)
    {
        foreach ($employee->departments()->get() as $item) {
            $department_ids[] = $item->pivot->department_id;
        }
        self::set_department_after_delete($employee, $department_ids);
        self::set_department_after_create($employee, $new_department_id);
    }
}
