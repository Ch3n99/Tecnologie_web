@extends('app')

@section('content')
<div class="page-title">
	<div class="title_left"></div>
</div>

<div class="clearfix"></div>
<div class="x_panel">
	    <div class="x_title">
			<h1>Benvenuto {{ Auth::user()->surname}} {{ Auth::user()->name}}</h1>
		</div>
	</div>
	<div class="x_panel"> 
			<h2>Informazioni personali</h2>
			</br></br>
			<div>
	            <label class="control-label col-md-6 col-sm-3 col-xs-12">Nome</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
				<label class="control-label col-md-7 col-xs-12">{{ Auth::user()->name}}</label>
	            </div>
	        </div>
			</br></br>
			<div>
	            <label class="control-label col-md-6 col-sm-3 col-xs-12">Cognome</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
				<label class="control-label col-md-7 col-xs-12">{{ Auth::user()->surname}}</label>
	            </div>
	        </div>
			</br></br>
			<div>
	            <label class="control-label col-md-6 col-sm-3 col-xs-12">Email</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
				<label class="control-label col-md-7 col-xs-12">{{ Auth::user()->email}}</label>
	            </div>
	        </div>
			</br></br>
			<div>
	            <label class="control-label col-md-6 col-sm-3 col-xs-12">Ruolo</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
				<label class="control-label col-md-7 col-xs-12">{{ Auth::user()->ruolo}}</label>
	            </div>
	        </div>
	</div>
<?php if (Auth::user()->ruolo=="Admin"): ?>	
<?php if (count($projects) < 1): ?>
</br></br>
<div id="no-project">
	<h1>Non ci sono progetti inseriti</h1>
	<a href="{{ URL::action('ProjectController@create') }}">Aggiungi un progetto</a>
</div>

<?php else: ?>
	<div class="x_panel">
	        <div class="x_title">
	            <h2>Elenco progetti attivi in azienda</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('ProjectController@create') }}"><i class="fa fa-plus"></i></a></li>
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            
	            <div class="clearfix"></div>
	        </div>

	        <div class="x_content">	
	            <table class="table table-striped">
	                <thead>
	                    <tr>
	                        <th>Nome</th>
	                        <th>Descrizione</th>
	                        <th>Note</th>
	                        <th>Data inizio</th>
	                        <th>Data fine prevista</th>	                        
	                        <th>Data fine effettiva</th>
							<th>Rag. sociale cliente</th>
							<th>Costo orario</th>
							<th>Dettagli aggiuntivi</th>
	                    </tr>
	                </thead>
	                <tbody>
						@foreach($projects as $p)
							<tr>
								<td>{{ $p->name}}</td>
								<td>{{ $p->description}}</td>
								<td>{{ $p->note}}</td>
								<td>{{ date('Y-m-d', strtotime($p->date_start)) }}</td>
								<td><?php if ($p->date_end_prev == ''): ?>{{' '}} <?php else: ?> {{date('Y-m-d', strtotime($p->date_end_prev))}}<?php endif; ?></td>
								<td></td>
								<td>{{ $p->ragsoc }}</td>
								<td>{{ number_format($p->hour_cost, 2) }} €</td>
								<td>
								<a href="{{ URL::action('ProjectController@query1', $p->id) }}" class="link">Visualizza</a>	
								</td>															
								<td>
									<a href="{{ URL::action('ProjectController@edit', $p->id) }}" class="action-link fa fa-pencil"></a>																
									<a href="{{ URL::action('ProjectController@destroy', $p->id) }}" onClick="return confirm('Sei sicuro di voler cancellare questa riga?')" class="action-link link-danger fa fa-close"></a>
								</td>
							</tr>
						@endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>	
</div>

<?php endif; ?>
<?php else: ?>
	<div class="x_panel"> 
			<h2>Gestione operazioni</h2>
			</br></br>
			<div>
	            <label class="control-label col-md-6 col-sm-3 col-xs-12">Riepilogo personale</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
				<a href="{{ URL::action('UserController@query3', Auth::user()->id) }}"><button type="submit" class="btn btn-primary" style="color:white">Visualizza</button></a>
	            </div>
	        </div>
			</br></br></br>
			<div>
	            <label class="control-label col-md-6 col-sm-3 col-xs-12">Visualizza diario</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
				<a href="{{ URL::action('DiarioController@index', Auth::user()->id) }}"><button type="submit" class="btn btn-primary" style="color:white">Visualizza</button></a>
	            </div>
	        </div>
			</br></br></br>
			<div>
	            <label class="control-label col-md-6 col-sm-3 col-xs-12">Inserisci scheda ore</label>
	            <div class="col-md-6 col-sm-6 col-xs-12">
				<a href="{{ URL::action('DiarioController@create', Auth::user()->id) }}"><button type="submit" class="btn btn-primary" style="color:white">Inserisci</button></a>
	            </div>
	        </div>
	</div>
</div>
<?php endif; ?>

@stop
