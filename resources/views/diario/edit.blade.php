@extends('app')

@section('content')
<?php if (Auth::user()->ruolo=="Semplice"): ?>
<div class="page-title">
	<div class="title_left"></div>
</div>

<div class="clearfix"></div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="x_panel">
	        <div class="x_title">
	            <h2>Modifica scheda ore</h2>
	            <ul class="nav navbar-right panel_toolbox">
					<li><a class="" href="{{ URL::action('DiarioController@index', Auth::user()->id) }}"><i class="fa fa-close"></i></a></li>	                
	            </ul>
	            <div class="clearfix"></div>
	        </div>
	        <div class="x_content">
	            
	            <br>
	            
	            <form method="POST" action="{{ URL::action('DiarioController@update', $d) }}" class="form-horizontal form-label-left">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<input type="hidden" name="_method" value="PUT">

					@if ($errors->any())
						<div class="alert alert-create alert-danger alert-dismissible fade in" role="alert">
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<p>Non posso modificare la scheda ore perchè:</p>
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
	                    <label for="data" class="control-label col-md-3 col-sm-3 col-xs-12">Data<span class="required">*</span>
	                    </label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="data" id="data" value = "{{ $d->data }}" class="date-picker form-control col-md-7 col-xs-12" value = "{{ $d->data }}">	
	                    </div>
	                </div>

                    <div class="form-group">
	                    <label for="num_ore" class="control-label col-md-3 col-sm-3 col-xs-12">Numero ore <span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="number" step="0.50" id="num_ore" name="num_ore" class="form-control col-md-7 col-xs-12" value = "{{ $d->num_ore }}">
	                    </div>
	                </div>
					
					<div class="form-group">
	                    <label for="note" class="control-label col-md-3 col-sm-3 col-xs-12">Note</label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="note" name="note" class="form-control col-md-7 col-xs-12" value = "{{ $d->note }}">
	                    </div>
	                </div>

                    <div class="form-group">
	                    <label for="id_asseg" class="control-label col-md-3 col-sm-3 col-xs-12">Progetto<span class="required">*</span>
	                    </label>	                    
	                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="id_asseg">
								<option value="none" selected disabled hidden></option>
								@foreach ($asseg as $a)
                                    @if ($d->id_asseg == $a->id) 
		                                <option selected="selected" value="{{ $a->id }}">{{ $a->name }}</option>
		                            @else
										<option value="{{ $a->id }}">{{ $a->name }}</option>
									@endif
								@endforeach
                            </select>
                        </div>
                    </div>					
	                	                
	                <div class="ln_solid"></div>
	                <div class="form-group">
	                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                        <button type="submit" class="btn btn-primary">Modifica</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/date.js') }}"></script> 
<?php else: ?>
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>
@stop