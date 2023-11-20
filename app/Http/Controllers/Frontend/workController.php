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
use App\Models\work;
use App\Models\workdetails;
use PhpParser\Node\Stmt\Return_;

class workController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'ask', 'work']]);
    }
    public function work(Request $request)
    {

        $work = work::get();


        return response()->json([

            'work' => $work,

        ]);
    }
    public function workstor(Request $request)
    {

        $request->validate([
       
            'work_id' => 'required',
            'earn' => 'required',
           
        ]);
        $work = workdetails::create([
            'status' => 'pending',
            'work_id' => $request->work_id,
            'user_id' => $request->user_id,
            'earn' => $request->earn,



        ]);




        return response()->json([

            'work' => $work,

        ]);
    }
}
