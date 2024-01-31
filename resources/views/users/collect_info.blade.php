<?php   use \App\Http\Controllers\UserController; ?>
@extends('layouts.userint')
@section('title')
    <title> User | Collect Information  </title>
@endsection

<?php $senderids= UserController::pullsenderid();?>

@section('content')



                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">User</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> Collect Information<i data-feather="chevron-right" class="breadcrumb__icon"></i><a href="" class="breadcrumb--active"> Form list </div>
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Search -->
                   
                    <!-- END: Search -->
                    <!-- BEGIN: Notifications -->
                 
                    <!-- END: Notifications -->
                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8 relative">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                         </div>
                        <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                            <div class="dropdown-box__content box bg-theme-38 text-white">
                                <div class="p-4 border-b border-theme-40">
                                    <div class="font-medium"> {{ ucwords(Auth::user()->name) }}</div>
                                    <div class="text-xs text-theme-41">Manage Account</div>
                                 </div>
                              
                                 <div class="p-2">
                                    <a href="/user/profile" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile</a>
                                    <a href="/user/updatePassword" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Update Password</a>
                               
                                </div>
                                <div class="p-2 border-t border-theme-40">
                                
                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->
               
              
<br/>
       <?php if($filter==0){?>   
<table width="100%">
<tr>
<td width="20%">  
<a href="/users/create_form"  class="button w-45 mr-2 mb-2 flex items-center justify-center bg-theme-9 text-white"> <i data-feather="file-plus" class="w-4 h-4 mr-2"></i>Create Form </a>  



      
       </td>
                            <td style="float:right"> <div class="clockContainer" style="font-size:15px">

                             </td>
</tr>

                     </table>  

                     <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-17 text-theme-11">
Create a form interface to collect customers/clients details from the web. A customized alert message is sent to customers on submition of form.
</div>
                     
                     <?php }?>
                     
                     @if(session('success'))
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9"> 
{{session('success')}}
    </div>
