<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use App\models\lists;
use App\models\contactlist;
use App\models\autosendlist;
use App\models\autosend;
use App\models\senderid;
use App\models\pilot;
use App\models\adminRole;
use App\models\account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //


    public function index()
    {
        $pilots= DB::table('pilots')->get(); 
        $customers= DB::table('customers')->get(); 
        $orders= DB::table('orders')->get();
        //$id= DB::table('senderids')->get(); 
       // $conlist= DB::table('contactlist')->get(); 
        //$auto= DB::table('lists')
       // ->select('lists.id','lists.name','lists.userID','autosend.id','autosend.listID','autosend.created_at','autosend.sendtype')
       // ->join('autosend','autosend.listID','=','lists.id')
       // ->get();
        return view('admin.index',['pilots'=>$pilots,'customers'=>$customers,'orders'=>$orders]);

    }


    public function pilots()
    {
        $pilots= DB::table('pilots')->get(); 
        return view('admin.pilots',['pilots'=>$pilots]);

    }

    public static function pulluserdetail($id)
    {
       
       $users= DB::table('users')->where('id', $id)->first(); 
       return response()->json($users);
           
      
    }

    public static function pullaccountdetail($id)
    {
       
       $users= DB::table('users')->where('id', $id)->first(); 
       return response()->json($users);
           
      
    }

    public function postaccounts()
    {
        $validator=$this->validate(request(),[
            'name'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
            'cpassword'=>'required|string',
            'acctype'=>'required|string',
           
            ],
            [
            'name.required'=>'Please enter name ',
            'email.required'=>'Please enter email ',
            'password.required'=>'Please enter password ',
            'acctype.required'=>'Please choose account type ',
             ]);

             if(count(request()->all()) > 0){

               
                if(request()->input('cpassword')!=request()->input('password')){

                    return redirect()->back()->withErrors('Confirm password and password are not the same. Please ensure they are equal'); 
                }
                else{

                    $encodePass=$this->encrypt_decrypt(request()->input('password'), true);
                    $date=Carbon::now()->toDateString();
                    $account = new account();
                    $account->name=request()->input('name');
                    $account->email=request()->input('email');
                    $account->password= Hash::make(request()->input('password'));
                    $account->email_verified_at= $date;
                    $account->role='admin';
                    $account->adminroles=request()->input('acctype');
                    $account->two_factor_secret='';
                    $account->two_factor_recovery_codes='';
                    $account->remember_token='';
                    if($account->save()){


                        return redirect()->back()->withSuccess('new user uploaded succesfully');
    
                     }

                }

                
                
                 
                
            
            
            
            }

    }


    public static function encrypt_decrypt ($data, $encrypt) {
        if ($encrypt == true) {
            $output = base64_encode (convert_uuencode ($data));
        } else {
            $output = convert_uudecode (base64_decode ($data));
        }
        return $output;
        
        
        
    }


    public function  editaccounts()
 {

   if(empty(request()->input('password')) && empty(request()->input('cpassword'))){


    $validator=$this->validate(request(),[
        'name'=>'required|string',
        'email'=>'required|string',
        'acctype'=>'required|string',
        ],
        [
            'name.required'=>'Enter your name ',
            'email.required'=>'Enter your email',
            'acctype.required'=>'Enter role of this account',
              
            
            ]);

                $updateprofile=DB::table('users')->where('id',request()->input('user'))->update(['name' =>request()->input('name'),'email' =>request()->input('email'),'name' =>request()->input('name'),'adminroles' =>request()->input('acctype')]);
    
               return redirect()->back()->withSuccess('account Updated successfully');

            

    
     
   }
   
   if(!empty(request()->input('password'))&& empty(request()->input('cpassword'))){

    return redirect()->back()->withErrors('Please ensure you enter a confirm password');
   }
   
   if(request()->input('cpassword')!=request()->input('password')){

    return redirect()->back()->withErrors('Password is not the same as the confirm password');
   }

   if(!empty(request()->input('cpassword')) &&  !empty(request()->input('password'))){

    $validator=$this->validate(request(),[
        'name'=>'required|string',
        'email'=>'required|string',
        'acctype'=>'required|string',
        ],
        [
            'name.required'=>'Enter your name ',
            'email.required'=>'Enter your email',
            'acctype.required'=>'Enter role of this account',
              
            
            ]);

          

                $updateprofile=DB::table('users')->where('id',request()->input('user'))->update(['name' =>request()->input('name'),'email' =>request()->input('email'),'adminroles' =>request()->input('acctype'),'password' =>Hash::make(request()->input('password'))]);
    
               return redirect()->back()->withSuccess('account Updated successfully');

            
   }
 }

   

    public function allaccounts()
    {
        $allaccount= DB::table('users')->get(); 
        return view('admin.users',['users'=> $allaccount]);

    }
    public function deletepilot($id)
    {

        $resources = DB::delete('delete from pilots where id='.$id);
        return redirect()->back()->withSuccess('Pilot deleted successfully');

    }

    public function deleteaccount($id)
    {

        $resources = DB::delete('delete from users where id='.$id);
        return redirect()->back()->withSuccess('Account deleted successfully');

    }

    public function customers()
    {
        $allcustomers= DB::table('customers')->get(); 
        return view('admin.customers',['customers'=>$allcustomers]);

    }



    public function customerorders()
    {
        $allorders= DB::table('orders') 
        ->select('orders.fromLoc','orders.toLoc','orders.amount','orders.remark','orders.created_at','customers.fname','customers.lname','customers.phone','pilots.firstname','pilots.lastname','orders.id')
        ->join('customers','customers.id','=','orders.custid')
        ->join('pilots','pilots.id','=','orders.riderid')
        ->get();
        return view('admin.customerorders',['orders'=>$allorders]);

    }

    public function assignorders($id)
    {

        $xpilot= DB::table('orders')
        ->where('id',$id)
        ->first(); 

        $activepilots= DB::table('pilots')
        ->where('status',1)
        ->where('online_status',1)
        ->where('id','!=', $xpilot->riderid)
        ->get(); 

        $allorders= DB::table('orders') 
        ->select('orders.fromLoc','orders.toLoc','orders.amount','orders.remark','orders.created_at','customers.fname','customers.lname','customers.phone','customers.email','customers.picture','pilots.firstname','pilots.lastname','orders.id')
        ->join('customers','customers.id','=','orders.custid')
        ->join('pilots','pilots.id','=','orders.riderid')
        ->where('orders.id',$id)
        ->first();
        return view('admin.order-detail',['order'=>$allorders,'pilots'=>$activepilots]);

    }
    


    public function onlinestatus()
    {
        $pilots= DB::table('pilots')->get(); 
        $onlines= DB::table('pilots')->where('online_status',1)->get();
        $offlines= DB::table('pilots')->where('online_status',0)->get();
        return view('admin.online-status',['pilots'=>$pilots,'online'=>$onlines,'offline'=>$offlines]);

    }

    public function postassignorders(){

      

        if(isset($_POST['allpilots'])){

            if(is_array($_POST['allpilots'])){

   if(count($_POST['allpilots'])>1){
                return redirect()->back()->withErrors('Please choose only one pilot');
   }else{   

    foreach($_POST['allpilots'] as $value){

    DB::table('orders')->where('id', request()->input('orderid'))
    ->update([
        
        'riderid' =>$value,
       
]);
    }
return redirect()->back()->withSuccess('You have assigned a new pilot to this trip succesfully');  


   }

            }
        }else{

            return redirect()->back()->withErrors('You have not selected the pilot you want to re-assign to this trip ');
          	
            

        }

    }

    public function createnewpilot()
    {

        $validator=$this->validate(request(),[
                
          //  'file' => 'required|mimes:jpg,jpeg,png',
            'fname'=>'required|string',
            'lname'=>'required|string', 
            'email'=>'required|string', 
            'phone'=>'required|string', 
           
        ],[
            'fname.required'=>'Type in the pilots first name ',
            'lname.required'=>'Type in the pilots lastname ',
            'email.required'=>'Type in the pilots email ',
            'phone.required'=>'Type in the pilots phone ',
           // 'file.required'=>'Upload a picture with jpeg or png format',
               
            ]
         
         );

         if(count(request()->all()) > 0){


            if(empty(request()->file('file'))){



            
              
              $filePathdb = asset('/dist/images/img2.png');
              
             
              
            $pilot = new pilot();
            $pilot->firstname=request()->input('fname');
            $pilot->lastname=request()->input('lname');
            $pilot->picture=$filePathdb;
            $pilot->phone=request()->input('phone');
            $pilot->email=request()->input('email');
            $pilot->status=0;
            $pilot->pilotID=$this->random_number_with_dupe();
            $pilot->online_status=0;
            $pilot->verification_code=$this->confirmation_code();
            $pilot->verification_status=0;
            $pilot->save();

            $this->sendverificationcode($pilot->id);
    
           return redirect()->back()->withSuccess('New pilot added successfully');




            }else{

            $file=request()->file('file');
            $extension = $file->getClientOriginalExtension(); 
            $fileName = rand(11111, 99999) . '.' . $extension; 
         
          //////// move file to upload folder ////////////////
          
          $filePathdb = asset('/photos/'.$fileName);
          $filePath = 'photos';
          $file->move($filePath,$fileName);
          
        $pilot = new pilot();
        $pilot->firstname=request()->input('fname');
        $pilot->lastname=request()->input('lname');
        $pilot->picture=$filePathdb;
        $pilot->phone=request()->input('phone');
        $pilot->email=request()->input('email');
        $pilot->status=0;
        $pilot->pilotID=$this->random_number_with_dupe();
        $pilot->online_status=0;
        $pilot->verification_code=$this->confirmation_code();
        $pilot->verification_status=0;
        $pilot->save();

        $this->sendverificationcode($pilot->id);

       return redirect()->back()->withSuccess('New pilot added successfully');

            }

         }

    }


    function random_number_with_dupe($len = 6, $dup = 1, $sort = false) {
        if ($dup < 1) {
            throw new InvalidArgumentException('Second argument is < 1');
        }        
    
        $num = range(0,9);
        shuffle($num);
    
        $num = array_slice($num, 0, ($len-$dup)+1);
    
        if ($dup > 0) {
            $k = array_rand($num, 1);
            for ($i=0; $i<($dup-1); $i++) {
                $num[] = $num[$k];
            }
        }
    
        if ($sort) {
            sort($num);
        }
    
        return implode('', $num);
    }


    function confirmation_code($len = 4, $dup = 1, $sort = false) {
        if ($dup < 1) {
            throw new InvalidArgumentException('Second argument is < 1');
        }        
    
        $num = range(0,9);
        shuffle($num);
    
        $num = array_slice($num, 0, ($len-$dup)+1);
    
        if ($dup > 0) {
            $k = array_rand($num, 1);
            for ($i=0; $i<($dup-1); $i++) {
                $num[] = $num[$k];
            }
        }
    
        if ($sort) {
            sort($num);
        }
    
        return implode('', $num);
    }

    public function sendverificationcode($pilotid){ 

        $vericode= DB::table('pilots')->where('id',$pilotid)->first(); 
        $msg=urlencode($vericode->verification_code);
		 $url='https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=ZR3eJEIlCdsHh3mcchZy38OX20qNzlpyklN4ZfBTjbNgQZTRZ0yJiwzaOqX2&from=GETTROOPA&to='.urlencode($vericode->phone).'&body='.$msg.'&dnd=2';
         $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
        $response=curl_exec($ch);
       $info = curl_getinfo($ch);
		curl_close($ch); 
		
         return $info['http_code']; 		// Close CURL

        // Use file get contents when CURL is not installed on server.
       // if(!$output){
       //    $output =  file_get_contents($smsgatewaydata);  
       // }

    }



    public static function pullpilot($id)
    {
       
       $detail= DB::table('pilots')->where('id', $id)->first(); 
       return response()->json($detail);
           
      
    }



    public function performaction(Request $request){

        $validator=$this->validate(request(),[
            'task'=>'required|string',
            ],
            [
                'task.required'=>'Select an action you want to perform ',
               
                
                ]);

                if(count(request()->all()) > 0){
        switch ($request->input('task')) {
            case 'verify':

               
        
                      
                
    
                if(isset($_POST['allpilots'])){


                    if (is_array($_POST['allpilots'])) {
                        foreach($_POST['allpilots'] as $value){

                            DB::table('pilots')->where('id', $value)
                            ->update(['status' =>'1']);

                           
                            
                        }
   
                     return redirect()->back()->withSuccess('You have performed a verification action successfully');
                      
   
                     } 
                     else{

                        DB::table('pilots')->where('id', $_POST['allpilots'])
                        ->update(['status' =>'1']);

                        return redirect()->back()->withSuccess('You have performed a verification action successfully');
                   

                         }


                    
               }else{
    
    
                return redirect()->back()->withErrors('Please scroll down and check the pilots you want to perfom action on ');
               }
    
                       
            
    
                break;
    
            case 'restrict':
                
                if(isset($_POST['allpilots'])){

                    if(is_array($_POST['allpilots'])) {
                        foreach($_POST['allpilots'] as $value){

                            DB::table('pilots')->where('id', $value)
                            ->update(['status' =>'2']);

                        return redirect()->back()->withSuccess('Pilots have been restricted.');


                        }
                    }
                    else{

                        DB::table('pilots')->where('id', $_POST['allpilots'])
                            ->update(['status' =>'2']);

                        return redirect()->back()->withSuccess('A Pilot have been restricted.');

                    }

                   
                   
               }else{
    
    
                return redirect()->back()->withErrors('Please scroll down and check the pilots you want to perfom action on ');
           
               }
    
    
                break;

    
                case 'onhold':
                    
                    if(isset($_POST['allpilots'])){
    
                        if(is_array($_POST['allpilots'])) {
                            foreach($_POST['allpilots'] as $value){
    
                                DB::table('pilots')->where('id',$value)
                                ->update(['status' =>'3']);
    
                            return redirect()->back()->withSuccess('Pilots have been placed on hold.');
    
    
                            }
                        }
                        else{
    
                            DB::table('pilots')->where('id', $_POST['allpilots'])
                                ->update(['status' =>'3']);
    
                            return redirect()->back()->withSuccess('A Pilot have been restricted.');
    
                        }
    
                       
                       
                   }else{
        
        
                    return redirect()->back()->withErrors('Please scroll down and check the pilots you want to perfom action on ');
               
                   }
        
        
                    break;

    
                    case 'delete':
                        
                        if(isset($_POST['allpilots'])){
        
                            if(is_array($_POST['allpilots'])) {
                                foreach($_POST['allpilots'] as $value){

                                     ///// remove the existing file from folder /////////
   
                                           $existFile=""; 
   
                                           $info= DB::table('pilots')->where('id',$value)->first(); 
                                           $existFile.=$info->picture; 
                               
                        
   
     
                         if(file_exists(public_path('photos/'.basename($existFile)))){
     
                             unlink(public_path('photos/'.basename($existFile)));
                       
                           }
        
                                    DB::table('pilots')->where('id',$value)->delete();
        
                                return redirect()->back()->withSuccess('Pilots have been deleted.');
        
        
                                }
                            }
                            else{
        
                                 ///// remove the existing file from folder /////////
   
                                 $existFile=""; 
   
                                 $info= DB::table('pilots')->where('id',$_POST['allpilots'])->first(); 
                                 $existFile.=$info->picture; 
                     
              


               if(file_exists(public_path('photos/'.basename($existFile)))){

                   unlink(public_path('photos/'.basename($existFile)));
             
                 }

                          DB::table('pilots')->where('id',$_POST['allpilots'])->delete();

                      return redirect()->back()->withSuccess('Pilots have been deleted.');

        
                            }
        
                           
                           
                       }else{
            
            
                        return redirect()->back()->withErrors('Please scroll down and check the pilots you want to perfom action on ');
                   
                       }
            
            
                        break;
    
            
        }}
    }



    public function pilotdetail($id){

        $detail= DB::table('pilots')->where('id', $id)->first(); 

        $cancelledtrips= DB::table('cancelledorders') 
        ->select('cancelledorders.reason','orders.fromLoc','orders.toLoc','cancelledorders.created_at','cancelledorders.status')
        ->join('orders','orders.id','=','cancelledorders.orderid')
        ->where('cancelledorders.riderid',$id)->get();

        $alltrips= DB::table('trips') 
        ->select('trips.fromLoc','trips.toLoc','trips.status','trips.remark','trips.delivery_time','customers.fname','customers.lname','customers.picture','customers.phone')
        ->join('customers','customers.id','=','trips.custid')
        ->where('trips.riderid',$id)->get();

        $userpayments= DB::table('payments') 
        ->select('trips.fromLoc','trips.toLoc','pilots.firstname','pilots.lastname','customers.fname','customers.lname','customers.phone')
        ->join('customers','customers.id','=','payments.custid')
        ->join('pilots','pilots.id','=','payments.riderid')
        ->join('trips','trips.id','=','payments.tripid')
        ->where('payments.riderid',$id)->get();

        $cancelorders= DB::table('cancelledOrders')->where('riderid', $id)->get(); 

        return view('admin.pilot-detail',['pilot'=>$detail,'trips'=>$alltrips,'payments'=>$userpayments,'allcancelled'=>$cancelledtrips]);
    
    }



    public function customerdetail($id){

        $detail= DB::table('customers')->where('id', $id)->first(); 

     
        $userpayments= DB::table('payments') 
        ->select('payments.amount','trips.toLoc','trips.fromLoc','trips.delivery_time','payments.created_at','payments.riderid')
        ->join('trips','trips.id','=','payments.tripid')
        ->where('payments.custid',$id)->get();

       

        return view('admin.customer-detail',['customer'=>$detail,'payments'=>$userpayments]);
    
    }





    public function editpilot(){

        //1.validate data
           
        $validator=$this->validate(request(),[
           'fname'=>'required|string',
           'lname'=>'required|string',
           'email'=>'required|string',
           'phone'=>'required|string',
          
          
           ]);
   
               if(count(request()->all()) > 0){
   
                  
   
   
                   if(empty(request()->file('file'))){
   
                    
                         
                DB::table('pilots')
                ->where('id',request()->input('user'))
                ->update(['firstname' => request()->input('fname'),'lastname'=>request()->input('lname'),'email' => request()->input('email'), 'phone' => request()->input('phone')]);
               
                    
                   
                       return redirect()->back()->withSuccess('Update succesful.');
                   
                   }
                   else{ 
   
   
   
   
   
                         ///// remove the existing file from folder /////////
   
                         $existFile=""; 
   
                         $info= DB::table('pilots')->where('id',request()->input('user'))->first(); 
                         $existFile.=$info->picture; 
                               
                        
                          
     
                         if(file_exists(public_path('photos/'.basename($existFile)))){
     
                             unlink(public_path('photos/'.basename($existFile)));
                       
                           }
                        
                       
                         //////// move file to upload folder ////////////////
                  
                 $file=request()->file('file');
                 $extension = $file->getClientOriginalExtension(); 
                 $fileName = rand(11111, 99999) . '.' . $extension; 
              
               //////// move file to upload folder ////////////////
               
               $filePathdb = asset('/photos/'.$fileName);
               $filePath = 'photos';
               $file->move($filePath,$fileName);
        
                     
     
                 //////////////// update database with new information ///////
     
                 DB::table('pilots')
                 ->where('id',request()->input('user'))
                 ->update(['firstname' => request()->input('fname'),'lastname'=>request()->input('lname'),'picture' =>$filePathdb,'email' => request()->input('email'), 'phone' => request()->input('phone')]);
                
                          
     
                return redirect()->back()->withSuccess('Update succesful.');
                       
                  
               
                   }}
   
   }








    public function list()
    {
        $list= DB::table('lists')->get(); 
        return view('admin.list',['lists'=>$list]);

    }



    public function senderid()
    {
        $idxx= DB::table('senderids')->get(); 
        return view('admin.senderid',['ids'=>$idxx]);

    }

    public static function showusername($id)
    {
        $count=0;
        $list= DB::table('users')->where('id', $id)->first(); 
       
        return  ucwords($list->name);
    }

    public function sentMessages()
    {

       // $list= DB::table('lists')
       // ->where('id', $id)
       // ->first(); 

        $message= DB::table('sendmsg')
       ->orderBy('created_at','desc')
       ->paginate(10); 
       return view('admin.sent_messages',['smss'=>$message]);


    }




    public function userlist(){

        $user= DB::table('users')->get(); 
        return view('admin.userlist',['users'=>$user]);

    }

    public function smsdetail($id)
    {
        $smsdetail= DB::table('sendmsg')->where('id',$id)->first(); 
        return view('admin.smsdetail',['smsx'=>$smsdetail]);

    }


    public function listDetail($id,$type)
    {
       $month=Carbon::now()->format('M');
       $day=Carbon::now()->format('d');
       $tomorrow=Carbon::now()->addHours(24)->format('d');

        $list= DB::table('lists')
        ->where('id', $id)
        ->first(); 

         $contactlist= DB::table('contactlist')
         ->where('listID', $id)
         ->get(); 

         $anniversary= DB::table('anniversary')
         ->where('listID', $id)
         ->get(); 

         $anniversarylist= DB::table('anniversarylist')
         ->where('listID', $id)
         ->get(); 

         $todayBirth= DB::table('contactlist')
         ->where('listID',$id)
         ->where('birthMonth',$month)
         ->where('birthDay',$day)
         ->get();

         $tomorrowBirth= DB::table('contactlist')
         ->where('listID',$id)
         ->where('birthMonth',$month)
         ->where('birthDay',$tomorrow)
         ->get();

         
         if($type=='birthday'){

            return view('admin.listDetail',['lists'=>$list,'birthcount'=>$todayBirth,'tomorrowbirthcount'=>$tomorrowBirth],['contactlists'=>$contactlist]);
          
        }else{
    
            return view('admin.otherAnniversary',['lists'=>$list,'anniversaries'=>$anniversary],['contactlists'=>$anniversarylist]);
         
    
    
    
          }
    }

    public static function listAnniversary($id)
 {
    
    $anns= DB::table('anniversary')->where('listID', $id)->get(); 
    return $anns;
        
   
 }

 public function anniversaryexc($list,$ann,$annid){

    $month=Carbon::now()->format('M');
    $day=Carbon::now()->format('d');
    $tomorrow=Carbon::now()->addHours(24)->format('d');

    $listsx= DB::table('lists')
     ->where('id', $list)
     ->first();
     
     $todayAnn= DB::table('anniversarylist')
     ->where('listID',$list)
     ->where('annmonth',$month)
     ->where('annday',$day)
     ->get();

     $tomorrowAnn= DB::table('anniversarylist')
     ->where('listID',$list)
     ->where('annmonth',$month)
     ->where('annday',$tomorrow)
     ->get();

     $monthAnn= DB::table('anniversarylist')
     ->where('listID',$list)
     ->get();

     return view('admin.anniversaryEx',['lists'=>$listsx,'todayanniversary'=>$todayAnn],['tomorrowanniversary'=>$tomorrowAnn,'monthanniversary'=>$monthAnn,'anns'=>$ann,'annids'=>$annid]);
 
}



