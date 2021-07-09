<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tasks = $request->user()->vehicles;
        return view('vehicle.index', ['vehicles' => $request->user()->vehicles]);
    }
}
