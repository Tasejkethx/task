<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = new EmployeeRepository($employee);
    }

    public function index()
    {
        return EmployeeResource::collection($this->employee->paginate(5));
    }

    public function store(EmployeeRequest $request)
    {
        $employee = new Employee($request->only(['name', 'surname', 'patronymic', 'sex', 'salary']));
        $employee->save();
        $employee->departments()->sync($request->get('department_id'));
        return new EmployeeResource($employee);
    }

    public function edit(Request $request, $id)
    {
        return new EmployeeResource($this->employee->findOrFail($id));
    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = $this->employee->findOrFail($id);
        $employee->update($request->only(['name', 'surname', 'patronymic', 'sex', 'salary']));
        $employee->departments()->sync($request->get('department_id'));
        return new EmployeeResource($employee);
    }

    public function destroy($id)
    {
        return $this->employee->destroy($id);
    }

}
