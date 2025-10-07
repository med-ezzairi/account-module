@extends('account::layouts.master')
@section('account')
<?php 
$trans_prefix       = 'account::account_group.global.';
$tooltip_users      = __($trans_prefix.'tooltip_users');
$tooltip_show       = __($trans_prefix.'tooltip_show');
$tooltip_edit       = __($trans_prefix.'tooltip_edit');
$tooltip_delete     = __($trans_prefix.'tooltip_delete');
?>
<div class="elements search">
	
	<div class="panel panel-primary">
		<div class="panel-heading">
    		<div class="panel-title">
    			 {{ __($trans_prefix.'action_list') }}
    			 
    			 <div class="pull-right">
    			 	<a class="btn btn-success btn-panel-header_" href="#" id="btn_item_create"> @fas(plus-circle) {{ __($trans_prefix.'action_create') }}</a>
    			 </div>
    			 
    		</div>
    	</div>
		<div class="panel-body">
			
			@if( !isset( $items ) || !$items->count() > 0 )
        	<div class="form-group col-md-12">
        		<div class="alert alert-info">
        			@fas(info-circle fa-lg) {{ __($trans_prefix.'no_item_found') }}
        		</div>
        	</div>
        	@else
        	<div class="table-responsive">
			<table class="table comission-table table-bordered table-responsive-md text-center">
				<tr>
					<th width="" class="text-center">{{ __($trans_prefix.'libelle') }}</th>
					<th width="20%" class="text-center">{{ __($trans_prefix.'users_count') }}</th>
					<th width="20%" class="text-center">{{ __($trans_prefix.'permissions_count') }}</th>
					<th width="20%" class="text-center">&nbsp;</th>
				</tr>
				
				@foreach( $items as $item )
		        <tr class="item-{{ $item->id }}" data-id="{{ $item->id }}">
					<td class="text-left">{{ $item->name }}</td>
					<td class="text-right">{{ $item->users_count }}</td>
					<td class="text-right">{{ $item->permissions_count }}</td>
					<td>
						<a title="{{ $tooltip_users }}" href="{{ route( 'account.groups.show', $item->id ) }}">@fas('users-cog fa-lg')</a> | 
						<a title="{{ $tooltip_edit }}" href="#" class="btn_item_edit">@fas('edit fa-lg')</a> | 
						@if( $item->users_count == 0 )
							<a title="{{ $tooltip_delete }}" href="#" class="btn_item_delete">@fas('trash-alt fa-lg')</a>
						@else
							@fas(trash-alt fa-lg,gray)
						@endif
					</td>
				</tr>
				@endforeach
			</table>
			<div class="paginator text-ltr pull-right">{{ $items->links() }}</div>
			</div>
        	@endif
	 	</div>
 	</div>
</div>
@include('account::groups.modal-create')
@endsection
@section('script')
<script type="text/javascript">
$(function() {

	//-- add
	$('#btn_item_create').click(function(evt){
		evt.preventDefault()
		let modal = '.modal#item-add';
		$(modal).find('input#id').val('')
		$(modal).find('input#name').val('')
		$(modal).modal('show')
		
	});
	//-- edit
	$('.btn_item_edit').click(function(evt){
		evt.preventDefault()
		let tr = $(this).closest('tr');
		let modal = '.modal#item-add';
		$(modal).find('input#id').val($(tr).data('id'))
		$(modal).find('input#name').val($(tr).find('td:eq(0)').text())
		$(modal).modal('show')
		
	});
	
});
</script>
@endsection