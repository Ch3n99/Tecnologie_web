@extends('app') <!--serve a richiamare la parte fissa dell'applicazione come la barra laterale -->

@section('content')
<?php if (Auth::user()->ruolo=="Admin"): ?>
<div class="page-title">
	<div class="title_left"></div>
</div>

<div class="clearfix"></div>

<?php if (count($utenti) < 1): ?>

<div id="no-project">
	<h1>ERRORE!!!!</h1>
	
</div>

<?php else: ?>
	
	    <div class="x_panel">
	        <div class="x_title">
	            <h2>Utenti</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('UserController@create') }}"><i class="fa fa-plus"></i></a></li>  <!-- link per creare nuovo progetto -->
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            
	            <div class="clearfix"></div>
	        </div>

	        <div class="x_content">	
	            <table class="table table-striped">  <!-- tabella per visualizzazione utenti -->
	                <thead>
	                    <tr>
	                        <th>Nome</th>
	                        <th>Cognome</th>
	                        <th>Ruolo</th>
	                        <th>Email</th>	                        
	                    </tr>
	                </thead>
	                <tbody>
						@foreach($utenti as $i)
							<tr>
								<td>{{ $i->name }}</td>
								<td>{{ $i->surname }}</td>
								<td>{{ $i->ruolo }}</td>
								<td>{{ $i->email }}</td>																
							
								<td><a href="{{ URL::action('DiarioController@viewdiario', $i->id) }}" class="link">Visualizza</a>								
								<td>
									<a href="{{ URL::action('UserController@edit', $i->id) }}" class="action-link fa fa-pencil"></a>																
									<a href="{{ URL::action('UserController@destroy', $i->id) }}" class="action-link link-danger del-link fa fa-close"></a> 
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
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>
@stop