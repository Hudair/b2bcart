@extends('layouts.vendor')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ $langg->lang448 }} <a class="add-btn" href="{{ route('admin-prod-types') }}"><i
							class="fas fa-arrow-left"></i> {{ $langg->lang550 }}</a></h4>
				<ul class="links">
					<li>
						<a href="{{ route('vendor-dashboard') }}">{{ $langg->lang441 }} </a>
					</li>
					<li>
						<a href="javascript:;">{{ $langg->lang447 }} </a>
					</li>
					<li>
						<a href="{{ route('vendor-import-index') }}">{{ $langg->lang449 }}</a>
					</li>
					<li>
						<a href="{{ route('vendor-import-create') }}">{{ $langg->lang448 }}</a>
					</li>
				</ul>

			</div>
		</div>
	</div>


	<form id="geniusform" action="{{route('vendor-import-store')}}" method="POST"
									enctype="multipart/form-data">
									{{csrf_field()}}
	<div class="row">
		<div class="col-lg-8">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">
		
								<div class="gocover"
									style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
								</div>
									@include('includes.admin.form-both')
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang632 }}* </h4>
												<p class="sub-heading">{{ $langg->lang517 }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="{{ $langg->lang632 }}"
												name="name" required="">
										</div>
									</div>
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang793 }}* </h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="{{ $langg->lang794 }}"
												name="sku" required=""
												value="{{ Str::random(3).substr(time(), 6,8).Str::random(3) }}">
		
										</div>
									</div>
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang707 }}* </h4>
												<p class="sub-heading">{{ $langg->lang708 }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="{{ $langg->lang707 }}"
												name="affiliate_link" required="">
											<div class="checkbox-wrapper">
												<input type="checkbox" name="product_condition_check" class="checkclick"
													id="conditionCheck" value="1">
												<label for="conditionCheck">{{ $langg->lang633 }}</label>
											</div>
										</div>
									</div>
		
		
									<div class="showbox">
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ $langg->lang634 }}*</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<select name="product_condition">
													<option value="2">{{ $langg->lang635 }}</option>
													<option value="1">{{ $langg->lang636 }}</option>
												</select>
											</div>
		
										</div>
		
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang637 }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select id="cat" name="category_id" required="">
												<option value="">{{ $langg->lang691 }}</option>
												@foreach($cats as $cat)
												<option data-href="{{ route('vendor-subcat-load',$cat->id) }}"
													value="{{ $cat->id }}">{{$cat->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang638 }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select id="subcat" name="subcategory_id" disabled="">
												<option value="">{{ $langg->lang639 }}</option>
											</select>
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang640 }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select id="childcat" name="childcategory_id" disabled="">
												<option value="">{{ $langg->lang641 }}</option>
											</select>
										</div>
									</div>
		

							
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
		
											</div>
										</div>
										<div class="col-lg-12">
											<ul class="list">
												<li>
													<input class="checkclick1" name="shipping_time_check" type="checkbox"
														id="check1" value="1">
													<label for="check1">{{ $langg->lang646 }}</label>
												</li>
											</ul>
										</div>
									</div>
		
		
		
									<div class="showbox">
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ $langg->lang647 }}* </h4>
												</div>
											</div>
											<div class="col-lg-12">
												<input type="text" class="input-field" placeholder="{{ $langg->lang647 }}"
													name="ship">
											</div>
										</div>
		
		
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
		
											</div>
										</div>
										<div class="col-lg-12">
											<ul class="list">
												<li>
													<input name="size_check" type="checkbox" id="size-check" value="1">
													<label for="size-check">{{ $langg->lang648 }}</label>
												</li>
											</ul>
										</div>
									</div>
									<div class="showbox" id="size-display">
										<div class="row">
											<div class="col-lg-12">
											</div>
											<div class="col-lg12">
												<div class="product-size-details" id="size-section">
													<div class="size-area">
														<span class="remove size-remove"><i class="fas fa-times"></i></span>
														<div class="row">
															<div class="col-md-4 col-sm-6">
																<label>
																	{{ $langg->lang649 }} :
																	<span>
																		{{ $langg->lang650 }}
																	</span>
																</label>
																<input type="text" name="size[]" class="input-field"
																	placeholder="{{ $langg->lang649 }}">
															</div>
															<div class="col-md-4 col-sm-6">
																<label>
																	{{ $langg->lang651 }} :
																	<span>
																		{{ $langg->lang652 }}
																	</span>
																</label>
																<input type="number" name="size_qty[]" class="input-field"
																	placeholder="{{ $langg->lang651 }}" value="1" min="1">
															</div>
															<div class="col-md-4 col-sm-6">
																<label>
																	{{ $langg->lang653 }} :
																	<span>
																		{{ $langg->lang654 }}
																	</span>
																</label>
																<input type="number" name="size_price[]" class="input-field"
																	placeholder="{{ $langg->lang653 }}" value="0" min="0">
															</div>
														</div>
													</div>
												</div>
		
												<a href="javascript:;" id="size-btn" class="add-more"><i
														class="fas fa-plus"></i>{{ $langg->lang655 }} </a>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
		
											</div>
										</div>
										<div class="col-lg-12">
											<ul class="list">
												<li>
													<input class="checkclick1" name="color_check" type="checkbox" id="check3"
														value="1">
													<label for="check3">{{ $langg->lang656 }}</label>
												</li>
											</ul>
										</div>
									</div>
		
		
		
									<div class="showbox">
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">
														{{ $langg->lang657 }}*
													</h4>
													<p class="sub-heading">
														{{ $langg->lang658 }}
													</p>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="select-input-color" id="color-section">
													<div class="color-area">
														<span class="remove color-remove"><i class="fas fa-times"></i></span>
														<div class="input-group colorpicker-component cp">
															<input type="text" name="color[]" value="#000000"
																class="input-field cp" />
															<span class="input-group-addon"><i></i></span>
														</div>
													</div>
												</div>
												<a href="javascript:;" id="color-btn" class="add-more mt-4 mb-3"><i
														class="fas fa-plus"></i>{{ $langg->lang659 }} </a>
											</div>
										</div>
		
									</div>
		
	
									<div class="row" id="stckprod">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang669 }}*</h4>
												<p class="sub-heading">{{ $langg->lang670 }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="stock" type="text" class="input-field"
												placeholder="{{ $langg->lang666 }}">
											<div class="checkbox-wrapper">
												<input type="checkbox" name="measure_check" class="checkclick"
													id="allowProductMeasurement" value="1">
												<label for="allowProductMeasurement">{{ $langg->lang671 }}</label>
											</div>
										</div>
									</div>
		
		
		
									<div class="showbox">
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ $langg->lang672 }}*</h4>
												</div>
											</div>
											<div class="col-lg-6">
												<select id="product_measure">
													<option value="">{{ $langg->lang673 }}</option>
													<option value="Gram">{{ $langg->lang674 }}</option>
													<option value="Kilogram">{{ $langg->lang675 }}</option>
													<option value="Litre">{{ $langg->lang676 }}</option>
													<option value="Pound">{{ $langg->lang677 }}</option>
													<option value="Custom">{{ $langg->lang678 }}</option>
												</select>
											</div>
											<div class="col-lg-6 hidden" id="measure">
												<input name="measure" type="text" id="measurement" class="input-field"
													placeholder="{{ $langg->lang679 }}">
											</div>
										</div>
		
									</div>
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													{{ $langg->lang680 }}*
												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="text-editor">
												<textarea class="nic-edit-p" name="details"></textarea>
											</div>
										</div>
									</div>
		
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													{{ $langg->lang681 }}*
												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="text-editor">
												<textarea class="nic-edit-p" name="policy"></textarea>
											</div>
										</div>
									</div>
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="checkbox-wrapper">
												<input type="checkbox" name="seo_check" value="1" class="checkclick"
													id="allowProductSEO" value="1">
												<label for="allowProductSEO">{{ $langg->lang683 }}</label>
											</div>
										</div>
									</div>
		
		
		
									<div class="showbox">
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ $langg->lang684 }} *</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<ul id="metatags" class="myTags">
												</ul>
											</div>
										</div>
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">
														{{ $langg->lang685 }} *
													</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="text-editor">
													<textarea name="meta_description" class="input-field"
														placeholder="{{ $langg->lang685 }}"></textarea>
												</div>
											</div>
										</div>
									</div>
		
						
		
									<input type="hidden" name="type" value="Physical">
									<div class="row">
										<div class="col-lg-12 text-center">
											<button class="addProductSubmit-btn" type="submit">{{ $langg->lang690 }}</button>
										</div>
									</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">
								<div class="row">
									<div class="col-lg-12">
										<div class="left-area">
											<h4 class="heading">{{ $langg->lang709 }}*</h4>
										</div>
									</div>
									<div class="col-lg-12">
										<select id="imageSource" name="image_source">
											<option value="file">{{ $langg->lang710 }}</option>
											<option value="link">{{ $langg->lang711 }}</option>
										</select>
									</div>
								</div>
	
	
								<div id="f-link" style="display: none;">
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang712 }} *</h4>
											</div>
										</div>
										<div class="col-lg-12">
	
											<input type="text" name="photolink" value="" class="input-field">
										</div>
									</div>
								</div>
									<div id="f-file">
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ $langg->lang511 }} *</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="img-upload custom-image-upload">
													<div id="image-preview" class="img-preview"
														style="background: url({{ asset('assets/vendor/images/upload.png') }});">
														<label for="image-upload" class="img-label" id="image-label"><i
																class="icofont-upload-alt"></i>{{ $langg->lang512 }}</label>
														<input type="file" name="photo" class="img-upload-p" id="image-upload"
															required>
													</div>
													<p class="img-alert mt-2 text-danger d-none"></p>
													<p class="text">
														{{ isset($langg->lang805) ? $langg->lang805 : 'Prefered Size: (800x800) or Square Size.' }}
													</p>
												</div>
		
											</div>
										</div>
		
		
		
									</div>
		
									<div id="f-link" style="display: none;">
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ $langg->lang712 }} *</h4>
												</div>
											</div>
											<div class="col-lg-12">
		
												<input type="text" name="photolink" value="" class="input-field">
											</div>
										</div>
									</div>

									<input type="file" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*"
										multiple>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													{{ $langg->lang644 }} *
												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<a href="#" class="set-gallery" data-toggle="modal" data-target="#setgallery">
												<i class="icofont-plus"></i> {{ $langg->lang645 }}
											</a>
										</div>
									</div>
		
		
				
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													{{ $langg->lang664 }}*
												</h4>
												<p class="sub-heading">
													({{ $langg->lang665 }} {{$sign->name}})
												</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="price" step="0.1" type="number" class="input-field"
												placeholder="{{ $langg->lang666 }}" required="" min="0">
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang667 }}*</h4>
												<p class="sub-heading">{{ $langg->lang668 }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="previous_price" step="0.1" type="number" class="input-field"
												placeholder="{{ $langg->lang666 }}" min="0">
										</div>
									</div>
		
							
		
									<div class="row">
										<div class="col-lg-12">
											<div class="featured-keyword-area">
												<div class="left-area">
													<h4 class="heading">{{ $langg->lang686 }}</h4>
												</div>
		
												<div class="feature-tag-top-filds" id="feature-section">
													<div class="feature-area">
														<span class="remove feature-remove"><i class="fas fa-times"></i></span>
														<div class="row">
															<div class="col-lg-6">
																<input type="text" name="features[]" class="input-field"
																	placeholder="{{ $langg->lang687 }}">
															</div>
		
															<div class="col-lg-6">
																<div class="input-group colorpicker-component cp">
																	<input type="text" name="colors[]" value="#000000"
																		class="input-field cp" />
																	<span class="input-group-addon"><i></i></span>
																</div>
															</div>
														</div>
													</div>
												</div>
		
												<a href="javascript:;" id="feature-btn" class="add-fild-btn"><i
														class="icofont-plus"></i> {{ $langg->lang688 }}</a>
											</div>
										</div>
									</div>
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ $langg->lang689 }} *</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<ul id="tags" class="myTags">
											</ul>
										</div>
									</div>
		
									<input type="hidden" name="type" value="Physical">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form>
