<?php
   
namespace App\Http\Controllers\Api\V1\Admin;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Admin\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Student;
use Spatie\MediaLibrary\Models\Media;
   
class AuthController extends BaseController
{
    public function signin(Request $request)
    {

        $student = Student::query()->where("username", strtolower($request->username))->where("password", $request->password)->get();
        return $student;
       /*  if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
            $student = Auth::student(); 
            $success['token'] =  $student->createToken('MyAuthApp')->plainTextToken; 
            $success['name'] =  $student->first_name;
   
            return $this->sendResponse($success, 'User signed in');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }   */
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User created successfully.');
    }
   
}