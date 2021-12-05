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
	            <h2>Clienti</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('ClienteController@create') }}"><i class="fa fa-plus"></i></a></li>
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            
	            <div class="clearfix"></div>
	        </div>
			
			@if ($errors->any())
				<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<p>Non posso completare la richiesta:</p>
                    <ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
                    </ul>
                </div>
			@endif

	        <div class="x_content">	
	            <table class="table table-striped">
	                <thead>
	                    <tr>
                            <th>Ragione sociale</th>                         
	                        <th>Nome</th>
	                        <th>Cognome</th>
	                        <th>Email</th>	                       
							<th>Dettagli aggiuntivi</th>
							<th>Azioni</th>
	                    </tr>
	                </thead>
	                <tbody>
	                
						@foreach($clienti as $cliente)
							<tr class="row-category">
                                <td>{{ $cliente['ragsoc'] }}</td>
								<td>{{ $cliente['name'] }}</td>
								<td>{{ $cliente['surname'] }}</td>
								<td>{{ $cliente['email'] }}</td>
								<td>
								<a href="{{ URL::action('ClienteController@query2', $cliente->id) }}" class="link">Visualizza</a>	
								</td>	
								<td>
									<a href="{{ URL::action('ClienteController@edit', $cliente['id']) }}" class="action-link fa fa-pencil"></a>																									
									<a href="{{ URL::action('ClienteController@destroy', $cliente['id']) }}" onClick="return confirm('Sei sicuro di voler cancellare questa riga?')" class="action-link link-danger fa fa-close"></a>
								</td>
							</tr>
						@endforeach
						
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>	
</div>
<?php else: ?>
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>
@stop