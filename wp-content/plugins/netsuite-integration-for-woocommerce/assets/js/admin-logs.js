jQuery(document).ready(function ($) {
    var logList = $('#logList').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [//columns options
            {"orderable": true, "searchable": false, "width": "10%"},
            {"orderable": true, "searchable": false, "width": "15%"},
            {"orderable": true, "searchable": false, "width": "10%"},
            {"orderable": true, "searchable": true, "width": "10%"},
            {"orderable": false, "searchable": true, "width": "40%"},
            {"orderable": true, "searchable": false, "width": "15%"},
        ],
        "pagingType": "full_numbers", //pagination
        "order": [[0, "desc"]],
        "ajax": {
            "url": tmwni_admin_log.ajax_url,
            "type": "POST",
            "data": {'action': 'load_tmwni_logs'}
        }
    });


    $("#clearlogs").click(function(e){
        var val = $("#clearlogs").val();


        // if(window.confirm("This can't be undone?")){
            $('#loader-wrapper').show();
            $.ajax({
                type: "post",
                dataType: "html",
                url: tmwni_admin_log.ajax_url,
                data: {action: 'tm_clear_logs', form_data : val,nonce : tmwni_admin_log.nonce,},
                success: function (response) {
                    $("head").append('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">');
                    $('#loader-wrapper').hide();
                    if(response == 'failure'){
                      $.notify('oops! Something went wrong. Please try again', {type: "info", icon:"close",align:"right", color: "#fff", background: "#D44950"});
                        logList.ajax.reload();  
                    }else{
                        $.notify(" All logs have been successfully cleared", {type: "info", icon:"check",align:"right", color: "#fff", background: "#20D67B"});
                        logList.ajax.reload();                       
                    }
                }
            });
        // }
    });


    

});
