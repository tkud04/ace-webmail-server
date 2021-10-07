<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<title><?php echo $__env->yieldContent('title'); ?> | Etuk NG Admin Center</title>
	
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/bootstrap/css/bootstrap.min.css')); ?>">
    <link href="<?php echo e(asset('vendor/fonts/circular-std/style.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('libs/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/fonts/fontawesome/css/fontawesome-all.css')); ?>">
    
	<!-- custom css -->
	  <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
	  
    <!-- jquery 3.3.1 -->
    <script src="<?php echo e(asset('vendor/jquery/jquery-3.3.1.min.js')); ?>"></script>
	 <!-- bootstrap bundle js -->
    <script src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.bundle.js')); ?>"></script>
	
	<!-- custom js -->
	<script src="<?php echo e(asset('js/helpers.js').'?ver='.rand(56,99999)); ?>"></script>
	<script src="<?php echo e(asset('js/mmm.js').'?ver='.rand(56,99999)); ?>"></script>
	
	<!--Simeditor--> 
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('lib/simeditor/css/simditor.css')); ?>" />
        <script type="text/javascript" src="<?php echo e(asset('lib/simeditor/js/module.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('lib/simeditor/js/hotkeys.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('lib/simeditor/js/uploader.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('lib/simeditor/js/simditor.js')); ?>"></script>		
	
	<!--SweetAlert--> 
    <link href="<?php echo e(asset('lib/sweet-alert/sweetalert2.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('lib/sweet-alert/sweetalert2.js')); ?>"></script>
	
	<?php echo $__env->yieldContent('styles'); ?>
	<?php echo $__env->yieldContent('scripts'); ?>
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
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">ETUK NG</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
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
                       
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="javascript:void(0)" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo e(asset('images/avatar.png')); ?>" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <?php
								 if($user == null)
								 {
								?>
								<div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">Guest</h5>
                                    <span class="status"></span><span class="ml-2">Sign in</span>
                                </div>
                                <a class="dropdown-item" href="<?php echo e(url('hello')); ?>"><i class="fas fa-key mr-2"></i>Sign in</a>
                               <?php
								 }
								 else
								 {
									 $n = $user->fname." ".$user->lname;
								?>
                                 <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"><?php echo e($n); ?></h5>
                                    <h5 class="mb-0 text-white nav-user-name"><?php echo e($user->email); ?></h5>
                                    <span class="status"></span><span class="ml-2"><?php echo e(strtoupper($user->role)); ?></span>
                                </div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="<?php echo e(url('bye')); ?>"><i class="fas fa-power-off mr-2"></i>Logout</a>								
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
      
	   <?php echo $__env->make('sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	  
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <?php echo $__env->yieldContent('page-header'); ?>
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

                 <?php if($pop != "" && $val != ""): ?>
                   <?php echo $__env->make('session-status',['pop' => $pop, 'val' => $val], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                 <?php endif; ?>
        	<!--------- Input errors -------------->
                    <?php if(count($errors) > 0): ?>
                          <?php echo $__env->make('input-errors', ['errors'=>$errors], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     <?php endif; ?> 
				<?php echo $__env->yieldContent('content'); ?>
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
                             Copyright &copy; <?php echo e(date("Y")); ?> Etuk NG. All rights reserved.
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
    <script src="<?php echo e(asset('vendor/slimscroll/jquery.slimscroll.js')); ?>"></script>
    <!-- main js -->
    <script src="<?php echo e(asset('libs/js/main-js.js')); ?>"></script>
<?php
}
?>    

</body>
 
</html>
<?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/layout.blade.php ENDPATH**/ ?>