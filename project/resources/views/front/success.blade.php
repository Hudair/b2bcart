@extends('layouts.front')




@section('content')

<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="pages">
          <li>
            <a href="{{ route('front.index') }}">
              {{ $langg->lang17 }}
            </a>
          </li>
          <li>
            <a href="{{ route('payment.return') }}">
              {{ $langg->lang169 }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumb Area End -->







<section class="tempcart">

@if(!empty($tempcart))

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="content-box section-padding add-product-1">
                        <div class="top-area">
                                <div class="content">
                                    <h4 class="heading">
                                        {{ $langg->order_title }}
                                    </h4>
                                    <p class="text">
                                        {{ $langg->order_text }}
                                    </p>
                                    <a href="{{ route('front.index') }}" class="link">{{ $langg->lang170 }}</a>
                                  </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">

                                    <div class="product__header">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-12">
                                                <div class="product-header-title">
                                                    <h2>{{ $langg->lang285 }} {{$order->order_number}}</h2>
                                        </div>   
                                    </div>
                                        @include('includes.form-success')
                                            <div class="col-md-12" id="tempview">
                                                <div class="dashboard-content">
                                                    <div class="view-order-page" id="print">
                                                        <p class="order-date">{{ $langg->lang301 }} {{date('d-M-Y',strtotime($order->created_at))}}</p>


@if($order->dp == 1)

                                                        <div class="billing-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>{{ $langg->lang287 }}</h5>
                                                                    <address>
                                                                        {{ $langg->lang288 }} {{$order->customer_name}}<br>
                                                                        {{ $langg->lang289 }} {{$order->customer_email}}<br>
                                                                        {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                                                                        {{ $langg->lang291 }} {{$order->customer_address}}<br>
                                                                        {{$order->customer_city}}-{{$order->customer_zip}}
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>{{ $langg->lang292 }}</h5> 
                                                                    @if ($order->whole_discount != 0)
                                                                    <p>Whole sell Discount : {{$order->currency_sign}} {{round($order->whole_discount * $order->currency_value , 2)}} </p>
                                                                    @endif
                                                                    <p>{{ $langg->lang293 }} {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</p>
                                                                    <p>{{ $langg->lang294 }} {{$order->method}}</p>

                                                                    @if($order->method != "Cash On Delivery")
                                                                        @if($order->method=="Stripe")
                                                                            {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}</p>
                                                                        @endif
                                                                        {{$order->method}} {{ $langg->lang296 }} <p id="ttn">{{$order->txnid}}</p>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

@else
                                                        <div class="shipping-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @if($order->shipping == "shipto")
                                                                        <h5>{{ $langg->lang302 }}</h5>
                                                                        <address>
                {{ $langg->lang288 }} {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                {{ $langg->lang289 }} {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                {{ $langg->lang290 }} {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                {{ $langg->lang291 }} {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
{{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                                                        </address>
                                                                    @else
                                                                        <h5>{{ $langg->lang303 }}</h5>
                                                                        <address>
                                                                            {{ $langg->lang304 }} {{$order->pickup_location}}<br>
                                                                        </address>
                                                                    @endif

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>{{ $langg->lang305 }}</h5>
                                                                    @if($order->shipping == "shipto")
                                                                        <p>{{ $langg->lang306 }}</p>
                                                                    @else
                                                                        <p>{{ $langg->lang307 }}</p>
                                                                    @endif
                                                                    @if($order->shipping_cost != 0)
                                                                        @php 
                                                                        $price = round(($order->shipping_cost / $order->currency_value),2);
                                                                        @endphp
                                                                        @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                                                                <p>
                                                                    {{ DB::table('shippings')->where('price','=',$price)->first()->title }}: {{$order->currency_sign}}{{ round($order->shipping_cost, 2) }}
                                                                </p>
                                                                        @endif
                                                                    @endif

                                                                    @if($order->packing_cost != 0)

                                                                        @php 
                                                                        $pprice = round(($order->packing_cost / $order->currency_value),2);
                                                                        @endphp


                                                                        @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                                                                <p>
                                                                    {{ DB::table('packages')->where('price','=',$pprice)->first()->title }}: {{$order->currency_sign}}{{ round($order->packing_cost, 2) }}
                                                                </p>
                                                                        @endif
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="billing-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>{{ $langg->lang287 }}</h5>
                                                                    <address>
                                                                        {{ $langg->lang288 }} {{$order->customer_name}}<br>
                                                                        {{ $langg->lang289 }} {{$order->customer_email}}<br>
                                                                        {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                                                                        {{ $langg->lang291 }} {{$order->customer_address}}<br>
                                                                        {{$order->customer_city}}-{{$order->customer_zip}}
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>{{ $langg->lang292 }}</h5>
                                                                     @if ($order->whole_discount != 0)
                                                                    <p>Whole sell Discount : {{$order->currency_sign}} {{round($order->whole_discount * $order->currency_value , 2)}} </p>
                                                                    @endif
                                                                    <p>{{ $langg->lang293 }} {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</p>
                                                                    <p>{{ $langg->lang294 }} {{$order->method}}</p>

                                                                    @if($order->method != "Cash On Delivery")
                                                                        @if($order->method=="Stripe")
                                                                            {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}</p>
                                                                        @endif
                                                                        @if($order->method=="Paypal")
                                                                        {{$order->method}} {{ $langg->lang296 }} <p id="ttn">{{ isset($_GET['tx']) ? $_GET['tx'] : '' }}</p>
                                                                        @else
                                                                        {{$order->method}} {{ $langg->lang296 }} <p id="ttn">{{$order->txnid}}</p>
                                                                        @endif

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <br>
                                                        <div class="table-responsive">
                            <table  class="table">
                                <h4 class="text-center">{{ $langg->lang308 }}</h4>
                                <thead>
                                <tr>

                                    <th width="60%">{{ $langg->lang310 }}</th>
                                    <th width="20%">{{ $langg->lang539 }}</th>
                                    <th width="10%">{{ $langg->lang314 }}</th>
                                    <th width="10%">{{ $langg->lang315 }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($tempcart['items'] as $product)
                                    <tr>

                                            <td>{{ $product['item']['name'] }}</td>
                                            <td>
                                                <b>{{ $langg->lang311 }}</b>: {{$product['qty']}} <br>
                                                @if(!empty($product['size']))
                                                <b>{{ $langg->lang312 }}</b>: {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}} <br>
                                                @endif
                                                @if(!empty($product['color']))
                                                <div class="d-flex mt-2">
                                                <b>{{ $langg->lang313 }}</b>:  <span id="color-bar" style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                                                </div>
                                                @endif

                                                    @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} <br>
                                                    @endforeach

                                                    @endif

                                                  </td>
                                            <td>{{$order->currency_sign}}{{round($product['item_price'] * $order->currency_value,2)}}</td>
                                            <td>{{$order->currency_sign}}{{round($product['price'] * $order->currency_value,2)}}</td>

                                    </tr>
                                @endforeach



                                </tbody>
                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>

@endif

  </section>

@endsection