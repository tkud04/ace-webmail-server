<?php
$title = "Users";
$subtitle = "View all users registered on the platform";
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
@include('page-header',['title' => $title,'subtitle' => $subtitle])
@stop

@section('content')
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Users</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Date Joined</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($users) > 0)
										   {
											  foreach($users as $u)
											   {
												   $vu = url('user')."?xf=".$u['email'];
												   $statusClass = "danger";
												   $type = "enable";
												   $duText = "Enable user";
												   $duClass = "success";
												   
												   if($u['status'] == "enabled")
												   {
													   $statusClass = "success";
													   $type = "disable";
													   $duText = "Disable user";
												       $duClass = "danger";
												   }
												   $du = url('edu')."?xf=".$u['id']."&type=".$type;
												   
										  ?>
                                            <tr>
                                                <td>{{ucwords($u['fname']." ".$u['lname'])}}</td>
                                                <td>{{$u['email']}}</td>
                                                <td>{{ucwords($u['role'])}}</td>
                                                <td>{{$u['date']}}</td>
                                                <td><span class="label label-{{$statusClass}}">{{strtoupper($u['status'])}}</td>
                                                <td>
												 <a class="btn btn-primary btn-sm" href="{{$vu}}">View</a>
												 <a class="btn btn-{{$duClass}} btn-sm" href="{{$du}}">{{$duText}}</a>
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
@stop