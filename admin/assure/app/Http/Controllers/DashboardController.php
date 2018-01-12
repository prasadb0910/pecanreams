<?php

namespace App\Http\Controllers;

use App\Project_detail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('CheckOtp');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project_detail  $project_detail
     * @return \Illuminate\Http\Response
     */
    public function show(Project_detail $project_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project_detail  $project_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Project_detail $project_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project_detail  $project_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project_detail $project_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project_detail  $project_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project_detail $project_detail)
    {
        //
    }
}
