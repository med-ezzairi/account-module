<?php 
use Modules\Account\Services\GroupService;

$groups = GroupService::getAll();

?>

<form method="POST" id="frm-item-groups">
<input type="hidden" id="class" name="" value="">
<input type="hidden" class="userEmail" name="userEmail" value="">
<div class="row">
    <div class="col-lg-12 col-md-12">
    
    	@foreach ($groups as $group)
            <div class="form-group col-sm-12">
        		<div class="checkbox-inline checkbox-styled" style="top:0px; height: unset;">
                	<label>
        	            <input type="checkbox" id="{{ $group->id }}"
        	            	 name="groups[]" value="{{ $group->id }}" class="item-group success">
        	            <span class="checkmark info"></span> 
            	        <span class="label-text-ltr">{{ $group->name }}</span>
                	</label>
    	        </div>
            </div>
        @endforeach
        
        <div class="clearfix"></div>
        <div class="save-groups has-alerts"></div>
        <div class="row">
        	<div class="col-sm-6 col-md-4 col-md-offset-8">
        		<button type="button" id="btn_save_groups" class="btn btn-block btn-warning">@fas(save) {{ __($trans_prefix.'save_groups') }}</button>
        	</div>
        </div>
        
    </div>
</div>
</form>
@push('partial-scripts')
<script type="text/javascript">
$(function() {

	$('#btn_save_groups').click( function(evt){
		evt.preventDefault();
		if(ajaxRunning) return;
		if( $('#userEmail').val() == ''){
			return false;
		}
		context = '.save-groups';
		loadingMessage	= "{{ __($trans_prefix.'action_saving') }}";
		app.POST("{{ route('account.affectations.groups' ) }}", 'form#frm-item-groups', function(rep){
			if( rep.status == 'success' ){
				app.hideDelayMessage(context);
			}
		});
	});

});
</script>
@endpush