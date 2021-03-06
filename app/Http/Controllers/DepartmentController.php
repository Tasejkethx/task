<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    private $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function index()
    {
        return DepartmentResource::collection($this->department
            ->select('*')
            ->selectSub(function ($query) {
                $query->from('employees')
                    ->join('department_employee', 'employees.id', '=', 'department_employee.employee_id')
                    ->selectRaw('max(salary)')
                    ->whereRaw('department_employee.department_id = departments.id');
            }, 'max_salary')
            ->withCount('employees')
            ->get());
    }

    public function store(DepartmentRequest $request)
    {
        $department = new Department($request->validated());
        $department->save();
        return new DepartmentResource($department);
    }

    public function edit(Request $request, $id)
    {
        return new DepartmentResource(Department::findOrFail($id));
    }

    public function update(DepartmentRequest $request, $id)
    {
        $department = $this->department->findOrFail($id);
        $department->update($request->validated());
        return new DepartmentResource($department);
    }

    public function destroy($id)
    {
        if (sizeof($this->department->findOrFail($id)->employees) === 0) {
            return $this->department->destroy($id);
        } else {
            return 2;
        }
    }
}