</div>

<div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ $langg->lang619 }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="top-area">
					<div class="row">
						<div class="col-sm-6 text-right">
							<div class="upload-img-btn">
								<label id="prod_gallery"><i class="icofont-upload-alt"></i>{{ $langg->lang620 }}</label>
							</div>
						</div>
						<div class="col-sm-6">
							<a href="javascript:;" class="upload-done" data-dismiss="modal"> <i
									class="fas fa-check"></i> {{ $langg->lang621 }}</a>
						</div>
						<div class="col-sm-12 text-center">( <small>{{ $langg->lang622 }}</small> )</div>
					</div>
				</div>
				<div class="gallery-images">
					<div class="selected-image">
						<div class="row">


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>

<script type="text/javascript">
	// Gallery Section Insert

	$(document).on('click', '.remove-img', function () {
		var id = $(this).find('input[type=hidden]').val();
		$('#galval' + id).remove();
		$(this).parent().parent().remove();
	});

	$(document).on('click', '#prod_gallery', function () {
		$('#uploadgallery').click();
		$('.selected-image .row').html('');
		$('#geniusform').find('.removegal').val(0);
	});


	$("#uploadgallery").change(function () {
		var total_file = document.getElementById("uploadgallery").files.length;
		for (var i = 0; i < total_file; i++) {
			$('.selected-image .row').append('<div class="col-sm-6">' +
				'<div class="img gallery-img">' +
				'<span class="remove-img"><i class="fas fa-times"></i>' +
				'<input type="hidden" value="' + i + '">' +
				'</span>' +
				'<a href="' + URL.createObjectURL(event.target.files[i]) + '" target="_blank">' +
				'<img src="' + URL.createObjectURL(event.target.files[i]) + '" alt="gallery image">' +
				'</a>' +
				'</div>' +
				'</div> '
			);
			$('#geniusform').append('<input type="hidden" name="galval[]" id="galval' + i +
				'" class="removegal" value="' + i + '">')
		}

	});

	// Gallery Section Insert Ends	
</script>

<script type="text/javascript">
	$('#imageSource').on('change', function () {
		var file = this.value;
		if (file == "file") {
			$('#f-file').show();
			$('#f-link').hide();
			$('#f-link').find('input').prop('required', false);
			$('#image-upload').prop('required', true);
		}
		if (file == "link") {
			$('#f-file').hide();
			$('#f-link').show();
			$('#f-link').find('input').prop('required', true);
			$('#image-upload').prop('required', false);
		}
	});
</script>

<script type="text/javascript">
	$('.cropme').simpleCropper();

</script>

<script src="{{asset('assets/vendor/js/product.js')}}"></script>
@endsection