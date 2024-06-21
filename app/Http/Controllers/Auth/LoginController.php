<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = '/home';

    /**
     * Common Service to use in this controller.
     *
     * @var CommonService
     */
    private CommonService $commonService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommonService $commonService)
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
        $this->commonService = $commonService;
    }

    /**
     * Handle tasks after user authentication.
     *
     * This method is called after the user is authenticated. It logs out other devices
     * using the provided password and writes a log entry indicating that the user has logged in.
     * This method overrides the `authenticated` method in `\Illuminate\Foundation\Auth\AuthenticatesUsers`.
     *
     * @param Request $request The incoming request instance.
     * @param User $user The authenticated user instance.
     * @return void
     */
    protected function authenticated(Request $request, $user): void
    {
        Auth::logoutOtherDevices($request->password);
        $this->commonService->writeLog(Auth::user()->name . " just logged in");
    }

}
