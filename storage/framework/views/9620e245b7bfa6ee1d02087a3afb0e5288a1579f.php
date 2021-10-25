



<?php $__env->startSection('title',$title); ?>
<?php $__env->startSection('content'); ?>
 <div class="ecommerce-widget">

                        <div class="row">
						
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                  <div class="card-header">
                                      <ul class="nav nav-tabs card-header-tabs"  id="settings-tab" role="tablist">
                                        <li class="nav-item">
                                          <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab" aria-controls="advanced" aria-selected="true">Advanced</a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="card-body">
									  <div class="tab-content" id="settings-tab-content">
									    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
										  <form method="post" action="<?php echo e(url('api/settings')); ?>">
										   <input id="new-sig-input" name="new-sigs" type="hidden">
										    <div class="form-group">
                                             <h5 class="card-title" for="sig">Language</h5>
                                             <p class="card-text">English</p>
                                           </div>
										   <div class="form-group">
                                             <h5 class="card-title" for="sig">Images</h5>
                                             <input type="text" class="form-control" id="sig" placeholder="Example input">
                                           </div>
										   <div class="form-group">
                                             <h5 class="card-title" for="sig">Signatures</h5>
											 <a href="javascript:void(0)" id="add-sig-btn">Add new signature</a>
											 <select class="form-control" id="sig">
											   <option value="none">Select a signature to enable it</option>
											 <?php
											   foreach($sigs as $s)
											   {
												   $ss = ($s['current'] == "yes") ? " selected='selected'" : "";
											 ?>
                                             <option value="<?php echo e($s['id']); ?>"<?php echo e($ss); ?>></option>
											 <?php
											   }
											 ?>
											 </select>
											  <p class="card-text mt-2" id="new-sig-alert"></p>
                                           </div>
										   
                                           <button type="submit" class="btn btn-primary">Submit</button>
										   </form>
										</div>
										<div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
										   <h5 class="card-title">Advanced</h5>
                                           <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                           <a href="#" class="btn btn-primary">Go somewhere</a>
										</div>
                                      </div>
                                    </div>
                                  </div>
                            </div>

                        </div>
                        
                            <!-- ============================================================== -->
							
</div>
							
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/settings.blade.php ENDPATH**/ ?>