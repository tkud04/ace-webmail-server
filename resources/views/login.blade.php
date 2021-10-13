<?php
$blank = true;
//$su = "javascript:void(0)";
$su = url("signup");
?>

@extends('layout')

@section('title',"Login")

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
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
           <div class="card-header text-center">
			  <a href="{{url('/')}}"><h3>ACE WEBMAIL</h3></a>
			  <img src="images/logo.png" style="width: 80px; height: 80px;"/>
			  <span class="splash-description">Login to continue.</span>
			</div>
            <div class="card-body">
                <form method="post" action="{{url('hello')}}" id="l-form">
                    {!! csrf_field() !!}
					
					<div class="form-group">
                        <input class="form-control form-control-lg" name="id" id="login-id" type="text" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="login-password" type="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="l-form-btn">Sign in</button>
                </form>

							
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="{{$su}}" class="footer-link">Create An Account</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="{{url('forgot-password')}}" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
 	
@stop
