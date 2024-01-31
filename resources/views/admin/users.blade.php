@extends('layouts.adminint')
<?php   use \App\Http\Controllers\AdminController; ?>
@section('title')
    <title> Admin | Users  </title>
@endsection
@section('content')



                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Admin</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Accounts</a> </div>
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
                       
                    </div>
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->

                
@if($errors->any())
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6"> 
    
   
        <Ol>
      <li>  {{$errors->first()}}</li>
        </Ol>
    </div>

@endif

                @if(session('success'))
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9"> 
{{session('success')}}
    </div>
@endif

                <h2 class="intro-y text-lg font-medium mt-10">
                   All Accounts
                </h2>

               <br/> 
               <form action="perform-action" method="POST">
                   {{ csrf_field() }}
<table>
<tr>

<td>
                                  
                                  

<a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview2" class="button w-45 mr-2 flex items-center justify-center bg-theme-9 text-white"> <i data-feather="key" class="w-4 h-4 mr-2"></i> New Account </a>             
</td>       
                        
                        <td >  <div class="mt-0">
                            
                        </div>
</td>



<td>
         
       </td>

                          
                   
</tr>

                     </table>                    
<div class="grid grid-cols-12 gap-6 mt-1">

               
                       
                   
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5 mt-5">
                        
                    <table class="table table-report table-report--bordered display datatable w-full" style="font-size:14px;">
                        <thead>
                            <tr>
                          
                          
                                <th class="border-b-2 whitespace-no-wrap">NAME</th>
                                <th class="border-b-2 whitespace-no-wrap">EMAIL</th>
                               
                                <th class="border-b-2 whitespace-no-wrap">DATE CREATED</th>
                                <th class="border-b-2 whitespace-no-wrap">ACTION</th>
                               
                               
                               
                               
                              
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user) 
                            <tr>
                           
                           
                                <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ucwords($user->name)}}</div>
                                  
                                </td>
                                <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{$user->email}}</div>
                                  
                                </td>
                               
                                <td class="w-40 border-b">
                                {{$user->created_at}}
                                 </td>

            
                              
                                
                               

                                <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                                            
                                 <a class="button button--sm w-8 mr-1 mb-2 bg-theme-7 text-white" id="deleteUser{{ $user->id}}" data-userid="{{$user->id}}" href="javascript:void(0)" onclick="showEditBox({{$user->id}});" > <i data-feather="edit" class="w-4 h-4 mr-1"></i></a>
                                   
                                    <a class="button button--sm w-8 mr-1 mb-2 bg-theme-6 text-white" id="deleteUser{{ $user->id}}" data-userid="{{$user->id}}" href="javascript:void(0)" onclick="showAlert({{$user->id}});" > <i data-feather="trash-2" class="w-4 h-4 mr-1"></i></a>
                                   
                                  
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                          
                        </tbody>
                    </table>
</form>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->




                <div class="modal" id="header-footer-modal-preview2">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">New Account</h2> 
             
         </div>
         <form  action="" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }} 

         
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
         <div class="col-span-12 sm:col-span-12">

        
</div>



             <div class="col-span-12 sm:col-span-12"><label>Name</label> 
            
            
             
             <input name="name" type="text" class="input w-full border mt-2 flex-1" placeholder="Name" required> </div>
            
             

             <div class="col-span-12 sm:col-span-12"><label>Email</label> 
            
            
             
             <input name="email" type="text" class="input w-full border mt-2 flex-1" placeholder="email" required> </div>
            
             
             
             <div class="col-span-12 sm:col-span-12"><label>Password</label> 
            
            
             
             <input name="password" type="text" class="input w-full border mt-2 flex-1" placeholder="Password" required> </div>
            
             

             <div class="col-span-12 sm:col-span-12"><label>Confirm Password</label> 
            
            
             
            <input name="cpassword" type="text" class="input w-full border mt-2 flex-1" placeholder="Confirm Password" required> </div>
           
         
            <div class="col-span-12 sm:col-span-12"><label><b>Admin Roles</b></label> 
            
            
             
            <select name="acctype" class="input w-full border mt-2 flex-1" required>

<option value="2">Admin</option>
<option value="1">Super Admin</option>


            </select> </div>
           
             
            
                                    
         </div>
        
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="submit" class="button w-20 bg-theme-1 text-white">Add</button> </div>
    </form> 
 </div>




 <div class="modal" id="header-footer-modal-preview3">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">Edit list</h2> 
             
         </div>
         <form  action="createlist" method="POST" >
         {{ csrf_field() }} 
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
             <div class="col-span-12 sm:col-span-12"><label>Name</label> 
             <input name="listid" id="listid2" type="hidden" class="input w-full border mt-2 flex-1"> 
             <input type="hidden", name="id" id="app_id2">
             
             <input name="title" id="title2" type="text" class="input w-full border mt-2 flex-1" placeholder="title" required>
             </div>

             <div class="col-span-12 sm:col-span-12"><label>Type</label> 
             
             
             
             <input name="showtype" id="show-type" type="text" class="input w-full border mt-2 flex-1" placeholder="title" disabled required>
             </div>
            
        
             
            
                                    
         </div>
         
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <a href="javascript:void(0);" onclick="submitlist();"  class="button w-20 bg-theme-1 text-white">Save</a> </div>
    </form> 
 </div>
 </div>




 <div class="modal" id="header-footer-modal-previewxx">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">Edit Account</h2> 
             
         </div>
         <form  action="/admin/editaccount" method="post" enctype="multipart/form-data">
         {{ method_field("PUT")}}
      {{ csrf_field() }}

         
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
        

             <div class="col-span-12 sm:col-span-12"><label><b>Name</b></label> 
            
            
             
             <input name="name" id="name" type="text" class="input w-full border mt-2 flex-1" placeholder="Name" required> </div>
            
             <input name="user" id="user" type="hidden" > 
            

             <div class="col-span-12 sm:col-span-12"><label><b>Email</b></label> 
            
            
             
             <input name="email" id="email" type="text" class="input w-full border mt-2 flex-1" placeholder="Email" required> </div>

                
            <div class="col-span-12 sm:col-span-12"><label><b>Admin Roles</b></label> 
            
            
             
            <select class="input w-full border mt-2 flex-1" name="acctype" required>

