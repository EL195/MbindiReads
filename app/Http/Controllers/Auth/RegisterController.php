<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fisrt_name'     => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'integer'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user  =  User::create([
            'fisrt_name'     => $data['fisrt_name'],
            'last_name'     => $data['last_name'],
            'phone'     => $data['phone'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $id= $user->id;
        DB::insert('insert into role_user values (?, ?)', [$id, $data['role']]);

/*         Mail::send('newUser', function($message){
            $message->from('contact@mbindireads.com');
            $message->subject('Welcome to Mbindi Reads');
            $message->to($data['email']);
        }); */

        //return view('/login');
        //return redirect()->route('login');

    }
}
