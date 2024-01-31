<?php   use \App\Http\Controllers\UserController; ?>
@extends('layouts.userint')
@section('title')
    <title> User | Add New Field  </title>
@endsection
@section('content')


                   <!-- BEGIN: Top Bar -->
                   <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">User</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Collect Information</a><i data-feather="chevron-right" class="breadcrumb__icon"></i> Add New Field </div>
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
            

<div class="intro-y box ">



<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                                    <h2 class="font-medium text-base mr-auto">
                                        Basic Field
                                    </h2>
                                    <div class="dropdown relative ml-auto sm:hidden">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal w-5 h-5 text-gray-700"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg> </a>
                                        <div class="dropdown-box mt-5 absolute w-40 top-0 right-0 z-20">
                                            <div class="dropdown-box__content box p-2">
                                            <a href="/users/create_form_edit" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"><i data-feather="chevron-left" class="w-6 h-6 mr-2"></i> Go Back </a> 
                                            
                                            <a href="" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"><i data-feather="layout" class="w-6 h-6 mr-2"></i> Basic Field </a>
                                            
                                                <a href="/users/create_custom_field_edit" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="user-check" class="w-6 h-6 mr-2"></i> Personalized Fields </a>
                                                
                                                
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <a href="/users/create_form_edit" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="chevron-left" class="w-6 h-6 mr-2"></i> Back </a>
                              
                                    <span style="padding-left:10px">
                                    <a href="" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="layout" class="w-6 h-6 mr-2"></i> Basic Field </a>
</span>
                                   <span style="padding-left:10px">
                                        <a href="/users/create_custom_field_edit" class="button border relative flex items-center text-gray-700 hidden sm:flex"> <i data-feather="user-check" class="w-6 h-6 mr-2"></i> Personalized Fields </a>
</span>


                                </div>


                  
                    <div class="px-5 sm:px-20  border-gray-200  mt-5">
                       <form method="POST" action="">
                       {{ csrf_field() }} 
                        <div class="grid grid-cols-70 gap-4 row-gap-5 mt-5 ">
                            
                            <div class="intro-y col-span-12 sm:col-span-6">
                               
                                <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" value="firstname" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" <?php if(UserController::selectedField('firstname')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Firstname</label> </div> </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                               
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="middlename" <?php if(UserController::selectedField('middlename')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Middlename</label> </div>       </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                               
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="lastname" <?php if(UserController::selectedField('lastname')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Lastname</label> </div>   </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                              
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="email" <?php if(UserController::selectedField('email')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Email</label> </div>  
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="address" <?php if(UserController::selectedField('address')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Address</label> </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="phone" <?php if(UserController::selectedField('phone')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Phone No.</label> </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="country" <?php if(UserController::selectedField('country')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Country</label> </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="state" <?php if(UserController::selectedField('state')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">State</label> </div>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="lga" <?php if(UserController::selectedField('lga')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">LGA</label> </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="occupation" <?php if(UserController::selectedField('occupation')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Occupation</label> </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="department" <?php if(UserController::selectedField('department')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Department</label> </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="name" <?php if(UserController::selectedField('name')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Name</label> </div>
                            </div>
                        
                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="position" <?php if(UserController::selectedField('position')==1){ echo 'checked';} ?>> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Position</label> </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="flex items-center text-gray-700 mr-2"> <input name="fields[]" type="checkbox" class="input border mr-2" id="horizontal-checkbox-chris-evans" value="age"> <label class="cursor-pointer select-none" for="horizontal-checkbox-chris-evans">Age</label> </div>
                            </div>

                           
                            
                            <div class="intro-y col-span-12 flex items-center justify-left  mt-5" >
                               <table> 
                                   <tr>
                                       <td>
                            <button type="submit"  class="button w-24  block bg-theme-9 text-white ml-2">Save</button>
                                       </td>
                                       <td>
                                       <a href="/users/create_form_edit" class="button w-24 mr-1   block bg-gray-200 text-gray-600 ml-2">Go Back</a>
                         
                                       </td>
                                   </tr>
                        
                        </table>

                      
                        
                        </div>
  <br/><br/><br/><br/><br/><br/>

                              
                        </div>

</form>


                    </div>

                  


                </div>



            </div>   
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                
                    <!-- END: Pagination -->

                   
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->
               
                <!-- END: Delete Confirmation Modal -->
            
@endsection

