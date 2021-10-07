<?php
$title = "View Transaction";
$subtitle = "View information about this transaction.";
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
<?php echo $__env->make('page-header',['title' => "Transactions",'subtitle' => "View Transaction"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
							<?php
							 $guest = $t['guest'];
										  $avatar = $guest['avatar'];
                                         
										 if($avatar == "") $avatar = [asset("images/avatar.png")];
										  $gname = $guest['fname']." ".$guest['lname'];
										  $uu = url('user')."?xf=".$guest['email'];
										  $i = $t['item'];
										  $ref = $i['order_id'];
											            $temp = [];
														 $apartment = $i['apartment'];
														 $temp['au'] = $apartment['url'];
														 $au = url('apartment')."?xf=".$apartment['apartment_id'];
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
														 $c1 = new DateTime($temp['checkin']);
														 $c2 = new DateTime($temp['checkout']);
														 $cdiff = $c1->diff($c2);
														 $duration = $cdiff->format("%r%a");
														 $dtt = $duration == 1 ? "night" : "nights";
														 $temp['guests'] = $i['guests'];
														 $temp['kids'] = $i['kids'];
							?>
                                <h5 class="card-header">Transaction Details</h5>
                                <div class="card-body">
                                    <form action="javascript:void(0)" id="t-form">
									    <div class="row">
										
										<div class="col-md-4 row">
										 <div class="col-md-6">
										 <a href="<?php echo e($uu); ?>">
										  <div class="form-group">
                                             <label>Guest</label>
                                             <div class="form-control hover">
										       <img class="rounded-circle mr-3 mb-3" src="<?php echo e($avatar[0]); ?>" alt="<?php echo e($gname); ?>" style="width: 100px; height: 100px;"/><br>
											   <?php echo e($gname); ?> 
										     </div>
                                           </div>
										   </a>
										 </div>
										 <div class="col-md-6">
										  <a href="<?php echo e($au); ?>">
										   <div class="form-group">
                                               <label>Apartment</label>
                                               <div class="form-control hover">
										         <img class="rounded-circle mr-3 mb-3" src="<?php echo e($temp['imgs'][0]); ?>" alt="<?php echo e($temp['name']); ?>" style="width: 100px; height: 100px;"/><br>
												 <?php echo e($temp['name']); ?>

										       </div>
                                            </div>
										    </a>
										 </div>
										</div>
										<div class="col-md-8">
										  <div class="row mb-3">
										     <div class="col-md-6">
										        <div class="form-group">
                                                  <label>Booking dates</label>
                                                  <p class="form-control-plaintext"><?php echo e($temp['checkin']); ?> - <?php echo e($temp['checkout']); ?></p>
                                                </div>
										     </div>
										     <div class="col-md-6">
										        <div class="form-group">
                                                  <label>Duration</label>
                                                  <p class="form-control-plaintext"><?php echo e($duration." ".$dtt); ?></p>
                                                </div>
										     </div>
										  </div>
										  <div class="row mb-3">
										     <div class="col-md-6">
										        <div class="form-group">
                                                  <label>Guests</label>
                                                  <p class="form-control-plaintext"><?php echo e($temp['guests']); ?> adults | <?php echo e($temp['kids']); ?> children</p>
                                                </div>
										     </div>
										     <div class="col-md-6">
										        <div class="form-group">
                                                  <label>Total charged</label>
                                                  <p class="form-control-plaintext">&#8358;<?php echo e(number_format($temp['amount'],2)); ?></p>
                                                </div>
										     </div>
										  </div>
										  <div class="row">
										     <div class="col-md-6">
										        <div class="form-group">
                                                  <label>Order reference #</label>
                                                  <p class="form-control-plaintext"><?php echo e($ref); ?></p>
                                                </div>
										     </div>
										     <div class="col-md-6">
										        <div class="form-group">
                                                  <label>Order status</label>
                                                  <p class="form-control-plaintext"><span class="label label-primary">PAID</span></p>
                                                </div>
										     </div>
										  </div>
										 
										</div>
										
										</div>
										
										

                                    </form>
                                </div>
                            </div>
                        </div>
</div>			
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/transaction.blade.php ENDPATH**/ ?>