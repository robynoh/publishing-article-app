<?php   use \App\Http\Controllers\UserController; ?>
@extends('layouts.adminint')
@section('title')
    <title> Admin | Dashboard  </title>
@endsection
@section('content')


                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Admin</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active" style="color:#FD8401">Dashboard</a> </div>
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
                        
                    </div>
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->
                <br/>
               


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
               

<div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
                    <!-- BEGIN: General Report -->
                    <div class="col-span-12 mt-8">

                    <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                  <a href="/admin/pilots">  <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="users" class="report-box__icon text-theme-9" style="color:#FD8401"></i> 
                                            
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6" >{{$pilots->count()}}</div>
                                        <div class="text-base text-gray-600 mt-1">Pilots</div>
                                    </div>
</a>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                <a href="#">   <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user-check" class="report-box__icon text-theme-9" style="color:#FD8401" ></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">{{$customers->count()}}</div>
                                        <div class="text-base text-gray-600 mt-1">Customers</div>
                                    </div></a>

                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                <a href="#">     <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="shopping-cart" class="report-box__icon text-theme-9" style="color:#FD8401"></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">{{$orders->count()}}</div>
                                        <div class="text-base text-gray-600 mt-1">Orders</div>
                                    </div></a>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                <a href="/admin/real-time-track">      <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="map-pin" class="report-box__icon text-theme-9" style="color:#FD8401"></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">Track Pilots</div>
                                        <div class="text-base text-gray-600 mt-1"> Realtime navigation</div>
                                    </div></a>
                                </div>
                            </div>
                        </div>
                       
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                <a href="#">    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="message-square" class="report-box__icon text-theme-9" style="color:#FD8401"></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">6</div>
                                        <div class="text-base text-gray-600 mt-1">Complains</div>
                                    </div>
</a>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user-x" class="report-box__icon text-theme-9" style="color:#FD8401"></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">8</div>
                                        <div class="text-base text-gray-600 mt-1">Restricted Pilot</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="truck" class="report-box__icon text-theme-9" style="color:#FD8401"></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">15</div>
                                        <div class="text-base text-gray-600 mt-1">Active Delivery</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="settings" class="report-box__icon text-theme-9" style="color:#FD8401"></i> 
                                           
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">CPanel</div>
                                        <div class="text-base text-gray-600 mt-1">Settings</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>


                    
                    <!-- END: General Report -->
                    <!-- BEGIN: Sales Report -->
                
                    <!-- END: Sales Report -->
                    <!-- BEGIN: Weekly Top Seller -->
                  
                    <!-- END: Weekly Top Seller -->
                    <!-- BEGIN: Sales Report -->
                  
                    <!-- END: Sales Report -->
                   
                          
                    <!-- BEGIN: Weekly Best Sellers -->
                    

                  

                   
                    <!-- END: Weekly Best Sellers -->
                    <!-- BEGIN: General Report -->
                    
                    <!-- END: General Report -->
                    <!-- BEGIN: Weekly Top Seller -->
                   
                        <!-- END: Schedules -->
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

