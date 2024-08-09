<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private $username;
    private $password;

    public function __construct()
    {
        $this->username = env('AUTH_USERNAME', 'default_username');
        $this->password = env('AUTH_PASSWORD', Hash::make('default_password'));  // Store the hashed password
    }

    public function checkAuth($u, $p) {
        if ($u === $this->username && Hash::check($p, $this->password)) {
            return true;
        }
        return false;
    }
}
