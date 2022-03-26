<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($page->meta_tag) && isset($page->meta_description))
        <meta name="keywords" content="{{ $page->meta_tag }}">
        <meta name="description" content="{{ $page->meta_description }}">
		<title>{{$gs->title}}</title>
	@elseif(isset($blog->meta_tag) && isset($blog->meta_description))
		<meta property="og:title" content="{{$blog->title}}" />
		<meta property="og:description" content="{{ $blog->meta_description != null ? $blog->meta_description : strip_tags($blog->meta_description) }}" />
		<meta property="og:image" content="{{asset('assets/images/blogs'.$blog->photo)}}" />
        <meta name="keywords" content="{{ $blog->meta_tag }}">
        <meta name="description" content="{{ $blog->meta_description }}">
		<title>{{$gs->title}}</title>
    @elseif(isset($productt))
		<meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): '' }}">
		<meta name="description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}">
	    <meta property="og:title" content="{{$productt->name}}" />
	    <meta property="og:description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
	    <meta property="og:image" content="{{asset('assets/images/thumbnails/'.$productt->thumbnail)}}" />
	    <meta name="author" content="GeniusOcean">
    	<title>{{substr($productt->name, 0,11)."-"}}{{$gs->title}}</title>
	@else
		<meta property="og:title" content="{{$gs->title}}" />
		<meta property="og:description" content="{{ strip_tags($gs->footer) }}" />
		<meta property="og:image" content="{{asset('assets/images/'.$gs->logo)}}" />
	    <meta name="keywords" content="{{ $seo->meta_keys }}">
	    <meta name="author" content="GeniusOcean">
		<title>{{$gs->title}}</title>
    @endif
	<!-- favicon -->
	<link rel="icon"  type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}"/>
	<!-- bootstrap -->
	<link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
	<!-- Plugin css -->
	<link rel="stylesheet" href="{{asset('assets/front/css/plugin.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/animate.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/toastr.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/toastr.css')}}">

	<!-- jQuery Ui Css-->
	<link rel="stylesheet" href="{{asset('assets/front/jquery-ui/jquery-ui.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/jquery-ui/jquery-ui.structure.min.css')}}">

@if($langg->rtl == "1")

	<!-- stylesheet -->
	<link rel="stylesheet" href="{{asset('assets/front/css/rtl/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/rtl/custom.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common.css')}}">
	<!-- responsive -->
	<link rel="stylesheet" href="{{asset('assets/front/css/rtl/responsive.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common-responsive.css')}}">

    <!--Updated CSS-->
 <link rel="stylesheet" href="{{ asset('assets/front/css/rtl/styles.php?color='.str_replace('#','',$gs->colors).'&amp;'.'header_color='.str_replace('#','',$gs->header_color).'&amp;'.'footer_color='.str_replace('#','',$gs->footer_color).'&amp;'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&amp;'.'menu_color='.str_replace('#','',$gs->menu_color).'&amp;'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}">

@else

	<!-- stylesheet -->
	<link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/custom.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common.css')}}">
	<!-- responsive -->
	<link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common-responsive.css')}}">

    <!--Updated CSS-->
 <link rel="stylesheet" href="{{ asset('assets/front/css/styles.php?color='.str_replace('#','',$gs->colors).'&amp;'.'header_color='.str_replace('#','',$gs->header_color).'&amp;'.'footer_color='.str_replace('#','',$gs->footer_color).'&amp;'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&amp;'.'menu_color='.str_replace('#','',$gs->menu_color).'&amp;'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}">

@endif



</head>

<body>

