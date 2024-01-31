<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\models\lists;
use App\Imports\contactlists;
use App\Imports\phonelistname;
use App\Exports\ResponseExport;
use App\models\contactlist;
use App\models\auto_send_phone_name;

use App\models\autosend;
use App\models\autosendlist;
use Illuminate\Http\Request;
use App\models\sendmsg;
use App\models\phone_only;
use App\models\anniversary;
use App\models\user_info;
use App\models\anniversarylist;
use App\models\phonenamelist;
use App\models\phone_schedule_sms;
use App\models\form_track;
use DB;
use DateTime;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;




class UserController extends Controller
{
    //

    public function index()
    {
        $conlist= DB::table('lists')->where('userID',auth()->user()->id)->get();
        $msg= DB::table('sendmsg')->where('userID',auth()->user()->id)->get();
        $id= DB::table('senderids')
        ->where('userID',auth()->user()->id)
        ->where('status',2)
        ->get(); 
        // $conlist= DB::table('contactlist')->get(); 
         $auto= DB::table('lists')
         ->select('lists.id','lists.name','lists.userID','autosend.id','autosend.listID','autosend.created_at','autosend.sendtype')
         ->join('autosend','autosend.listID','=','lists.id')
         ->get();

         $checkprofile= DB::table('users_info')->where('userID', auth()->user()->id)->get(); 
         if($checkprofile->count()<1){

            return view('users.moreinfo');
         }else{

         return view('users.index',['contactlist'=>$conlist,'auto'=>$auto,'ids'=>$id,'msgs'=>$msg]);
         }
    }

    public function list()
    {
        $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 

        $checkprofile= DB::table('users_info')->where('userID', auth()->user()->id)->get(); 
        if($checkprofile->count()<1){

           return view('users.moreinfo');
        }else{
        return view('users.list',['lists'=>$list]);
        }

    }


    public function formpage()
    {
       // $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 

             

           return view('formpage');
        

    }

    public function senderid()
    {
        $checkprofile= DB::table('users_info')->where('userID', auth()->user()->id)->get(); 
        if($checkprofile->count()<1){

           return view('users.moreinfo');
        }else{
        return view('users.senderid');
        }
    }


public function moreinfo(){

    return view('users.moreinfo');

}


public function displayform($name,$user,$title){
    $title="";
    $description="";

    $forms= DB::table('form_track')
    ->where('userID', $user)
   ->first(); 

   $title=$forms->title;
    $description=$forms->note;
    $organisation=$forms->company_name;
    $logo=$forms->logo;


   $allfield= DB::table('form_'.$user)
  ->get(); 

    return view('formpage',['users'=>$user,'title'=>$title,'notes'=>$description,'company_name'=>$organisation,'logos'=>$logo,'fields'=>$allfield]);

}


public function deleterecord(Request $request){

    switch ($request->input('action')) {
        case 'delete':


            if(count(request()->all()) > 0){

                if(isset($_POST['res'])){


                    if (is_array($_POST['res'])) {
                        foreach($_POST['res'] as $value){
                            

                            DB::table('form_'.auth()->user()->id.'_store')->where('id',$value)->delete();
                           

                       
                        }
                    
                        return redirect()->back()->withSuccess('Record deleted succesfully');
                    
                    }
                
                
                }
                        else{

                            return redirect()->back()->withErrors('You have not checked any record to delete')->withInput();
         
                        }

            }else{



            }
        }

}

public function response(){


    $scountrowsx= DB::table('form_'.auth()->user()->id)->get(); 
    $ascountx=$scountrowsx->count();

    $srowsx=DB::table('form_'.auth()->user()->id)->paginate(4);
    $acountx=$srowsx->count();
    
    
    
    
    $srows1x=DB::table('form_'.auth()->user()->id)->paginate(4);
    $acount1x= $srows1x->count();
    
    $srows2x=DB::table('form_'.auth()->user()->id.'_store')
    ->orderBy('id','desc')
    ->get() ;
    $acount2x=$srows2x->count();

    return view('users.response',['scountrows'=> $scountrowsx,'ascount'=> $ascountx,'srows'=> $srowsx,'acount'=>$acountx,'srows1'=>$srows1x,'acount1'=> $acount1x,'srows2'=>$srows2x,'acount2'=>$acount2x]);

}

public function resdelete($id){

    DB::table('form_'.auth()->user()->id.'_store')->where('id',$id)->delete();
    return redirect()->back()->withSuccess('Record has been removed successfully.');

}

public function resdetail($id){

    $srowsx=DB::table('form_'.auth()->user()->id)->get() ;
    $acountx=$srowsx->count();

   

   $srows1=DB::table('form_'.auth()->user()->id)->get() ;
    $acount1x=$srows1->count();
    
    

    $srows2x=DB::table('form_'.auth()->user()->id.'_store')
    ->where('id',$id)
    ->get() ;
    $acount2x=$srows2x->count();
    return view('users.response_detail',['srows'=>$srowsx,'acount'=>$acountx,'srows2'=>$srows2x,'acount2'=>$acount2x,'fieldid'=>$id]);

}



public static function getResponseValue($fieldname,$id){
   
    
    $output="";
    
    $rows=DB::table('form_'.auth()->user()->id.'_store')
    ->where('id',$id)
    ->get() ;
    foreach($rows as $row){
        
 if ($fieldname=='state'){ 
 
 $output.=UserController::get_state_name($row->$fieldname);
 
 }
else{
     $output.=ucwords(str_replace('/', ' ,',$row->$fieldname));
     }  	
    //$output.=str_replace('/', ' ,',$row[$fieldname]);
        
    }
    return $output;
}




public function customfield(){

    return view('users.create_custom_field');

}

public function customfieldedit(){

    return view('users.create_custom_field_edit');

}


public function form_step2(){

    $fdata= DB::table('form_'.auth()->user()->id)
    ->orderBy('fieldord','asc')
    ->get(); 

    return view('users.create_form_stp2',['fields'=>$fdata]);

}

public function form_step_sheet(){

    $fdata= DB::table('form_'.auth()->user()->id)
    ->orderBy('fieldord','asc')
    ->get(); 

    

    return view('users.create_form_sheet',['fields'=>$fdata]);

    

}

    public function mysender()
    {
        $idsx= DB::table('senderids')->where('userID',auth()->user()->id)->get(); 
        
        return view('users.my_senderid',['ids'=>$idsx]);

    }


    public function donelist($id)
    {
        $idsx= DB::table('senderids')->where('userID',auth()->user()->id)->get(); 
        return view('users.donelist',['list'=>$id]);

    }

    public function form_create()
    {
        
        return view('users.done_form_create');

    }

    public function collectinfo()
    {
        $chk="";
        $title="";
       $frmchks= DB::table('form_track')->where('form','form_'.auth()->user()->id)->get(); 
       foreach($frmchks as $frmchk){
        $title.=$frmchk->title;
       }


       if($frmchks->count()<1){

        $chk=0;
       }
       else if($frmchks->count()>0 &&  empty($title)){

        $chk=1;
       }

       else if($frmchks->count()>0 &&  !empty($title) ){

        $chk=2;
       }

       $formsx= DB::table('sms_for_phone')
       ->where('form','form_'.auth()->user()->id)
       ->where('userID',auth()->user()->id)
       ->get();
       
       
       return view('users.collect_info',['filter'=>$chk,'datas'=>$frmchks,'forms'=>$formsx]);

    }

    public function createform()
    {
       // $idsx= DB::table('senderids')->where('userID',auth()->user()->id)->get(); 
        return view('users.create_form');

    }

    public function newfieldedit()
    {
       // $idsx= DB::table('senderids')->where('userID',auth()->user()->id)->get(); 
        return view('users.add_new_field_edit');

    }


    public function formedit()
    {
       // $idsx= DB::table('senderids')->where('userID',auth()->user()->id)->get(); 
        return view('users.create_form_edit');

    }


    public function forminfoedit()
    {
        $infos= DB::table('form_track')->where('userID',auth()->user()->id)->first(); 
        $smsinfo= DB::table('sms_for_phone')->where('userID',auth()->user()->id)->first(); 
        return view('users.form_info_edit',['info'=>$infos,'sms'=>$smsinfo]);

    }


    public static  function showHumanTime($date,$time){
    $timeVariable= $date." ".$time;
    $time=  date("D, d M Y", strtotime($timeVariable));
    return $time;

    }


    public function form_info_update(){

        //1.validate data
           
        $validator=$this->validate(request(),[
           'organisation'=>'required|string',
           'title'=>'required|string',
           'note'=>'required|string',
          
          
           ]);
   
               if(count(request()->all()) > 0){
   
                  
   
   
                   if(empty( request()->file('file'))){
   
                       
                         
                DB::table('form_track')->where('userID',auth()->user()->id)->update(['company_name' => request()->input('organisation'), 'title' => request()->input('title'), 'note' => request()->input('note')]);
                //DB::table('sms_for_phone')->where('userID', auth()->user()->id)->update(['sms' => request()->input('sms'), 'senderID' => request()->input('senderid')]);
               
                    
                   
                       return redirect()->back()->withSuccess('Update succesful.');
                   
                   }
                   else{ 
   
   
   
   
   
                         ///// remove the existing file from folder /////////
   
                         $existFile=""; 
   
                         $info= DB::table('form_track')->where('userID',auth()->user()->id)->first(); 
                         $existFile.=$info->logo; 
                               
                        
   
     
                         if(file_exists(public_path('photos/'.basename($existFile)))){
     
                             unlink(public_path('photos/'.basename($existFile)));
                       
                           }
                        
                       
                         //////// move file to upload folder ////////////////
                   $file=request()->file('file');
                 $original_name = strtolower(trim($file->getClientOriginalName()));
                 $fileName =  time().rand(100,999).$original_name;
                 $filePathdb = asset('/photos/'.$fileName);
                 $filePath = 'photos';
                 $file->move($filePath,$fileName);
                     
     
                 //////////////// update database with new information ///////
     
                 DB::table('form_track')->where('userID',auth()->user()->id)->update(['company_name' => request()->input('organisation'), 'title' => request()->input('title'), 'logo' => $filePathdb, 'note' => request()->input('note')]);
               // DB::table('sms_for_phone')->where('userID', auth()->user()->id)->update(['sms' => request()->input('sms'), 'senderID' => request()->input('senderid')]);
               
                          
     
                return redirect()->back()->withSuccess('Update succesful.');
                       
                  
               
                   }}
   
   }

    public function removefield($id){


        $others= DB::table("form_".auth()->user()->id)->where('id',$id)->first(); 


////////////// also remove column from store table
    $querystore="ALTER TABLE form_".auth()->user()->id."_store DROP ".str_replace(' ', '',$others->fields);
    $insertstore = DB::insert($querystore);

if($others->type=='radio' || $others->type=='checkbox'){
    
    $deletequery1="delete from options  where user_table='form_".auth()->user()->id."' and fieldname='".$others->fields."' and type='".$others->type."' " ;	
    $insertdelete = DB::insert( $deletequery1);


    }
    

    /////// delete field from table ///////////////////////////
    

    $insquery="delete from form_".auth()->user()->id." where id='".$id."'";
    $insert = DB::insert( $insquery);


    return redirect()->back();

    }

    public function deletefrm(){

        $insquery="delete from form_track where userID=".auth()->user()->id;
        $insert = DB::insert( $insquery);

        $insquery2="DROP TABLE form_".auth()->user()->id;
        $insert2 = DB::insert( $insquery2);

        $insquery3="DROP TABLE form_".auth()->user()->id.'_store';
        $insert3 = DB::insert( $insquery3);
    
        return redirect()->route('collectinfo');
    }


    public function form_info(){

        return view('users.form_info');
    }


    public function store_form_info()    
{
    $validator=$this->validate(request(),[
        'organisation'=>'required|string',
        'title'=>'required|string',
        'note'=>'required|string',
        'imgfile'=>'required|mimes:jpeg,JPEG,png',
      
       
        
        
        ],
        [
            'organisation.required'=>'Type in the name of your organisation ',
            'title.required'=>'Enter the title of form ',
            'note.required'=>'Enter a brief description of the event ',
            'imgfile.required'=>'Upload the logo of your organisation/business',
               
            ]);

            if(count(request()->all()) > 0){
     
        $imgfile= request()->file('imgfile');
        $original_filename = strtolower(trim($imgfile->getClientOriginalName()));
        $fileName =  time().rand(100,999).$original_filename;
        $filePath = 'photos';
        $filePathdb = asset('/photos/'.$fileName);
        $imgfile->move($filePath,$fileName);

        $upinfo=DB::table('form_track')->where('userID',auth()->user()->id)->update(['title' =>request()->input('title'), 'logo' => $filePathdb,'company_name' =>request()->input('organisation'),'note' =>request()->input('note')]);
    
        //$insquery="insert into sms_for_phone (id,sms,form,userID,senderID) values(NULL,'".request()->input('sms')."','form_".auth()->user()->id."','".auth()->user()->id."','".request()->input('senderid')."')";
        //$insert = DB::insert( $insquery);


        return redirect()->route('collectinfo');
        //return redirect()->back()->withSuccess('form created succesfully. Click <\B>Collect information<\/B> on the navigational bar at the left');

}

}

    public function processstate(Request $request){
        

        $output="";
        $states= DB::table('lgas')->where('states_id',$request->id)->get(); 
       
        $output.='<br/>';
        
        foreach($states as $row){
            
        
        $output.='<option>'.$row->lga_name.'</option>';
            
            
            
        }
        
        echo  $output;


    }


    public function pullfieldname(Request $request){
        

        
        $fieldname= DB::table('form_'.auth()->user()->id)->where('id',$request->fieldId)->first(); 
       
       
        echo  ucwords($fieldname->fields);


    }