public function todayannivlist($listID,$ann,$annid)
{

   $month=Carbon::now()->format('M');
   $day=Carbon::now()->format('d');
  

    $list= DB::table('lists')
    ->where('id', $listID)
    ->first(); 

    $annlist=  DB::table('anniversarylist')
    ->where('anniversary', $ann)
    ->where('annmonth', $month)
    ->where('annday', $day)
    ->where('listID', $listID)
    ->get();
     
  
     return view('admin.todayAnniversary',['lists'=>$list,'contactlists'=>$annlist,'anns'=>$ann,'annids'=>$annid]);

}

public function anniversaryByMonth($id,$ann,$annid)
{

    $list= DB::table('lists')
    ->where('id', $id)
    ->first(); 

     $contactlist= DB::table('anniversarylist')
     ->where('listID', $id)
     ->where('anniversary',$ann)
     ->get(); 

   return view('admin.anniversaryByMonths',['lists'=>$list,'anns'=>$ann,'annids'=>$annid],['contactlists'=>$contactlist]);


}

public function annmonthExtract($month,$listID,$ann,$annid)
    {

        $list= DB::table('lists')
        ->where('id', $listID)
       ->first(); 

       $contactlist= DB::table('anniversarylist')
       ->where('annmonth', $month)
       ->where('listID', $listID)
       ->where('anniversary', $ann)
        ->get(); 

      
      return view('admin.annextractMonth',['lists'=>$list,'month'=>$month,'anns'=>$ann,'annids'=>$annid],['contactlists'=>$contactlist]);


    }


