<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InboundController extends Controller
{
    function index()
    {
        return view('page/inbound');
    }
}
