<?php
$title = "Add Post";
$subtitle = "Upload a post to the blog.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Posts",'subtitle' => $title])
@stop


@section('content')
<script>
$(document).ready(() => {
let addPostContentEditor = new Simditor({
		textarea: $('#ap-content'),
		toolbar: toolbar,
		placeholder: `Enter your post content here. Maximum of 7000 words..`
	});	
});

</script>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Post</h5>
                                <div class="card-body">
                                    <form action="{{url('add-post')}}" id="abp-form" method="post" enctype="multipart/form-data">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ap-img">Upload image</label>
                                            <div id="ap-images">
												<div id="ap-image-div-0" class="row">
												  <div class="col-md-7">
												    <input type="file" class="form-control" onchange="readURL(this,{id: 'ap',ctr: '0'})" id="ap-img-0" name="ap-images[]">												    
												  </div>
												  <div class="col-md-5">
												    <img id="ap-preview-0" src="#" alt="preview" style="width: 100px; height: 100px;"/>
													</div>
												</div>
										    </div>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ap-title">Title</label>
                                            <input id="ap-title" type="text" placeholder="Post title" name="title" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ap-url">URL</label>
                                             <input id="ap-url" type="text" placeholder="Friendly URL e.g. how-to-pick-an-apartment" name="url" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Tips</label>
                                               <p class="form-control-plaintext">This is the first tip.</p>
											   <p class="form-control-plaintext">This is the second tip.</p>
											   <p class="form-control-plaintext">This is the third tip.</p>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ap-url">Content</label>
                                             <textarea class="form-control" name="content" id="ap-content"></textarea>
                                        </div>
										</div>
										
				
                                            <div class="col-md-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="abp-form-btn">Save</button>
                                                </p>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop