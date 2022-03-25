<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title=L5_SWAGGER_CONST_TITLE,
 *     version="1.0.0"
 * ),
 * @OA\Server(
 *     url="/api",
 *     description=L5_SWAGGER_CONST_TITLE
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="Bearer",
 *     type="http",
 *     scheme="bearer",
 * ),
 * @OA\Response(
 *     response=422,
 *     description="Validation error",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string"),
 *         @OA\Property(
 *             property="errors",
 *             type="object",
 *             @OA\AdditionalProperties(type="array", items="string",),
 *         ),
 *     ),
 * )
 * @OA\Response(
 *     response=401,
 *     description="Authentication error",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string"),
 *     ),
 * ),
 * @OA\Response(
 *     response=200,
 *     description="Success",
 *     @OA\JsonContent(),
 * ),
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
