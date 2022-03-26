@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
                <div class="col-lg-8">
<div class="user-profile-details">
                        
<div class="account-info">
                            <div class="header-area">
                                <h4 class="title">
                                    {{ $langg->lang409 }} <a class="mybtn1" href="{{route('user-package')}}"> <i class="fas fa-arrow-left"></i> {{ $langg->lang410 }}</a>
                                </h4>
                            </div>
                            <div class="pack-details">
                                <div class="row">

                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            {{ $langg->lang411 }}
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{$subs->title}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            {{ $langg->lang412 }}
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{$subs->convertedPrice($subs->price)}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            {{ $langg->lang413 }}
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{$subs->days}} {{ $langg->lang403 }}
                                    </p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            {{ $langg->lang414 }}
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{ $subs->allowed_products == 0 ? 'Unlimited':  $subs->allowed_products}}
                                        </p>
                                    </div>
                                </div>

                                        @if(!empty($package))
                                            @if($package->subscription_id != $subs->id)
                                <div class="row">
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-8">
                                        <span class="notic"><b>{{ $langg->lang415 }}</b> {{ $langg->lang416 }}</span>
                                    </div>
                                </div>

                                <br>
                                            @else
                                <br>

                                            @endif
                                        @else
                                <br>
                                        @endif

                                        <form id="subscribe-form" class="pay-form" action="{{route('user-vendor-request-submit')}}" method="POST">

                            @include('includes.form-success')
                            @include('includes.form-error')
                            @include('includes.admin.form-error') 
                                            
                                            {{ csrf_field() }}


                                        @if($user->is_vendor == 0)

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang238 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text"  id="shop-name" class="option" name="shop_name" placeholder="{{ $langg->lang238 }}" required>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang239 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="owner_name" placeholder="{{ $langg->lang239 }}" required>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang240 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="shop_number" placeholder="{{ $langg->lang240 }}" required>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang241 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="shop_address" placeholder="{{ $langg->lang241 }}" required>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang242 }} <small>{{ $langg->lang417 }}</small>
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="reg_number" placeholder="{{ $langg->lang242 }}">
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang243 }} <small>{{ $langg->lang417 }}</small>
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                <textarea class="option" name="shop_message" placeholder="{{ $langg->lang243 }}" rows="5"></textarea>
                                            </div>
                                        </div>

                                        <br>


                                        @endif
                                        <input type="hidden" name="subs_id" value="{{ $subs->id }}">

                                 @if($subs->price != 0)       

                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title pt-1">
                                            {{ $langg->lang418 }} *
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">

                                            <select name="method" id="option" onchange="meThods(this)" class="option" required="">
                                                <option value="">{{ $langg->lang419 }}</option>
                                                @if($gs->paypal_check == 1)
                                                    <option value="Paypal">{{ $langg->lang420 }}</option>
                                                @endif
                                                @if($gs->stripe_check == 1)
                                                    <option value="Stripe">{{ $langg->lang421 }}</option>
                                                @endif
                                                @if($gs->is_instamojo == 1)
                                                    <option value="Instamojo">{{ $langg->lang763 }}</option>
                                                @endif
                                                @if($gs->is_paystack == 1)
                                                    <option value="Paystack">{{ $langg->lang764 }}</option>
                                                @endif
                                                @if($gs->is_molly == 1)
                                                    <option value="Molly">{{ $langg->lang802 }}</option>
                                                @endif
                                                @if($gs->is_paytm == 1)
                                                    <option value="Paytm">{{ $langg->paytm }}</option>
                                                @endif
                                                @if($gs->is_razorpay == 1)
                                                    <option value="Razorpay">{{ $langg->razorpay }}</option>
                                                @endif
                                            </select>

                                    </div>
                                </div>


                                            <div id="stripes" style="display: none;">

                                    <br>



                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang422 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="card" id="scard" placeholder="{{ $langg->lang422 }}">
                                            </div>
                                        </div>

                                    <br>


                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang423 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="cvv" id="scvv" placeholder="{{ $langg->lang423 }}">
                                            </div>
                                        </div>

                                    <br>


                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang424 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="month" id="smonth" placeholder="{{ $langg->lang424 }}">
                                            </div>
                                        </div>


                                    <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    {{ $langg->lang425 }} *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="year" id="syear" placeholder="{{ $langg->lang425 }}">
                                            </div>
                                        </div>

                                            </div>
                                            <div id="paypals">
                                                <input type="hidden" name="cmd" value="_xclick">
                                                <input type="hidden" name="no_note" value="1">
                                                <input type="hidden" name="lc" value="UK">
                                                <input type="hidden" name="currency_code" value="{{strtoupper($subs->currency_code)}}">
                                                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
                                                <input type="hidden" name="ref_id" id="ref_id" value="">
                                                <input type="hidden" name="sub" id="sub" value="0">
                                                <input type="hidden" name="ck" id="ck" value="0">
                                            </div>

                                @endif
                                <div class="row">
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-8">
                                            <button type="submit" id="final-btn" class="mybtn1">{{ $langg->lang426 }}</button>
                                    </div>
                                </div>




                                 </form>



                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </div>
  </section>

