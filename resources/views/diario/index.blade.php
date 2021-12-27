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
<div class="page-title">
	<div class="title_left"></div>
</div>

<div class="clearfix"></div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Utente {{ $user->surname }} {{ $user->name }}</h1>
	    <div class="x_panel">
	        <div class="x_title">
	            <h2>Progetti</h2>
                
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
                <table class="table table-striped">
	                <thead>
	                    <tr>
                            <th>Nome progetto</th>
                            <th>Descrizione</th>                         
	                        <th>Cliente di riferimento</th>
	                        <th>Costo orario</th>
	                    </tr>
	                </thead>
	                <tbody>  
						@foreach($progetti as $i)
							<tr class="row-category">
                                <td>{{ $i->name }}</td>
								<td>{{ $i->description }}</td>
								<td>{{ $i->id_cliente }}</td>
                                <td>{{ $i->hour_cost }} €</td>
							
							</tr>
						@endforeach	
	                </tbody>
	            </table>
	            
	            <div class="clearfix"></div>
	        </div>
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
        <div class="x_title">
	            <h2>Progetti</h2>
                
	            <ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
                <table class="table table-striped">
	                <thead>
	                    <tr>
                            <th>Data</th>
                            <th>Note</th>
	                        <th>Nome progetto</th>
                            <th>Numero ore</th>                                                
	                    </tr>
	                </thead>
	                <tbody>  
						@foreach($diari as $i)
							<tr class="row-category">
                                <td>{{ $i->data }}</td>
                                <td>{{ $i->note }}</td>
                                <td>{{ $i->name }}</td>
								<td>{{ $i->num_ore }} h</td>							
							</tr>
						@endforeach	
	                </tbody>
                    <tfoot>
                            <tr>
                                <th>Totale </th>
                                <th></th>
                                <th></th>
                                <th>{{ number_format($tot, 2) }} h</th>
                            </tr>
                    </tfoot>
	            </table>
	            
	            <div class="clearfix"></div>
	        </div>
	</div>	
</div>
<script type="text/javascript" src="{{ URL::asset('js/date.js') }}"></script>
@stop