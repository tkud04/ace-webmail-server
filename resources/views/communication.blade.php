<?php
$title = "Communication";
$subtitle = "View contact information and send messages to all users";

$gc = $dt['guests'];
$hc = $dt['hosts'];
#$hs = [];
?>

@extends('layout')

@section('title',$title)

@section('scripts')
  <!-- DataTables CSS -->
  <link href="{{asset('lib/datatables/css/buttons.bootstrap.min.css')}}" rel="stylesheet" /> 
  <link href="{{asset('lib/datatables/css/buttons.dataTables.min.css')}}" rel="stylesheet" /> 
  <link href="{{asset('lib/datatables/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" /> 
  
      <!-- DataTables js -->
       <script src="{{asset('lib/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/datatables-init.js')}}"></script>
@stop

@section('page-header')
@include('page-header',['title' => $title." - ".$subtitle,'subtitle' => $subtitle])
@stop

@section('content')
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">
							Guests 
							<a href="javascript:void(0)" onclick="copyData({type:'ge'})"  data-toggle="modal" data-target="#copyDataModal" class="btn btn-outline-secondary">Copy all email addresses</a>
							<a href="javascript:void(0)" onclick="copyData({type: 'gp'})" data-toggle="modal" data-target="#copyDataModal" class="btn btn-outline-secondary">Copy all phone numbers</a>
							</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Contact Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?php
									   if(count($gc) > 0)
									   {
										for($d = 0; $d < count($gc); $d++)
										{
											$g = $gc[$d];
											$gid = $g['id'];
											$gn = $g['fname']." ".$g['lname'];
											$ll = ""; $sm = " class='text-muted'"; $tc = "";
											
											if($d == 0)
											{
												$ll = " active";
											    $sm = "";
											}
		
										  #$vu = url('transaction')."?xf=".$t['id'];
										  
												
									   ?>
                                            <tr>
                                                <td>
												 {{$gn}} 
												</td>
                                                <td>
												 <div class="d-flex w-100 ">
											       <div>
                                                    <h5 class="mb-1 success">Phone number: <span class="gp">{{$g['phone']}}</span></h5>
                                                    <h5 class="mb-1 info">Email address: <span class="ge">{{$g['email']}}</span></h5>
                                                   </div>
                                                 </div>
												</td>
                                                <td>
												  <a href="javascript:void(0)" onclick="addXF({type: 'send-message', name: '{{$gn}}', xf:'{{$gid}}'})" class="btn btn-primary" data-toggle="modal" data-target="#sendMessageModal">Send a message</a>
												</td>
                                            </tr>
									     <?php
											   }
										   }
										 ?>
									   </tbody>
									</table>
							    </div>
							 </div>
						</div>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">
							Guests 
							<a href="javascript:void(0)" onclick="copyData({type:'he'})"  data-toggle="modal" data-target="#copyDataModal" class="btn btn-outline-secondary">Copy all email addresses</a>
							<a href="javascript:void(0)" onclick="copyData({type: 'hp'})" data-toggle="modal" data-target="#copyDataModal" class="btn btn-outline-secondary">Copy all phone numbers</a>
							</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Contact Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?php
									   if(count($hc) > 0)
									   {
										for($d = 0; $d < count($hc); $d++)
										{
											$h = $hc[$d];
											$hid = $h['id'];
											$hn = $h['fname']." ".$h['lname'];
											$ll = ""; $sm = " class='text-muted'"; $tc = "";
											
											if($d == 0)
											{
												$ll = " active";
											    $sm = "";
											}
		
										 # $vu = url('transaction')."?xf=".$t['id'];
										  
												
									   ?>
                                            <tr>
                                                <td>
												 {{$h['fname']." ".$h['lname']}} 
												</td>
                                                <td>
												 <div class="d-flex w-100 ">
											       <div>
                                                    <h5 class="mb-1 success">Phone number: <span class="hp">{{$h['phone']}}</span></h5>
                                                    <h5 class="mb-1 info">Email address: <span class="he">{{$h['email']}}</span></h5>
                                                   </div>
                                                 </div>
												</td>
                                                <td>
												  <a href="javascript:void(0)" onclick="addXF({type: 'send-message', name: '{{$hn}}', xf:'{{$hid}}'})" class="btn btn-primary" data-toggle="modal" data-target="#sendMessageModal">Send a message</a>
												</td>
                                            </tr>
									     <?php
											   }
										   }
										 ?>
									   </tbody>
									</table>
							    </div>
							 </div>
						</div>
                    </div>
					
					 <!-- Button trigger modal -->
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="sendMessageModalLabel">Send Message to <span id="send-message-name"></span></h5>
                                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </a>
                                                            </div>
                                                            <div class="modal-body">
                                                               <form id="send-message-form" action="{{url('send-message')}}" method="post">
								                                {!! csrf_field() !!}
																<input type="hidden" name="xf" id="send-message-xf" value="">
																<div class="row">
									                            	<div class="col-md-12">
										                              <div class="form-group">
																	    <label>Type</label>
																		<select class="form-control" name="type" id="send-message-type">
												                          <option value="none">Select message type</option>
												                          <option value="sms">SMS</option>
												                          <option value="email">Email</option>
												                         </select>
																		 <span class="text-danger text-bold input-error" id="send-message-type-error">This field is required</span>						  
																	  </div>
																	  <div class="form-group" id="send-message-email-div">
																	    <label>Subject</label>
																		<input type="text" class="form-control" name="subject" id="send-message-subject" placeholder="Subject">	
																		 <span class="text-danger text-bold input-error" id="send-message-subject-error">This field is required</span>
																	  </div>
																	  <div class="form-group">
																	    <label>Message</label>
																		<textarea rows="10" class="form-control" name="message" id="send-message-msg" placeholder="Your message"></textarea>	
																		 <span class="text-danger text-bold input-error" id="send-message-msg-error">This field is required</span>
																	  </div>
																	</div>
                                                                 </div>																	
															   </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:void(0)" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                                                                <a href="javascript:void(0)" id="send-message-submit" class="btn btn-primary">Submit</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
				</div>
				<!-- Modal -->	
				<!-- Button trigger modal -->
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="modal fade" id="copyDataModal" tabindex="-1" role="dialog" aria-labelledby="copyDataModalLabel" aria-hidden="true" style="display: none;">
                                                         <div class="modal-dialog" role="document">
                                                           <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="copyDataModalLabel">Copy <span id="copy-data-name"></span></h5>
                                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </a>
                                                            </div>
                                                            <div class="modal-body">
                                                               <form>
																	  <div class="form-group">
																	    <label>Message</label>
																		<textarea rows="10" class="form-control" name="message" id="copy-data-msg" readonly></textarea>	
																	   </div>
                                                                </form>
															</div>
															<div class="modal-footer">
                                                                <a href="javascript:void(0)" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                                                            </div>  
                                                            </div>
                                                          </div>
                                                        </div>
				</div>
				<!-- Modal -->	
					
                </div>
@stop