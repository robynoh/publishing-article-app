@extends('layouts.adminint')
<?php   use \App\Http\Controllers\AdminController; ?>
@section('title')
    <title> Admin | Pilot Detail  </title>
@endsection
@section('content')



                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Admin</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active" style="color:#FD8401">Pilots</a> </div>
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

                <h2 class="intro-y text-lg font-medium mt-10">
                   Rider Information
                </h2>

               <br/> 
               
         



               <div class="intro-y box px-5 pt-5 mt-5">
                    <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <img alt="Pilot photo" class="rounded-full" src="{{$pilot->picture}}">
                            </div>
                            <div class="ml-5">
                                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ucwords($pilot->firstname)}} {{ucwords($pilot->lastname)}}</div>
                                <div class="text-gray-600">ID No.{{ucwords($pilot->pilotID)}}</div>
                                <div class="button w-32 mr-2 mb-2 flex items-center justify-center bg-theme-7 text-white"> <i data-feather="edit" class="w-4 h-4 mr-2"></i><a id="deleteUser{{ $pilot->id}}" data-userid="{{$pilot->id}}" href="javascript:void(0)" onclick="showAlert({{$pilot->id}});">Edit Profile</a></div>
                           
                             
                            </div>
                        </div>
                        <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$pilot->email}} </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i> {{$pilot->phone}}  <input id="phoneNum" type="hidden"  value="{{$pilot->phone}}" /></div>
                           
                            <?php if($pilot->status==2){?>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3 text-theme-6" style="font-size:larger;font-weight:bold"> <i data-feather="anchor" class="w-4 h-4 mr-2 "></i> Restricted </div>
                       <?php }?>
                       <?php if($pilot->status==3){?>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3 text-theme-12" style="font-size:larger;font-weight:bold"> <i data-feather="anchor" class="w-4 h-4 mr-2 "></i> On Hold</div>
                       <?php }?>
                       <?php if($pilot->status==1){?>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3 text-theme-9" style="font-size:larger;font-weight:bold"> <i data-feather="anchor" class="w-4 h-4 mr-2 "></i> Verified </div>
                       <?php }?>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 pt-5 lg:pt-0">
                            <div class="text-center rounded-md w-20 py-3">
                                <div class="font-semibold text-theme-1 text-lg">201</div>
                                <div class="text-gray-600">Trips</div>
                            </div>
                            <div class="text-center rounded-md w-60 py-3">
                                <div class="font-semibold text-theme-1 text-lg">&#x20A6; 0.0</div>
                                <div class="text-gray-600">Cash Balance</div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
                        <a onclick="hideotherstrips()" data-toggle="tab" data-target="#trips" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="truck"></i> Rider Details</a>
                        <a onclick="hideotherspayments()" data-toggle="tab" data-target="#payments" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="settings"></i> Motor Bike Details </a>
                        <a onclick="hideotherscancelled()" data-toggle="tab" data-target="#cancelled" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="file-text"></i> Licence Details</a>
                        <a onclick="hideotherslocation()" data-toggle="tab" data-target="#location" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="credit-card"></i> Bank Account Detail </a>
                        <a onclick="hideothersorders()" data-toggle="tab" data-target="#orders" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="shopping-bag"></i> Orders </a>
                        <a onclick="hideothersgps()" data-toggle="tab" data-target="#current-location" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="map-pin"></i> Current Location </a>
                    
                    </div>
                </div>




                <div class="tab-content mt-5">
                    <div class="tab-content__pane active " id="trips">

                    <b>Persona</b>
                    <br/>  <br/>
                        <div class="grid grid-cols-12 gap-6">

                       
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                        
                   <!-- BEGIN: Personal Information -->
                 
                         
                            <div class="p-5">
                                <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                            <label>ID No.</label>
                                            <input style="font-weight:bold" type="text" class="input w-full border bg-gray-100 cursor-not-allowed mt-2" placeholder="Input text" value="{{$pilot->pilotID}}" disabled>
                                        </div>
                                        <div class="mt-3">
                                            <label>Name</label>
                                            <input style="font-weight:bold" type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->firstname}}" disabled>
                                        </div>
                                        <div class="mt-3">
                                            <label>Phone</label>
                                            <input style="font-weight:bold" type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->phone}}" disabled>
                                    
                                        </div>
                                       
                                    </div>
                                    <div class="col-span-12 xl:col-span-6">
                                    <div>
                                            <label>Email</label>
                                            <input style="font-weight:bold" type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->email}}" disabled>
                                        </div>
                                        <div class="mt-3">
                                            <label>Creation Date</label>
                                            <input style="font-weight:bold" type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->created_at}}" disabled>
                                        </div>
                                      
                                     
                                    </div>
                                </div>
                              
                            </div>
                        
                        <!-- END: Personal Information -->
