@extends('app') <!--serve a richiamare la parte fissa dell'applicazione come la barra laterale -->

@section('content')
<?php if (Auth::user()->ruolo=="Admin"): ?>
<div class="page-title">
	<div class="title_left"></div>
</div>

<div class="clearfix"></div>

<?php if (count($progetti) < 1): ?>

<div id="no-project">
	<h1>Non ci sono progetti inseriti</h1>
	<a href="{{ URL::action('ProjectController@create') }}">Aggiungi un progetto</a>
</div>

<?php else: ?>
	
	    <div class="x_panel">
	        <div class="x_title">
	            <h2>Progetti</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('ProjectController@create') }}"><i class="fa fa-plus"></i></a></li>  <!-- link per creare nuovo progetto -->
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            
	            <div class="clearfix"></div>
	        </div>

	        <div class="x_content">	
	            <table class="table table-striped">  <!-- tabella per visualizzazione progetti -->
	                <thead>
	                    <tr>
	                        <th>Nome</th>
	                        <th>Descrizione</th>
	                        <th>Note</th>
	                        <th>Data d'inizio</th>
	                        <th>Data di fine prevista</th>	                        
	                        <th>Data di fine effettiva</th>
                            <th>Cliente di riferimento</th>
                            <th>Costo orario</th>
							<th>Ulteriori dettagli</th>
	                    </tr>
	                </thead>
	                <tbody>
						@foreach($progetti as $i)
							<tr>
								<td>{{ $i->name }}</td>
								<td>{{ $i->description }}</td>
								<td>{{ $i->note }}</td>
								<td>{{ $i->date_start }}</td>																
								<td>{{ $i->date_end_prev }}</td>		
                                <td>{{ $i->date_end_eff }}</td>
                                <td>{{ $i->ragsoc }}</td>
                                <td>{{ $i->hour_cost }} €</td>
								<td><a href="{{ URL::action('ProjectController@viewprog', $i->id) }}" class="link">Visualizza</a>								
								<td>
									<a href="{{ URL::action('ProjectController@edit', $i->id) }}" class="action-link fa fa-pencil"></a>																
									<a href="{{ URL::action('ProjectController@destroy', $i->id) }}" class="action-link link-danger del-link fa fa-close"></a> 
								</td>
							</tr>
						@endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>	
</div>
</div>
<?php endif; ?>
<?php else: ?>
	<h1>Benvenuto {{Auth::user()->name}} {{Auth::user()->surname}}</h1>
	<h2>Clicca <a href="{{ URL::action('DiarioController@viewdiario', Auth::user()->id) }}" class="link">qui</a> per vedere il tuo diario</h2>		
<?php endif; ?>
@stop