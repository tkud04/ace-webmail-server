<?php
$title = "Add Permissions";
$subtitle = "Grant one or more permissions to this user.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Permissions",'subtitle' => $title])
@stop

@section('scripts')
<script>
let apTags = [];
$(document).ready(() => {
	apTags = [
	<?php
	 for($i = 0; $i < count($permissions); $i++)
	 {
		 $p = $permissions[$i];
	?>
	{ptag: "{{$p}}",selected: false}@if($i != count($permissions) - 1),@endif
	<?php
	 }
	?>
	];
});
</script>
@stop

@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Permissions</h5>
                                <div class="card-body">
                                    <form action="{{url('add-permissions')}}" id="ap-form" method="post">
										{!! csrf_field() !!}
										<input type="hidden" name="xf" value="{{$u['id']}}"/>
										<input type="hidden" name="pp" id="ap-pp" value=""/>
                                        
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ap-email">Email address</label>
                                            <input id="user-email" type="email" value="{{$u['email']}}" placeholder="Enter email address" class="form-control" readonly>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Select Permission(s)</h4>
                                            <?php
											for($i=0; $i < count($permissions); $i++)
											{
												$pp = $permissions[$i];
											?>
											<label class="custom-control custom-control-inline custom-checkbox">
                                                <input type="checkbox" onchange="togglePP('{{$pp}}')" class="custom-control-input"><span class="custom-control-label">{{$pp}}</span>
                                            </label>
											<?php
											}
											?>
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
                                                    <button class="btn btn-space btn-secondary" id="ap-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop