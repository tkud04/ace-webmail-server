<?php
$title = "Dashboard";
$subtitle = "Admin dashboard";
?>



<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('lib/morris-bundle/morris.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('lib/morris-bundle/raphael.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/morris-bundle/morris.js')); ?>"></script>
<script src="<?php echo e(asset('lib/morris-bundle/morris-init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title',$title); ?>
<?php $__env->startSection('content'); ?>
 <div class="ecommerce-widget">

                        <div class="row">
						<?php
						 //total users
						 $ta = $stats['total_users'];
						 $tap = (($ta - 2) / $ta) * 100;
						 $taClass = "text-success";
						 $taIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 
						 if($tap < 0)
						 {
							 $taClass = "text-secondary";
							 $taIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($tap == 0)
						 {
							 $taClass = "text-primary";
							 $taIcon = "";
						 }
						 
						 //total emails
						 $tb = $stats['total_messages'];
						 $tbp = 0;
						 $tbClass = "text-success";
						 $tbIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 
						 if($tbp < 0)
						 {
							 $tbClass = "text-secondary";
							 $tbIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($tbp == 0)
						 {
							 $tbClass = "text-primary";
							 $tbIcon = "";
						 }
						 
						 
						?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Users</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"><?php echo e($ta); ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right <?php echo e($taClass); ?> font-weight-bold">
										
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                           
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Emails</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"><?php echo e($tb); ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right <?php echo e($tbClass); ?> font-weight-bold">
                                           
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
                        </div>
                        
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Recent Users</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Email</th>
                                                        <th class="border-0">Status</th>
                                                        <th class="border-0">Date created</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
												
										  foreach($accts as $a)
										  {
											$ssClass = "success"; if($a['status'] == "disabled") $ssClass = "danger";	 	
                                            $ss = strtoupper($a['status']);											
											  
									   ?>
                                                    <tr>
                                                        <td>
														 <?php echo e($a['username']); ?>@aceluxurystore.com
														</td>
														<td><span class="badge-dot badge-<?php echo e($ssClass); ?> mr-1"></span><?php echo e($ss); ?> </td>
                                                        <td>
														  <?php echo e($a['date']); ?>

                                                        </td>
                                                        
                                                    </tr>
                                        <?php
										 
										}
										?>       
                                                    <tr>
                                                        <td colspan="9"><a href="<?php echo e(url('users')); ?>" class="btn btn-outline-light float-right">View more</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->		
							
							
							</div>
							
							</div>
							
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/index.blade.php ENDPATH**/ ?>