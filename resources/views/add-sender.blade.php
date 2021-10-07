<?php
$title = "Add Sender";
$subtitle = "Add SMTP sender.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Add SMTP Sender",'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add SMTP (E-mail) sender</h5>
                                <div class="card-body">
                                    <form action="{{url('add-sender')}}" id="as-form" method="post" enctype="multipart/form-data">
										{!! csrf_field() !!}
										<input type="hidden" id="spp-s" value="show">
										
										<div class="row">
										  <div class="col-md-12">
										  <div class="form-group">
                                            <h4>Full Name</h4>
                                            <input type="text" class="form-control" name="name" id="as-name" placeholder="Sender name e.g Etuk NG" value="Etuk NG" required/>
										  </div>
										</div>
										
										  <div class="col-md-12" id="server-form-row">
				                            <div class="form-group">
  				                            <h4>Choose server:</h4>
											  <select class="form-control" id="server" name="server">
											    <option value="none">Select SMTP server</option>
												<?php
												 $servers = ['gmail' => "Gmail",'yahoo' => "Yahoo mail",'other' => "Other"];
												foreach($servers as $key => $value){
												//$ss = $product['status'] == $key ? " selected='selected'" : "";
												?>
												 <option value="{{$key}}">{{$value}}</option>
												<?php
												}
												?>
											  </select>
											</div>
				                        </div>
										
									      <div class="col-md-12" id="as-other">
										    <div class="form-group">
                                            <h4>SMTP host</h4>
                                            <input type="text" class="form-control" name="ss" id="as-server" placeholder="Server address e.g smtp.gmail.com"/>
											</div>
				                            <div class="form-group">
                                            <h4>SMTP port</h4>
                                            <input type="number" class="form-control" name="sp" id="as-sp" placeholder="Port e.g 587" value="587"/>
											</div>
				                            <div class="form-group">
                                              <h4>SMTP encryption</h4>
		  							          <select class="form-control" name="sec" id="as-sec" style="margin-bottom: 5px;">
		  							          <option value="nonee">Select encryption</option>
		  								      <?php
		  								       $secs = ['tls' => "TLS",'ssl' => "SSL",'none' => "No encryption"];
		  								       foreach($secs as $key => $value){
		  								      ?>
		  								      <option value="{{$key}}">{{$value}}</option>
		  								      <?php
		  								      }
		  								      ?>
		  							          </select>
										    </div>
									      </div>
									    </div>   
										
										<div class="row">
											<div class="col-md-12">
					                            <div class="form-group">
	                                            <h4>Username</h4>
	                                            <input type="text" class="form-control" name="username" id="as-username" placeholder="Login username/email" required/>
												</div>
					                        </div>
											<div class="col-md-12">
					                            <div class="form-group">
	                                            <h4>Password</h4>
												   <div class="row">
												    	<div class="col-md-9">
												          <input type="password" class="form-control" name="password" id="as-password" placeholder="Password" required/>
													    </div>
													    <div class="col-md-3">
														  <button id="spp-show" class="btn btn-space btn-secondary">Show</button>
													    </div>
												    </div>
											   </div>
					                        </div>
										</div>
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="add-sender-submit">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop
