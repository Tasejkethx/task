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
      //  return view('department.index');
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


    public function edit(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        if($request->expectsJson()){
            return response()->json($department);
        }
       // return view('department.edit');
    }


    public function update(DepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->name=$request->get('name');
        $department->save();
        return response()->json(['success'=>true]);
    }


    public function destroy($id)
    {
        $department= Department::findOrFail($id);
        $department->delete();
        return response()->json(['success'=>true]);
    }
}
