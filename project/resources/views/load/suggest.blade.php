@foreach($prods as $prod)
@php
	$attrPrice = 0;
	$sessionCur = session()->get('currency');
	$sessionCurr = DB::table('currencies')->where('id',$sessionCur)->first();
	$databaseCurr = DB::table('currencies')->where('is_default',1)->first();
	$curr = $sessionCurr ? $sessionCurr: $databaseCurr;

	if($prod->user_id != 0){
        $attrPrice = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }

    if(!empty($prod->size) && !empty($prod->size_price)){
          $attrPrice += $prod->size_price[0];
      }

      if(!empty($prod->attributes)){
        $attrArr = json_decode($prod->attributes, true);
      }
@endphp

@if (!empty($prod->attributes))
	@php
	$attrArr = json_decode($prod->attributes, true);
	@endphp
	@endif

	@if (!empty($attrArr))
		@foreach ($attrArr as $attrKey => $attrVal)
			@if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)
				@foreach ($attrVal['values'] as $optionKey => $optionVal)
				@if ($loop->first)
					@if (!empty($attrVal['prices'][$optionKey]))
						@php
							$attrPrice = $attrPrice + $attrVal['prices'][$optionKey] * $curr->value;
						@endphp
					@endif
				@endif
			@endforeach
		@endif
	@endforeach
@endif

@php
  $withSelectedAtrributePrice = $attrPrice;
  $withSelectedAtrributePrice = round(($withSelectedAtrributePrice) * $curr->value,2);


@endphp
	<div class="docname">
		<a href="{{ route('front.product', $prod->slug) }}">
			<img src="{{ asset('assets/images/thumbnails/'.$prod->thumbnail) }}" alt="">
			<div class="search-content">
				<p>{!! mb_strlen($prod->name,'utf-8') > 66 ? str_replace($slug,'<b>'.$slug.'</b>',mb_substr($prod->name,0,66,'utf-8')).'...' : str_replace($slug,'<b>'.$slug.'</b>',$prod->name)  !!} </p>
				<span style="font-size: 14px; font-weight:600; display:block;">{{ $attrPrice != 0 ?  $gs->currency_format == 0 ? $curr->sign.$withSelectedAtrributePrice : $withSelectedAtrributePrice.$curr->sign :$prod->showPrice() }}</span>
			</div>
		</a>
	</div> 
@endforeach