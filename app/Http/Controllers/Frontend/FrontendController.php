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

class FrontendController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','ask','vip']]);
    }
    public function payment_method()
    {
        $payment = payment::orderBy('id', 'desc')->get()->all();
        // return response()->json(['user' => $user]);
        return response()->json([
            'status' => 'success',
            'payment' => $payment,

        ]);
    }
    public function deposit(Request $request)
    {
        $request->validate([
       
            'price' => 'required',
           
        ]);

        $method=payment::where('id',$request->method)->get()->first();
        $user=User::find(auth()->user()->id);
        if ($request->type=='withdraw') {
            $user->update(
                [
                    'main_balance' =>$user->main_balance-$request->price,
                    
    
                ]
            );
        }
        
        $deposit = transaction::create([
            'status' =>'pending',
            'user_id' => auth()->user()->id,
            'method' => $request->method,
            'type' => $request->type,

            'network' => $request->network,
            'price' => $request->price,
            'trxid' => $request->trxid,

            'address' => $request->address,


        ]);
        return response()->json([
            'message'=>'Your deposit request done.Wait few moment adding balence',
            'status' => $request->status,
            'user_id' => auth()->user()->id,
            'method' => $method,
            'type' => $request->type,

            'network' => $request->network,
            'price' => $request->price,
            'trxid' => $request->trxid,

            'address' => $request->address,
            'created_at' => now(),

        ]);
    }
    public function transaction(Request $request)
    {
        $allTransaction=transaction::with('method')->orderBy('id', 'desc')->get();
        $authTransaction = transaction::where('user_id',auth()->user()->id)->with('method')->orderBy('id', 'desc')->get();
        return response()->json([
            'allTransaction'=>$allTransaction,
            'authTransaction'=>$authTransaction

        ]);
    }
    
    public function vip(Request $request)
    {
        $vip=vip::with('vipunlock')->get();
       
        return response()->json([
            'vip'=>$vip,

        ]);
    }

    

    public function ask()
    {
        $ask=ask::orderBy('id', 'desc')->get();
       
        return response()->json([
            'ask'=>$ask,

        ]);
    }
   
}
