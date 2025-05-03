<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentUserRequest;
use App\Models\StudentUser;

class StudentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StudentUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentUser $studentUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentUser $studentUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentUserRequest $request, StudentUser $studentUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentUser $studentUser)
    {
        //
    }
}
