<?php
$title = "Add FAQ";
$subtitle = "Add a question/answer pair to FAQs";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Add FAQ",'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add FAQ</h5>
                                <div class="card-body">
                                    <form action="{{url('add-faq')}}" id="faq-form" method="post">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-question">Question</label>
                                            <input id="faq-question" type="text" placeholder="Question" name="question" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-answer">Answer</label>
                                             <textarea class="form-control" name="answer" id="faq-answer"></textarea>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Tag</h4>
                                            <select class="form-control" name="tag" id="faq-tag" style="margin-bottom: 5px;">
							                  <option value="none">Select tag</option>
								           <?php
								              foreach($tags as $t){
									      	 
								           ?>
								              <option value="{{$t['tag']}}">{{$t['name']}}</option>
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
                                                    <button class="btn btn-space btn-secondary" id="faq-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop