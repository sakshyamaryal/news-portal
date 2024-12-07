<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $access = $this->middleware('can:dashboard');
        if (!$access) {
            abort(403, 'You do not have access to dashboard');
        }
    }
    public function index()
    {
        return view('Dashboard.index');
    }
}
