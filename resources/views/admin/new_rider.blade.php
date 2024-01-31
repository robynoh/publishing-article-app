@extends('layouts.adminint')
<?php   use \App\Http\Controllers\AdminController; ?>
@section('title')
    <title> Admin | New Rider  </title>
@endsection
@section('content')



                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Admin</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active" style="color:#FD8401">New Rider</a> </div>
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


            

         <table>
        <tr>
<td>


</td>
<td>
         
<a href="/admin/pilots" class="button box bg-theme-7 text-white mr-2 flex items-center  ml-auto sm:ml-0" >
         <i data-feather="chevron-left" class="w-4 h-4 mr-2"></i>  Go to all riders </a>
              
</td>

                 
                   
</tr>

                     </table>  

                <div class="tab-content mt-5">
                    <form method="post" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content__pane active " id="trips">

                  
                        <div class="grid grid-cols-12 gap-6">

                       
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                        
                   <!-- BEGIN: Personal Information -->
                 
                         
                        
                            <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
                        <div class="font-medium text-base" style="font-size:18px;color:#090">1. Contact</div>
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Full Name</div>
                                <input name="fullname" type="text" class="input w-full border flex-1" placeholder="Full name" value="{{old('fullname')}}">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Email</div>
                                <input name="email" type="text" class="input w-full border flex-1" placeholder="example@gmail.com" value="{{old('email')}}">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Phone</div>
                                <input name="phone" type="text" class="input w-full border flex-1" placeholder="Phone" value="{{old('phone')}}">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Address</div>
                                <input name="address" type="text" class="input w-full border flex-1" placeholder="Address" value="{{old('address')}}">
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Are you from 3PL ?</div>
                                <input type="radio" id="thirdparty" name="3pl" value="Yes" onchange="thirdParty()"> Yes
                                <input type="radio" id="thirdparty" name="3pl" value="No" onchange="thirdParty()"> No
                            </div>

                            
                            </div>
                          
                       
                        </div>

                        <div id="thirdvalues" class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200" style="display:none">
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Company Name</div>
                                <input name="company_name" type="text" class="input w-full border flex-1" placeholder="Company name">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Company Code</div>
                                <input name="company_code" type="text" class="input w-full border flex-1" placeholder="Company code">
                            </div>
                           
                          
                       
                        </div>
                    </div>
                  

                    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
                        <div class="font-medium text-base" style="font-size:18px;color:#090">2. Bike Information</div>
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Machine Manufacturer</div>
                                <input value="{{old('machine_manufacture')}}" name="machine_manufacture" type="text" class="input w-full border flex-1" placeholder="Machine manufacturer">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">License Plate</div>
                                <input value="{{old('license_plate')}}" name="license_plate" type="text" class="input w-full border flex-1" placeholder="License plate">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Engine size</div>
                                <input value="{{old('engine_size')}}"  name="engine_size" type="text" class="input w-full border flex-1" placeholder="Engine Size">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Bike Color</div>
                                <input value="{{old('bike_color')}}" name="bike_color" type="color" >
                            </div>
                          
                       
                        </div>
                    </div>

                    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
                        <div class="font-medium text-base" style="font-size:18px;color:#090">3. Fees & Documents</div>
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Drivers License</div>
                                <input value="{{old('driver_license')}}" name="driver_license" type="text" class="input w-full border flex-1" placeholder="Machine manufacturer">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">expiry Date</div>
                                <input value="{{old('expiry_date')}}" name="expiry_date" type="date" class="input w-full border flex-1" placeholder="License plate">
                            </div>
                            
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Do you have a valid permit ?</div>
                                <input type="radio" id="vpermit" name="vpermit" value="Yes"> Yes
                                <input type="radio" id="vpermit" name="vpermit" value="No"> No
                            </div>

                           
                          
                        
                        </div>
                    </div>



                    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
                        <div class="font-medium text-base" style="font-size:18px;color:#090">4. Uploads</div>
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                        <div class="col-span-12 sm:col-span-12">
            <span>Profile Photo</span>
            <br/>

          
            <br/>
        
            <div class="col-span-12 sm:col-span-12">
 <input style="align:center" name="profile_photo" type="file" onchange="readURL(this);"  />
 <br/>



 <br/>
            <span>Driver License</span>
            <br/>

           
            <br/>
        
            <div class="col-span-12 sm:col-span-12">
 <input style="align:center" name="driver_license_pic" type="file" onchange="readURL(this);"  />


 <br/>
 <br/>
            <span>Valid Permit</span>
            <br/>

           
            <br/>
        
            <div class="col-span-12 sm:col-span-12">
 <input style="align:center" name="permit_pic" type="file" onchange="readURL(this);"  />
 <br/>

 <br/>
 
          
