
	let  toolbar = ['title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr', '|', 'indent', 'outdent', 'alignment'];
	let xx = ['#spam-btn','#trash-btn','#unread-btn','#move-btn'];
   
	
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
	hideElem(['#compose-loading','#compose-result']);
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
	
	//MESSAGES
	$("#mm-all").change(e => {
       e.preventDefault();
	   let c = $("#mm-all").is(':checked'), cc;
	   if(c){
		   showElem(xx);
           cc=true;		   
	   }
	   else{ 
		    hideElem(xx);
            cc=false;			
	   }   
	   $('.mm').prop('checked', cc);        
    });
	
	$("#reply-btn, #more-reply").click(e => {
       e.preventDefault();
	   editMode = "reply";
	   
	   $('#edit-menu').removeClass("d-inline-flex");
	   $('#edit-menu').hide();
	   
	  
	   $('#reply-form').addClass("d-inline-flex");
	   showElem(['#reply-form']);	
	   $('#edit-actions').addClass("d-inline-flex");
	   showElem(['#edit-actions']);	
	   scrollTo({id:"#reply-to"});
    });
	
	$("#forward-btn, #more-forward").click(e => {
       e.preventDefault();
	   editMode = "forward";
	   
	   $('#edit-menu').removeClass("d-inline-flex");
	   $('#edit-menu').hide();
	   
	   
	   $('#forward-form').addClass("d-inline-flex");
	   showElem(['#forward-form']);	
	   $('#edit-actions').addClass("d-inline-flex");
	   showElem(['#edit-actions']);	
	   scrollTo({id:"#forward-to"});
    });
	
	$("#discard-btn").click(e => {
       e.preventDefault();
	   
	   $(`#${editMode}-form`).removeClass("d-inline-flex");
	   hideElem([`#${editMode}-form`]);	
	   $('#edit-actions').removeClass("d-inline-flex");
	   hideElem(['#edit-actions']);	
	   editMode = "";
	   $('#edit-menu').addClass("d-inline-flex");
	   showElem(['#edit-menu']);
    });
	
	$("#submit-btn").click(e => {
       e.preventDefault();

	   let u = $('#u').val(), m = $('#m').val(), t = $(`#${editMode}-to`).val(), c = $(`#${editMode}-box`).val();
	   
	   
	   $('#edit-actions').removeClass("d-inline-flex");
	   hideElem(['#edit-actions']);	
	   showElem(['#edit-loading']);
	        let fd = new FormData();
	       fd.append("u",u);
	       fd.append("tk","kt");
	       fd.append("m",m);
	       fd.append("xf",editMode);
	       fd.append("c",c);
	
	   if(editMode == "reply"){
	      reply(fd);
       }
       
       else if(editMode == "forward"){
	      fd.append("t",t);
	      fwd(fd);
       }
		 
		 
    });
	
	$(".inbox-all-btn").click(e => {
       e.preventDefault();

	   let ret = [];
	   $(`.mm`).each((index, obj) => {
        if (obj.checked === true) {
            ret.push(obj.getAttribute('data-xf'));
        }
    });
	  moveToInbox(ret);
		 
    });
	
	$(".spam-all-btn").click(e => {
       e.preventDefault();

	   let ret = [];
	   $(`.mm`).each((index, obj) => {
        if (obj.checked === true) {
            ret.push(obj.getAttribute('data-xf'));
        }
    });
	  markSpam(ret);
		 
    });
	
	$("#trash-all-btn").click(e => {
       e.preventDefault();

	   let ret = [];
	   $(`.mm`).each((index, obj) => {
        if (obj.checked === true) {
            ret.push(obj.getAttribute('data-xf'));
        }
    });
	  trash(ret);
		 
    });
	
	$("#delete-all-btn").click(e => {
       e.preventDefault();

	   let ret = [];
	   $(`.mm`).each((index, obj) => {
        if (obj.checked === true) {
            ret.push(obj.getAttribute('data-xf'));
        }
    });
	  deleteMessage(ret);
		 
    });
	
	$("#unread-all-btn").click(e => {
       e.preventDefault();

	   let ret = [];
	   $(`.mm`).each((index, obj) => {
        if (obj.checked === true) {
            ret.push(obj.getAttribute('data-xf'));
        }
    });
	  trash(ret);
		 
    });
	
	
	
});
