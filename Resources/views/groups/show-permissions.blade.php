<?php 
$allow_all  	= trans('account::roles.permissions.allow_all');
$deny_all   	= trans('account::roles.permissions.deny_all');
$inherit_all    = trans('account::roles.permissions.inherit_all');

$allow  		= trans('account::roles.permissions.allow');
$deny   		= trans('account::roles.permissions.deny');
$inherit    	= trans('account::roles.permissions.inherit');
?>
<style>
.checkbox-styled .label-text-ltr{
    display:block; 
    padding-left: 25px;
}
</style>
<div class="row">
    <div class="col-lg-9 col-md-12">
        <div class="btn-group permission-parent-actions pull-right">
            <button type="button" class="btn btn-default allow-all">{{ $allow_all }}</button>
            <button type="button" class="btn btn-default deny-all">{{ $deny_all }}</button>
            <button type="button" class="btn btn-default inherit-all">{{ $inherit_all }}</button>
        </div>
    </div>
</div>

<form method="POST" id="frm-item-permissions">
<div class="row">
    <div class="col-lg-9 col-md-12">
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
                                <div class="col-md-4 col-sm-4">
                                    <h3>{{ $group }}</h3>
                                </div>

                                <div class="col-md-8 col-sm-8">
                                    <div class="btn-group permission-group-actions pull-right">
                                        <button type="button" class="btn btn-default allow-all">{{ $allow_all }}</button>
                                        <button type="button" class="btn btn-default deny-all">{{ $deny_all }}</button>
                                        <button type="button" class="btn btn-default inherit-all">{{ $inherit_all }}</button>
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
    <div class="has-alerts"></div>
    <div class="row">
    	<div class="col-sm-6 col-md-4 col-md-offset-8">
    		<button type="button" id="btn_save" class="btn btn-block btn-warning">@fas(save) {{ __($trans_prefix.'save_permissions') }}</button>
    	</div>
    </div>
    
    </div>
</div>
</form>

@push('partial-scripts')
<script type="text/javascript">
$(function() {

	$('#btn_save').click( function(evt){
		evt.preventDefault();
		if(ajaxRunning) return;
		context = '.has-alerts';
		loadingMessage	= "{{ __($trans_prefix.'action_saving') }}";
		app.POST("{{ route('account.groups.permissions', $item->id ) }}", 'form#frm-item-permissions', rep => app.reloadOnSuccess(rep));
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
