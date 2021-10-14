<?php
$void = "javascript:void(0)";
$xf = $m['id'];
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
<script>
$(document).ready(() => {
let addPostContentEditor = new Simditor({
		textarea: $('#reply-box'),
		toolbar: toolbar,
		placeholder: `Enter your post content here. Maximum of 7000 words..`
	});	
});

</script>
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
							 <div class="row">
							    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							 <ul class="list-inline">
							  <li class="list-inline-item"><input type="checkbox" id="mm-all"></li>
							   <li class="list-inline-item"><a id="spam-btn" href="<?php echo e($void); ?>" class="btn" title="Mark as Spam" onclick="markSpam(<?php echo e($xf); ?>)"><i class="fa fa-fw fa-exclamation-triangle menu-icon"></i></a></li>
							  <li class="list-inline-item"><a id="trash-btn" href="<?php echo e($void); ?>" class="btn" title="Delete" onclick="trash()"><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							  <li class="list-inline-item">|</li>
							 <li class="list-inline-item"><a id="unread-btn" href="<?php echo e($void); ?>" class="btn" title="Mark as Unread" onclick="markUnread(<?php echo e($xf); ?>)"><i class="fa fa-fw fa-envelope menu-icon"></i></a></li>
							  <li class="list-inline-item">
								<div class="dropdown">
                                <a id="move-btn" href="<?php echo e($void); ?>" class="btn dropdown-toggle" title="Move to" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-folder-open menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
                                    <a class="dropdown-item" href="<?php echo e($void); ?>" onclick="moveTo({'xf':<?php echo e($xf); ?>,'dest':'spam'})">Spam</a>
                                  </div>
                                </div>
							  </li>
							  <li class="list-inline-item">
								<div class="dropdown">
                                <a id="more-btn" href="<?php echo e($void); ?>" class="btn dropdown-toggle" title="More" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-ellipsis-v menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
                                    <a class="dropdown-item" href="<?php echo e($void); ?>">Action</a>
                                    <a class="dropdown-item" href="<?php echo e($void); ?>">Another action</a>
                                    <a class="dropdown-item" href="<?php echo e($void); ?>">Something else here</a>
                                  </div>
                                </div>
								</li>
							  
							 </ul>  
							</div>	  
							</div>	  
								  
							
							</div>
                            <div class="card-body" style="overflow-y:scroll;">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
									  <div class="d-flex justify-content-between">
										  <div class="d-inline-flex">
										    <div class="mr-2"> <i class="fa fa-2x fa-fw fa-user-circle"></i></div>
										    <div class="d-inline-flex">
											    <div><span class="text-bold mr-2"><?php echo e($m['sn']); ?> </span></div>
												 <div><?php echo e("<".$m['sa'].">"); ?></div>
											</div>
										  </div>
									    <div class="align-self-end">
									    <div class="d-inline-flex">
										  <div><span class="text-bold justify-content-center"><?php echo e($m['date']); ?></span></div>
										   <div><a href="<?php echo e($void); ?>" class="btn" title="Mark as Unread" onclick="reply(<?php echo e($xf); ?>)"><i class="fa fa-fw fa-envelope menu-icon"></i></a></div>
								<div class="dropdown">
                                <a id="more-btn" href="<?php echo e($void); ?>" class="btn dropdown-toggle" title="More" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-ellipsis-v menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
                                    <a class="dropdown-item" href="<?php echo e($void); ?>">Action</a>
                                    <a class="dropdown-item" href="<?php echo e($void); ?>">Another action</a>
                                    <a class="dropdown-item" href="<?php echo e($void); ?>">Something else here</a>
                                  </div>
                                </div>
                                </div>
                                </div>
									  </div><hr>
									</div>
                                    
                                    <div class="col-md-12">
									<center>
									<div>
									<?php echo $m['content']; ?>

									</div>
									<div class="d-inline-flex">
									<div><i class="fa fa-2x fa-fw fa-user-circle"></i></div>
									<div><textarea class="form-control" name="reply" id="reply-box"></textarea></div>
									</div>
									</center>
									
							        </div>
							    </div>
							 </div>
						</div>
                    </div>
                </div>			
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/message.blade.php ENDPATH**/ ?>