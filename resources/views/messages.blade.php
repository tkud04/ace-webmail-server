<?php
$void = "javascript:void(0)";
?>

@extends('layout')

@section('title',$title)

@section('scripts')
  <!-- DataTables CSS -->
    <link href="{{asset('lib/datatables/css/datatables.min.css')}}" rel="stylesheet" /> 
	
	<!-- DataTables js -->
	<script src="{{asset('lib/datatables/js/datatables.min.js')}}"></script>
	 <script src="{{asset('lib/datatables/js/datatables-init.js')}}"></script>
  @stop
  
  @section('scriptss')
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
   
@stop

@section('page-header')
@include('page-header',['title' => $title,'subtitle' => $subtitle])
@stop

@section('content')
<script>
$(document).ready(() => {
	hideElem(xx);
});

</script>
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
							 <div class="row">
							    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							 <ul class="list-inline"  style="overflow-x: scroll;">
							  <li class="list-inline-item"><input type="checkbox" id="mm-all"></li>
							  <li class="list-inline-item"><a id="refresh-btn" href="{{url('inbox')}}" class="btn" title="Refresh"><i class="fa fa-fw fa-undo menu-icon"></i></a></li>
							  <li class="list-inline-item"><a id="spam-btn" href="{{$void}}" class="btn" title="Mark as Spam" onclick="markSpam()"><i class="fa fa-fw fa-exclamation-triangle menu-icon"></i></a></li>
							  <li class="list-inline-item"><a id="trash-btn" href="{{$void}}" class="btn" title="Delete" onclick="trash()"><i class="fa fa-fw fa-trash menu-icon"></i></a></li>
							  <li class="list-inline-item"><a id="unread-btn" href="{{$void}}" class="btn" title="Mark as Unread" onclick="markUnread()"><i class="fa fa-fw fa-envelope menu-icon"></i></a></li>
							  <li class="list-inline-item"><a id="move-btn" href="{{$void}}" class="btn" title="Move to" onclick="moveTo()"><i class="fa fa-fw fa-folder-open menu-icon"></i></a></li>				  
							 </ul>  
							</div>	  
							</div>	  
								  
							
							</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table first etuk-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($msgs) > 0)
										   {
											  foreach($msgs as $m)
											   {
												   $sn = "<p>{$m['sn']}</p>";
												   $subject = "<p>{$m['subject']}</p>";
												   $ss  = $m['excerpt'];
												   $xf = $m['id'];
												   $vu = url('message')."?xf=".$xf;
												   if($m['status'] == "unread")
												   {
													   //$b = "text-bold";
													  $sn = "<p><span class='label label-success p-2'>{$m['sn']}</span></p>";
												   }
										  ?>
                                            <tr>
                                                <td>
                                                	<a href="{{$vu}}">
													@desktop
                                                	 <div class="d-flex justify-content-between">
													   <div class="d-inline-flex mt-3">
                                                	    <div><input type="checkbox" class="mm mr-2" data-xf="{{$xf}}"></div>  
													     <div>{!! $sn !!}</div>
                                               	       </div>
													   <div class="d-inline-flex mt-3">
                                                	   <div>{!! $subject !!}</div>
                                                	   <div class="ml-1 mr-1"> - </div>
                                                	   <div style="color: #ccc;">{!! $ss !!}...</div>
                                               	       </div>
													   <div class="d-inline-flex  mt-3">
                                                	     <div>{{ $m['dd'] }}</div>
                                               	       </div>
                                               	      </div>
													  @elsedesktop
													   <div class="row">
													      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														   <div class="d-flex justify-content-between">
													         <div class="d-inline-flex mt-3">
                                                	          <div><input type="checkbox" class="mm mr-2" data-xf="{{$xf}}"></div>  
                                               	             </div>
													         <div class="mt-3">
													          <div>{!! $sn !!}</div>															 
                                                	          <div class="mt-3">{!! $subject !!}</div>
                                                	          <div style="color: #b3b3b3;">{!! $ss !!}...</div>
                                               	             </div>
													         <div class=" mt-3">
                                                	           <div>{{ $m['dd'] }}</div>
                                               	             </div>
                                               	           </div>
													      </div>
													   </div>
													  @enddesktop
                                                   </a>
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