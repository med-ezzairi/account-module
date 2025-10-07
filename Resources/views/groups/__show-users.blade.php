@css(datatables-2.3.4.min)
<div class="row">
	<div class="col-sm-12 search-users">
		<div class="panel panel-info">
        	<div class="panel-heading">
        		<div class="panel-title">
        			<span class="fas fa-users"></span>
        			{{ trans('account::roles.users.search_users') }}
        		</div>
        	</div>
        	<div class="panel-body">
        		<div class="list-group">
        			
        			
        			{{-- 
        			@foreach( $users as $user)
                	<div class="list-group-item user-{{ $user->id }}" data-id="{{ $user->id }}">
                		<div class="checkbox-inline checkbox-styled checkbox-styled-ltr">
                    		<label>
                	            <input type="checkbox" name="membre[{{ $user->id }}]" value="1" class="success">
                	            <span class="checkmark info"></span> 
                    	        <span class="checkmark-label">{{ $user->nom.' '.$user->prenom.' - '.$user->email }}</span>
                        	</label>
            	        </div>
            	        <a href="#" class="pull-right btn_remove_item"><i class="fas fa-plus-circle fa-lg "></i></a>
                		
            		</div>
            		@endforeach
            		 --}}
            		
            		{{-- 
            		<table id="tabUsers" class="table">
            			<thead>
                      <tr>
                        <th>&nbsp;</th>
                        <th>Nom</th>
                        <th>Email</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach( $users as $user)
                      <tr>
                        <td><input type="checkbox" name="membre[{{ $user->id }}]" value="1" class="success"></td>
                        <td>{{ ($user->nom.' '.$user->prenom) ?? '&nbsp;' }}</td>
                        <td>{{ $user->email }}</td>
                      </tr>
                      @endforeach
                      </tbody>
                    </table>
                     --}}
                     
            		<table id="tabUsers" class="table"></table>

                	
        			
        			
                </div>
        	</div>
    	</div>
	</div>
</div>

@push('partial-scripts')
@js(datatables-2.3.4.min)
<script type="text/javascript">
$(function() {
	const tabUsers = new DataTable('#tabUsers', {
		serverSide: true,
		ajax: '{{ route("account.users.index") }}',
	    columns: [
	        { data: 'id' },
	        { data: 'nom' },
	        { data: 'prenom' },
	        { data: 'email' }
	    ]
	});
	
	$('#btn_save').click( function(evt){
		evt.preventDefault();
		if(ajaxRunning) return;
		context = '.has-alerts';
		loadingMessage	= "{{ __($trans_prefix.'action_saving') }}";
		app.POST("{{ route('account.groups.permissions', $item->id ) }}", 'form#frm-item-permissions', rep => app.reloadOnSuccess(rep));
	});

	
});
</script>
@endpush