</form>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>

                       </div>
                       </div>
                       </div>



                       <div class="tab-content mt-5">
                    <div class="tab-content__pane active " id="current-location">

                    <b>Rider Location</b>
                    <br/>  <br/>
                        <div class="grid grid-cols-12 gap-6">

                       
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                        
                   <!-- BEGIN: Personal Information -->
                 
                         
                            <div class="p-5">
         
                            <div id="map" style="width:100%;height:400px;"></div>



                               
    

                            </div>
                        
                        <!-- END: Personal Information -->
</form>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>

                       </div>
                       </div>
                       </div>







                       <div class="tab-content mt-5">
                    <div class="tab-content__pane active " id="orders">

                    <b>Order History</b>
                    <br/>  <br/>
                        <div class="grid grid-cols-12 gap-6">

                       
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                        
                   <!-- BEGIN: Personal Information -->
                 
                         
                            <div class="p-5">
                                <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                           
                                            <button name="action" value="filter"  class="button box bg-theme-6 text-white mr-2 flex items-center  ml-auto sm:ml-0" >
         <i data-feather="x" class="w-4 h-4 mr-2"></i> (340) Cancelled Orders </button></div>
                                        <div class="mt-3">
                                      
                                            <button name="action" value="filter"  class="button box bg-theme-9 text-white mr-2 flex items-center  ml-auto sm:ml-0" >
         <i data-feather="truck" class="w-4 h-4 mr-2"></i> (342)  Delivered Orders </button>    </div>
                                       
                                       
                                    </div>
                                    <div class="col-span-12 xl:col-span-6">
                                    <div>
                                            
                                            <button name="action" value="filter"  class="button box bg-theme-1 text-white mr-2 flex items-center  ml-auto sm:ml-0" >
         <i data-feather="x" class="w-4 h-4 mr-2"></i> (348)  Orders in progress</button>
                                   </div>
                                       
                                      
                                     
                                    </div>
                                </div>
                              
                            </div>
                        
                        <!-- END: Personal Information -->
</form>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>

                       </div>
                       </div>
                       </div>



                       
                <div class="tab-content mt-5">
                    <div class="tab-content__pane" id="payments">

                    <b>Motor bike detail</b>
                    <br/><br/>
                        <div class="grid grid-cols-12 gap-6">


                        
                        

<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
<div class="intro-y datatable-wrapper box p-5">

<div class="p-5">
                                <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                            <label>Machine Manufacture</label>
                                            <input type="text" class="input w-full border bg-gray-100 cursor-not-allowed mt-2" placeholder="Input text" value="{{$pilot->machine_manufacture}}" style="font-weight:bold" disabled>
                                        </div>
                                        <div class="mt-3">
                                            <label>Engine Size</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->engine_size}}" style="font-weight:bold" disabled>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="col-span-12 xl:col-span-6">
                                    <div>
                                            <label>Plate License</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->license_plate}}" style="font-weight:bold" disabled>
                                    
                                        </div>
                                        <div class="mt-3">
                                            <label>Bike Color</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->bike_color}}" disabled>
                                        </div>
                                         
                                    </div>
                                </div>
                              
                            </div>
</form>
</div>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->

<!-- END: Pagination -->
</div>

                        

                       </div>
                       </div>
                       </div>


                       <div class="tab-content mt-5">
                    <div class="tab-content__pane " id="cancelled">

                    <b>License Detail</b>
                    <br/>  <br/>
                        <div class="grid grid-cols-12 gap-6">

                        

                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                        
                    <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                            <label>Drivers License</label>
                                            <input type="text" class="input w-full border bg-gray-100 cursor-not-allowed mt-2" placeholder="Input text" value="{{$pilot->driver_license}}" style="font-weight:bold" disabled>
                                        </div>
                                        <div class="mt-3">
                                            <label>Expiry Date</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->expiry_date}}" style="font-weight:bold" disabled>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="col-span-12 xl:col-span-6">
                                    <div>
                                            <label>Do you have valid permit ?</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->valid_permit}}" style="font-weight:bold" disabled>
                                    
                                        </div>
                                         
                                    </div>
                                </div>


                                
</form>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>

                       </div>
