<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Check if user exists
        $user = User::where('email', request('identifier'))
            ->orWhere('username', request('identifier'))
            ->first();

        // if User not found
        if (!$user) {
            return Helper::apiRes("email or username not found", [], false, 401);
        }

       return $this->logUserIn($user);
    }

    public function register(Request $request){
        try {
            //code...
            $user = new User;
            $user->name = ucfirst($request->name);
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->save();
        } catch (\Throwable $th) {
            return Helper::apiRes($th->getMessage(), [], false, 401);
        }

        return $this->logUserIn($user,"Registration Successful");
    }

    public function logUserIn(User $user,$mesaage = "Successfully logged in"){
        // if user found, attempt authentication
        Auth::attempt(['email' => $user->email, 'password' => request('password')]);

        // if authentication failed
        if (!Auth::check()) {
            return Helper::apiRes("invalid login credentials", [], false, 401);
        }
        
        $token = Auth::user()->createToken(config('app.key'))->plainTextToken;

        // Authentication Succeeded
        return Helper::apiRes($mesaage, ["token" => $token], true, 200);
    }

    public function user(){
        return Helper::apiRes("Logged in User", new ResourcesUser(Auth::user()));
    }

    public function refreshDatabase(){
        try {
            Artisan::call('migrate:refresh --seed --no-interaction');
        } catch (\Throwable $th) {
            return Helper::apiRes($th->getMessage(), [], false, 500);
        }

        return Helper::apiRes("Database Refresh Completed");
    }
}