<!-- Breadcrumb Area End -->

	<!-- Check Out Area Start -->
	<section class="checkout"> 
		<div class="container">

			<div class="row">
				

				<div class="col-lg-8 order-last order-lg-first">

		<form action="" method="POST" class="checkoutform">

			@include('includes.form-success')
			@include('includes.form-error')

			{{ csrf_field() }}

					<div class="checkout-area">
                        <div class="order-box">
								<div class="content-box">
									<div class="content">
											<div class="payment-information">
												<h4 class="title">
													{{ $langg->lang759 }}
												</h4>

												<div class="row">
													<div class="col-lg-12">
														<div class="nav flex-column"  role="tablist" aria-orientation="vertical">
														@if($gs->paypal_check == 1)
															<a class="nav-link payment" data-val="" data-show="no" data-form="{{route('api.paypal.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'paypal','slug2' => 0]) }}" id="v-pills-tab1-tab" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1" aria-selected="true">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																<p>
																		{{ $langg->lang760 }}

																	@if($gs->paypal_text != null)

																	<small>
																			{{ $gs->paypal_text }}
																	</small>

																	@endif

																</p>
															</a>
														@endif
														@if($gs->stripe_check == 1)
															<a class="nav-link payment" data-val="" data-show="yes" data-form="{{route('api.stripe.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'stripe','slug2' => 0]) }}" id="v-pills-tab2-tab" data-toggle="pill" href="#v-pills-tab2" role="tab" aria-controls="v-pills-tab2" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																	{{ $langg->lang761 }}

																		@if($gs->stripe_text != null)

																		<small>
																			{{ $gs->stripe_text }}
																		</small>

																		@endif

																	</p>
															</a>
														@endif
													
														@if($gs->is_instamojo == 1)
															<a class="nav-link payment" data-val="" data-show="no" data-form="{{route('api.instamojo.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'instamojo','slug2' => 0]) }}"  id="v-pills-tab4-tab" data-toggle="pill" href="#v-pills-tab4" role="tab" aria-controls="v-pills-tab4" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																			{{ $langg->lang763 }}

																		@if($gs->instamojo_text != null)

																		<small>
																				{{ $gs->instamojo_text }}
																		</small>

																		@endif

																	</p>
															</a>
															@endif
															@if($gs->is_paytm == 1)
																<a class="nav-link payment" data-val="" data-show="no" data-form="{{route('api.paytm.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'paytm','slug2' => 0]) }}"  id="v-pills-tab5-tab" data-toggle="pill" href="#v-pills-tab5" role="tab" aria-controls="v-pills-tab5" aria-selected="false">
																		<div class="icon">
																				<span class="radio"></span>
																		</div>
																		<p>
																				{{ $langg->paytm }}
	
																			@if($gs->paytm_text != null)
	
																			<small>
																					{{ $gs->paytm_text }}
																			</small>
	
																			@endif
	
																		</p>
																</a>
																@endif
																@if($gs->is_razorpay == 1)
																	<a class="nav-link payment" data-val="" data-show="no" data-form="{{route('api.razorpay.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'razorpay','slug2' => 0]) }}"  id="v-pills-tab6-tab" data-toggle="pill" href="#v-pills-tab6" role="tab" aria-controls="v-pills-tab6" aria-selected="false">
																			<div class="icon">
																					<span class="radio"></span>
																			</div>
																			<p>
																					
																				{{ $langg->razorpay }}
		
																				@if($gs->razorpay_text != null)
		
																				<small>
																						{{ $gs->razorpay_text }}
																				</small>
		
																				@endif
		
																			</p>
																	</a>
																	@endif
																	
														
															
															@if($gs->is_paystack == 1)

															<a class="nav-link payment" data-val="paystack" data-show="no" data-form="{{route('api.paystack.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'paystack','slug2' => 0]) }}" id="v-pills-tab7-tab" data-toggle="pill" href="#v-pills-tab7" role="tab" aria-controls="v-pills-tab7" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																			{{ $langg->lang764 }}

																		@if($gs->paystack_text != null)

																		<small>
																				{{ $gs->paystack_text }}
																		</small>

																		@endif
																	</p>
															</a>

															@endif
															
															


															@if($gs->is_molly == 1)
															<a class="nav-link payment" data-val="" data-show="no" data-form="{{route('api.molly.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'molly','slug2' => 0]) }}" id="v-pills-tab8-tab" data-toggle="pill" href="#v-pills-tab8" role="tab" aria-controls="v-pills-tab8" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																			{{ $langg->lang802 }}

																		@if($gs->molly_text != null)

																		<small>
																				{{ $gs->molly_text }}
																		</small>

																		@endif
																	</p>
															</a>

															@endif

														</div>
													</div>
													<div class="col-lg-12">
													  <div class="pay-area d-none">
														<div class="tab-content" id="v-pills-tabContent">

															
															@if($gs->paypal_check == 1)
															<div class="tab-pane fade" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1-tab">

															</div>
															@endif
															@if($gs->stripe_check == 1)
															<div class="tab-pane fade" id="v-pills-tab2" role="tabpanel" aria-labelledby="v-pills-tab2-tab">
															</div>
															@endif
														
															@if($gs->is_instamojo == 1)
																<div class="tab-pane fade" id="v-pills-tab4" role="tabpanel" aria-labelledby="v-pills-tab4-tab">
																</div>
															@endif
															@if($gs->is_paytm == 1)
																<div class="tab-pane fade" id="v-pills-tab5" role="tabpanel" aria-labelledby="v-pills-tab5-tab">
																</div>
															@endif
															@if($gs->is_razorpay == 1)
																<div class="tab-pane fade" id="v-pills-tab6" role="tabpanel" aria-labelledby="v-pills-tab6-tab">
																</div>
															@endif
															@if($gs->is_paystack == 1)
																<div class="tab-pane fade" id="v-pills-tab7" role="tabpanel" aria-labelledby="v-pills-tab7-tab">
																</div>
															@endif
															@if($gs->is_molly == 1)
																<div class="tab-pane fade" id="v-pills-tab8" role="tabpanel" aria-labelledby="v-pills-tab8-tab">
																</div>
															@endif										
																								
															
														
													</div>
														</div>
													</div>
												</div>
											</div>
											
										<div class="row">
											<div class="col-lg-12 mt-3">
												<div class="bottom-area">
												     <input type="hidden" value="{{ $order->pay_amount * $order->currency_value }}" id="grandTotal">
													<button type="submit" id="final-btn" class="mybtn1">{{ $langg->lang753 }}</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<input type="hidden" id="preamount" value="{{ $order->pay_amount * $order->currency_value }}">
						<input type="hidden" name="order_number" value="{{ $order->order_number }}">
						<input type="hidden" name="email" value="{{ $order->customer_email }}">
						<input type="hidden" name="ref_id" id="ref_id" value="">

				</div>


				<div class="col-lg-4">
					<div class="right-area">
						<div class="order-box">
						<h4 class="title">{{ $langg->lang127 }}</h4>


        		            <div class="total-price">
        		              <p>
        		                {{ $langg->lang131 }}
        		              </p>
        		              <p>
                                    
        							@if($gs->currency_format == 0)
        								<span id="total-cost">{{ $order->currency_sign }}<span class="total_price"> {{ round($order->pay_amount * $order->currency_value,2) }}</span></span>
        							@else 
        								<span id="total-cost"> <span class="total_price"> {{ round($order->pay_amount * $order->currency_value,2) }}</span>{{ $order->currency_sign }}</span>
        							@endif
        
        		              </p>
		                    </div>

               
						{{-- Shipping Method Area Start --}}
						<div class="packeging-area">
								<h4 class="title">{{ $langg->lang765 }}</h4>

							@foreach($shipping_data as $data)
						
								<div class="radio-design">
										<input type="radio" class="shipping" id="free-shepping{{ $data->id }}" name="shipping" value="{{$data->id}}" data="{{ round($data->price * $order->currency_value,2) }}" {{ ($loop->first) ? 'checked' : '' }}> 
										<span class="checkmark"></span>
										<label for="free-shepping{{ $data->id }}"> 
												{{ $data->title }}
												@if($data->price != 0)
												+ {{ $order->currency_sign }}{{ round($data->price * $order->currency_value,2) }}
												@endif
												<small>{{ $data->subtitle }}</small>
										</label>
								</div>

							@endforeach		

						</div>
						{{-- Shipping Method Area End --}}

						{{-- Packeging Area Start --}}
						<div class="packeging-area">
								<h4 class="title">{{ $langg->lang766 }}</h4>

							@foreach($package_data as $data)	

								<div class="radio-design">
										<input type="radio" class="packing" id="free-package{{ $data->id }}" name="packeging" value="{{$data->id}}" data="{{ round($data->price * $order->currency_value,2) }}" {{ ($loop->first) ? 'checked' : '' }}> 
										<span class="checkmark"></span>
										<label for="free-package{{ $data->id }}"> 
												{{ $data->title }}
												@if($data->price != 0)
												+ {{ $order->currency_sign }}{{ round($data->price * $order->currency_value,2) }}
												@endif
												<small>{{ $data->subtitle }}</small>
										</label>
								</div>

							@endforeach	

						</div>
						{{-- Packeging Area End Start--}}


						</div>
						{{-- Final Price Area End --}}

						</div>
					</div>
					
					
                          
					</form>
					
					
				</div>

			</div>
		</div>
	</section>
		<!-- Check Out Area End-->


