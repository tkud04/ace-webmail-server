const showElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		$(names[i]).fadeIn();
	}
}

const hideElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		$(names[i]).hide();
	}
}

const hideInputErrors = type => {
	let ret = [], types = [];
	
	if(Array.isArray(type)){
	  types = type;
	}
	else{
		types.push(type);
	}
	
	for(let i = 0; i < types.length; i++){
	  switch(types[i]){
		case "signup":
		  $('#signup-finish').html(`<b>Signup successful!</b><p class='text-primary'>Redirecting you to the home page.</p>`);
		  ret = ['#s-fname-error','#s-lname-error','#s-email-error','#s-phone-error','#s-pass-error','#s-pass2-error','#signup-finish'];	 
		break;
		
		case "login":
		  $('#login-finish').html(`<b>Signin successful!</b><p class='text-primary'>Redirecting you to your dashboard.</p>`);
	      ret = ['#l-id-error','#l-pass-error','#login-finish'];	 
		break;
		
		case "forgot-password":
		  $('#fp-finish').html(`<b>Request received!</b><p class='text-primary'>Please check your email for your password reset link.</p>`);
	      ret = ['#fp-id-error','#fp-finish'];	 
		break;
		
		case "reset-password":
		  $('#rp-finish').html(`<b>Password reset!</b><p class='text-primary'>You can now <a href="#" data-toggle="modal" data-target="#login">sign in</a>.</p>`);
	      ret = ['#rp-pass-error','#rp-pass2-error','#rp-finish'];	 
		break;
		
		case "oauth-sp":
		  ret = ['#osp-pass-error','#osp-pass2-error'];	 
		break;
	  }
	  hideElem(ret);
	}
}

const signup = dt => {

     let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-signup').val());
		 
	//create request
	let url = "signup";
	const req = new Request(url,{method: 'POST', body: fd});
	
	//fetch request
	fetch(req)
	   .then(response => {
		   
		   if(response.status === 200){   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to sign you up: " + error);			
			hideElem('#signup-loading');
		     showElem('#signup-submit');
	   })
	   .then(res => {
		   console.log(res);
				 
		   if(res.status == "ok"){
              hideElem(['#signup-loading','#signup-submit']); 
              showElem('#signup-finish');
              window.location = "/"; 			   
		   }
		   else if(res.status == "error"){
		     alert("An unknown error has occured, please try again.");			
			hideElem('#signup-loading');
		     showElem('#signup-submit');					 
		   }
		   		   
		  
	   }).catch(error => {
		    alert("Failed to sign you up: " + error);	
            hideElem('#signup-loading');
		     showElem('#signup-submit');		
	   });
}

const fp = dt => {

     let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-fp').val());
		 
	//create request
	let url = "forgot-password";
	const req = new Request(url,{method: 'POST', body: fd});
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send new password request: " + error);			
			hideElem('#fp-loading');
		     showElem('#fp-submit');
	   })
	   .then(res => {
		   console.log(res);
			 hideElem(['#fp-loading','#fp-submit']); 
             	 
		   if(res.status == "ok"){
               $('#fp-finish').html(`<b>Request received!</b><p class='text-primary'>Please check your email for your password reset link.</p>`);
				 showElem(['#fp-finish','#fp-submit']);			   
		   }
		   else if(res.status == "error"){
			   console.log(res.message);
			 if(res.message == "auth"){
				 $('#fp-finish').html(`<p class='text-primary'>No user exists with that email address.</p>`);
				 showElem(['#fp-finish','#fp-submit']);
			 }
			 else if(res.message == "validation" || res.message == "dt-validation"){
				 $('#fp-finish').html(`<p class='text-primary'>Please enter a valid email address.</p>`);
				 showElem(['#fp-finish','#fp-submit']);
			 }
			 else{
			   alert("An unknown error has occured, please try again.");			
			   hideElem('#fp-loading');
		       showElem('#fp-submit');	 
			 }					 
		   }
		   		   
		  
	   }).catch(error => {
		    alert("Failed to sign you in: " + error);	
            hideElem('#login-loading');
		     showElem('#login-submit');		
	   });
}

const rp = dt => {

     let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-rp').val());
		 
	//create request
	let url = "reset";
	const req = new Request(url,{method: 'POST', body: fd});
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send new password request: " + error);			
			hideElem('#rp-loading');
		     showElem('#rp-submit');
	   })
	   .then(res => {
		   console.log(res);
			 hideElem(['#rp-loading','#rp-submit']); 
             	 
		   if(res.status == "ok"){
               $('#rp-finish').html(`<b>Password reset!</b><p class='text-primary'>You can now <a href="hello">sign in</a>.</p>`);
				 showElem(['#rp-finish','#rp-submit']);			   
		   }
		   else if(res.status == "error"){
			   console.log(res.message);
			 if(res.message == "auth"){
				 $('#rp-finish').html(`<p class='text-primary'>No user exists with that email address.</p>`);
				 showElem(['#rp-finish','#rp-submit']);
			 }
			 else if(res.message == "validation" || res.message == "dt-validation"){
				 $('#rp-finish').html(`<p class='text-primary'>Please enter a valid email address.</p>`);
				 showElem(['#rp-finish','#rp-submit']);
			 }
			 else{
			   alert("An unknown error has occured, please try again.");			
			   hideElem('#rp-loading');
		       showElem('#rp-submit');	 
			 }					 
		   }
		   		     
	   }).catch(error => {
		    alert("Failed to sign you in: " + error);	
            hideElem('#rp-loading');
		     showElem('#rp-submit');		
	   });
}


