@extends('app')

@section('content')
<?php if (Auth::user()->ruolo=="Admin"): ?>
<div class="page-title">
	<div class="title_left"></div>
</div>
<?php if (count($ass)<1): ?>
	<div>
		<h1>Non ci sono utenti assegnati al progetto {{$project->name}}</h1>
		<?php if(Auth::user()->ruolo=="Admin"): ?>
		<a href="{{ URL::action('AssegnazioneController@createv2',$project->id) }}">Assegna il progetto a un utente</a>
		<?php endif; ?>
	</div>
<?php else: ?>
	<div class="x_panel">
	<div class="x_title">
<?php if ($project->date_end_eff == NULL): ?>
	    <h2>Utenti a cui è attualmente assegnato il progetto {{$project->name}}</h2>
<?php else: ?>
		<h2>Utenti a cui era assegnato il progetto {{$project->name}}</h2>
<?php endif; ?>
<ul class="nav navbar-right panel_toolbox">
		<?php if(Auth::user()->ruolo=="Admin"): ?>
	        <li><a class="add-link" href="{{ URL::action('AssegnazioneController@createv2',$project->id) }}"><i class="fa fa-plus"></i></a></li>
		<?php endif; ?>
	    </ul>
<div class="clearfix"></div>
</div>
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-12">
	    <div class="x_content">	
	            <table class="table table-striped">
				<thead>
		                    <tr>
								<th>Cognome utente</th>
								<th>Nome utente</th>
                                <th></th>
		                    </tr>
		                </thead>

		                <tbody>			
		                	@foreach ($ass as $a)
								<tr>										
                                    <td>{{ $a->surname }}</td>
									<td>{{ $a->name }}</td>
                                    <td><a href="{{ URL::action('AssegnazioneController@destroy', $a->id) }}" onClick="return confirm('Sei sicuro di voler cancellare questa riga?')" class="action-link link-danger fa fa-close"></a></td>			
								</tr>
                                
		                	@endforeach
		                </tbody>	
	            </table>
	    </div>
	</div>	
</div>
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
								<form id="form-period" method="get" action="{{ URL::action('ProjectController@query1', $id) }}" class="form-horizontal form-label-left">
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
			<h2>Non ci sono attività in corso per il progetto {{$project->name}} durante il periodo selezionato</h2>
		</div>

		<?php else: ?>
        <div class="x_panel">
	            <h2>Ore di lavoro per il progetto {{$project->name}} durante il periodo selezionato</h2>
	            <div class="clearfix"></div>
	    </div>
		<div class="x_content">
		<table id="table-summary" class="table table-striped">
		                <thead>
		                    <tr>
								<th>Cognome utente</th>
                                <th>Nome utente</th>
		                        <th>Numero ore</th>
		                    </tr>
		                </thead>

		                <tbody>			
		                	@foreach ($ore_prog as $ore)
                           
								<tr>										
                                    <td>{{ $ore['cognome_utente'] }}</td>
                                    <td>{{ $ore['nome_utente'] }}</td>
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
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="hidden" id="encoded_ore_prog_list" value="{{ json_encode($ore_prog) }}" />
						<canvas id="split_pie"></canvas>	        
		</div>
		</div>
		<div>
			<?php if ($project->date_end_eff == NULL): ?>
				<h2 id="costo">Il costo per il periodo selezionato è {{$costo_tot}} € </h2>
			<?php else: ?>
				<h2 id="costo">Il costo totale è {{$costo_tot}} € </h2>
			<?php endif; ?>
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
				label: h[i].cognome_utente
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
