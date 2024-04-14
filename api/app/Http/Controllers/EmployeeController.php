<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function store(EmployeeRequest $request)
    {
        Employee::create($request->validated());
        return response()->json("Record created successfully");
    }

    public function show(Employee $employee)
    {
        $employee = $employee->employments()
        ->with('assignments',
         'assignments.employer',
         'assignments.locations',
         'assignments.assignmentRoles',
         'assignments.assignmentRoles.assignmentRoleType',
         'assignments.leaves')->get();

        return response()->json($employee);
    }

    public function update(EmployeeRequest $request, Employee $employee){
        $employee->update($request->validated());
        return response()->json("Record updated successfully");
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json("Record deleted successfully");
    }
}