const switchMode = dt => {
    let url = `sm?m=${dt.mode}`;
	window.location = url;
}

const toggleFacility = dt => {
	 // console.log(`selecting facility ${dt}`);
	  f = $(`a#apt-service-${dt}`);
	  i = $(`i#apt-service-icon-${dt}`);
	  ft = f.attr('data-check');
	  ret = {id: dt, selected: false};
	  ih = "Check", rc = 'btn-warning', ac = 'btn-primary', iac = "ti-control-stop", idc = "ti-check-box",  dc = "unchecked";
	  
	  if(f){
		  if(ft == "unchecked"){
			ih = "Uncheck", rc = 'btn-primary', ac = 'btn-warning',iac = "ti-check-box", idc = "ti-control-stop", dc = "checked";
	        ret.selected = true;
		  } 
		   let ss = facilities.find(i => i.id == dt);
		  //console.log('us: ',us);
		  if(ss){
			ss.selected = ret.selected;  
		  }
		  else{
			facilities.push(ret);  
		  }
		  
		 // f.html(ih);
		  f.removeClass(rc);
		  f.addClass(ac);
		  i.removeClass(idc);
		  i.addClass(iac);
		  f.attr({'data-check':dc});
	  }
}


const aptAddImage = dt => {
	let i = $(`#${dt.id}-images`), ctr = $(`#${dt.id}-images div.row`).length;
	let sciText = `<a href='javascript:void(0)' onclick="aptSetCoverImage('${ctr}')" class='btn btn-primary btn-sm'>Set as cover image</a>`;
	
	i.append(`
			  <div id="${dt.id}-image-div-${ctr}" class="row">
				<div class="col-md-7">
					<input type="file" class="form-control" data-ic="${ctr}" onchange="readURL(this,{id: '${dt.id}',ctr: '${ctr}'})" id="${dt.id}-image-${ctr}" name="${dt.id}-images[]">												    
				</div>
			    <div class="col-md-5">
					<img id="${dt.id}-preview-${ctr}" src="#" alt="preview" style="width: 50px; height: 50px;"/>
					${sciText}
					<a href="javascript:void(0)" onclick="aptRemoveImage({id: '${dt.id}', ctr: '${ctr}'})"class="btn btn-warning btn-sm">Remove</a>
				</div>
			  </div>
	  `);
}

const aptRemoveImage = dt => {
	let r = $(`#${dt.id}-image-div-${dt.ctr}`);
	//console.log(r);
	r.remove();
}

const aptSetCoverImage = ctr => {
	aptCover = ctr;
	//r.remove();
}

