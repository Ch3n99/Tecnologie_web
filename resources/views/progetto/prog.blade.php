@extends('app')

@section('content')
<div>
	<h1>Progetto {{$project->name}}</h1>
    <?php if (count($ass) < 1): ?>
    <div id="no-project">
	    <h2>Non ci sono utenti assegnati a questo progetto</h2>
	    <a href="/">Assegna un nuovo utente a questo progetto</a>
    </div>
    <?php else: ?>
        <div class="x_panel">
	        <div class="x_title">
	            <h2>Progetti</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('AssegnazioneController@create', $project->id) }}"><i class="fa fa-plus"></i></a></li>  <!-- link per creare nuova assegnazione -->
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            
	            <div class="clearfix"></div>
	        </div>

	        <div class="x_content">	
	            <table class="table table-striped">  <!-- tabella per visualizzazione utenti assegnati a progetto -->
	                <thead>
	                    <tr>
	                        <th>Nome</th>
	                        <th>Cognome</th>
	                    </tr>
	                </thead>
	                <tbody>
						@foreach($ass as $i)
							<tr>
								<td>{{ $i->name }}</td>
								<td>{{ $i->surname }}</td>												
							</tr>
						@endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>  
<?php endif; ?>
</div>
@stop