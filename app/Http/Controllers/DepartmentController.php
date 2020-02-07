<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function index()
    {
        return DepartmentResource::collection($this->department->all()->load('employees'));
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