@endif

   
<?php if($filter==1){?>
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-5 text-theme-4">
<table>
    <tr><td colspan="2" style="color:#003366;font-size:16px">
    <b>Hi,</b><br/><br/>
    You started the process of form creation already. Complete the other steps to finish. Click the Continue button to continue the process or click 'Cancel' to cancel the process
</td></tr>
<tr>
<td> 
    <br/>
  <table>
<tr>
    <td>
<a href="/users/create_form_stp2" value="activate" class="button box bg-theme-1 text-white mr-2 flex items-center  ml-auto sm:ml-0" >
 Continue </a></td>
                            <td> <a id="deleteUser{{ Auth::user()->id}}" data-userid="{{Auth::user()->id}}" href="javascript:void(0)" onclick="showAlertfrm({{ Auth::user()->id}});"  class="button box bg-theme-6 text-white mr-2 flex items-center  ml-auto sm:ml-0" >
                             Cancel form </a>
</td>
</tr>

  </table>  

</td>
</tr>

                     </table> 
</div>







<?php }?>


     <div class="grid grid-cols-12 gap-6 mt-5">

     

               
                       
                   
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <?php if($filter==2){?>
                    <div class="intro-y datatable-wrapper box p-5 mt-5">


                    @foreach($datas as $data)
                    <form  action="" method="POST">
{{ csrf_field() }} 
                                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                                    <h2 class="font-medium text-base mr-auto">
                                        Entry Interface
                                    </h2>
                                    <div class="dropdown relative ml-auto sm:hidden">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal w-5 h-5 text-gray-700"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg> </a>
                                        <div class="dropdown-box mt-5 absolute w-40 top-0 right-0 z-20">
                                            <div class="dropdown-box__content box p-2">
                                            <a href="/users/collect_information" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"><i data-feather="chevron-left" class="w-6 h-6 mr-2"></i> Go Back </a> 
                                            
                                          
                                            
                                                <a href="/users/exportresponse" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="external-link" class="w-6 h-6 mr-2"></i> Export to Excel </a>
                                                <a href="/users/create_contact_list" class="flex items-center p-2 transition duration-300 ease-in-out bg-white  hover:bg-gray-200 rounded-md"><i data-feather="folder-plus" class="w-6 h-6 mr-2"></i>  Create Phonebook </a>
                                                
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <a href="/users/response/" target="blank" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="user-check" class="w-6 h-6 mr-2"></i> User Response</a>
                              
                                    <span style="padding-left:10px">
                                    <a href="/form/{{ str_replace(' ', '-',$data->company_name)}}/{{Auth::user()->id}}/{{ str_replace(' ', '-',$data->title)}}" target="blank" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="globe" class="w-6 h-6 mr-2"></i> View Live </a>


                                </span>

                                <span style="padding-left:10px">
                                <a  id="deleteUser{{ Auth::user()->id}}" data-userid="{{Auth::user()->id}}" href="javascript:void(0)" onclick="showAlertSMS({{ Auth::user()->id}});"  class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="mail" class="w-6 h-6 mr-2"></i> Comfirmation Text </a>


                                </span>

                                   <span style="padding-left:10px">
                                        <a href="/users/create_form_edit" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="edit" class="w-6 h-6 mr-2"></i> Edit form information </a>
</span>
<span style="padding-left:10px">
                                    <a  id="deleteUser{{ Auth::user()->id}}" data-userid="{{Auth::user()->id}}" href="javascript:void(0)" onclick="showAlertfrm({{ Auth::user()->id}});"  class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="trash-2" class="w-6 h-6 mr-2"></i> Delete </a>
</span>

                                </div>
                                <div class="datatable-wrapper box p-5 ">

                              


                                <div class="px-5">
                                        <div class="flex flex-col lg:flex-row items-center pb-5">
                                            <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200">
                                                <div class="sm:mr-5">
                                                    <div class="w-20 h-20 image-fit">
                                                        <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{ asset($data->logo) }}">
                                                    </div>
                                                </div>
                                                <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                    <a href="" class="font-medium text-lg"><?php echo ucfirst($data->title); ?></a> 
                                                    <div class="text-gray-600 mt-1 sm:mt-0"><?php echo substr(ucfirst($data->note), 0,120) ?>...</div>
                                                </div>
                                            </div>
                                            <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200">
                                                <div class="text-center rounded-md w-20 py-3">
                                                    <div class="font-semibold text-theme-1 text-lg">30</div>
                                                    <div class="text-gray-600">Views</div>
                                                </div>
                                                <div class="text-center rounded-md w-20 py-3">
                                                    <div class="font-semibold text-theme-1 text-lg">50k</div>
                                                    <div class="text-gray-600">Entries</div>
                                                </div>
                                                <div class="text-center rounded-md w-20 py-3">



                                               
     <div class="mt-2"> 
     <?php foreach($forms as $fm){ ?>
     <input type="checkbox" onclick="switchsms();" class="input input--switch border" <?php if($fm->send_status==1){ echo 'checked';} ?> />
     <?php } ?> 
    
    </div>
 

                                                     <div class="text-gray-600">SMS</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 pt-5">
                                            <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 pb-5 sm:pb-0">
                                                <div class="px-3 py-2 bg-theme-14 text-theme-10 rounded font-medium mr-3">{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</div>
                                                <div class="text-gray-600">Time of Release</div>
                                            </div>
                                           
                                        </div>
                                    </div>



                   
                   
                    </div>

                    @endforeach 
                             </form> 

                    


                  


                   
                    </div>


                   




                                 

                    <?php }?>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->




                <div class="modal" id="header-footer-modal-preview2">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">Autosend Type </h2> 
             
         </div>

         
         <form  action="autosendtype" method="GET" >
         {{ csrf_field() }} 
         
         <div class="p-5 "> <label><b>Choose how you want  to autosend wishes to your contacts</b></label>
     <div class="flex items-center text-gray-700 mt-2"> <input name="autotype" type="radio" class="input border mr-2" id="vertical-radio-chris-evans" name="vertical_radio_button" value="1" required> <label class="cursor-pointer select-none" for="vertical-radio-chris-evans">Send same message to all my contacts</label> </div>
     <div class="flex items-center text-gray-700 mt-2"> <input name="autotype" type="radio" class="input border mr-2" id="vertical-radio-liam-neeson" name="vertical_radio_button" value="2" required> <label class="cursor-pointer select-none" for="vertical-radio-liam-neeson">Send different messages to my contacts</label> </div>
  </div>
        
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="submit" class="button w-20 bg-theme-1 text-white">Continue</button> </div>
    </form>  </div>
 </div>


                <form action="" method="post" >
                <div class="modal" id="delete-confirmation-modal">

               {{ csrf_field() }}

                    <div class="modal__content">
                        <div class="p-5 text-center">
                            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> 
                            <div class="text-3xl mt-5">sure you want to deactivate this list?</div>
                            <div class="text-gray-600 mt-2">Do you really want to deactivate these records? This process cannot be undone.</div>
                            <input type="hidden", name="id" id="app_id">
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                            <button type="submit" class="button w-24 bg-theme-6 text-white" onclick="senddel();" >Deactivate</button>
                        </div>
                    </div>
                </div>
                </form>
                <!-- END: Delete Confirmation Modal -->


                <form action="" method="post" >
                <div class="modal" id="delete-confirmation-modal2">

               {{ csrf_field() }}

                    <div class="modal__content">
                        <div class="p-5 text-center">
                            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> 
                           
                            <div class="text-gray-600 mt-2">Do you really want to delete these form? This process cannot be undone. All data regarding this form will be removed totally</div>
                            <input type="hidden", name="id" id="app_id">
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                            <button type="submit" class="button w-24 bg-theme-6 text-white" onclick="senddel();" >Delete</button>
                        </div>
                    </div>
                </div>
                </form>



                <div class="modal" id="medium-modal-size-preview">
     <div class="modal__content p-10 "> 



        
              
                
                <?php if($forms->count()>0){
                 
                 foreach($forms as $form){
                 ?>

<form  method="POST" action="" id="myForm2"> 
     
                {{ method_field("PUT")}}
                {{ csrf_field() }}
<h2 class="font-medium text-base mr-auto">Edit confirmation message</h2>
                
                <br/>
           <div class="col-span-12 sm:col-span-12"><label><b>Sender ID</b></label> 
              <input name="listid" type="hidden"  value="{{ Auth::user()->id }}">
             <select id="senderid2" name="senderid" class="input w-full border mt-2 flex-1 bg-gray-200" required>
@foreach($senderids as  $senderid)

<option value="{{ $senderid->name }}">{{ $senderid->name }}</option>
@endforeach
<option value="{{ $form->senderID }}"><?php echo $form->senderID;  ?></option>
</select>
             
            </div>





 

             <div class="news__input relative mt-5"> 
                            <label><b>Message</b></label> <br/>
                            <span><i>This message will be sent as SMS to people who submit this form</i></span>
                                             <textarea required id="message2" name="message" class="input w-full bg-gray-200 pl-5 py-6 mt-2 placeholder-theme-13 resize-none" rows="1" placeholder="Type in SMS here..." onkeydown="limitText(this.form.message,this.form.countdown,160);" onkeyup='limitText(this.form.message,this.form.countdown,160);'><?php echo $form->sms;  ?></textarea>
                        </div>
                        <br/>
                        <span id="errormsg2" style="color:red"></span>
                        <span id="processing" style="color:green"></span>
        <br/><br/>
        <div class="intro-y  datatable-wrapper box p-5" style="float:right">
        You have
        <input readonly type="text" name="countdown" size="3" value="160"> chars left

</div>


                          
        <br/><br/>



        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                       
                        
                       <a href="javascript:void(0);" onclick="updateMessage();"  class="button box bg-theme-9 text-white mr-2 flex items-center  ml-auto sm:ml-0">
                        Update </a>
      
                   
                   </div>
    
            </form>
            
            <?php

            
            
              } }
            
            else{?>
 <form action="" method="POST" id="myForm">
 {{ csrf_field() }}
<h2 class="font-medium text-base mr-auto">Send Confirmation Alert</h2>
     <br/>
         <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-14 text-theme-10"> Send a comfirmation SMS to users who fill your form to acknowledge that you have recieved their information. </div>
   
               
            
           <br/>

                <div id="booktype" class="col-span-12 sm:col-span-12"> <label>Do you want your form to send a confirmation SMS on submittion?</label>
     <div class="flex flex-col sm:flex-row mt-3">
         <div class="flex items-center text-gray-700 mr-2"> <input type="radio" class="input border mr-2" id="question" name="question" value="no"> <label class="cursor-pointer select-none" for="horizontal-radio-chris-evans">No</label> </div>
         <div class="flex items-center text-gray-700 mr-2 mt-2 sm:mt-0"> <input type="radio" class="input border mr-2" id="question" name="question" value="yes"> <label class="cursor-pointer select-none" for="horizontal-radio-liam-neeson">Yes</label> </div>
      </div>
 </div>

 


 

            
        <br/><br/>






        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                       
                        
                       <a href="javascript:void(0);" onclick="showconfirmSMS()" class="button box bg-theme-9 text-white mr-2 flex items-center  ml-auto sm:ml-0">
                        Continue </a>
      
                   
                   </div>
    <?php }?>
    