    public function processoption(Request $request){

        $output="";

        $insquery="insert into options  (option_id,user_table,fieldname,userid,option_item,type ) values(NULL,'form_".auth()->user()->id."','".$request->title."','".auth()->user()->id."','".$request->optionValue."','".$request->option_type."')";
        $insert = DB::insert($insquery);

        $options= DB::table('options')
        ->where('user_table', 'form_'.auth()->user()->id)
        ->where('fieldname', $request->title)
        ->where('type', $request->option_type)
        ->get();

        foreach($options as $row){

           $output.='<table style="width:100%;padding:20px;background:#F0F0F0;paddding-bottom:10px;margin-top:10px"  >';
           $output.='<tr>';
            
           $output.='<td style="padding:10px">'.$row->option_item.'</td><td style="float:right;padding:10px"><a href="javascript:void(0);" onClick="deleteOptions('.$row->option_id.')"><b>x</b></a></td>';
            
           $output.='</tr>';
            
            
           $output.='</table>';

        }


           return $output;

    }


    public function displayprocessoption(Request $request){

        $output="";

        
        $options= DB::table('options')
        ->where('user_table', 'form_'.auth()->user()->id)
        ->where('fieldname', $request->title)
        ->where('type', $request->option_type)
        ->get();

        foreach($options as $row){

           $output.='<table style="width:100%;padding:20px;background:#F0F0F0;paddding-bottom:10px;margin-top:10px"  >';
           $output.='<tr>';
            
           $output.='<td style="padding:10px">'.$row->option_item.'</td><td style="float:right;padding:10px"><a href="javascript:void(0);" onClick="deleteOptions('.$row->option_id.')"><b>x</b></a></td>';
            
           $output.='</tr>';
            
            
           $output.='</table>';

        }


           return $output;

    }




    public function processmenuoption(Request $request){

        $output="";

        $insquery="insert into menuoptions  (menuid,user_table,fieldname,userid,option_item,type ) values(NULL,'form_".auth()->user()->id."','".$request->title."','".auth()->user()->id."','".$request->optionMenuValue."','".$request->option_type."')";
        $insert = DB::insert($insquery);

        $options= DB::table('menuoptions')
        ->where('user_table', 'form_'.auth()->user()->id)
        ->where('fieldname', $request->title)
        ->where('type', $request->option_type)
        ->get();

        foreach($options as $row){

           $output.='<table style="width:100%;padding:20px;background:#F0F0F0;paddding-bottom:10px;margin-top:10px"  >';
           $output.='<tr>';
            
           $output.='<td style="padding:10px">'.$row->option_item.'</td><td style="float:right;padding:10px"><a href="javascript:void(0);" onClick="deleteMenuOptions('.$row->menuid.')"><b>x</b></a></td>';
            
           $output.='</tr>';
            
            
           $output.='</table>';

        }


           return $output;

    }


    public function displayprocessmenuoption(Request $request){

        $output="";
        $options= DB::table('menuoptions')
        ->where('user_table', 'form_'.auth()->user()->id)
        ->where('fieldname', $request->title)
        ->where('type', $request->option_type)
        ->get();

        foreach($options as $row){

           $output.='<table style="width:100%;padding:20px;background:#F0F0F0;paddding-bottom:10px;margin-top:10px"  >';
           $output.='<tr>';
            
           $output.='<td style="padding:10px">'.$row->option_item.'</td><td style="float:right;padding:10px"><a href="javascript:void(0);" onClick="deleteMenuOptions('.$row->menuid.')"><b>x</b></a></td>';
            
           $output.='</tr>';
            
            
           $output.='</table>';

        }


           return $output;

    }



    public function deletemenuoption(Request $request){

        $output="";

        $insquery="delete from menuoptions where menuid='". $request->menuid."' ";
        $insert = DB::insert($insquery);

        $options= DB::table('menuoptions')
        ->where('user_table', 'form_'.auth()->user()->id)
        ->where('fieldname', $request->title)
        ->where('type', $request->option_type)
        ->get();

        foreach($options as $row){

            $output.='<table style="width:100%;padding:20px;background:#F0F0F0;paddding-bottom:10px;margin-top:10px"  >';
            $output.='<tr>';
             
            $output.='<td style="padding:10px">'.$row->option_item.'</td><td style="float:right;padding:10px"><a href="javascript:void(0);" onClick="deleteMenuOptions('.$row->menuid.')"><b>x</b></a></td>';
             
            $output.='</tr>';
             
             
            $output.='</table>';
 
         }


           return $output;

    }


    public function deleteoption(Request $request){

        $output="";

        $insquery="delete from options where option_id='". $request->optionid."' ";
        $insert = DB::insert($insquery);

        $options= DB::table('options')
        ->where('user_table', 'form_'.auth()->user()->id)
        ->where('fieldname', $request->title)
        ->where('type', $request->option_type)
        ->get();

        foreach($options as $row){

           $output.='<table style="width:100%;padding:20px;background:#F0F0F0;paddding-bottom:10px;margin-top:10px"  >';
           $output.='<tr>';
            
           $output.='<td style="padding:10px">'.$row->option_item.'</td><td style="float:right;padding:10px"><a href="javascript:void(0);" onClick="deleteOptions('.$row->option_id.')"><b>x</b></a></td>';
            
           $output.='</tr>';
            
            
           $output.='</table>';

        }


           return $output;

    }


    public function newfield(){

        // $idsx= DB::table('senderids')->where('userID',auth()->user()->id)->get(); 
        return view('users.add_new_field');
    }

    public static function selectedField($field){
		$output="";
    $fieldchk= DB::table("form_".auth()->user()->id)->where('fields', $field)
    ->get();
    
		if($fieldchk->count()<1){
			$output.=0;
		}
		else if($fieldchk->count()>0){
			
			$output.=1;
		}
		
		return $output;
	} 



    



    public function addfield()
    {
        
        $tablename='form_'.auth()->user()->id;
        $tablename2='form_'.auth()->user()->id.'_store';
   
       

       if(isset($_POST['fields'])){ 
            

        $input =request()->all();  
        $condition = $input['fields'];
        foreach ($condition as $key => $condition) {

            if(UserController::selectedField($input['fields'][$key])!=1){

          

            if($input['fields'][$key]=='state' || $input['fields'][$key]=='country' || $input['fields'][$key]=='lga'){
		
                $fieldchk= DB::table($tablename)->where('fields', $input['fields'][$key])
                ->get();
                if($fieldchk->count()<1){
                 $insquery="insert into ".$tablename." (id,fieldord,required_type,fields,description,type) values(NULL,0,'yes','".$input['fields'][$key]."','','menu')";
                 $insert = DB::insert( $insquery);
              
                }
                    }else{

                        $fieldchk= DB::table($tablename)->where('fields', $input['fields'][$key])
                        ->get();
                        if($fieldchk->count()<1){
                        
                        $insquery="insert into ".$tablename." (id,fieldord,required_type,fields,description,type) values(NULL,0,'yes','".$input['fields'][$key]."','','text')";
                        $insert = DB::insert( $insquery);
                        }
                        
                    }	

                   

                   


            }



            if (Schema::hasTable($tablename2)){


                if (!Schema::hasColumn($tablename2,str_replace(' ', '',$input['fields'][$key]))) {
                    $fcquery2='ALTER TABLE '.$tablename2.' ADD '.str_replace(' ', '',$input['fields'][$key]).' VARCHAR( 200 ) NOT NULL AFTER id ';
                    $insert = DB::insert($fcquery2); 
                      } 
                   

                
         
        }  


    }

   

    $fdata= DB::table($tablename)
    ->orderBy('id','asc')
    ->get(); 
    return redirect()->route('formstp2', ['fields'=>$fdata]);
    
    //return view('users.create_form_stp2',['fields'=>$fdata]);


}else{

        return redirect()->back()->withErrors('You have not checked any field to add to form')->withInput();
     

    }

    }

   

    public function addfieldedit()
    {
        
        $tablename='form_'.auth()->user()->id;
        $tablename2='form_'.auth()->user()->id.'_store';
   
       

       if(isset($_POST['fields'])){ 
            

        $input =request()->all();  
        $condition = $input['fields'];
        foreach ($condition as $key => $condition) {

            if(UserController::selectedField($input['fields'][$key])!=1){

          

            if($input['fields'][$key]=='state' || $input['fields'][$key]=='country' || $input['fields'][$key]=='lga'){
		
                $fieldchk= DB::table($tablename)->where('fields', $input['fields'][$key])
                ->get();
                if($fieldchk->count()<1){
                 $insquery="insert into ".$tablename." (id,fieldord,required_type,fields,description,type) values(NULL,0,'yes','".$input['fields'][$key]."','','menu')";
                 $insert = DB::insert( $insquery);
              
                }
                    }else{

                        $fieldchk= DB::table($tablename)->where('fields', $input['fields'][$key])
                        ->get();
                        if($fieldchk->count()<1){
                        
                        $insquery="insert into ".$tablename." (id,fieldord,required_type,fields,description,type) values(NULL,0,'yes','".$input['fields'][$key]."','','text')";
                        $insert = DB::insert( $insquery);
                        }
                        
                    }	

                   

                   


            }



            if (Schema::hasTable($tablename2)){


                if (!Schema::hasColumn($tablename2,str_replace(' ', '',$input['fields'][$key]))) {
                    $fcquery2='ALTER TABLE '.$tablename2.' ADD '.str_replace(' ', '',$input['fields'][$key]).' VARCHAR( 200 ) NOT NULL AFTER id ';
                    $insert = DB::insert($fcquery2); 
                      } 
                   

                
         
        }  


    }

   

    $fdata= DB::table($tablename)
    ->orderBy('id','asc')
    ->get(); 
    return redirect()->route('formedit', ['fields'=>$fdata]);
    
    //return view('users.create_form_stp2',['fields'=>$fdata]);


}else{

        return redirect()->back()->withErrors('You have not checked any field to add to form')->withInput();
     

    }

    }


    public function updatefielddetail(){

        $alteredColumn="";


        $validator=$this->validate(request(),[

            'fieldname'=>'required|string',
            'option'=>'required|string',
            'required_option'=>'required|string',
         
            ],
            [
                'fieldname.required'=>'Please type in the question you want to create in form ',
                'option.required'=>'Please choose the kind of answer you want to create',
                'required_option.required'=>'Please thick wether answer to this question is required or optional',
               
                  
                
                ]);
    
                if(count(request()->all()) > 0){
    
               $oldcolumn= DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))->first();
               $alteredColumn= $oldcolumn->fields;
        
