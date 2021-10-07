<?php
$title = "Edit Plugin";
$subtitle = "Edit this plugin.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Plugins",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Edit Plugin</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('plugin')); ?>" id="apl-form" method="post">
										<?php echo csrf_field(); ?>

										<input type="hidden" name="xf" value="<?php echo e($p['id']); ?>"/>
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="apl-name">Name</label>
                                            <input id="apl-name" type="text" value="<?php echo e($p['name']); ?>" placeholder="Plugin name" name="name" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="apl-value">Value</label>
                                             <textarea class="form-control" name="value" id="ap-value"><?php echo $p['value']; ?></textarea>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Status</h4>
                                            <select class="form-control" name="status" id="ap-status" style="margin-bottom: 5px;">
							                  <option value="none">Select status</option>
								           <?php
								            $secs = ['enabled' => "Enabled",'disabled' => "Disabled"];
								            foreach($secs as $key => $value){
									      	 $ss = $p['status'] == $key ? " selected='selected'" : "";
								           ?>
								              <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>><?php echo e($value); ?></option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="apl-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/plugin.blade.php ENDPATH**/ ?>