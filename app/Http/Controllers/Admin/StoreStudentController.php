<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\StoreStudent;

class StoreStudentController extends Controller
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
    public function store(StoreStudentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StoreStudent $storeStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreStudent $storeStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStudentRequest $request, StoreStudent $storeStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreStudent $storeStudent)
    {
        //
    }
}