<br/>

                       <b>Documents Upload</b>
                    <br/>  <br/>
                        <div class="grid grid-cols-12 gap-6">

                        

                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5">
                        
                    <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                        <br/><br/>
                                            <label><b>Drivers License</b></label>
                                            <br/>
                                            <br/>
                                            

                                            <div class="button w-100 mr-2 mb-2 flex items-center justify-center bg-theme-9 text-white"> <i data-feather="hard-drive" class="w-4 h-4 mr-2"></i><a href="{{$pilot->driver_license_pic}}">Download riders Drivers License</a></div>
                           
                                        </div>
                                       
                                       
                                    </div>


                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                        <br/><br/>
                                            <label><b>Other Valid Permit</b></label>
                                            <br/>
                                            <br/>
                                            <?php if($pilot->permit_pic==""){?>

<p>No permit is uploaded by this rider</p>
                                           <?php }else{?>

                                            <div class="button w-100 mr-2 mb-2 flex items-center justify-center bg-theme-9 text-white"> <i data-feather="hard-drive" class="w-4 h-4 mr-2"></i><a href="{{$pilot->permit_pic}}">Download Permit</a></div>
                           <?php }?>
                                        </div>
                                       
                                       
                                    </div>
                                    
                                </div>


                                
</form>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>

                       </div>
                       </div>
                       </div>



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
                                            <input type="text" class="input w-full border bg-gray-100 cursor-not-allowed mt-2" placeholder="Input text" value="{{$pilot->bankName}}" style="font-weight:bold" disabled>
                                        </div>
                                        <div class="mt-3">
                                            <label>Account Name</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->accountName}}" style="font-weight:bold" disabled>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="col-span-12 xl:col-span-6">
                                    <div>
                                            <label>Account Number</label>
                                            <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$pilot->accountNumber}}" style="font-weight:bold" disabled>
                                    
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
 <br/><br/>
  <hr/>
            <h1><b style="font-size:18px;color:#090">Persona</b></h1>
</div>



             <div class="col-span-12 sm:col-span-12"><label>Firstname</label> 
            
            
             
             <input  name="fname" id="fname" type="text" class="input w-full border mt-2 flex-1" placeholder="Firstname"  required> </div>
            
             <input name="user" id="user" type="hidden" > 
            

             
             
             
             <div class="col-span-12 sm:col-span-12"><label>Phone</label> 
            
            
             
             <input name="phone" id="phone" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
            
             

             <div class="col-span-12 sm:col-span-12"><label>Email</label> 
            
            
             
            <input name="email" id="email" type="text" class="input w-full border mt-2 flex-1" placeholder="Email" required> </div>
           
         
            <div class="col-span-12 sm:col-span-12"><label>Address</label> 
            
            
             
            <input value="{{$pilot->address}}" name="address" id="address" type="text" class="input w-full border mt-2 flex-1" placeholder="Address" required> </div>
           
         
            
             
            
                                    
         </div>

         <div style="padding:20px">

         
  <hr/><br/>
            <h1><b style="font-size:18px;color:#090">Bike Information</b></h1>
<br/>

             
            <div class="col-span-12 sm:col-span-12"><label>Motorcycle Manufacturer</label> 
            
            
             
            <input value="{{$pilot->machine_manufacture}}" name="manufacturer" id="manufacturer" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
           
            
<br/>
             
            <div class="col-span-12 sm:col-span-12"><label>Engine Size</label> 
            
            
             
            <input value="{{$pilot->engine_size}}" name="engine_size" id="engine_size" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
           
            <br/>    
             
            <div class="col-span-12 sm:col-span-12"><label>License Plate</label> 
            
            
             
            <input value="{{$pilot->license_plate}}" name="license_plate" id="license_plate" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> 
        
        </div>

        <br/>
         
        <div class="col-span-12 sm:col-span-12"><label>Bike Color</label> 
            
            
             
            <input value="{{$pilot->bike_color}}" name="bike_color" id="bike_color" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> 
        
        </div>
           
            



                                           </div>


                                           <div style="padding:20px">

         
  <hr/><br/>
            <h1><b style="font-size:18px;color:#090">Documents & Fees</b></h1>
<br/>

             
            <div class="col-span-12 sm:col-span-12"><label>Driver License</label> 
            
            
             
            <input value="{{$pilot->driver_license}}" name="driversLicense" id="driversLicense" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
           
            
<br/>
             
            <div class="col-span-12 sm:col-span-12"><label>Expiry Date</label> 
            
            
             
            <input value="{{$pilot->engine_size}}" name="engine_size" id="engine_size" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
           
            <br/>    
             
            <div class="col-span-12 sm:col-span-12"><label>Do you have a valid permit?</label> 
            
            
             
          <select name="validpermit">
          <option>{{$pilot->valid_permit}}</option>
          <option>Yes</option>
          <option>No</option>
          </select>  
        </div>

        <br/>
         
       
            



                                           </div>


                                           <div style="padding:20px">

         
  <hr/><br/>
            <h1><b style="font-size:18px;color:#090">Uploads</b></h1>
