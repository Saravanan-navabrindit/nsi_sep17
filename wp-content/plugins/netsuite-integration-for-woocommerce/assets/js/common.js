jQuery(document).ready(function ($) {
	
	var tab = getUrlParameter('tab');
    if(undefined == tab){
        $('.dashboard_tab').addClass('nav-tab-active');
    }else{
     $('.'+tab+'_tab').addClass('nav-tab-active');
     if(tab == 'general_settings' || tab == 'inventory_settings' || tab == 'customer_settings' || tab == 'logs' || tab == 'order_settings' || tab == 'import_export_settings'){
        $('.setting_tab').addClass('nav-tab-active');
    } 
}




function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

});