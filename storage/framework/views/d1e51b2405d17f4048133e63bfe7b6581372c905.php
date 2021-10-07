<?php
$title = "Add Ticket";
$subtitle = "Raise a new support ticket.";
?>



<?php $__env->startSection('title',$title); ?>

<?php $__env->startSection('scripts'); ?>
  <!-- DataTables CSS -->
  <link href="<?php echo e(asset('lib/datatables/css/buttons.bootstrap.min.css')); ?>" rel="stylesheet" /> 
  <link href="<?php echo e(asset('lib/datatables/css/buttons.dataTables.min.css')); ?>" rel="stylesheet" /> 
  <link href="<?php echo e(asset('lib/datatables/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" /> 
  
      <!-- DataTables js -->
       <script src="<?php echo e(asset('lib/datatables/js/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/datatables-init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Add Ticket",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Ticket</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-ticket')); ?>" id="add-ticket-form" method="post">
										<?php echo csrf_field(); ?>

										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
                                            <label>Guest Email <span class="text-danger text-bold">*</span></label>
                                            <input id="add-ticket-email" type="email" name="email" placeholder="Guest's registered email address" class="form-control">
                                        </div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
										    <label>Type <span class="text-danger text-bold">*</span></label>
                                             <?php
											 $types = ['apartment','billing','other'];
											?>
											<select id="add-ticket-type" name="type" class="form-control">
											 <option value="none">Select complaint category</option>
											 <?php
											  foreach($types as $t)
											  {
										     ?>
											 <option value="<?php echo e($t); ?>"><?php echo e(ucwords($t)); ?></option>
											  <?php
											  }
											  ?>
											</select>
                                            
                                        </div>
										</div>
										</div>
										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
                                            <label>Subject <span class="text-danger text-bold">*</span></label>
                                            <input id="add-ticket-subject" type="text" name="subject" placeholder="Subject of complaint" class="form-control">
                                        </div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
                                            <label for="user-lname">Resource ID</label>
                                            <input id="add-ticket-apt" type="text" name="id" value="" placeholder="Apartment ID, order reference#, etc" class="form-control">
                                        </div>
										</div>
										</div>
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Message <span class="text-danger text-bold">*</span></label>
											<textarea class="form-control" id="add-ticket-msg" name="msg" rows="15" placeholder="Describe your complaint here.. Max 1000 words"></textarea>
                                        </div>
										</div>
										</div>
										
                                        <div class="row">
                                            <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                                                <label class="be-checkbox custom-control custom-checkbox">
                                                   <span class="custom-control-label">Your complaint will be forwarded to our support staff and you will be notified of replies via email.</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-6 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="add-ticket-form-btn">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>		
</div>		
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/add-ticket.blade.php ENDPATH**/ ?>