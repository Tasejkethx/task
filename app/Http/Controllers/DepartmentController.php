<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\DepartmentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
/*
        try{
        $departments= Department::all();
        if($request->expectsJson()){
            return response()->json($departments);
        }
        } catch (\Exception $e){
            return response()->json(['doesNotExist'=>true]);
        }
*/
       return  new DepartmentCollection(Department::all());
    }


    public function create()
    {
        //
    }


    public function store(DepartmentRequest $request)
    {
        try{
        $department = new Department([
            'name'=>$request->get('name'),
        ]);
        $department->save();
        return response()->json(['success'=>true]);
        } catch (\Exception $e){
            return response()->json(['doesNotExist'=>true]);
        }
    }


    public function show(Department $department)
    {
        //
    }


    public function edit(Request $request, $id)
    {
        /*
        try {
            $department = Department::findOrFail($id);
            if ($request->expectsJson()) {
                return response()->json($department);
            }
        } catch (ModelNotFoundException $e) {
                return response()->json(['doesNotExist' => true]);
            }
        */
        return new DepartmentResource(Department::findOrFail($id));
    }


    public function update(DepartmentRequest $request, $id)
    {
        try{
        $department = Department::findOrFail($id);
        $department->name=$request->get('name');
        $department->save();
        return response()->json(['success'=>true]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['doesNotExist' => true]);
        }
    }


    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);
            if ($department->amount == 0) {
                $department->delete();
                return response()->json(['success' => true]);
            } else  {
                return response()->json(['amount' => true]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['doesNotExist' => true]);
        }
    }
}