@endsection



@section('scripts')

<script src="https://js.paystack.co/v1/inline.js"></script>

<script type="text/javascript">
    
        $(document).on('submit','#paystack-form',function(e){
            var val = $('#sub').val();
                if(val == 0)
                {            
                    $.get('{{ route('user.paystack.check').'?shop_name=' }}'+$('#shop-name').val(), function(data, status){


                          if ((data.errors)) {

                          $('.alert-danger').show();
                          $('.alert-danger ul').html('');
                            for(var error in data.errors)
                            {
                              $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>');
                              $('#sub').val('0');
                              $('#ck').val('1');
                            }

                          }
                          else {
                            $('#ck').val('0');
                          }

              

                    });

setTimeout(function(){ 

if($('#ck').val() == '0') {

                            $('#preloader').hide();

                            var total = {{$subs->price}};

                                var handler = PaystackPop.setup({
                                  key: '{{$gs->paystack_key}}',
                                  email: '{{$user->email}}',
                                  amount: total * 100,
                                  currency: "{{strtoupper($curr->name)}}",
                                  ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                                  callback: function(response){
                                    $('#ref_id').val(response.reference);
                                    $('#sub').val('1');
                                    $('#final-btn').click();
                                  },
                                  onClose: function(){
                                  }
                                });
                                handler.openIframe();
                                    return false;    



}



 }, 1000);
  



                                    return false;

                }


                            else {
                                $('#preloader').show();
                                return true;   
                            }


        });

</script>


@if($subs->price != 0)
<script type="text/javascript">
        function meThods(val) {
            var action1 = "{{route('user.paypal.submit')}}";
            var action2 = "{{route('user.stripe.submit')}}";
            var action3 = "{{route('user.instamojo.submit')}}";
            var action4 = "{{route('user.paystack.submit')}}";
            var action5 = "{{route('user.molly.submit')}}";
            var action6 = "{{route('user.paytm.submit')}}";
            var action7 = "{{route('user.razorpay.submit')}}";

             if (val.value == "Paypal") {
               $('.pay-form').attr('id','subscribe-form');
                $(".pay-form").attr("action", action1);
                $("#scard").prop("required", false);
                $("#scvv").prop("required", false);
                $("#smonth").prop("required", false);
                $("#syear").prop("required", false);
                $("#stripes").hide();

            }
            else if (val.value == "Instamojo") {
               $('.pay-form').attr('id','subscribe-form');
                $(".pay-form").attr("action", action3);
                $("#scard").prop("required", false);
                $("#scvv").prop("required", false);
                $("#smonth").prop("required", false);
                $("#syear").prop("required", false);
                $("#stripes").hide();
            }

            else if (val.value == "Molly") {
               $('.pay-form').attr('id','subscribe-form');
                $(".pay-form").attr("action", action5);
                $("#scard").prop("required", false);
                $("#scvv").prop("required", false);
                $("#smonth").prop("required", false);
                $("#syear").prop("required", false);
                $("#stripes").hide();
            }

            else if (val.value == "Paytm") {
               $('.pay-form').attr('id','subscribe-form');
                $(".pay-form").attr("action", action6);
                $("#scard").prop("required", false);
                $("#scvv").prop("required", false);
                $("#smonth").prop("required", false);
                $("#syear").prop("required", false);
                $("#stripes").hide();
            }

            else if (val.value == "Razorpay") {
               $('.pay-form').attr('id','subscribe-form');
                $(".pay-form").attr("action", action7);
                $("#scard").prop("required", false);
                $("#scvv").prop("required", false);
                $("#smonth").prop("required", false);
                $("#syear").prop("required", false);
                $("#stripes").hide();
            }

            else if (val.value == "Paystack") {
               $('.pay-form').attr('id','paystack-form');
                $(".pay-form").attr("action", action4);
                $("#scard").prop("required", false);
                $("#scvv").prop("required", false);
                $("#smonth").prop("required", false);
                $("#syear").prop("required", false);
                $("#stripes").hide();
            }

            else if (val.value == "Stripe") {
               $('.pay-form').attr('id','subscribe-form');
                $(".pay-form").attr("action", action2);
                $("#scard").prop("required", true);
                $("#scvv").prop("required", true);
                $("#smonth").prop("required", true);
                $("#syear").prop("required", true);
                $("#stripes").show();
            }
        }    
</script>
@endif

<script type="text/javascript">
    
$(document).on('submit','#subscribe-form',function(){
     $('#preloader').show();
});
    
</script>

@endsection