public static function pullsenderid()
    {
          
        $senderids= DB::table('senderids')
        ->where('userID',auth()->user()->id)
        ->where('status',2)
        ->get();
         return $senderids;
        

    }

public static function annpermonth($listID,$month,$ann)
{

    $listrows= DB::table('anniversarylist')
    ->where('listID', $listID)
    ->where('annmonth', $month)
    ->where('anniversary',$ann)
    ->get(); 

    
    return $listrows;


}

public static function fullmonth($month)
{
    $fullmonth="";
    if($month=='Jan'){

    $fullmonth="January";

    }

    if($month=='Feb'){

        $fullmonth="February";

        }


    if($month=='Mar'){

            $fullmonth="March";
    
            }

    if($month=='Apr'){

                $fullmonth="April";
        
                }

    if($month=='May'){

                    $fullmonth="May";
            
                    }

    if($month=='Jun'){

                        $fullmonth=="June";
                
                        }

     if($month=='Jul'){

                            $fullmonth="July";
                    
                            }

    if($month=='Aug'){

                                $fullmonth="August";
                        
                                }

    if($month=='Sep'){

                                    $fullmonth="September";
                            
                                    }

    if($month=='Oct'){

                                        $fullmonth="October";
                                
                                        }

    if($month=='Nov'){

                                            $fullmonth="November";
                                    
                                            }

    if($month=='Dec'){

                                                $fullmonth="December";
                                        
                                                }

    
    return $fullmonth;


}




public static function autostatus($id)
{
    $output="";
    $listrows= DB::table('autosend')
    ->where('listID', $id)
    ->first();

    if(isset($listrows)){
   

    $output.=1;

   
}
else{

    $output.="";  
}
    return $output;

}



public function tomorrowannivlist($listID,$ann,$annid)
    {

       $month=Carbon::now()->format('M');
       $tomorrow=Carbon::now()->addHours(24)->format('d');
      

        $list= DB::table('lists')
        ->where('id', $listID)
        ->first(); 

        $annlist=  DB::table('anniversarylist')
        ->where('anniversary', $ann)
        ->where('annmonth', $month)
        ->where('annday', $tomorrow)
        ->where('listID', $listID)
        ->get();
         
      
         return view('admin.tomorrowAnniversary',['lists'=>$list,'contactlists'=>$annlist,'anns'=>$ann,'annids'=>$annid]);

    }

 public static function anniversaryCount($anniversary,$list)
 {

     $rows= DB::table('anniversarylist')
     ->where('anniversary', $anniversary)
     ->where('listID', $list)
     ->get(); 

     
     return $rows->count();


 }


    public function multiplecontact($id)
{
    
$input =request()->all();  
$condition = $input['firstname'];
foreach ($condition as $key => $condition) {
    $contactlist = new contactlist();
                            $contactlist->firstName=$input['firstname'][$key];
                            $contactlist->lastName=$input['lastname'][$key];
                            $contactlist->birthMonth=$input['birthmonth'][$key];
                            $contactlist->birthDay=$input['birthday'][$key];
                            $contactlist->phone=$input['phone'][$key];
                            $contactlist->remarks=$input['remark'][$key];
                            $contactlist->listID=$id;
                            $contactlist->save();

    }


    return redirect()->back()->withSuccess('Contacts added succesfully.');
        
   
}

    public function todayBirthday($id)
    {
        $month=Carbon::now()->format('M');
       $day=Carbon::now()->format('d');
       $tomorrow=Carbon::now()->addHours(24)->format('d');

        $list= DB::table('lists')
        ->where('id', $id)
        ->first(); 

         $contactlist= DB::table('contactlist')
         ->where('listID', $id)
         ->where('birthMonth', $month)
         ->where('birthDay', $day)
         ->get();

         
      return view('admin.todayBirthday',['lists'=>$list],['contactlists'=>$contactlist]);

    }

    public function tomorrowBirthday($id)
    {

        $month=Carbon::now()->format('M');
        $tomorrow=Carbon::now()->addHours(24)->format('d');

        $list= DB::table('lists')
        ->where('id', $id)
        ->first(); 

         $contactlist=  DB::table('contactlist')
         ->where('listID', $id)
         ->where('birthMonth', $month)
         ->where('birthDay', $tomorrow)
         ->get();

        return view('admin.tomorrowBirthday',['lists'=>$list],['contactlists'=>$contactlist]);

    }


    public function autosendtype(Request $request)
{

if($request->input('autotype')=="1"){

    $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
    return view('admin.scheduler',['lists'=>$list]);

}
if($request->input('autotype')=="2"){
    $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
    
    return view('admin.multiplemessage',['lists'=>$list]);
}
        
   
}

    public function scheduleList()
    {
        $list= DB::table('lists')
        ->select('lists.id','lists.name','lists.userID','autosend.id','autosend.listID','autosend.created_at','autosend.sendtype')
        ->join('autosend','autosend.listID','=','lists.id')
        ->get();
        return view('admin.autoscheduleList',['lists'=>$list]);

    }

    public function multipleupdate($id)
    {
          
        $senderid= DB::table('autosend')->where('listID',AdminController::getListIdFromAutosend($id))->first();
         $lists= DB::table('autosend_list')->where('listID',AdminController::getListIdFromAutosend($id))->get(); 
        // $contactlist= DB::table('contactlist')->where('listID',UserController::getListIdFromAutosend($id))->get(); 
            
         return view('admin.updateschedulemultiple',['lists'=>$lists,'sender'=>$senderid]);
        

        

    }

    public function createList()
    {

        $lists = new lists();
        $lists->name=request()->input('title');
        $lists->type=request()->input('type');
        $lists->userID=auth()->user()->id;
        $lists->save();
        return redirect()->back()->withSuccess('New list created successfully');

    }

       public function listcontacts($id,$type)
    {
        $list= DB::table('lists')->where('id', $id)->first(); 
        

        if($type=='birthday'){
            $contactlist= DB::table('contactlist')->where('listID', $id)->get();
           
            return view('admin.list_contacts',['lists'=>$list],['contactlists'=>$contactlist]);
        }
        else if($type=='other'){

            $contactlist= DB::table('anniversarylist')->where('listID', $id)->get();
            return view('admin.list_contacts_other',['lists'=>$list],['contactlists'=>$contactlist]);
      
        }
       
    }

    public function autosms(Request $request){
        switch ($request->input('action')) {
            case 'activate':

                $validator=$this->validate(request(),[
                    'senderid'=>'required|string',
                    'message'=>'required|string',
                    'time'=>'required|string',
                    ],
                    [
                        'senderid.required'=>'.Please type in name you  want celebrants to see as the sender ',
                        'message.required'=>'.Please enter message you want to send',
                        'time.required'=>'.Please choose the time you want the message to be sent',
                          
                        
                        ]);
        
                        if(count(request()->all()) > 0){
                
    
                if(isset($_POST['listid'])){


                    if (is_array($_POST['listid'])) {
                        foreach($_POST['listid'] as $value){

                        $autosend = new autosend();
                        $autosend->userID=auth()->user()->id;
                        $autosend->listID=$value;
                        $autosend->senderID=request()->input('senderid');
                        $autosend->message=request()->input('message');
                        $autosend->sendtime=request()->input('time');
                        $autosend->sendtype='single';
                            if($autosend->save()){



                                $list= DB::table('contactlist')
                                ->where('listID', $value)
                                ->get(); 

                             foreach($list as $row){

                            $autosendlist = new autosendlist();
                            $autosendlist->userID=auth()->user()->id;
                            $autosendlist->listID=$value;
                            $autosendlist->senderID=request()->input('senderid');
                            $autosendlist->msg=request()->input('message');
                            $autosendlist->reciever=$row->phone;
                            $autosendlist->reciever_name=ucwords($row->firstName).' '.ucwords($row->lastName);
                            $autosendlist->birthDay=$row->birthDay;
                            $autosendlist->birthMonth=$row->birthMonth;
                            $autosendlist->send_time=request()->input('time');
                            $autosendlist->save();
                            
                        
                        }

                        return redirect()->back()->withSuccess('Auto send SMS has been activated for list successfuly.');
                           
                        }
                        }
   
                       
   
                     } else {

                        $autosend = new autosend();
                        $autosend->userID=auth()->user()->id;
                        $autosend->listID=$value;
                        $autosend->senderID=request()->input('senderid');
                        $autosend->message=request()->input('message');
                        $autosend->sendtime=request()->input('time');
                        $autosend->sendtype='single';
                        if($autosend->save()){



                            $list= DB::table('contactlist')
                            ->where('listID', $value)
                            ->get(); 

                         foreach($list as $row){

                        $autosendlist = new autosendlist();
                        $autosendlist->userID=auth()->user()->id;
                        $autosendlist->listID=$value;
                        $autosendlist->senderID=request()->input('senderid');
                        $autosendlist->msg=request()->input('message');
                        $autosendlist->reciever=$row->phone;
                        $autosendlist->reciever_name=ucwords($row->firstName);
                        $autosendlist->birthDay=$row->birthDay;
                        $autosendlist->birthMonth=$row->birthMonth;
                        $autosendlist->send_time=request()->input('time');
                        $autosendlist->save();
                        
                    
                    }

                    return redirect()->back()->withSuccess('Auto send SMS has been activated for list successfuly.');
                       
                    }  }


                    
               }else{
    
    
                return redirect()->back()->withErrors('Please scroll down and check the list you want to automate ')->withInput();
               }
    
                       
            }
    
                break;
    
            case 'deactivate':
                
                if(isset($_POST['listid'])){

                    if(is_array($_POST['listid'])) {
                        foreach($_POST['listid'] as $value){

                        DB::table('autosend_list')->where('listID',$value)->delete();
                        DB::table('autosend')->where('listID',$value)->delete();

                        return redirect()->back()->withSuccess('list deactivated succesfuly.');


                        }
                    }else{

                        DB::table('autosend_list')->where('listID',$value)->delete();
                        DB::table('autosend')->where('listID',$value)->delete();
                        return redirect()->back()->withSuccess('list deactivated succesfuly.');

                    }

                   
                   
               }else{
    
    
               return redirect()->back()->withErrors('Please scroll down and check the list you want to deactivate ')->withInput();
             
               }
    
    
                break;
    
            
        }
    }




    public function celebByMonth($id)
    {

        $list= DB::table('lists')
        ->where('id', $id)
        ->first(); 

         $contactlist= DB::table('contactlist')
         ->where('listID', $id)
         ->get(); 
        return view('admin.celebrantsByMonths',['lists'=>$list],['contactlists'=>$contactlist]);


    }

    public function monthExtract($month,$listID)
    {

        $list= DB::table('lists')
        ->where('id', $listID)
       ->first(); 

       $contactlist= DB::table('contactlist')
       ->where('birthMonth', $month)
       ->where('listID', $listID)
        ->get(); 

      
      return view('admin.extractMonth',['lists'=>$list,'months'=>$month],['contactlists'=>$contactlist]);


    }

    public function smsallcontact($id,$type)
    {
        $list= DB::table('lists')->where('id', $id)->first(); 
        if($type=='other'){

            $contactlistx= DB::table('anniversarylist')->where('listID',$id)->get(); 
            return view('admin.smsallcontactsother',['lists'=>$list,'contactlists'=> $contactlistx]);
        }

        if($type=='birthday'){
            $contactlistx= DB::table('contactlist')->where('listID',$id)->get(); 
            return view('admin.smsallcontacts',['lists'=>$list,'contactlists'=> $contactlistx]);

        }
        
       
       

    }


    public function multipleprocessmsg($id){



        $input =request()->all();  
        $condition = $input['contactid'];
        foreach ($condition as $key => $condition) {
           
            $autosendlist = new autosendlist();
            $autosendlist->userID=auth()->user()->id;
            $autosendlist->listID=$id;
            $autosendlist->senderID=$input['senderid'];
            $autosendlist->msg=$input['msg'][$key];
            $autosendlist->reciever=$input['phone'][$key];
            $autosendlist->reciever_name=ucwords($input['firstname'][$key]).' '.ucwords($input['lastname'][$key]);
            $autosendlist->birthDay=$input['birthday'][$key];
            $autosendlist->birthMonth=$input['birthmonth'][$key];
            $autosendlist->send_time=$input['sendtime'][$key];
            $autosendlist->save();

        
            }

            $autosend = new autosend();
            $autosend->userID=auth()->user()->id;
            $autosend->listID=$id;
            $autosend->senderID=$input['senderid'];
            $autosend->message="multiple";
            $autosend->sendtime=$input['sendtime'][$key];
            $autosend->sendtype='multiple';
            $autosend->save();
        
           
            return redirect('admin/done_list/'.$id);

    }

    public static function getListIdFromAutosend($id)
    {
        $list= DB::table('autosend')->where('id',$id)->first(); 
        return $list->listID;

    }

    public function singleupdate($id)
    {
          

         $list= DB::table('autosend')->where('id',$id)->first(); 
         $contactlist= DB::table('contactlist')->where('listID',AdminController::getListIdFromAutosend($id))->get(); 
            
       return view('admin.updateschedule',['list'=>$list,'contactlist'=>$contactlist]);
        

        

    }


    public function todaytask()
    {
        $month=Carbon::now()->format('M');
       $day=Carbon::now()->format('d');
      

         $contactlist= DB::table('contactlist')
         ->where('birthMonth', $month)
         ->where('birthDay', $day)
         ->get();

         
      return view('admin.todaytask',['contactlists'=>$contactlist]);

    }

    public static function pulllistdetail($id)
 {
    
    $list= DB::table('lists')->where('id', $id)->first(); 
    return  $list->name;
        
   
 }

 public static function pulllistauthor($id)
 {
    
    $list= DB::table('lists')->where('id', $id)->first(); 
    $users= DB::table('users')->where('id', $list->userID)->first();
    return  $users->name;
        
   
 }


    

    public function scheduleupdate($id,$id2)
    {
            if($id2=='single'){

             $list= DB::table('autosend')->where('id',$id)->first(); 
            $contactlist= DB::table('contactlist')->where('listID',AdminController::getListIdFromAutosend($id))->get(); 
            return redirect('admin/singleupdate/'.$id);
        
        
        } 
        if($id2=='multiple'){

            $list= DB::table('autosend_list')->where('listID',AdminController::getListIdFromAutosend($id))->get(); 
           
           return redirect('admin/multipleupdate/'.$id);

        }

    }

    
    public function scheduleupdate2($id)
    {
        $validator=$this->validate(request(),[
            'senderid'=>'required|string',
            'message'=>'required|string',
            'time'=>'required|string',
            ],
            [
                'senderid.required'=>'.Please type in name you  want celebrants to see as the sender ',
                'message.required'=>'.Please enter message you want to send',
                'time.required'=>'.Please choose the time you want the message to be sent',
                  
                
                ]);
                if(count(request()->all()) > 0){

                DB::table('autosend')->where('id', $id)->update([
                    
                    'senderID' => request()->input('senderid'),
                    'message' => request()->input('message'),
                    'sendtime' => request()->input('time')
                
                
                ]);

                $auto=DB::table('autosend')->where('id',$id)->first(); 

                DB::table('autosend_list')->where('listID', $auto->listID)->update([
                    
                    'senderID' => request()->input('senderid'),
                    'msg' => request()->input('message'),
                    'send_time' => request()->input('time')
                ]);

                return redirect()->back()->withSuccess('Update sucessful.');
          
                }
          

    }

    public function multipleupdateinfo(){

        $input =request()->all();  
        $condition = $input['contact'];
        foreach ($condition as $key => $condition) {

            DB::table('autosend_list')->where('id', $input['contact'][$key])
            ->update(['msg' =>$input['msg'][$key], 'send_time' =>$input['sendtime'][$key]]);
        }

        return redirect()->back()->withSuccess('Infomation updated succesfully.');

    }

    



    public function donelist($id)
    {
        
        return view('admin.donelist',['list'=>$id]);

    }

    public function processsenderid(){

       
        if(count(request()->all()) > 0){
       

        if(isset($_POST['ids'])){

            if (is_array($_POST['ids'])) {

            foreach($_POST['ids'] as $value){
                DB::table('senderids')->where('id', $value)
                ->update(['status' =>request()->input('status')]);
        }

        return redirect()->back()->withSuccess('sender ID updated successfuly.');
                      

    }else{

        DB::table('senderids')->where('id', $value)
        ->update(['status' =>request()->input('status')]);

        return redirect()->back()->withSuccess('sender ID updated successfuly.');
                      

    }     

           


            
       }else{


        return redirect()->back()->withErrors('Please scroll down and check atleast one sender ID to process ')->withInput();
       }

    }
}



public function insertname($name){

    $senderid = new senderid();
    $senderid->userID=auth()->user()->id;
    $senderid->status=0;
    $senderid->name=$name;
    if($senderid->save()){

        echo"good";
    }


}

}
