<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Contracts\Validation\Validator as Validation;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->commonService = $commonService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validation
     */
    protected function validator(array $data) : Validation
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) : User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->commonService->writeLog("New user just registered with data : \n " . json_encode($data));
        return $user;
    }
}
