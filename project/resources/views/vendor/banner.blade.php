@extends('layouts.vendor')
@section('content')

						<div class="content-area">
							<div class="mr-breadcrumb">
								<div class="row">
									<div class="col-lg-12">
											<h4 class="heading">{{ $langg->lang454 }}</h4>

										<ul class="links">
											<li>
												<a href="{{ route('vendor-dashboard') }}">{{ $langg->lang441 }} </a>
											</li>
											<li>
												<a href="javascript:;">{{ $langg->lang452 }} </a>
											</li>
											<li>
												<a href="{{ route('vendor-banner') }}">{{ $langg->lang454 }}</a>
											</li>
										</ul>



									</div>
								</div>
							</div>
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">

				                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
											<form id="geniusform" action="{{ route('vendor-profile-update') }}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}


                      						 @include('includes.vendor.form-both')  

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                                <h4 class="heading">{{ $langg->lang520 }} *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <div class="img-upload full-width-img">
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->shop_image ? asset('assets/images/vendorbanner/'.$data->shop_image):asset('assets/images/noimage.png') }});">
						                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ $langg->lang522 }}</label>
						                                    <input type="file" name="shop_image" class="img-upload" id="image-upload">
						                                  </div>
						                                  <p class="text">{{ $langg->lang521 }}</p>
						                            </div>

						                          </div>
						                        </div>



						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit">{{ $langg->lang523 }}</button>
						                          </div>
						                        </div>

											</form>


											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

@endsection