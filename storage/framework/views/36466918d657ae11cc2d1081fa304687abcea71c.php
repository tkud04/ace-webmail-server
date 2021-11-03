<?php
$void = "javascript:void(0)";
$xf = $m['id'];
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<script>
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

</script>
<input type="hidden" id="u" value="<?php echo e($user->username); ?>">
<input type="hidden" id="m" value="<?php echo e($xf); ?>">
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
							 <div class="row">
							    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							 <ul class="list-inline">
							  <li class="list-inline-item"><a id="spam-btn" href="<?php echo e(url($m['label'])); ?>" class="btn" title="Back"><i class="fa fa-fw fa-arrow-circle-left menu-icon"></i></a></li>
							  
							   <li class="list-inline-item"><a id="spam-btn" href="<?php echo e($void); ?>" class="btn" title="Mark as Spam" onclick="markSpam(<?php echo e($xf); ?>)"><i class="fa fa-fw fa-exclamation-triangle menu-icon"></i></a></li>
							 
							   <?php if($m['label'] != "trash"): ?>
							 <li class="list-inline-item"><a id="trash-btn" href="<?php echo e($void); ?>" class="btn" title="Delete forever" onclick="trash(<?php echo e($xf); ?>)"><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							   <?php else: ?>
 							<li class="list-inline-item"><a id="trash-btn" href="<?php echo e($void); ?>" class="btn" title="Move to trash" onclick="deleteMessage(<?php echo e($xf); ?>)"><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							   <?php endif; ?>
							<li class="list-inline-item">|</li>
							 <li class="list-inline-item"><a id="unread-btn" href="<?php echo e($void); ?>" class="btn" title="Mark as Unread" onclick="markUnread(<?php echo e($xf); ?>)"><i class="fa fa-fw fa-envelope menu-icon"></i></a></li>
							  <li class="list-inline-item">
								<div class="dropdown">
                                <a id="move-btn" href="<?php echo e($void); ?>" class="btn dropdown-toggle" title="Move to" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-folder-open menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
								    <?php if($m['label'] == "inbox"): ?>
                                    <a class="dropdown-item" href="<?php echo e($void); ?>" onclick="markSpam(<?php echo e($xf); ?>)">Spam</a>
								    <?php elseif($m['label'] == "spam"): ?>
                                    <a class="dropdown-item" href="<?php echo e($void); ?>" onclick="moveToInbox(<?php echo e($xf); ?>)">Inbox</a>
									<?php endif; ?>
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
									
									<div class="mb-5">
									<?php echo $m['content']; ?>

									</div>
									<div class="mb-3">
									<?php
									  $atts = $m['attachments'];
									  if(count($atts) > 0)
									  {
										  foreach($atts as $a)
										  {
										    $du = url('dl')."?xf=".$a['id']."&uid=".rand(10000,1244567997);
											$as = $a['size']; $asd = $as; $asd2 = " bytes";
											if($as >= 999999)
											{
												$asd = $as / 1000000; $asd2 = " MB";
											}
											elseif($as >= 999 && $as <= 999999)
											{
												$asd = $as / 1000; $asd2 = " KB";
											}
									?>
									  <div id="att-<?php echo e($xf); ?>-div" class="inline-flex">
									  <a id="att-<?php echo e($xf); ?>" href="<?php echo e($du); ?>" target="_blank"><i class="fa fa-fw fa-paperclip"></i> <?php echo e($a['filename']); ?> - <?php echo e($asd.$asd2); ?></a>
									  </div>
									<?php
									      }
									  }
									?>
									</div>
									<center>
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
									  <input class="form-control" id="forward-to" placeholder="Recipient">
									  <textarea class="form-control mb-2" name="forward" id="forward-box" rows="15" cols="50" placeholder="Content (optional)"></textarea>
									</div>
									</div>
									<div id="edit-actions">
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/message.blade.php ENDPATH**/ ?>