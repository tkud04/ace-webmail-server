<?php
$title = $u['fname']." ".$u['lname'];
$subtitle = "View information about this user.";
$pu = url('add-permissions')."?xf=".$u['email'];
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
@include('page-header',['title' => "Users",'subtitle' => $title])
@stop

@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Personal Information</h5>
                                <div class="card-body">
                                    <form action="{{url('user')}}" id="user-form" method="post">
										{!! csrf_field() !!}
										<input type="hidden" name="xf" value="{{$u['id']}}"/>
                                        <div class="row">
										<div class="col-md-6">
										<div class="form-group">
                                            <label for="user-fname">First Name</label>
                                            <input id="user-fname" type="text" name="fname" value="{{$u['fname']}}" placeholder="Enter first name" class="form-control">
                                        </div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
                                            <label for="user-lname">Last Name</label>
                                            <input id="user-lname" type="text" name="lname" value="{{$u['lname']}}" placeholder="Enter last name" class="form-control">
                                        </div>
										</div>
										</div>
										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
                                            <label for="user-email">Email address</label>
                                            <input id="user-email" type="email" name="email" value="{{$u['email']}}" placeholder="Enter email address" class="form-control" readonly>
                                        </div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
                                            <label for="user-phone">Phone number</label>
                                            <input id="user-phone" type="number" name="phone" value="{{$u['phone']}}" placeholder="Enter phone number" class="form-control">
                                        </div>
										</div>
										</div>
										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
                                            <label for="user-role">Role</label>
											<?php
											 $roles = ['user','admin','su'];
											?>
											<select id="user-role" name="role" class="form-control">
											 <option value="none">Select role</option>
											 <?php
											  foreach($roles as $r)
											  {
												  $ss = $r == $u['role'] ? " selected='selected'" : "";
												  $rr = $r == "su" ? "super user" : $r;
											 ?>
											 <option value="{{$r}}"{{$ss}}>{{ucwords($rr)}}</option>
											  <?php
											  }
											  ?>
											</select>
                                        </div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
                                            <label for="user-status">Status</label>
											<?php
											 $statuses = ['enabled','disabled'];
											?>
											<select id="user-status" name="status" class="form-control">
											 <option value="none">Select account status</option>
											 <?php
											  foreach($statuses as $s)
											  {
												  $ss = $s == $u['status'] ? " selected='selected'" : "";
												  $sss = $s == "enabled" ? "active" : $s;
											 ?>
											 <option value="{{$s}}"{{$ss}}>{{ucwords($sss)}}</option>
											  <?php
											  }
											  ?>
											</select>
                                        </div>
										</div>
										</div>
										
                                        <div class="row">
                                            <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                                                <label class="be-checkbox custom-control custom-checkbox">
                                                   <span class="custom-control-label">Last updated: <em>{{$u['updated']}}</em></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-6 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="user-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Permissions</h5>
							<a href="{{$pu}}" class="btn btn-outline-secondary">Add permission</a>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Permission</th>
                                                <th>Granted by</th>
                                                <th>Date granted</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?php
									    if(count($permissions) > 0)
										{
										  foreach($permissions as $p)
										   {
											   $uu = url('remove-permission')."?xf=".$u['id']."&p=".$p['ptag'];
											    $gname = $p['granted_by']->fname." ".$p['granted_by']->lname;
									   ?>
                                            <tr>
                                                <td>{{$p['ptag']}}</td>
                                                <td>{{ucwords($gname)}}</td>
                                                <td>{{$p['date']}}</td>
                                                <td>
												 <a class="btn btn-primary btn-sm" href="{{$uu}}">Remove</a>
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
</div>
<div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="card">
                            <h5 class="card-header">Apartments</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Apartment</th>
                                                <th>Location</th>
                                                <th>Rating</th>
                                                <th>Date added</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?php
									    if(count($apts) > 0)
										{
										  foreach($apts as $a)
										   {
											   $statusClass = "danger";
											   $name = $a['name'];
											   $address = $a['address'];
											   #$reviews = $a['reviews'];
											   $uu = url('apartment')."?xf=".$a['apartment_id'];
											    $sss = $a['status'];
												
												if($a['status'] == "enabled")
												{
													$statusClass = "success";
													$sss = "approved";
												}
											   $imgs = $a['cmedia']['images'];
											   
									   ?>
                                            <tr>
                                                <td>
												  <img class="img-fluid" onclick="window.location='{{$uu}}'" src="{{$imgs[0]}}" alt="{{$name}}" style="cursor: pointer; width: 100px; height: 100px;"/>
												  <a href="{{$uu}}"><h4>{{ucwords($name)}}</h4></a><br>							  
												</td>
                                                <td>{{ucwords($address['address'].",")}}<br>{{ucwords($address['city'].", ".$address['state'])}}</td>
                                                <td>
												@for($i = 0; $i < $a['rating']; $i++)
												  <i class="fas fa-star"></i>
											    @endfor
												&nbsp;({{count($a['reviews'])}} reviews)
												</td>
                                                <td>{{$a['date']}}</td>
                                                <td><span class="label label-{{$statusClass}}">{{strtoupper($sss)}}</td>
                                                <td>
												 <a class="btn btn-primary btn-sm" href="{{$uu}}">View</a>
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
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="card">
                            <h5 class="card-header">Reviews</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Apartment</th>
                                                <th>Rating</th>
                                                <th>Comment</th>
                                                <th>Date Added</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($reviews) > 0)
										   {
											  foreach($reviews as $r)
											   {
												   $a = $r['apartment'];
						     			        $statusClass = "danger";
											   $name = $a['name'];
											   $uu = url('apartment')."?xf=".$a['apartment_id'];
											    $sss = $r['status'];
												
												if($sss == "approved")
												{
													$statusClass = "success";
												}
											   $imgs = $a['cmedia']['images'];

												   
												   $ar = ($r['service'] + $r['location'] + $r['security'] + $r['cleanliness'] + $r['comfort']) / 5;
										  ?>
                                            <tr>
                                               <td>
												  <img class="img-fluid" onclick="window.location='{{$uu}}'" src="{{$imgs[0]}}" alt="{{$name}}" style="cursor: pointer; width: 100px; height: 100px;"/>
												  <a href="{{$uu}}"><h4>{{ucwords($name)}}</h4></a><br>							  
												</td>
												<td>
												  <h3>
												   @for($i = 0; $i < $ar; $i++)
												     <i class="fas fa-star"></i>
											       @endfor
												  </h3>
												  <ul>
												    <li>Service: <b>{{$r['service']}}</b></li>
												    <li>Location: <b>{{$r['location']}}</b></li>
												    <li>Security: <b>{{$r['security']}}</b></li>
												    <li>Cleanliness: <b>{{$r['cleanliness']}}</b></li>
												    <li>Comfort: <b>{{$r['comfort']}}</b></li>
												  </ul>							  
												</td>
                                                <td><em>{{$r['comment']}}</em></td>
                                                <td>{{$r['date']}}</td>
                                                <td><span class="label label-{{$statusClass}}">{{strtoupper($r['status'])}}</td>
                                                
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
                </div>			
@stop
