<?php
$title = "Add Permissions";
$subtitle = "Grant one or more permissions to this user.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Permissions",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
let apTags = [];
$(document).ready(() => {
	apTags = [
	<?php
	 for($i = 0; $i < count($permissions); $i++)
	 {
		 $p = $permissions[$i];
	?>
	{ptag: "<?php echo e($p); ?>",selected: false}<?php if($i != count($permissions) - 1): ?>,<?php endif; ?>
	<?php
	 }
	?>
	];
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Permissions</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-permissions')); ?>" id="ap-form" method="post">
										<?php echo csrf_field(); ?>

										<input type="hidden" name="xf" value="<?php echo e($u['id']); ?>"/>
										<input type="hidden" name="pp" id="ap-pp" value=""/>
                                        
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ap-email">Email address</label>
                                            <input id="user-email" type="email" value="<?php echo e($u['email']); ?>" placeholder="Enter email address" class="form-control" readonly>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Select Permission(s)</h4>
                                            <?php
											for($i=0; $i < count($permissions); $i++)
											{
												$pp = $permissions[$i];
											?>
											<label class="custom-control custom-control-inline custom-checkbox">
                                                <input type="checkbox" onchange="togglePP('<?php echo e($pp); ?>')" class="custom-control-input"><span class="custom-control-label"><?php echo e($pp); ?></span>
                                            </label>
											<?php
											}
											?>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                                                <label class="be-checkbox custom-control custom-checkbox">
                                                   <span class="custom-control-label">Last updated: <em><?php echo e($u['updated']); ?></em></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-6 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ap-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/add-permissions.blade.php ENDPATH**/ ?>