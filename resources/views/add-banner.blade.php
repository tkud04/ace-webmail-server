<?php
$title = "Add Banner";
$subtitle = "Upload a banner.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Banners",'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Banner</h5>
                                <div class="card-body">
                                    <form action="{{url('add-banner')}}" id="ab-form" method="post" enctype="multipart/form-data">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-img">Upload image</label>
                                            <div id="ab-images">
												<div id="ab-image-div-0" class="row">
												  <div class="col-md-7">
												    <input type="file" class="form-control" onchange="readURL(this,{id: 'ab',ctr: '0'})" id="ab-img-0" name="ab-images[]">												    
												  </div>
												  <div class="col-md-5">
												    <img id="ab-preview-0" src="#" alt="preview" style="width: 100px; height: 100px;"/>
													</div>
												</div>
										    </div>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Type</h4>
                                            <select class="form-control" name="type" id="ab-type" style="margin-bottom: 5px;">
							                  <option value="none">Select type</option>
								           <?php
								            $types = ['landing' => "Landing page banner",'top-header' => "Top Header banner"];
								            foreach($types as $key => $value){
									      	 
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
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ab-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop