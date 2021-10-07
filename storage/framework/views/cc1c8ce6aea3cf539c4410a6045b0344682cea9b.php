<?php
$title = $apartment['name'];
$subtitle = "Edit your apartment information";

$checkoutHead = <<<EOD
                                <div class="checkout-head">
									<ul>
										<li class="my-apartment-active-1 active"><span class="my-apartment-ticker-1">1</span>Apartment Information</li>
										<li class="my-apartment-active-2"><span class="my-apartment-ticker-2">2</span>Location & Media</li>
										<li class="my-apartment-active-3"><span class="my-apartment-ticker-3">3</span>Preview</li>
									</ul>
								</div>
EOD;

$terms = $apartment['terms'];
$adata = $apartment['data'];
$address = $apartment['address'];
$facilities = $apartment['facilities'];
$cmedia = $apartment['cmedia'];
$media = $apartment['media'];
$rawImgs = $media['images'];
$imgs = $cmedia['images'];
$video = $cmedia['video'];
?>



<?php $__env->startSection('title',$title); ?>

<?php $__env->startSection('top-header'); ?>
<?php echo $__env->make('top-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('banner-2',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
let selectedSide = "1", facilities = [], aptImages = [], aptImgCount = <?php echo e(count($cmedia['images'])); ?>,
    aptCover = "0", aptCurrentImgCount = "<?php echo e(count($imgs)); ?>";

$(document).ready(() => {
$('#my-apartment-loading').hide();
let myApartmentDescriptionEditor = new Simditor({
		textarea: $('#my-apartment-description'),
		toolbar: toolbar,
		placeholder: `This is the description`
	});
	
	myApartmentDescriptionEditor.setValue(`<?php echo $adata['description']; ?>`);

 <?php
	foreach($facilities as $ff)
	  {
  ?>
    toggleFacility("<?php echo e($ff['facility']); ?>");
  <?php
	  }
	  
	  foreach($rawImgs as $ri)
	  {
		  $imgId = $ri['id'];
  ?>
      $(`#sci-<?php echo e($imgId); ?>-loading`).hide();
  <?php  
	  }
  ?>
	aptRemoveImage({id: 'my-apartment',ctr: '0'});
});

</script>
<!-- =================== Add Apartment Search ==================== -->
			<section class="gray">
				<div class="container">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							<input type="hidden" id="tk-apt" value="<?php echo e(csrf_token()); ?>">
							<input type="hidden" id="tk-xf" value="<?php echo e($apartment['apartment_id']); ?>">
							<input type="hidden" id="tk-axf" value="<?php echo e(url('apartments')); ?>">
							<!-- Add Apartment Step 1 -->
							<div class="checkout-wrap" id="my-apartment-side-1">
								
								<?php echo $checkoutHead; ?>

								
								<div class="checkout-body">
									<div class="row">
								
										<div class="col-lg-12 col-md-12 col-sm-12">
											<h4 class="mb-3">Basic Information</h4>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Apartment ID<i class="req">*</i></label>
												<input type="text" class="form-control" value="<?php echo e($apartment['apartment_id']); ?>" readonly>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Friendly URL<i class="req">*</i></label>
												<input type="text" class="form-control" id="my-apartment-url" value="<?php echo e($apartment['url']); ?>">
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Friendly Name<i class="req">*</i></label>
												<input type="text" class="form-control" id="my-apartment-name" value="<?php echo e($apartment['name']); ?>" placeholder="Give your apartment a name e.g Royal Hibiscus">
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Price per day(&#8358;)<i class="req">*</i></label>
												<input type="number" class="form-control" id="my-apartment-amount" value="<?php echo e($adata['amount']); ?>" placeholder="Enter amount in NGN">
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12">
										<?php
										  $av = ['available' => "Available",
										         'occupied' => "Occupied",
										         'unavailable' => "Unavailable"
												 ];
										?>
											<div class="form-group">
												<label>Availability<i class="req">*</i></label>
												<select class="form-control" id="my-apartment-avb">
												  <option value="none">Select availability</option>
												  <?php
												  foreach($av as $key => $value)
												  {
													  $ss = $key == $apartment['avb'] ? " selected='selected'" : "";
												  ?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>><?php echo e($value); ?></option>
												  <?php
												  }
												  ?>
												</select>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Max. adults<i class="req">*</i></label>
												<input type="number" class="form-control" id="my-apartment-max-adults" value="<?php echo e($adata['max_adults']); ?>" placeholder="The max number of adults allowed to check-in">
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Max. children<i class="req">*</i></label>
												<input type="number" class="form-control" id="my-apartment-max-children" value="<?php echo e($adata['max_children']); ?>" placeholder="The max number of children allowed to check-in">
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group">
												<label>Description</label>
												<textarea id="my-apartment-description" class="form-control"></textarea>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 20px;">
											<h4 class="mb-3">Terms & Conditions</h4>
										</div>
										<?php
										  $times = ['12pm' => "12:00 pm",
										            '1pm' => "1:00 pm",
										            '2pm' => "2:00 pm",
										            '3pm' => "3:00 pm",
										            '4pm' => "4:00 pm",
										            '5pm' => "5:00 pm",
										            '6pm' => "6:00 pm",
										            '7pm' => "7:00 pm"
												   ];
										?>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Check In<i class="req">*</i></label>
												<select class="form-control" id="my-apartment-checkin">
												  <option value="none">Select check-in time</option>
												  <?php
												  foreach($times as $key => $value)
												  {
													  $ss = $key == $terms['checkin'] ? " selected='selected'" : "";
												  ?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>>From <?php echo e($value); ?></option>
												  <?php
												  }
												  ?>
												</select>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Check Out<i class="req">*</i></label>
												<select class="form-control" id="my-apartment-checkout">
												  <option value="none">Select check-out time</option>
												  <?php
												  foreach($times as $key => $value)
												  {
													    $ss = $key == $terms['checkout'] ? " selected='selected'" : "";
												  ?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>>By <?php echo e($value); ?></option>
												  <?php
												  }
												  ?>
												</select>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Payment Type<i class="req">*</i></label>
												<?php
												 $paymentTypes = ['none' => "Select payment type",'card' => "Card"];
												?>
												<select class="form-control" id="my-apartment-payment-type">
												<?php
												  foreach($paymentTypes as $key => $value)
												  {
													  $ss = $key == $terms['payment_type'] ? " selected='selected'" : "";
												?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>><?php echo e($value); ?></option>
												<?php
												  }
												?>
												</select>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>ID Required on Check-in<i class="req">*</i></label>
												<?php
												 $opts1 = ['none' => "ID required on check-in?",'yes' => "Yes",'no' => "No"];
												?>
												<select class="form-control" id="my-apartment-id-required">
												<?php
												  foreach($opts1 as $key => $value)
												  {
													  $ss = $key == $terms['id_required'] ? " selected='selected'" : "";
												?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>><?php echo e($value); ?></option>
												<?php
												  }
												?>
												</select>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Children<i class="req">*</i></label>
												<?php
												 $opts2 = [
												    'nonee' => "Select payment type",
													'none' => "No children allowed",
													'1-5yrs' => "1-5yrs",
													'6-10yrs' => "6-10yrs",
													'11-20yrs' => "11-20yrs",
													'>20yrs' => "20yrs above",
													'all' => "All children allowed"
												 ];
												?>
												<select class="form-control" id="my-apartment-children">
												<?php
												  foreach($opts2 as $key => $value)
												  {
													  $ss = $key == $terms['children'] ? " selected='selected'" : "";
												?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>><?php echo e($value); ?></option>
												<?php
												  }
												?>
												</select>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Pets<i class="req">*</i></label>
												<?php
												 $opts3 = [
												    'no' => "No",
													'yes' => "Yes"
												 ];
												?>
												<select class="form-control" id="my-apartment-pets">
												<?php
												  foreach($opts3 as $key => $value)
												  {
													  $ss = $key == $terms['pets'] ? " selected='selected'" : "";
												?>
												  <option value="<?php echo e($key); ?>"<?php echo e($ss); ?>><?php echo e($value); ?></option>
												<?php
												  }
												?>
												</select>
											</div>
										</div>
										
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 20px;">
											<h4 class="mb-3">Facilities & Services</h4>
										</div>										
										
										<div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 20px;">
											<div class="form-group">
											   
												<div class="row">
												  <?php
											        foreach($services as $s)
													{
														$key = $s['tag'];
														$value = $s['name'];
											      ?>
												  <div class="col-lg-3 col-md-6 col-sm-12">
												   
 												    <a class="btn btn-primary btn-sm text-white apt-service" id="apt-service-<?php echo e($key); ?>" onclick="toggleFacility('<?php echo e($key); ?>')" data-check="unchecked">
													  <center><i id="apt-service-icon-<?php echo e($key); ?>" class="ti-control-stop"></i></center>
													</a>
													 <label><?php echo e($value); ?></label>
												  </div>
												  <?php
													}
												  ?>
												</div>
												
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group text-center">
												<a href="javascript:void(0)" id="my-apartment-side-1-next" class="btn btn-theme">Next</a>
											</div>
										</div>
										
									</div>
								</div>
								
							</div>
							<!-- End of Add Apartment Step 1 -->
							
							<!-- Add Apartment Step 2 -->
							<div class="checkout-wrap" id="my-apartment-side-2">
								
								<?php echo $checkoutHead; ?>

								
								<div class="checkout-body">
									<div class="row mb-5">
								
										<div class="col-lg-12 col-md-12 col-sm-12">
											<h4 class="mb-3">Location & Media</h4>
										</div>
																			
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group">
												<label>Address<i class="req">*</i></label>
												<input type="text" class="form-control" id="my-apartment-address" value="<?php echo e($address['address']); ?>" placeholder="House address">
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>City<i class="req">*</i></label>
												<input type="text" class="form-control" id="my-apartment-city" value="<?php echo e($address['city']); ?>" placeholder="City">
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>State<i class="req">*</i></label>
												<select class="form-control" id="my-apartment-state">
												  <option value="none">Select state</option>
												  <?php
												   foreach($states as $key => $value)
												   {
													   $ss = $key == $address['state'] ? " selected='selected'" : "";
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
									  <!--
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Video<i class="req">*</i></label>
												<input type="file" class="form-control" id="my-apartment-video">
											</div>
											<div class="form-group">
											    <ol class="form-control-plaintext">
												  <li>Requirements and recommendations will be displayed here</li>
												  <li>Requirements and recommendations will be displayed here</li>
												</ol>
											</div>
										</div>
										-->
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group">
												<label>Images<i class="req">*</i></label>
												<div class="row">
												 <?php
												  for($x = 0; $x < count($imgs); $x++)
												  {
													  $img = $imgs[$x];
													  $imgId = $rawImgs[$x]['id'];
													  $cover = $rawImgs[$x]['cover'];
													  $dt = "{apartment_id: '".$apartment['apartment_id']."',id:".$imgId."}";
												 ?>
												 <div class="col-lg-4 col-md-4 col-sm-12" id="my-apartment-current-img-<?php echo e($imgId); ?>">
												    <div>
												      <img src="<?php echo e($img); ?>" alt="preview" style="width: 100px; height: 100px;"/>	
                                                       <?php if($cover == "yes"): ?>
                                                        <label class="label label-success" id="my-apartment-cover-label">Cover image</label>
                                                       <?php endif; ?>														   
												    </div>
												    <div style="margin-top: 10px;" id="sci-<?php echo e($imgId); ?>-submit">
													   <?php if($cover == "no"): ?>
													   <a href="javascript:void(0)" onclick="myAptSetCurrentCoverImage(<?php echo e($dt); ?>)" class="btn btn-theme btn-sm">Set as cover image</a>
												       <?php endif; ?>
													   <a href="javascript:void(0)" onclick="myAptRemoveCurrentImage(<?php echo e($dt); ?>)"class="btn btn-warning btn-sm">Remove</a>
												    </div>
													<div style="margin-top: 10px;" id="sci-<?php echo e($imgId); ?>-loading">
													   <h4>Processing.. <img src="<?php echo e(asset('img/loading.gif')); ?>" class="img img-fluid" alt="Processing.."></h4>
													</div>
												  </div>
												  <?php
												  }
												  ?>
												</div>
											</div><br>
											<div class="form-group">
												<label>Upload new images</label>
												<div id="my-apartment-images">
												<div id="my-apartment-image-div-0" class="row">
												  <div class="col-md-7">
												    <input type="file" class="form-control" onchange="readURL(this,'0')" id="my-apartment-image-0" name="my-apartment-images[]">												    
												  </div>
												  <div class="col-md-5">
												    <img id="my-apartment-preview-0" src="#" alt="preview" style="width: 50px; height: 50px;"/>
													<a href="javascript:void(0)" onclick="aptSetCoverImage(0)" class="btn btn-theme btn-sm">Set as cover image</a>
												    <a href="javascript:void(0)" onclick="aptRemoveImage({id: 'add-apartment',ctr: '0'})" class="btn btn-warning btn-sm">Remove</a>
												  </div>
												</div>
												</div>
											</div>
											<div class="form-group">
											    <a href="javascript:void(0)" onclick="aptAddImage({id: 'my-apartment'})" class="btn btn-warning btn-sm">Add image</a>
											    <ol class="form-control-plaintext">
												  <li>Recommended dimensions: Your images should not exceed <b>1280x880</b></li>
												  <li>Maximum file size: Your images must not be more than <b>1.5MB</b></li>
												</ol>
											</div>
										</div>									
												
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<input id="a-2" class="checkbox-custom" name="a-2" type="checkbox" checked>
												<label for="a-2" class="checkbox-custom-label">By continuing, you agree to our <a href="<?php echo e(url('terms')); ?>">terms & conditions</a></label>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group text-center">
												<a href="javascript:void(0)" id="my-apartment-side-2-prev" class="btn btn-theme">Back</a>
												<a href="javascript:void(0)" id="my-apartment-side-2-next" class="btn btn-theme">Next</a>
											</div>
										</div>
										
									</div>
								</div>
								
							</div>							
							<!-- End of Add Apartment Step 2 -->
							
							<!-- Add Apartment Step 3 -->
							<div class="checkout-wrap" id="my-apartment-side-3">
								
								<?php echo $checkoutHead; ?>

								
								<div class="checkout-body">
									
									
									<div class="row">
										<div class="col-md-12 col-lg-12">
										
											<ul class="booking-detail-list" id="my-apartment-final-preview">
												
											</ul>
											<hr>
											
											<h4>Final Notes</h4>
											<p>Take a moment to preview the information about your apartment to ensure there are no errors or mistypes as your request will be reviewed by an admin. If you are sure all your information is correct click on <b>Submit</b> below. To make changes click on <b>Back</b>.</p>
											
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group text-center" id="my-apartment-submit">
												<a href="javascript:void(0)" id="my-apartment-side-3-prev" class="btn btn-theme">Back</a>
												<a href="javascript:void(0)" id="my-apartment-side-3-next" class="btn btn-theme">Submit</a>
											</div>
											<div class="form-group text-center" id="my-apartment-loading">
												 <h4>Updating apartment.. <img src="<?php echo e(asset('img/loading.gif')); ?>" class="img img-fluid" alt="Adding apartment.."></h4><br>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							<!-- End of Add Apartment Step 3 -->
							
							
						</div>
						<!-- Sidebar End -->
							
						<div class="col-lg-3 col-md-4">
							<?php echo $__env->make('apt-sidebar',['cmedia' => $cmedia,'media' => $media], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</div>
					</div>
				</div>
			</section>
			<!-- =================== Add Apartment Search ==================== -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-web\resources\views/my-apartment.blade.php ENDPATH**/ ?>