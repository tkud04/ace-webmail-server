<?php
$title = "Senders";
$subtitle = "View all registered plugins";
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
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<a href="<?php echo e(url('add-sender')); ?>" class="btn btn-outline-secondary">Add sender</a>
                        <div class="card">
                            <h5 class="card-header">Senders</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
			                                     <th>Host</th>
			                                     <th>Login</th>
			                                     <th>Current sender</th>
                                            </tr>
                                        </thead>
                                        <tbody>
					  							  <?php
							  
					  					  if(count($senders) > 0)
					  					  {
					  						 foreach($senders as $s)
					  						 {
					  							 $ss = $s['ss'];
					  							$su = $s['su'];
					  							$vu = url('sender')."?s=".$s['id'];
					  							$ru = url('remove-sender')."?s=".$s['id'];
					  							$mu = url('mark-sender')."?s=".$s['id'];
							 
							
					  				    ?>
					                        <tr>
					   
					  					   <td><?php echo $ss; ?></td>
					  					  <td><?php echo $su; ?></td>
					  					  <td>
					  					   <?php if($s['current'] == "yes"): ?>
					  					    <h3 class="badge badge-info">CURRENT</h3>
					  					   <?php else: ?>
					  						 <a class="btn btn-outline-secondary" href="<?php echo e($mu); ?>">Set as current</a>
					  				       <?php endif; ?>
					  					  </td>
					  					   <td>
					  						<a class="btn btn-outline-secondary" href="<?php echo e($vu); ?>">View</a>
					  						<a class="btn btn-outline-secondary" href="<?php echo e($ru); ?>">Remove</a>
					                         </td>
					
					  					 </tr>
					  					<?php
					  						 }  
					  					  }
					                      ?>
									   </tbody>
									</table>
							    </div>
							 </div>
						</div>
                    </div>
                </div>			
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/senders.blade.php ENDPATH**/ ?>