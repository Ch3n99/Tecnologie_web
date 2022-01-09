@extends('app')

@section('content')
<?php
//array per elencare mesi
$mesi=array(
    1 => "Gennaio",
    2 => "Febbraio",
    3 => "Marzo",
	4 => "Aprile",
	5 => "Maggio",
	6 => "Giugno",
	7 => "Luglio",
	8 => "Agosto",
	9 => "Settembre",
	10 => "Ottobre",
	11 => "Novembre",
	12 => "Dicembre"
);
?>

<?php if ((Auth::user()->ruolo=="Admin") || (Auth::user()->id==$user->id)): ?>
<!-- il diario è visualizzabile dall'admin o se l'utente in questione coincide con quello loggato -->
<div class="page-title">
	<div class="title_left"></div>
</div>

<div class="clearfix"></div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Utente {{ $user->surname }} {{ $user->name }}</h1>
	<?php if (count($progetti) < 1): ?>

	<div id="no-project">
		<h2>L'utente non sta lavorando a nessun progetto</h2>
	</div>

	<?php else: ?>
	    <div class="x_panel">
	        <div class="x_title">
			<h2>Progetti</h2>

			<ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
			<div class="clearfix"></div>
	        </div>
	            
                
			<div class="x_content">
                <table class="table table-striped">  <!-- tabella per mostrare elenco progetti a cui l'utente è assegnato -->
	                <thead>
	                    <tr>
                            <th>Nome progetto</th>
                            <th>Descrizione</th>                         
	                        <th>Cliente di riferimento</th>
	                        <th>Costo orario</th>
							<th></th>
	                    </tr>
	                </thead>
	                <tbody>  
						@foreach($progetti as $i)
							<tr class="row-category">
                                <td>{{ $i->name }}</td>
								<td>{{ $i->description }}</td>
								<td>{{ $i->ragsoc }}</td>
                                <td>{{ $i->hour_cost }} €</td>
								<td><a href="{{ URL::action('AssegnazioneController@destroy', $i->id) }}" class="action-link link-danger del-link fa fa-close"></a> </td>
							</tr>
						@endforeach	
	                </tbody>
	            </table>
            
			</div>
	        </div>
			</br></br>
			<!-- form per inserimento mese e anno di cui si vuole visualizzare il diario -->
			<form id="form-period" method="get" action="{{ URL::action('DiarioController@viewdiario', $user->id) }}" class="form-horizontal form-label-left">
	                                <div class="input-prepend input-group">
									<div class="col-md-4 col-sm-4 col-xs-12">
									<select class="form-control" id="month" name="mese"> <!-- menù a tendina per vedere i mesi -->
									<?php
										for ($i = 1; $i <= 12; $i++) {
											if($i==$month)
												echo "<option selected=\"selected\" value=\"$i\">$mesi[$i]</option>\n";
											else
												echo "<option value=\"$i\">$mesi[$i]</option>\n";
										}
									?>
                            	    </select>
								    </div>
								    <div class="col-md-3 col-sm-3 col-xs-12">
								    <select class="form-control" id="year" name="anno"> <!-- menù a tendina per vedere gli anni -->
								    <?php
								    for ($i = 2015; $i <= 2065; $i++) {
									    if($i==$year)
												echo "<option selected=\"selected\" value=\"$i\">$i</option>\n";
											else
												echo "<option value=\"$i\">$i</option>\n";
									    }
								    ?>
							        </select>
								    </div>
								    <div class="col-md-2 col-sm-2 col-xs-12">
										<a href="javascript:void(0);" id="reset" style="margin-left: 5px; margin-right: 20px; font-size: 18px;"><i class="fa fa-refresh"></i></a>											
								    </div>
								    <div class="col-md-3 col-sm-3 col-xs-12">	
										<button type="submit" style="margin-left: 2px; margin-bottom: 0px;" id="submit-period" class="btn btn-primary">Imposta</button>
								    </div>
									</div>
								    </form>
	    </div>
	</br></br>
	<?php if (count($diari) < 1): ?>

	<div id="no-project">
		<h2>Nessun diario per il periodo selezionato</h2>
	</div>

	<?php else: ?>
        <div class="x_panel">
	        <div class="x_title">
	            <h2>Diario mensile</h2>
                
	            <ul class="nav navbar-right panel_toolbox">
					<?php if(Auth::user()->id==$user->id): ?> <!-- gli inserimenti nel diario possono essere fatti solo dall'utente in questione -->
					<li><a class="add-link" href="{{ URL::action('DiarioController@create') }}"><i class="fa fa-plus"></i></a></li>
					<?php endif; ?>
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
				<div class="clearfix"></div>
	        </div>
			<div class="x_content">
                <table class="table table-striped"> <!-- tabella per mostrare diario mensile dell'utente -->
	                <thead>
	                    <tr>
                            <th>Data</th>
                            <th>Note</th>
	                        <th>Nome progetto</th>
                            <th>Numero ore</th>
							<th></th>                                                
	                    </tr>
	                </thead>
	                <tbody>  
						@foreach($diari as $i)
							<tr class="row-category">
                                <td>{{ $i->data }}</td>
                                <td>{{ $i->note }}</td>
                                <td>{{ $i->name }}</td>
								<td>{{ $i->num_ore }} h</td>
								<td>
								<?php if(Auth::user()->id==$user->id): ?> <!-- modifiche e cancellazioni possono essere fatti solo dall'utente in questione -->
									<a href="{{ URL::action('DiarioController@edit', $i->id) }}" class="action-link fa fa-pencil"></a>																
									<a href="{{ URL::action('DiarioController@destroy', $i->id) }}" class="action-link link-danger del-link fa fa-close"></a>
								<?php endif; ?>
								</td>							
							</tr>
						@endforeach	
	                </tbody>
                    <tfoot>
                            <tr>
                                <th>Totale </th>
                                <th></th>
                                <th></th>
                                <th>{{ number_format($tot, 2) }} h</th>
								<th></th>
                            </tr>
                    </tfoot>
	            </table>
	            
	            <div class="clearfix"></div>
	        </div>
	</div>	
</div>
<?php endif; ?>
<?php endif; ?>
<script type="text/javascript" src="{{ URL::asset('js/date.js') }}"></script>
<?php else: ?>
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>
@stop