<?php   use \App\Http\Controllers\UserController; ?>
@extends('layouts.userint')
@section('title')
    <title> User | Profile  </title>
@endsection
@section('content')


                   <!-- BEGIN: Top Bar -->
                   <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">User</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Profile</a> </div>
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
                
                <h1 class="text-lg font-medium mr-auto mt-3" style="font-size:23px">
                Account Settings
                    </h1><br/>


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
            

<div class="intro-y box py-10 sm:py-20">
<div class="px-5 mt-5">@foreach($datas as $data)
                        <div class="font-medium text-center text-lg">Your Personal Information</div>
                        <div class="text-gray-600 text-center mt-2">This account was created <i>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }} </i>. To update your password, <u class=""><a href="/user/updatePassword">click here</a></u></div>
                    </div>
                  
                    <div class="px-5 sm:px-20  border-gray-200  mt-5">
                       <form method="POST" action="">
                       {{ csrf_field() }} 
                        <div class="grid grid-cols-12 gap-4 row-gap-5 ">
                            
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Name</div>
                                <input name="name" type="text" class="input w-full border flex-1" placeholder="name" value="{{$data->name}}">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Email</div>
                                <input name="email" type="email" class="input w-full border flex-1" placeholder="email" value="{{$data->email}}">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Phone</div>
                                <input name="phone"  type="number" class="input w-full border flex-1" placeholder="phone" value="{{$data->phone}}">
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Country</div>
                                <input name="country2" type="text" class="input w-full border flex-1" placeholder="country" value="{{$data->country}}" disabled>
                                <input name="country" type="hidden" class="input w-full border flex-1" placeholder="country" value="{{$data->country}}">
                            
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">State</div>
                                <select name="state" class="input w-full border flex-1">
                                <option>{{$data->state}}</option>

                                {{Usercontroller::states()}}
</select>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <div class="mb-2">Usage Type</div>
                                <select name="usage" class="input w-full border flex-1">
                                    <option>{{$data->usage_type}}</option>
                                    <option>Personal</option>
                                    <option>Corporate</option>
                                   
                                </select>
                            </div>
                           @endforeach

                            
                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                
                            
                                <button class="button w-24 justify-center block bg-theme-1 text-white ml-2">Save</button>
                            </div>
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

