<!DOCTYPE html>
<!-- view con link ai fogli di stile (bootstrap, gentelella...) e per parti comuni dell'applicazione (barra laterale e superiore) -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
	    <!-- Bootstrap core CSS -->    
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	
		<!-- Custom styling plus plugins -->
	    <link rel="stylesheet" href="{{ URL::asset('vendor/css/animate.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('vendor/css/icheck/flat/green.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('vendor/css/gentelella.css') }}">
		
		<!-- Stile Custom -->
		<link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">		
		
		<!-- Fonts -->    
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

		<!-- Javascript -->
		<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

		<title>{{ config('app.name', 'Count On Us') }}</title>
	    
		<!-- CSRF Token -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Vue JS ed Axios -->
		<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
		<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    </head>

    <body class="nav-md">
		<div class="container body">
            <div class="main_container">
            	<div class="col-md-3 left_col">
					<div class="navbar nav_title" style="border: 2;">
                        <a href="{{ route('home') }}" class="site_title"><img src="{{ URL::asset('images/a.webp') }}" id="logo" /> <span>Count On Us</span></a> <!-- nome e logo -->
                        <br /> 
                        <!-- sidebar menu -->	
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li class="">
										<a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="">
										<?php if (Auth::user()->ruolo=="Admin"): ?>	<!-- barra laterale per admin -->										
                                            <li><a href="{{ URL::action('ProjectController@index') }}">Progetti</a></li>
											<li><a href="{{ URL::action('ClienteController@index') }}">Clienti</a></li>
                                            <li><a href="{{ URL::action('UserController@index') }}">Utenti</a></li>
										<?php else: ?> <!-- barra laterale per utente semplice -->
											<li><a href="{{ URL::action('DiarioController@viewdiario', Auth::user()->id) }}">Diario</a></li>
											<li><a href="{{ URL::action('DiarioController@create') }}">Inserisci scheda ore</a></li>
										<?php endif; ?>										
                                        </ul>
                                    </li>
								</ul>                                                
							</div>							           		
						</div>						        		
						
                    </div>  
					          		
            	</div>
				
				<div class="top_nav">
	                <div class="nav_menu">
	                    <nav class="" role="navigation">
	                        <div class="nav toggle">
	                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
	                        </div>
	                        <ul class="nav navbar-nav navbar-right">
                            	<li class="">
                                	<a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Ciao <?php echo Auth::user()->name; ?> <span class=" fa fa-angle-down"></span></a>
									<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    	<li><a href="{{ URL::action('Auth\LoginController@logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
									</ul>
								</li>
							</ul>
	                    </nav>
	                </div>
				</div>
				
            	<div class="right_col" role="main">
            		@yield('content')
	            </div>
				
            </div>
        </div>

	    <!-- Bootstrap core JS -->    
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	    
    	<!-- Bootstrap Colorpicker -->
    	<script type="text/javascript" src="{{ URL::asset('vendor/js/colorpicker/bootstrap-colorpicker.js') }}"></script>

	    <!-- Chart JS -->
		<script type="text/javascript" src="{{ URL::asset('vendor/js/chartjs/chart.min.js') }}"></script>
	    
	    <!-- Bootstrap progress JS -->
		<script type="text/javascript" src="{{ URL::asset('vendor/js/progressbar/bootstrap-progressbar.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('vendor/js/nicescroll/jquery.nicescroll.min.js') }}"></script>

	    <!-- icheck -->
		<script type="text/javascript" src="{{ URL::asset('vendor/js/icheck/icheck.min.js') }}"></script>

	    <!-- Gentelella -->
		<script type="text/javascript" src="{{ URL::asset('vendor/js/gentelella.js') }}"></script>
				
		<!-- Moment -->
		<script type="text/javascript" src="{{ URL::asset('vendor/js/moment.min2.js') }}"></script> 
		
		<!-- Date Range Picker -->
		<script type="text/javascript" src="{{ URL::asset('vendor/js/datepicker/daterangepicker.js') }}"></script> 		
		
    </body>
</html>