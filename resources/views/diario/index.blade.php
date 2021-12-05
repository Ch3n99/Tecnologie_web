@extends('app')
@section('content')
<?php
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
<?php if (Auth::user()->ruolo=="Semplice"): ?>
<div class="x_panel">
	<h2>Diario dell'utente {{$user->surname}} {{$user->name}}</h2>
	<div class="clearfix"></div>
	</div>
<div class="x_panel">
	        <div class="x_title">
	        	<h2>Imposta Periodo</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
	            </ul>	        	
				<div class="clearfix"></div>
	        </div>
	        <div class="x_content" style="display:none;">	
				<div class="well">
                    <fieldset id="period">
                        <div class="control-group">
                            <div class="controls">
								<form id="form-period" method="get" action="{{ URL::action('DiarioController@index') }}" class="form-horizontal form-label-left">
	                                <div class="input-prepend input-group">
									<div class="col-md-4 col-sm-4 col-xs-12">
									<select class="form-control" id="month" name="mese">
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
								<select class="form-control" id="year" name="anno">
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
                        </div>
                    </fieldset>
	            </div>
			</div>
        </div>
		<?php if (count($diari) < 1): ?>
		<div>
			<h1>Nessuna scheda ore inserita per il periodo selezionato</h1>
				<h2>
	            <a href="{{ URL::action('DiarioController@create') }}">Aggiungi nuova scheda ore</a>
				</h2>
		</div>

		<?php else: ?>
        <div class="x_title">
	            <h2>Diario per il periodo selezionato</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="add-link" href="{{ URL::action('DiarioController@create') }}"><i class="fa fa-plus"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
	        </div>
<div class="x_content">	        
	        	<div class="col-md-6 col-sm-6 col-xs-12">
		            <table id="table-summary" class="table table-striped">
		                <thead>
		                    <tr>
								<th>Data</th>
                                <th>Nome progetto</th>
                                <th>Numero ore</th>
                                <th>Note</th>
		                    </tr>
		                </thead>

		                <tbody>			
		                	@foreach ($diari as $d)
								<tr>										
                                    <td>{{ date('Y-m-d', strtotime($d->data)) }}</td>             
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->num_ore }} h</td>
                                    <td>{{ $d->note }}</td>
									<td>
									<a href="{{ URL::action('DiarioController@edit', $d->id) }}" class="action-link fa fa-pencil"></a>														
									<a href="{{ URL::action('DiarioController@destroy', $d->id) }}" onClick="return confirm('Sei sicuro di voler cancellare questa riga?')" class="action-link link-danger fa fa-close"></a>
								</td>		
								</tr>
		                	@endforeach
		                </tbody>
		                <tfoot>
							<tr>						
								<th><strong>Totale ore</strong></th>
								<th></th>
								<th>{{ number_format($tot, 2) }} h</th>	
								<th></th>	
								<th></th>													
							</tr>
						</tfoot>
		            </table>	
		            
					<br/>

<?php endif; ?>
<script type="text/javascript" src="{{ URL::asset('js/date.js') }}"></script> 
<?php else: ?>
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>
@stop