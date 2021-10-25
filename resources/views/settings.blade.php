

@extends('layout')

@section('title',$title)
@section('content')
 <div class="ecommerce-widget">

                        <div class="row">
						
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                  <div class="card-header">
                                      <ul class="nav nav-tabs card-header-tabs"  id="settings-tab" role="tablist">
                                        <li class="nav-item">
                                          <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab" aria-controls="advanced" aria-selected="true">Advanced</a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="card-body">
									  <div class="tab-content" id="settings-tab-content">
									    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
										  <form method="post" action="{{url('api/settings')}}">
										   <input id="new-sig-input" name="new-sigs" type="hidden"><input name="tk" type="hidden" value="kt">

                            
										    <div class="form-group">
                                             <h5 class="card-title" for="sig">Language</h5>
                                             <p class="card-text">English</p>
                                           </div>

										   <div class="form-group">
                                             <h5 class="card-title" for="sig">Signatures</h5>
											 <a href="javascript:void(0)" id="add-sig-btn">Add new signature</a>
											 <select class="form-control" id="sig" name="sig">
											   <option value="none">Select a signature to enable it</option>
											 <?php
											   foreach($sigs as $s)
											   {
												   $ss = ($s['current'] == "yes") ? " selected='selected'" : "";
											 ?>
                                             <option value="{{$s['id']}}"{{$ss}}></option>
											 <?php
											   }
											 ?>
											 </select>
											  <p class="card-text mt-2" id="new-sig-alert"></p>
                                           </div>
										   
                                           <button type="submit" class="btn btn-primary">Submit</button>
										   </form>
										</div>
										<div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
										   <h5 class="card-title">Advanced</h5>
                                           <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                           <a href="#" class="btn btn-primary">Go somewhere</a>
										</div>
                                      </div>
                                    </div>
                                  </div>
                            </div>

                        </div>
                        
                            <!-- ============================================================== -->
							
</div>
							
@stop