<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Main Controller For Authentication.
 *
 * This controller handles the authorization and validation logic for the application.
 * It uses the AuthorizesRequests and ValidatesRequests traits to provide functionality
 * for authorizing actions and validating requests.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
