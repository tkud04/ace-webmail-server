<?php
$title = "Add Plan";
$subtitle = "Add a subscription plan to the system.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Plans",'subtitle' => $title])
@stop


@section('content')
<script>
$(document).ready(() => {
let addPlanDescriptionEditor = new Simditor({
		textarea: $('#asp-description'),
		toolbar: toolbar,
		placeholder: `Enter your description here. Maximum of 200 words..`
	});	
});

</script>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Plan</h5>
                                <div class="card-body">
                                    <form action="{{url('add-plan')}}" id="asp-form" method="post" enctype="multipart/form-data">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="asp-name">Name</label>
                                            <input id="asp-name" type="text" placeholder="Plan name" name="name" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="asp-amount">Amount</label>
                                             <input id="asp-amount" type="number" placeholder="Price" name="amount" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="asp-tc">Post Count</label>
                                             <input id="asp-tc" type="number" placeholder="Posting count" name="pc"  class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="asp-ps-id">Paystack ID (type <em>free</em> for free plans)</label>
                                             <input id="asp-ps-id" type="text" placeholder="Unique ID generated on Paystack" name="ps_id" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="asp-frequency">Billing frequency</label>
                                             <select id="ap-frequency" name="frequency" class="form-control">
											   <option value="none">How frequent should customers should be billed?</option>
											   <?php
											    $frequencies = [
												  'free' => "Don't bill customers",
												  'day' => "Daily",
												  'week' => "Weekly",
												  '2-week' => "Every 2 weeks",												 
												  'month' => "Monthly",
												  '3-month' => "Quarterly",
												];
												
												foreach($frequencies as $k => $v)
												{
											   ?>
											    <option value="{{$k}}">{{$v}}</option>
											   <?php
											    }
											   ?>
											 </select>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="asp-description">Description <em>(optional)</em></label>
                                             <textarea class="form-control" name="description" id="asp-description"></textarea>
                                        </div>
										</div>
										
				
                                            <div class="col-md-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="asp-form-btn">Submit</button>
                                                </p>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop