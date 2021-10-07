<?php
$blank = true;
?>



<?php $__env->startSection('title',"Reset Password"); ?>

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
            <div class="card-header text-center"><a href="<?php echo e(url('/')); ?>"><h3>ETUK ADMIN</h3></a><span class="splash-description">Reset Password</span></div>
            <div class="card-body">
                <form method="post" id="fp-form">
                  <input type="hidden" id="acsrf" value="<?php echo e($uu->id); ?>"/>
				 <input type="hidden" id="tk-rp" value="<?php echo e(csrf_token()); ?>"/>
					
					 <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="rp-pass" type="password" placeholder="New password">
                    </div>
					 <div class="form-group">
                        <input class="form-control form-control-lg" name="password2" id="rp-pass2" type="password" placeholder="Confirm password">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="rp-submit">Submit</button>
					
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                  <h4 class="text-primary" id="rp-loading">Processing your request.. <img alt="Loading.." src="<?php echo e(asset('images/loader.svg')); ?>"></h4>
					<h4 class="text-primary" id="rp-finish"><b>Password reset!</b><p class='text-primary'>You can now <a href="<?php echo e(url('hello')); ?>">sign in</a>.</p></h4>    
				</div>
            </div>
        </div>
    </div>
 	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/reset.blade.php ENDPATH**/ ?>