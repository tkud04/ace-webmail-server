<?php
$title = "Apartments";
$subtitle = "View all apartments";
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
                        <div class="card">
                            <h5 class="card-header">View all apartments</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Apartment</th>
                                                <th>Rating</th>
												<th>Host</th>
                                                <th>Subscription plan</th>
                                                <th>Date Added</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($apartments) > 0)
										   {
											  foreach($apartments as $a)
											   {
												$statusClass = "danger";
												$arrClass = "success";
												$arrText = "Approve";
												
												$h = $a['host'];

											   $name = $a['name'];
											   $uu = url('apartment')."?xf=".$a['apartment_id'];
											    $sss = $a['status'];
												
												if($sss == "approved")
												{
													$statusClass = "success";
													$arrClass = "warning";
													$arrText = "Reject";
												}
											   $imgs = $a['cmedia']['images'];

												   $arr = url('uas')."?axf=".$a['apartment_id']."&type=".strtolower($arrText);
												   $dr = url('remove-apartment')."?axf=".$a['apartment_id'];
												   $ar = $a['rating'];
										  ?>
                                            <tr>
                                               <td>
												  <img class="img-fluid" onclick="window.location='<?php echo e($uu); ?>'" src="<?php echo e($imgs[0]); ?>" alt="<?php echo e($name); ?>" style="cursor: pointer; width: 100px; height: 100px;"/>
												  <a href="<?php echo e($uu); ?>"><h4><?php echo e(ucwords($name)); ?></h4></a>					  
												  <a href="<?php echo e($uu); ?>"><h4><?php echo e($a['apartment_id']); ?></h4></a><br>							  
												</td>
												<td>
												  <h3>
												   <?php for($i = 0; $i < $ar; $i++): ?>
												     <i class="fas fa-star"></i>
											       <?php endfor; ?>
												  </h3>						  
												</td>
                                                <td>
												  Name: <em><?php echo e($h['fname']." ".$h['lname']); ?></em><br>
												  Phone no: <em><?php echo e($h['phone']); ?></em><br>
												  Email: <em><?php echo e($h['email']); ?></em><br>
												</td>
                                                <td>None</td>
                                                <td><?php echo e($a['date']); ?></td>
                                                <td><span class="label label-<?php echo e($statusClass); ?>"><?php echo e(strtoupper($sss)); ?></span></td>
                                                <td>
												 <a class="btn btn-<?php echo e($arrClass); ?> btn-sm" href="<?php echo e($arr); ?>"><?php echo e($arrText); ?></a>
												 <a class="btn btn-danger btn-sm" href="<?php echo e($dr); ?>">Remove</a>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/apartments.blade.php ENDPATH**/ ?>