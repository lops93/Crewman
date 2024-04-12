<?php

namespace App\Http\Controllers;

use App\Models\AssignmentRole;
use Illuminate\Http\Request;

class AssignmentRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignmentRoles = AssignmentRole::all();
        return response()->json($assignmentRoles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignmentRole $assignmentRole)
    {
        return response()->json($assignmentRole);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
