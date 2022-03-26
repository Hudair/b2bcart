



@if($payment == 'cod') 
<input type="hidden" name="method" value="Cash On Delivery">

@endif

@if($payment == 'ssl') 
<input type="hidden" name="method" value="SSLCommerz">

@endif


@if($payment == 'flutter') 
<input type="hidden" name="method" value="Flutter Wave">
@endif

@if($payment == 'paypal') 
<input type="hidden" name="method" value="Paypal">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="lc" value="UK">
<input type="hidden" name="currency_code" value="{{$curr->name}}">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
@endif


@if($payment == 'mercadopago')
<input type="hidden" name="method" value="mercadopago">

<div class="row">



<div class="col-lg-6">
<input class="form-control" type="text" placeholder="{{ __('Credit Card Number') }}" id="cardNumber" data-checkout="cardNumber" onselectstart="return false" autocomplete=off required />
</div>

<div class="col-lg-6">
<input class="form-control" type="text" id="securityCode" data-checkout="securityCode" placeholder="{{ __('Security Code') }}" onselectstart="return false" autocomplete=off required />
</div>

<div class="col-lg-6">
<input class="form-control" type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" placeholder="{{ __('Expiration Month') }}" autocomplete=off required />
</div>

<div class="col-lg-6">
<input class="form-control" type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" placeholder="{{ __('Expiration Year') }}" autocomplete=off required />
</div>

<div class="col-lg-6">
<input class="form-control" type="text" id="cardholderName" data-checkout="cardholderName" placeholder="{{ __('Card Holder Name') }}" required />
</div>
<div class="col-lg-6">
<select class="form-control" id="docType" data-checkout="docType" required>
</select>
</div>

<div class="col-lg-6">
<input class="form-control" type="text" id="docNumber" data-checkout="docNumber" placeholder="{{ __('Document Number') }}" required />
</div>

</div>


<input type="hidden" id="installments" value="1"/>
<input type="hidden" name="amount" id="amount"/>
<input type="hidden" name="description"/>
<input type="hidden" name="paymentMethodId" />


<script>

Mercadopago.setPublishableKey("{{$gs->mercado_publish_key}}");

function getBin() {
var ccNumber = document.querySelector('input[data-checkout="cardNumber"]');
return ccNumber.value.replace(/[ .-]/g, '').slice(0, 6);
};

function guessingPaymentMethod(event) {
var bin = getBin();

if (event.type == "keyup") {
if (bin.length >= 6) {
Mercadopago.getPaymentMethod({
"bin": bin
}, setPaymentMethodInfo);
}
} else {
setTimeout(function() {
if (bin.length >= 6) {
Mercadopago.getPaymentMethod({
"bin": bin
}, setPaymentMethodInfo);
}
}, 100);
}
};

Mercadopago.getIdentificationTypes();


function setPaymentMethodInfo(status, response) {
if (status == 200) {
// do somethings ex: show logo of the payment method
var form = document.querySelector('#mercadopago');

if (document.querySelector("input[name=paymentMethodId]") == null) {
var paymentMethod = document.createElement('input');
paymentMethod.setAttribute('name', "paymentMethodId");
paymentMethod.setAttribute('type', "hidden");
paymentMethod.setAttribute('value', response[0].id);

form.appendChild(paymentMethod);
} else {
document.querySelector("input[name=paymentMethodId]").value = response[0].id;
}
}
};

function addEvent(el, eventName, handler) {
if (el.addEventListener) {
el.addEventListener(eventName, handler);
} else {
el.attachEvent('on' + eventName, function(){
handler.call(el);
});
}
};

addEvent(document.querySelector('input[data-checkout="cardNumber"]'), 'keyup', guessingPaymentMethod);
addEvent(document.querySelector('input[data-checkout="cardNumber"]'), 'change', guessingPaymentMethod);

doSubmit = false;
addEvent(document.querySelector('#mercadopago'),'submit',doPay);
function doPay(event){
event.preventDefault();
if(!doSubmit){
var $form = document.querySelector('#mercadopago');

Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below

return false;
}
};
function sdkResponseHandler(status, response) {
console.log(response);

if (status != 200 && status != 201) {
alert("verify filled data");
}else{

var form = document.querySelector('#mercadopago');

var card = document.createElement('input');
card.setAttribute('name',"token");
card.setAttribute('type',"hidden");
card.setAttribute('value',response.id);
form.appendChild(card);
// doSubmit=true;
form.submit();
}
};
</script>

@endif



@if($payment == 'stripe') 
  <input type="hidden" name="method" value="Stripe">
  <div class="row" >
    <div class="col-lg-6">
      <input class="form-control card-elements" name="cardNumber" type="text" placeholder="{{ $langg->lang163 }}" autocomplete="off"  autofocus oninput="validateCard(this.value);" />
      <span id="errCard"></span>
    </div>
    <div class="col-lg-6">
      <input class="form-control card-elements" name="cardCVC" type="text" placeholder="{{ $langg->lang164 }}" autocomplete="off"  oninput="validateCVC(this.value);" />
      <span id="errCVC"></span>
    </div>
    <div class="col-lg-6">
      <input class="form-control card-elements" name="month" type="text" placeholder="{{ $langg->lang165 }}"  />
    </div>
    <div class="col-lg-6">
      <input class="form-control card-elements" name="year" type="text" placeholder="{{ $langg->lang166 }}"  />
    </div>
