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
	            <h2>Aggiungi un utente</h2>
	            <ul class="nav navbar-right panel_toolbox">
					<li><a class="" href="{{ URL::action('UserController@index') }}"><i class="fa fa-close"></i></a></li>	                
	            </ul>
	            <div class="clearfix"></div>
	        </div>
	        <div class="x_content">
	            
	            <br>
	            
	            <form method="POST" action="{{ URL::action('UserController@index') }}" id="form" class="form-horizontal form-label-left">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

					@if ($errors->any())
						<div class="alert alert-create alert-danger alert-dismissible fade in" role="alert">
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<p>Non posso completare la richiesta:</p>
		                    <ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
		                    </ul>
		                </div>
					@endif
						                
	                <div class="form-group">
	                    <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Nome <span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" name="name" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="surname" class="control-label col-md-3 col-sm-3 col-xs-12">Cognome <span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" name="surname" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>
	                
	                <div class="form-group">
	                    <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="email" name="email" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>

					<div class="form-group">
	                    <label for="ruolo" class="control-label col-md-3 col-sm-3 col-xs-12">Ruolo <span class="required">*</span>
	                    </label>	                    
	                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="ruolo">
									<option value="none" selected disabled hidden></option>
	                                <option value="Admin">Admin</option>
									<option value="Semplice">Semplice</option>
                            </select>
                        </div>
                    </div>
                                        
	                <div class="form-group">
	                    <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="password" name="password" class="form-control col-md-7 col-xs-12">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="password_confirmation" class="control-label col-md-3 col-sm-3 col-xs-12">Conferma Password <span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="password" name="password_confirmation" class="form-control col-md-7 col-xs-12">
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
<script>
	$('document').ready(function(){
		$('#insert').click(function(add){
			add.preventDefault();
			$.ajaxSetup({
				var id = $(this).val();
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf_token"]').attr('content')}
			});
			$.ajax({
				url:"user/",
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
