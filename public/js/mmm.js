
	let  toolbar = ['title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr', '|', 'indent', 'outdent', 'alignment'];
	

$(document).ready(function() {
    "use strict";
	hideInputErrors(["signup","login","forgot-password","reset-password","oauth-sp"]);
	hideElem(["#signup-loading","#signup-finish",
	          "#login-loading","#login-finish",
			  "#fp-loading","#fp-finish",
			  "#rp-loading","#rp-finish",
			  "#apt-chat-loading","#apt-chat-finish","#message-reply-loading",
                          "#as-other"
			  ]);
	
	hideElem(['#send-message-type-error','#send-message-subject-error','#send-message-msg-error', '#send-message-email-div']);
	
	hideElem(["#sps-row","#pa-side-2","#pa-side-3","#ap-loading"]);
	
	/**
	//Init wysiwyg editors
	Simditor.locale = 'en-US';
	let aptDescriptionTextArea = $('#pa-description');
	//console.log('area: ',aptDescriptionTextArea);
	**/
	
    
     $('#spp-show').click((e) => {
	   e.preventDefault();
	   let spps = $('#spp-s').val();
	   
	   if(spps == "hide"){
		   $('#as-password').attr('type',"password");
		   $('#spp-show').html("Show");
		   $('#spp-s').val("show");
	   }
	   else{
		   $('#as-password').attr('type',"text");
		   $('#spp-show').html("Hide");
		   $('#spp-s').val("hide");
	   }
   });
		
		$("#server").change((e) =>{
			e.preventDefault();
			let server = $("#server").val();
			console.log("server: ",server);
			
			if(server == "other"){
				$('#as-other').fadeIn();     
            }
            else{
				$('#as-other').hide();     
            }
			
		});
		 $("#add-sender-submit").click(function(e){            
		       e.preventDefault();
			   let valid = true;
			   let name = $('#as-name').val(), username = $('#as-username').val(),
			   pass = $('#as-password').val(), s = $('#server').val(),
			   ss = $('#as-server').val(), sp = $('#as-sp').val(), sec = $('#as-sec').val();
			   
			   if(name == "" || username == "" || pass == "" || s == "none"){
				   valid = false;
			   }
			   else{
				   if(s == "other"){
					   if(ss == "" || sp == "" || sec == "nonee") valid = false;
				   }
			   }
			   
			   if(valid){
				 $('#as-form'). submit();
			    //updateDeliveryFees({d1: d1, d2: d2});  
			   }
			   else{
				   Swal.fire({
			            icon: 'error',
                                    title: "Please fill all the required fields"
                                   })
			   }
             
		  });
	
	
    $("a.lno-cart").on("click", function(e) {
    	if(isMobile()){
    	  window.location = "cart";
       }
    })
    
	
	$("#s-form-btn").click(e => {
       e.preventDefault();
	  
       hideInputErrors("signup");	  
      let fname = $('#signup-fname').val(), lname = $('#signup-lname').val(),
	      username = $('#signup-username').val(),p = $('#signup-password').val(), p2 = $('#signup-password-2').val();
		  
		  
	   if(fname == "" || lname == "" || username == "" || p == "" || p != p2){
		  Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           });
	   }
	   else{
		 $('#s-form').submit();   
	   }
    });
	
	$("#l-form-btn").click(e => {
       e.preventDefault();
	  
       hideInputErrors("login");	  
      let id = $('#login-id').val(),p = $('#login-password').val();
		  
		  
	   if(id == "" || p == ""){
		  Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           });
	   }
	   else{
		 $('#l-form').submit();   
	   }
    });
	
	$("#fp-submit").click(e => {
       e.preventDefault();
	  
       hideInputErrors("forgot-password");	  
      let id = $('#fp-email').val();
		  
		  
	   if(id == ""){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill in your email address."
           });
	   }
	   else{
		  hideElem("#fp-submit");
		  showElem("#fp-loading");
		  
		 fp({
			 email: id
		 });   
	   }
    });
	
	$("#rp-submit").click(e => {
       e.preventDefault();
	  
       hideInputErrors("reset-password");	  
      let id = $('#acsrf').val(), p = $('#rp-pass').val(), p2 = $('#rp-pass2').val();
		  
		  
	   if(p == "" || p2 == "" || p != p2){
		   let hh = "default";
		   if(p == "") hh = "Enter your new password.";
		   if(p2 == "" || p != p2) hh = "Passwords must match.";
		   
		    Swal.fire({
			 icon: 'error',
             title: hh
           });
	   }
	   else{
		  hideElem("#rp-submit");
		  showElem("#rp-loading");
		  
		 rp({
			 id: id,
			 pass: p
		 });   
	   }
    });
	
	$("#osp-submit").click(e => {
       e.preventDefault();
	  
       hideInputErrors("oauth-sp");	  
      let p = $('#osp-pass').val(), p2 = $('#osp-pass2').val();
		  
		  
	   if(p == "" || p2 == "" || p != p2){
		   if(p == "") showElem('#osp-pass-error');
		   if(p2 == "" || p != p2) showElem('#osp-pass2-error');
	   }
	   else{
		 $('#osp-form').submit();   
	   }
    });
	
	
	//DASHBOARD
	if ($('#revenue_by_room_category').length) {
            Morris.Donut({
                element: 'revenue_by_room_category',
                data: rbrcData,
             
                labelColor: '#2e2f39',
                   gridTextSize: '14px',
                colors: [
                     "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#0540f2"
                               
                ],

                formatter: function(x) { return "N" + x },
                  resize: true
            });
	}   
		
	if($('#total_revenue_month').length){
			 // ============================================================== 
    // Total Revenue
    // ============================================================== 
    Morris.Area({
        element: 'total_revenue_month',
        behaveLikeLine: true,
        data: trmData,
        xkey: 'x',
        ykeys: ['y'],
        labels: ['Total'],
        lineColors: ['#5969ff'],
        resize: true,
		 dateFormat: function(x) { 
		   let d = new Date(x).toString(), dd = d.split(" "), ret = "";
           if(dd.length > 4){
			 ret = `${dd[0]} ${dd[1]} ${dd[2]}, ${dd[3]}`;
		   }   
           return ret;		 
		 },
		 preUnits: "NGN"

    });
		}
	
	//EDIT USER
	$("#user-form-btn").click(e => {
       e.preventDefault();
	   
	   //side 1 validation
	   let fname = $('#user-fname').val(), lname = $('#user-lname').val(),email = $('#user-email').val(),
	       phone = $('#user-phone').val(), role = $('#user-role').val(),status = $('#user-status').val(),
		   side1_validation = (fname == "" || lname == "" || email == "" || phone == "" || role == "none" || status == "none");	  
	  
       
	   if(side1_validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else{
		  $('#user-form').submit();		  
	   }
    });
	
	//ADD PERMISSIONS
	$("#ap-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let apSelected = false;
	   
	   for(let i = 0; i < apTags.length; i++){
		   apSelected = apSelected || apTags[i].selected;
	   }
	    console.log(apSelected);
	   let side1_validation = !apSelected;	  
	 
       
	   if(side1_validation){
		   Swal.fire({
			 icon: 'error',
             title: "Select a permission"
           })
	   }
	   else{
		   $('#ap-pp').val(JSON.stringify(apTags));
		  $('#ap-form').submit();		  
	   }
	   
	   
    });
	
	//ADD PLUGIN
	$("#apl-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let aplName = $('#apl-name').val(), aplValue = $('#apl-value').val(), aplStatus = $('#apl-status').val(),
	       validation = (aplName == "" || aplValue == "" || aplStatus == "none");
	   
	   
       
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else{
		  $('#apl-form').submit();		  
	   }
	   
	   
    });
	
	//ADD TICKET
	$("#add-ticket-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let atEmail = $('#add-ticket-email').val(), atSubject = $('#add-ticket-subject').val(), atType = $('#add-ticket-type').val(),
           atApt = $('#add-ticket-apt').val(), atMsg = $('#add-ticket-msg').val(),
		   validation = (atEmail == "" || atSubject == "" || atType == "none" || atMsg == "");
	   
	   
       
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else{
		  $('#add-ticket-form').submit();		  
	   }
	   
	   
    });
	
	//UPDATE TICKET
	$("#ut-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let utMsg = $('#ut-msg').val(), validation = (utMsg == "");
	   
	   
       
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else{
		  $('#ut-form').submit();		  
	   }
	   
	   
    });
	
	//ADD BANNER
	$("#ab-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let abType = $('#ab-type').val(), validation = (abType == "none"),
	        abImages = $(`#ab-images input[type=file]`), emptyImage = false;
			
	     for(let i = 0; i < abImages.length; i++){
			   if(abImages[i].files.length < 1) emptyImage = true;
		   }
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else if(emptyImage){
		   Swal.fire({
			 icon: 'error',
             title: "You have an empty image field."
           })
	   }
	   else{	 
		 $('#ab-form').submit();
	   }
	   
	   
    });
    
    //ADD FAQ
	$("#faq-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let tag = $('#faq-tag').val(), question = $('#faq-question').val(), 
       answer = $('#faq-answer').val(), validation = (question == "" || answer == "" || tag == "none");
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#faq-form').submit();
	   }   
    });
    
    $("#faq-tag-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let tag = $('#faq-tag').val(), name = $('#faq-name').val(), 
       validation = (name == "" || tag == "");
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#faq-tag-form').submit();
	   }   
    });
	
	$("#abp-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let title = $('#ap-title').val(), url = $('#ap-url').val(), description = $('#ap-description').val(), 
	     apImages = $(`#ap-images input[type=file]`), emptyImage = false, validation = (title == "" || url == "" || description == "");
			
	     for(let i = 0; i < apImages.length; i++){
			   if(apImages[i].files.length < 1) emptyImage = true;
		   }
       
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   else if(emptyImage){
		   Swal.fire({
			 icon: 'error',
             title: "Please upload an image."
           })
	   }
	   
	   else{	 
		 $('#abp-form').submit();
	   }   
    });
	
	$("#ubp-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let title = $('#ap-title').val(), url = $('#ap-url').val(), description = $('#ap-description').val(), 
	     apImages = $(`#ap-images input[type=file]`), emptyImage = false, validation = (title == "" || url == "" || description == "");
			
	     for(let i = 0; i < apImages.length; i++){
			   if(apImages[i].files.length < 1) emptyImage = true;
		   }
       
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	 
	   
	   else{	 
		 $('#ubp-form').submit();
	   }   
    });
	
	//APARTMENTS
	$("#admin-apt-prev").click(e => {
       e.preventDefault();
	   
	   if(selectedSide == 2){
		   $('#admin-apt-side-2').hide();
		   $('#admin-apt-side-1').fadeIn();
		   selectedSide = 1;
	   }
    });
	
	$("#admin-apt-next").click(e => {
       e.preventDefault();
	   
	   if(selectedSide == 1){
		   $('#admin-apt-side-1').hide();
		   $('#admin-apt-side-2').fadeIn();
		   selectedSide = 2;
	   }
    });
    
	
	//ADD APARTMENT
	$("#pa-side-1-next").click(e => {
       e.preventDefault();
	   
	   let aptUrl = $('#pa-url').val(), aptName = $('#pa-name').val(), aptAmount = $('#pa-amount').val(),
	   aptMaxAdults = $('#pa-max-adults').val(),aptMaxChildren = $('#pa-max-children').val(),aptDescription = $('#pa-description').val(),
	       aptCategory = $('#pa-category').val(), aptPType = $('#pa-ptype').val(),aptRooms = $('#pa-rooms').val(),
	       aptUnits = $('#pa-units').val(),aptBathrooms = $('#pa-bathrooms').val(),
		   aptBedrooms = $('#pa-bedrooms').val(), aptPets = $('#pa-pets').val(),
		      side1_validation = (aptUrl == "" || aptName == "" || aptMaxAdults == "" || aptMaxChildren == "" || aptAmount < 0 || aptDescription == "" || aptCategory == "none" || aptPType == "none" || aptRooms == "none" || aptUnits == "none" || aptBedrooms == "none" || aptBathrooms == "none" || aptPets == "none");	  
	  
	   if(side1_validation){
		  Swal.fire({
			     icon: 'error',
                 title: `All fields are required`
               }); 
	   }
	   else{
		 
		   hideElem(['#pa-side-1','#pa-side-3']);
	       showElem(['#pa-side-2']);
	   }
    });
	$("#pa-side-2-prev").click(e => {
       e.preventDefault();
	  hideElem(['#pa-side-2','#pa-side-3']);
	  showElem(['#pa-side-1']);
    });
	$("#pa-side-2-next").click(e => {
       e.preventDefault();
	   
	   //side 2 validation imgs = $(`${BUUPlist[bc].id}-images-div input[type=file]`);
	   let aptAddress = $('#pa-address').val(), aptCity = $('#pa-city').val(), aptLGA = $('#pa-lga').val(),aptState = $('#pa-state').val(),
	       aptCountry = $('#pa-country').val(), aptAVB = $('#pa-avb').val(), aptStatus = $('#pa-status').val(), aptImages = $(`#pa-images input[type=file]`), emptyImage = false,
           side2_validation = (facilities.length < 1 || aptAddress == "" || aptCity == "" || aptLGA == "" || aptState == "none" || aptCountry == "none" || aptAVB == "none" || aptStatus == "none");
		   
		   if(side2_validation){
			 Swal.fire({
			     icon: 'error',
                 title: `All fields are required`
               });   
		   }
		   else{
			  hideElem(['#pa-side-1','#pa-side-2']);

		   aptFinalPreview('pa');
		   showElem(['#pa-side-3']);
    
		   }
	     });
	$("#pa-side-3-prev").click(e => {
       e.preventDefault();
	  hideElem(['#pa-side-1','#pa-side-3']);
	  showElem(['#pa-side-2']);
    });	
	$("#pa-side-3-next").click(e => {
       e.preventDefault();
	   console.log("add apartment submit");
	   
	   //side 1 validation
	   let aptUrl = $('#pa-url').val(), aptName = $('#pa-name').val(), aptAmount = $('#pa-amount').val(),
	   aptMaxAdults = $('#pa-max-adults').val(),aptMaxChildren = $('#pa-max-children').val(),aptDescription = $('#pa-description').val(),
	       aptCategory = $('#pa-category').val(), aptPType = $('#pa-ptype').val(),aptRooms = $('#pa-rooms').val(),
	       aptUnits = $('#pa-units').val(),aptBathrooms = $('#pa-bathrooms').val(),
		   aptBedrooms = $('#pa-bedrooms').val(), aptPets = $('#pa-pets').val(),
		   side1_validation = (aptUrl == "" || aptName == "" || aptMaxAdults == "" || aptMaxChildren == "" || aptAmount < 0 || aptDescription == "" || aptCategory == "none" || aptPType == "none" || aptRooms == "none" || aptUnits == "none" || aptBedrooms == "none" || aptBathrooms == "none" || aptPets == "none" || facilities.length < 1);	  
	  
       //side 2 validation imgs = $(`${BUUPlist[bc].id}-images-div input[type=file]`);
	   let aptAddress = $('#pa-address').val(), aptCity = $('#pa-city').val(), aptLGA = $('#pa-lga').val(),aptState = $('#pa-state').val(),
	       aptImages = $(`#pa-images input[type=file]`), emptyImage = false,aptCountry = $('#pa-country').val(), aptAVB = $('#pa-avb').val(), aptStatus = $('#pa-status').val(),
           side2_validation = (aptAddress == "" || aptCity == "" || aptLGA == "" || aptState == "none" || aptCountry == "none" || aptAVB == "none" || aptStatus == "none");
           
		   for(let i = 0; i < aptImages.length; i++){
			   if(aptImages[i].files.length < 1) emptyImage = true;
		   }
		   
        // console.log("video: ",aptVideo);
         //console.log("images: ",aptImages);
	   
	   let aptPlan = $('#pa-plan').val(), side3_validation = (aptPlan == "none"); 
	   
	   if(side1_validation || side2_validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all the required fields"
           })
	   }
	   else if(emptyImage){
		   Swal.fire({
			 icon: 'error',
             title: "You have an empty image field."
           })
	   }
	   else if(aptCover == "none"){
		   Swal.fire({
			 icon: 'error',
             title: "Select a cover image."
           })
	   }
	   /**
	   else if(aptVideo[0].size > 15000000){
		   Swal.fire({
			 icon: 'error',
             title: "Video must not be larger than 10MB"
           })
	   }
	   **/
	   else{
		 //let aptName = $('#pa-name').val(),   
		 console.log("final");
		 
		 let ff = [];
		 for(let y = 0; y < facilities.length; y++){
			 if(facilities[y].selected) ff.push(facilities[y]);
		 }
		 
		 let fd =  new FormData();
		 fd.append("url",aptUrl);
		 fd.append("name",aptName);
		 fd.append("max_adults",aptMaxAdults);
		 fd.append("max_children",aptMaxChildren);
		 fd.append("description",aptDescription);
		 fd.append("rooms",aptRooms);
		 fd.append("category",aptCategory);
		 fd.append("property_type",aptPType);
		 fd.append("amount",aptAmount);
		 fd.append("bedrooms",aptBedrooms);
		fd.append("bathrooms",aptBathrooms);
		fd.append("units",aptUnits);
		 fd.append("pets",aptPets);
		 fd.append("address",aptAddress);
		 fd.append("city",aptCity);
		 fd.append("lga",aptLGA);
		 fd.append("state",aptState);
		 fd.append("country",aptCountry);
		 fd.append("avb",aptAVB);
		 fd.append("status",aptStatus);
		 fd.append("facilities",JSON.stringify(ff));
		 
		 //fd.append("video",aptVideo[0]);
		 fd.append("cover",aptCover);
		 fd.append("img_count",aptImages.length);
		 
		 for(let r = 0; r < aptImages.length; r++)
		 {
		    let imgg = aptImages[r];
			let imgName = imgg.getAttribute("id");
            //console.log("imgg name: ",imgName);			
            fd.append(imgName,imgg.files[0]);   			   			
		 }
		 
		 /**
		 for(let vv of fd.values()){
			 console.log("vv: ",vv);
		 }
		 **/
		  fd.append("_token",$('#tk-pa').val());
		  
		  $('#pa-submit').hide();
		  $('#pa-loading').fadeIn();
		  addApartment(fd);  
		  
	   }
    });
	
	//SUBSCRIPTION PLANS
	$("#asp-form-btn").click(e => {
       e.preventDefault();
	   
	   let name = $('#asp-name').val(), description = $('#asp-description').val(), amount = $('#asp-amount').val(),
	       psID = $('#asp-ps-id').val(), frequency = $('#asp-frequency').val(), pc = $('#asp-pc').val(),
		   validation = (name == "" || parseInt(amount) < 0 || parseInt(pc) < 0 || psID == "" || frequency == "none");
	   
	   if(validation){
		   Swal.fire({
			   icon: 'error',
			   title: `Please fill all required fields`
		   });
	   }
	   else{
		   $('#asp-form').submit();
	   }
    });
	
	
	//SEND MESSAGE
	$('#send-message-type').change(e => {
		e.preventDefault();
		let mt = $('#send-message-type').val();
		
		if(mt == "email"){
			showElem('#send-message-email-div');
		}
		else{
			hideElem('#send-message-email-div');
		}
	});
	
	$('#send-message-submit').click(e => {
		e.preventDefault();
		hideElem(['#send-message-type-error','#send-message-subject-error','#send-message-msg-error']);
		
		let mt = $('#send-message-type').val(), ms = $('#send-message-subject').val(), mm = $('#send-message-msg').val();
		let v = (mt == "none" || (ms == "" && mt == "email") || mm == "");
		
		if(v){
			if(mt == "none") showElem('#send-message-type-error');
			if(ms == "" && mt == "email") showElem('#send-message-subject-error');
			if(mm == "") showElem('#send-message-msg-error');
		}
		else{
			 $('#send-message-form').submit();
		}
	});
    
	
	//ADD APARTMENT TIP
	$("#aat-form-btn").click(e => {
       e.preventDefault();
	   
	   //validation
	   let title = $('#aat-title').val(), message = $('#aat-message').val(), validation = (message == "");
	        
	        
	   if(validation){
		   Swal.fire({
			 icon: 'error',
             title: "Please fill all required fields."
           })
	   }
	   
	   else{	 
		 $('#aat-form').submit();
	   }   
    });
	
});