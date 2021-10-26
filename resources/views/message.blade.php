<?php
$void = "javascript:void(0)";
$xf = $m['id'];
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => $title,'subtitle' => $subtitle])
@stop

@section('content')
<script>
$(document).ready(() => {
	$('#reply-form').removeClass("d-inline-flex");
	$('#reply-form').hide();
	$('#edit-loading').hide();
	$('#forward-form').removeClass("d-inline-flex");
	$('#forward-form').hide();
	$('#edit-actions').removeClass("d-inline-flex");
	$('#edit-actions').hide();
	 $('#reply-to').flexselect();
	 $('#forward-to').flexselect();
});

</script>
<input type="hidden" id="u" value="{{$user->username}}">
<input type="hidden" id="m" value="{{$xf}}">
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
							 <div class="row">
							    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							 <ul class="list-inline">
							  <li class="list-inline-item"><a id="spam-btn" href="{{url($m['label'])}}" class="btn" title="Back"><i class="fa fa-fw fa-arrow-circle-left menu-icon"></i></a></li>
							  
							   <li class="list-inline-item"><a id="spam-btn" href="{{$void}}" class="btn" title="Mark as Spam" onclick="markSpam({{$xf}})"><i class="fa fa-fw fa-exclamation-triangle menu-icon"></i></a></li>
							 
							   @if($m['label'] != "trash")
							 <li class="list-inline-item"><a id="trash-btn" href="{{$void}}" class="btn" title="Delete forever" onclick="trash({{$xf}})"><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							   @else
 							<li class="list-inline-item"><a id="trash-btn" href="{{$void}}" class="btn" title="Move to trash" onclick="deleteMessage({{$xf}})"><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							   @endif
							<li class="list-inline-item">|</li>
							 <li class="list-inline-item"><a id="unread-btn" href="{{$void}}" class="btn" title="Mark as Unread" onclick="markUnread({{$xf}})"><i class="fa fa-fw fa-envelope menu-icon"></i></a></li>
							  <li class="list-inline-item">
								<div class="dropdown">
                                <a id="move-btn" href="{{$void}}" class="btn dropdown-toggle" title="Move to" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-folder-open menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
								    @if($m['label'] == "inbox")
                                    <a class="dropdown-item" href="{{$void}}" onclick="markSpam({{$xf}})">Spam</a>
								    @elseif($m['label'] == "spam")
                                    <a class="dropdown-item" href="{{$void}}" onclick="moveToInbox({{$xf}})">Inbox</a>
									@endif
                                  </div>
                                </div>
							  </li>
							  <li class="list-inline-item">
								<div class="dropdown">
                                <a id="more-btn" href="{{$void}}" class="btn dropdown-toggle" title="More" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-ellipsis-v menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
                                    <a class="dropdown-item" href="{{$void}}">Action</a>
                                    <a class="dropdown-item" href="{{$void}}">Another action</a>
                                    <a class="dropdown-item" href="{{$void}}">Something else here</a>
                                  </div>
                                </div>
								</li>
							  
							 </ul>  
							</div>	  
							</div>	  
								  
							
							</div>
                            <div class="card-body" style="overflow-y:scroll;">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
									  <div class="d-flex justify-content-between">
										  <div class="d-inline-flex">
										    <div class="mr-2"> <i class="fa fa-2x fa-fw fa-user-circle"></i></div>
										    <div class="d-inline-flex">
											    <div><span class="text-bold mr-2">{{$m['sn']}} </span></div>
												 <div>{{"<".$m['sa'].">"}}</div>
											</div>
										  </div>
									    <div class="align-self-end">
									    <div class="d-inline-flex">
										  <div><span class="text-bold justify-content-center">{{$m['date']}}</span></div>
										   <div><a href="{{$void}}" class="btn" title="Mark as Unread" onclick="reply({{$xf}})"><i class="fa fa-fw fa-envelope menu-icon"></i></a></div>
								<div class="dropdown">
                                <a id="more-btn" href="{{$void}}" class="btn dropdown-toggle" title="More" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								   <i class="fa fa-fw fa-ellipsis-v menu-icon"></i>
								 </a>
                                  <div class="dropdown-menu" aria-labelledby="more-btn">
                                    <a id="more-reply" class="dropdown-item" href="{{$void}}">Reply</a>
                                    <a id="more-forward" class="dropdown-item" href="{{$void}}">Forward</a>
                                    <a id="more-mark-unread" class="dropdown-item" href="{{$void}}">Mark as unread</a>
                                    <a id="more-mark-spam" class="dropdown-item" href="{{$void}}">Mark as spam</a>
                                    <a id="more-delete" class="dropdown-item" href="{{$void}}">Delete</a>
                                  </div>
                                </div>
                                </div>
                                </div>
									  </div><hr>
									</div>
                                    
                                    <div class="col-md-12">
									
									<div class="mb-5">
									{!! $m['content'] !!}
									</div>
									<div class="mb-3">
									<?php
									  $atts = $m['attachments'];
									  if(count($atts) > 0)
									  {
										  foreach($atts as $a)
										  {
										    $du = url('dl')."?xf=".$a['id']."&uid=".rand(10000,1244567997);
											$as = $a['size']; $asd = $as; $asd2 = " bytes";
											if($as >= 999999)
											{
												$asd = $as / 1000000; $asd2 = " MB";
											}
											elseif($as >= 999 && $as <= 999999)
											{
												$asd = $as / 1000; $asd2 = " KB";
											}
									?>
									  <div id="att-{{$xf}}-div" class="inline-flex">
									  <a id="att-{{$xf}}" href="{{$du}}" target="_blank"><i class="fa fa-fw fa-paperclip"></i> {{$a['filename']}} - {{$asd.$asd2}}</a>
									  </div>
									<?php
									      }
									  }
									?>
									</div>
									<center>
									<div class="d-inline-flex" id="edit-menu">
									   <a id="reply-btn" class="btn btn-outline-primary" href="{{$void}}"><i class="fa fa-fw fa-reply"></i> Reply</a>
									   <a id="forward-btn" class="btn btn-outline-primary" href="{{$void}}"><i class="fa fa-fw fa-forward"></i> Forward</a>
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
									  <input class="form-control" id="forward-to" placeholder="Recipient">
									  <textarea class="form-control mb-2" name="forward" id="forward-box" rows="15" cols="50" placeholder="Content (optional)"></textarea>
									</div>
									</div>
									<div id="edit-actions">
									   <a id="submit-btn" class="btn btn-outline-primary" href="{{$void}}"><i class="fa fa-fw fa-rocket"></i> Submit</a>
									   <a id="discard-btn" class="btn btn-outline-danger" href="{{$void}}"><i class="fa fa-fw fa-trash"></i> Discard</a>
									</div>
									<h4 id="edit-loading">Sending.. <img src="{{asset('images/loading.gif')}}" class="img img-fluid" alt="Sending.."></h4>
									</center>
									
							        </div>
							    </div>
							 </div>
						</div>
                    </div>
                </div>			
@stop