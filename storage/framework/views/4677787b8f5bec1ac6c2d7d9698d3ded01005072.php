<?php
$title = "Banners";
$subtitle = "View all uploaded banner images";
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
                            <h5 class="card-header">Banners</h5>
							<a href="<?php echo e(url('add-banner')); ?>" class="btn btn-outline-secondary">Add banner</a>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                 <th>Image</th>
                                                 <th>Type</th>
                                                 <th>Cover Image</th>
                                                 <th>Added by</th>
                                                 <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($banners) > 0)
										   {
											  foreach($banners as $b)
											   {
												    $img = $b['url'];
							                        $author = $b['author'];
										            $avatar = $author['avatar'];
                                                    if($avatar == "") $avatar = [asset("images/avatar.png")];
										            $aname = $author['fname']." ".$author['lname'];
													$ru = url('remove-banner')."?xf=".$b['id'];
													$ss = $b['cover'] == "yes" ? "badge-primary" : "badge-warning";
													
													$sci = url('update-banner')."?xf=".$b['id']."&type=".$b['type']."&sci=yes";
													$sciText = "Set as first image";
													
													if($b['cover'] == "yes")
													{
														$sci = url('update-banner')."?xf=".$b['id']."&type=".$b['type']."&sci=no";
													    $sciText = "Remove as first image";
													}
										  ?>
                                            <tr>
                                                <td><img class="mr-3 mb-3" src="<?php echo e($img); ?>" alt="Banner" style="width: 192px; height: 100px;"/><br></td>
                                                <td><?php echo e(ucwords($b['type'])); ?></td>
                                                <td><span class="badge <?php echo e($ss); ?>"><?php echo e(ucwords($b['cover'])); ?></span></td>
												<td>
												  <img class="rounded-circle mr-3 mb-3" src="<?php echo e($avatar[0]); ?>" alt="<?php echo e($aname); ?>" style="width: 100px; height: 100px;"/>
												  <br><?php echo e($aname); ?>

												</td>
					                            
					                            <td>
						                          <a class="btn btn-outline-primary" href="<?php echo e($sci); ?>"><?php echo e($sciText); ?></a>
						                          <a class="btn btn-outline-danger" href="<?php echo e($ru); ?>">Remove</a>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/banners.blade.php ENDPATH**/ ?>