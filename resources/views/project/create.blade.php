@extends('app')

@section('content')
<?php if (Auth::user()->ruolo=="Admin"): ?>
<div class="page-title">
	<div class="title_left"></div>
</div>

<div class="clearfix"></div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="x_panel">
	        <div class="x_title">
	            <h2>Aggiungi un progetto</h2>
	            <ul class="nav navbar-right panel_toolbox">
					<li><a class="" href="{{ URL::action('ProjectController@index') }}"><i class="fa fa-close"></i></a></li>	                
	            </ul>
	            <div class="clearfix"></div>
	        </div>
	        <div class="x_content">
	            
	            <br>
	            
	            <form id="create-form" method="POST" action="{{ URL::action('ProjectController@index') }}" id="form" class="form-horizontal form-label-left">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

					@if ($errors->any())
						<div class="alert alert-create alert-danger alert-dismissible fade in" role="alert">
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<p>Non posso aggiungere il progetto perchè:</p>
		                    <ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
		                    </ul>
		                </div>
					@endif

					@if (session('success'))
						<div class="alert alert-create alert-success alert-dismissible fade in" role="alert">
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<p>{{ session('success') }}</p>
		                </div>
					@endif
					
					<div class="form-group">
	                    <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Nome<span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>

					<div class="form-group">
	                    <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Descrizione<span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="description" name="description" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>

					<div class="form-group">
	                    <label for="note" class="control-label col-md-3 col-sm-3 col-xs-12">Note</label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="note" name="note" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="date_start" class="control-label col-md-3 col-sm-3 col-xs-12">Data inizio in formato Y-m-d<span class="required">*</span>
	                    </label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="date_start" id="data" value="{{ date('Y-m-d') }}" class="date-picker form-control col-md-7 col-xs-12" >	
	                    </div>
	                </div>

					<div class="form-group">
	                    <label for="date_end_prev" class="control-label col-md-3 col-sm-3 col-xs-12">Data fine prevista in formato Y-m-d
	                    </label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="date_end_prev" id="data1" class="date-picker form-control col-md-7 col-xs-12" >
	                    </div>
	                </div>

					<div class="form-group">
	                    <label for="date_end_eff" class="control-label col-md-3 col-sm-3 col-xs-12">Data fine effettiva in formato Y-m-d
	                    </label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="date_end_eff" id="data2" class="date-picker form-control col-md-7 col-xs-12" >
	                    </div>
	                </div>
	                
	                <div class="form-group">
	                    <label for="id_cliente" class="control-label col-md-3 col-sm-3 col-xs-12">Cliente<span class="required">*</span>
	                    </label>	                    
	                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="id_cliente">
								<option value="none" selected disabled hidden></option>
								@foreach ($clienti as $cliente)
	                                <option value="{{ $cliente->id }}">{{ $cliente->ragsoc }}</option>
								@endforeach
                            </select>
                        </div>
                    </div>
	                
	                <div class="form-group">
	                    <label for="hour_cost" class="control-label col-md-3 col-sm-3 col-xs-12">Costo orario <span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="number" step="1.00" id="hour_cost" name="hour_cost" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>
	                	                
	                <div class="ln_solid"></div>
	                <div class="form-group">
	                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                        <button type="submit" id="insert" class="btn btn-primary">Aggiungi</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/date.js') }}"></script>
<script>
	$('document').ready(function(){
		$('#insert').click(function(add){
			add.preventDefault();
			$.ajaxSetup({
				var id = $(this).val();
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf_token"]').attr('content')}
			});
			$.ajax({
				url:"project/",
				method:"post",
				data: $('#form').serialize(),
				success:function(response){
					location.reload(true);
				},
				error:function(response,stato){
					console.log(stato);
				}
			});
		});
		return false;
	});
</script> 
<?php else: ?>
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>
@stop

