<?php
$title = $p['title'];
$subtitle = "View post.";
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
<?php echo $__env->make('page-header',['title' => "Posts",'subtitle' => $p['title']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
							<?php
							$title = $p['title'];
							$url = $p['url'];
							$status = $p['status'];
							$content = $p['content'];
							$comments = $p['comments'];
							$date = $p['date'];
							$updated_at = $p['updated'];
							#$utu = url('update-post')."?xf=".$p['ticket_id'];
							$img = $p['img'];
							
							  $author = $p['author'];
										  $avatar = $author['avatar'];
                                         
										 if($avatar == "") $avatar = [asset("images/avatar.png")];
										  $aname = $author['fname']." ".$author['lname'];
										  $uu = url('user')."?xf=".$author['email'];
										 
							$statusClass = $status == "enabled" ? "label-primary" : "label-danger"; 
							?>

<script>
$(document).ready(() => {
let addPostContentEditor = new Simditor({
		textarea: $('#ap-content'),
		toolbar: toolbar,
		placeholder: `Enter your post content here. Maximum of 7000 words..`
	});
addPostContentEditor.setValue(`<?php echo $content; ?>`);	
});


</script>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <h5 class="card-header">Post Details</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('post')); ?>" method="post" id="ubp-form">
										<?php echo csrf_field(); ?>

										<input type="hidden" name="xf" value="<?php echo e($p['id']); ?>"/>
									    <div class="row">
										
										<div class="col-md-4">
										  <div class="row">
										    <div class="col-md-12">
										      <a href="<?php echo e($uu); ?>">
										      <div class="form-group">
                                                <label>Author</label>
                                                <div class="form-control hover">
										          <img class="rounded-circle mr-3 mb-3" src="<?php echo e($avatar[0]); ?>" alt="<?php echo e($aname); ?>" style="width: 100px; height: 100px;"/><br>
											      <?php echo e($aname); ?> 
										        </div>
                                              </div>
										      </a>
										    </div>
										  </div>
										  <div class="row">
										    <div class="col-md-12">
										      <a href="javascript:void(0)">
										      <div class="form-group">
                                                <label>Image</label>
                                                <div class="form-control hover">
										          <img class="rounded-circle mr-3 mb-3" src="<?php echo e($img); ?>" alt="<?php echo e($title); ?>" style="width: 200px; height: 200px;"/><br>										       
										        </div>
                                              </div>
											  <div class="form-group">
                                            <label for="ap-img">Change image:</label>
                                            <div id="ap-images">
												<div id="ap-image-div-0" class="row">
												  <div class="col-md-7">
												    <input type="file" class="form-control" onchange="readURL(this,{id: 'ap',ctr: '0'})" id="ap-img-0" name="ap-images[]">												    
												  </div>
												  <div class="col-md-5">
												    <img id="ap-preview-0" src="#" alt="preview" style="width: 100px; height: 100px;"/>
													</div>
												</div>
										    </div>
                                        </div>
										      </a>
										    </div>
										  </div>
										</div>
										<div class="col-md-8">
										  <div class="row mb-3">
										    <div class="col-md-12">
										       <div class="form-group">
                                                 <label for="ap-title">Title</label>
                                                 <input id="ap-title" type="text" placeholder="Post title" name="title" value="<?php echo e($title); ?>" class="form-control">
                                               </div>
										    </div>
											<div class="col-md-12">
										       <div class="form-group">
                                                 <label for="ap-url">URL</label>
                                                 <input id="ap-url" type="text" placeholder="Friendly URL e.g. how-to-pick-an-apartment" name="url" value="<?php echo e($url); ?>" class="form-control">
                                               </div>
										    </div>
										     <div class="col-md-12">
										        <div class="form-group">
                                                  <label>Status</label>
												  <?php
										            $statuses = ['enabled' => "Enabled",
										            'disabled' => "Disabled"
													];
										          ?>
                                                  <select class="form-control" id="ap-status" name="status">
												  <option value="none">Select status</option>
												  <?php
												  foreach($statuses as $key => $value)
												  {
													  $ss = $key == $status ? " selected='selected'" : "";
												  ?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>><?php echo e($value); ?></option>
												  <?php
												  }
												  ?>
												</select>
                                                </div>
										     </div>
											 <div class="col-md-6">										 
												<div class="form-group">
                                                  <label>Date created</label>
                                                  <p class="form-control-plaintext"><?php echo e($date); ?></p>
                                                </div>
											 </div>
											 <div class="col-md-6">	
												<div class="form-group">
                                                  <label>Last updated</label>
                                                  <p class="form-control-plaintext"><?php echo e($updated_at); ?></p>
                                                </div>
										     </div>
										  </div>
										</div>
										
										</div>
										
										<div class="row mb-3">
										     <div class="col-md-12">
										       <div class="form-group">
                                                 <label for="ap-content">Content</label>
                                                 <textarea class="form-control" name="content" id="ap-content"></textarea>
                                               </div>
										    </div>
										  </div>
										  
										  <div class="row mb-3">
										     <div class="col-md-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ubp-form-btn">Save</button>
                                                </p>
                                            </div>
										  </div>
										

                                    </form>
                                </div>
                            </div>
                        </div>
</div>	

<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Comments</h5>
                            <div class="card-body">
							  <?php
							    for($i = 0; $i < count($comments); $i++)
								{
								  $ti = $items[$i];
								  $author = $ti['author'];
								  $img = $author['avatar'];
								  if($img == "") $img = [asset("images/avatar.png")];
								  $name = $author['fname']." ".$author['lname'];
								  
								  
								  $subjj = $i == 0 ? $subject : "Re: ".$subject;
							  ?>
                                <div class="media">
								<img class="mr-3 user-avatar-lg rounded" src="<?php echo e($img[0]); ?>" alt="<?php echo e($name); ?>">
                                    <div class="media-body">
                                        <h5><?php echo e($subjj); ?></h5>
                                        <p><?php echo e($ti['msg']); ?></p>
                                    </div>
									<p class="pull-right"><em><?php echo e($ti['date']); ?></em></p>
                                </div>
								<hr>
							  <?php
								}
							  ?>
                            </div>
                        </div>
                    </div>
</div>		
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/post.blade.php ENDPATH**/ ?>