<br/>

             
            <div class="col-span-12 sm:col-span-12">
            <span>Valid permit</span>
            <br/>

            <span><a  style="color:blue" href="{{$pilot->permit_pic}}" >{{$pilot->permit_pic}}</a></span>
            <br/>
            <br/>
        
            <div class="col-span-12 sm:col-span-12">
 <input style="align:center" name="file" type="file" onchange="readURL(this);"  />
 <br/>



 <br/>
            <span>Rider driver License</span>
            <br/>

            <span><a  style="color:blue" href="{{$pilot->driver_license_pic}}" >{{$pilot->driver_license_pic}}</a></span>
            <br/>
            <br/>
        
            <div class="col-span-12 sm:col-span-12">
 <input style="align:center" name="file" type="file" onchange="readURL(this);"  />
 <br/>
          
</div> 
        
        </div>
            
<br/>
             
                <br/>    
             
            
         
       
            



                                           </div>

                                           </div>


                                           <div style="padding:20px">

         
  <hr/><br/>
            <h1><b style="font-size:18px;color:#090">Bank Detail</b></h1>
<br/>

             
            <div class="col-span-12 sm:col-span-12"><label>Bank Name</label> 
            
            
             
            <input value="{{$pilot->bankName}}" name="bankname" id="bankname" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
           
            
<br/>
             
            <div class="col-span-12 sm:col-span-12"><label>Account Name</label> 
            
            
             
            <input value="{{$pilot->accountName}}" name="accountname" id="accountname" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
           
            <br/>   
            
            
            <div class="col-span-12 sm:col-span-12"><label>Account Number</label> 
            
            
             
            <input value="{{$pilot->accountNumber}}" name="accountnumber" id="accountnumber" type="text" class="input w-full border mt-2 flex-1" placeholder="Phone" required> </div>
           
            <br/>   
             
           
        <br/>
         
       
            



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
<script async
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARVQnTNKvSr3d9qyGIjRqgqFhrhXlyMPc&callback=initMap">
</script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use-->
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-database.js"></script>

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
    $("#orders").hide();
}

function hideotherspayments(){

$("#payments").show();
$("#cancelled").hide();
$("#location").hide();
$("#trips").hide();
$("#orders").hide();
}

function hideotherscancelled(){

$("#payments").hide();
$("#cancelled").show();
$("#location").hide();
$("#trips").hide();
$("#orders").hide();
}


function hideotherslocation(){

$("#payments").hide();
$("#cancelled").hide();
$("#location").show();
$("#trips").hide();
$("#orders").hide();
$("#current-location").hide();
}

function hideothersorders(){

$("#payments").hide();
$("#cancelled").hide();
$("#location").hide();
$("#trips").hide();
$("#orders").show();
$("#current-location").hide();
}


function hideothersgps(){

$("#payments").hide();
$("#cancelled").hide();
$("#location").hide();
$("#trips").hide();
$("#orders").hide();
$("#current-location").show();
}
</script>

<script>
// Initialize and add the map



function initMap() {
    
var longitude;
var latitude;
var id= {{$pilot->phone}};

const firebaseConfig = {
apiKey: "AIzaSyBJEJQIlg9kV3rsLysoc8CJbujw44mPBfY",
authDomain: "high-unity-147305.firebaseapp.com",
databaseURL: "https://high-unity-147305-default-rtdb.firebaseio.com",
projectId: "high-unity-147305",
storageBucket: "high-unity-147305.appspot.com",
messagingSenderId: "525137107282",
appId: "1:525137107282:web:eda6eaa8ff5e0f2d5d428b"
};


// Initialize Firebase
firebase.initializeApp(firebaseConfig);





var dbRef= firebase.database().ref("RiderLocation/{{$pilot->phone}}");
dbRef.on("value", function (snapshot) {

// console.log(snapshot.val().name);
// console.log(snapshot.val().user);
// console.log(snapshot.val().gender);
latitude=snapshot.val().latitude;
longitude=snapshot.val().longitude;


const uluru = { lat: parseFloat(latitude), lng:  parseFloat(longitude) };
// The map, centered at Uluru
const map = new google.maps.Map(document.getElementById("map"), {
zoom: 15,
center: uluru,
});

// The marker, positioned at Uluru
const marker = new google.maps.Marker({
position: uluru,
map: map,
icon:'/dist/images/gmarker.png'
});

});








}

window.initMap = initMap;
</script>


                              

