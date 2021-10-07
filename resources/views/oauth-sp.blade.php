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
            <div class="card-header text-center"><a href="{{url('/')}}"><h3>ETUK ADMIN</h3></a><span class="splash-description">Set Your Account Password</span></div>
            <div class="card-body">
                <form method="post" action="oauth-sp" id="osp-form">
                  {!! csrf_field() !!}
							 <input type="hidden" name="acsrf" value="{{$xf}}"/>
							 
					 <div class="form-group">
                        <input class="form-control form-control-lg" id="osp-pass" name="pass" type="password" placeholder="New password">
                    </div>
					 <div class="form-group">
                        <input class="form-control form-control-lg" id="osp-pass2" name="pass_confirmation" type="password" placeholder="Confirm password">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="osp-submit">Submit</button>
					
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
