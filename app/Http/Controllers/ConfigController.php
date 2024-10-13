<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $temp_folder = Config::where('temp_folder')->firstOrFail();
        $staging_area = Config::where('staging_area')->firstOrFail();
        return view('config', compact('temp_folder', 'staging_area'));
    }

    public function update(Request $request)
    {

    }
}
