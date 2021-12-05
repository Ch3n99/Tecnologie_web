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
	            <h2>Utenti amministratori</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('UserController@create') }}"><i class="fa fa-plus"></i></a></li>
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
	                        <th>Nome</th>
	                        <th>Cognome</th>
	                        <th>Email</th>	
							<th>Ruolo</th>                    
	                        <th>Azioni</th>
	                    </tr>
	                </thead>
	                <tbody>
	                
						@foreach($users as $user)
							@if($user['ruolo']=="Admin")
							<tr class="row-category">
								<td>{{ $user['name'] }}</td>
								<td>{{ $user['surname'] }}</td>
								<td>{{ $user['email'] }}</td>
								<td>{{ $user['ruolo'] }}</td>
								<td>									
									<a href="{{ URL::action('UserController@edit', $user['id']) }}" class="action-link fa fa-pencil"></a>																									
									<a href="{{ URL::action('UserController@destroy', $user['id']) }}" onClick="return confirm('Sei sicuro di voler cancellare questa riga?')" class="action-link link-danger fa fa-close"></a>
								</td>
							</tr>
							@endif
						@endforeach
						
	                </tbody>
	            </table>
	        </div>
	    </div>
		<div class="x_panel">
	        <div class="x_title">
	            <h2>Utenti semplici</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('UserController@create') }}"><i class="fa fa-plus"></i></a></li>
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
	                        <th>Nome</th>
	                        <th>Cognome</th>
	                        <th>Email</th>	
							<th>Ruolo</th>
							<th>Assegnazioni</th>                        
	                        <th>Azioni</th>
	                    </tr>
	                </thead>
	                <tbody>
	                
						@foreach($users as $user)
							@if($user['ruolo']=="Semplice")
							<tr class="row-category">
								<td>{{ $user['name'] }}</td>
								<td>{{ $user['surname'] }}</td>
								<td>{{ $user['email'] }}</td>
								<td>{{ $user['ruolo'] }}</td>
								<td>
									<a href="{{ URL::action('UserController@query3', $user['id']) }}" class="link">Visualizza</a></td>
								<td>									
									<a href="{{ URL::action('UserController@edit', $user['id']) }}" class="action-link fa fa-pencil"></a>																									
									<a href="{{ URL::action('UserController@destroy', $user['id']) }}" onClick="return confirm('Sei sicuro di voler cancellare questa riga?')" class="action-link link-danger fa fa-close"></a>
								</td>
							</tr>
							@endif
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
