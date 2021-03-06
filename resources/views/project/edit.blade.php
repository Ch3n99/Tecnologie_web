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
	            <h2>Aggiorna progetto</h2>
	            <ul class="nav navbar-right panel_toolbox">
					<li><a class="" href="{{ URL::action('ProjectController@index') }}"><i class="fa fa-close"></i></a></li>	                
	            </ul>
	            <div class="clearfix"></div>
	        </div>
	        <div class="x_content">
	            
	            <br>
	            
	            <form method="POST" action="{{ URL::action('ProjectController@update', $project->id) }}" class="form-horizontal form-label-left">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <input type="hidden" name="_method" value="PUT">

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
					
                    <div class="form-group">
	                    <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Nome<span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12" value="{{ $project->name }}">
	                    </div>
	                </div>

                    <div class="form-group">
	                    <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Descrizione<span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" value="{{ $project->description }}">
	                    </div>
	                </div>

                    <div class="form-group">
	                    <label for="note" class="control-label col-md-3 col-sm-3 col-xs-12">Note</label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="note" name="note" class="form-control col-md-7 col-xs-12" value="{{ $project->note }}">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="date" class="control-label col-md-3 col-sm-3 col-xs-12">Data d'inizio<span class="required">*</span>
	                    </label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="date_start" class="form-control date-period" name="date_start" value="{{ $project->date_start }}" class="date-picker form-control col-md-7 col-xs-12">
	                    </div>
	                </div>

                    <div class="form-group">
	                    <label for="date" class="control-label col-md-3 col-sm-3 col-xs-12">Data fine prevista
	                    </label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="date_end_prev" class="form-control date-period" name="date_end_prev" class="date-picker form-control col-md-7 col-xs-12" value="{{ $project->date_end_prev }}">
	                    </div>
	                </div>

                    <div class="form-group">
	                    <label for="date" class="control-label col-md-3 col-sm-3 col-xs-12">Data fine effettiva
	                    </label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="text" id="date_end_eff" class="form-control date-period" name="date_end_eff" class="date-picker form-control col-md-7 col-xs-12" value="{{ $project->date_end_eff }}">
	                    </div>
	                </div>
	                
	                <div class="form-group">
	                    <label for="cliente" class="control-label col-md-3 col-sm-3 col-xs-12">Ragione sociale cliente<span class="required">*</span></label>	                    
	                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="id_cliente">
								@foreach ($clienti as $i)			<!-- per ciascun cliente genero opzione menù a tendina selezionando come valore di default il cliente attuale -->
                                @if ($project->id_cliente == $i->id) 
		                                <option selected="selected" value="{{ $i->id }}">{{ $i->ragsoc }}</option> <!-- salvo l'id per chiave esterna ma mostro la ragione sociale -->
		                            @else
										<option value="{{ $i->id }}">{{ $i->ragsoc }}</option>
								@endif
								@endforeach
                            </select>
                        </div>
                    </div>
	                
	                <div class="form-group">
	                    <label for="amount" class="control-label col-md-3 col-sm-3 col-xs-12">Costo orario<span class="required">*</span></label>
	                    <div class="col-md-6 col-sm-6 col-xs-12">
	                        <input type="number" step="0.5" id="hour_cost" name="hour_cost" class="form-control col-md-7 col-xs-12" value="{{ $project->hour_cost }}">
	                    </div>
	                </div>
	                	                
	                <div class="ln_solid"></div>
	                <div class="form-group">
	                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                        <button type="submit" class="btn btn-primary">Aggiorna</button>
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
