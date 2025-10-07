{{-- 
This is a test to send permissions indexed by action (inherit|allow|deny) 
but not working due to radio bottons need to have same name.

could be done in a next time
 --}}

<div class="permission-row">
    <div class="row">
        <div class="col-md-5 col-sm-4">
            <span class="permission-label">{{ trans($permissionLabel) }}</span>
        </div>

        <div class="col-md-7 col-sm-8">
            <div class="row">
                <div class="radio-btn clearfix">
                	
                	{{-- 
                    @if (! is_null($entity))
                        @php
                            $permissionValue = old('permissions')["{$group}.{$permissionAction}"] ?? permission_value($entity->permissions ?: [], "{$group}.{$permissionAction}")
                        @endphp
                    @endif
                	 --}}
                	 
                	<?php 
                	$permission = "{$group}.{$permissionAction}";
                	$action = $item->getAction($permission);
                	?>
                	
                	<div class="form-group col-sm-4">
                		<div class="checkbox-inline checkbox-styled" style="top:0px; height: unset;">
                        	<label>
                	            <input type="radio" id="{{ "{$group}-{$permissionAction}" }}-allow"
                	            	 name="permissions[allow][{{ $i }}]" value="{{ $permission }}" class="success permission-allow"  {{ $action == 'allow' ? 'checked' : '' }}>
                	            <span class="checkmark info"></span> 
                    	        <span class="label-text-ltr">{{ $allow }}</span>
                        	</label>
            	        </div>
                    </div>
                    
                	<div class="form-group col-sm-4">
                		<div class="checkbox-inline checkbox-styled" style="top:0px; height: unset;">
                        	<label>
                	            <input type="radio" id="{{ "{$group}-{$permissionAction}" }}-deny"
                	            	 name="permissions[deny][{{ $i }}]" value="{{ $permission }}" class="success permission-deny"  {{ $action == 'deny' ? 'checked' : '' }}>
                	            <span class="checkmark info"></span> 
                    	        <span class="label-text-ltr">{{ $deny }}</span>
                        	</label>
            	        </div>
                    </div>
                     
                	<div class="form-group col-sm-4">
                		<div class="checkbox-inline checkbox-styled" style="top:0px; height: unset;">
                        	<label>
                	            <input type="radio" id="{{ "{$group}-{$permissionAction}" }}-inherit"
                	            	 name="permissions[inherit][{{ $i }}]" value="{{ $permission }}" class="success permission-inherit"  {{ $action == 'inherit' ? 'checked' : '' }}>
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
