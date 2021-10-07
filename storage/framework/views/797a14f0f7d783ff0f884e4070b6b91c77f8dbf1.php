<?php
$title = "Reviews";
$subtitle = "View all user reviews";
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
                            <h5 class="card-header">Reviews</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Apartment</th>
                                                <th>Rating</th>
                                                <th>Comment</th>
                                                <th>Date Added</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($reviews) > 0)
										   {
											  foreach($reviews as $r)
											   {
												   $a = $r['apartment'];
						     			        $statusClass = "danger";
												$arrClass = "success";
												$arrText = "Approve";
;
											   $name = $a['name'];
											   $uu = url('apartment')."?xf=".$a['apartment_id'];
											    $sss = $r['status'];
												
												if($sss == "approved")
												{
													$statusClass = "success";
													$arrClass = "warning";
													$arrText = "Reject";
												}
											   $imgs = $a['cmedia']['images'];

												   $arr = url('arr')."?xf=".$r['id']."&type=".strtolower($arrText);
												   $dr = url('dr')."?xf=".$r['id'];
												   $ar = ($r['service'] + $r['location'] + $r['security'] + $r['cleanliness'] + $r['comfort']) / 5;
										  ?>
                                            <tr>
                                               <td>
												  <img class="img-fluid" onclick="window.location='<?php echo e($uu); ?>'" src="<?php echo e($imgs[0]); ?>" alt="<?php echo e($name); ?>" style="cursor: pointer; width: 100px; height: 100px;"/>
												  <a href="<?php echo e($uu); ?>"><h4><?php echo e(ucwords($name)); ?></h4></a><br>							  
												</td>
												<td>
												  <h3>
												   <?php for($i = 0; $i < $ar; $i++): ?>
												     <i class="fas fa-star"></i>
											       <?php endfor; ?>
												  </h3>
												  <ul>
												    <li>Service: <b><?php echo e($r['service']); ?></b></li>
												    <li>Location: <b><?php echo e($r['location']); ?></b></li>
												    <li>Security: <b><?php echo e($r['security']); ?></b></li>
												    <li>Cleanliness: <b><?php echo e($r['cleanliness']); ?></b></li>
												    <li>Comfort: <b><?php echo e($r['comfort']); ?></b></li>
												  </ul>							  
												</td>
                                                <td><em><?php echo e($r['comment']); ?></em></td>
                                                <td><?php echo e($r['date']); ?></td>
                                                <td><span class="label label-<?php echo e($statusClass); ?>"><?php echo e(strtoupper($r['status'])); ?></td>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/reviews.blade.php ENDPATH**/ ?>