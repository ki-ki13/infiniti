<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutboundController extends Controller
{
    function index()
    {
        return view('page/outbound');
    }
}