            ///////////////////////////////////// create table ///////////////////////////////////////////////////////
            $insquery='CREATE TABLE IF NOT EXISTS form_'.auth()->user()->id.' (
            id INT AUTO_INCREMENT,fields VARCHAR(255),description VARCHAR(300),fieldord VARCHAR(255) NOT NULL,required_type VARCHAR(255) NOT NULL,type VARCHAR(255) NOT NULL, PRIMARY KEY (id))  ENGINE=INNODB';
            $insert = DB::insert( $insquery);
            
            
            
            ///////////////////////////////////// create table ///////////////////////////////////////////////////////
            $fcquery1='CREATE TABLE IF NOT EXISTS form_'.auth()->user()->id.'_store (
            id INT AUTO_INCREMENT,enter_date VARCHAR(255) NOT NULL ,PRIMARY KEY (id))  ENGINE=INNODB';
            $insert = DB::insert($fcquery1);
            
    
            $formChk= DB::table('form_track')->where('form', "form_".auth()->user()->id)->get();
           // $queryfm= "select * from form_track where form='form_".$_SESSION['ID']."' ";
           // $resultfm=$connect->retrieve($queryfm);
            $numfm= $formChk->count();
            if($numfm<1){
    
    
                $form_track = new form_track();
                $form_track ->form='form_'.auth()->user()->id;
                $form_track ->userID=auth()->user()->id;
                $form_track ->title='';
                $form_track ->logo='';
                $form_track ->company_name='';
                $form_track ->note='';
                $form_track ->save();
    
    
           // $insquerytrack="insert into form_track (track_id,form,userID,title,logo,company_name,note,date_created ) values(NULL,'form_".auth()->user()->id."','".auth()->user()->id."','','','','','".date('d-M-Y')."')";
           // $insert = DB::insert($insquerytrack);
    
            }
    
            $options= DB::table('options')
            ->where('user_table', "form_".auth()->user()->id)
            ->where('fieldname', request()->input('fieldname'))
            ->where('type', request()->input('option'))
            ->get();
    
            //$query="SELECT * FROM options where user_table= 'form_".$_SESSION['ID']."' and fieldname='".$_POST['fieldname']."' and type='".$_POST['option']."' " ;
            //$result=$connect->retrieve($query);
            $num=$options->count();
    
           $menuoptions= DB::table('menuoptions')
           ->where('user_table', "form_".auth()->user()->id)
           ->where('fieldname', request()->input('fieldname'))
           ->where('type', request()->input('option'))
           ->get();
            
           // $query="SELECT * FROM menuoptions where user_table= 'form_".$_SESSION['ID']."' and fieldname='".$_POST['fieldname']."' and type='".$_POST['option']."' " ;
           // $result=$connect->retrieve($query);
            $num2= $menuoptions->count();
            
            if(!empty( request()->input('fieldname')) && !empty(request()->input('option'))){
                
                if(request()->input('option')=='radio' || request()->input('option')=='checkbox'  ){
                if($num<1){

                        // return redirect()->back()->withErrors('Please ensure  the options of the answer type you have checked are entered.')->withInput();


                       // DB::table('options')
                         //   ->where('fieldname', request()->input('oldfieldname'))
                          //  ->where('user_table', 'form_' . auth()->user()->id)
                           // ->where('userid', auth()->user()->id)
                           // ->update([

                            //    'fieldname' => request()->input('fieldname'),

                           // ]);

               $insqueryx="update options set fieldname='".str_replace('_', ' ',request()->input('fieldname'))."' where fieldname='".str_replace('_', ' ',request()->input('oldfieldname'))."' and  user_table ='form_".auth()->user()->id."' and userid='".auth()->user()->id."' and type='".request()->input('option')."'";
               DB::insert($insqueryx);
             
                   
        
        
        if(request()->input('option')=='textfield'){
                    
            // $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('input_type')."')";
            // $insertx= DB::insert($insqueryx);

             DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
             ->update([
                 
                 'required_type' =>request()->input('required_option'),
                 'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                 'description' =>request()->input('description'),
                 'type' =>request()->input('input_type'),
         ]);
     
         }else{
             
        // $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('option')."')";
        // $insertx= DB::insert($insqueryx);
       



         DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
         ->update([
             
             'required_type' =>request()->input('required_option'),
             'fields' =>str_replace(' ', '_',request()->input('fieldname')),
             'description' =>request()->input('description'),
             'type' =>request()->input('option'),
     ]);


         
         }
         //ALTER TABLE form_".auth()->user()->id."_store ADD ".$alteredColumn." TO ".str_replace(' ', '_',request()->input('fieldname')).";   
     
  //   $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
  $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store CHANGE ". $alteredColumn." ".str_replace(' ', '_',request()->input('fieldname'))." varchar(255)";
  $insert1x= DB::insert($fcquery1x);
     
  return redirect()->back()->withSuccess(' update successful.');     
        
      
               
               
               
                }
                
                
                else{
                    
                    
                    //$queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
                   // $resultfmt=$connect->retrieve($queryfmt);
                   // $numfmt=$connect->numRows($resultfmt);
    
                   
        
        
        if(request()->input('option')=='textfield'){
                    
                   // $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('input_type')."')";
                   // $insertx= DB::insert($insqueryx);

                    DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
                    ->update([
                        
                        'required_type' =>request()->input('required_option'),
                        'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                        'description' =>request()->input('description'),
                        'type' =>request()->input('input_type'),
                ]);
            
                }else{
                    
               // $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('option')."')";
               // $insertx= DB::insert($insqueryx);
              



                DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
                ->update([
                    
                    'required_type' =>request()->input('required_option'),
                    'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                    'description' =>request()->input('description'),
                    'type' =>request()->input('option'),
            ]);


                
                }
                //ALTER TABLE form_".auth()->user()->id."_store ADD ".$alteredColumn." TO ".str_replace(' ', '_',request()->input('fieldname')).";   
            
         //   $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
         $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store CHANGE ". $alteredColumn." ".str_replace(' ', '_',request()->input('fieldname'))." varchar(255)";
         $insert1x= DB::insert($fcquery1x);
            
         return redirect()->back()->withSuccess(' update successful.');     
               
                    
                    
                }	
                    
                }
                else if(request()->input('option')=='textfield' && empty(request()->input('input_type')) ){
                    
                    
                    return redirect()->back()->withErrors('Select input type for textfield')->withInput();
             
                    
                    
                    
                }
                
                else if(request()->input('option')=='selectMenu'){
                    
                    
                if($num2<1){

                    if(request()->input('oldoption')=='radio' || request()->input('oldoption')=='checkbox' ){

                        $options= DB::table('options')
                        ->where('user_table', "form_".auth()->user()->id)
                        ->where('fieldname', request()->input('fieldname'))
                        ->where('userid',auth()->user()->id)
                        ->where('type',request()->input('oldoption'))
                        ->get();

                        foreach($options as  $option){

                     $insquerya="insert into menuoptions (user_table,fieldname,userid,option_item,type ) 
                     values('form_'".auth()->user()->id."','".request()->input('fieldname')."','".auth()->user()->id."','".$option->option_item."','selectMenu')";
                    DB::insert($insquerya);

                        }

                    DB::table('options') 
                    ->where('user_table', "form_".auth()->user()->id)
                    ->where('fieldname', request()->input('fieldname'))
                    ->where('userid',auth()->user()->id)
                    ->where('type',request()->input('oldoption'))
                    ->delete();


                    }

                   
    
                   
        if(request()->input('option')=='textfield'){
                    
            //$insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['input_type']."')";
            //$connect->insertion($insquery);

            DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
            ->update([
                
                'required_type' =>request()->input('required_option'),
                'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                'description' =>request()->input('description'),
                'type' =>request()->input('input_type'),
        ]);
    
        }else{

            DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
            ->update([
                
                'required_type' =>request()->input('required_option'),
                'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                'description' =>request()->input('description'),
                'type' =>request()->input('option'),
        ]);
            
       // $insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['option']."')";
   // $connect->insertion($insquery);
        
        }

    
    //$fcquery1="ALTER TABLE form_".$_SESSION['ID']."_store ADD ".str_replace(' ', '_',$_POST['fieldname'])." VARCHAR( 600 ) NOT NULL AFTER id " ;
    //$connect->insertion($fcquery1);

    $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store CHANGE ". $alteredColumn." ".str_replace(' ', '_',request()->input('fieldname'))." varchar(255)";
    $insert1x= DB::insert($fcquery1x);
    
    return redirect()->back()->withSuccess(' update successful.');  	
                    
                }
        else{
            
            
                   // $queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
                   // $resultfmt=$connect->retrieve($queryfmt);
                   // $numfmt=$connect->numRows($resultfmt);
    
                  
        
        
        if(request()->input('option')=='textfield'){
                    
                    //$insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['input_type']."')";
                    //$connect->insertion($insquery);
    
                    DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
                    ->update([
                        
                        'required_type' =>request()->input('required_option'),
                        'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                        'description' =>request()->input('description'),
                        'type' =>request()->input('input_type'),
                ]);
            
                }else{
    
                    DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
                    ->update([
                        
                        'required_type' =>request()->input('required_option'),
                        'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                        'description' =>request()->input('description'),
                        'type' =>request()->input('option'),
                ]);
                    
               // $insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['option']."')";
           // $connect->insertion($insquery);
                
                }
        
            
            //$fcquery1="ALTER TABLE form_".$_SESSION['ID']."_store ADD ".str_replace(' ', '_',$_POST['fieldname'])." VARCHAR( 600 ) NOT NULL AFTER id " ;
            //$connect->insertion($fcquery1);
    
            $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store CHANGE ". $alteredColumn." ".str_replace(' ', '_',request()->input('fieldname'))." varchar(255)";
            $insert1x= DB::insert($fcquery1x);
            
            return redirect()->back()->withSuccess(' update successful.');  
    
           // header('location:custom_field_create?status=created');
           
                }		
                    
                    
                }
                
                
                else{
                    
                    
                 //$queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
                  //  $resultfmt=$connect->retrieve($queryfmt);
                  //  $numfmt=$connect->numRows($resultfmt);
    
                   	
                    
                if(request()->input('option')=='textfield'){
    
                    DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
                    ->update([
                        
                        'required_type' =>request()->input('required_option'),
                        'fields' =>str_replace(' ', '_',request()->input('fieldname')),
                        'description' =>request()->input('description'),
                        'type' =>request()->input('input_type'),
                ]);
            
                    
                  //  $insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['input_type']."')";
           // $connect->insertion($insquery);
            
                }else{
                    
                //$insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['option']."')";
           // $connect->insertion($insquery);
    
           DB::table('form_'.auth()->user()->id)->where('id', request()->input('id'))
           ->update([
               
               'required_type' =>request()->input('required_option'),
               'fields' =>str_replace(' ', '_',request()->input('fieldname')),
               'description' =>request()->input('description'),
               'type' =>request()->input('option'),
       ]);
    
                
                }
            
            if($_POST['option']=='textarea'){
                $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store CHANGE ". $alteredColumn." ".str_replace(' ', '_',request()->input('fieldname'))." varchar(255)";
                $insert1x= DB::insert($fcquery1x);
            }
            else{
                
                $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store CHANGE ". $alteredColumn." ".str_replace(' ', '_',request()->input('fieldname'))." varchar(255)";
                $insert1x= DB::insert($fcquery1x);
            }
    
    
            if($_POST['option']=='image'||$_POST['option']=='imagelive'){
    
                $folder = public_path('/photos_'.auth()->user()->id. '/');
    
    
                if (! File::exists($folder)) {
                    File::makeDirectory($folder);
                }
    
    
                 }
    
                 if($_POST['option']=='file'){
    
                    $folder = public_path('/documents_'.auth()->user()->id. '/');
        
        
                    if (! File::exists($folder)) {
                        File::makeDirectory($folder);
                    }
        
        
                     }
            
                     return redirect()->back()->withSuccess(' update successful.');  
           
                
           	}	
            
                
                
            }
            
            
            
            
        
        
        }
        
    
    }





public function savecustomfield(){

    $validator=$this->validate(request(),[
        'fieldname'=>'required|string',
        'option'=>'required|string',
        'required_option'=>'required|string',
     
        ],
        [
            'fieldname.required'=>'Please type in the question you want to create in form ',
            'option.required'=>'Please choose the kind of answer you want to create',
            'required_option.required'=>'Please thick wether answer to this question is required or optional',
           
              
            
            ]);

            if(count(request()->all()) > 0){

	
	
        ///////////////////////////////////// create table ///////////////////////////////////////////////////////
        $insquery='CREATE TABLE IF NOT EXISTS form_'.auth()->user()->id.' (
        id INT AUTO_INCREMENT,fields VARCHAR(255),description VARCHAR(300),fieldord VARCHAR(255) NOT NULL,required_type VARCHAR(255) NOT NULL,type VARCHAR(255) NOT NULL, PRIMARY KEY (id))  ENGINE=INNODB';
        $insert = DB::insert( $insquery);
        
        
        
        ///////////////////////////////////// create table ///////////////////////////////////////////////////////
        $fcquery1='CREATE TABLE IF NOT EXISTS form_'.auth()->user()->id.'_store (
        id INT AUTO_INCREMENT,enter_date VARCHAR(255) NOT NULL ,PRIMARY KEY (id))  ENGINE=INNODB';
        $insert = DB::insert($fcquery1);
        

        $formChk= DB::table('form_track')->where('form', "form_".auth()->user()->id)->get();
       // $queryfm= "select * from form_track where form='form_".$_SESSION['ID']."' ";
       // $resultfm=$connect->retrieve($queryfm);
        $numfm= $formChk->count();
        if($numfm<1){


            $form_track = new form_track();
            $form_track ->form='form_'.auth()->user()->id;
            $form_track ->userID=auth()->user()->id;
            $form_track ->title='';
            $form_track ->logo='';
            $form_track ->company_name='';
            $form_track ->note='';
            $form_track ->save();


       // $insquerytrack="insert into form_track (track_id,form,userID,title,logo,company_name,note,date_created ) values(NULL,'form_".auth()->user()->id."','".auth()->user()->id."','','','','','".date('d-M-Y')."')";
       // $insert = DB::insert($insquerytrack);

        }

        $options= DB::table('options')
        ->where('user_table', "form_".auth()->user()->id)
        ->where('fieldname', request()->input('fieldname'))
        ->where('type', request()->input('option'))
        ->get();

        //$query="SELECT * FROM options where user_table= 'form_".$_SESSION['ID']."' and fieldname='".$_POST['fieldname']."' and type='".$_POST['option']."' " ;
        //$result=$connect->retrieve($query);
        $num=$options->count();

       $menuoptions= DB::table('menuoptions')
       ->where('user_table', "form_".auth()->user()->id)
       ->where('fieldname', request()->input('fieldname'))
       ->where('type', request()->input('option'))
       ->get();
        
       // $query="SELECT * FROM menuoptions where user_table= 'form_".$_SESSION['ID']."' and fieldname='".$_POST['fieldname']."' and type='".$_POST['option']."' " ;
       // $result=$connect->retrieve($query);
        $num2= $menuoptions->count();
        
        if(!empty( request()->input('fieldname')) && !empty(request()->input('option'))){
            
            if(request()->input('option')=='radio' || request()->input('option')=='checkbox'  ){
            if($num<1){
                
                return redirect()->back()->withErrors('Please ensure  the options of the answer type you have checked are entered.')->withInput();
            
            }
            
            
            else{
                
                
                //$queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
               // $resultfmt=$connect->retrieve($queryfmt);
               // $numfmt=$connect->numRows($resultfmt);

                $formcheckx= DB::table("form_".auth()->user()->id)
                ->where('fields', str_replace(' ', '_',request()->input('fieldname')))
                ->get();
                $numfmt=$formcheckx->count();
                
            if($numfmt<1){
    
    
    if(request()->input('option')=='textfield'){
                
                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('input_type')."')";
                $insertx= DB::insert($insqueryx);
        
            }else{
                
            $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('option')."')";
            $insertx= DB::insert($insqueryx);
            
            }
    
            
        
        $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
        $insert1x= DB::insert($fcquery1x);
        
        return redirect()->route('donefield');         
            }else{
                
                
                 return redirect()->back()->withErrors('You have already created this question in form. <a href="cform"> View</a>')->withInput();
         
                
                
            }
                
                
            }	
                
            }
            else if(request()->input('option')=='textfield' && empty(request()->input('input_type')) ){
                
                
                return redirect()->back()->withErrors('Select input type for textfield')->withInput();
         
                
                
                
            }
            
            else if(request()->input('option')=='selectMenu'){
                
                
            if($num2<1){

                return redirect()->back()->withErrors('Please ensure  the options of the answer type you have checked are entered')->withInput();
         
                
                //header('location:custom_field_create?update=NO_OPTIONSii');	
                
            }
    else{
        
        
               // $queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
               // $resultfmt=$connect->retrieve($queryfmt);
               // $numfmt=$connect->numRows($resultfmt);

                $formcheckx= DB::table("form_".auth()->user()->id)
                ->where('fields', str_replace(' ', '_',request()->input('fieldname')))
                ->get();
                $numfmt=$formcheckx->count();

        
        if($numfmt<1){	
    
    
    if(request()->input('option')=='textfield'){
                
                //$insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['input_type']."')";
                //$connect->insertion($insquery);

                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type ) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('input_type')."')";
                $insertx= DB::insert($insqueryx);
        
            }else{

                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type ) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('option')."')";
                $insertx= DB::insert($insqueryx);
                
           // $insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['option']."')";
       // $connect->insertion($insquery);
            
            }
    
        
        //$fcquery1="ALTER TABLE form_".$_SESSION['ID']."_store ADD ".str_replace(' ', '_',$_POST['fieldname'])." VARCHAR( 600 ) NOT NULL AFTER id " ;
        //$connect->insertion($fcquery1);

        $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
        $insert1x= DB::insert($fcquery1x);
        
        return redirect()->route('donefield');

       // header('location:custom_field_create?status=created');
        }	
        else{
                
                
            //header('location:custom_field_create?status=already_exist');	
            return redirect()->back()->withErrors('You have already created this question in form. <a href="cform"> View</a>')->withInput();
           
                
            }		
            }		
                
                
            }
            
            
            else{
                
                
             //$queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
              //  $resultfmt=$connect->retrieve($queryfmt);
              //  $numfmt=$connect->numRows($resultfmt);

                $formcheckx= DB::table("form_".auth()->user()->id)
                ->where('fields', str_replace(' ', '_',request()->input('fieldname')))
                ->get();
                $numfmt=$formcheckx->count();
        
        if($numfmt<1){		
                
            if(request()->input('option')=='textfield'){

                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type ) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('input_type')."')";
                $insertx= DB::insert($insqueryx);
        
                
              //  $insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['input_type']."')";
       // $connect->insertion($insquery);
        
            }else{
                
            //$insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['option']."')";
       // $connect->insertion($insquery);

        $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,required_type,fields,description,type ) values(NULL,0,'".request()->input('required_option')."','".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('description')."','".request()->input('option')."')";
        $insertx= DB::insert($insqueryx);

            
            }
        
        if($_POST['option']=='textarea'){
        $fcquery1="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." TEXT NOT NULL AFTER id " ;
        $insertx1= DB::insert($fcquery1);
        }
        else{
            
        $fcquery1="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
        $insertx1= DB::insert($fcquery1);
        }


        if($_POST['option']=='image'||$_POST['option']=='imagelive'){

            $folder = public_path('/photos_'.auth()->user()->id. '/');


            if (! File::exists($folder)) {
                File::makeDirectory($folder);
            }


             }

             if($_POST['option']=='file'){

                $folder = public_path('/documents_'.auth()->user()->id. '/');
    
    
                if (! File::exists($folder)) {
                    File::makeDirectory($folder);
                }
    
    
                 }
        
        return redirect()->route('donefield');
       
            
        }
            else{
                
                
                return redirect()->back()->withErrors('You have already created this question in form. <a href="cform"> View</a>')->withInput();
          	
                
                
            }	}	
        
            
            
        }
        
        
        
        
    
    
    }
    

}



