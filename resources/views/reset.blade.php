<?php
$blank = true;
?>

@extends('layout')

@section('title',"Reset Password")

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
            <div class="card-header text-center"><a href="{{url('/')}}"><h3>ETUK ADMIN</h3></a><span class="splash-description">Reset Password</span></div>
            <div class="card-body">
                <form method="post" id="fp-form">
                  <input type="hidden" id="acsrf" value="{{$uu->id}}"/>
				 <input type="hidden" id="tk-rp" value="{{csrf_token()}}"/>
					
					 <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="rp-pass" type="password" placeholder="New password">
                    </div>
					 <div class="form-group">
                        <input class="form-control form-control-lg" name="password2" id="rp-pass2" type="password" placeholder="Confirm password">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="rp-submit">Submit</button>
					
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                  <h4 class="text-primary" id="rp-loading">Processing your request.. <img alt="Loading.." src="{{asset('images/loader.svg')}}"></h4>
					<h4 class="text-primary" id="rp-finish"><b>Password reset!</b><p class='text-primary'>You can now <a href="{{url('hello')}}">sign in</a>.</p></h4>    
				</div>
            </div>
        </div>
    </div>
 	
@stop