<script type="text/javascript">
  var mainurl = "{{url('/')}}";
  var gs      = {!! json_encode($gs) !!};
  var langg    = {!! json_encode($langg) !!};
</script>

	<!-- jquery -->
	<script src="{{asset('assets/front/js/jquery.js')}}"></script>
	{{-- <script src="{{asset('assets/front/js/vue.js')}}"></script> --}}
	<script src="{{asset('assets/front/jquery-ui/jquery-ui.min.js')}}"></script>
	<!-- popper -->
	<script src="{{asset('assets/front/js/popper.min.js')}}"></script>
	<!-- bootstrap -->
	<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
	<!-- plugin js-->
	<script src="{{asset('assets/front/js/plugin.js')}}"></script>

	<script src="{{asset('assets/front/js/xzoom.min.js')}}"></script>
	<script src="{{asset('assets/front/js/jquery.hammer.min.js')}}"></script>
	<script src="{{asset('assets/front/js/setup.js')}}"></script>

	<script src="{{asset('assets/front/js/toastr.js')}}"></script>
	<!-- main -->
	<script src="{{asset('assets/front/js/main.js')}}"></script>
	<!-- custom -->
	<script src="{{asset('assets/front/js/custom.js')}}"></script>

    {!! $seo->google_analytics !!}

	@if($gs->is_talkto == 1)
		<!--Start of Tawk.to Script-->
		{!! $gs->talkto !!}
		<!--End of Tawk.to Script-->
	@endif