</div>


<script type="text/javascript" src="{{ asset('assets/front/js/payvalid.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/front/js/paymin.js') }}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="{{ asset('assets/front/js/payform.js') }}"></script>


<script type="text/javascript">
  var cnstatus = false;
  var dateStatus = false;
  var cvcStatus = false;

  function validateCard(cn) {
    cnstatus = Stripe.card.validateCardNumber(cn);
    if (!cnstatus) {
      $("#errCard").html('{{ $langg->lang781 }}');
    } else {
      $("#errCard").html('');
    }



  }

  function validateCVC(cvc) {
    cvcStatus = Stripe.card.validateCVC(cvc);
    if (!cvcStatus) {
      $("#errCVC").html('{{ $langg->lang782 }}');
    } else {
      $("#errCVC").html('');
    }

  }

</script>


@endif


@if($payment == 'instamojo') 
  <input type="hidden" name="method" value="Instamojo">

@endif


@if($payment == 'paystack') 

<input type="hidden" name="ref_id" id="ref_id" value="">
<input type="hidden" name="sub" id="sub" value="0">
<input type="hidden" name="method" value="Paystack">

@endif


@if($payment == 'voguepay') 

<input type="hidden" name="ref_id" id="ref_id" value="">
<input type="hidden" name="sub" id="sub" value="0">
<input type="hidden" name="method" value="Voguepay">

@endif


@if($payment == 'razorpay') 

  <input type="hidden" name="method" value="Razorpay">

@endif

@if($payment == 'molly') 
  <input type="hidden" name="method" value="Molly">

@endif


@if($payment == 'authorize.net') 
  <input type="hidden" name="method" value="Authorize.Net">


  <div class="row" >
    <div class="col-lg-6">
      <input class="form-control" name="cardNumber" type="text" placeholder="{{ $langg->lang163 }}" autocomplete="off"/>
    </div>
    <div class="col-lg-6">
      <input class="form-control" name="cardCode" type="text" placeholder="{{ __('CVV') }}" autocomplete="off"/>
    </div>
    <div class="col-lg-6">
      <input class="form-control" name="month" type="text" placeholder="{{ $langg->lang165 }}"  />
    </div>
    <div class="col-lg-6">
      <input class="form-control" name="year" type="text" placeholder="{{ $langg->lang808 }}"  />
    </div>
</div>

@endif
@if($payment == 'twocheckout') 



<input type="hidden" name="method" value="2Checkout">

<input id="token" name="token" type="hidden" value="">

<div class="row" >
  <div class="col-lg-6">
    <input class="form-control" id="ccNo" name="cardNumber" type="text" placeholder="{{ $langg->lang163 }}" autocomplete="off" />
  </div>
  <div class="col-lg-6">
    <input class="form-control" id="cvv" name="cardCVC" type="text" placeholder="{{ $langg->lang164 }}" autocomplete="off" />
  </div>
  <div class="col-lg-6">
    <input class="form-control" id="expMonth" name="month" type="text" placeholder="{{ $langg->lang165 }}"  />
  </div>
  <div class="col-lg-6">
    <input class="form-control" id="expYear" name="year" type="text" placeholder="{{ $langg->lang808 }}"  />
  </div>
</div>


<script type="application/javascript">
$(function ($) {
"use strict";

  // Called when token created successfully.
  var successCallback = function(data) {
   
      var myForm = document.getElementById('twocheckout');

      // Set the token as the value for the token input
      myForm.token.value = data.response.token.token;
      console.log(data.response.token.token);

      // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
      myForm.submit();
  };

  // Called when token creation fails.
  var errorCallback = function(data) {
      if (data.errorCode === 200) {tokenRequest();} else {alert(data.errorMsg);}
  };

  var tokenRequest = function() {
      // Setup token request arguments
      var args = {
          sellerId: "{{ $gs->twocheckout_seller_id }}",
          publishableKey: "{{ $gs->twocheckout_public_key }}",
          ccNo: $("#ccNo").val(),
          cvv: $("#cvv").val(),
          expMonth: $("#expMonth").val(),
          expYear: $("#expYear").val()
      };

      // Make the token request
      TCO.requestToken(successCallback, errorCallback, args);
      
  };
   
      
  $(function() {
      // Pull in the public encryption key for our environment
      @if($gs->twocheckout_sandbox_check == 1)
      TCO.loadPubKey('sandbox');
      @else 
      TCO.loadPubKey('production');
      @endif

      $(".checkoutform").submit(function(e) {
          // Call our token request function
          tokenRequest();

          // Prevent form from submitting
          return false;
      });
  });


});

</script>

@endif



@if($payment == 'other') 

<input type="hidden" name="method" value="{{ $gateway->title }}">

  <div class="row" >

<div class="col-lg-12 pb-2">

{!! $gateway->details !!}

</div>


<div class="col-lg-6">
<label>{{ $langg->lang167 }} *</label>
<input class="form-control" name="txn_id4" type="text" placeholder="{{ $langg->lang167 }}"  />
</div>


</div>
@endif