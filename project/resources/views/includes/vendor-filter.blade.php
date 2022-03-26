						<div class="item-filter">

							<ul class="filter-list">
								<li class="item-short-area">
										<p>{{$langg->lang64}} :</p>
										<form id="sortForm" class="d-inline-block" action="{{ route('front.vendor', Request::route('category')) }}" method="get">
											@if (!empty(request()->input('min')))
												<input type="hidden" name="min" value="{{ request()->input('min') }}">
											@endif
											@if (!empty(request()->input('max')))
												<input type="hidden" name="max" value="{{ request()->input('max') }}">
											@endif
											<select id name="sort" class="short-item" onchange="document.getElementById('sortForm').submit()">
		                    <option value="date_desc" {{ request()->input('sort') == 'date_desc' ? 'selected' : '' }}>{{$langg->lang65}}</option>
		                    <option value="date_asc" {{ request()->input('sort') == 'date_asc' ? 'selected' : '' }}>{{$langg->lang66}}</option>
		                    <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>{{$langg->lang67}}</option>
		                    <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>{{$langg->lang68}}</option>
											</select>
										</form>
								</li>
							</ul>
						</div>
