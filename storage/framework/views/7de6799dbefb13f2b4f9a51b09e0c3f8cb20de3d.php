<?php $__env->startSection('title',"Welcome"); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- ================= true Facts start ========================= -->
			<section class="facts">
				<div class="container">
					<div class="row">
						
						<div class="col-lg-4 col-md-4">
							<div class="facts-wrap">
								<div class="facts-icon">
									<i class="theme-cl ti-location-pin"></i>
								</div>
								<div class="facts-detail">
									<h4>1,000+ Choice Apartments</h4>
									<p>With 5-star hospitality</p>
								</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4">
							<div class="facts-wrap">
								<div class="facts-icon">
									<i class="theme-cl ti-shine"></i>
								</div>
								<div class="facts-detail">
									<h4>Home Away</h4>
									<p>A home away from home</p>
								</div>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4">
							<div class="facts-wrap">
								<div class="facts-icon">
									<i class="theme-cl ti-face-smile"></i>
								</div>
								<div class="facts-detail">
									<h4>98% Happy Guests</h4>
									<p>We strive to serve you better</p>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ================= End true Facts ========================= -->
			
			
						<!-- ================= Apartments start ========================= -->
			<section class="min">
				<div class="container">
				
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center">
								<p>Popular Apartments</p>
								<h2>Featured Apartments</h2>
							</div>
						</div>
					</div>
					
					<div class="row">
						<?php
						 $popularApartmentss = [
						   ['img' => asset('img/des-2.jpg'),'href' => "javascript-void(0)", 'tc' => "5",'location' => "Ikeja, Lagos",'stars' => "5", 'amount' => "20000"],
						   ['img' => asset('img/des-3.jpg'),'href' => "javascript-void(0)", 'tc' => "6",'location' => "Ikorodu, Lagos",'stars' => "3", 'amount' => "10000"],
						   ['img' => asset('img/des-4.jpg'),'href' => "javascript-void(0)", 'tc' => "5",'location' => "Victoria Island, Lagos",'stars' => "5", 'amount' => "20000"],
						   ['img' => asset('img/des-5.jpg'),'href' => "javascript-void(0)", 'tc' => "5",'location' => "Bodija, Oyo",'stars' => "3", 'amount' => "7000"],
						   ['img' => asset('img/des-6.jpg'),'href' => "javascript-void(0)", 'tc' => "7",'location' => "Mokola, Ibadan",'stars' => "4", 'amount' => "10000"],
						   ['img' => asset('img/des-7.jpg'),'href' => "javascript-void(0)", 'tc' => "7",'location' => "Yaba, Lagos",'stars' => "4", 'amount' => "10000"],
						 ];
						 
						 foreach($popularApartments as $pa)
						 {
							 $pt = [];
$adata = $pa['data'];
$address = $pa['address'];
$cmedia = $pa['cmedia'];
$imgs = $cmedia['images'];

$pt['img'] = $imgs[0];
$pt['href'] = url('apartment')."?xf=".$pa['url'];
$pt['tc'] = $adata['max_adults'];
$pt['location'] = $address['city'].", ".$address['state'];
$pt['stars'] = $pa['rating'];
$pt['amount'] = $adata['amount'];
$pt['name'] = $pa['name'];
						?>
						<!-- Single Tour Place -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="tour-simple-wrap">
								<div class="tour-simple-thumb">
									<a href="<?php echo e($pt['href']); ?>"><img src="<?php echo e($pt['img']); ?>" class="img-fluid img-responsive" alt="<?php echo e($pt['name']); ?>" style="width: 348px; height: 237px;"/></a>
								</div>
								<div class="tour-simple-caption">
									<div class="ts-caption-left">
										<h4 class="ts-title">
										 <a href="<?php echo e($pt['href']); ?>"><?php echo e($pt['name']); ?></a><br>
										 <a href="javascript:void(0)"><?php echo e($pt['location']); ?></a>
										</h4>
										<span><?php echo e($pt['tc']); ?> adults max.</span>
									</div>
									<div class="ts-caption-right">
										<div class="ts-caption-rating">
										   <?php for($i = 0; $i < $pt['stars']; $i++): ?>
											<i class="ti-star filled"></i>
										   <?php endfor; ?>
										   <?php for($i = 0; $i < 5 - $pt['stars']; $i++): ?>
											<i class="ti-star"></i>
										   <?php endfor; ?>
										</div>
										<h5 class="ts-price">&#8358;<?php echo e(number_format($pt['amount'],2)); ?></h5>
									</div>
								</div>
							</div>
						</div>
						<?php
						 }
						?>
						
						
					</div>
				
				</div>
			</section>
			<!-- ========================= End Apartment Section ============================ -->
			
			
			<!-- ================= Ads start ========================= -->
			<section class="gray">
				<div class="container">
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="owl-carousel owl-theme" id="lists-slide">
								
								<div class="single-item">
									<div class="destination-item">
										<span class="discount-off">-35%</span>
										<figure class="destination-list-wrap">
											<a class="destination-listlink" href="search.html">
												<img class="cover" src="<?php echo e(asset('img/cat-1.jpg')); ?>" alt="room">
											</a>
										</figure>
										<div class="destination-listdetails">
											<span class="destination-list-cat theme-bg">Eat & Drinks</span>
											<h4 class="title"><a class="title-ln" href="search.html">Machu Picchu, Peru</a></h4>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</div>
									</div>
								</div>
								
								<div class="single-item">
									<div class="destination-item">
										<span class="discount-off">-50%</span>
										<figure class="destination-list-wrap">
											<a class="destination-listlink" href="search.html">
												<img class="cover" src="<?php echo e(asset('img/cat-7.jpg')); ?>" alt="room">
											</a>
										</figure>
										<div class="destination-listdetails">
											<span class="destination-list-cat theme-bg">Adventures</span>
											<h4 class="title"><a class="title-ln" href="search.html">Great Barrier Reef</a></h4>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</div>
									</div>
								</div>
								
								<div class="single-item">
									<div class="destination-item">
										<span class="discount-off">-10%</span>
										<figure class="destination-list-wrap">
											<a class="destination-listlink" href="search.html">
												<img class="cover" src="<?php echo e(asset('img/cat-3.jpg')); ?>" alt="room">
											</a>
										</figure>
										<div class="destination-listdetails">
											<span class="destination-list-cat theme-bg">Restaurants</span>
											<h4 class="title"><a class="title-ln" href="search.html">Pyramids of Giza</a></h4>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</div>
									</div>
								</div>
								
								<div class="single-item">
									<div class="destination-item">
										<span class="discount-off">-20%</span>
										<figure class="destination-list-wrap">
											<a class="destination-listlink" href="search.html">
												<img class="cover" src="<?php echo e(asset('img/cat-4.jpg')); ?>" alt="room">
											</a>
										</figure>
										<div class="destination-listdetails">
											<span class="destination-list-cat theme-bg">Hotel & Rooms</span>
											<h4 class="title"><a class="title-ln" href="search.html">Heritage of England</a></h4>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</div>
									</div>
								</div>
								
								<div class="single-item">
									<div class="destination-item">
										<span class="discount-off">-30%</span>
										<figure class="destination-list-wrap">
											<a class="destination-listlink" href="search.html">
												<img class="cover" src="<?php echo e(asset('img/cat-5.jpg')); ?>" alt="room">
											</a>
										</figure>
										<div class="destination-listdetails">
											<span class="destination-list-cat theme-bg">Hike & Ride</span>
											<h4 class="title"><a class="title-ln" href="search.html">The City of Lights </a></h4>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</div>
									</div>
								</div>
							
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<!-- ========================= End Ads Section ============================ -->
			
			
				<!-- ================= Bouquets start ========================= -->
			<section class="">
				<div class="container">
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center">
								<p>Top Bouquets</p>
								<h2>Get More For Less!</h2>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="owl-carousel owl-theme" id="lists-slide">
								<?php
								  $bouquets = [
								   [
								     'apartment_id' => "ETUK88293CD768",
								     'location' => "Maryland, Lagos",
									 'img'=> asset("img/des-2.jpg"),
									 'href' => "javascript:void(0)",
									 'discount' => "5000",
									 'amount' => "20000",
									 'description' => "A lovely description about my apartment and why you would have an amazing time here."
								   ],
								   [
								     'apartment_id' => "ETUK979293CD7",
								     'location' => "Naby Barracks, Calabar",
									 'img'=> asset("img/des-3.jpg"),
									 'href' => "javascript:void(0)",
									 'discount' => "5000",
									 'amount' => "20000",
									 'description' => "A lovely description about my apartment and why you would have an amazing time here."
								   ],
								   [
								     'apartment_id' => "ETUK882956768",
								     'location' => "Maitama, Abuja",
									 'img'=> asset("img/des-4.jpg"),
									 'href' => "javascript:void(0)",
									 'discount' => "5000",
									 'amount' => "20000",
									 'description' => "A lovely description about my apartment and why you would have an amazing time here."
								   ],
								   [
								     'apartment_id' => "ETUK882454CD808",
								     'location' => "Oshogbo, Osun",
									 'img'=> asset("img/des-5.jpg"),
									 'href' => "javascript:void(0)",
									 'discount' => "5000",
									 'amount' => "20000",
									 'description' => "A lovely description about my apartment and why you would have an amazing time here."
								   ],
								   [
								     'apartment_id' => "ETUK57593CD444",
								     'location' => "Ikoyi, Lagos",
									 'img'=> asset("img/des-6.jpg"),
									 'href' => "javascript:void(0)",
									 'discount' => "5000",
									 'amount' => "20000",
									 'description' => "A lovely description about my apartment and why you would have an amazing time here."
								   ],
								  ];
								  
								  foreach($bouquets as $bq)
								  {
								?>
								<div class="single-item">
									<div class="destination-discount">
										<div class="destination-discount-thumb">
											<a href="<?php echo e($bq['href']); ?>"><img src="<?php echo e($bq['img']); ?>" class="img-responsive" alt="Apartment #<?php echo e($bq['apartment_id']); ?>" /></a>
										</div>
										<div class="destination-discount-caption">
											<div class="discount-box">
												<h4 class="discount-title"><sup class="current-title">&#8358;</sup><?php echo e(number_format($bq['discount'],2)); ?></h4>
												<span>Off</span>
											</div>
											<h4 class="destination-title"><a href="<?php echo e($bq['href']); ?>"><?php echo e($bq['location']); ?></a></h4>
											<p><?php echo e($bq['description']); ?></p>
											<h5 class="destination-price theme-cl"><span>From</span>&#8358;<?php echo e($bq['amount'] - $bq['discount']); ?></h5>
											<a href="<?php echo e($bq['href']); ?>" class="check-btn">Check<i class="ti-arrow-right"></i></a>
										</div>
									</div>
								</div>
								<?php
								  }
								?>
							
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<!-- ========================= End Bouquets Section ============================ -->

      <?php echo $__env->make('recent-blog', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('newsletter-cta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-web\resources\views/index.blade.php ENDPATH**/ ?>