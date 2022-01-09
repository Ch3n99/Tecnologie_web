@extends('app')

@section('content')
<?php if (Auth::user()->ruolo=="Admin"): ?>
<div>
	<h2>Assegna il progetto {{$project->name}} a un nuovo utente</h2> <!-- pagina per creare nuove assegnazione di uno specifico progetto -->
    <ul class="nav navbar-right panel_toolbox">
					<li><a class="" href="{{ URL::action('ProjectController@viewprog', $project->id) }}"><i class="fa fa-close"></i></a></li>	                
	            </ul>
</div>
    <form id="create-form" method="POST" action="{{ URL::action('AssegnazioneController@index') }}" class="form-horizontal form-label-left">
	    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				@if ($errors->any()) 
					<div class="alert alert-create alert-danger alert-dismissible fade in" role="alert">
	                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<p>Non posso assegnare il progetto all'utente perchè:</p>
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

				@if (session('error'))
						<div class="alert alert-create alert-danger alert-dismissible fade in" role="alert">
		                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<p>{{ session('error') }}</p>
		                </div>
				@endif

                <div class="form-group">
	                    <label for="id_progetto" class="control-label col-md-3 col-sm-3 col-xs-12">Progetto<span class="required">*</span>
	                    </label>	                    
	                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="id_progetto"> <!-- il menù a tendina per scegliere il progetto è bloccato (ha cioè una sola opzione) sul progetto in questione -->
	                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            </select>
                        </div>
                    </div>
                <div class="form-group">
	                    <label for="utente" class="control-label col-md-3 col-sm-3 col-xs-12">Utente<span class="required">*</span></label>	                    
	                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="id_user">
								<option value="none" selected disabled hidden></option>
								@foreach ($users as $i)									<!-- per ciascun utente possibile genero opzione menù a tendina -->
	                                <option value="{{ $i->id }}">{{ $i->surname }} {{ $i->name }}</option>  <!--- salvo l'id per chiave esterna ma mostro il nome -->
								@endforeach
                            </select>
                        </div>
                    </div>
</br> </br>
	                <button type="submit" class="btn btn-primary">Assegna</button>
	            </form> 
<?php else: ?>
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>					
@stop