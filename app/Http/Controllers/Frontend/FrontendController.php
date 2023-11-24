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
use App\Models\kyc;
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
        $this->middleware('auth:api', ['except' => ['login', 'register', 'ask', 'vip']]);
    }
    public function payment_method()
    {
        $payment = payment::where('user_id',auth()->user()->id);
        $paymentarray = payment::where('user_id',auth()->user()->id)->get()->first();
        if ($payment->count() > '0') {
            return response()->json([

                'payment' => $paymentarray,
    
            ]);
        } else {
            return response()->json([

                'payment' => '',
    
            ]);
        }
        
      
    }
    public function deposit(Request $request)
    {
        $request->validate([

            'amount' => 'required',


        ]);

        $user = User::find(auth()->user()->id);
        if ($request->type == 'withdraw' || $request->type == 'Withdraw') {


            if ($request->address == 'wallet' || $request->address == 'Wallet') {

                $user->update(
                    [
                        'main_balance' => $user->main_balance - $request->amount,


                    ]
                );
            } else {

                $user->update(
                    [
                        'live_balance' => $user->live_balance - $request->amount,


                    ]
                );
            }
        }

        $deposit = transaction::create([
            'status' => 'pending',
            'user_id' => auth()->user()->id,
            'method' => $request->method,
            'type' => $request->type,

            'amount' => $request->amount,

            'address' => $request->address,


        ]);
        return response()->json([
            'message' => 'Your transection request done.Wait few moment for change  balance',
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
            $allTransaction = transaction::orderBy('id', 'desc')->get();
            $authTransaction = transaction::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
            return response()->json([
                'allTransaction' => $allTransaction,
                'authTransaction' => $authTransaction

            ]);
        } else {
            $allTransaction = '';
            $authTransaction = transaction::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
            return response()->json([
                'allTransaction' => $allTransaction,
                'authTransaction' => $authTransaction

            ]);
        }
    }

    public function vip(Request $request)
    {
        $vip = vip::with('vipunlock')->get();

        return response()->json([
            'vip' => $vip,

        ]);
    }



    public function ask()
    {
        $ask = ask::orderBy('id', 'desc')->get();

        return response()->json([
            'ask' => $ask,

        ]);
    }
    public function user_edit(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');


            $name = rand(0000000, 999999) . $file->getClientOriginalName();
            $file->move(public_path('img/profile'), $name);
            $path = asset('img/profile/');
            $url = $path . '/' . $name;
        } else {
            $url = $user->profile;
        }


        if ($request->password) {
            $request->validate([

                'password' => 'required|string|min:6|confirmed',


            ]);


            $password = Hash::make($request->password);
        } else {
            $password = $user->password;
        }


        $user->update(
            [

                'password' => $password,
                'profile' => $url,

                'birth' => $request->birth,
                'Phone' => $request->phone,

            ]
        );

        return response()->json([
            'user' => $user,
            'message' => 'User update done!'

        ]);
    }
    public function kyc(Request $request)
    {










        if ($request->hasFile('front')) {
            $file = $request->file('front');


            $name = rand(0000000, 999999) . $file->getClientOriginalName();
            $file->move(public_path('img/kyc'), $name);
            $path = asset('img/kyc/');
            $font_url = $path . '/' . $name;
        } else {
            $font_url = '';
        }
        if ($request->hasFile('back')) {
            $file = $request->file('back');


            $name = rand(0000000, 999999) . $file->getClientOriginalName();
            $file->move(public_path('img/kyc'), $name);
            $path = asset('img/kyc/');
            $back_url = $path . '/' . $name;
        } else {
            $back_url = '';
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');


            $name = rand(0000000, 999999) . $file->getClientOriginalName();
            $file->move(public_path('img/kyc'), $name);
            $path = asset('img/kyc/');
            $file_url = $path . '/' . $name;
        } else {
            $file_url = '';
        }

        $existUser = User::find(auth()->user()->id);

        $existkyc = kyc::where('user_id', auth()->user()->id);






        if ($existkyc->count() > 0) {

            if ($request->type == 'id') {


                $user= $existkyc->update([
                    'user_id' => auth()->user()->id,
                    'id_front' => $font_url,
                    'id_back' => $back_url,
                    'id_file' => $file_url,

                ]);

                $existUser->update(
                    [

                        'id_kyc' => 'pending',


                    ]
                );
            }
            if ($request->type == 'address') {


               $user= $existkyc->update([
                    'user_id' => auth()->user()->id,
                    'ad_front' => $font_url,
                    'ad_back' => $back_url,
                    'ad_file' => $file_url,
                    'country' => $request->country,
                    'city' => $request->city,
                    'address' => $request->address,
                    'postel' => $request->postel,

                ]);
                $existUser->update(
                    [

                        'ad_kyc' => 'pending',


                    ]
                );
            }
            if ($request->type == 'selfie') {


                $user= $existkyc->update([
                    'user_id' => auth()->user()->id,

                    'se_file' => $file_url,

                ]);

                $existUser->update(
                    [

                        'id_kyc' => 'pending',


                    ]
                );
            }
            if ($request->type == 'other') {


                $user= $existkyc->update([
                    'user_id' => auth()->user()->id,

                    'ot_file' => $file_url,

                ]);
                $existUser->update(
                    [

                        'id_kyc' => 'pending',


                    ]
                );
            }
        } else {
            
        if ($request->type == 'id') {


            $user = kyc::create([
                'user_id' => auth()->user()->id,
                'id_front' => $font_url,
                'id_back' => $back_url,
                'id_file' => $file_url,

            ]);

            $existUser->update(
                [

                    'id_kyc' => 'pending',


                ]
            );
        }
        if ($request->type == 'address') {


            $user = kyc::create([
                'user_id' => auth()->user()->id,
                'ad_front' => $font_url,
                'ad_back' => $back_url,
                'ad_file' => $file_url,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'postel' => $request->postel,

            ]);
            $existUser->update(
                [

                    'ad_kyc' => 'pending',


                ]
            );
        }
        if ($request->type == 'selfie') {


            $user = kyc::create([
                'user_id' => auth()->user()->id,

                'se_file' => $file_url,

            ]);

            $existUser->update(
                [

                    'id_kyc' => 'pending',


                ]
            );
        }
        if ($request->type == 'other') {


            $user = kyc::create([
                'user_id' => auth()->user()->id,

                'ot_file' => $file_url,

            ]);
            $existUser->update(
                [

                    'id_kyc' => 'pending',


                ]
            );
        }

        }








        return response()->json([
            'user' => $user,
            'message' => 'kyc Submited!'

        ]);
    }
}
