<?php
$title = "Tickets";
$subtitle = "View all support tickets raised on the platform.";
$pu = url('add-ticket');
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
<?php echo $__env->make('page-header',['title' => "Tickets",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Tickets</h5>
							<a href="<?php echo e($pu); ?>" class="btn btn-outline-secondary">Add ticket</a>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Ticket ID</th>
                                                <th>Raised by</th>
                                                <th>Subject</th>
                                                <th>Type</th>
                                                <th>Resource</th>
                                                <th>Date raised</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?php
									    if(count($tickets) > 0)
										{
										  foreach($tickets as $t)
										   {
											   $vu = url('ticket')."?xf=".$t['ticket_id'];
											   $ru = url('remove-ticket')."?xf=".$t['ticket_id'];
											   
											    $guest = $t['user'];
										        $avatar = $guest['avatar'];
                                         
										        if($avatar == "") $avatar = [asset("images/avatar.png")];
										        $gname = $guest['fname']." ".$guest['lname'];
										        $uu = url('user')."?xf=".$guest['email'];
												
												
									   ?>
                                            <tr>
                                                <td><?php echo e($t['ticket_id']); ?></td>
                                                <td>
												  <a href="<?php echo e($uu); ?>">
												   <div class="form-control hover">
										             <img class="rounded-circle mr-3 mb-3" src="<?php echo e($avatar[0]); ?>" alt="<?php echo e($gname); ?>" style="width: 100px; height: 100px;"/><br>
											         <?php echo e($gname); ?> 
										           </div>
												  </a>
												</td>
                                                <td><?php echo e($t['subject']); ?></td>
                                                <td><span class="label label-success"><?php echo e(strtoupper($t['type'])); ?></span></td>
												<td>
												<?php
												 if(count($t['resource']) < 1)
												 {
												?>
												<a href="javascript:void(0)">None specified</a>
												<?php
												 }
												 else if($t['type'] == "apartment")
												 {
													 
														 $apartment = $t['resource'];
														 $au = url('apartment')."?xf=".$apartment['apartment_id'];
														 $name = $apartment['name'];
														 $cmedia = $apartment['cmedia'];
														 $imgs = $cmedia['images'];
												?>
												 <a href="<?php echo e($au); ?>">
												   <div class="form-control hover">
										             <img class="rounded-circle mr-3 mb-3" src="<?php echo e($imgs[0]); ?>" alt="<?php echo e($name); ?>" style="width: 100px; height: 100px;"/><br>
												     <?php echo e($name); ?>

										           </div>
												 </a>
												 <?php
												 }
												 ?>
												</td>
                                                <td>
												 <a class="btn btn-primary btn-sm" href="<?php echo e($vu); ?>">View</a>
												 <a class="btn btn-danger btn-sm" href="<?php echo e($ru); ?>">Remove</a>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/tickets.blade.php ENDPATH**/ ?>