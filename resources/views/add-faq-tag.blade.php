<?php
$title = "Add FAQ Tag";
$subtitle = "Adda category for FAQs";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => $title,'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add FAQ Tag</h5>
                                <div class="card-body">
                                    <form action="{{url('add-faq-tag')}}" id="faq-tag-form" method="post">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-tag">Tag</label>
                                            <input id="faq-tag" type="text" placeholder="Tag e.g payment" name="tag" class="form-control">
                                        </div>
                                        <div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-name">Name</label>
                                            <input id="faq-name" type="text" placeholder="Tag title e.g Payments and Billing" name="name" class="form-control">
                                        </div>
										</div>
										
										
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="faq-tag-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop