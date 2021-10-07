<?php
$title = "Senders";
$subtitle = "View all registered plugins";
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
					<a href="{{url('add-sender')}}" class="btn btn-outline-secondary">Add sender</a>
                        <div class="card">
                            <h5 class="card-header">Senders</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
			                                     <th>Host</th>
			                                     <th>Login</th>
			                                     <th>Current sender</th>
                                            </tr>
                                        </thead>
                                        <tbody>
					  							  <?php
							  
					  					  if(count($senders) > 0)
					  					  {
					  						 foreach($senders as $s)
					  						 {
					  							 $ss = $s['ss'];
					  							$su = $s['su'];
					  							$vu = url('sender')."?s=".$s['id'];
					  							$ru = url('remove-sender')."?s=".$s['id'];
					  							$mu = url('mark-sender')."?s=".$s['id'];
							 
							
					  				    ?>
					                        <tr>
					   
					  					   <td>{!! $ss !!}</td>
					  					  <td>{!! $su !!}</td>
					  					  <td>
					  					   @if($s['current'] == "yes")
					  					    <h3 class="badge badge-info">CURRENT</h3>
					  					   @else
					  						 <a class="btn btn-outline-secondary" href="{{$mu}}">Set as current</a>
					  				       @endif
					  					  </td>
					  					   <td>
					  						<a class="btn btn-outline-secondary" href="{{$vu}}">View</a>
					  						<a class="btn btn-outline-secondary" href="{{$ru}}">Remove</a>
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
