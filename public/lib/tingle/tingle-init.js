// Compose modal
let composeModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'button', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2'],
    onOpen: function() {
        console.log('modal open');
    },
    onClose: function() {
        console.log('modal closed');
    },
    beforeClose: function() {
        // here's goes some logic
        // e.g. save content before closing the modal
        return true; // close the modal
        return false; // nothing happens
    }
});

let ccc = `
              <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card ">
	                          <h3 class="card-header bg-dark text-white">New Message</h3>
                            <div class="card-body" style="">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
									  <div class="d-flex">
										  <div class="d-inline-flex">
										    <div class="mr-2"> <span class="text-gray">To</span></div>
										    <div class="d-inline-flex" id="to-list">    
												<div class="d-inline-flex" id="rdiv">
												  <input type="text" id="to-input" class="compose-input" oninput="addToItem('to',event)"> 
												</div>
											</div>
											
										  </div>
									  </div><hr>
									</div>
									<div class="col-md-12 mb-3">
									  <div class="d-flex">
										  <div class="d-inline-flex">
										    <div class="mr-2"> <span class="text-gray">Cc</span></div>
										       <div id="ccdiv">
												  <input type="text" id="cc-input" class="compose-input" oninput="addToItem('cc',event)">
												</div>
										  </div>
									  </div><hr>
									</div>
									<div class="col-md-12 mb-3">
									  <div class="d-flex"  style="width: 100%;">
										  <div class="d-inline-flex">
												<div class="d-inline-flex">
												  <input type="text" id="subject-input" placeholder="Subject" class="compose-input" >
												</div>
											<div class="mr-2"><a href="javascript:void(0)" onclick="addAttachment()"><i class="fa fa-fw fa-paperclip"></i></a></div>
										  </div>
									  </div><hr>
									</div>
									<div class="col-md-12 mb-3">
									  <div class="d-flex">
										  <textarea class="compose-input" id="msg-input"></textarea>
									  </div><hr>
									</div>
                                    <div class="col-md-12 mb-3">
									  <div class="d-flex">
										  <div class="d-inline-flex">
										    <div class="mr-2"> <span class="text-gray">Extra</span></div>
										    <div class="d-inline-flex">
											    
												<div class="d-inline-flex">
												  <input type="text" id="" class="compose-input">
												</div>
											</div>
										  </div>
									  </div><hr>
									</div>
									<div class="col-md-12 mb-3">
									  <div class="d-flex">
										  <p class="text-bold text-primary" id="compose-result">Message sent! </p>
										  <p class="text-bold" id="compose-loading">Sending <img src="images/loading.gif" alt="Sending.." style="width: 40px; height: 40px;"></p>
									  </div><hr>
									</div>
                                    
                                   
							    </div>
							 </div>
						</div>
                    </div>
                </div>				
`;
// set content
composeModal.setContent(ccc);

// add a button
composeModal.addFooterBtn('Send', 'tingle-btn tingle-btn--primary', function() {
    // here goes some logic
   // composeModal.close();
   
   let fd = new FormData();
   fd.append('tk',"kt");
   fd.append('t',JSON.stringify(to));
   fd.append('s',$('#subject-input').val());
   fd.append('c',$('#msg-input').val());
   showElem('#compose-loading');
   fetch("gu").then((r)=>{r.text()
       .then((d)=>{
	   fd.append('u',d);
	      sendMessage(fd,composeModal);
	   });
	});

});

// add another button
composeModal.addFooterBtn('Close', 'tingle-btn tingle-btn--danger', function() {
    // here goes some logic
    composeModal.close();
});

$(document).ready(() => {
let btn = document.querySelector('#compose-btn');
        btn.addEventListener('click', function () {
            composeModal.open();
        });
});


// close modal
//modal.close();
