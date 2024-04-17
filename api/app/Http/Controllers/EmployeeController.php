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
        $request->validated();
        $employee = new Employee();

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->identification_number = $request->identification_number;
        $employee->save();
        return response()->json("Record created successfully");
    }

    public function show(Employee $employee)
    {
        $employee = $employee->load([
            'employments.assignments',
            'employments.assignments.employer',
            'employments.assignments.locations',
            'employments.assignments.assignmentRoles',
            'employments.assignments.assignmentRoles.assignmentRoleType',
            'employments.assignments.leaves'
        ]);

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

    public function getLastEmployee()
    {
        return Employee::latest()->first();;
    }
}
