<?php 
use Modules\Account\Services\PermissionService;

$trans_permissions = 'account::global.permissions.';
$allow_all  	= trans($trans_permissions.'allow_all');
$deny_all   	= trans($trans_permissions.'deny_all');
$inherit_all    = trans($trans_permissions.'inherit_all');

$allow  		= trans($trans_permissions.'allow');
$deny   		= trans($trans_permissions.'deny');
$inherit    	= trans($trans_permissions.'inherit');

$permissions    = PermissionService::getAllModulesPermissions();
?>
<style>
.checkbox-styled .label-text-ltr{
    display:block; 
    padding-left: 25px;
}
</style>
<div class="row">
	<div class="col-sm-12">
	<div class="col-md-5 col-sm-4">
        &nbsp;
    </div>
    <div class="col-md-7 col-sm-8">
        <div class="row">
        	<div class="btn-group btn-group-justified" role="group">
                <div class="btn-group permission-parent-actions">
                    <button type="button" class="btn btn-default allow-all">{{ $allow_all }}</button>
                </div>
                <div class="btn-group permission-parent-actions" role="group">
                    <button type="button" class="btn btn-default deny-all">{{ $deny_all }}</button>
                </div>
                <div class="btn-group permission-parent-actions" role="group">
                    <button type="button" class="btn btn-default inherit-all">{{ $inherit_all }}</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<form method="POST" id="frm-item-permissions">
<input type="hidden" id="class" name="" value="">
<input type="hidden" class="userEmail" name="userEmail" value="">
<div class="row">
    <div class="col-lg-12 col-md-12">
	@foreach ($permissions as $module => $modulePermissions)
        <div class="col-md-12">
            <div class="row">
                <div class="permission-parent-head clearfix">
                    <h3>{{ $module }}</h3>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        
        @foreach ($modulePermissions as $group => $groupPermissions)
            <div class="permission-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="permission-group-head">
                            <div class="row">
                                <div class="col-md-5 col-sm-4">
                                    <h3>{{ $group }}</h3>
                                </div>

                                <div class="col-md-7 col-sm-8">
                                	<div class="btn-group btn-group-justified" role="group">
                                        <div class="btn-group permission-group-actions" role="group">
                                            <button type="button" class="btn btn-default allow-all">{{ $allow_all }}</button>
                                        </div>
                                        <div class="btn-group permission-group-actions" role="group">
                                            <button type="button" class="btn btn-default deny-all">{{ $deny_all }}</button>
                                        </div>
                                        <div class="btn-group permission-group-actions" role="group">
                                            <button type="button" class="btn btn-default inherit-all">{{ $inherit_all }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 15px;">
                            @foreach ($groupPermissions as $permissionAction => $permissionLabel)
                                @include('account::permissions.row')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
    @endforeach
        
    <div class="clearfix"></div>
    <div class="save-permissions has-alerts"></div>
    <div class="row">
    	<div class="col-sm-6 col-md-4 col-md-offset-8">
    		<button type="button" id="btn_save_permissions" class="btn btn-block btn-warning">@fas(save) {{ __($trans_prefix.'save_permissions') }}</button>
    	</div>
    </div>
    
    </div>
</div>
</form>

@push('partial-scripts')
<script type="text/javascript">
$(function() {

	$('#btn_save_permissions').click( function(evt){
		evt.preventDefault();
		if(ajaxRunning) return;
		if( $('#userEmail').val() == ''){
			return false;
		}
		context = '.save-permissions';
		loadingMessage	= "{{ __($trans_prefix.'action_saving') }}";
		app.POST("{{ route('account.affectations.permissions' ) }}", 'form#frm-item-permissions', function(rep){
			if( rep.status == 'success' ){
				app.hideDelayMessage(context);
			}
		});
	});

	$('.permission-parent-actions > .allow-all, .permission-parent-actions > .deny-all, .permission-parent-actions > .inherit-all').on('click', (e) => {
	    let action = e.currentTarget.className.split(/\s+/)[2].split(/-/)[0];

	    $(`.permission-${action}`).prop('checked', true);
	});

	$('.permission-group-actions > .allow-all, .permission-group-actions > .deny-all, .permission-group-actions > .inherit-all').on('click', (e) => {
	    let action = e.currentTarget.className.split(/\s+/)[2].split(/-/)[0];
	    
	    $(e.currentTarget).closest('.permission-group')
	        .find(`.permission-${action}`)
	        .each((index, value) => {
	            $(value).prop('checked', true);
	        });
	});
});
</script>
@endpush
