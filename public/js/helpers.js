let  editMode = "", to = [], cc = [], bcc = [], mmsg = ``, attachments = [],
 sigs = [], sig = ``, sigQuill = null;

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



const checkForMessages = () => {
	console.log("checking for new messages..");
}


const scrollTo = dt => {
	document.querySelector(`${dt.id}`).scrollIntoView({
          behavior: 'smooth' 
        });
}


const addToItem = (dest,dt) => {
	 //console.log("dt: ",dt);
	let str = dt.target.value;
	 if(str.substr(-1) == ' '){
		 let em = $(`#${dest}-input`).val(), ii = ``,oc=``,bdiv=``;
		 
		 if(em.length > 0){
			 if(dest == 'to'){
				 ii = `to-${to.length}`;
				 oc = `removeToItem('${ii}')`;
				 bdiv  = `#rdiv`;
				 to.push({id: ii,em: em});
			 }
			 else if(dest == 'cc'){
				 ii = `cc-${cc.length}`;
				 oc = `removeCcItem('${ii}')`;
				 bdiv  = `#ccdiv`;
				 cc.push({id: ii,em: em});
			 }
			 else if(dest == 'bcc'){
				 ii = `bcc-${bcc.length}`;
				 oc = `removeBccItem('${ii}')`;
				 bdiv  = `#bccdiv`;
				 bcc.push({id: ii,em: em});
			 }
		  
		 let hh = `
<div class="to-item d-inline-flex" id="${ii}">
	<span class="text-bold mr-2">${em}</span>
	<a href="javascript:void(0)" onclick="${oc}" class="to-item-remove"></a>
</div>		 
		 `;
		 $(hh).insertBefore(bdiv);
		 $(`#${dest}-input`).val("");
		 }
	 }
}

const removeToItem = (dt) => {
	let ret = [];
	for(let i = 0; i  < to.length; i++){
		let item = to[i];
		if(item.id != dt) ret.push(item);
	}
	to = ret;
	document.querySelector(`#${dt}`).remove();
}

const removeCcItem = (dt) => {
	let ret = [];
	for(let i = 0; i  < cc.length; i++){
		let item = cc[i];
		if(item.id != dt) ret.push(item);
	}
	cc = ret;
	document.querySelector(`#${dt}`).remove();
}

const removeBccItem = (dt) => {
	let ret = [];
	for(let i = 0; i  < bcc.length; i++){
		let item = bcc[i];
		if(item.id != dt) ret.push(item);
	}
	bcc = ret;
	document.querySelector(`#${dt}`).remove();
}

const addAttachment = () => {
	 //console.log("dt: ",dt);
	let xx = `att-${attachments.length}`;

		 let hh = `
		 <div class="d-inline-flex" id="${xx}-div">
		   <input type="file" id="${xx}">
		   <a class="ml-2" href="javascript:void(0)" onclick="removeAttachment('${xx}')"><i class="fa fa-fw fa-trash"></i></a>
		 </div>
		   `;
		 adiv  = `#adiv`;
		 $(hh).insertBefore(adiv);
		 attachments.push({id: xx});
}

const removeAttachment = (dt) => {
	let ret = [];
	for(let i = 0; i < attachments.length; i++){
		let a = attachments[i];
		if(a.id != dt) ret.push(a);
	}
	attachments = ret;
	document.querySelector(`#${dt}-div`).remove();
}

const fwd = dt => {
	 
	//create request
	let url = "api/message";
	const req = new Request(url,{method: 'POST', body: dt});
	
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
		    alert("Failed to forward message: " + error);			
			hideElem('#edit-loading');
		    $(`#edit-actions`).removeClass("d-inline-flex");
	        showElem([`#edit-actions`]);	
	   })
	   .then(res => {
		   console.log(res);
			 hideElem(['#rp-loading','#rp-submit']); 
             	 
		   if(res.status == "ok"){
               $('#edit-loading').hide();
               $('#edit-actions').addClass("d-inline-flex");
	          showElem(['#edit-actions']);	
              alert("Message sent!");
              window.location = "inbox";			   
		   }
		   else if(res.status == "error"){
			   console.log(res.message);
			 if(res.message == "validation" || res.message == "dt-validation"){
				 $('#rp-finish').html(`<p class='text-primary'>Please enter a valid email address.</p>`);
				 showElem(['#rp-finish','#rp-submit']);
			 }
			 else{
			   alert("Failed to forward message: " + error);			
			hideElem('#edit-loading');
		    $(`#edit-actions`).removeClass("d-inline-flex");
	        showElem([`#edit-actions`]);		 
			 }					 
		   }
		   		     
	   }).catch(error => {
		    alert("Failed to forward message: " + error);			
			hideElem('#edit-loading');
		    $(`#edit-actions`).removeClass("d-inline-flex");
	        hideElem([`#edit-actions`]);		
	   });
}

const reply = dt => {
	 
	//create request
	let url = "api/message";
	const req = new Request(url,{method: 'POST', body: dt});
	
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
		    alert("Failed to send reply: " + error);			
			hideElem('#edit-loading');
		    $(`#edit-actions`).removeClass("d-inline-flex");
	        showElem([`#edit-actions`]);	
	   })
	   .then(res => {
		   console.log(res);
			 hideElem(['#rp-loading','#rp-submit']); 
             	 
		   if(res.status == "ok"){
               $('#edit-loading').hide();
               $('#edit-actions').addClass("d-inline-flex");
	          showElem(['#edit-actions']);	
              alert("Message sent!");
              window.location = "inbox";			   
		   }
		   else if(res.status == "error"){
			   console.log(res.message);
			 if(res.message == "validation" || res.message == "dt-validation"){
				 $('#rp-finish').html(`<p class='text-primary'>Please enter a valid email address.</p>`);
				 showElem(['#rp-finish','#rp-submit']);
			 }
			 else{
			   alert("Failed to send reply: " + error);			
			hideElem('#edit-loading');
		    $(`#edit-actions`).removeClass("d-inline-flex");
	        showElem([`#edit-actions`]);		 
			 }					 
		   }
		   		     
	   }).catch(error => {
		    alert("Failed to send reply: " + error);			
			hideElem('#edit-loading');
		    $(`#edit-actions`).removeClass("d-inline-flex");
	        hideElem([`#edit-actions`]);		
	   });
}

const sendMessage = (dt,mm) => {
	 
	//create request
	let url = "api/new-message";
	const req = new Request(url,{method: 'POST', body: dt});
	
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
		    alert("Failed to send message: " + error);			
			hideElem('#compose-loading');
		    showElem([`#compose-result`]);	
	   })
	   .then(res => {
		   console.log(res);
			 hideElem(['#compose-loading']); 
             	 
		   if(res.status == "ok"){
			   $('#subject-input').val("");
			   $('#msg-input').val("");
			   $('#subject-input').val("");
			   hideElem(['#compose-result']);
              for(let i = 0; i < to.length; i++) removeToItem(to[i].id);
               alert("Message sent!");			  
               mm.close();
		   }
		   else if(res.status == "error"){
			   console.log(res.message);
			 if(res.message == "validation" || res.message == "dt-validation"){
				 
			 }
			 else{
			   alert("Failed to send message: " + error);			
			//hideElem('#compose-loading');
		    //showElem([`#compose-actions`]);		 
			 }					 
		   }
		   		     
	   }).catch(error => {
		    alert("Failed to send reply: " + error);			
			//showElem([`#compose-actions`]);		 
	   });
}

const extractMessage = (dt,t) => {
	 console.log("dt: ",dt);
	 let ret = ``, ops = dt.ops;
	 
	 for(let i = 0; i < ops.length; i++){
		 let op = ops[i], a = op.attributes || {},line = `
		  ${a.link ? `<a href="${a.link}">` : ''} ${a.bold ? `<b>` : ''} ${a.italic ? `<i>` : ''} ${op.insert} ${a.italic ? `</i>` : ''} ${a.bold ? `</b>` : ''} ${a.link ? `</a>` : ''}
		 `;
	     //for (const property in op) {
           //console.log(`${property}: ${op[property]}`);
         //}
		 ret += line;
	 }
	  //console.log("ret: ",ret);
	  if(t == "compose") mmsg = ret;
	  else if(t == "sig") sig = ret;
	  return ret;
}

const sigg = () => {
   let xf = $('#sig').val(), ddd = null, dd = ``;
   if(xf != "none"){	   
	   ddd = ssigs.find(i => i.id == xf);
	   if(ddd) dd = `${ddd.value} <a href="api/remove-sig?tk=kt&xf=${xf}" class="btn btn-danger ml-2"><i class="fa fa-fw fa-trash"></i></a>`;
   }
   $('#sig-alert').html(dd);
}

const isMessageSelected = c => {
    ret = false;

    $(`.${c}`).each((index, obj) => {
		//console.log('[index, obj]: ',[index, obj]);
        if (obj.checked === true) {
            ret = true;
        }
    });
    return ret;
};

const moveToInbox = (dt) => {
	let msgs = [];
	
	if(Array.isArray(dt)){
	  msgs = dt;
	}
	else{
		msgs.push(dt);
	}
	
	let uu = `api/move-message?tk=kt&l=inbox&dt=${JSON.stringify(msgs)}`;
     //console.log('uu: ',uu);
	 window.location = uu;
}

const markSpam = (dt) => {
	let msgs = [];
	
	if(Array.isArray(dt)){
	  msgs = dt;
	}
	else{
		msgs.push(dt);
	}
	
	let uu = `api/move-message?tk=kt&l=spam&dt=${JSON.stringify(msgs)}`;
     //console.log('uu: ',uu);
	 window.location = uu;
}

const trash = (dt) => {
	let msgs = [];
	
	if(Array.isArray(dt)){
	  msgs = dt;
	}
	else{
		msgs.push(dt);
	}
	
	let uu = `api/move-message?tk=kt&l=trash&dt=${JSON.stringify(msgs)}`;
     //console.log('uu: ',uu);
	 window.location = uu;
}

const deleteMessage = (dt) => {
	let msgs = [], u = $('#u').val();
	
	if(Array.isArray(dt)){
	  msgs = dt;
	}
	else{
		msgs.push(dt);
	}
	
	let uu = `api/delete-message?tk=kt&u=${u}&dt=${JSON.stringify(msgs)}`;
     //console.log('uu: ',uu);
	 window.location = uu;
}

const markUnread = (dt) => {
	let msgs = [];
	
	if(Array.isArray(dt)){
	  msgs = dt;
	}
	else{
		msgs.push(dt);
	}
	
	let uu = `api/mark-unread?tk=kt&dt=${JSON.stringify(msgs)}`;
     //console.log('uu: ',uu);
	 window.location = uu;
}

