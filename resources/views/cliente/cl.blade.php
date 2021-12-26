@extends('app')

@section('content')
<div>
	<h1>Cliente {{ $cliente->ragsoc }}</h1>	
    <?php if (count($projects) < 1): ?>
    <div id="no-project">
	    <h2>Non ci sono progetti relativi a questo cliente</h2>
	    <a href="{{ URL::action('ProjectController@create') }}">Assegna un nuovo utente a questo progetto</a>
    </div>
    <?php else: ?>
		<form id="form-period" method="get" action="{{ URL::action('ClienteController@viewcliente', $cliente->id) }}" class="form-horizontal form-label-left">
	        <div class="input-prepend input-group">
                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
					<input type="text" style="width: 150px" name="date-period-begin" id="date-period-begin" class="form-control date-period" value="{{ $begin->toDateString() }}">
					<input type="text" style="width: 150px" name="date-period-end" id="date-period-end" class="form-control date-period" value="{{ $end->toDateString() }}">
					<a href="javascript:void(0);" id="period-reset" style="margin-left: 5px; margin-right: 20px; font-size: 18px;"><i class="fa fa-refresh"></i></a>											
					<button type="submit" style="margin-left: 2px; margin-bottom: 0px;" id="submit-period" class="btn btn-primary">Imposta</button>
	         </div>
		</form>
        <div class="x_panel">
	        <div class="x_title">
	            <h2>Attività di lavoro per il cliente nel periodo selezionato</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            
	            <div class="clearfix"></div>
	        </div>

	        <div class="x_content">	
	            <table class="table table-striped">  <!-- tabella per visualizzazione utenti assegnati al progetto con numero ore di lavoro -->
	                <thead>
	                    <tr>
	                        <th>Nome</th>
	                        <th>Cognome</th>
							<th>Ore di lavoro</th>
	                    </tr>
	                </thead>
	                <tbody>
						@foreach($ore_cl as $i)
							<tr>
								<td>{{ $i['nome_utente'] }}</td>
								<td>{{ $i['cognome_utente'] }}</td>
								<td>{{ number_format($i['tot'],2) }} h</td>										
							</tr>
						@endforeach
	                </tbody>
					<tfoot>
					<tr>
	                        <th>Totale ore</th>
	                        <th></th>
							<th>{{ number_format($ore_tot,2) }} h</th>
	                    </tr>
					</tfoot>
	            </table>
	        </div>
	    </div>
		<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="hidden" id="encoded_ore_cl_list" value="{{ json_encode($ore_cl) }}" />
						<canvas id="split_pie"></canvas>	        
		</div>
	<script type="text/javascript">	

	$(document).ready(function() { 	    
		
		var h = JSON.parse( $('#encoded_ore_cl_list').val() );

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
</div>
<script type="text/javascript" src="{{ URL::asset('js/date.js') }}"></script>
@stop