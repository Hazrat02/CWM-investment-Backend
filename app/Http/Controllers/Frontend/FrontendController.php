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
       
            'amount' => 'required',

           
        ]);

        $user=User::find(auth()->user()->id);
        if ($request->type=='withdraw' ||$request->type=='Withdraw' ) {


            if ($request->address == 'wallet' || $request->address == 'Wallet' ) {
                    
            $user->update(
                [
                    'main_balance' =>$user->main_balance-$request->amount,
                    
    
                ]
            );
            } else {
                    
            $user->update(
                [
                    'live_balance' =>$user->live_balance-$request->amount,
                    
    
                ]
            );
            }
        
        }
        
        $deposit = transaction::create([
            'status' =>'pending',
            'user_id' => auth()->user()->id,
            'method' => $request->method,
            'type' => $request->type,

            'amount' => $request->amount,

            'address' => $request->address,


        ]);
        return response()->json([
            'message'=>'Your transection request done.Wait few moment for change  balance',
            'status' => $request->status,
            'user_id' => auth()->user()->id,
            'method' => $request->method,
            'type' => $request->type,

            'amount' => $request->amount,

            'address' => $request->address,
            'created_at' => now(),

        ]);
    }
    public function transaction(Request $request)
    {
        if (auth()->user()->role === '0') {
            $allTransaction=transaction::orderBy('id', 'desc')->get();
        $authTransaction = transaction::where('user_id',auth()->user()->id)->orderBy('id', 'desc')->get();
        return response()->json([
            'allTransaction'=>$allTransaction,
            'authTransaction'=>$authTransaction

        ]);
        }else {
            $allTransaction='';
            $authTransaction = transaction::where('user_id',auth()->user()->id)->orderBy('id', 'desc')->get();
        return response()->json([
            'allTransaction'=>$allTransaction,
            'authTransaction'=>$authTransaction

        ]);
        }
       
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
    public function user_edit(Request $request)
    {
        $user=User::find(auth()->user()->id);
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
        
        
        $name =rand(0000000,999999) .$file->getClientOriginalName();
        $file->move(public_path('img/profile'), $name);
        $path=asset('img/profile/');
       $url= $path.'/'.$name;
       
        }else{
            $url=$user->profile;
           

        }


        if ($request->password) {
            $request->validate([
                
                'password' => 'required|string|min:6|confirmed',
                
                
            ]);
    

            $password=Hash::make($request->password);
        }else {
            $password=$user->password;

        }


        $user->update(
            [
            
            'password' =>$password ,
            'profile'=>$url,
            
            'birth'=>$request->birth,
            'Phone'=>$request->phone,
            
            ]
        );
       
        return response()->json([
            'user'=>$user,
            'message'=>'User update done!'

        ]);
    }
   
}
