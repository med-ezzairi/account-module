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
		<div class="panel-body">
			
			{{-- 
			<div class="list-group">
				<div class="list-group-item">{{ __($trans_prefix.'action_show').': '.$group->name }}</div>
				<div class="list-group-item">{{ __($trans_prefix.'action_show').': '.$group->name }}</div>
				<div class="list-group-item">{{ __($trans_prefix.'action_show').': '.$group->name }}</div>
			</div>
			 --}}
			<h2>{{ __($trans_prefix.'libelle').': '.$item->name }}</h2>
	 	</div>
 	</div>
</div>
<div class="row">
	<ul class="nav nav-tabs">
		<li role="presentation" class="{{ $element=='permissions' ? 'active':'' }}">
			<a href="{{ route('account.groups.show', $item->id) }}">{{ __($trans_prefix.'permissions') }}</a>
		</li>
		<li role="presentation" class="{{ $element=='members' ? 'active':'' }}">
			<a href="{{ route('account.groups.show', [$item->id, 'element' => 'members'])  }}">{{ __($trans_prefix.'members') }}</a>
		</li>
	</ul>
	<div class="tab-content" style="padding-top: 15px;">
		@includeIf( 'account::groups.show-'.$element )
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(function() {

	//-- group-add
	$('#btn_item_create').click(function(evt){
		evt.preventDefault()
		let modal = '.modal#item-add';
		$(modal).find('input#id').val('')
		$(modal).find('input#name').val('')
		$(modal).modal('show')
		
	});
	//-- group-edit
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