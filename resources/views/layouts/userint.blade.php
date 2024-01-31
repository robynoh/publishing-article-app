<!DOCTYPE html>
<!--
Template Name: Midone - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="{{ app()->getLocale() }}">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

@yield('title')

        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="app">
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                </a>
                <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            </div>
            <ul class="border-t border-theme-24 py-5 hidden">
            <li>
                        <a href="/user" class="menu menu--active">
                            <div class="menu__icon"> <i data-feather="archive"></i> </div>
                            <div class="menu__title"> Dashboard</div>
                        </a>
                    </li>

                    <li>
                        <a href="/user" class="menu menu--active">
                            <div class="menu__icon"> <i data-feather="toggle-right"></i> </div>
                            <div class="menu__title"> Logout</div>
                        </a>
                    </li>
                   
               
               
               
                   
                   
               
        
            
             
            </ul>
        </div>
        <!-- END: Mobile Menu -->
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            <nav class="side-nav">
                <a href="" class="intro-x flex items-center pl-5 pt-4">
                    <img alt="Midone Tailwind HTML Admin Template" class="w-6" src=" {{ asset('dist/images/logo.svg') }} ">
                    <span class="hidden xl:block text-white text-lg ml-3"> Mid<span class="font-medium">one</span> </span>
                </a>
                <div class="side-nav__devider my-6"></div>
                <ul>
                    <li>
                        <a href="/users" class="side-menu side-menu<?php if(Request::segment(2)==''){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="slack"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>

                    <li>
                        <a href="/users/list" class="side-menu side-menu<?php if(Request::segment(2)=='list'){?>--active<?php }?><?php if(Request::segment(2)=='listDetail'){?>--active<?php }?><?php if(Request::segment(3)=='anniversary'){?>--active<?php }?><?php if(Request::segment(2)=='anniversary'){?>--active<?php }?><?php if(Request::segment(2)=='anniversaryByMonths'){?>--active<?php }?><?php if(Request::segment(2)=='smsallcontacts'){?>--active<?php }?><?php if(Request::segment(2)=='todayBirthday'){?>--active<?php }?><?php if(Request::segment(2)=='tomorrowBirthday'){?>--active<?php }?><?php if(Request::segment(2)=='celebrantsByMonths'){?>--active<?php }?><?php if(Request::segment(2)=='monthExtract'){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="book"></i> </div>
                            <div class="side-menu__title"> Contact list</div>
                        </a>
                    </li>
                    <li>
                        <a href="/users/scheduleList" class="side-menu side-menu<?php if(Request::segment(2)=='scheduleList'){?>--active<?php }?><?php if(Request::segment(2)=='multipleupdate'){?>--active<?php }?><?php if(Request::segment(2)=='contacts'){?>--active<?php }?><?php if(Request::segment(2)=='scheduleUpdate'){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="clock"></i> </div>
                            <div class="side-menu__title">Auto schedule</div>
                        </a>
                    </li>
                    <li>
                        <a href="/users/sentMessages" class="side-menu side-menu<?php if(Request::segment(2)=='sentMessages'){?>--active<?php }?><?php if(Request::segment(2)=='smsdetail'){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="send"></i> </div>
                            <div class="side-menu__title">Message History</div>
                        </a>
                    </li>

                    <li>
                        <a href="/users/senderid" class="side-menu side-menu<?php if(Request::segment(2)=='senderid'){?>--active<?php }?><?php if(Request::segment(2)=='my_senderid'){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="key"></i> </div>
                            <div class="side-menu__title">Sender ID</div>
                        </a>
                    </li>

                    <li>
                        <a href="/users/senderid" class="side-menu side-menu<?php if(Request::segment(2)=='senderid'){?>--active<?php }?><?php if(Request::segment(2)=='my_senderid'){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="message-circle"></i> </div>
                            <div class="side-menu__title">Auto Responder</div>
                        </a>
                    </li>

                    <li>
                        <a href="/users/collect_information" class="side-menu side-menu<?php if(Request::segment(2)=='senderid'){?>--active<?php }?><?php if(Request::segment(2)=='my_senderid'){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                            <div class="side-menu__title">Collect Information</div>
                        </a>
                    </li>

                  
                    
                    <li>
                        <a href="/users/profile_view" class="side-menu side-menu<?php if(Request::segment(2)=='senderid'){?>--active<?php }?><?php if(Request::segment(2)=='my_senderid'){?>--active<?php }?>">
                            <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                            <div class="side-menu__title">Profile</div>
                        </a>
                    </li>



                   


                  <!---  <li>
                        <a href="/user/sentMessages" class="side-menu side-menu">
                            <div class="side-menu__icon"> <i data-feather="help-circle"></i> </div>
                            <div class="side-menu__title"> How it work</div>
                        </a>
                    </li>

                    <li>
                        <a href="/users/pricing" class="side-menu side-menu">
                            <div class="side-menu__icon"> <i data-feather="credit-card"></i> </div>
                            <div class="side-menu__title">Pricing</div>
                        </a>
                    </li>
                   
                    <li>
                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"  class="side-menu side-menu">
                            <div class="side-menu__icon"> <i data-feather="settings"></i> </div>
                            <div class="side-menu__title"> Settings</div>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                    </li>-->
                
                   
                  
                    <li class="side-nav__devider my-6"></li>
                   
                   
                   
                   
                   
                   
                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            
            <div class="content">

            
            @yield('content')
            
</div>
            <!-- END: Content -->
        </div>
        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        <script src="{{ asset('dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->

        <script>



$('input[type="radio"]').click(function(){
    if ($(this).is(':checked'))
    {
      if($(this).val()=='radio' || $(this).val()=='checkbox'){
		  
		  $('#optTable').show();
		  $('#menuTable').hide();
		   $('#inputT').hide();
	  }
      else if($(this).val()=='yes' || $(this).val()=='no'){
		  
          // $('#optTable').show();
          // $('#menuTable').show();
           // $('#inputT').hide();
       }
	 else if($(this).val()=='selectMenu'){
		  
		  $('#menuTable').show();
		  $('#optTable').hide();
		   $('#inputT').hide();
	  }
	  else if($(this).val()=='textfield'){
		  
		  $('#menuTable').hide();
		  $('#optTable').hide();
		  $('#inputT').show();
	  }
	  
	  else{
		  
		 $('#optTable').hide();  
		  $('#menuTable').hide();  
		  $('#inputT').hide();
	  }
    }
  });

		   




	
	
	
 
  $('input[type="radio"]').click(function() {
    setActiveBox($(this));            
});   

function setActiveBox($radioButton) {
    if(!($radioButton instanceof jQuery)) {
        $radioButton = $($radioButton);
    }
    
    var value = $radioButton.attr("value");
    $(".box").hide();
    $("." + value).show();
    saveData("activeRadio",value);    
}

function saveData(key,value) {
       localStorage.setItem(key,value) || (document.cookie = key + "=" + value);
}

function getData(key) {
    return localStorage.getItem(key) || document.cookie.match(new RegExp(key + "\=(.+?)(?=;)"))[1];
}

//check stored radioButton on page load
var $radioButton = $("[value=" + getData("activeRadio") + "]");
$($radioButton).attr("checked",true);
setActiveBox($radioButton);
  
  


 </script>
    </body>
</html>