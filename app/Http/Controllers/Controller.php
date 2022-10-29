<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version = "1.1.2",
 *      title = "Laravel API Test Doc",
 *      description = "This is a simple API documentation.",
 *      @OA\Contact(email="tugrulbo@gmail.com"),
 *      @OA\License(name="Apache 2.0", url="http://wwww.apache.org/licenses/LICENSE-2.0.html")
 * ),
 * 
 * @OA/SecuritySchema(
 *      type="http",
 *      securityScheme="bearer_token",
 *      scheme ="bearer"
 *      
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
