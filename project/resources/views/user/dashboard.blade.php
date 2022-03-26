@extends('layouts.front')
@section('content')


<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
          @include('includes.form-success')
          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="user-profile-details">
                <div class="account-info">
                  <div class="header-area">
                    <h4 class="title">
                      {{ $langg->lang208 }}
                    </h4>
                  </div>
                  <div class="edit-info-area">
                  </div>
                  <div class="main-info">
                    <h5 class="title">{{ $user->name }}</h5>
                    <ul class="list">
                      <li>
                        <p><span class="user-title">{{ $langg->lang209 }}:</span> {{ $user->email }}</p>
                      </li>
                      @if($user->phone != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang210 }}:</span> {{ $user->phone }}</p>
                      </li>
                      @endif
                      @if($user->fax != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang211 }}:</span> {{ $user->fax }}</p>
                      </li>
                      @endif
                      @if($user->city != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang212 }}:</span> {{ $user->city }}</p>
                      </li>
                      @endif
                      @if($user->zip != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang213 }}:</span> {{ $user->zip }}</p>
                      </li>
                      @endif
                      @if($user->address != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang214 }}:</span> {{ $user->address }}</p>
                      </li>
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        
            <div class="col-lg-6">
              <div class="user-profile-details h100">
                <div class="account-info wallet h100">
                  <div class="header-area">
                    <h4 class="title">
                      {{ isset($langg->lang812) ? $langg->lang812 : 'My Balance' }}
                    </h4>
                  </div>
                  <div class="edit-info-area">
                  </div>
                  <div class="main-info">
                    <h3 class="title w-title">{{ $langg->lang215 }}:</h3>
                    <h3 class="title w-price">{{ App\Models\Product::vendorConvertPrice($user->affilate_income) }}</h3>
                  </div>
                </div>
              </div>
            </div>
        </div>


        <div class="row row-cards-one mb-3">
          <div class="col-md-6 col-xl-6">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                  <p>{{ Auth::user()->orders()->where('status','completed')->count() }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ isset($langg->lang809) ? $langg->lang809 : 'Total Orders' }}</h6>
                    <p class="text">{{ isset($langg->lang811) ? $langg->lang811 : 'All Time' }}</p>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-xl-6">
              <div class="card c-info-box-area">
                  <div class="c-info-box box1">
                      <p>{{ Auth::user()->orders()->where('status','pending')->count() }}</p>
                  </div>
                  <div class="c-info-box-content">
                      <h6 class="title">{{ isset($langg->lang810) ? $langg->lang810 : 'Pending Orders' }}</h6>
                      <p class="text">{{ isset($langg->lang811) ? $langg->lang811 : 'All Time' }}</p>
                  </div>
              </div>
          </div>
      </div>

        <div class="row">
        <div class="col-lg-12">
          <div class="user-profile-details">
            <div class="account-info wallet">
              <div class="header-area">
                <h4 class="title">
                  {{ isset($langg->lang808) ? $langg->lang808 : 'Recent Orders' }}
                </h4>
              </div>
              <div class="edit-info-area">
              </div>
              <div class="main-info">
                <div class="mr-table allproduct mt-4">
									<div class="table-responsiv">
											<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>{{ $langg->lang278 }}</th>
														<th>{{ $langg->lang279 }}</th>
														<th>{{ $langg->lang280 }}</th>
														<th>{{ $langg->lang281 }}</th>
														<th>{{ $langg->lang282 }}</th>
													</tr>
												</thead>
												<tbody>
													 @foreach(Auth::user()->orders()->latest()->take(5)->get() as $order)
													<tr>
														<td>
																{{$order->order_number}}
														</td>
														<td>
																{{date('d M Y',strtotime($order->created_at))}}
														</td>
														<td>
																{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
														</td>
														<td>
															<div class="order-status {{ $order->status }}">
																	{{ucwords($order->status)}}
															</div>
														</td>
														<td>
															<a class="mybtn2 sm" href="{{route('user-order',$order->id)}}">
																	{{ $langg->lang283 }}
															</a>
														</td>
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
    </div>
  </section>



@endsection