@extends('layouts.admin') 

@section('content')  
					<input type="hidden" id="headerdata" value="{{ __('FAQ') }}">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __('Faq') }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
											</li>
											<li>
												<a href="javascript:;">{{ __('Menu Page Settings') }} </a>
											</li>
											<li>
												<a href="{{ route('admin-faq-index') }}">{{ __('Faq') }}</a>
											</li>
										</ul>
								</div>
							</div>
						</div>
						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
								<div class="heading-area">
									<h4 class="title">
										{{ __('Faq Page') }} :
									</h4>
	                                <div class="action-list">
	                                    <select class="process select droplinks {{ $gs->is_faq == 1 ? 'drop-success' : 'drop-danger' }}">
	                                      <option data-val="1" value="{{route('admin-gs-isfaq',1)}}" {{ $gs->is_faq == 1 ? 'selected' : '' }}>{{ __('Activated') }}</option>
	                                      <option data-val="0" value="{{route('admin-gs-isfaq',0)}}" {{ $gs->is_faq == 0 ? 'selected' : '' }}>{{ __('Deactivated') }}</option>
	                                    </select>
	                                  </div>
								</div>
									<div class="mr-table allproduct">
										@include('includes.admin.form-success') 
										<div class="table-responsiv">
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th width="30%">{{ __('Faq Title') }}</th>
									                        <th width="50%">{{ __('Faq Details') }}</th>
									                        <th>{{ __('Options') }}</th>
														</tr>
													</thead>
												</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

{{-- ADD / EDIT MODAL --}}

				<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
										
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
												<div class="submit-loader">
														<img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
												</div>
											<div class="modal-header">
											<h5 class="modal-title"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">

											</div>
											<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
											</div>
						</div>
					</div>

				</div>

{{-- ADD / EDIT MODAL ENDS --}}


{{-- DELETE MODAL --}}

<div class="modal fade" id="confirm-delete">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header text-center">
        <h4 class="modal-title w-100">{{ __('Confirm Delete') }}</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center">{{ __('You are about to delete this Faq.') }}</p>
            <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- DELETE MODAL ENDS --}}

@endsection    



@section('scripts')

{{-- DATA TABLE --}}


    <script type="text/javascript">

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('admin-faq-datatables') }}',
               columns: [
                        { data: 'title', name: 'title' },
                        { data: 'details', name: 'details' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],
               language : {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                }
            });

      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 text-right">'+
        	'<a class="add-btn" href="{{route('admin-faq-create')}}">'+
          '<i class="fas fa-plus"></i> {{ __('Add New Faq') }}'+
          '</a>'+
          '</div>');
      });												
									
    </script>

{{-- DATA TABLE --}}
    
@endsection   