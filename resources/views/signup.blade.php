<?php
$blank = true;
?>

@extends('layout')

@section('title',"Signup")

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
			  <span class="splash-description">Signup to continue.</span>
			</div>
            <div class="card-body">
                <form method="post" action="{{url('signup')}}" id="s-form">
                    {!! csrf_field() !!}
					
					<div class="row">
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="fname" id="signup-fname" type="text" placeholder="First name" autocomplete="off">
                      </div>
                     </div> 
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="lname" id="signup-lname" type="text" placeholder="Last name" autocomplete="off">
                      </div>
                     </div>
                    </div>
					<div class="row">
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="signup-username" type="text" placeholder="Desired username" autocomplete="off">
                      </div>
                     </div> 
					 <div class="col-md-6">
					  <div class="form-group">
                        <p class="form-control-plaintext">@aceluxurystore.com</p>
                      </div>
                     </div>
                    </div>
					<div class="row">
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="pass" id="signup-password" type="password" placeholder="Password">
                    </div>
                     </div> 
					 <div class="col-md-6">
					  <div class="form-group">
                        <input class="form-control form-control-lg" name="pass_confirmation" id="signup-password-2" type="password" placeholder="Confirm password">
                    </div>
                     </div>
                    </div>
                    
                    <button class="btn btn-primary btn-lg btn-block" id="s-form-btn">Sign up</button>
                </form>
		

							
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="{{url('login')}}" class="footer-link">Log in</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="{{url('forgot-password')}}" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
 	
@stop