public function postform($name,$user,$title){

    $fields="";
	$postfields="";
	$chkvalue="";
	$chkpostfields="";
	$chkfields="";
	$chkvalueformat="";
    

            if(count(request()->all()) > 0){

                //$squery="SELECT * FROM form_".$id." where type!='checkbox'";

                //$sresult=$connect->retrieve($squery);
                //$srows=$connect->arrayFetch($sresult);

                $srows= DB::table('form_'.$user)
                ->where('type','!=', 'checkbox')
                ->get();

                $chrows= DB::table('form_'.$user)
                ->where('type','checkbox')
                ->get();




                
               // $chquery="SELECT * FROM form_".$id." where type ='checkbox'";
                
               // $chresult=$connect->retrieve($chquery);
               // $chrows=$connect->arrayFetch($chresult);
                
                foreach($chrows as $chrow){
                    
                    $chkfields.= ','.$chrow->fields;
                    
                    
                    foreach(request()->input(str_replace('_','',$chrow->fields))  as  $key ){
                    
                    
                    $chkvalue.='/'.$key;
                    
                    
                    }
                    
                    $chkpostfields.=",'".$chkvalue."'";
                }
                
                foreach($srows as $srow){
                     
                    $fields.= ','.str_replace(' ','',$srow->fields);
                    $postfields.= ',"'.request()->input($srow->fields).'"';
                 }
                
                 
                     
                
                 
                  $query="INSERT INTO form_".$user."_store (id".$fields.$chkfields.",enter_date) VALUES(NULL$postfields $chkpostfields,'".date('d-M-Y')."')";
                  $insert = DB::insert( $query);
                
                  return redirect()->back()->withSuccess('Thank you for submitting your information.');
                 
                 
                
            }}


public function savecustomfield2(){

    $validator=$this->validate(request(),[
        'fieldname'=>'required|string',
        'option'=>'required|string',
     
        ],
        [
            'fieldname.required'=>'Please type in the name of the field you want to create in form ',
            'option.required'=>'Please choose the kind of field you want to create',
           
              
            
            ]);

            if(count(request()->all()) > 0){

	
	
        ///////////////////////////////////// create table ///////////////////////////////////////////////////////
        $insquery='CREATE TABLE IF NOT EXISTS form_'.auth()->user()->id.' (
        form_id INT AUTO_INCREMENT,fields VARCHAR(255) NOT NULL,type VARCHAR(255) NOT NULL, PRIMARY KEY (form_id))  ENGINE=INNODB';
        $insert = DB::insert( $insquery);
        
        
        
        ///////////////////////////////////// create table ///////////////////////////////////////////////////////
        $fcquery1='CREATE TABLE IF NOT EXISTS form_'.auth()->user()->id.'_store (
        id INT AUTO_INCREMENT,enter_date VARCHAR(255) NOT NULL ,PRIMARY KEY (id))  ENGINE=INNODB';
        $insert = DB::insert($fcquery1);
        

        $formChk= DB::table('form_track')->where('form', "form_".auth()->user()->id)->get();
       // $queryfm= "select * from form_track where form='form_".$_SESSION['ID']."' ";
       // $resultfm=$connect->retrieve($queryfm);
        $numfm= $formChk->count();
        if($numfm<1){


            $form_track = new form_track();
            $form_track ->form='form_'.auth()->user()->id;
            $form_track ->userID=auth()->user()->id;
            $form_track ->title='';
            $form_track ->logo='';
            $form_track ->company_name='';
            $form_track ->note='';
            $form_track ->save();





       // $insquerytrack="insert into form_track (track_id,form,user_id,title,logo,company_name,note,date_created ) values(NULL,'form_".auth()->user()->id."','".auth()->user()->id."','','','','','".date('d-M-Y')."')";
       // $insert = DB::insert($insquerytrack);

        }

        $options= DB::table('options')
        ->where('user_table', "form_".auth()->user()->id)
        ->where('fieldname', request()->input('fieldname'))
        ->where('type', request()->input('option'))
        ->get();

        //$query="SELECT * FROM options where user_table= 'form_".$_SESSION['ID']."' and fieldname='".$_POST['fieldname']."' and type='".$_POST['option']."' " ;
        //$result=$connect->retrieve($query);
        $num=$options->count();

       $menuoptions= DB::table('menuoptions')
       ->where('user_table', "form_".auth()->user()->id)
       ->where('fieldname', request()->input('fieldname'))
       ->where('type', request()->input('option'))
       ->get();
        
       // $query="SELECT * FROM menuoptions where user_table= 'form_".$_SESSION['ID']."' and fieldname='".$_POST['fieldname']."' and type='".$_POST['option']."' " ;
       // $result=$connect->retrieve($query);
        $num2= $menuoptions->count();
        
        if(!empty( request()->input('fieldname')) && !empty(request()->input('option'))){
            
            if(request()->input('option')=='radio' || request()->input('option')=='checkbox'  ){
            if($num<1){
                
                return redirect()->back()->withErrors('Please ensure  the options of the field-type you have checked are entered.')->withInput();
            
            }
            
            
            else{
                
                
                //$queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
               // $resultfmt=$connect->retrieve($queryfmt);
               // $numfmt=$connect->numRows($resultfmt);

                $formcheckx= DB::table("form_".auth()->user()->id)
                ->where('fields', str_replace(' ', '_',request()->input('fieldname')))
                ->get();
                $numfmt=$formcheckx->count();
                
            if($numfmt<1){
    
    
    if(request()->input('option')=='textfield'){
                
                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,fields,type) values(NULL,0,'".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('input_type')."')";
                $insertx= DB::insert($insqueryx);
        
            }else{
                
            $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,fields,type) values(NULL,0,'".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('option')."')";
            $insertx= DB::insert($insqueryx);
            
            }
    
            
        
        $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
        $insert1x= DB::insert($fcquery1x);
        
        return redirect()->route('donefieldedit');         
            }else{
                
                
                 return redirect()->back()->withErrors('You have already created this field in form. <a href="cform"> View</a>')->withInput();
         
                
                
            }
                
                
            }	
                
            }
            else if(request()->input('option')=='textfield' && empty(request()->input('input_type')) ){
                
                
                return redirect()->back()->withErrors('Select input type for textfield')->withInput();
         
                
                
                
            }
            
            else if(request()->input('option')=='selectMenu'){
                
                
            if($num2<1){

                return redirect()->back()->withErrors('Please ensure  the options of the field-type you have checked are entered')->withInput();
         
                
                //header('location:custom_field_create?update=NO_OPTIONSii');	
                
            }
    else{
        
        
               // $queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
               // $resultfmt=$connect->retrieve($queryfmt);
               // $numfmt=$connect->numRows($resultfmt);

                $formcheckx= DB::table("form_".auth()->user()->id)
                ->where('fields', str_replace(' ', '_',request()->input('fieldname')))
                ->get();
                $numfmt=$formcheckx->count();

        
        if($numfmt<1){	
    
    
    if(request()->input('option')=='textfield'){
                
                //$insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['input_type']."')";
                //$connect->insertion($insquery);

                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,fields,type ) values(NULL,0,'".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('input_type')."')";
                $insertx= DB::insert($insqueryx);
        
            }else{

                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,fields,type ) values(NULL,0,'".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('option')."')";
                $insertx= DB::insert($insqueryx);
                
           // $insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['option']."')";
       // $connect->insertion($insquery);
            
            }
    
        
        //$fcquery1="ALTER TABLE form_".$_SESSION['ID']."_store ADD ".str_replace(' ', '_',$_POST['fieldname'])." VARCHAR( 600 ) NOT NULL AFTER id " ;
        //$connect->insertion($fcquery1);

        $fcquery1x="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
        $insert1x= DB::insert($fcquery1x);
        
        return redirect()->route('donefieldedit');

       // header('location:custom_field_create?status=created');
        }	
        else{
                
                
            //header('location:custom_field_create?status=already_exist');	
            return redirect()->back()->withErrors('You have already created this field in form. <a href="cform"> View</a>')->withInput();
           
                
            }		
            }		
                
                
            }
            
            
            else{
                
                
             //$queryfmt= "select * from form_".$_SESSION['ID']." where fields='".str_replace(' ', '_',$_POST['fieldname'])."' ";
              //  $resultfmt=$connect->retrieve($queryfmt);
              //  $numfmt=$connect->numRows($resultfmt);

                $formcheckx= DB::table("form_".auth()->user()->id)
                ->where('fields', str_replace(' ', '_',request()->input('fieldname')))
                ->get();
                $numfmt=$formcheckx->count();
        
        if($numfmt<1){		
                
            if(request()->input('option')=='textfield'){

                $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,fields,type ) values(NULL,0,'".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('input_type')."')";
                $insertx= DB::insert($insqueryx);
        
                
              //  $insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['input_type']."')";
       // $connect->insertion($insquery);
        
            }else{
                
            //$insquery="insert into form_".$_SESSION['ID']." (form_id,fields,type ) values(NULL,'".str_replace(' ', '_',$_POST['fieldname'])."','".$_POST['option']."')";
       // $connect->insertion($insquery);

        $insqueryx="insert into form_".auth()->user()->id." (id,fieldord,fields,type ) values(NULL,0,'".str_replace(' ', '_',request()->input('fieldname'))."','".request()->input('option')."')";
        $insertx= DB::insert($insqueryx);

            
            }
        
        if($_POST['option']=='textarea'){
        $fcquery1="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." TEXT NOT NULL AFTER id " ;
        $insertx1= DB::insert($fcquery1);
        }
        else{
            
        $fcquery1="ALTER TABLE form_".auth()->user()->id."_store ADD ".str_replace(' ', '_',request()->input('fieldname'))." VARCHAR( 600 ) NOT NULL AFTER id " ;
        $insertx1= DB::insert($fcquery1);
        }
        
        return redirect()->route('donefieldedit');
       
            
        }
            else{
                
                
                return redirect()->back()->withErrors('You have already created this field in form. <a href="cform"> View</a>')->withInput();
          	
                
                
            }	}	
        
            
            
        }
        
        
        
        
    
    
    }
    

}

public function donefield(){

    return view('users.done_field_create');  
}

