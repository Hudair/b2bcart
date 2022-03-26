@extends('layouts.front')

@section('content')

	@if($ps->slider == 1)

		@if(count($sliders))
			@include('includes.slider-style')
		@endif
	@endif

	@if($ps->slider == 1)
		<!-- Hero Area Start -->
		<section class="hero-area">
			@if($ps->slider == 1)

				@if(count($sliders))
					<div class="hero-area-slider">
						<div class="slide-progress"></div>
						<div class="intro-carousel">
							@foreach($sliders as $data)
								<div class="intro-content {{$data->position}}" style="background-image: url({{asset('assets/images/sliders/'.$data->photo)}})">
									<div class="container">
										<div class="row">
											<div class="col-lg-12">
												<div class="slider-content">
													<!-- layer 1 -->
													<div class="layer-1">
														<h4 style="font-size: {{$data->subtitle_size}}px; color: {{$data->subtitle_color}}" class="subtitle subtitle{{$data->id}}" data-animation="animated {{$data->subtitle_anime}}">{{$data->subtitle_text}}</h4>
														<h2 style="font-size: {{$data->title_size}}px; color: {{$data->title_color}}" class="title title{{$data->id}}" data-animation="animated {{$data->title_anime}}">{{$data->title_text}}</h2>
													</div>
													<!-- layer 2 -->
													<div class="layer-2">
														<p style="font-size: {{$data->details_size}}px; color: {{$data->details_color}}"  class="text text{{$data->id}}" data-animation="animated {{$data->details_anime}}">{{$data->details_text}}</p>
													</div>
													<!-- layer 3 -->
													<div class="layer-3">
														<a href="{{$data->link}}" target="_blank" class="mybtn1"><span>{{ $langg->lang25 }} <i class="fas fa-chevron-right"></i></span></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				@endif

			@endif

		</section>
		<!-- Hero Area End -->
	@endif

	
	@if($ps->featured_category == 1)

	{{-- Slider buttom Category Start --}}
	<section class="slider-buttom-category d-none d-md-block">
		<div class="container-fluid">
			<div class="row">
				@foreach($categories->where('is_featured','=',1) as $cat)
					<div class="col-xl-2 col-lg-3 col-md-4 sc-common-padding">
						<a href="{{ route('front.category',$cat->slug) }}" class="single-category">
							<div class="left">
								<h5 class="title">
									{{ $cat->name }}
								</h5>
								<p class="count">
									{{ count($cat->products) }} {{ $langg->lang4 }}
								</p>
							</div>
							<div class="right">
								<img src="{{asset('assets/images/categories/'.$cat->image) }}" alt="">
							</div>
						</a>
					</div>
				@endforeach
			</div>
		</div>
	</section>
	{{-- Slider buttom banner End --}}

	@endif



	<section id="extraData">
		<div class="text-center">
			<img src="{{asset('assets/images/'.$gs->loader)}}">
		</div>
	</section>


@endsection

@section('scripts')
	<script>
        $(window).on('load',function() {

            setTimeout(function(){

                $('#extraData').load('{{route('front.extraIndex')}}');

            }, 500);
        });

	</script>
@endsection