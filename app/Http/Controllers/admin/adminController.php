<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\payment;
use App\Models\transaction;
use App\Models\kyc;
use App\Models\contact;
use App\Models\work;
use PhpParser\Node\Stmt\Return_;


class adminController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function contact_us(Request $request)
    {
 
       
        $contact = contact::orderBy('id', 'desc')->get();
       
            
    
            return response()->json([
              
                'contact'=>$contact
               
            ]);
            
    }
    public function payment_method_create(Request $request)
    {
 
       
    
       
            if ($request->hasFile('qr')) {
                $file = $request->file('qr');
            
            
            $name =rand(0000000,999999) .$file->getClientOriginalName();
            $file->move(public_path('img/method'), $name);
            $path=asset('img/method/');
           $qrurl= $path.'/'.$name;
           
            }else{
                $qrurl='';
               
    
            }
            if ($request->hasFile('doc')) {
                $file = $request->file('doc');
            
            
            $name =rand(0000000,999999) .$file->getClientOriginalName();
            $file->move(public_path('img/method'), $name);
            $path=asset('img/method/');
           $docurl= $path.'/'.$name;
           
            }else{
                $docurl='';
               
    
            }
            $payment = payment::create([
               
                'user_id' => auth()->user()->id,
                'method' => $request->method,
                'qr' => $qrurl,
                'doc' => $docurl,
               
               
          
                'wallet_address' => $request->wallet_address,
                'bank_address' => $request->bank_address,
                'tag' => $request->tag,
             
                'holder' => $request->holder,
                'bank_name' => $request->bank_name,
                'ifsc' => $request->ifsc,
                
        
            ]);
            
    
            return response()->json([
                'status' => 'success',
                'message' => 'Method created successfully',
                'payment'=>$payment
               
            ]);
            
    }
    
   
    public function work_store(Request $request)
    {
       
   
       
        
        
          $user=User::find(auth()->user()->id); 
        $work = work::create([

         
            'user_id' => auth()->user()->id,
            'employ' => $request->employ,
            'industry' => $request->industry,
            'source_of_income' => $request->source_of_income,
            'est_annual_income' => $request->est_annual_income,
         
            'est_net_worth' => $request->est_net_worth,
            'ever_traded' => $request->ever_traded,
            'previous_work_exp' =>$request->previous_work_exp,
            'are_you_us_citizen' => $request->are_you_us_citizen,
           
         
            
        ]);
        $user->update(
            [

                'ec_kyc' => 'pending',


            ]
            );
        

        return response()->json([
            'status' => 'success',
            'economic'=>$work,
            'message' => 'economic created successfully',
           
        ]);
       
       
    }
  
    public function admin_deposit(Request $request)
    {
        $request->validate([

            'amount' => 'required',


        ]);



        $user = User::where('id',$request->id)->get()->first();




            if ($request->type == 'withdraw' || $request->type == 'Withdraw') {


                if ($request->address == 'wallet' || $request->address == 'Wallet') {
    
                    $user->update(
                        [
                            'main_balance' => $user->main_balance - $request->amount,
    
    
                        ]
                    );
                }
                
                
                if($request->address == 'live' || $request->address == 'Live') {
    
                    $user->update(
                        [
                            'live_balance' => $user->live_balance - $request->amount,
    
    
                        ]
                    );
                }
            }else{
    
                if ($request->address == 'wallet' || $request->address == 'Wallet') {
    
                    $user->update(
                        [
                            'main_balance' => $user->main_balance + $request->amount,
    
    
                        ]
                    );
                }
                
                
                if($request->address == 'live' || $request->address == 'Live') {
    
                    $user->update(
                        [
                            'live_balance' => $user->live_balance + $request->amount,
    
    
                        ]
                    );
                }
    
            }
    
            $transection = transaction::create([
                'status' => 'success',
                'user_id' => $request->id,
                'method' => $request->method,
                'type' => $request->type,
    
                'amount' => $request->amount,
    
                'address' => $request->address,
                'created_at' => now(),
    
    
            ]);
    
    
            return response()->json([
                'message' => 'Your transection done.',
                'status' => 'success',
                'user' => $user,
                'transection' => $transection,
                ]);


     


            
    }
    public function all_user()
    {
        $alluser= $users = User::where('email', '<>', 'developer@gmail.com')->get();
        return response()->json([
            'alluser'=>$alluser,

        ]);
    }
    
    public function user_details( Request $request)
    {
        $economic=work::where('user_id',$request->id)->get()->first();
        $kyc=kyc::where('user_id',$request->id)->get()->first();
        $payment=payment::where('user_id',$request->id)->get()->first();


        return response()->json([
            'economic'=>$economic,
            'kyc'=>$kyc,
            'payment'=>$payment,

        ]);
    }
    
    public function user_delete(Request $request)
    {
        $id=$request->id;
        $user=User::find($id)->get();
        $res = User::find($id)->delete();
     
        return response()->json([
            'user'=>$user,
            'message'=>'Delete done!',
          

        ]);
    }
    
  

    public function work_edit(Request $request)
    {
        
        
        $work = work::where('user_id',auth()->user()->id)->get()->first();
        // dd($user);
        
       
        
        
        
        $work->Update([

         
            'employ' => $request->employ,
            'industry' => $request->industry,
            'source_of_income' => $request->source_of_income,
            'est_annual_income' => $request->est_annual_income,
         
            'est_net_worth' => $request->est_net_worth,
            'ever_traded' => $request->ever_traded,
            'previous_work_exp' =>$request->previous_work_exp,
            'are_you_us_citizen' => $request->are_you_us_citizen,
           
         
            
        ]);
  
        

        return response()->json([
            'status' => 'success',
            'economic'=>$work,
            'message' => 'economic Update successfully',
           
        ]);
     
       
    }
    
    public function kyc_edit(Request $request)
    {
    
        
        $user = User::where('id',$request->id)->get()->first();
        // dd($user);

        $user->update(
            [
                $request->type => 'success',
                
               

            ]
        );
     
        return response()->json([
            'message'=>'KYC update done!',
            'user'=>$user

        ]);
    }
    
    public function payment_edit(Request $request)
    {
    
        
        $payment = payment::where('user_id',auth()->user()->id)->get()->first();

        // $paymentedit = payment::where('user_id',auth()->user()->id);
        // dd($user);
        
    
       
        if ($request->hasFile('qr')) {
            $file = $request->file('qr');
        
        
        $name =rand(0000000,999999) .$file->getClientOriginalName();
        $file->move(public_path('img/method'), $name);
        $path=asset('img/method/');
       $qrurl= $path.'/'.$name;
       
        }else{
            $qrurl= $payment->qr;
           

        }
        if ($request->hasFile('doc')) {
            $file = $request->file('doc');
        
        
        $name =rand(0000000,999999) .$file->getClientOriginalName();
        $file->move(public_path('img/method'), $name);
        $path=asset('img/method/');
       $docurl= $path.'/'.$name;
       
        }else{
            $docurl=$payment->doc;
           

        }
        $payment->update([
           
            'user_id' => auth()->user()->id,
            'method' => $request->method,
            'qr' => $qrurl,
            'doc' => $docurl,
           
           
      
            'wallet_address' => $request->wallet_address,
            'bank_address' => $request->bank_address,
            'tag' => $request->tag,
         
            'holder' => $request->holder,
            'bank_name' => $request->bank_name,
            'ifsc' => $request->ifsc,
            
    
        ]);
        

        return response()->json([
            'status' => 'success',
            'message' => 'Method Update successfully',
            'payment'=>$payment
           
        ]);
     
        return response()->json([
            'message'=>'Payment update done!',
            'payment'=>$payment

        ]);
    }
    public function transaction_edit(Request $request)
    {
        $id=$request->id;
        
        $transaction = transaction::find($id);
        $user=User::where('id',$transaction->user_id)->get()->first();
        if ($request->status=='success') {
           
            if ($transaction->type =='deposit') {
                if ($transaction->address == 'wallet' || $transaction->address == 'Wallet') {
                    $user->update(
                        [
                            'main_balance' =>$user->main_balance+$transaction->amount,
                            
            
                        ]
                    );
                } else {
                    $user->update(
                        [
                            'live_balance' =>$user->live_balance+$transaction->amount,
                            
            
                        ]
                    );
                }
                
                
            }
            
            $status= $transaction->update(
                [
                    'status' =>'success',
                    
    
                ]
            );
        }else{

            if ($transaction->type=='deposit') {

                $status= $transaction->update(
                    [
                        'status' =>'rejected',
                        
        
                    ]

                );
            } else {

                $status=$transaction->update(
                    [
                        'status' =>'rejected',
                        
        
                    ]
                );
                if ($transaction->address == 'wallet' || $transaction->address == 'Wallet') {
                    $user->update(
                        [
                            'main_balance' =>$user->main_balance + $transaction->amount,
                            
            
                        ]
                    );
                } else {
                    $user->update(
                        [
                            'live_balance' =>$user->live_balance + $transaction->amount,
                            
            
                        ]
                    );
                }
                
                
            }
            


        }
        // dd($user);
       
     
        return response()->json([
            'message'=>'Transaction update done!',
            'status'=>$status

        ]);
    }
    public function transfer(Request $request)
    {
   
        $user=User::where('id',$request->id)->get()->first();
        if ($request->address=='Wallet'||$request->address=='wallet') {
           
        
                    $user->update(
                        [
                            'main_balance' =>$user->main_balance-$request->amount,
                            'live_balance' =>$user->live_balance+$request->amount,
                            
            
                        ]
                    );
                
                
                
            }else {
                
                $user->update(
                    [
                        'main_balance' =>$user->main_balance+$request->amount,
                        'live_balance' =>$user->live_balance-$request->amount,
                        
        
                    ]
                );
            }
            
  
       
            return response()->json([
                'message'=>'Balance Transfer done!',
                'user'=>$user
    
            ]);
        }
    
       
     




    
    
}
