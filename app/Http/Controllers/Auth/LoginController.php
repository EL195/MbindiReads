<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;

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

    //protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {
        $userId = Auth::id();
        $CurentUser= User::query()->where("id", $userId)->with("roles")->get()[0];
        //dd($CurentUser);
        $role = $CurentUser->roles[0]->title;
        //dd($role);
        switch ($role) {
          case 'Admin':
            return '/home';
            break;
          case 'School':
            return '/admin/classes';
            break; 
        case 'Parent':
            return '/admin/students';
            break; 
      
          default:
            return '/home'; 
          break;
        }
      }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
