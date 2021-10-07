<?php
$title = "Add FAQ Tag";
$subtitle = "Adda category for FAQs";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add FAQ Tag</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-faq-tag')); ?>" id="faq-tag-form" method="post">
										<?php echo csrf_field(); ?>

										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-tag">Tag</label>
                                            <input id="faq-tag" type="text" placeholder="Tag e.g payment" name="tag" class="form-control">
                                        </div>
                                        <div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-name">Name</label>
                                            <input id="faq-name" type="text" placeholder="Tag title e.g Payments and Billing" name="name" class="form-control">
                                        </div>
										</div>
										
										
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="faq-tag-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/add-faq-tag.blade.php ENDPATH**/ ?>