<?php   use \App\Http\Controllers\UserController; ?>
@extends('layouts.userint')
@section('title')
    <title> User | Form Edit  </title>
@endsection
@section('content')


                   <!-- BEGIN: Top Bar -->
                   <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">User</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Collect Information</a><i data-feather="chevron-right" class="breadcrumb__icon"></i> Edit form  </div>
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Search -->
                    <div class="search hidden sm:block">
                        </div>
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
                                    <a href="user/profile" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile</a>
                                    <a href="user/updatePassword" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Update Password</a>
                               
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
                
             

                     
<div class="intro-y box col-span-12">
                                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                                    <h2 class="font-medium text-base mr-auto">
                                       Form Fields
                                    </h2>
                                    <div class="dropdown relative ml-auto sm:hidden">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal w-5 h-5 text-gray-700"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg> </a>
                                        <div class="dropdown-box mt-5 absolute w-40 top-0 right-0 z-20">
                                            <div class="dropdown-box__content box p-2">
                                            <a href="/users/collect_information" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"><i data-feather="chevron-left" class="w-6 h-6 mr-2"></i> Back </a> 
                                            
                                            <a href="/users/new_field_edit" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"><i data-feather="file-plus" class="w-6 h-6 mr-2"></i> Add New Field </a>
                                            
                                                <a href="/users/custom_form_arrange_edit" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="sliders" class="w-6 h-6 mr-2"></i> Custom Arrangement </a>
                                                <a href="/users/form_info_edit" class="flex items-center p-2 transition duration-300 ease-in-out bg-white  hover:bg-gray-200 rounded-md"><i data-feather="edit-3" class="w-6 h-6 mr-2"></i>  Edit Information </a>
                                                
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <a href="/users/collect_information" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="chevron-left" class="w-6 h-6 mr-2"></i> Back </a>
                              
                                    <span style="padding-left:10px">
                                    <a href="/users/new_field_edit" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="file-plus" class="w-6 h-6 mr-2"></i> Add New Field</a>
</span>
                                   <span style="padding-left:10px">
                                        <a href="/users/custom_form_arrange_edit" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="sliders" class="w-6 h-6 mr-2"></i> Custom Arrangement</a>
</span>
<span style="padding-left:10px">
                                    <a href="/users/form_info_edit" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="edit-3" class="w-6 h-6 mr-2"></i> Edit Information</a>
</span>

                                </div>
                                <div class="datatable-wrapper box p-5 ">
                    
                    </div>
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



            

<div class="box ">


    

                  
                  
                    <iframe src="/users/create_form_sheet" width="100%" height="450">Your browser isn't compatible</iframe>

                  
 <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5" style="padding-right:20px">
                                
                            
                            </div>

                </div>

                
                  


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


            </div>   
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                
                    <!-- END: Pagination -->

                   
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->
                      <!-- END: Delete Confirmation Modal -->
   <script>
    
    function showAlertfrm(id){
    var formid=id;
    var userID=$('#deleteUser'+formid).attr('data-userid');
    $('#app_id').val(userID); 
   $('#delete-confirmation-modal2').modal('show'); 
   
}

function senddel(){
    
    window.location="/users/form/delete";
   
}
</script>         
@endsection

