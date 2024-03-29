@extends('layouts.adminint')
<?php   use \App\Http\Controllers\AdminController; ?>
@section('title')
    <title> Admin | Customer Detail  </title>
@endsection
@section('content')



                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Admin</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Pilots</a> </div>
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
                   Customer Information
                </h2>

               <br/> 
              


               <div class="intro-y box px-5 pt-5 mt-5">
                    <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <img alt="Customer photo" class="rounded-full" src="{{$customer->picture}}">
                            </div>
                            <div class="ml-5">
                                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ucwords($customer->fname)}} {{ucwords($customer->lname)}}</div>
                    
                              
                             
                            </div>
                        </div>
                        <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$customer->email}} </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i> {{$customer->phone}} </div>
                           
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 pt-5 lg:pt-0">
                            <div class="text-center rounded-md w-20 py-3">
                                <div class="font-semibold text-theme-1 text-lg">201</div>
                                <div class="text-gray-600">Trips</div>
                            </div>
                        
                        </div>
                    </div>
                    <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
                        <a onclick="hideotherstrips()" data-toggle="tab" data-target="#trips" href="javascript:;" class="py-4 sm:mr-8 flex items-center active"> <i class="w-4 h-4 mr-2" data-feather="credit-card"></i> Transactions</a>
                        </div>
                </div>




                <div class="tab-content mt-5">
                    <div class="tab-content__pane active " id="trips">

                    <b>All Transactions</b>
                    <br/><br/>
                        <div class="grid grid-cols-12 gap-6">

                       

                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                        
                    <table class="table table-report table-report--bordered display datatable w-full" style="font-size:14px;">
                        <thead>
                             <th class="border-b-2 whitespace-no-wrap">PILOT</th>
                             <th class="border-b-2 whitespace-no-wrap">NAME</th>
                                <th class="border-b-2 whitespace-no-wrap">FROM</th>
                               
                                <th class="border-b-2 whitespace-no-wrap">TO</th>
                                <th class="border-b-2 whitespace-no-wrap">AMOUNT PAID</th>
                                <th class="border-b-2 whitespace-no-wrap">DATE</th>
                            
                               
                               
                            
                               
                              
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($payments as $payment)
                            <tr>
                            <td class="border-b">
                            {{$payment->riderid}}     
                        </td>
                            <td class="border-b">
                            {{$payment->riderid}}                
                                </td>
                                <td class="border-b">
                                {{$payment->fromLoc}}  
                                </td>
                                <td class="border-b">
                                {{$payment->toLoc}}  
                                </td>
                               
                                <td class="w-40 border-b">
                                {{$payment->amount}}  
                                 </td>

                                 <td class="w-40 border-b">

                                 {{$payment->created_at}}  
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

                       </div>
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
         <form  action="" method="post" enctype="multipart/form-data">
         {{ method_field("PUT")}}
      {{ csrf_field() }}

         
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
         <div class="col-span-12 sm:col-span-12">

         <div class="mx-auto text-center">
                                    <div class="w-40 h-40 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                       
                                        <img id="imgsrc" alt="pilot photo"  src="">
                          
                                    </div>
                                   
                                </div>
</div>


<div class="col-span-12 sm:col-span-12">
 <input style="align:center" name="file" type="file" onchange="readURL(this);"  />
  
</div>

             <div class="col-span-12 sm:col-span-12"><label>Firstname</label> 
            
            
             
             <input name="fname" id="fname" type="text" class="input w-full border mt-2 flex-1" placeholder="Firstname" required> </div>
            
             <input name="user" id="user" type="hidden" > 
            

             <div class="col-span-12 sm:col-span-12"><label>Lastname</label> 
            
            
             
             <input name="lname" id="lname" type="text" class="input w-full border mt-2 flex-1" placeholder="Lastname" required> </div>
            
             
             
             <div class="col-span-12 sm:col-span-12"><label>Phone</label> 
            
            
             
             <input name="phone" id="phone" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
            
             

             <div class="col-span-12 sm:col-span-12"><label>Email</label> 
            
            
             
            <input name="email" id="email" type="text" class="input w-full border mt-2 flex-1" placeholder="Email" required> </div>
           
         
            
             
            
                                    
         </div>
        
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="submit" class="button w-20 bg-theme-1 text-white">Save</button> </div>
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
                    $('#blah')
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
</script>

