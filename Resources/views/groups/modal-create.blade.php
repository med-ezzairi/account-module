<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="item-add">
  <div class="modal-dialog" role="document">
  	<form method="POST" id="frm-item-add">
    <div class="modal-content">
    	
      <div class="modal-header">
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
        	{{ __($trans_prefix.'action_create') }}
        </h4>
      </div>
      
      <div class="modal-body">
      		
  		<input type="hidden" name="id" id="id" value="" >
  		<div class="form-group col-sm-6">
  			<label class="control-label" for="name">{{ __($trans_prefix.'libelle') }}</label>
  			<input name="name" id="name" type="text" class="form-control" required>
  		</div>
      	<div class="clearfix"></div>
      	<div class="col-sm-12 has-alerts"></div>
      	<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      	<div class="col-sm-12">
	      	<div class="col-sm-4">
	        	<button type="button" class="btn btn-block btn-warning" data-dismiss="modal">{{ __('global.cancel') }}</button>
	      	</div>
	      	<div class="col-sm-4">
	        	<button type="button" id="btn-item-save" class="btn btn-block btn-success">{{ __('global.save') }}</button>
	      	</div>
      	</div>
      </div>
    </div><!-- /.modal-content -->
  </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('partial-scripts')
<script type="text/javascript">
$(function() {
	
	$('#btn-item-save').click( function(evt){
		evt.preventDefault();
		if(ajaxRunning) return;
		context = '.has-alerts';
		loadingMessage	= "{{ __($trans_prefix.'action_saving') }}";
		app.POST("{{ route('account.groups.store') }}", 'form#frm-item-add', rep => app.reloadOnSuccess(rep));
	});

	/*
	let initModal = function( _context ){
		context = _context;
		$( context ).find('input#id').val( '' );
		$( context ).find('input#prenom').val( '' );
		$( context ).find('input#cin').val( '' );
		//$( context ).find('input#adresse').val( '' );
		$( context ).find('input#cadre').prop( 'checked', false );
		$( context ).find('.modal-title').html( modal_title );
	};

	
	let saveBeneficiaire = function( _context ){
		context = _context;
		loadingMessage	= "{{ __($trans_prefix.'action_saving') }}";
		app.POST("{{ route('account.groups.store') }}", 'form#frm-item-add', rep => app.reloadOnSuccess(rep));
	}
	*/
});
</script>
@endpush