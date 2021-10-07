<?php
$blank = true;
?>



<?php $__env->startSection('title',"Login"); ?>

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
            <div class="card-header text-center"><a href="<?php echo e(url('/')); ?>"><h3>ETUK ADMIN</h3></a><span class="splash-description">Login to continue.</span></div>
            <div class="card-body">
                <form method="post" action="<?php echo e(url('hello')); ?>" id="l-form">
                    <?php echo csrf_field(); ?>

					
					<div class="form-group">
                        <input class="form-control form-control-lg" name="id" id="login-id" type="text" placeholder="Email address" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="login-password" type="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="l-form-btn">Sign in</button>
                </form>
				<center><h4>OR</h4></center>
				<?php
							$fbLogin = url('oauth')."?type=facebook";
							$twLogin = url('oauth')."?type=twitter";
							$gLogin = url('oauth')."?type=google";
							?>
							  <a href="<?php echo e($fbLogin); ?>" class="btn btn-outline-primary">Facebook</a>
							  <a href="<?php echo e($twLogin); ?>" class="btn btn-outline-primary">Twitter</a>
							  <a href="<?php echo e($gLogin); ?>" class="btn btn-outline-danger">Google</a>

							
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="javascript:void(0)" class="footer-link">Create An Account</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="<?php echo e(url('forgot-password')); ?>" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
 	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/login.blade.php ENDPATH**/ ?>