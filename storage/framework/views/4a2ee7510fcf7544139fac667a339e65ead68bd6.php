<?php
$title = "Checkout";
$subtitle = "Make payment or book for later";
$cartt = $cart['data'];
$ii = count($cartt) == 1 ? "item" : "items";
$subtotal = $cart['subtotal'];

 //for tests
			  $secureCheckout = "http://etukng.tobi-demos.tk/checkout";
			  $unsecureCheckout = url('checkout');
			  $securePay = "http://etukng.tobi-demos.tk/pay";
			  $unsecurePay = url('pay');
			  
			  $isSecure = (isset($secure) && $secure);
			  $pay = $isSecure ? $securePay : $unsecurePay;
			  $checkout = $isSecure ? $secureCheckout : $unsecureCheckout;

?>


<?php $__env->startSection('title',$title); ?>

<?php $__env->startSection('top-header'); ?>
<?php echo $__env->make('top-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('banner-2',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

 <script>
		    
								 mc = {"ref":"<?php echo e($ref); ?>",
								       "type":"checkout",
								       "email":"<?php echo e($user->email); ?>",
									   "notes":""
									  };
                             
           </script>

                            	<input type="hidden" id="card-action" value="<?php echo e($pay); ?>">
                            	<input type="hidden" id="checkout-ref" value="<?php echo e($ref); ?>">
<!-- ============================ Checkout Start ================================== -->
			<section>
				<div class="container">
				
					
					<div class="row align-items-center">
						
						<div class="col-lg-7 col-md-7">
							<div class="contact-form">
								<form id="checkout-form" method="post">
								<?php echo csrf_field(); ?>

									<div class="row">
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
											  <label>Name</label>
											  <input type="text" class="form-control" value="<?php echo e($user->fname.' '.$user->lname); ?>" placeholder="Name" readonly>
											</div>
										</div>
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
											  <label>Email</label>
											  <input type="email" class="form-control" value="<?php echo e($user->email); ?>" placeholder="Email" readonly>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label>Payment type</label>
												<select class="form-control" id="checkout-payment-type">
												  <option value="none">Select payment type</option>
												  <option value="card" selected="selected">Card</option>
												</select>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label>Notes (optional)</label>
												<textarea class="form-control" id="notes" placeholder="Type Here..."></textarea>
											</div>
										</div>
									</div>
									
									 <!-- payment form -->
                            	<input type="hidden" name="email" value="<?php echo e($user->email); ?>"> 
                            	<input type="hidden" name="quantity" value="1"> 
                            	<input type="hidden" name="amount" value="<?php echo e($subtotal * 100); ?>"> 
                            	<input type="hidden" name="metadata" id="nd" value="" > 
                            
                                <input type="hidden" id="meta-comment" value="">  
                            <!-- End payment form -->
									
								</form>
							</div>
						</div>
						
						<div class="col-lg-5 col-md-5 mt-5" style="overflow-y: scroll;">
							<div class="row">
							  <div class="col-lg-12 col-md-12">
							   <h3><?php echo e(count($cartt)); ?> <?php echo e($ii); ?></h3><br>
							   <h4>Subtotal: &#8358;<span><?php echo e(number_format($subtotal,2)); ?></span></h4><br>
							  </div><br>
							  <div class="col-lg-12 col-md-12">
							  <?php
							    foreach($cartt as $c)
													 {
														 $xf = $user->id;
														 $axf = $c['apartment_id'];
														 $apartment = $c['apartment'];
														 $au = $apartment['url'];
														 $cmedia = $apartment['cmedia'];
														 $imgs = $cmedia['images'];
														 $adata = $apartment['data'];
														 $amount = $adata['amount'];
														 $address = $apartment['address'];
														 $location = $address['city'].", ".$address['state'];
														 $checkin = new DateTime($c['checkin']);
														 $checkout = new DateTime($c['checkout']);
							 if($c != $cartt[0])
							 {
							 ?>
							 <hr style="margin-top: 10px;">
							 <?php
							 }
							 ?>
							   <h3><span class="label label-primary"><?php echo e($apartment['name']); ?></span> <b>&#8358;<?php echo e(number_format($amount,2)); ?></b> <small>per night</small></h3>
							   <p>Check-in: <b><?php echo e($checkin->format("jS F, Y")); ?></b></p>
							   <p>Check-out: <b><?php echo e($checkout->format("jS F, Y")); ?></b></p>
							   <p>Guests: <b><?php echo e($c['guests']); ?></b> | Kids: <b><?php echo e($c['kids']); ?></b></p>
							   <p></p>
							 <?php
													 }
							 ?>
							  </div>
							</div>
						</div>
					</div>
					<div class="row mt-5">
										<div class="col-lg-12 col-md-12">										
											<button id="checkout-book-btn" class="btn btn-primary">Book for later</button>
											<button id="checkout-pay-btn" class="btn btn-success">Pay now</button>
										</div>
									</div>
					
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- ============================ Checkout End ================================== -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-web\resources\views/checkout.blade.php ENDPATH**/ ?>