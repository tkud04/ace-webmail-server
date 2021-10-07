<?php
$blank = true;
?>

@extends('layout')

@section('title',"Forgot Password")

@section('styles')
<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
@stop

@section('content')
<!-- ============================================================== -->
    <!-- Forgot password page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="{{url('/')}}"><h3>ETUK ADMIN</h3></a><span class="splash-description">Forgot Password</span></div>
            <div class="card-body">
                <form method="post" id="fp-form">
                  <input type="hidden" id="tk-fp" value="{{csrf_token()}}"/>
					
					<div class="form-group">
                        <input class="form-control form-control-lg" name="id" id="fp-email" type="text" placeholder="Your email address" autocomplete="off">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="fp-submit">Submit</button>
					
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                  <h4 class="text-primary" id="fp-loading">Processing your request.. <img alt="Loading.." src="{{asset('images/loader.svg')}}"></h4>
					<h4 class="text-primary" id="fp-finish"><b>Request received!</b><p class='text-primary'>Please check your email for your password reset link.</p></h4>    
				</div>
            </div>
        </div>
    </div>
 	
@stop
