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
                            <div class="card-body" style="overflow-y:scroll;">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
									  <div class="d-flex">
										  <div class="d-inline-flex">
										    <div class="mr-2"> <span class="text-gray">To</span></div>
										    <div class="d-inline-flex" id="to-list">
											    <div class="to-item d-inline-flex">
												  <span class="text-bold mr-2">{{$m['sn']}} </span>
												  <a href="javascript:void(0)" class="to-item-remove"></a>
												</div>
											</div>
										  </div>
									  </div><hr>
									</div>
                                    
                                    <div class="col-md-12">
									<center>
									<div class="mb-5">
									{!! $m['content'] !!}
									</div>
									<div class="d-inline-flex" id="edit-menu">
									   <a id="reply-btn" class="btn btn-outline-primary" href="javascript:void(0)"><i class="fa fa-fw fa-reply"></i> Reply</a>
									   <a id="forward-btn" class="btn btn-outline-primary" href="javascript:void(0)"><i class="fa fa-fw fa-forward"></i> Forward</a>
									</div>
									<div class="d-inline-flex" id="reply-form">
									<div><i class="fa fa-2x fa-fw fa-user-circle"></i></div>
									<div>
									 
									 <textarea class="form-control" name="reply" id="reply-box" rows="15" cols="50" placeholder="Content"></textarea>
									</div>
									</div>
									<div class="d-inline-flex" id="forward-form">
									<div><i class="fa fa-2x fa-fw fa-user-circle"></i></div>
									<div>
									  <select class="form-control" id="forward-to">
                                                <option value="none">Recipient</option>
                                                   @foreach($contacts as $c)
                                                           <option value="{{$c}}">{{$c}}</option>
                                                   @endforeach
									 </select>
									  <textarea class="form-control mb-2" name="forward" id="forward-box" rows="15" cols="50" placeholder="Content (optional)"></textarea>
									</div>
									</div>
									<div class="d-inline-flex" id="edit-actions">
									   <a id="submit-btn" class="btn btn-outline-primary" href="javascript:void(0)"><i class="fa fa-fw fa-rocket"></i> Submit</a>
									   <a id="discard-btn" class="btn btn-outline-danger" href="javascript:void(0)"><i class="fa fa-fw fa-trash"></i> Discard</a>
									</div>
									<h4 id="edit-loading">Sending.. <img src="{{asset('images/loading.gif')}}" class="img img-fluid" alt="Sending.."></h4>
									</center>
									
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
composeModal.addFooterBtn('Button label', 'tingle-btn tingle-btn--primary', function() {
    // here goes some logic
    composeModal.close();
});

// add another button
composeModal.addFooterBtn('Dangerous action !', 'tingle-btn tingle-btn--danger', function() {
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