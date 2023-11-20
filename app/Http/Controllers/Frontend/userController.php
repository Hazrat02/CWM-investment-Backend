<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\payment;
use App\Models\transaction;
use App\Models\ask;
use App\Models\vip;
use PhpParser\Node\Stmt\Return_;

class userController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'ask', 'vip']]);
    }
    public function userEdit(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->get()->first();
        if (isset($request->name)) {
            $name = $request->name;
        } else {
            $name = $user->name;
        }

        if (isset($request->main_balance)) {
            $balance = $request->main_balance;
        } else {
            $balance = $user->main_balance;
        }
        if (isset($request->vip)) {
            $vip = $request->vip;
            $email_verified_at = now();
        } else {
            $vip = $user->vip;
            $email_verified_at = null;
        }
        if (isset($request->frozen_balance)) {
            $frozen_balance = $request->frozen_balance;
        } else {
            $frozen_balance = $user->frozen_balance;
        }
        if (isset($request->email)) {
            $email = $request->email;
        } else {
            $email = $user->email;
        }
        if (isset($request->password)) {
            $request->validate([
                
                'password' => 'required|string|min:6|confirmed',
            ]);
    
            $password= Hash::make($request->password);
            
        } else {
            $password = $user->password;
        }


        $response = User::where('id', auth()->user()->id)->update([
            'id' => auth()->user()->id,
            'main_balance' => $balance,
            'name' => $name,
            'vip' => $vip,
            'email_verified_at' => $email_verified_at,
            'frozen_balance' => $frozen_balance,
            'email' => $email,
            'password'=>$password,
            'created_at' => $user->created_at,
            
        ]);


        return response()->json([
            'id' => auth()->user()->id,
            'main_balance' => $balance,
            'name' => $name,
            'vip' => $vip,
            'email_verified_at' => $email_verified_at,
            'frozen_balance' => $frozen_balance,
            'email' => $email,
            'created_at' => $user->created_at,
        ]);
    }
    public function reffer_details(Request $request)
    {
        $alluser=User::where('use_reffer',auth()->user()->my_reffer)->latest()->take(6)->get();
        return response()->json([
            'alluser'=>$alluser,

        ]);
    }
   

}