</div> 
        
        </div>
                        </div>
                    </div>
                              
                            </div>
                        
                        <!-- END: Personal Information -->
</form>
                    </div>


                    
                    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
                        <div class="font-medium text-base" style="font-size:18px;color:#090">5. Bank Detail</div>
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Bank Name</div>
                                <input value="{{old('bank_name')}}" name="bank_name" type="text" class="input w-full border flex-1" placeholder="Bank Name">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Account Name</div>
                                <input value="{{old('account_name')}}" name="account_name" type="text" class="input w-full border flex-1" placeholder="Account Name">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Account Number</div>
                                <input value="{{old('account_number')}}" name="account_number" type="text" class="input w-full border flex-1" placeholder="Account Number">
                            </div>
                           
                          
                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                 <button name="save" type="submit" class="button w-24 justify-center block bg-theme-1 text-white ml-2">Save</button>
                            </div>
                        </div>
                    </div>




                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>

                       </div>
                       </div>
                       </div>
</form>
                       
                



                       <div class="tab-content mt-5">
                    <div class="tab-content__pane " id="location">

                    <b>Bank Account Detail</b>
                    <br/>  <br/>
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                 
                    <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                            <label>Bank Name</label>
                                            <input type="text" class="input w-full border bg-gray-100 cursor-not-allowed mt-2" placeholder="Input text" value="" style="font-weight:bold" disabled>
                                        </div>
                                        <div class="mt-3">
                                            <label>Account Name</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="" style="font-weight:bold" disabled>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="col-span-12 xl:col-span-6">
                                    <div>
                                            <label>Account Number</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="" style="font-weight:bold" disabled>
                                    
                                        </div>
                                        
                                        <div class="mt-3">
                                            <label></label>
                                            <br/><br/>
                                              </div>
                                     
                                    </div>
                                </div>
                                           </div>
                                           <div>
                       </div>
                       </div>






















                
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->




                <div class="modal" id="header-footer-modal-preview2">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">Edit Pilot</h2> 
             
         </div>
         
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
                            <h2 style="font-weight:bold">Do you really want to delete this pilot information</h2>
                            <div class="p-5">


                            <div class="mx-auto text-center">
                                    <div class="w-40 h-40 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                       
                                        <img id="imgsrc" alt="pilot photo"  src="">
                          
                                    </div>
                                   
                                </div>



                            <a href="" class="block font-medium text-base mt-5" style="color:#090"><span id="fname" ></span>  <span id="lname"></span></a> 
                            <a href="" class="block font-medium text-base mt-5"><b><span id="" >ID NUMBER:</span>  <span id="id"></span></b></a> 
                          
                        </div>   <input type="hidden", name="id" id="app_id">
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">No</button>
                            <button type="submit" class="button w-26 bg-theme-6 text-white" onclick="senddel();" >Yes Delete !</button>
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

    $.get('/admin/pullpilotdetail/'+id,function(detail){
     $("#fname").val(detail.firstname);
     $("#lname").val(detail.lastname);
     $("#email").val(detail.email);
     $("#phone").val(detail.phone);
     $("#user").val(detail.id);
     $('#imgsrc').attr('src', detail.picture)
      

});

   $('#header-footer-modal-preview2').modal('show'); 
   
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

function senddel(){
    
    window.location="/admin/pilot/delete/"+$('#app_id').val();
   
}

function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgsrc')
                        .attr('src', e.target.result)
                        .width(200)
                        
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function selectAll(source) {
    checkboxes = document.getElementsByName('pilots[]');
    for(var i in checkboxes)
        checkboxes[i].checked = source.checked;
}

function hideotherstrips(){

    $("#payments").hide();
    $("#cancelled").hide();
    $("#location").hide();
    $("#trips").show();
}

function hideotherspayments(){

$("#payments").show();
$("#cancelled").hide();
$("#location").hide();
$("#trips").hide();
}

function hideotherscancelled(){

$("#payments").hide();
$("#cancelled").show();
$("#location").hide();
$("#trips").hide();
}


function hideotherslocation(){

$("#payments").hide();
$("#cancelled").hide();
$("#location").show();
$("#trips").hide();
}



function thirdParty(){
    
    if(document.querySelector('input[name="3pl"]:checked').value=="Yes"){

        
$("#thirdvalues").show();
    }
    else if(document.querySelector('input[name="3pl"]:checked').value=="No"){

        $("#thirdvalues").hide();
}


}
</script>

