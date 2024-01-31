@extends('layouts.adminint')
<?php   use \App\Http\Controllers\AdminController; ?>
@section('title')
    <title> Admin | Pilots  </title>
@endsection
@section('content')



                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Admin</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active" style="color:#FD8401" >Pilots</a> </div>
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
                  Pilots Online Status
                </h2>

               <br/> 
               <form action="perform-action" method="POST">
                   {{ csrf_field() }}
                   <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                  <a href="#">  <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="globe" class="report-box__icon text-theme-9"></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">{{$online->count()}}</div>
                                        <div class="text-base text-gray-600 mt-1">Pilots Online</div>
                                    </div>
</a>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                <a href="#">   <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="cloud-lightning" class="report-box__icon text-theme-6"></i> 
                                            
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">{{$offline->count()}}</div>
                                        <div class="text-base text-gray-600 mt-1">Pilots Offline</div>
                                    </div></a>

                                </div>
                            </div>

                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                <a href="#">   <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="map-pin" class="report-box__icon text-theme-8"></i> 
                                            
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">{{$offline->count()}}</div>
                                        <div class="text-base text-gray-600 mt-1">All pilots on map</div>
                                    </div></a>

                                </div>
                            </div>
                          
                           
                        </div>                  
<div class="grid grid-cols-12 gap-6 mt-1">

               
                       
                   
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5 mt-5">
                        
                    <table class="table table-report table-report--bordered display datatable w-full" style="font-size:14px;">
                        <thead>
                            <tr>
                           
                            <th class="border-b-2 whitespace-no-wrap"></th>
                                <th class="border-b-2 whitespace-no-wrap">NAME</th>
                                <th class="border-b-2 whitespace-no-wrap">PHONE</th>
                                <th class="border-b-2 whitespace-no-wrap">ONLINE STATUS</th>
                               
                               
                              
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($pilots as $pilot) 
                            <tr>
                              <td class="border-b">
                                    <div class="font-medium whitespace-no-wrap">


                                    <div class="h-full flex items-center">
                                <div class="mx-auto text-center">
                                    <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                        <img alt="Pilot Photo" src="{{$pilot->picture}}">
                                    </div>
                                   
                                </div>
                            </div>
                                    </div>
                                    
                                </td>
                                <td class="border-b">
                                <div class="font-medium whitespace-no-wrap" style="color:#090">{{$pilot->firstname}} {{$pilot->lastname}}</div>
                                  
                                </td>
                                <td class="border-b">
                                <div class="font-medium whitespace-no-wrap" style="color:#090">{{$pilot->phone}}</div>
                                  
                                </td>
                               
                               

                                 <td class="w-40 border-b">
                                 <div class="mt-4">
                                   <?php  if($pilot->online_status==1){?>
                                 
                                 <span class="button w-24 rounded-full mr-1 mb-2 bg-theme-18 text-theme-9">Online</span>
                                 
                                 <?php }?>
                                 <?php  if($pilot->online_status==0){?>

                        
                                    <span class="button w-24 rounded-full mr-1 mb-2 bg-theme-31 text-theme-6">Offline</span>
                                 
                                 
                                 <?php }?>
                                
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
             <h2 class="font-medium text-base mr-auto">New Pilot</h2> 
             
         </div>
         <form  action="" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }} 

         
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
         <div class="col-span-12 sm:col-span-12">

         <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
  
    <a href="" class="w-3/5 file__icon file__icon--image mx-auto">
        <div class="file__icon--image__preview image-fit">
            <img id="blah" alt="Brand logo" src="{{ asset('dist/images/img2.png')}}" >
        </div>
    </a>
   
</div>
</div>


<div class="col-span-12 sm:col-span-12">
 <input style="align:center" name="file" type="file" onchange="readURL(this);" required  />
  
</div>

             <div class="col-span-12 sm:col-span-12"><label>Firstname</label> 
            
            
             
             <input name="fname" type="text" class="input w-full border mt-2 flex-1" placeholder="Firstname" required> </div>
            
             

             <div class="col-span-12 sm:col-span-12"><label>Lastname</label> 
            
            
             
             <input name="lname" type="text" class="input w-full border mt-2 flex-1" placeholder="Lastname" required> </div>
            
             
             
             <div class="col-span-12 sm:col-span-12"><label>Phone</label> 
            
            
             
             <input name="phone" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
            
             

             <div class="col-span-12 sm:col-span-12"><label>Email</label> 
            
            
             
            <input name="email" type="text" class="input w-full border mt-2 flex-1" placeholder="Email" required> </div>
           
         
            
             
            
                                    
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
     $("#fname").text(detail.firstname.toUpperCase());
     $("#lname").text(detail.lastname.toUpperCase());
     $("#id").text(detail.pilotID.toUpperCase());
     $('#imgsrc').attr('src', detail.picture)
      

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
    checkboxes = document.getElementsByName('allpilots[]');
    for(var i in checkboxes)
        checkboxes[i].checked = source.checked;
}
</script>

