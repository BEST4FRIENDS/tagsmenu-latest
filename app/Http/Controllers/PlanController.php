<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Display the list of available subscription plans.
     */
    public function index(): View
    {
        return view('plans.index');
    }
}