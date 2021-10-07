<?php
$blank = true;
?>



<?php $__env->startSection('title',"Signup"); ?>

<?php $__env->startSection('styles'); ?>
<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
			  <a href="<?php echo e(url('/')); ?>"><h3>ACE WEBMAIL</h3></a>
			  <img src="images/logo.png" style="width: 80px; height: 80px;"/>
			  <span class="splash-description">Signup to continue.</span>
			</div>
            <div class="card-body">
                <form method="post" action="<?php echo e(url('signup')); ?>" id="s-form">
                    <?php echo csrf_field(); ?>

					
					<div class="row">
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="fname" id="signup-fname" type="text" placeholder="First name" autocomplete="off">
                      </div>
                     </div> 
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="lname" id="signup-lname" type="text" placeholder="Last name" autocomplete="off">
                      </div>
                     </div>
                    </div>
					<div class="row">
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="signup-username" type="text" placeholder="Desired username" autocomplete="off">
                      </div>
                     </div> 
					 <div class="col-md-6">
					  <div class="form-group">
                        <p class="form-control-plaintext">@aceluxurystore.com</p>
                      </div>
                     </div>
                    </div>
					<div class="row">
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="pass" id="signup-password" type="password" placeholder="Password">
                    </div>
                     </div> 
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="pass_confirmation" id="signup-password-2" type="password" placeholder="Confirm password">
                    </div>
                     </div>
                    </div>
                    
                    <button class="btn btn-primary btn-lg btn-block" id="s-form-btn">Sign up</button>
                </form>
		

							
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="<?php echo e(url('login')); ?>" class="footer-link">Log in</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="<?php echo e(url('forgot-password')); ?>" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
 	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/signup.blade.php ENDPATH**/ ?>