const readURL = (input,dt) => {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
		let pv = input.getAttribute("data-ic");
      $(`#${dt.id}-preview-${dt.ctr}`).attr({
	      'src': e.target.result,
	      'width': "50",
	      'height': "50"
	  });
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

const aptFinalPreview = (id) => {
	 //side 1 
	   let aptName = $(`#${id}-name`).val(), aptUrl = $(`#${id}-url`).val(), aptMaxAdults = $(`#${id}-max-adults`).val(),
	    aptMaxChildren = $(`#${id}-max-children`).val(), aptAmount = $(`#${id}-amount`).val(),aptDescription = $(`#${id}-description`).val(),
	       aptCategory = $(`#${id}-category`).val(), aptPType = $(`#${id}-ptype`).val(),aptRooms = $(`#${id}-rooms`).val(),
	       aptUnits = $(`#${id}-units`).val(),aptBathrooms = $(`#${id}-bathrooms`).val(),
		   aptBedrooms = $(`#${id}-bedrooms`).val(),  aptPets = $(`#${id}-pets`).val(),
		 
       //side 2
	       aptAddress = $(`#${id}-address`).val(), aptCity = $(`#${id}-city`).val(),aptLGA = $(`#${id}-lga`).val(),aptState = $(`#${id}-state`).val(),
	       aptImages = $(`#${id}-images input[type=file]`), axf = $(`#tk-axf`).val();
		   
		   let fff = [];
		   for(let y = 0; y < facilities.length; y++){
			 if(facilities[y].selected) fff.push(facilities[y]);
		   }
		   
		   let ff = `None specified`;
		   if(fff.length > 0){
			   ff = `${fff[0].id}`;
		     for(let y = 1; y < fff.length; y++){
				 let ii = fff[y];
			   if(ii.selected) ff += ` | ${ii.id}`;
		     }
		   }
		   
		   if(aptUrl == "") aptUrl = "not specified";
		   
		   let aptAvb = $(`#${id}-avb`).val(), ci = null;
		   
		   let ac = aptCover == "none" ? 0 : aptCover, reader = null;
           let imgs = aptImages[ac].files, rawImgs = [], ii = aptImages.length == 1 ? "image" : "images";
	       
		   //Add the images to the apt preview
			 for(let i = 0; i < aptImages.length; i++){
			    reader = new FileReader();
 	            reader.onload = function(e) {
					let x = {
						 src:`<img src="${e.target.result}" width="236" height="161">`,
						 cover:"no",
						 cml: null
						};
						
	                if(ac == i){
						x.cover = "yes";
						x.cml = `<span class="label label-primary">Cover image</span>`;
					} 
					rawImgs.push(x);
                }
                reader.readAsDataURL(aptImages[i].files[0]); // convert to base64 string
		      }
		   
		   console.log(rawImgs);
		   
	let i = `
	     <tr><td>Apartment ID</td><td><span>Will be generated</span></td></tr>
	     <tr><td>Friendly name</td><td><span>${aptName}</span></td></tr>
	     <tr><td>Friendly URL</td><td><span>[main website]?xf=<b>${aptUrl}</b></span></td></tr>
	     <tr><td>Max. guests</td><td><span>${aptMaxAdults}</span></td></tr>
	     <tr><td>Availability</td><td><span>${aptAvb}</span></td></tr>
	     <tr><td>Price per day</td><td><span>&#8358;${aptAmount}</span></td></tr>
	     <tr><td>Category</td><td><span>${aptCategory}</span></td></tr>
	     <tr><td>Property type</td><td><span>${aptPType}</span></td></tr>
	     <tr><td>No. of rooms</td><td><span>${aptRooms}</span></td></tr>
	     <tr><td>No. of units</td><td><span>${aptUnits}</span></td></tr>
	     <tr><td>No. of bedrooms</td><td><span>${aptBedrooms}</span></td></tr>
	     <tr><td>No. of bathrooms</td><td><span>${aptBathrooms}</span></td></tr>
	     <tr><td>Pets</td><td><span>${aptPets}</span></td></tr>
	     <tr><td>Facilities & services</td><td><span>${ff}</span></td></tr>
	     <tr>
		  <td>Images</td>
		  <td>
		    <h4>${aptImages.length} ${ii}</h4>
		     ${rawImgs.map(r => r.src + " " + r.cml).join("")}
		  </td></tr>
	`;
	
	$(`#${id}-final-preview`).html(i);
}


const aptPreferencePreview = (id) => {
	 //side 1 
	   let aptMaxAdults = $(`#${id}-max-adults`).val(), aptMaxChildren = $(`#${id}-max-children`).val(),
	   aptAvb = $(`#${id}-avb`).val(), aptAmount = $(`#${id}-amount`).val(),
       aptRating = $(`#${id}-rating`).val(),aptIdRequired = $(`#${id}-id-required`).val(),
	   aptChildren = $(`#${id}-children`).val(), aptIdPets = $(`#${id}-pets`).val(),
       aptCity = $(`#${id}-city`).val(),aptState = $(`#${id}-state`).val();
		   
		   let fff = [];
		   for(let y = 0; y < facilities.length; y++){
			 if(facilities[y].selected) fff.push(facilities[y]);
		   }
		   
		   let ff = `None specified`;
		   if(fff.length > 0){
			   ff = `${fff[0].id}`;
		     for(let y = 1; y < fff.length; y++){
				 let ii = fff[y];
			   if(ii.selected) ff += ` | ${ii.id}`;
		     }
		   }

	let i = `
												<li>Availability<span>${aptAvb}</span></li>
												<li>Location<span>${aptCity}, ${aptState}</span></li>
												<li>Min. rating<span>${aptRating}</span></li>
												<li>Min. price per day<span>&#8358;${aptAmount}.00</span></li>
												<li>Max. adults<span>${aptMaxAdults}</span></li>
												<li>Max. children<span>${aptMaxChildren}</span></li>
												<li>Payment type<span>Card</span></li>
												<li>ID required on check-in<span>${aptIdRequired}</span></li>
												<li>Children<span>${aptChildren}</span></li>
												<li>Facilities & services<span>${ff}</span></li>
	`;
	
	$(`#${id}-final-preview`).html(i);
}


const updateApartmentPreference = (dt) => {
	//create request
	const req = new Request("apartment-preferences",{method: 'POST', body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to update apartment preferences: " + error);			
			$('#apartment-preference-loading').hide();
		     $('#apartment-preference-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
		   if(res.status == "ok"){
              Swal.fire({
			     icon: 'success',
                 title: "Apartment preferences updated!"
               }).then((result) => {
               if (result.value) {                 
			     window.location = `apartment-preferences`;
                }
              });
		   }
		   else if(res.status == "error"){
			   let hh = ``;
			   if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               });					 
		   }
		    $('#apartment-preference-loading').hide();
		     $('#apartment-preference-submit').fadeIn();
		   
		  
	   }).catch(error => {
		     alert("Failed to update apartment preferences: " + error);			
			$('#apartment-preference-loading').hide();
		     $('#apartment-preference-submit').fadeIn();			
	   });
}