</form>

    
    
    </div>
 </div>



 <div class="modal" id="medium-modal-size-preview2">
     <div class="modal__content p-10 "> 
     <h2 class="font-medium text-base mr-auto">Message</h2>
     <br/>
     <form action="" method="POST" >
                {{ csrf_field() }}
                
              
               
            
            
           <br/>
           <div class="col-span-12 sm:col-span-12"><label><b>Sender ID</b></label> 
              <input name="listid" type="hidden"  value="{{ Auth::user()->id }}">
             <select id="senderid" name="senderid" class="input w-full border mt-2 flex-1 bg-gray-200" required>
@foreach( $senderids as  $senderid)
<option value="{{ $senderid->name }}">{{ $senderid->name }}</option>
@endforeach
</select>
             
            </div>





 

             <div class="news__input relative mt-5"> 
                            <label><b>Message</b></label> <br/>
                            <span>This message will be sent as SMS to people who submit this form</span>
                                             <textarea required id="message" name="message" class="input w-full bg-gray-200 pl-16 py-6 mt-2 placeholder-theme-13 resize-none" rows="1" placeholder="Type in SMS here..." onkeydown="limitText(this.form.message,this.form.countdown,160);" onkeyup='limitText(this.form.message,this.form.countdown,160);'>{{ old('message') }}</textarea>
                        </div>
                        <br/>
                        <span id="errormsg" style="color:red"></span>
                        <span id="processing" style="color:green"></span>
        <br/><br/>
        <div class="intro-y  datatable-wrapper box p-5" style="float:right">
        You have
        <input readonly type="text" name="countdown" size="3" value="160"> chars left