public function donefieldedit(){

    return view('users.done_field_create_edit');  
}


    public function submitformfield()
    {
        $trackFields="";
        $track="";
        $inserttrack="";
        $tablename='form_'.auth()->user()->id;
        $tablename2='form_'.auth()->user()->id.'_store';

        if (!Schema::hasTable($tablename)){
        Schema::create($tablename, function($table)
{
         $table->increments('id');
         $table->string('fields', 255);
         $table->string('type', 255);
});


$fcquery2='ALTER TABLE '.$tablename.' ADD fieldord INT(11) NOT NULL AFTER id ';
                            $insert = DB::insert($fcquery2); 

$fcquery3='ALTER TABLE '.$tablename.' ADD required_type VARCHAR(255) NOT NULL AFTER id ';
                            $insert = DB::insert($fcquery3); 

$fcquery4='ALTER TABLE '.$tablename.' ADD description VARCHAR(255) NOT NULL AFTER id ';
                            $insert = DB::insert($fcquery4); 
                            
}      
       

       if(isset($_POST['fields'])){ 
            

        $input =request()->all();  
        $condition = $input['fields'];
        foreach ($condition as $key => $condition) {

          

            if($input['fields'][$key]=='state' || $input['fields'][$key]=='country' || $input['fields'][$key]=='lga'){
		
                $fieldchk= DB::table($tablename)->where('fields', $input['fields'][$key])
                ->get();
                if($fieldchk->count()<1){
                 $insquery="insert into ".$tablename." (id,fieldord,required_type,fields,description,type) values(NULL,0,'yes','".$input['fields'][$key]."','','menu')";
                 $insert = DB::insert( $insquery);
              
                }
                    }else{

                        $fieldchk= DB::table($tablename)->where('fields', $input['fields'][$key])
                        ->get();
                        if($fieldchk->count()<1){
                        
                        $insquery="insert into ".$tablename." (id,fieldord,required_type,fields,description,type) values(NULL,0,'yes','".$input['fields'][$key]."','','text')";
                        $insert = DB::insert( $insquery);
                        }
                        
                    }	

                    $trackFields.=str_replace(' ', '',$input['fields'][$key]).' VARCHAR(255) NOT NULL,';
                   

                    if (Schema::hasTable($tablename2)){


                        if (!Schema::hasColumn($tablename2,str_replace(' ', '',$input['fields'][$key]))) {
                            $fcquery2='ALTER TABLE '.$tablename2.' ADD '.str_replace(' ', '',$input['fields'][$key]).' VARCHAR( 200 ) NOT NULL AFTER id ';
                            $insert = DB::insert($fcquery2); 
                              } 
                           
       
                        
                 
                }  

    }

    $fcquery1='CREATE TABLE IF NOT EXISTS '.$tablename2.' (id INT AUTO_INCREMENT,'.$trackFields.'enter_date VARCHAR(255) NOT NULL, PRIMARY KEY (id))  ENGINE=INNODB';
    $insert = DB::insert($fcquery1);


       

    $form_track = new form_track();
    $form_track ->form=$tablename;
    $form_track ->userID=auth()->user()->id;
    $form_track ->title='';
    $form_track ->logo='';
    $form_track ->company_name='';
    $form_track ->note='';
    $form_track ->save();

    $fdata= DB::table($tablename)
    ->orderBy('id','asc')
    ->get(); 
    return redirect()->route('formstp2', ['fields'=>$fdata]);
    
    //return view('users.create_form_stp2',['fields'=>$fdata]);


}else{

        return redirect()->back()->withErrors('You have not checked any field to add to form')->withInput();
     

    }

    }
    
    public function profileview(){
        $data= DB::table('users_info') 
        ->select('users_info.name','users_info.email','users_info.phone','users_info.country','users_info.state','users.created_at','users_info.usage_type')
        ->join('users','users.id','=','users_info.userID')
        ->where('userID',auth()->user()->id)->get();
        
        $checkprofile= DB::table('users_info')->where('userID', auth()->user()->id)->get(); 
        if($checkprofile->count()<1){

           return view('users.moreinfo');
        }else{
        return view('users.profile_view',['datas'=>$data]);
        }
    }


    public static function country(){
        
   $output='';
   $rows= DB::table('countries')->get();
   foreach($rows as $row){
   
       $output.='<option value="'.$row->country_name.'">'. $row->country_name.'</option>';
       }
       
       return $output;
   }


   public static function getOptionsItem($val,$val2,$sessid){
    $output="";
    
    if($val=='radio'){
       


        
      //  $query="select * from options where fieldname='".$val2."' and type='".$val."' and user_table='form_".$sessid."' ";
    //$result=$this->retrieve($query);
    //$rows=$this->arrayFetch($result);

    $options= DB::table('options')->where('fieldname', $val2)
    ->where(['type' => $val])
    ->where(['user_table' => 'form_'.$sessid])
    ->get();


    
        $output.='<table><tr>';
        foreach($options as $option){
            $output.='<td style="padding-right:20px"> <input type='.$val.' name='.str_replace(' ', '.',$val2).' value='.$option->option_item.' required /> '.ucwords($option->option_item).' </td>';
        }
        $output.='</tr></table>';
    
}
    else if($val=='checkbox'){
        
      //  $query="select * from options where fieldname='".$val2."' and type='".$val."' and user_table='form_".$_SESSION['ID']."' ";
    //$result=$this->retrieve($query);
    //$rows=$this->arrayFetch($result);

    $options= DB::table('options')->where('fieldname', $val2)
    ->where(['type' => $val])
    ->where(['user_table' => 'form_'.$sessid])
    ->get();
        
    $output.='<table>';
        foreach($options as $option){
            $output.='<tr><td style="padding-right:20px"> <input type='.$val.' name="'.str_replace(' ', '',$val2).'[]" value='.str_replace(' ', '-',$option->option_item).' /> '.ucwords($option->option_item).' </td></tr>';
        }
        $output.='</table>';
    }
    return $output;
}

    public static function verifyField($field,$type,$sessid){
        $output="";	
        
            
        if($field=='country'){
            
                              
                      $output='<select name="country" class="input w-full border mt-2" required>'.
                      
                      Usercontroller::country()
                      
                     .' </select>';	
                
        
            
        }		
            
        if($field=='state'){
            
    
                      
                      $output='<select id="state" name="state" class="input w-full border mt-2" onChange="popProvince()" >'.
                     
                      Usercontroller::states2()
                      
                     .' </select>';	
                
        
            
        }
        
        if($field=='lga'){
           
                      
                      $output='<select id="province" name="lga" class="input w-full border mt-2" ></select>';	
                
        
            
        }
        
        
        
        if($field=='email'){
            
             
                      
                      $output='<input name="'.$field.'" class="input w-full border mt-2" type="email" required>';	
            
            
        }		
        else if($field !='email' || $field !='state'|| $field !='country' ){
            
             if($type=='radio'){
                $output=UserController::getOptionsItem($type,$field,$sessid);
                 
             }
             else if($type=='checkbox'){
                 
                $output=UserController::getOptionsItem($type,$field,$sessid);
             }
            else if($type=='textarea'){
                   $output='<textarea name="'.str_replace(' ', '.',$field).'" class="input w-full border mt-2" required></textarea>';	
                 
             }
             else if($type=='text'){

                if($field=="date of birth"){

                    $output='<input name="'.str_replace(' ', '.',$field).'"  class="datepicker input w-full border block mx-auto mt-2" type="'.$type.'" required>'; 
              
                }else{
                 
                 $output='<input name="'.str_replace(' ', '.',$field).'" class="input w-full border mt-2" type="'.$type.'" required>'; 
                }
                }

                 else if($type=='date'){

               

                    $output='<input name="'.str_replace(' ', '.',$field).'"  class="datepicker input w-full border block mx-auto mt-2" type="'.$type.'" required>'; 
              
                }
             else if($type=='number'){
                 
                 $output='<input name="'.str_replace(' ', '.',$field).'" class="input w-full border mt-2" type="'.$type.'" required>'; 
             }
                    
            else if($type=='selectMenu'){
                
               // $result= "select * from  menuoptions where user_table ='form_".$_SESSION['ID']."' and fieldname='".$field."' ";
               // $result=$this->retrieve($result);
               // $rows=$this->arrayFetch($result);

                $options= DB::table('menuoptions')
                ->where('fieldname', $field)
                ->where(['user_table' => 'form_'.auth()->user()->id])
                ->get();
                 
                 $output.='<select name="'.str_replace(' ', '.',$field).'" class="input w-full border mt-2">';
                 
                 foreach($options as $option){
                  $output.='<option>'.$option->option_item.'</option>';
                 }
                  
                  $output.='</select>';
                 
             }	

             else if($type=='image'||$type=='file'){
                
                   $output.='<input name="'.str_replace(' ', '.',$field).'" type="file" />';
                   
                   return $output;
                  
              }	

              else if($type=='imagelive'){
                
                $output.=' <button onClick="take_snapshot()" class="button w-32 mr-2 mb-2 flex items-center justify-center bg-theme-34 text-white"> <i data-feather="camera" class="w-4 h-4 mr-2"></i> Snap</button>
                <input type="hidden" name="image" class="image-tag"> ';
                
                return $output;
               
           }	
            
            
        }
    return $output;	
        }




        public static function verifyField2($field,$type,$sessid){
            $output="";	
            
                
            if($field=='country'){
                
                                  
                          $output='<select name="country" class="form-control" data-plugin-multiselect data-plugin-options=\'{ "maxHeight": 200 }\' id="ms_example1" required>'.
                          
                          Usercontroller::country()
                          
                         .' </select>';	
                    
            
                
            }		
                
            if($field=='state'){
                
        
                          
                          $output='<select id="state" name="state" class="form-control" data-plugin-multiselect data-plugin-options=\'{ "maxHeight": 200 }\' id="ms_example1" onChange="popProvince()" >'.
                         
                          Usercontroller::states2()
                          
                         .' </select>';	
                    
            
                
            }
            
            if($field=='lga'){
               
                          
                          $output='<select id="province" name="lga" class="form-control" ></select>';	
                    
            
                
            }
            
            
            
            if($field=='email'){
                
                 
                          
                          $output='<input name="'.$field.'" class="form-control" type="email" required>';	
                
                
            }		
            else if($field !='email' || $field !='state'|| $field !='country' ){
                
                 if($type=='radio'){
                    $output=UserController::getOptionsItem($type,$field,$sessid);
                     
                 }
                 else if($type=='checkbox'){
                     
                    $output=UserController::getOptionsItem($type,$field,$sessid);
                 }
                else if($type=='textarea'){
                       $output='<textarea name="'.str_replace(' ', '.',$field).'" class="form-control" required></textarea>';	
                     
                 }
                 else if($type=='text'){
    
                    if($field=="date of birth"){
    
                        $output='<input name="'.str_replace(' ', '.',$field).'" data-plugin-datepicker class="form-control" type="text" required>'; 
                  
                    }else{
                     
                     $output='<input name="'.str_replace(' ', '.',$field).'" class="form-control" type="'.$type.'" required>'; 
                    }
                    }
    
                     else if($type=='date'){
    
                   
    
                        $output='<input name="'.str_replace(' ', '.',$field).'" data-plugin-datepicker  class="form-control" type="text" required>'; 
                  
                    }
                 else if($type=='number'){
                     
                     $output='<input name="'.str_replace(' ', '.',$field).'" class="form-control" type="'.$type.'" required>'; 
                 }
                        
                else if($type=='selectMenu'){
                    
                   // $result= "select * from  menuoptions where user_table ='form_".$_SESSION['ID']."' and fieldname='".$field."' ";
                   // $result=$this->retrieve($result);
                   // $rows=$this->arrayFetch($result);
    
                    $options= DB::table('menuoptions')
                    ->where('fieldname', $field)
                    ->where(['user_table' => 'form_'.$sessid])
                    ->get();
                     
                     $output.='<select name="'.str_replace(' ', '.',$field).'" class="form-control" data-plugin-multiselect data-plugin-options=\'{ "maxHeight": 200 }\' id="ms_example1">';
                     
                     foreach($options as $option){
                      $output.='<option>'.$option->option_item.'</option>';
                     }
                      
                      $output.='</select>';
                     
                 }	
                
                
            }
        return $output;	
            }



    public function smsdetail($id)
    {
        $smsdetail= DB::table('sendmsg')->where('id',$id)->first(); 
        return view('users.smsdetail',['smsx'=>$smsdetail]);

    }


    public static function get_list_type($id)
    {
        $listtype= DB::table('lists')->where('id',$id)->first(); 
        
        return $listtype->type;

    }


    public static function get_list_type_brand($id)
    {
        $output="";
        $listtype= DB::table('lists')->where('id',$id)->first(); 
        if($listtype->type=='other'){
            $output=' Anniversary List';
        }
        else if($listtype->type=='phonebook'){
            $output=' Phone Book';
        }
        else{

            $output=' Birthday List';

        }
        
        return $output;

    }

    public function resend(){

        $phone=request()->input('phone');
        $msg=request()->input('message');
        $senderid=request()->input('senderid');
        $id=request()->input('id');

        $response=$this->CURLsendsms($phone,$msg,$senderid);
        DB::table('sendmsg')->where('id', $id)->update([
                    
            'status' => $response
            
        ]);
        return redirect()->back()->withSuccess('SMS re-sent succesfully');     


    }

    public function schedule()
    {
        $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
        return view('users.scheduler',['lists'=>$list]);

    }

    public function smsallcontact($id,$type)
    {
        $list= DB::table('lists')->where('id', $id)->first(); 
        if($type=='other'){

            $contactlistx= DB::table('anniversarylist')->where('listID',$id)->get(); 
            return view('users.smsallcontactsother',['lists'=>$list,'contactlists'=> $contactlistx]);
        }

        if($type=='birthday'){
            $contactlistx= DB::table('contactlist')->where('listID',$id)->get(); 
            return view('users.smsallcontacts',['lists'=>$list,'contactlists'=> $contactlistx]);

        }
        
       
       

    }


    
public function customarrange(){

    $fdata="";
   
    if (Schema::hasColumn('form_'.auth()->user()->id,'fieldord')) {

        $fdata= DB::table('form_'.auth()->user()->id)
        ->orderBy('fieldord','ASC')
        ->get(); 

          }else{


            $fdata= DB::table('form_'.auth()->user()->id)
            ->get();

          }

    
    return view('users.custom_form_arrange',['fields'=>$fdata]);
}


    
public function customarrangeedit(){

    $fdata="";
   
    if (Schema::hasColumn('form_'.auth()->user()->id,'fieldord')) {

        $fdata= DB::table('form_'.auth()->user()->id)
        ->orderBy('fieldord','ASC')
        ->get(); 

          }else{


            $fdata= DB::table('form_'.auth()->user()->id)
            ->get();

          }

    
    return view('users.custom_form_arrange_edit',['fields'=>$fdata]);
}