const addApartment = (dt) => {
	//create request
	const req = new Request("post-apartment",{method: 'POST', body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to add apartment: " + error);			
			$('#pa-loading').hide();
		     $('#pa-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
		   if(res.status == "ok"){
              Swal.fire({
			     icon: 'success',
                 title: "Apartment added!"
               }).then((result) => {
               if (result.value) {                 
			     window.location = `apartments`;
                }
              });
		   }
		   else if(res.status == "error"){
			   let hh = ``;
			   if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "network"){
				 hh = `A network error has occured, please check your connection and try again.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               }).then((result) => {
               if (result.value) {
                  $('#pa-loading').hide();
		          $('#pa-submit').fadeIn();	
                }
              });					 
		   }
		  
		   
		  
	   }).catch(error => {
		     alert("Failed to add apartment: " + error);			
			$('#pa-loading').hide();
		     $('#pa-submit').fadeIn();			
	   });
}

const myAptSetCurrentCoverImage = (dt) => {
	console.log(dt);
	let uu = `sci?xf=${dt.id}&apartment_id=${dt.apartment_id}`;
	window.location = uu;
}

const myAptRemoveCurrentImage = (dt) => {
	console.log(dt);
	let uu = `ri?xf=${dt.id}&apartment_id=${dt.apartment_id}`;
	window.location = uu;
}

const updateApartment = (dt) => {
	//create request
	const req = new Request("my-apartment",{method: 'POST', body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to update apartment: " + error);			
			$('#my-apartment-loading').hide();
		     $('#my-apartment-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
		   if(res.status == "ok"){
              Swal.fire({
			     icon: 'success',
                 title: "Apartment information updated."
               }).then((result) => {
               if (result.value) {                 
			     window.location = `my-apartments`;
                }
              });
		   }
		   else if(res.status == "error"){
			   let hh = ``;
			   if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               }).then((result) => {
               if (result.value) {
                  $('#my-apartment-loading').hide();
		          $('#my-apartment-submit').fadeIn();	
                }
              });					 
		   }
		  
		   
		  
	   }).catch(error => {
		     alert("Failed to add apartment: " + error);			
			$('#my-apartment-loading').hide();
		     $('#my-apartment-submit').fadeIn();			
	   });
}

const aptShowGrid = () => {
	viewType = "grid";
	perPage = 8;
	//$('apartments-list').hide();
	//$('apartments-grid').fadeIn();
	showPage(page,true);
}

const aptShowList = () => {
	viewType = "list";
	perPage = 5;
	//$('apartments-grid').hide();
	//$('apartments-list').fadeIn();
	showPage(page,true);
}

const showPage = (p,changeViewType=false) => {
	//console.log("arr length: ",productsLength);
	//console.log("show per page: ",perPage);
	$('#pagination-row').hide();
	$('#products').html("");
	let start = 0, end = 0;
	
	if(apartmentsLength < perPage){
		end = apartmentsLength;
	}
	else{
		start = (p * perPage) - perPage;
		end = p * perPage;
	}
	
	console.log(`start: ${start}, end: ${end},page: ${page}, p: ${p}, changeViewType: ${changeViewType}`);

	let hh = "", cids = [];
    
	
	if(page != p || changeViewType){
		$('#apartments').hide();
        $('#apartments').html(``);
		for(let i = start; i < end; i++){
		if(i < apartmentsLength)
		{
		let a = apartments[i];
	    //console.log(a);
	
		cids.push(a.apartment_id);
		let nnn = a.name;
		if(a.name.length > 12){
			nnn = `${a.name.substr(0,12)}..`;
		}
		
		let facilities = JSON.parse(a.facilities);
		let description = `${a.description}`;
		let starsText = "";

		for(let x = 0; x < a.stars; x++){
			starsText += "<i class='fa fa-star filled'></i>";
		}
		for(let y = 0; y < 5 - a.stars; y++){
			starsText += "<i class='fa fa-star'></i>";
		}
 	
	    if(viewType == "grid"){
			hh = `
				    <!-- Single Place -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="singlePlaceitem">
										<figure class="singlePlacewrap">
											<a class="place-link" href="${a.uu}">
												<img class="cover" src="${a.img}" alt="room">
											</a>
										</figure>
										<div class="placeDetail">
											<span class="onsale-section"><span class="onsale">45% Off</span></span>
											<div class="placeDetail-left">
												<div class="item-rating">
													${starsText}
													<span>${a.reviews} Reviews</span>
												</div>
												<h4 class="title"><a href="${a.uu}">${nnn}</a></h4>
												<span class="placeDetail-detail"><i class="ti-location-pin"></i>${a.location}</span>
											</div>
											<div class="pricedetail-box">
											<h6 class="price-title-cut">&#8358;0.00</h6>
											<h4 class="price-title">&#8358;${a.amount}</h4>
											</div>
										</div>
									</div>
								</div>
		   `;
		}
		else if(viewType == "list"){
			hh = `
			    <!-- Single List -->
								<div class="book_list_box popular_item">
									<div class="row no-gutters">
										
										<div class="col-lg-4 col-md-4">
											<figure>
												<a href="${a.uu}"><img src="${a.img}" class="img-responsive" alt=""></a>
											</figure>
										</div>
										
										<div class="col-lg-6 col-md-6 pl-5 side-br">
											<div class="book_list_header">
												<div class="view-ratting">
													${starsText}
												</div>
												<h4 class="book_list_title"><a href="${a.uu}">${a.name}</a></h4>
												<span class="location"><i class="ti-location-pin"></i>${a.location}</span>
											</div>
											<div class="book_list_description">
												<p>${a.description}</p>
											</div>
											<div class="book_list_rate">
												<h5 class="over_all_rate high"><span class="rating_status">${a.stars}</span>Very Good<small>(${a.reviews} Reviews)</small></h5>
											</div>
											<div class="book_list_offers">
												<ul>
													<li><i class="ti-location-pin"></i>Free WiFi</li>
													<li><i class="ti-car"></i>Parking</li>
													<li><i class="ti-cup"></i>Breakfast</li>
												</ul>
											</div>
										</div>
										
										<div class="col-lg-2 col-md-2 padd-l-0">
											<div class="book_list_foot">
												<span class="off-status theme-cl">${a.status}</span>
												<h4 class="book_list_price">&#8358;${a.amount}</h4>
												<span class="booking-time">per night</span>
												<a href="${a.uu}" class="book_list_btn btn-theme">View</a>
											</div>
										</div>
										
									</div>
								</div>
			`;
		}
		
		$('#apartments').append(hh);
	  }
	}
	
	page = p;
	$('#apartments').fadeIn();
	//fbq('track', 'ViewContent', {content_ids: cids, currency: "NGN", content_type: 'product'});
	
	}
	
	
}

const showPreviousPage = () => {
	let sp = apartmentsLength < perPage ? 1 : Math.ceil(apartmentsLength / perPage), pp = page - 1;
	//console.log(`page: ${page},sp: ${sp},pp: ${pp}`);
	if(pp < 1) pp = 1;
	if(sp > pp && pp > 0){
		showPage(pp);
	}
	
}

const showNextPage = () => {

		let sp = apartmentsLength < perPage ? 1 : Math.ceil(apartmentsLength / perPage), pp = page - 1;
		if(pp < 1) pp = 1;
	console.log(`page: ${page},sp: ${sp},pp: ${pp}`);
	
	if(sp >= pp){
		showPage(pp);
	}

}

const changePerPage = () =>{
	       perPage = $('#per-page').val();
		   if(perPage == "none") perPage = 3;

}

const isMobile = () =>{
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	return isMobile;
}


const search = dt => {
	console.log("dt: ",dt);
	$('#guest-apt-sidebar-dt').val(JSON.stringify(dt));
	$('#guest-apt-sidebar-form').submit();
}

const sendMessage = (dt,id) => {
	//create request
	const req = new Request("chat",{method: 'POST', body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send message: " + error);			
			$(`#${id}-loading`).hide();
		     $(`#${id}-btn`).fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
		   if(res.status == "ok"){
              Swal.fire({
			     icon: 'success',
                 title: "Message sent!"
               });
			   $(`#${id}-msg`).val("");
			  if(id == "message-reply") window.location = "messages";
		   }
		   else if(res.status == "error"){
			   let hh = `nothing happened`;
			   if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               });		  
		   }
		   $(`#${id}-loading`).hide();
		   $(`#${id}-btn`).fadeIn();
		  
	   }).catch(error => {
		     alert("Failed to send message: " + error);			
			$('#apt-chat-loading').hide();
		     $('#apt-chat-btn').fadeIn();			
	   });
}

