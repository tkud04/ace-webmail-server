<?php
$title = "Add Apartment Tip";
$subtitle = "Add a tip or piece of information to show guests when viewing an apartment";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header"><?php echo e($title); ?></h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-apartment-tip')); ?>" id="aat-form" method="post">
										<?php echo csrf_field(); ?>

										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Title (optional)</label>
                                            <input id="aat-title" type="text" placeholder="Enter a title for your tip" name="title" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="aat-message">Message</label>
                                             <textarea class="form-control" name="message" placeholder="Your message" id="aat-message"></textarea>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="aat-form-btn">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/add-apartment-tip.blade.php ENDPATH**/ ?>