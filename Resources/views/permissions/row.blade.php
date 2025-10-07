<div class="permission-row">
    <div class="row">
        <div class="col-md-5 col-sm-4">
            <span class="permission-label">{{ trans($permissionLabel) }}</span>
        </div>

        <div class="col-md-7 col-sm-8">
            <div class="row">
                <div class="radio-btn clearfix">
                	
                	<?php 
                	$permission = "{$group}.{$permissionAction}";
                	$action = $item->getAction($permission);
                	?>
                	
                	<div class="form-group col-sm-4">
                		<div class="checkbox-inline checkbox-styled" style="top:0px; height: unset;">
                        	<label>
                	            <input type="radio" id="{{ "{$group}-{$permissionAction}" }}-allow"
                	            	 name="permissions[{{ $permission }}]" value="1" class="success permission-allow"  {{ $action == 'allow' ? 'checked' : '' }}>
                	            <span class="checkmark info"></span> 
                    	        <span class="label-text-ltr">{{ $allow }}</span>
                        	</label>
            	        </div>
                    </div>
                    
                	<div class="form-group col-sm-4">
                		<div class="checkbox-inline checkbox-styled" style="top:0px; height: unset;">
                        	<label>
                	            <input type="radio" id="{{ "{$group}-{$permissionAction}" }}-deny"
                	            	 name="permissions[{{ $permission }}]" value="0" class="success permission-deny"  {{ $action == 'deny' ? 'checked' : '' }}>
                	            <span class="checkmark info"></span> 
                    	        <span class="label-text-ltr">{{ $deny }}</span>
                        	</label>
            	        </div>
                    </div>
                     
                	<div class="form-group col-sm-4">
                		<div class="checkbox-inline checkbox-styled" style="top:0px; height: unset;">
                        	<label>
                	            <input type="radio" id="{{ "{$group}-{$permissionAction}" }}-inherit"
                	            	 name="permissions[{{ $permission }}]" value="-1" class="success permission-inherit"  {{ $action == 'inherit' ? 'checked' : '' }}>
                	            <span class="checkmark info"></span> 
                    	        <span class="label-text-ltr">{{ $inherit }}</span>
                        	</label>
            	        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
