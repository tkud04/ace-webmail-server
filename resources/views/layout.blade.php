<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<title>@yield('title') | Ace Webmail</title>
	
	<!-- favicon 
	  <link rel="favicon" src="{{asset('images/logo.png')}}">-->
	  
	<!-- Bootstrap CSS -->
   <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link href="{{asset('vendor/fonts/circular-std/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('libs/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
    
	<!-- custom css -->
	  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
	  
    <!-- jquery 3.3.1 -->
    <script src="{{asset('vendor/jquery/jquery-3.3.1.min.js')}}"></script>
	 <!-- bootstrap bundle js -->
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
	
	<!--AutoComplete --> 
    <link href="{{asset('css/flexselect.css')}}" rel="stylesheet">
    <script src="{{asset('js/liquidmetal.js')}}"></script>
    <script src="{{asset('js/jquery.flexselect.js')}}"></script>
	
	<!-- custom js -->
	<script src="{{asset('js/helpers.js').'?ver='.rand(56,99999)}}"></script>
	<script src="{{asset('js/mmm.js').'?ver='.rand(56,99999)}}"></script>
	
	<!--Simeditor--> 
        <link rel="stylesheet" type="text/css" href="{{asset('lib/simeditor/css/simditor.css')}}" />
        <script type="text/javascript" src="{{asset('lib/simeditor/js/module.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/simeditor/js/hotkeys.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/simeditor/js/uploader.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/simeditor/js/simditor.js')}}"></script>		
	
	<!--SweetAlert--> 
    <link href="{{asset('lib/sweet-alert/sweetalert2.css')}}" rel="stylesheet">
    <script src="{{asset('lib/sweet-alert/sweetalert2.js')}}"></script>
	
	<!--Quill--> 
    <link href="{{asset('lib/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('lib/quill/quill.bubble.css')}}" rel="stylesheet">
	<script src="{{asset('lib/quill/quill.js')}}"></script>
	<!--<script src="{{asset('lib/quill/quill-init.js')}}"></script>--> 
	
	<!--Tingle--> 
    <link href="{{asset('lib/tingle/tingle.min.css')}}" rel="stylesheet">
	
	<script>
	$(document).ready(() => {
	var Delta = Quill.import('delta');
var quill = new Quill('#msg-input', {
  modules: {
    toolbar: true
  },
  placeholder: 'Message...',
  theme: 'snow'
});

// Store accumulated changes
var change = new Delta();
quill.on('text-change', function(delta) {
  change = change.compose(delta);
});

// Save periodically
setInterval(function() {
  if (change.length() > 0) {
    console.log('Saving changes', change);
    /* 
    Send partial changes
    $.post('/your-endpoint', { 
      partial: JSON.stringify(change) 
    });
    
    Send entire document
    $.post('/your-endpoint', { 
      doc: JSON.stringify(quill.getContents())
    });
    */
    change = new Delta();
  }
}, 5*1000);

// Check for unsaved data
window.onbeforeunload = function() {
  if (change.length() > 0) {
    return 'There are unsaved changes. Are you sure you want to leave?';
  }
}
});
</script>
	@yield('styles')
	@yield('scripts')
</head>

<body>
<?php
if(!isset($blank))
{
?>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
       <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="{{url('/')}}"> <img src="images/logo.png" style="width: 40px; height: 40px;"/></a>
                <button class="navbar-toggler"" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon toggler-white"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
						 <!--
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="javascript:void(0)" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">
John Abraham</span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="javascript:void(0)">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                       -->
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="javascript:void(0)" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('images/avatar.png')}}" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <?php
								 if($user == null)
								 {
								?>
								<div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">Guest</h5>
                                    <span class="status"></span><span class="ml-2">Sign in</span>
                                </div>
                                <a class="dropdown-item" href="{{url('hello')}}"><i class="fas fa-key mr-2"></i>Sign in</a>
                               <?php
								 }
								 else
								 {
									 $n = $user->fname." ".$user->lname;
								?>
                                 <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{$n}}</h5>
                                    <h5 class="mb-0 text-white nav-user-name">{{$user->email}}</h5>
                                    <span class="status"></span><span class="ml-2">{{strtoupper($user->role)}}</span>
                                </div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="{{url('bye')}}"><i class="fas fa-power-off mr-2"></i>Logout</a>								
								<?php
								 }
							   ?>
							</div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
      
	   @include('sidebar',['user' => $user])
	  
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                @yield('page-header')
<?php
}
?>	 

  <!--------- Session notifications-------------->
        	<?php
               $pop = ""; $val = "";
               
               if(isset($signals))
               {
                  foreach($signals['okays'] as $key => $value)
                  {
                    if(session()->has($key))
                    {
                  	$pop = $key; $val = session()->get($key);
                    }
                 }
              }
              
             ?> 

                 @if($pop != "" && $val != "")
                   @include('session-status',['pop' => $pop, 'val' => $val])
                 @endif
        	<!--------- Input errors -------------->
                    @if (count($errors) > 0)
                          @include('input-errors', ['errors'=>$errors])
                     @endif 
				@yield('content')
<?php
if(!isset($blank))
{
?>
            </div>
             <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                             Copyright &copy; {{date("Y")}} Ace Luxury Store. All rights reserved.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->

      <!-- Optional JavaScript -->
    <!-- slimscroll js -->
    <script src="{{asset('vendor/slimscroll/jquery.slimscroll.js')}}"></script>
    <!-- main js -->
    <script src="{{asset('libs/js/main-js.js')}}"></script>
	
	<!--Tingle--> '?ver='.rand(56,99999)
    <script src="{{asset('lib/tingle/tingle.min.js')}}"></script>
    <script src="{{asset('lib/tingle/tingle-init.js?ver='.rand(56,99999))}}"></script>
<?php
}
?>    

</body>
 
</html>
