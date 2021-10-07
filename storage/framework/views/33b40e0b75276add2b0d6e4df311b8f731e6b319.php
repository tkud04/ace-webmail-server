<?php
$title = "Update Ticket";
$subtitle = "Update the ticket trail of a complaint/issue.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Update Ticket",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Re: <?php echo e($t['subject']); ?></h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('update-ticket')); ?>" id="ut-form" method="post">
										<?php echo csrf_field(); ?>

										<input type="hidden" name="xf" value="<?php echo e($t['ticket_id']); ?>">
										<div class="row">
										  <div class="col-md-12">
										     <div class="form-group">
                                               <label>Your message</label>
                                               <textarea class="form-control" name="msg" id="ut-msg"></textarea>
                                              </div>
										   </div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ut-form-btn">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/update-ticket.blade.php ENDPATH**/ ?>