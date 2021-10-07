<?php
$title = "Reviews";
$subtitle = "View all user reviews";
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
                                                <th>Actions</th>
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
												$arrClass = "success";
												$arrText = "Approve";
;
											   $name = $a['name'];
											   $uu = url('apartment')."?xf=".$a['apartment_id'];
											    $sss = $r['status'];
												
												if($sss == "approved")
												{
													$statusClass = "success";
													$arrClass = "warning";
													$arrText = "Reject";
												}
											   $imgs = $a['cmedia']['images'];

												   $arr = url('arr')."?xf=".$r['id']."&type=".strtolower($arrText);
												   $dr = url('dr')."?xf=".$r['id'];
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
                                                <td>
												 <a class="btn btn-{{$arrClass}} btn-sm" href="{{$arr}}">{{$arrText}}</a>
												 <a class="btn btn-danger btn-sm" href="{{$dr}}">Remove</a>
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