const checkForMessages = () => {
	console.log("checking for new messages..");
}

const showChat = (gxf) => {
	console.log(`showing messages for ${gxf}`);
	 let chats = msgs.filter(m => m.gxf == gxf);
	$('#chat-body').hide();
	//display chats
   
   let hh = ``;
	
	for(let i = chats.length - 1; i >=0; i--){
		let c = chats[i];
		
		//set global settings for current chat
		if(i == 0){
		  aapt = c.apt_id;
		  ggxf = c.gxf;
		} 
    console.log('i: ',i);
    console.log('c: ',c);
		
	if(c.gsb == c.gxf){
			hh += `
			  <div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="${c.a}" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer">
									${c.m}
									<span class="msg_time">${c.d}</span>
								</div>
							</div>
			`;
		}
		else if(c.gsb == hhxf){
			hh += `
			  <div class="d-flex justify-content-end mb-4">
								<div class="msg_cotainer_send">
									${c.m}
									<span class="msg_time_send">${c.d}</span>
								</div>
								<div class="img_cont_msg">
							<img src="${ha}" class="rounded-circle user_img_msg">
								</div>
							</div>
			`;
		}
	}
	
	$('#chat-body').html(hh);
	$('#chat-body').fadeIn();
}

const scrollTo = dt => {
	document.querySelector(`${dt.id}`).scrollIntoView({
          behavior: 'smooth' 
        });
}

