@extends('app')

@section('content')
<?php if(($user->ruolo=='Semplice') && ((Auth::user()->ruolo=="Admin") || (Auth::user()->id==$user->id))): ?>
<div class="page-title">
	<div class="title_left"></div>
</div>
<?php if (count($projects) < 1): ?>
	<div>
		<h1>Non ci sono progetti assegnati all'utente {{$user->surname}} {{$user->name}}</h1>
		<?php if(Auth::user()->ruolo=="Admin"): ?>
		<a href="{{ URL::action('AssegnazioneController@createv1',$user->id) }}">Assegna un progetto all'utente</a>
		<?php endif; ?>
	</div>
<?php else: ?>
<div class="x_panel">
<div class="x_title">
<h2>Elenco progetti per l'utente {{$user->surname}} {{$user->name}}</h2>
<ul class="nav navbar-right panel_toolbox">
				<?php if(Auth::user()->ruolo=="Admin"): ?>
	                <li><a class="add-link" href="{{ URL::action('AssegnazioneController@createv1',$user->id) }}"><i class="fa fa-plus"></i></a></li>
				<?php endif; ?>
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
<div class="clearfix"></div>
</div>
<div class="row">
	    <div class="x_content">	
	            <table class="table table-striped">
				<thead>
		                    <tr>
								<th>Nome progetto</th>
								<th>Descrizione</th>
								<th>Data inizio</th>
								<th>Data fine prevista</th>
								<th>Data fine effettiva</th>
								<th>Costo orario</th>
								<th>Cliente di riferimento</th>
								<th>Mail cliente</th>
								<?php if (Auth::user()->ruolo=="Admin"): ?>
                                <th>Ulteriori dettagli</th>
								<th></th>
								<?php endif; ?>
		                    </tr>
		                </thead>

		                <tbody>			
		                	@foreach ($projects as $p)
								<tr>										
                                    <td>{{ $p->name }}</td>
									<td>{{ $p->description }}</td>
									<td>{{ $p->date_start }}</td>
									<td>{{ $p->date_end_prev }}</td>
									<td>{{ $p->date_end_eff }}</td>
									<td>{{ $p->hour_cost }} €</td>
									<td>{{ $p->ragsoc }}</td>
									<td>{{ $p->email }}</td>
									<?php if (Auth::user()->ruolo=="Admin"): ?>
                                    <td><a href="{{ URL::action('ProjectController@query1', $p->id) }}">Visualizza</a></td>
									<?php endif; ?>
									<td><a href="{{ URL::action('AssegnazioneController@destroy', $p->id_asseg) }}" onClick="return confirm('Sei sicuro di voler cancellare questa riga?')" class="action-link link-danger fa fa-close"></a></td>			
								</tr>
                                
		                	@endforeach
		                </tbody>	
	            </table>
	    </div>
</div>
</br> </br>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="col-md-6 col-sm-6 col-xs-12">
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
								<form id="form-period" method="get" action="{{ URL::action('UserController@query3', $user->id) }}" class="form-horizontal form-label-left">
	                                <div class="input-prepend input-group">
                                    	<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" style="width: 150px" name="date-period-begin" id="date-period-begin" class="form-control date-period" value="{{ $begin->toDateString() }}">
										<input type="text" style="width: 150px" name="date-period-end" id="date-period-end" class="form-control date-period" value="{{ $end->toDateString() }}">
										<a href="javascript:void(0);" id="period-reset" style="margin-left: 5px; margin-right: 20px; font-size: 18px;"><i class="fa fa-refresh"></i></a>											
										<button type="submit" style="margin-left: 2px; margin-bottom: 0px;" id="submit-period" class="btn btn-primary">Imposta</button>
	                                </div>
								</form>
                            </div>
                        </div>
                    </fieldset>
	            </div>
			</div>
        </div>
		</br></br>		
		<?php if (count($ore_prog) < 1): ?>
		<div>
			<h2>Non ci sono attività per l'utente {{$user->surname}} {{$user->name}} durante il periodo selezionato</h2>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<?php if (Auth::user()->id==$user->id): ?>
				<a href="{{ URL::action('DiarioController@index', $user->id) }}"><button type="submit" class="btn btn-primary" style="color:white">Visualizza diario</button></a>
			<?php endif ?>
			</div>
		</div>

		<?php else: ?>
			<div class="x_panel">
	            <h2>Ore di lavoro dell'utente {{$user->surname}} {{$user->name}} durante il periodo selezionato</h2>
	            <div class="clearfix"></div>
			</div>
<div class="x_content">	        
		            <table id="table-summary" class="table table-striped">
		                <thead>
		                    <tr>
								<th>Nome progetto</th>
                                <th>Cliente di riferimento</th>
		                        <th>Numero ore</th>
		                    </tr>
		                </thead>

		                <tbody>			
		                	@foreach ($ore_prog as $ore)
                           
								<tr>										
                                    <td>{{ $ore['progetto_name'] }}</td>
                                    <td>{{ $ore['rag_soc'] }}</td>
									<td>{{ number_format($ore['tot'], 2) }} h</td>
								</tr>
                                
		                	@endforeach
		                </tbody>

						<tfoot>
							<tr>						
								<th><strong>Totale</strong></th>
                                <th></th>
								<th>{{ number_format($ore_tot, 2) }} h</th>															
							</tr>
						</tfoot>		                
		            </table>	
		            
					</div>
	            	<div class="col-md-6 col-sm-6 col-xs-12">
					<?php if (Auth::user()->id==$user->id): ?>
					<a href="{{ URL::action('DiarioController@index', $user->id) }}"><button type="submit" class="btn btn-primary" style="color:white">Visualizza diario</button></a>
					<?php endif ?>
					</div>
				</div>

					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="hidden" id="encoded_ore_prog_list" value="{{ json_encode($ore_prog) }}" />
						<canvas id="split_pie"></canvas>	        
					</div>
					</div>
</div> 

<script type="text/javascript">	
	
	$(document).ready(function() { 	    
		
		var h = JSON.parse( $('#encoded_ore_prog_list').val() );

		var splitData 	= [];
		for (i=0; i < h.length; i++) {
			var _color = randomColor(i);
			var data = {
				value: parseFloat(h[i].tot),
				color: _color,
				highlight: _color,
				label: h[i].progetto_name
			}
			
			splitData.push(data);	
			
			$('#table-split .color-' + i).css('background-color', _color);
		}

		window.myPie = new Chart(document.getElementById("split_pie").getContext("2d")).Pie(splitData, {
            responsive: true,
            tooltipFillColor: "rgba(51, 51, 51, 0.55)"
        });

	function randomColor(index) {
			var colours = ['#4E9FA5','#F26522', '#FFCD33', '#4E7EA5', '#A54E7C', '#676766'];
			if (index < 0 || index > colours.length-1) {
				return getRandomColor();
			}
			
			return colours[index]
		}

		/** 
		 * Ritorna un colore generto casualmente 
		 */ 
		function getRandomColor() {
			var letters = '0123456789ABCDEF'.split('');
			var color = '#';
			for (var i = 0; i < 6; i++ ) {
				color += letters[Math.floor(Math.random() * 16)];
			}	
			
			return color;
		}
	});
	
</script>
				
<?php endif; ?>
<?php endif; ?>
<script type="text/javascript" src="{{ URL::asset('js/date.js') }}"></script> 
<?php else: ?>
	<h2>Non hai il permesso per accedere a questa pagina</h2>
<?php endif; ?>				
@stop