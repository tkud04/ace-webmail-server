<?php
$title = "Finance";
$subtitle = "View all transactions on the platform";

$gt = $transactions['guests'];
$hs = $transactions['hosts'];
#$hs = [];
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
<?php echo $__env->make('page-header',['title' => $title." - ".$subtitle,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Guest Transactions</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Guest</th>
                                                <th>Transaction Details</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?php
									   if(count($gt) > 0)
									   {
										for($d = 0; $d < count($gt); $d++)
										{
											$t = $gt[$d];
											$ll = ""; $sm = " class='text-muted'"; $tc = "";
											
											if($d == 0)
											{
												$ll = " active";
											    $sm = "";
											}
		
										  $vu = url('transaction')."?xf=".$t['id'];
										  $guest = $t['guest'];
										  $avatar = $guest['avatar'];
                                         
										 if($avatar == "") $avatar = [asset("images/avatar.png")];
										  $gname = $guest['fname']." ".$guest['lname'];
										
										  $i = $t['item'];
										  $ref = $i['order_id'];
											            $temp = [];
														 $apartment = $i['apartment'];
														 $temp['au'] = $apartment['url'];
														 $temp['name'] = $apartment['name'];
														 $cmedia = $apartment['cmedia'];
														 $temp['imgs'] = $cmedia['images'];
														 $adata = $apartment['data'];
														 $temp['terms'] = $apartment['terms'];
														 $host = $apartment['host'];
														 $temp['hostName'] = $host['fname']." ".substr($host['lname'],0,1).".";
														 $temp['amount'] = $adata['amount'];
														 $address = $apartment['address'];
														 $temp['location'] = $address['city'].", ".$address['state'];
														 $temp['checkin'] = $i['checkin'];
														 $temp['checkout'] = $i['checkout'];
														 $temp['guests'] = $i['guests'];
														 $temp['kids'] = $i['kids'];
												
                                          //status
											$status = $t['status']; $ss = ""; $ssClass = "";
											
											switch($status)
											{
												case "paid":
												  $ss = "Completed"; $ssClass = "success";
												break;
												
												case "unpaid":
												  $ss = "On hold"; $ssClass = "warning";
												break;
												
												case "cancelled":
												  $ss = "Cancelled"; $ssClass = "danger";
												break;
											}
												
									   ?>
                                            <tr>
                                                <td>
												<center>
												   <img class="rounded-circle mr-3 mb-3" src="<?php echo e($avatar[0]); ?>" alt="<?php echo e($gname); ?>" style="width: 100px; height: 100px;"/><br>
														  <?php echo e($gname); ?> 
												</center>
												</td>
                                                <td>
												  <div class="d-flex w-100 ">
											<img class="rounded-circle mr-3 mb-3" src="<?php echo e($temp['imgs'][0]); ?>" alt="<?php echo e($temp['name']); ?>" style="width: 100px; height: 100px;"/>
											  <div>
                                                <h5 class="mb-1<?php echo e($tc); ?>"><?php echo e($temp['name']); ?></h5>
                                                <small<?php echo e($sm); ?>><?php echo e($temp['checkin']." - ".$temp['checkout']); ?></small>
												
												<p class="mb-1">Guests: <?php echo e($temp['guests']); ?></p>
                                            <small<?php echo e($sm); ?>>Price per night: &#8358;<?php echo e(number_format($temp['amount'])); ?></small>
											  </div>
                                            </div>
												</td>
                                                <td>
												<span class="badge-dot badge-<?php echo e($ssClass); ?> mr-1"></span><?php echo e($ss); ?> 
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
					
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Host Subscriptions</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Host</th>
                                                <th>Subscription plan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?php
									   if(count($hs) > 0)
									   {
										for($d = 0; $d < count($hs); $d++)
										{
											$t = $hs[$d];
											$hu = $t['user']; $hp = $t['plan']; $stats = $t['stats']; 
											
											$sm = " class='text-muted'"; $tc = "";
											
											if($d == 0)
											{
												$ll = " active";
											    $sm = "";
											}
		
										  $avatar = $hu['avatar'];
                                         
										 if($avatar == "") $avatar = [asset("images/avatar.png")];
										  $hname = $hu['fname']." ".$hu['lname'];
													
									   ?>
                                            <tr>
                                                <td>
												<center>
												   <img class="rounded-circle mr-3 mb-3" src="<?php echo e($avatar[0]); ?>" alt="<?php echo e($hname); ?>" style="width: 100px; height: 100px;"/><br>
														  <?php echo e($hname); ?> 
												</center>
												</td>
                                                <td>
												  <div class="d-flex w-100 ">
											  <div>
                                                <h5 class="mb-1<?php echo e($tc); ?>"><?php echo e($hp['name']); ?></h5> 
												<small<?php echo e($sm); ?>>&#8358;<?php echo e(number_format($hp['amount'])); ?> per <?php echo e($hp['frequency']); ?></small>
                                              
												<p class="mb-1"><?php echo e($stats['posts_left']); ?> out of <?php echo e($hp['pc']); ?> postings remaining</p>
                                           
											  </div>
                                            </div>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/transactions.blade.php ENDPATH**/ ?>