const setUserRating = dt => {
	
	switch(dt.r){
		case "sec":
		  sec = dt.v;
		break;
		
		case "svc":
		  svc = dt.v;
		break;
		
		case "loc":
		  loc = dt.v;
		break;
		
		case "cln":
		  cln = dt.v;
		break;
		
		case "cmf":
		  cmf = dt.v;
		break;
	}
}

const voteReview = dt => {
$(`#review-${dt.rxf}-loading`).fadeIn();
//create request
   let url = `vote-review?rxf=${dt.r}&type=${dt.type}&xf=${dt.xf}`;
	const req = new Request(url,{method: 'GET'});
	console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to vote review: " + error);			
			$(`#review-${dt.rxf}-loading`).hide();
	   })
	   .then(res => {
		   console.log(res);
          $(`#review-${dt.rxf}-loading`).hide();
		  
		   if(res.status == "ok"){
			   let d = res.data;
			   $(`#review-${dt.rxf}-upvotes`).val(d.u);
			   $(`#review-${dt.rxf}-downvotes`).val(d.d);
		   }
		   else if(res.status == "error"){
			   let hh = `nothing happened`;
			   if(res.message == "auth"){
				 hh = `Please sign in to vote a review.`;  
			   }
			   else if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "duplicate"){
				 hh = `You've voted this review already.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               });		  
		   }
		   $(`#review-${dt.rxf}-loading`).hide();
		  
	   }).catch(error => {
		     alert("Failed to vote review: " + error);			
			$(`#review-${dt.rxf}-loading`).hide();			
	   });	
}

const goToApartment = u => {
	window.location = `apartment?xf=${u}`;
}

const addTime = dt => {
    let date = new Date(dt.date), ret = "";
	
	switch(dt.period){
		case "days":
		  ret = date.setDate(date.getDate() + dt.value);  
		break;
	}
    
	return ret;
}

const payCard = dt =>{
	
	Swal.fire({
    title: `Order reference: ${dt.ref}`,
  imageUrl: "img/paystack.png",
  imageWidth: 400,
  imageHeight: 200,
  imageAlt: `Pay for order ${dt.ref} with card`,
  showCloseButton: true,
  html:
     "<h4 class='text-danger'><b>NOTE: </b>Make sure you note down your reference number above, as it will be required in the case of any issues regarding this order.</h4><p class='text-primary'>Click OK below to redirect to our secure payment gateway to complete this payment.</p>"
}).then((result) => {
  if (result.value) {
	  let a = false;
	  mc['notes'] = $('#notes').val();
	  mc['sps'] = $('#checkout-sps').val();
	  mc['pt'] = dt.pt;
	 
	 $('#nd').val(JSON.stringify(mc)); 
	console.log(mc);
	

	let paymentURL = $("#card-action").val(); 
	$('#checkout-form').attr('action',paymentURL);
   $('#checkout-form').submit();

  }
});

}

const getAnalytics = dt => {
//create request
   let url = `analytics?type=${dt.type}&month=${dt.month}&year=${dt.year}`;
	const req = new Request(url,{method: 'GET'});
	console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		   Swal.fire({
			     icon: 'error',
                 title: `Failed to get analytics: ${error}`
               });		  
			$(`#host-${dt.type}-loading`).hide();
	   })
	   .then(res => {
		   console.log(res);
          $(`#host-${dt.type}-loading`).hide();
		  
		   if(res.status == "ok"){
			   let d = res.data;
			   
			   if(dt.type == "total-revenue"){
				   $('#host-transactions-bar').hide();
				      $('#host-transactions-bar').html("");
					  
				   if(d.length){
				     Morris.Bar({
                      element: 'host-transactions-bar',
                      data: d,
                      xkey: 'x',
                      ykeys: ['y'],
                      labels: ['Revenue(N)'],
                      barColors: ['#5969ff'],
                       resize: true,
                          gridTextSize: '14px'
                     });   
				   }
				   else{
					   $('#host-transactions-bar').html("<h3>No data could be found.</h3>");
				   }
				   
				   $('#host-transactions-bar').fadeIn();
			   }
			   else if(dt.type == "best-selling-apartments"){
				   $('#host-best-selling-apartments-donut').hide();
				      $('#host-best-selling-apartments-donut').html("");
					  
				   if(d.length){
				     Morris.Donut({
                element: 'host-best-selling-apartments-donut',
                data: d,
             
                labelColor: '#2e2f39',
                   gridTextSize: '14px',
                colors: [
                     "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750"
                               
                ],

                formatter: function(x) { return "N" + x },
                  resize: true
            });   
				   }
				   else{
					   $('#host-best-selling-apartments-donut').html("<h3>No data could be found.</h3>");
				   }
				   
				   $('#host-best-selling-apartments-donut').fadeIn();
			   }
		   }
		   else if(res.status == "error"){
			   let hh = `nothing happened`;
			   if(res.message == "auth"){
				 hh = `Please sign in to view analytics.`;  
			   }
			   else if(res.message == "validation"){
				 hh = `Please fill all required fields and try again.`;  
			   }
			   else if(res.message == "Technical error"){
				 hh = `A technical error has occured, please try again.`;  
			   }
			   Swal.fire({
			     icon: 'error',
                 title: hh
               });		  
		   }
		  
	   }).catch(error => {
		     Swal.fire({
			     icon: 'error',
                 title: `Failed to get analytics: ${error}`
               });		  
			$(`#host-${dt.type}-loading`).hide();			
	   });	
}

const togglePP = dt => {
	 // console.log(`selecting facility ${dt}`);
	  ret = {ptag: dt, selected: false};

		   let pp = apTags.find(p => p.ptag == dt);

		  if(pp){
			pp.selected = !pp.selected;  
		  }
		  
}
/**********************************************************************************************************************
                                                     OLD METHODS
/**********************************************************************************************************************/

function bomb(dt,url){

	//create request
	const req = new Request(url,{method: 'POST', headers: {'Content-Type': 'application/json'}, body: dt});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send message: " + error);			
	   })
	   .then(res => {
		   console.log(res);
		   let ev = true;
			
		   if(res.status == "ok"){
			   if(res.message === "finished"){
			      alert("All messages have been sent. To send more messages you need to delete the old leads and select new ones");
				  ev = false;
				  $("#stop-btn").hide();
		          $("#send-btn").fadeIn();
			    }
				else{
				  let ug = res.ug;
		          let bdg = $('#bdg-' + ug);
			      $('#rmk-' + ug).html("Message Sent!");			  
			      bdg.removeClass(bdg.attr("data-badge"));
			      bdg.addClass("badge-success");
                  bdg.html("sent");				  
				}
		   }
		   else if(res.status == "error"){
			   if(res.message == "Network error"){
				     alert("An unknown network error has occured. Please refresh the app or try again later");
                     ev = false;					 
			   }
			   else{
			   let ug = res.ug;
		       let bdg = $('#bdg-' + ug);
			   $('#rmk-' + ug).html("Failed to send message: " + res.message);
			   bdg.removeClass(bdg.attr("data-badge"));
			   bdg.addClass("badge-danger");
			   bdg.html("failed");
			   }
		   }
		   
		   if(ev === true){
		      setTimeout(function(){
		       bomb(dt,url);
		      },5000);
		    }
		   
	   }).catch(error => {
		    alert("Failed to send message: " + error);			
	   });
}


function printElem(html)
{
    let mywindow = window.open('', 'PRINT');
    let content = `
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>${document.title}</title>
<!-- Google fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<!-- Ionicons font -->
<link href="css/ionicons.min.css" rel="stylesheet">
<!-- Bootstrap styles-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!--custom styles-->
<link href="css/custom.css" rel="stylesheet" />
<link href="css/custom-pink.css" rel="stylesheet"/>
<link href="css/custom-turquoise.css" rel="stylesheet" />
<link href="css/custom-purple.css" rel="stylesheet" />
<link href="css/custom-orange.css" rel="stylesheet" />
<link href="css/custom-blue.css" rel="stylesheet" />
<link href="css/custom-green.css" rel="stylesheet" />
<link href="css/custom-red.css" rel="stylesheet" />
<link href="css/custom-gold.css" rel="stylesheet" id="style">
<!--tooltiop-->
<link href="css/hint.css" rel="stylesheet">
<!-- animation -->
<link href="css/animate.css" rel="stylesheet" />
<!--select-->
<link href="css/bootstrap-select.min.css" rel="stylesheet">
<!--color picker-->
<link href="css/jquery.simplecolorpicker.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
<!-- favicon -->

<link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">

<!--jQuery--> 
<script src="js/jquery.min.js"></script> 
<!--SweetAlert--> 
<script src="lib/sweet-alert/all.js"></script>
</head><body>
${html}
</body></html>
	`;
    
	mywindow.document.write(content);
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    //mywindow.print();
    //mywindow.close();

    return true;
}

