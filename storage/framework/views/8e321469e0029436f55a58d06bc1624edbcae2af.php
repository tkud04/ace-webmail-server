<?php
$void = "javascript:void(0)";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<scriptt>
$(document).ready(() => {
	$('#reply-form').removeClass("d-inline-flex");
	$('#reply-form').hide();
	$('#edit-loading').hide();
	$('#forward-form').removeClass("d-inline-flex");
	$('#forward-form').hide();
	$('#edit-actions').removeClass("d-inline-flex");
	$('#edit-actions').hide();
	 $('#reply-to').flexselect();
	 $('#forward-to').flexselect();
});

</scriptt>
<input type="hidden" id="u" value="<?php echo e($user->username); ?>">
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
                                    <a id="more-reply" class="dropdown-item" href="<?php echo e($void); ?>">Reply</a>
                                    <a id="more-forward" class="dropdown-item" href="<?php echo e($void); ?>">Forward</a>
                                    <a id="more-mark-unread" class="dropdown-item" href="<?php echo e($void); ?>">Mark as unread</a>
                                    <a id="more-mark-spam" class="dropdown-item" href="<?php echo e($void); ?>">Mark as spam</a>
                                    <a id="more-delete" class="dropdown-item" href="<?php echo e($void); ?>">Delete</a>
                                  </div>
                                </div>
                                </div>
                                </div>
									  </div><hr>
									</div>
                                    
                                    <div class="col-md-12">
									<center>
									<div class="mb-5">
									<?php echo $m['content']; ?>

									</div>
									<div class="d-inline-flex" id="edit-menu">
									   <a id="reply-btn" class="btn btn-outline-primary" href="<?php echo e($void); ?>"><i class="fa fa-fw fa-reply"></i> Reply</a>
									   <a id="forward-btn" class="btn btn-outline-primary" href="<?php echo e($void); ?>"><i class="fa fa-fw fa-forward"></i> Forward</a>
									</div>
									<div class="d-inline-flex" id="reply-form">
									<div><i class="fa fa-2x fa-fw fa-user-circle"></i></div>
									<div>
									 
									 <textarea class="form-control" name="reply" id="reply-box" rows="15" cols="50" placeholder="Content"></textarea>
									</div>
									</div>
									<div class="d-inline-flex" id="forward-form">
									<div><i class="fa fa-2x fa-fw fa-user-circle"></i></div>
									<div>
									  <select class="form-control" id="forward-to">
                                                <option value="none">Recipient</option>
                                                   <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                           <option value="<?php echo e($c); ?>"><?php echo e($c); ?></option>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									 </select>
									  <textarea class="form-control mb-2" name="forward" id="forward-box" rows="15" cols="50" placeholder="Content (optional)"></textarea>
									</div>
									</div>
									<div class="d-inline-flex" id="edit-actions">
									   <a id="submit-btn" class="btn btn-outline-primary" href="<?php echo e($void); ?>"><i class="fa fa-fw fa-rocket"></i> Submit</a>
									   <a id="discard-btn" class="btn btn-outline-danger" href="<?php echo e($void); ?>"><i class="fa fa-fw fa-trash"></i> Discard</a>
									</div>
									<h4 id="edit-loading">Sending.. <img src="<?php echo e(asset('images/loading.gif')); ?>" class="img img-fluid" alt="Sending.."></h4>
									</center>
									
							        </div>
							    </div>
							 </div>
						</div>
                    </div>
                </div>			
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/new-message.blade.php ENDPATH**/ ?>