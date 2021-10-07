<?php
$user = null;
$cart = ['data' => [],'subtotal' => 0];
$messages = [];
$title = "Page Not Found";
$subtitle = "We checked very hard but could not find what you were looking for";
?>


<?php $__env->startSection('title',$title); ?>

<?php $__env->startSection('content'); ?>
<!-- ============================ 404 Dashboard ================================== -->
			<section class="error-wrap">
				<div class="container">
					<div class="row justify-content-center">
						
						<div class="col-lg-6 col-md-10">
							<div class="text-center">
								
								<h2><?php echo e($subtitle); ?></h2>
								<a class="btn btn-theme" href="<?php echo e(url('/')); ?>">Back To Home</a>
								
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ 404 End ================================== -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/errors/404.blade.php ENDPATH**/ ?>