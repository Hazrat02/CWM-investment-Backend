<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\payment;
use App\Models\transaction;
use App\Models\ask;
use App\Models\vip;
use App\Models\vipunlock;
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
        $this->middleware('auth:api', ['except' => ['login', 'register','ask','vip']]);
    }
    public function payment_method_create(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'method' => 'required|string|max:255',
            'network' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            
           
        ]);
      
       
    
        if (auth()->user()->role === '0') {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
            
            
            $name =rand(0000000,999999) .$file->getClientOriginalName();
            $file->move(public_path('img/method'), $name);
            $path=asset('img/method/');
           $url= $path.'/'.$name;
           
            }else{
                $url='';
               
    
            }
            $payment = payment::create([
                'name' => $request->name,
                'method' => $request->method,
                'network' => $request->network,
                'address' => $request->method,
                'image' => $url,
               
                
            ]);
            
    
            return response()->json([
                'status' => 'success',
                'message' => 'Method created successfully',
                'payment'=>$payment
               
            ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry!You are not admin',
                   
                ]);
            }
    }
    public function vip_store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'task' => 'required|string|max:255',
            
           
        ]);
        if (auth()->user()->role === '0') {
           
        $vip = vip::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'task' => $request->task,
            'duration' => $request->duration,
           'icon'=>$request->icon,
            
        ]);
        

        return response()->json([
            'status' => 'success',
            'message' => 'Vip plan created successfully',
            'vip'=>$vip
           
        ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry!You are not admin',
                        ]);
        }
       
    }
    public function vipunlock_store(Request $request)
    {

        $request->validate([
            'vip_id' => 'required||max:255',
            'limit' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            
           
        ]);
        if (auth()->user()->role === '0') {
           
        $unlock = vipunlock::create([
            'vip_id' => $request->vip_id,
            'limit' => $request->limit,
            'type' => $request->type,
            
            
        ]);
        

        return response()->json([
            'status' => 'success',
            'message' => 'Vip Label created successfully',
            'label'=>$unlock
           
        ]);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Sorry!You are not admin',
               
            ]);
        }
       
    }
    public function work_store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'vip_id' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'earn' => 'required|string|max:255',
            
           
        ]);
        $vip_id = [
            ['name' => 'bal', 'id' => '1'],
            ['name' => 'bal', 'id' => '2'],
            ['name' => 'bal', 'id' => '3'],
        ];
        
       
        
        if (auth()->user()->role === '0') {
           
        $work = work::create([
            'name' => $request->name,
            'description' => $request->description,
            'vip_id' => $vip_id,
            'icon' => $request->icon,
            'earn' => $request->earn,
         
            
        ]);
        

        return response()->json([
            'status' => 'success',
            'work'=>$work,
            'message' => 'Work created successfully',
           
        ]);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Sorry!You are not admin',
               
            ]);
        }
       
    }
    public function ask_store(Request $request)
    {
       
        $request->validate([
            'ask' => 'required|string|max:255',
            'ans' => 'required|string|max:255',

            
           
        ]);
       
        if (auth()->user()->role === '0') {
           
        $ask = ask::create([
            'ask' => $request->ask,
            'ans' => $request->ans,
            
         
            
        ]);
        

        return response()->json([
            'status' => 'success',
            'ask'=>$ask,
            'message' => 'Ask created successfully',
           
        ]);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Sorry!You are not admin',
               
            ]);
        }
       
    }
    public function all_user()
    {
        $alluser=User::get();
        return response()->json([
            'alluser'=>$alluser,

        ]);
    }
    public function user_delete(Request $request)
    {
        $id=$request->id;
        $res = User::find($id)->delete();
     
        return response()->json([
            'message'=>'Delete done!',
          

        ]);
    }
    public function unlock_delete(Request $request)
    {
        $id=$request->id;
        $res = vipunlock::find($id)->delete();
     
        return response()->json([
            'message'=>'Vip label delete done!',
          

        ]);
    }
    public function vip_delete(Request $request)
    {
        $id=$request->id;
        $res = vip::find($id)->delete();
     
        return response()->json([
            'message'=>'Vip delete done!',
          

        ]);
    }
    public function payment_delete(Request $request)
    {
        $id=$request->id;
        $res = payment::find($id)->delete();
     
        return response()->json([
            'message'=>'Payment method delete done!',
          

        ]);
    }
    public function ask_delete(Request $request)
    {
        $id=$request->id;
        $res = ask::find($id)->delete();
     
        return response()->json([
            'message'=>'Ask delete done!',
          

        ]);
    }
    public function work_delete(Request $request)
    {
        $id=$request->id;
        $res = work::find($id)->delete();
     
        return response()->json([
            'message'=>'Work delete done!',
          

        ]);
    }
    
    public function vip_edit(Request $request)
    {
        $id=$request->id;
        
        $vip = vip::find($id);
        // dd($user);
        $vip->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'task' => $request->task,
                'duration' => $request->duration,
               'icon'=>$request->icon,

            ]
        );
     
        return response()->json([
            'message'=>'Vip update done!',
            'vip'=>$vip

        ]);
    }
    public function work_edit(Request $request)
    {
        $id=$request->id;
        
        $work = work::find($id);
        // dd($user);
        $work->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'earn' => $request->earn,
                'vip_id' => $request->vip_id,
                'component' => $request->component,
               'icon'=>$request->icon,

             

            ]
        );
     
        return response()->json([
            'message'=>'Work update done!',
            'work'=>$work

        ]);
    }
    
    public function ask_edit(Request $request)
    {
        $id=$request->id;
        
        $ask = ask::find($id);
        // dd($user);
        $ask->update(
            [
                'ask' => $request->ask,
                'ans' => $request->ans,
               

            ]
        );
     
        return response()->json([
            'message'=>'Ask update done!',
            'ask'=>$ask

        ]);
    }
    
    public function payment_edit(Request $request)
    {
        $id=$request->id;
        
        $payment = payment::find($id);
        // dd($user);
        $payment->update(
            [
                'name' => $request->name,
                'method' => $request->method,
                'network' => $request->network,
                'image' => $request->image,
                'address' => $request->address,
             

            ]
        );
     
        return response()->json([
            'message'=>'Payment update done!',
            'payment'=>$payment

        ]);
    }
    public function transaction_edit(Request $request)
    {
        $id=$request->id;
        
        $transaction = transaction::find($id);
        $user=User::find($transaction->user_id);
        if ($request->status=='success') {
           
            if ($transaction->type=='deposit') {
                $user->update(
                    [
                        'main_balance' =>$user->main_balance+$transaction->price,
                        
        
                    ]
                );
            }
            
            $transaction->update(
                [
                    'status' =>'success',
                    
    
                ]
            );
        }else{

            if ($transaction->type=='deposit') {
                $transaction->update(
                    [
                        'status' =>'rejected',
                        
        
                    ]

                );
            } else {

                $transaction->update(
                    [
                        'status' =>'rejected',
                        
        
                    ]
                );
                $user->update(
                    [
                        'main_balance' =>$user->main_balance+$transaction->price,
                        
        
                    ]
                );
            }
            


        }
        // dd($user);
       
     
        return response()->json([
            'message'=>'Transaction update done!',
            

        ]);
    }
    
    
}
