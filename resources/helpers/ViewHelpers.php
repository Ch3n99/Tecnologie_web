<?php	

	/*
	|--------------------------------------------------------------------------
	| Metodi Helper
	|--------------------------------------------------------------------------
	|
	| Questo file è caricato automaticamente perchè è incluso nella chiave 
	| "autoload" del file composer.json:
	|
	|    "files": [
    |        "resources/helpers/ViewHelpers.php"
    |    ]
	| 
	| Quando vengono fatti i cambiamenti al file composer.json è necessario 
	| ricaricarlo con il comando:
	| $ composer dump-autoload
	|
	*/
	
	use Carbon\Carbon;
		
	function human_date($date) {
		if ($date != null) {
			return Carbon::parse($date)->format("d/m/Y"); 
		}
		
		return Carbon::now()->format("d/m/Y"); 
	}
		
?>