<option value="2">Admin</option>
<option value="1">Super Admin</option>


            </select> </div>
           
            
           
            
             <div class="col-span-12 sm:col-span-12">
             <b style="color:#090;">Change Password</b>
             </div>
             <div class="col-span-12 sm:col-span-12"><label>New Password</label> 
            
            
             
            <input name="password" id="password" type="text" class="input w-full border mt-2 flex-1" placeholder="Password" > </div>
           
            
            
            <div class="col-span-12 sm:col-span-12"><label>Confirm Password</label> 
            
            
             
            <input name="cpassword" id="cpassword" type="text" class="input w-full border mt-2 flex-1" placeholder="Confirm Password" > </div>
           
            
           
              

               
            
                                    
         </div>
        
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="submit" class="button w-40 bg-theme-1 text-white">Update Account</button> </div>
    </form> 
 </div>
</div>


 


                <form action="" method="post" >
                <div class="modal" id="delete-confirmation-modalXX">

               {{ csrf_field() }}

                    <div class="modal__content">
                        <div class="p-5 text-center">
                            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> 
                            <div class="text-3xl mt-5">sure you want to delete this list?</div>
                            <div class="text-gray-600 mt-2">Do you really want to delete these records? This process cannot be undone.</div>
                            <input type="hidden", name="id" id="app_id">
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                            <button type="submit" class="button w-24 bg-theme-6 text-white" onclick="senddel();" >Delete</button>
                        </div>
                    </div>
                </div>
                </form>


                <form action="" method="post" >
                <div class="modal" id="delete-confirmation-modal">

               {{ csrf_field() }}

                    <div class="modal__content">
                        <div class="p-5 text-center">
                           
                            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> 
                            <h2 style="font-weight:bold">Do you really want to delete this Account</h2>
                            <div class="p-5">



                            <a href="" class="block font-medium text-base mt-5" style="color:#090"><span id="namexx" ></span></a> 
                            <a href="" class="block font-medium text-base mt-5"><b><span id="emailxx"></span></b></a> 
                            <a href="" class="block font-medium text-base mt-5"><b><span id="idxx"></span></b></a> 
                        </div>   <input type="hidden", name="id" id="app_id">
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">No</button>
                            <button type="submit" class="button w-26 bg-theme-6 text-white" onclick="senddelx();" >Yes Delete !</button>
                        </div>
                    </div>
                </div>
                </form>

                <div class="modal" id="button-modal-preview">
     <div class="modal__content relative"> <a data-dismiss="modal" href="javascript:;" class="absolute right-0 top-0 mt-3 mr-3"> <i data-feather="x" class="w-8 h-8 text-gray-500"></i> </a>
         <div class="p-5 text-center"> <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
             <div class="text-3xl mt-5">Update Successful</div>
            
         </div>
         <div class="px-5 pb-8 text-center"> <a href="" class="button w-24 bg-theme-1 text-white">Ok</a> </div>
     </div>
 </div>
                <!-- END: Delete Confirmation Modal -->
            
@endsection

<script>


function showAlert(photo){
    var id=photo;
    var userID=$('#deleteUser'+id).attr('data-userid');
    $('#app_id').val(userID); 

    $.get('/admin/pullaccountdetail/'+id,function(user){
     $("#namexx").text(user.name.toUpperCase());
     $("#emailxx").text(user.email);
     $("#idxx").text(user.id.toUpperCase());
    
      

});

   $('#delete-confirmation-modal').modal('show'); 
   
}


function showAlert2(photo){
    var id=photo;
    var userID=$('#deleteUser'+id).attr('data-userid');
    $('#app_id2').val(userID); 

    $.get('/users/pulllistdetail/'+id,function(list){

        $("#listid2").val(list.id);
       $("#title2").val(list.name);
      


});


  $('#header-footer-modal-preview3').modal('show'); 
   
}

function showEditBox(photo){
    var id=photo;
    var userID=$('#deleteUser'+id).attr('data-userid');
    $('#app_id2').val(userID); 

    $.get('/admin/pulluserdetail/'+id,function(user){

        $("#user").val(user.id);
       $("#name").val(user.name);
       $("#email").val(user.email);
      


});


  $('#header-footer-modal-previewxx').modal('show'); 
   
}


function submitlist(){

var id=$("#listid2").val();
var title=$("#title2").val();
var _token = $('input[name="_token"]').val();
$.ajax({
      url:'/users/submitlistupdate',
            method: 'POST',
            data: {
              id:id,title:title,_token:_token
            },
            
            success:function(result){
              $('#header-footer-modal-preview3').modal('hide'); 
              $('#button-modal-preview').modal('show'); 
            }});



}

function senddelx(){
    
    window.location="/admin/account/delete/"+$('#app_id').val();
   
}

function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(200)
                        
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function selectAll(source) {
    checkboxes = document.getElementsByName('allpilots[]');
    for(var i in checkboxes)
        checkboxes[i].checked = source.checked;
}
</script>

