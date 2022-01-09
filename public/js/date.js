$(document).ready(function () {
    //serve per far apparire calendario quando inserisco date
    $('.date-period').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_4",
        format: 'YYYY-MM-DD',
        locale: { 
            daysOfWeek: [ "Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab" ],
            monthNames: [ "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre" ],
            firstDay: 1,
        }
    }, function (start, end, label) {
    });  
    
    //serve a ripristinare i valori di default se schiaccio la rotella (nel caso di dettagli progetti e clienti)
    $('#period-reset').click(function() {
        var d = new Date();
        var curr_date 	= d.getDate();
        var curr_month 	= d.getMonth()+1;
        var curr_year 	= d.getFullYear();

        if (curr_month < 10) {
            curr_month = "0"+curr_month;
        }
        if (curr_date < 10) {
            curr_date = "0"+curr_date;
        }
        var begin 	= curr_year+"-"+curr_month+"-01";
        if(curr_month==04 || curr_month==06 || curr_month==09 || curr_month==11)
            var end 	= curr_year+"-"+curr_month+"-30";
        if(curr_month==01 || curr_month==03 || curr_month==05 || curr_month==07 || curr_month==08 || curr_month==10 || curr_month==12)
            var end 	= curr_year+"-"+curr_month+"-31";
        if(curr_month==02 && curr_year%4!=0)
            var end 	= curr_year+"-"+curr_month+"-28";
        if(curr_month==02 && curr_year%4==0)
            var end 	= curr_year+"-"+curr_month+"-29";

        $('#date-period-begin').val(begin);
        $('#date-period-end').val(end);
    });		

    //serve a ripristinare i valori di default se schiaccio la rotella (nel caso del diario dell'utente)
    $('#reset').click(function() {

        var d = new Date();
        var curr_month 	= d.getMonth()+1;
        var curr_year 	= d.getFullYear();

        var begin 	= curr_month;
        var end = curr_year

        $('#month').val(begin);
        $('#year').val(end);
    });	
    
});