public function fieldarrange()
{
    
            if(count(request()->all()) > 0){

                $tablename2='form_'.auth()->user()->id;

            

                   

                    $input =request()->all();  
                    $condition = $input['id'];
                    foreach ($condition as $key => $condition) {
                        $insquery="update ".$tablename2." set fieldord='".$input['order'][$key]."' where id='".$input['id'][$key]."'";
                        $insert = DB::insert( $insquery);
       
    
                    }
                
                          


                          return redirect()->back()->withSuccess('Field rearranged sucessful.');
               


            }
}


public function fieldarrangeedit()
{
    
            if(count(request()->all()) > 0){

                $tablename2='form_'.auth()->user()->id;

            

                   

                    $input =request()->all();  
                    $condition = $input['id'];
                    foreach ($condition as $key => $condition) {
                        $insquery="update ".$tablename2." set fieldord='".$input['order'][$key]."' where id='".$input['id'][$key]."'";
                        $insert = DB::insert( $insquery);
       
    
                    }
                
                          


                          return redirect()->back()->withSuccess('Field rearranged sucessful.');
               


            }
}


    public function scheduleList()
    {
        $list= DB::table('lists')
        ->select('lists.id','lists.name','autosend.id','autosend.listID','autosend.created_at','autosend.sendtype')
        ->join('autosend','autosend.listID','=','lists.id')
        ->where(['autosend.userID' => auth()->user()->id])
        ->get();


        $checkprofile= DB::table('users_info')->where('userID', auth()->user()->id)->get(); 
        if($checkprofile->count()<1){

           return view('users.moreinfo');
        }else{
        return view('users.autoscheduleList',['lists'=>$list]);
        }

    }

    public function deactivateauto($id)

    {
        DB::table('autosend_list')->where('listID',$id)->delete();
        DB::table('autosend')->where('listID',$id)->delete();
        //$resources = DB::delete('delete from autosend where id='.$id);
        return redirect()->back()->withSuccess('list deactivated sucessfuly');
          

    }



    public function changesenderid($id){

        if(count(request()->all()) > 0){


            DB::table('autosend_list')->where('listID', $id)->update(['senderID'=>request()->input('senderid')]);

            return redirect()->back()->withSuccess('Sender ID updated succesfully');


        }

    }


    public function changesenderid2($id){

        if(count(request()->all()) > 0){

            

            DB::table('autosend')->where('id', $id)->update(['senderID'=>request()->input('senderid')]);



            DB::table('autosend_list')->where('listID', UserController::getListIdFromAutosend($id))->update(['senderID'=>request()->input('senderid')]);

            return redirect()->back()->withSuccess('Sender ID updated succesfully');


        }

    }

    public function scheduleupdate($id,$id2,$extra)
    {
            if($id2=='single'){

             $list= DB::table('autosend')->where('id',$id)->first(); 
            $contactlist= DB::table('contactlist')->where('listID',UserController::getListIdFromAutosend($id))->get(); 
            return redirect('users/singleupdate/'.$id);
        //return view('users.updateschedule',['list'=>$list,'contactlist'=>$contactlist]);
        
        } 
        if($id2=='multiple'){

            if($extra=="other"){
              $names= DB::table('lists')->where('id',UserController::getListIdFromAutosend($id))->first(); 
               
              $list= DB::table('autosend_list')->where('listID',UserController::getListIdFromAutosend($id))->get(); 
              //$senders= DB::table('autosend_list')->where('listID',UserController::getListIdFromAutosend($id))->first(); 
             return redirect('users/multipleupdate/'.$id);
              // return view('users.list_contacts_other_exit',['contactlists'=>$list,'lists'=>$names,'sender'=>$senders]);
                
            }
else{
            $list= DB::table('autosend_list')->where('listID',UserController::getListIdFromAutosend($id))->get(); 
           // return view('users.updateschedulemultiple',['list'=>$list]);
           return redirect('users/multipleupdate/'.$id);
        }
        }
        if($id2=='phonebook'){

            $auto= DB::table('autosend')->where('id',$id)->first(); 

            $list= DB::table('lists')->where('id',  $auto->listID)->first(); // return view('users.updateschedulemultiple',['list'=>$list]);
           if($list->filter==1){
            $contactlistx= DB::table('phonenamelist')->where('listID', $auto->listID)->get();
            $smsx= DB::table('phone_schedule_sms')->where('listID', $auto->listID)->get();
           
            return view('users.auto_name_phone',['lists'=>$list,'contactlists'=>$contactlistx,'smss'=> $smsx]);
    
           }
           else if($list->filter==2){
            $contactlistx= DB::table('phoneonly')->where('listID', $auto->listID)->first();
            $smsx= DB::table('phone_schedule_sms')->where('listID', $auto->listID)->get();
            return view('users.auto_phone',['lists'=>$list,'contactlists'=>$contactlistx,'smss'=> $smsx]);
        
           }

        }

    }


    public function singleupdate($id)
    {
          

         $list= DB::table('autosend')->where('id',$id)->first(); 
         $contactlist= DB::table('contactlist')->where('listID',UserController::getListIdFromAutosend($id))->get(); 
         $senderids= DB::table('autosend_list')->where('listID',UserController::getListIdFromAutosend($id))->first();
         
       return view('users.updateschedule',['list'=>$list,'contactlist'=>$contactlist,'sendero'=>$senderids]);
        

        

    }

    

    public function multipleupdate($id)
    {
          $listids=UserController::getListIdFromAutosend($id);
        $senderid= DB::table('senderids')->where('userID',auth()->user()->id)->get();
        $senderids= DB::table('autosend_list')->where('listID',UserController::getListIdFromAutosend($id))->first();
         $lists= DB::table('autosend_list')->where('listID',UserController::getListIdFromAutosend($id))->get(); 
        // $contactlist= DB::table('contactlist')->where('listID',UserController::getListIdFromAutosend($id))->get(); 
            
         return view('users.updateschedulemultiple',['lists'=>$lists,'sender'=>$senderid,'listid'=>$listids,'sendero'=>$senderids]);
        

        

    }


    public static function pullsenderid()
    {
          
        $senderids= DB::table('senderids')
        ->where('userID',auth()->user()->id)
        ->where('status',2)
        ->get();
         return $senderids;
        

    }




    public function getListIdFromAutosend($id)
    {
        $list= DB::table('autosend')->where('id',$id)->first(); 
        return $list->listID;

    }


    public function scheduleupdate2($id)
    {
        $validator=$this->validate(request(),[
            
            'message'=>'required|string',
            'time'=>'required|string',
            ],
            [
                  'message.required'=>'.Please enter message you want to send',
                'time.required'=>'.Please choose the time you want the message to be sent',
                  
                
                ]);
                if(count(request()->all()) > 0){

                DB::table('autosend')->where('id', $id)->update([
                    
                  
                    'message' => request()->input('message'),
                    'sendtime' => request()->input('time')
                
                
                ]);

                $auto=DB::table('autosend')->where('id',$id)->first(); 

                DB::table('autosend_list')->where('listID', $auto->listID)->update([
                    
                   
                    'msg' => request()->input('message'),
                    'send_time' => request()->input('time'),
                    'send_timeString' => strtotime(request()->input('time'))
                ]);

                return redirect()->back()->withSuccess('Update sucessful.');
          
                }
          

    }

    public static function listname($id)
    {
        $list= DB::table('lists')->where('id',$id)->first(); 
        return $list->name;
          

    }


    public  function filtermessage(){

if(request()->input('action')==='delete'){



    if(isset($_POST['contacts'])){

        if(is_array($_POST['contacts'])) {
            foreach($_POST['contacts'] as $value){

          
            DB::table('sendmsg')->where('id',$value)->delete();

           


            }

            return redirect()->back()->withSuccess('Message deleted successfuly.');
        }else{

            DB::table('sendmsg')->where('id',$value)->delete();
            return redirect()->back()->withSuccess('Message deleted successfully.');

        }

       
       
   }else{


   return redirect()->back()->withErrors('Please select atleast one message to delete ')->withInput();
 
   }


}else{

        if(empty(request()->input('month')) || empty(request()->input('year'))){

 return redirect()->back()->withErrors('Please select month and year to filter ')->withInput();
        }else{
   $month=request()->input('month');
   $year=request()->input('year');
         
    $msgs= DB::table('sendmsg')
   ->where('month',$month)
   ->where('year',$year)
   ->paginate(10);; 

   return view('users.message_filter',['smss'=>$msgs,'filtermonth'=>$month,'filteryear'=>$year]);
        }
    }
    }



    public function userProfile()
    {
        return view('users.userProfile');
    }

    public function pricing()
    {
        return view('users.price');
    }

    public function updatePassword()
    {
        return view('profile.updatePassword');
    }

    public function createList()
    {

        if(request()->input('type')=='phonebook'){


            $lists = new lists();
            $lists->name=request()->input('title');
            $lists->type=request()->input('type');
            $lists->filter=request()->input('booktype');
            $lists->userID=auth()->user()->id;
            $lists->save();


        }else{

            $lists = new lists();
            $lists->name=request()->input('title');
            $lists->type=request()->input('type');
            $lists->filter="";
            $lists->userID=auth()->user()->id;
            $lists->save();
       
       
        }
 return redirect()->back()->withSuccess('New list created successfully');

    }


    public function createAnniversary()
    {

        $anniversary = new anniversary();
        $anniversary->name=request()->input('name');
        $anniversary->listID=request()->input('listid');
        $anniversary->save();
        return redirect()->back()->withSuccess('Anniversary created successfully');

    }


    public function deleteList($id)
    {

        $resources = DB::delete('delete from lists where id='.$id);
       // $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
        return redirect()->back();

    }

    public function deleteContact($id)
    {

        $resources = DB::delete('delete from contactlist where id='.$id);
       // $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
        return redirect()->back();

    }

    public function deleteContactname($id)
    {

        $resources = DB::delete('delete from phonenamelist where id='.$id);
       // $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
       return redirect()->back()->withSuccess('phone number deleted successfully');
    }


    public static function anniversaryname($id)
    {
        $list= DB::table('anniversary')->where('id',$id)->first(); 
        return $list->name;
          

    }

    public function deleteAnniversary($id,$list)
    {

        
        
        $annlist = DB::delete('delete from anniversarylist where anniversary="'.$this->anniversaryname($id).'" and listID='.$list);
        $ann = DB::delete('delete from anniversary where id='.$id);
        return redirect()->back()->withSuccess('Anniversary deleted successfully');

    }
    
    public function deleteanniversarylist($id)
    {

        $resources = DB::delete('delete from anniversarylist where id='.$id);
        return redirect()->back()->withSuccess('Contact deleted successfully');

    }



    public function deletecontactphone($id)
    {

        $resources = DB::delete('delete from phoneonly where listID='.$id);
        return redirect()->back()->withSuccess('Contact list deleted successfully');

    }


    public static function showvariedImage($number,$list,$message){
$output="";
        $sms= DB::table('sendmsg')
        ->where('phone', $number)
        ->where('listID', $list)
        ->where('message', $message)
        ->first();

        if( $sms->count()<1){
            $output=0;

        }

       else if( $sms->status==0){

        $output=1 ; 
        }

        else if( $sms->status==1){
            $output=2;
            
        }

        return $output;
    }


    public function deleteschedulesms($id)
    {

        $resources = DB::delete('delete from phone_schedule_sms where id='.$id);
        $resources = DB::delete('delete from auto_send_phone_name where autosmsID='.$id);
        return redirect()->back()->withSuccess('SMS deleted successfully');

    }

    public function deletepilot($id)
    {

        $resources = DB::delete('delete from pilots where id='.$id);
        return redirect()->back()->withSuccess('Pilot deleted successfully');

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
         ->where('annmonth',$month)
         ->get();

         return view('users.anniversaryEx',['lists'=>$listsx,'todayanniversary'=>$todayAnn],['tomorrowanniversary'=>$tomorrowAnn,'monthanniversary'=>$monthAnn,'anns'=>$ann,'annids'=>$annid]);
     
    }


    public function listDetail($id,$type)    
    {

        $month=Carbon::now()->format('M');
        $day=Carbon::now()->format('d');
        $tomorrow=Carbon::now()->addHours(24)->format('d');

        $anniversary= DB::table('anniversary')
        ->where('listID', $id)
        ->get(); 

 
         $list= DB::table('lists')
         ->where('userID', auth()->user()->id)
         ->where('id', $id)
         ->first(); 
 
          $contactlist= DB::table('contactlist')
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

        return view('users.listDetail',['lists'=>$list,'birthcount'=>$todayBirth,'tomorrowbirthcount'=>$tomorrowBirth],['contactlists'=>$contactlist]);
      
    }
    if($type=='phonebook'){

        if($list->filter==1){

            $contactlist= DB::table('phonenamelist')->where('listID', $id)->get(); 
        return view('users.name_phone_only',['lists'=>$id,'listsname'=>$list->name,'contactlists'=>$contactlist]);

        }
        else if($list->filter==2){

            $contactlist= DB::table('phoneonly')->where('listID', $id)->get(); 
            $countcontactlist= DB::table('phoneonly')->where('listID', $id)->get(); 
            return view('users.phone_only',['lists'=>$id,'listsname'=>$list->name,'contactlists'=>$contactlist,'countphone'=>$countcontactlist->count()]);

        }

       
      
    }
    else{

        return view('users.otherAnniversary',['lists'=>$list,'anniversaries'=>$anniversary],['contactlists'=>$anniversarylist]);
     



      }
    }


    public function phone_name($id){

       
        $contactlist= DB::table('phonenamelist')->where('listID', $id)->get(); 
        return view('users.name_phone_only',['lists'=>$id,'contactlists'=>$contactlist]);
    }

    public function phone_only($id){

        $phone_only = new phone_only();
        $phone_only->title=request()->input('title');
        $phone_only->numbers=request()->input('numbers');
        $phone_only->listID=$id;
        $phone_only->save();


        return redirect()->back()->withSuccess('Contact list created succesfully');
    }

    public function phone_update($id){

        $upinfo=DB::table('phoneonly')->where('listID',$id)->update(['title' =>request()->input('title'),'numbers'=>request()->input('numbers')]);
        return redirect()->back()->withSuccess('Contact updated successfully');

    }

    public function phone_edit($id){

        $contactlist= DB::table('phoneonly')->where('listID', $id)->get();
        return view('users.edit_phone',['lists'=>$id,'contactlists'=>$contactlist,'listname'=>$this->listname($id)]);

    }



    public function todayBirthday($id)
    {
        $month=Carbon::now()->format('M');
       $day=Carbon::now()->format('d');
       $tomorrow=Carbon::now()->addHours(24)->format('d');

        $list= DB::table('lists')
        ->where('userID', auth()->user()->id)
        ->where('id', $id)
        ->first(); 

         $contactlist= DB::table('contactlist')
         ->where('listID', $id)
         ->where('birthMonth', $month)
         ->where('birthDay', $day)
         ->get();

         
      return view('users.todayBirthday',['lists'=>$list],['contactlists'=>$contactlist]);

    }


    public function tomorrowBirthday($id)
    {

        $month=Carbon::now()->format('M');
        $tomorrow=Carbon::now()->addHours(24)->format('d');

        $list= DB::table('lists')
        ->where('userID', auth()->user()->id)
        ->where('id', $id)
        ->first(); 

         $contactlist=  DB::table('contactlist')
         ->where('listID', $id)
         ->where('birthMonth', $month)
         ->where('birthDay', $tomorrow)
         ->get();

        return view('users.tomorrowBirthday',['lists'=>$list],['contactlists'=>$contactlist]);

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
         
      
         return view('users.todayAnniversary',['lists'=>$list,'contactlists'=>$annlist,'anns'=>$ann,'annids'=>$annid]);

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
         
      
         return view('users.tomorrowAnniversary',['lists'=>$list,'contactlists'=>$annlist,'anns'=>$ann,'annids'=>$annid]);

    }



    public function addContact($id)
    {

        $contactlist = new contactlist();
        $contactlist->firstName=request()->input('firstname');
        $contactlist->lastName=request()->input('lastname');
        $contactlist->birthmonth=request()->input('birthmonth');
        $contactlist->birthday=request()->input('birthday');
        $contactlist->phone=request()->input('phone');
        $contactlist->remarks=request()->input('remark');
        $contactlist->listID=$id;
        $contactlist->save();

        return redirect()->back();
    


    }

    

    public function sentMessages()
    {

       // $list= DB::table('lists')
       // ->where('id', $id)
       // ->first(); 

        $message= DB::table('sendmsg')
       ->where('userID', auth()->user()->id)
       ->orderBy('created_at','desc')
       ->paginate(10); 
       return view('users.sent_messages',['smss'=>$message]);


    }

    public function celebByMonth($id)
    {

        $list= DB::table('lists')
        ->where('userID', auth()->user()->id)
        ->where('id', $id)
        ->first(); 

         $contactlist= DB::table('contactlist')
         ->where('listID', $id)
         ->get(); 
        return view('users.celebrantsByMonths',['lists'=>$list],['contactlists'=>$contactlist]);


    }

    public function anniversaryByMonth($id,$ann,$annid)
    {

        $list= DB::table('lists')
        ->where('userID', auth()->user()->id)
        ->where('id', $id)
        ->first(); 

         $contactlist= DB::table('anniversarylist')
         ->where('listID', $id)
         ->where('anniversary',$ann)
         ->get(); 

       return view('users.anniversaryByMonths',['lists'=>$list,'anns'=>$ann,'annids'=>$annid],['contactlists'=>$contactlist]);


    }

    public static function permonth($listID,$month)
    {

        $listrows= DB::table('contactlist')
        ->where('listID', $listID)
        ->where('birthMonth', $month)
        ->get(); 

        
        return $listrows;


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


    public static function anniversaryCount($anniversary,$list)
    {

        $rows= DB::table('anniversarylist')
        ->where('anniversary', $anniversary)
        ->where('listID', $list)
        ->get(); 

        
        return $rows->count();


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
                            $autosendlist->birthMonthString=strtotime($row->birthMonth);
                            $autosendlist->send_timeString=strtotime(request()->input('time'));
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
                        $autosendlist->birthMonthString=strtotime($row->birthMonth);
                        $autosendlist->send_timeString=strtotime(request()->input('time'));
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









    public function monthExtract($month,$listID)
    {

        $list= DB::table('lists')
        ->where('id', $listID)
       ->first(); 

       $contactlist= DB::table('contactlist')
       ->where('birthMonth', $month)
       ->where('listID', $listID)
        ->get(); 

      
      return view('users.extractMonth',['lists'=>$list,'month'=>$month],['contactlists'=>$contactlist]);


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

    public function smstocontacts3(){

        $validator=$this->validate(request(),[
            'senderid'=>'required|string',
            'message'=>'required|string',
            ],
            [
                'senderid.required'=>'.Please type in name you  want celebrants to see as the sender ',
                'message.required'=>'.Please enter message you want to send',
                  
                
                ]);

                if(count(request()->all()) > 0){

        if(isset($_POST['contacts'])){ 
            

            $input =request()->all();  
            $condition = $input['contacts'];
            foreach ($condition as $key => $condition) {
                
              $response=$this->CURLsendsms($input['contacts'][$key],request()->input('message'),request()->input('senderid'));
              $sentmsg = new sendmsg();
              $sentmsg ->userID=auth()->user()->id;
              $sentmsg ->name=$input['name'][$key];
              $sentmsg ->phone=$input['contacts'][$key];
              $sentmsg ->listID=request()->input('listid');
              $sentmsg ->senderID=request()->input('senderid');
              $sentmsg ->message=request()->input('message');
              $sentmsg ->status=$response;
              $sentmsg ->year=Carbon::now()->format('Y');
              $sentmsg ->month=Carbon::now()->format('M');
              $sentmsg ->day=Carbon::now()->format('d');
              $sentmsg ->time=date('H:i:s');
              $sentmsg ->save();
          
            }

            return redirect()->back()->withSuccess('SMS sent succesfully.');

           // $senderid=request()->input('senderid');
           // $message=request()->input('message');
           // $mobile=$_POST['contacts'];
           // $mobileNumbers= implode('',$mobile);
           // $arr=str_split($mobileNumbers,'12');
           // $numbers=implode(',',$arr);
           // print_r($numbers);
           // echo $message;
           // echo $senderid;
            
       }else{


        return redirect()->back()->withErrors('Please scroll down and check atleast one contact to send message to')->withInput();
       }

       
    }
    }



    public static function CURLsendsms($phone,$message,$senderid){ 
 
         $msg=urlencode(ucwords($message));
		 $url='https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=ZR3eJEIlCdsHh3mcchZy38OX20qNzlpyklN4ZfBTjbNgQZTRZ0yJiwzaOqX2&from='.urlencode($senderid).'&to='.urlencode($phone).'&body='.$msg.'&dnd=2';
         $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		    curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch); 
		
        // $response = json_decode($url, true);
        return $httpCode; 
 

       

    }




    public function smstocontacts2(){

        $validator=$this->validate(request(),[
            'senderid'=>'required|string',
            'message'=>'required|string',
            ],
            [
                'senderid.required'=>'.Please type in name you  want celebrants to see as the sender ',
                'message.required'=>'.Please enter message you want to send',
                  
                
                ]);

                if(count(request()->all()) > 0){

        if(isset($_POST['contacts'])){ 
            
            $senderid=request()->input('senderid');
            $message=request()->input('message');
            $mobile=$_POST['contacts'];
            $mobileNumbers= implode('',$mobile);
            $arr=str_split($mobileNumbers,'12');
            $numbers=implode(',',$arr);
            print_r($numbers);
            echo $message;
            echo $senderid;
            
       }else{


        return redirect()->back()->withErrors('Please scroll down and check atleast one contact to send message to')->withInput();
       }

       
    }
    }


    public function smstocontactsphone(){

        $validator=$this->validate(request(),[
            'senderid'=>'required|string',
            'message'=>'required|string',
            ],
            [
                'senderid.required'=>'.Please type in name you  want celebrants to see as the sender ',
                'message.required'=>'.Please enter message you want to send',
                  
                
                ]);

                if(count(request()->all()) > 0){

        if(isset($_POST['ids'])){ 
            
           // $senderid=request()->input('senderid');
           // $message=request()->input('message');
           // $mobile=$_POST['contacts'];
           
            $numbers = explode(",", request()->input('numbers'));
            foreach($numbers as $number){


                $response=$this->CURLsendsms($number,request()->input('message'),request()->input('senderid'));
                $sentmsg = new sendmsg();
                $sentmsg ->userID=auth()->user()->id;
                $sentmsg ->name=$number;
                $sentmsg ->phone=$number;
                $sentmsg ->listID=request()->input('listid');
                $sentmsg ->senderID=request()->input('senderid');
                $sentmsg ->message=request()->input('message');
                $sentmsg ->status=$response;
                $sentmsg ->year=Carbon::now()->format('Y');
                $sentmsg ->month=Carbon::now()->format('M');
                $sentmsg ->day=Carbon::now()->format('d');
                $sentmsg ->time=date('H:i:s');
                $sentmsg ->save();
            }
            return redirect()->back()->withSuccess('SMS sent successfully.');
            
       }else{


        return redirect()->back()->withErrors('Please scroll down and check the contact list to send SMS to')->withInput();
       }

       
    }
    }


    public function create_contact_list(){

        $fieldsx=DB::table('form_'.auth()->user()->id)->get(); 
        return view('users.create_contact_list',['fields'=> $fieldsx]);

    }

public function create_phone_list(){


    $validator=$this->validate(request(),[
        'listname'=>'required|string',
        ],
        [
            'listname.required'=>'Please ensure you include the name of the contact list',
            
              
            
            ]);

            if(count(request()->all()) > 0){

                $listsid="";

                $names=request()->input('names');
                $phones=request()->input('phones');


    $lists = new lists();
    $lists->name=request()->input('listname');
    $lists->type='phonebook';
    $lists->filter='1';
    $lists->userID=auth()->user()->id;
    $lists->save();

    $listsid=$lists->id;

    $allrecords= DB::table('form_'.auth()->user()->id.'_store')->get();
    foreach($allrecords as $allrecord){

        $phonenamelist = new phonenamelist();
        $phonenamelist->name=$allrecord->$names;
        $phonenamelist->phone=$allrecord->$phones;
        $phonenamelist->listID=$lists->id;
        $phonenamelist->save();


    }

    return redirect('users/list_created/'.$listsid);
            }
    
    

}

public function export() 
    {
        return Excel::download(new ResponseExport, 'userinformation.xlsx');
    }


public function listcreated($id){


    return view('users.done_create_con_list',['list'=>$this->listname($id),'listid'=>$id]);


}

    public function smstocontacts(){

        $validator=$this->validate(request(),[
            'senderid'=>'required|string',
            'message'=>'required|string',
            ],
            [
                'senderid.required'=>'.Please type in name you  want celebrants to see as the sender ',
                'message.required'=>'.Please enter message you want to send',
                  
                
                ]);

                if(count(request()->all()) > 0){

        if(isset($_POST['contacts'])){ 
            
            $senderid=request()->input('senderid');
            $message=request()->input('message');
            $mobile=$_POST['contacts'];
            $mobileNumbers= implode('',$mobile);
            $arr=str_split($mobileNumbers,'12');
            $numbers=implode(',',$arr);
            print_r($numbers);
            echo $message;
            echo $senderid;
            
       }else{


        return redirect()->back()->withErrors('Please scroll down and check atleast one contact to send message to')->withInput();
       }

       
    }
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


public function multiplenamecontact($id)
{
    
$input =request()->all();  
$condition = $input['name'];
foreach ($condition as $key => $condition) {
    $phonenamelist = new phonenamelist();
    $phonenamelist->phone=$input['phone'][$key];
    $phonenamelist->name=$input['name'][$key];
    $phonenamelist->listID=$id;
    $phonenamelist->save();

    }


    return redirect()->back()->withSuccess('Contacts added succesfully.');
        
   
}


public function multipleanniversary($id)
{
    
$input =request()->all();  
$condition = $input['firstname'];
foreach ($condition as $key => $condition) {
    $contactlist = new anniversarylist();
                            $contactlist->firstname=$input['firstname'][$key];
                            $contactlist->lastname=$input['lastname'][$key];
                            $contactlist->annmonth=$input['annmonth'][$key];
                            $contactlist->annday=$input['annday'][$key];
                            $contactlist->contact=$input['phone'][$key];
                            $contactlist->anniversary=$input['anniversary'][$key];
                            $contactlist->listID=$id;
                            $contactlist->save();

    }


    return redirect()->back()->withSuccess('Contacts added succesfully.');
        
   
}

public function autosendtype(Request $request)
{

if($request->input('autotype')=="1"){

    $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
    return view('users.scheduler',['lists'=>$list]);

}
if($request->input('autotype')=="2"){
    $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
    
    return view('users.multiplemessage',['lists'=>$list]);
}

if($request->input('autotype')=="3"){
    $list= DB::table('lists')->where('userID', auth()->user()->id)->get(); 
    
    return view('users.multiplemessage',['lists'=>$list]);
}
        
   
}

public function listcontacts($id,$type)
    {
        $list= DB::table('lists')->where('id', $id)->first(); 
        

        if($type=='birthday'){
            $contactlist= DB::table('contactlist')->where('listID', $id)->get();
           
            return view('users.list_contacts',['lists'=>$list],['contactlists'=>$contactlist]);
        }
        else if($type=='other'){

            $contactlist= DB::table('anniversarylist')->where('listID', $id)->get();
            return view('users.list_contacts_other',['lists'=>$list],['contactlists'=>$contactlist]);
      
        }

        else if($type=='phonebook'){

            // this will display the listname, listid and count of contacts in the list

            if($list->filter==1){
                $contactlistx= DB::table('phonenamelist')->where('listID', $id)->get();
                $smsx= DB::table('phone_schedule_sms')->where('listID', $id)->get();
               
                return view('users.auto_name_phone',['lists'=>$list,'contactlists'=>$contactlistx,'smss'=> $smsx]);
        

            }
           else if($list->filter==2){

            $contactlistx= DB::table('phoneonly')->where('listID', $id)->first();
            $smsx= DB::table('phone_schedule_sms')->where('listID', $id)->get();
            return view('users.auto_phone',['lists'=>$list,'contactlists'=>$contactlistx,'smss'=> $smsx]);
        
                
            }

      
        }
       
    }


    public function nameschedulesms($id){

        

        $sendtime=request()->input('sendTime')." ".request()->input('sendPeriod');

        $updatepsms=DB::table('phone_schedule_sms')->where('id',request()->input('smsid'))->update(['senderID' =>request()->input('senderid'), 'sendDate' => request()->input('sendDate'),'sendTime' => $sendtime, 'sendDateString' => strtotime(request()->input('sendDate')),'sendTimeString' => strtotime($sendtime),'sms' => request()->input('message')]);
        $updatepsms2=DB::table('auto_send_phone_name')->where('autosmsID',request()->input('smsid'))->update(['senderID' =>request()->input('senderid'), 'sendDate' => request()->input('sendDate'),'sendTime' => $sendtime, 'sendDateString' => strtotime(request()->input('sendDate')),'sendTimeString' => strtotime($sendtime),'sms' => request()->input('message')]);
       
        return redirect()->back()->withSuccess('Update sucessful');

    }


    public function schedulesms2($id){

        $lastid="";
        $send= DB::table('autosend')
        ->where('userID', auth()->user()->id)
        ->where('listID', $id)
        ->get(); 


        $sms= new phone_schedule_sms();
    $sms->senderID=request()->input('senderid');
    $sms->sendDate=request()->input('sendDate');
    $sms->sendTime=request()->input('sendTime').request()->input('sendPeriod');
    $sms->sendDateString=strtotime(request()->input('sendDate'));
    $sms->sendTimeString=strtotime(request()->input('sendTime').request()->input('sendPeriod'));
    $sms->sms=request()->input('message');
    $sms->listID=$id;
    $sms->status=0;
    $sms->save();

    $lastid=$sms->id;


        $phonenames= DB::table('phoneonly')
        ->where('listID', $id)
        ->first(); 
        
        foreach(explode(',', $phonenames->numbers) as $phonename){


        $sms= new auto_send_phone_name();
        $sms->senderID=request()->input('senderid');
        $sms->sendDate=request()->input('sendDate');
        $sms->sendTime=request()->input('sendTime').request()->input('sendPeriod');
        $sms->sendDateString=strtotime(request()->input('sendDate'));
        $sms->sendTimeString=strtotime(request()->input('sendTime').request()->input('sendPeriod'));
        $sms->sms=request()->input('message');
        $sms->name=$phonename;
        $sms->phone=$phonename;
        $sms->listID=$id;
        $sms->userID=auth()->user()->id;
        $sms->autosmsID=$lastid;
        $sms->save();

    }

    

if($send->count()<1){
        $autosend = new autosend();
        $autosend->userID=auth()->user()->id;
        $autosend->listID=$id;
        $autosend->senderID=request()->input('senderid');
        $autosend->message="message";
        $autosend->sendtime=request()->input('sendTime').request()->input('sendPeriod');
        $autosend->sendtype='phonebook';
        $autosend->save();
}
        return redirect()->back()->withSuccess('SMS Scheduled successfully');

    }



    public function schedulesms($id){

        $lastid="";
        $send= DB::table('autosend')
        ->where('userID', auth()->user()->id)
        ->where('listID', $id)
        ->get(); 


        $sms= new phone_schedule_sms();
    $sms->senderID=request()->input('senderid');
    $sms->sendDate=request()->input('sendDate');
    $sms->sendTime=request()->input('sendTime').request()->input('sendPeriod');
    $sms->sendDateString=strtotime(request()->input('sendDate'));
    $sms->sendTimeString=strtotime(request()->input('sendTime').request()->input('sendPeriod'));
    $sms->sms=request()->input('message');
    $sms->listID=$id;
    $sms->status=0;
    $sms->save();

    $lastid=$sms->id;


        $phonenames= DB::table('phonenamelist')
        ->where('listID', $id)
        ->get(); 
        
        foreach($phonenames as $phonename){


        $sms= new auto_send_phone_name();
        $sms->senderID=request()->input('senderid');
        $sms->sendDate=request()->input('sendDate');
        $sms->sendTime=request()->input('sendTime').request()->input('sendPeriod');
        $sms->sendDateString=strtotime(request()->input('sendDate'));
        $sms->sendTimeString=strtotime(request()->input('sendTime').request()->input('sendPeriod'));
        $sms->sms=request()->input('message');
        $sms->name=$phonename->name;
        $sms->phone=$phonename->phone;
        $sms->listID=$id;
        $sms->userID=auth()->user()->id;
        $sms->autosmsID=$lastid;
        $sms->save();

    }

    

if($send->count()<1){
        $autosend = new autosend();
        $autosend->userID=auth()->user()->id;
        $autosend->listID=$id;
        $autosend->senderID=request()->input('senderid');
        $autosend->message="message";
        $autosend->sendtime=request()->input('sendTime').request()->input('sendPeriod');
        $autosend->sendtype='phonebook';
        $autosend->save();
}
        return redirect()->back()->withSuccess('SMS Scheduled successfully');

    }


    public static function smsstatus($id,$date,$stime){
        $output="";
        $list= DB::table('phone_schedule_sms')->where('id', $id)->first(); 
        $time=$date." ".$stime;
        $todayTime=date("Y-m-d H:m");

        $strtime=strtotime($time);
        $strtimetoday=strtotime($todayTime);

        $date = new DateTime($date);
        $now = new DateTime();
       
      if($strtime>$strtimetoday && $list->status==0){
        $output=0;

      }
      if($list->status==1){

        $output=1;
    }

    if($strtime<$strtimetoday && $list->status==0){

        $output=2;
    }

    return  $output; 
    }
   
    public static function pullcontact($id)
 {
    
    $contact= DB::table('contactlist')->where('id', $id)->first(); 
    return response()->json($contact);
        
   
 }

 public static function pullsms($id)
 {
    
    $auto= DB::table('phone_schedule_sms')->where('id', $id)->first(); 
    return response()->json($auto);
        
   
 }

 public static function  pullanniversary($id)
 {
    
    $contact= DB::table('anniversarylist')->where('id', $id)->first(); 
    return response()->json($contact);
        
   
 }

 public static function listAnniversary($id)
 {
    
    $anns= DB::table('anniversary')->where('listID', $id)->get(); 
    return $anns;
        
   
 }

 
 public static function states()
 {
    
    $states= DB::table('states')->get(); 
    foreach($states as $state){

echo '<option>'. $state->states_name.'</option>';

    }
    
        
   
 }

 public static function states2()
 {
    $output="";
    $states= DB::table('states')->get(); 
    foreach($states as $state){

        $output.='<option value="'.$state->states_id.'">'. $state->states_name.'</option>';

    }
    
   return $output;     
   
 }


 public function get_state_name($id){
        
$output='';

$states= DB::table('states')->where('state_id', $id)
->get(); 
foreach($states as $state){

    $output.= $state->states_name;

}

    
    return $output;
}  


public static function fieldValue($value,$value2){

return $value->$value2;
}



 public function submitinfo()
 {
   
    $validator=$this->validate(request(),[
        'phone'=>'required|string',
        'country'=>'required|string',
        'usage'=>'required|string',
        'state'=>'required|string',
        ],
        [
            'phone.required'=>'Enter your mobile numbber ',
            'country.required'=>'Enter your country',
            'state.required'=>'Choose your state',
            'usage.required'=>'Select the type of usage',
              
            
            ]);

            if(count(request()->all()) > 0){

                $user_info = new user_info();
                $user_info->userID=auth()->user()->id;
                $user_info->name=request()->input('name');
                $user_info->email=request()->input('email');
                $user_info->phone=request()->input('phone');
                $user_info->country=request()->input('country');
                $user_info->state=request()->input('state');
                $user_info->usage_type=request()->input('usage');
                $user_info->save();
                return redirect()->back()->withSuccess('Thanks for completing your account registration');

            } 
        
   
 }

 public function  profilesubmit()
 {
   
    $validator=$this->validate(request(),[
        'name'=>'required|string',
        'email'=>'required|string',
        'phone'=>'required|string',
        'state'=>'required|string',
        ],
        [
            'name.required'=>'Enter your name ',
            'email.required'=>'Enter your email',
            'phone.required'=>'Enter your phone',
            'state.required'=>'Select your state',
              
            
            ]);

            if(count(request()->all()) > 0){

                $updateprofile=DB::table('users_info')->where('userID',auth()->user()->id)->update(['name' =>request()->input('name'), 'email' => request()->input('email'),'phone' => request()->input('phone'),'country' => request()->input('country'),'state' =>request()->input('state'),'usage_type' => request()->input('usage')]);
    
               return redirect()->back()->withSuccess('Profile Updated successfully');

            } 
        
   
 }



 public static function pulllistdetail($id)
 {
    
    $list= DB::table('lists')->where('id', $id)->first(); 
    return response()->json($list);
        
   
 }


 public static function pulllfielddetail($id)
 {
    
    $field= DB::table('form_'.auth()->user()->id)->where('id', $id)->first(); 
    return response()->json($field);
        
   
 }

 public static function submitconfirmsms($id)
 {
    
    $field= DB::table('form_'.auth()->user()->id)->where('id', $id)->first(); 
    return response()->json($field);
        
   
 }


 public static function editfielddetail($id){

    $fields= DB::table('form_'.auth()->user()->id)->where('id', $id)->first();
    return view('users.edit_field',['field'=>$fields]); 


 }

 public function updatecomfirmsms(Request $request)
 {
     $output="";  
      $sms=DB::table('sms_for_phone')->where('form','form_'.auth()->user()->id)->update(['sms' =>$request->message, 'senderID' => $request->senderid]);
              
     //$insquery="update sms_for_phone set sms='".$request->message."', senderID ='".$request->senderid."' where form='form_'".auth()->user()->id."'";
     // DB::insert( $insquery);
     
     $output='success';
     echo $output;
 }


 public function submitcomfirmsms(Request $request)
 {
     $output="";
     //$departments=DB::table('sms_for_phone')->where('id',$request->id)->update(['firstName' =>$request->firstname, 'lastName' => $request->lastname,'phone' => $request->phone,'remarks' => $request->remark,'birthMonth' => $request->month,'birthDay' => $request->day]);
                
     $insquery="insert into sms_for_phone (id,sms,form,userID,senderID,send_status) values(NULL,'".$request->message."','form_".auth()->user()->id."','".auth()->user()->id."','".$request->senderid."','1')";
     $insert = DB::insert( $insquery);
     
     $output='success';
     echo $output;
 }

 public function submitcontactupdate(Request $request)
 {
     $output="";
     $departments=DB::table('contactlist')->where('id',$request->id)->update(['firstName' =>$request->firstname, 'lastName' => $request->lastname,'phone' => $request->phone,'remarks' => $request->remark,'birthMonth' => $request->month,'birthDay' => $request->day]);
                
     $output='success';
     echo $output;
 }


 public function submitanniversaryupdate(Request $request)
 {
     $output="";
     $departments=DB::table('anniversarylist')->where('id',$request->id)->update(['firstname' =>$request->firstname, 'lastname' => $request->lastname,'contact' => $request->phone,'anniversary' => $request->anniversary,'annmonth' => $request->month,'annday' => $request->day]);
                
     $output='success';
     echo $output;
 }

 public function submitlistupdate(Request $request)
 {
     $output="";
     $departments=DB::table('lists')->where('id',$request->id)->update(['name' =>$request->title,'type' => $request->type]);
                
     $output='success';
     echo $output;
 }


 


 public function fileupload(){

    $validator=$this->validate(request(),[
            'file' => 'required|mimes:csv,txt',        
        ],
        [
           'file.required'=>'Please Upload excel file of csv format ',
            
            
            ]);


         if(count(request()->all()) > 0){

           
           
            $id=request()->input('listId');
        
            

             //////////// create data //////////////////////

            

             Excel::import(new contactlists($id),request()->file('file'));
           

             return redirect()->back()->withSuccess('Contact uploaded sucessfully');
           
           

         }




}



public function fileuploadname(){

    $validator=$this->validate(request(),[
            'file' => 'required|mimes:csv,txt',        
        ],
        [
           'file.required'=>'Please Upload excel file of csv format ',
            
            
            ]);


         if(count(request()->all()) > 0){

           
           
            $id=request()->input('listId');
        
            

             //////////// create data //////////////////////

            

             Excel::import(new phonelistname($id),request()->file('file'));
           

             return redirect()->back()->withSuccess('Contact uploaded sucessfully');
           
           

         }




}

 

 public function download($file_name,$path) {
    $file_path = public_path($path.'/'.$file_name);
    return response()->download($file_path);
  }


 public static function showoptions($id)
    {
        $count=0;
        $list= DB::table('autosend')->where('listID', $id)->get(); 
        $count= $list->count();
        return $count;
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


    public function multipleprocessmsgedit($id){



        $input =request()->all();  
        $condition = $input['contactid'];
        foreach ($condition as $key => $condition) {
           
           
            DB::table('autosend_list')->where('id',$input['contactid'][$key])->update(['msg' =>$input['msg'][$key], 'send_time' =>$input['sendtime'][$key],'senderID' =>$input['senderid']]);
       

        
            }

           
        
           
            return redirect()->back()->withSuccess('Infomation updated succesfully.');

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
            $autosendlist->birthMonthString=strtotime($input['birthmonth'][$key]);
            $autosendlist->send_timeString=strtotime($input['sendtime'][$key]);
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
        
           
            return redirect('users/done_list/'.$id);

    }


  


    
}