function supportsLocalStorage(){
	try{
	  return 'localStorage' in window && window['localStorage'] !== null;
	}
	catch(e){
		return false;
	}
}

const generateRandomString = (length) => {
	let chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	let ret = '';
	
	for(let i = length; i > 0; --i){
		ret += chars[Math.floor(Math.random() * chars.length)];
	}
	return ret;
}

function addToWishlist(dt)
{
  let wu = `add-to-wishlist?sku=${dt.sku}&gid=${gid}`;
  console.log("wu: ",wu);
  window.location = wu;
}

function removeFromWishlist(dt)
{
  let wu = `remove-from-wishlist?sku=${dt.sku}&gid=${gid}`;
  window.location = wu;
}

function addToCompare(dt)
{
  let cu = `add-to-compare?sku=${dt.sku}&gid=${gid}`;
  window.location = cu;
}

function removeFromCompare(dt)
{
  let wu = `remove-from-compare?sku=${dt.sku}&gid=${gid}`;
  window.location = wu;
}

function showCheckout(type){
	switch(type){
		case 'new':
		 $('#checkout-anon').hide();
		 $('#checkout-new').fadeIn();
		break;
		
		case 'anon':
		 $('#checkout-new').hide();
		 $('#checkout-anon').fadeIn();
		break;
	}
}



const getCart = () => {
	let cart = null;
	
    try{
		let c = localStorage.getItem('cart');
		if(c){
			cart = JSON.parse(c);
			console.log("cart: ",cart);
		}
		else{
			cart = [];
		}
	}
	
	catch(err){
		console.log("err in getCart(): ",err);
		cart = [];
	}
	
	return cart;
}

const setCartData = (cart) => {
	document.querySelector('#cart-badge').innerHTML = cart.length;
			let cartMenu = document.querySelector('#cart-menu');
			let htt = cartMenu.innerHTML;
			
			for(let j = 0; j < cart.length; j++){
				let cc = cart[j];
				htt += `
                  <li><div class="lnt-cart-products text-success"><i class="ion-android-checkmark-circle icon"></i> {{$item['sku']}} <b>x{{$qty}}</b><span class="lnt-cart-total">&#8358;{{number_format($itemAmount * $qty, 2)}}</span> </div></li>
				 `; 
				 
			}
			htt += `<li class="lnt-cart-actions text-center"> <a class="btn btn-default btn-lg hvr-underline-from-center-default" href="{{url('cart')}}">View cart</a> <a class="btn btn-primary hvr-underline-from-center-primary" href="{{url('checkout')}}">Checkout</a> </li>`;
			cartMenu.innerHTML = htt;
}

const setCookie = (k,v) => {
	var d = new Date;
            d.setTime(d.getTime() + 24 * 60 * 60 * 60 * 1e3);
            var e = "; expires=" + d.toGMTString();
	 document.cookie = k + "=" + v + e;
}

const getCookie = (a) => {
	for (var b = a + "=", c = document.cookie.split(";"), d = 0; d < c.length; d++) {
            for (var e = c[d]; " " == e.charAt(0); )
                e = e.substring(1, e.length);
            if (0 == e.indexOf(b))
                return e.substring(b.length, e.length)
        }
        return null;
}

const getParameterByName = (name, url) => {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

const syncData = (dt) => {
    let url = "sync-data";
	//create request
	const req = new Request(url,{method: "POST",body: dt});
	console.log("dt: ",dt);
	
	
	//fetch request
	return fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to send message: " + error);			
	   })
	   .then(res => {
		   console.log("syncData returned: ",res);
		   
	   }).catch(error => {
		    alert("Failed to call getProducts: " + error);			
	   });
}

const searchToCart = (s) => {
	 let qty = $(`#search-qty-${s}`).val();
	   //console.log("qty: ",qty);
	   addToCart({sku: s,qty: qty});
}

const addXF = dt => {
	$(`#${dt.type}-xf`).val(dt.xf);
	$(`#${dt.type}-name`).html(`to ${dt.name}`);
}

const copyData = dt => {
	let ret = ``, title = ""; 
	if(dt.type){
		let elems = $(`.${dt.type}`);
		
		if(elems.length > 0){
			for(let i = 0; i < elems.length; i++){
				let ei = $(elems[i]).html();
			  ret += `${ei}
`;
			}
		}
		
		switch(dt.type){
			case "ge":
			  title = "guest email addresses";
			break;
			case "gp":
			  title = "guest phone numbers";
			break;
			case "he":
			  title = "host email addresses";
			break;
			case "hp":
			  title = "host phone numbers";
			break;
		}
	}
	console.log(ret);
	$(`#copy-data-name`).html(title);
	$(`#copy-data-msg`).val(ret);
}
