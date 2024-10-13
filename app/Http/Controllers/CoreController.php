<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Native\Laravel\Facades\Window;

class CoreController extends Controller
{
    public function index(Request $request)
    {
        match ($request->get('action')) {
            "reduce" => Window::minimize(Window::current()),
            "maximize" => Window::maximize(Window::current()),
            "close" => Window::close(Window::current())
        };
    }
}
