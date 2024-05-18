<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\payment;
use App\Models\transaction;
use App\Models\contact;
use App\Models\work;
use App\Models\lead;
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
        $this->middleware('auth:api', ['except' => ['login', 'register','leads_store', 'contact_store']]);
    }
    public function work(Request $request)
    {

        $work = work::where('user_id',auth()->user()->id)->get()->first();


        return response()->json([

            'economic' => $work,

        ]);
    }
    public function contact_store(Request $request)
    {

        $contact = contact::create(
            [
                'name'=>$request->name,
                'email' =>$request->email,
                'sub' =>$request->sub,
                'sms' =>$request->sms,
            ]
        );


        return response()->json([

            'message' => 'Thank You for give us message.We will contact with you later.',

        ]);
    }
    public function leads_store(Request $request)
    {

        $lead = lead::create(
            [
                'name'=>$request->name,
                'phone' =>$request->phone,
                'city' =>$request->city,
           
            ]
        );


        return response()->json([

            'message' => 'Thank You for give us information.We will contact with you later.',

        ]);
    }

}