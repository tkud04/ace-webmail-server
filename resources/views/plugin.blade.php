<?php
$title = "Edit Plugin";
$subtitle = "Edit this plugin.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Plugins",'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Edit Plugin</h5>
                                <div class="card-body">
                                    <form action="{{url('plugin')}}" id="apl-form" method="post">
										{!! csrf_field() !!}
										<input type="hidden" name="xf" value="{{$p['id']}}"/>
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="apl-name">Name</label>
                                            <input id="apl-name" type="text" value="{{$p['name']}}" placeholder="Plugin name" name="name" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="apl-value">Value</label>
                                             <textarea class="form-control" name="value" id="ap-value">{!! $p['value'] !!}</textarea>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Status</h4>
                                            <select class="form-control" name="status" id="ap-status" style="margin-bottom: 5px;">
							                  <option value="none">Select status</option>
								           <?php
								            $secs = ['enabled' => "Enabled",'disabled' => "Disabled"];
								            foreach($secs as $key => $value){
									      	 $ss = $p['status'] == $key ? " selected='selected'" : "";
								           ?>
								              <option value="{{$key}}"{{$ss}}>{{$value}}</option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="apl-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop