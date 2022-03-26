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
							<a href="{{ route('user-wishlists') }}">
								{{ $langg->lang168 }}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<!-- Breadcrumb Area End -->

<!-- Wish List Area Start -->
	<section class="sub-categori wish-list">
		<div class="container">

			@if(count($wishlists))
			<div class="right-area">
				@include('includes.filter')
			<div id="ajaxContent">
			<div class="row wish-list-area">

				@foreach($wishlists as $wishlist)

				@if(!empty($sort))


				<div class="col-lg-6">
					<div class="single-wish">
						<span class="remove wishlist-remove" data-href="{{ route('user-wishlist-remove', App\Models\Wishlist::where('user_id','=',$user->id)->where('product_id','=',$wishlist->id)->first()->id ) }}"><i class="fas fa-times"></i></span>
						<div class="left">
							<img src="{{ $wishlist->photo ? asset('assets/images/products/'.$wishlist->photo):asset('assets/images/noimage.png') }}" alt="">
						</div>
						<div class="right">
							<h4 class="title">
								<a href="{{ route('front.product', $wishlist->slug) }}">
								{{ $wishlist->name }}
								</a>
							</h4>
							<ul class="stars">
                                <div class="ratings">
                                    <div class="empty-stars"></div>
                                   	<div class="full-stars" style="width:{{App\Models\Rating::ratings($wishlist->id)}}%"></div>
                                </div>
							</ul>
							<div class="price">
								{{ $wishlist->showPrice() }}<small><del>{{ $wishlist->showPreviousPrice() }}</del></small>
							</div>
						</div>
					</div>
				</div>

				@else

				<div class="col-lg-6">
					<div class="single-wish">
						<span class="remove wishlist-remove" data-href="{{ route('user-wishlist-remove',$wishlist->id) }}"><i class="fas fa-times"></i></span>
						<div class="left">
							<img src="{{ $wishlist->product->photo ? asset('assets/images/products/'.$wishlist->product->photo):asset('assets/images/noimage.png') }}" alt="">
						</div>
						<div class="right">
							<h4 class="title">
						<a href="{{ route('front.product', $wishlist->product->slug) }}">
							{{ $wishlist->product->name }}
						</a>
							</h4>
							<ul class="stars">
                                <div class="ratings">
                                    <div class="empty-stars"></div>
                                   	<div class="full-stars" style="width:{{App\Models\Rating::ratings($wishlist->product->id)}}%"></div>
                                </div>
							</ul>
							<div class="price">
								{{ $wishlist->product->showPrice() }}<small><del>{{ $wishlist->product->showPreviousPrice() }}</del></small>
							</div>
						</div>
					</div>
				</div>

				@endif
				@endforeach

			</div>

			<div class="page-center category">
				{{ $wishlists->appends(['sort' => $sort])->links() }}
			</div>


			</div>
		</div>
			@else

			<div class="page-center">
				<h4 class="text-center">{{ $langg->lang60 }}</h4>
			</div>

			@endif

		</div>
	</section>
<!-- Wish List Area End -->

@endsection

@section('scripts')

<script type="text/javascript">
        $("#sortby").on('change',function () {
        var sort = $("#sortby").val();
        window.location = "{{url('/user/wishlists')}}?sort="+sort;
    	});
</script>

@endsection
