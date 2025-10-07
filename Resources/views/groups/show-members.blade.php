
<div class="row">
	<div class="col-sm-12 membres">
		<div class="panel panel-info">
        	<div class="panel-heading">
        		<div class="panel-title">
        			<span class="fas fa-users"></span>
        			{{ trans('account::roles.users.members') }}
        			
        			<div class="pull-right">
        				{{ trans('account::roles.users.members_count').$item->users->count() ?? '0' }}
    				</div>
        		</div>
        	</div>
        	<div class="panel-body">
        		<div class="list-group">
        			@foreach( $item->users as $user)
                	<div class="list-group-item user-{{ $user->id }}" data-id="{{ $user->id }}">
                		<div class="checkbox-inline checkbox-styled checkbox-styled-ltr">
                    		<label>
                	            <input type="checkbox" name="membre[{{ $user->id }}]" value="1" class="success">
                	            <span class="checkmark info"></span> 
                    	        <span class="checkmark-label">{{ $user->nom.' '.$user->prenom.' - '.$user->email }}</span>
                        	</label>
            	        </div>
            	        <a href="#" class="pull-right btn_remove_item"><i class="fas fa-trash-alt fa-lg "></i></a>
                		
            		</div>
                	@endforeach
                </div>
        	</div>
        	<div class="panel-footer">
        		<div class="pull-right">
        			<button type="button" class="btn btn-warning">{{ trans('account::roles.users.remove_selected') }}</button>
        		</div>
        		<div class="clearfix"></div>
        	</div>
    	</div>
	</div>
</div>
@include( $partials.'.modals.confirmation', [
	'title'		=> trans('account::roles.users.remove_selected'),
	'action'	=> route('account.groups.users', $item->id),
])
@push('partial-scripts')
<script type="text/javascript">
const confirmActionFunction = function(){
	context = '#generic-confirm-item';
	loadingMessage = '';
	let action = $(context).find('#action').val();
	let _id = $(context).find('#item_id').val();
	app.DELETE( action, {id:_id }, rep => app.reloadOnSuccess(rep) );
};
$(function() {

	$('.btn_remove_item').click( function ( evt) {
		evt.preventDefault();
		context = '#generic-confirm-item';
		app.hideMessage(context)
		const container = $(this).closest('div');
		const item_id = $( container ).data('id');
		const message = $( container ).find('.checkmark-label').text();
		$(context).find('.item_name').text( message );
		$(context).find('#item_id').val(item_id);
		$(context).modal('show')
	});

	/*
	$('#btn_save').click( function(evt){
		evt.preventDefault();
		if(ajaxRunning) return;
		context = '.has-alerts';
		loadingMessage	= "{{ __($trans_prefix.'action_saving') }}";
		//app.POST("{{ route('account.groups.permissions', $item->id ) }}", 'form#frm-item-permissions', rep => app.reloadOnSuccess(rep));
	});
	*/
});
</script>
@endpush