<script src="https://js.paystack.co/v1/inline.js"></script>

<script src="//voguepay.com/js/voguepay.js"></script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>



<script type="text/javascript">
	$('a.payment:first').addClass('active');
	$('.checkoutform').prop('action',$('a.payment:first').data('form'));
	$($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));
	var show = $('a.payment:first').data('show');
	if(show != 'no') {
		$('.pay-area').removeClass('d-none');
	}
	else {
		$('.pay-area').addClass('d-none');
	}
	$($('a.payment:first').attr('href')).addClass('active').addClass('show');
</script>


@php 
$curr = App\Models\Currency::where('sign','=',$order->currency_sign)->firstOrFail();
@endphp


<script type="text/javascript">

var ck = 0;

	$('.checkoutform').on('submit',function(e){
		if(ck == 0) {
			e.preventDefault();			
		$('#pills-step2-tab').removeClass('disabled');
		$('#pills-step2-tab').click();

	}else {
		$('#preloader').show();
	}
	$('#pills-step1-tab').addClass('active');
	});

	$('#step1-btn').on('click',function(){
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step2-tab').addClass('disabled');
		$('#pills-step3-tab').addClass('disabled');

		$('#pills-step1-tab').click();

	});

// Step 2 btn DONE

	$('#step2-btn').on('click',function(){
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').addClass('disabled');
		$('#pills-step2-tab').click();
		$('#pills-step1-tab').addClass('active');

	});

	$('#step3-btn').on('click',function(){
	 	if($('a.payment:first').data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
		else if($('a.payment:first').data('val') == 'voguepay'){
			$('.checkoutform').prop('id','voguepay');
		}
		else {
			$('.checkoutform').prop('id','twocheckout');
		}
		$('#pills-step3-tab').removeClass('disabled');
		$('#pills-step3-tab').click();

		var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();
		var shipping_location  = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
		var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

		$('#shipping_user').html('<i class="fas fa-user"></i>'+shipping_user);
		$('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>'+shipping_location);
		$('#shipping_phone').html('<i class="fas fa-phone"></i>'+shipping_phone);
		$('#shipping_email').html('<i class="fas fa-envelope"></i>'+shipping_email);

		$('#pills-step1-tab').addClass('active');
		$('#pills-step2-tab').addClass('active');
	});

	$('#final-btn').on('click',function(){
		ck = 1;
	})


	$('.payment').on('click',function(){
		if($(this).data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
		else if($(this).data('val') == 'voguepay'){
			$('.checkoutform').prop('id','voguepay');
		}
		else if($(this).data('val') == 'mercadopago'){
			$('.checkoutform').prop('id','mercadopago');
		}
		else {
			$('.checkoutform').prop('id','twocheckout');
		}
		$('.checkoutform').prop('action',$(this).data('form'));
		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
		$($(this).attr('href')).load($(this).data('href'));
	})
	
	
	
	$(document).on('click','.shipping',function(){
	    grandTotal();
	});
	
	$(document).on('click','.packing',function(){
	    grandTotal();
	});
	
	let extra = 0;
	function grandTotal(){
	    $('#grandTotal').val($('#preamount').val());
	    let total = parseFloat($('#grandTotal').val());
	    let shipping_charge = parseFloat($('.shipping:checked').attr('data'));
	    let packing_charge = parseFloat($('.packing:checked').attr('data'));
	    extra = shipping_charge + packing_charge;
	    total += shipping_charge + packing_charge;
	    $('.total_price').html(parseFloat(total).toFixed(2));
	    $('#grandTotal').val(parseFloat(total).toFixed(2))
	}


        $(document).on('submit','#step1-form',function(){
        	$('#preloader').hide();
            var val = $('#sub').val();
            var total = $('#grandTotal').val() ;
            
			total = Math.round(total);
                if(val == 0)
                {
                var handler = PaystackPop.setup({
                  key: '{{$gs->paystack_key}}',
                  email: $('input[name=email]').val(),
                  amount: total * 100,
                  currency: "{{ $curr->name }}",
                  ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                  callback: function(response){
                    $('#ref_id').val(response.reference);
                    $('#sub').val('1');
                    $('#final-btn').click();
                  },
                  onClose: function(){
                  	window.location.reload();
                  }
                });
                handler.openIframe();
                    return false;                    
                }
                else {
                	$('#preloader').show();
                    return true;   
                }
		});
		

		closedFunction=function() {
        alert('window closed');
    	}

     	successFunction=function(transaction_id) {
        alert('Transaction was successful, Ref: '+transaction_id)
    	}

     	failedFunction=function(transaction_id) {
         alert('Transaction was not successful, Ref: '+transaction_id)
    	}

</script>











