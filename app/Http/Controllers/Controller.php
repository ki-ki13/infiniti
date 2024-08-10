<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Dokumentasi API",
     *      description="Entry Quiz Infiniti",
     *      @OA\Contact(
     *          email="rizkimahjati845@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\SecurityScheme(
     *         securityScheme="basicAuth",
     *         type="http",
     *         scheme="basic",
     *         description="Basic Authentication"
     *  )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="API Entry Quiz Infiniti"
     * )
     */

    private $username;
    private $password;

    public function __construct()
    {
        $this->username = env('AUTH_USERNAME', 'default_username');
        $this->password = env('AUTH_PASSWORD', Hash::make('default_password'));  // Store the hashed password
    }

    public function checkAuth($u, $p)
    {
        if ($u == $this->username && Hash::check($p, $this->password)) {
            return true;
        }
        return false;
    }
}
