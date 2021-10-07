<?php
$title = "Plugins";
$subtitle = "View all installed plugins";
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
					<a href="{{url('add-plugin')}}" class="btn btn-outline-secondary">Add plugin</a>
                        <div class="card">
                            <h5 class="card-header">Plugins</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                 <th>Name</th>
                                                 <th>Code snippet</th>
                                                 <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($plugins) > 0)
										   {
											  foreach($plugins as $p)
											   {
												    $name = $p['name'];
							                        $value = $p['value'];
							                        $vu = url('plugin')."?s=".$p['id'];
							                        $ru = url('remove-plugin')."?s=".$p['id'];
							
							                        $ss = $p['status'] == "enabled" ? "bg-primary" : "bg-danger";
										  ?>
                                            <tr>
                                                <td>{{ $name }}</td>
					                            <td><code>{{ $value }}</code></td>
					                            <td>				   
					                             <h3 class="{{$ss}}">{{strtoupper($p['status'])}}</h3>
					                            </td>
					                            <td>
						                          <a class="btn btn-default btn-block btn-clean" href="{{$vu}}">View</a>
						                          <a class="btn btn-default btn-block btn-clean" href="{{$ru}}">Remove</a>
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