<?php
$void = "javascript:void(0)";
?>



<?php $__env->startSection('title',$title); ?>

<?php $__env->startSection('scripts'); ?>
  <!-- DataTables CSS -->
    <link href="<?php echo e(asset('lib/datatables/css/datatables.min.css')); ?>" rel="stylesheet" /> 
	
	<!-- DataTables js -->
	<script src="<?php echo e(asset('lib/datatables/js/datatables.min.js')); ?>"></script>
	 <script src="<?php echo e(asset('lib/datatables/js/datatables-init.js')); ?>"></script>
	 
<script>
$(document).ready(() => {
	hideElem(xx);
	
	$('.mm').change((e) => {
		e.preventDefault();
		
		let ims = isMessageSelected('mm');

		if(ims){
			showElem(xx);
		}
		else{
			hideElem(xx);
		}
	});
});

</script>
  <?php $__env->stopSection(); ?>
  
  <?php $__env->startSection('scriptss'); ?>
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
   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<input type="hidden" id="u" value="<?php echo e($user->username); ?>">
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
							 <div class="row">
							    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							 <ul class="list-inline"  style="overflow-x: scroll;">
							  <li class="list-inline-item"><input type="checkbox" id="mm-all"></li>
							  <li class="list-inline-item"><a id="refresh-all-btn" href="<?php echo e($label); ?>" class="btn" title="Refresh"><i class="fa fa-fw fa-undo menu-icon"></i></a></li>
							  <li class="list-inline-item"><a class="spam-all-btn" href="<?php echo e($void); ?>" class="btn" title="Mark as Spam"><i class="fa fa-fw fa-exclamation-triangle menu-icon"></i></a></li>
							  <?php if($label == "trash"): ?>
							  <li class="list-inline-item"><a id="delete-all-btn" href="<?php echo e($void); ?>" class="btn" title="Delete forever" ><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							  <?php else: ?>
							  <li class="list-inline-item"><a id="trash-all-btn" href="<?php echo e($void); ?>" class="btn" title="Delete" ><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							  <?php endif; ?>
							 <li class="list-inline-item"><a id="unread-all-btn" href="<?php echo e($void); ?>" class="btn" title="Mark as Unread"><i class="fa fa-fw fa-envelope menu-icon"></i></a></li>
							 <li class="list-inline-item">
								<div class="dropdown">
                                <a id="move-btn" href="<?php echo e($void); ?>" class="btn dropdown-toggle" title="Move to" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-folder-open menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
								   <a class="spam-all-btn" class="dropdown-item" href="<?php echo e($void); ?>">Spam</a>
                                    <a class="inbox-all-btn" class="dropdown-item" href="<?php echo e($void); ?>">Inbox</a>
                                  </div>
                                </div>
							  </li>			  
							 </ul>  
							</div>	  
							</div>	  
								  
							
							</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table first etuk-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($msgs) > 0)
										   {
											  foreach($msgs as $m)
											   {
												   $sn = "<p>{$m['sn']}</p>";
												   $subject = "<p>{$m['subject']}</p>";
												   $ss  = $m['excerpt'];
												   $xf = $m['id'];
												   $vu = url('message')."?xf=".$xf;
												   if($m['status'] == "unread")
												   {
													   //$b = "text-bold";
													  $sn = "<p><span class='label label-success p-2'>{$m['sn']}</span></p>";
												   }
										  ?>
                                            <tr>
                                                <td>
                                                	<a href="<?php echo e($vu); ?>">
													<?php if(!app('mobile-detect')->isMobile()) : ?>
                                                	 <div class="d-flex justify-content-between">
													   <div class="d-inline-flex mt-3">
                                                	    <div><input type="checkbox" class="mm mr-2" data-xf="<?php echo e($xf); ?>"></div>  
													     <div><?php echo $sn; ?></div>
                                               	       </div>
													   <div class="d-inline-flex mt-3">
                                                	   <div><?php echo $subject; ?></div>
                                                	   <div class="ml-1 mr-1"> - </div>
                                                	   <div style="color: #ccc;"><?php echo $ss; ?>...</div>
                                               	       </div>
													   <div class="d-inline-flex  mt-3">
                                                	     <div><?php echo e($m['dd']); ?></div>
                                               	       </div>
                                               	      </div>
													  <?php else: ?>
													   <div class="row">
													      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														   <div class="d-flex justify-content-between">
													         <div class="d-inline-flex mt-3">
                                                	          <div><input type="checkbox" class="mm mr-2" data-xf="<?php echo e($xf); ?>"></div>  
                                               	             </div>
													         <div class="mt-3">
													          <div><?php echo $sn; ?></div>															 
                                                	          <div class="mt-3"><?php echo $subject; ?></div>
                                                	          <div style="color: #b3b3b3;"><?php echo $ss; ?>...</div>
                                               	             </div>
													         <div class=" mt-3">
                                                	           <div><?php echo e($m['dd']); ?></div>
                                               	             </div>
                                               	           </div>
													      </div>
													   </div>
													  <?php endif; ?>
                                                   </a>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/messages.blade.php ENDPATH**/ ?>