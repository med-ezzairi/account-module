@extends('account::layouts.master')
@section('account')
<?php 
$trans_prefix       = 'account::account_user.global.';
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
    			 
    			 {{-- 
    			 <div class="pull-right">
    			 	<a class="btn btn-success btn-panel-header_" href="#" id="btn_item_create"> @fas(plus-circle) {{ __($trans_prefix.'action_create') }}</a>
    			 </div>
    			  --}}
    			 
    		</div>
    	</div>
		<div class="panel-body">
			
			<div class="col-sm-6">
				<div class="form-group">
                	<label for="email" class="control-label">{{ __($trans_prefix.'email') }}</label>
                	<div class="input-group">
                		<input type="email" class="form-control" id="email" placeholder="Email">
                		<span class="input-group-btn">
                        	<button class="btn btn-primary" type="button" id="btnSearch">@fas(search) {{ __($trans_prefix.'search') }}</button>
                        </span>
                	</div>
                </div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group">
                	<label for="name" class="control-label">{{ __($trans_prefix.'name') }}</label>
            		<input type="text" class="form-control" id="name" readonly>
                </div>
			</div>
			<div class="clearfix"></div>
			<div class="user-search has-alerts"></div>
			
			<hr class="clearfix">
			
			<!-- Groups & Permissions -->
			<div class="col-sms-12">
            	<ul class="nav nav-tabs">
            		<li role="presentation" class="active">
            			<a href="#groups" aria-controls="home" role="tab" data-toggle="tab">{{ __($trans_prefix.'groups') }}</a>
            		</li>
            		<li role="presentation">
            			<a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab">{{ __($trans_prefix.'permissions') }}</a>
            		</li>
            	</ul>
            	<div class="tab-content" style="padding-top: 15px;">
            		<div role="tabpanel" class="tab-pane active" id="groups">
            			@includeIf('account::affectations.groups')
            		</div>
            		<div role="tabpanel" class="tab-pane" id="permissions">
            			@includeIf('account::affectations.permissions')
            		</div>
            		
            	</div>
            </div>

		</div>
	</div>
</div>
@endsection
@push('partial-scripts')
<script type="text/javascript">
$(function() {
	/**
	* Reset all permissions to Inherit
	*/
	const resetPermissions = function(){
		$('.permission-parent-actions > .inherit-all').trigger('click');
	};

	/**
	* show user's permissions
	*/
	const showPermissions = function( permissions ){
		let input = ''; 
		$.each( permissions, function( item, value ){
			input = document.getElementById(item+'-allow');
			if( input != undefined ){
    			if( value ){
    				document.getElementById(item+'-allow').checked = true
    			}else{
    				document.getElementById(item+'-deny').checked = true
    			}
			}
		});
	};
	
	/**
	* Reset all groups
	*/
	const resetGroups = function(){
		$('input.item-group').prop('checked', false );
	};

	/**
	* show user's groups
	*/
	const showGroups = function( groups ){
		console.log( groups );
		let input = ''
		$.each( groups, function( index, item ){
			input = document.getElementById(item.id);
			if( input != undefined ){
				input.checked = true
			}
		});
	};
	
	
	$('#btnSearch').click( function(evt){
		evt.preventDefault();
		if(ajaxRunning) return;

		resetPermissions();
		resetGroups();
		$('#name').val('');
		
		context = '.user-search';
		loadingMessage	= "{{ __($trans_prefix.'action_searching') }}";
		app.POST_Data("{{ route('account.affectations.search' ) }}", {email: $('#email').val()}, function(rep){
			if( rep.status == 'success' ){
				app.hideDelayMessage(context);
				if( rep.user ){
					$('#name').val(rep.user.name.ar);
					$('.userEmail').val(rep.user.email); // permissions sub-view
					showPermissions(rep.user.permissions);
					showGroups(rep.user.groups);
				}
			}
		});
	});
	
});
</script>
@endpush