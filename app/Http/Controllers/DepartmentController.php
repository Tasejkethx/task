<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        $departments= Department::all();
        if($request->expectsJson()){
            return response()->json($departments);
        }
        return view('department.index');
    }


    public function create()
    {
        //
    }


    public function store(DepartmentRequest $request)
    {
        $department = new Department([
            'name'=>$request->get('name'),
        ]);

        $department->save();

        return response()->json(['success'=>true]);
    }


    public function show(Department $department)
    {
        //
    }


    public function edit(Department $department)
    {
        //
    }


    public function update(Request $request, Department $department)
    {
        //
    }


    public function destroy(Department $department)
    {
        //
    }
}