</div>


                          
        <br/><br/>



        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                       
                        
                       <a href="javascript:void(0);" onclick="submitMessage();"  class="button box bg-theme-9 text-white mr-2 flex items-center  ml-auto sm:ml-0">
                        Submit </a>
      
                   
                   </div>
    
    



</form>

    



    
    </div>
 </div>
          
 
 <div class="modal" id="delete-confirmation-modal5">

{{ csrf_field() }}

     <div class="modal__content">
         <div class="p-5 text-center">
             <i data-feather="mail" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i> 
            
             <div class="text-gray-600 mt-2">Form comfirmation message Saved</div>
            
         </div>
         <div class="px-5 pb-8 text-center">
             <a href="" class="button w-24 inline-block mr-1 mb-2 border text-gray-700"  >Okay</a>
         </div>
     </div>
 </div>

 <div class="modal" id="delete-confirmation-modal6">

{{ csrf_field() }}

     <div class="modal__content">
         <div class="p-5 text-center">
             <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i> 
            
             <div class="text-gray-600 mt-2">Confirmation message updated</div>
            
         </div>
         <div class="px-5 pb-8 text-center">
             <a href="" class="button w-24 inline-block mr-1 mb-2 border text-gray-700"  >Okay</a>
         </div>
     </div>
 </div>
            
@endsection

<script>


function showconfirmSMS(){

    if($('input[name=question]:checked', '#myForm').val()=='no'){

        $('#medium-modal-size-preview').modal('hide'); 
    }
    else if($('input[name=question]:checked', '#myForm').val()=='yes'){
        $('#medium-modal-size-preview').modal('hide'); 
 $('#medium-modal-size-preview2').modal('show');

}
}


function updateMessage(){

if($('#message2').val()==''){

    $('#errormsg2').text('Please enter message!')
}else{
    $('#errormsg2').hide();

    var senderid=$('#senderid2').val(); 
    var message=$('#message2').val();
 var _token = $('input[name="_token"]').val();

 $.ajax({
    url:'/users/updateconfirmsms',
       method:'POST',
       data: {
         senderid:senderid,message:message,_token:_token
       },
       success:function(result){

$('#delete-confirmation-modal6').modal('show'); 
$('#medium-modal-size-preview').modal('hide');
        


       }});
   


}

}


function submitMessage(){

    if($('#message').val()==''){

        $('#errormsg').text('Please enter message!')
    }else{
        $('#errormsg').hide()

        var senderid=$('#senderid').val(); 
        var message=$('#message').val();
     var _token = $('input[name="_token"]').val();

     $.ajax({
        url:'/users/addconfirmsms',
           method:'POST',
           data: {
             senderid:senderid,message:message,_token:_token
           },
           
           success:function(result){

             
$('#medium-modal-size-preview2').modal('hide');
$('#delete-confirmation-modal5').modal('show');         


           }});
       


    }

}

function showAlertfrm(id){
    var formid=id;
    var userID=$('#deleteUser'+formid).attr('data-userid');
    $('#app_id').val(userID); 
   $('#delete-confirmation-modal2').modal('show'); 
   
}

function showAlertSMS(id){
    var formid=id;
    var userID=$('#deleteUser'+formid).attr('data-userid');
    $('#app_id').val(userID); 
   $('#medium-modal-size-preview').modal('show'); 
   
}

function senddel(){
    
    window.location="/users/form/delete";
   
}


function limitText(limitField, limitCount, limitNum) {
          if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
          } else {
            limitCount.value = limitNum - limitField.value.length;
          }
        }


        function switchsms(){

            alert('uerhiu');
        }

</script>
