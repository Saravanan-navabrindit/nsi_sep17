jQuery(document).ready(function ($) {





		
 var dataRecords = $('#dashboardList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,			
		'serverMethod': 'post',		
		"order": [[0, "desc"]],
		"ajax":{
			url:tmwni_admin_dashboard.ajax_url,
			type:"POST",
			data:{action:'order_logs',nonce : tmwni_admin_dashboard.nonce},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[3,5],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	


 //Clear dashboard logs
    $("#cleardashboardlogs").click(function(e){
        var val = $("#cleardashboardlogs").val();



        // if(window.confirm("This can't be undone?")){
            $('#loader-wrapper').show();
            $.ajax({
                type: "post",
                dataType: "html",
                url: tmwni_admin_dashboard.ajax_url,
                data: {action: 'tm_clear_dashboard_logs', form_data : val,nonce : tmwni_admin_dashboard.nonce,},
                success: function (response) {
                    $("head").append('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">');
                    $('#loader-wrapper').hide();
                    if(response == 'failure'){
                      $.notify('oops! Something went wrong. Please try again', {type: "info", icon:"close",align:"right", color: "#fff", background: "#D44950"});
                        dataRecords.ajax.reload();  
                    }else{
                        $.notify(" All logs have been successfully cleared", {type: "info", icon:"check",align:"right", color: "#fff", background: "#20D67B"});
                        dataRecords.ajax.reload();                       
                    }
                }
            });
        // }
    });






 jQuery( document ).on( "click", ".manual_order_sync",function(e) {
		e.preventDefault();
		var id = jQuery(this).attr('data-id');  
		var btnEventListener = $(this);
		btnEventListener.css('display', 'none');
		table = jQuery('#dashboardList').dataTable();


		jQuery.ajax({
			type: "post",
			dataType: "html",
			url: tmwni_admin_dashboard.ajax_url,
			data: {action: 'manual_order_sync',order_id:id,nonce: tmwni_admin_dashboard.nonce},
			beforeSend: function() {
				btnEventListener.closest('.manually_order_sync_btn').find('span.loaderSpiner').append('<i class="glyphicon glyphicon-refresh glyphicon-spin manually_order_sync_spiner" ></i>');

			},
			success: function (response) {
			btnEventListener.closest('.manually_order_sync_btn').find('span.loaderSpiner').hide();
			console.log(response);

				if (response == 0 || response == '' || response == 00) {
					$.notify('oops! Something went wrong. Please try again', {type: "info", icon:"close",align:"right", color: "#fff", background: "#D44950"});
				} else {
					$.notify(" Order has been successfully synced to NetSuite", {type: "info", icon:"check",align:"right", color: "#fff", background: "#20D67B"});
				}
				btnEventListener.css('display', 'block');
				// jQuery('#dashboardList').DataTable().ajax.reload();
        		table.fnDraw();



			},
			error: function (response) {
				btnEventListener.closest('.manually_order_sync_btn').find('span.loaderSpiner').hide();
				$.notify('oops! Something went wrong. Please try again', {type: "info", icon:"close",align:"right", color: "#fff", background: "#D44950"});

				btnEventListener.css('display', 'block');
				table.fnDraw();


			},

		});
	});	







	





	


});