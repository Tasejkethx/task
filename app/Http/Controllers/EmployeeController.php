<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(EmployeeRepository $employee)
    {
        $this->employee = $employee;
    }

    public function index()
    {
        return EmployeeResource::collection($this->employee->paginate(3));
    }

    public function create()
    {
        //
    }

    public function store(EmployeeRequest $request)
    {
        $employee = new Employee($request->only(['name','surname','patronymic','sex','salary']));
        $department_ids= $request->get('department_id');
        $this->employee->set_department_after_create($employee, $department_ids);
        $employee->save();
        $employee->departments()->sync($department_ids);
        return new EmployeeResource($employee);
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit(Request $request,  $id)
    {
        return new EmployeeResource($this->employee->findOrFail($id));
    }

    public function update(EmployeeRequest $request, $id)
    {
         $this->employee->update($id, $request);

    }

    public function destroy($id)
    {
      return $this->employee->destroy($id);
    }

}
