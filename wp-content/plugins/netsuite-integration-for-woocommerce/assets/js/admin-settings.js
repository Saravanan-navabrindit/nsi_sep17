function tm_ns_validateForm() {
  var isValid = true;
  jQuery('#ns_general_settings_form input').each(function() {
    if ( jQuery(this).val() === '' )
        isValid = false;
});
  return isValid;
}

jQuery(document).ready(function ($) {


    $("#ns_promo_custform_id").attr('placeholder', 'NS Promo Custom Form ID' );
    $("#ns_promo_discount_id").attr('placeholder', 'NS Promo Discount ID' );
    $("#sku_mapping_custom_field").attr('placeholder', 'Custom Field ID' );
    $("#ns_order_tracking_number").attr('placeholder', 'Tracking Number Meta Key' );
    $("#ns_order_shipping_courier").attr('placeholder', 'Shipping courier Meta Key' );
    $("#ns_order_pickup_date").attr('placeholder', 'Order Pickup Date Meta Key');
    $("#importfile").attr('accept', 'application/json');




    makeSelectfieldsSelect2($);
    $('#ns_order_shiping_line_item_enable').click(function(){
        if($('#ns_order_shiping_line_item_enable:checked').length > 0){
            // $('#ns_order_shiping_line_item').css('display','');
            $('#ns_order_shiping_line_item').removeClass('ns_order_shiping_line_item');
            $("input[name='ns_order_shiping_line_item']").prop('required',true);
        }else{
            $('#ns_order_shiping_line_item').addClass('ns_order_shiping_line_item');
            $("input[name='ns_order_shiping_line_item']").prop('required',false);
            // $('#ns_order_shiping_line_item').css('display','none');
        }
    });



    $('#enableFulfilmentSync').click(function(){
        if($('#enableFulfilmentSync:checked').length > 0){
            // $('#ns_order_shiping_line_item').css('display','');
            $('#order_fulfilment_fields').removeClass('order_fulfilment_fields');
        }else{
            $('#order_fulfilment_fields').addClass('order_fulfilment_fields');
            // $('#ns_order_shiping_line_item').css('display','none');
        }
    });


    $('#enableOrderSync').click(function(){
        if($('#enableOrderSync:checked').length > 0){
            // $('#ns_order_shiping_line_item').css('display','');
            $('#order_enable_fields').removeClass('order_enable_fields');
        }else{
            $('#order_enable_fields').addClass('order_enable_fields');
            // $('#ns_order_shiping_line_item').css('display','none');
        }
    });

    $('#refund_order_ns_to_woo').click(function(){
        if($('#refund_order_ns_to_woo:checked').length > 0){
            // $('#ns_order_shiping_line_item').css('display','');
            $('#refundOrderStatus').removeClass('order_refund_fields_enable');
        }else{
            $('#refundOrderStatus').addClass('order_refund_fields_enable');
            // $('#ns_order_shiping_line_item').css('display','none');
        }
    });




    // $('#ns_order_shiping_line_item_enable').click(function(){
    //     if($('#ns_order_shiping_line_item_enable:checked').length > 0){
    //         $('#ns_order_shiping_line_item').removeClass('ns_order_shiping_line_item');
    //         // $('#ns_order_shiping_line_item').css('display','');
    //     }else{
    //         $('#ns_order_shiping_line_item').addClass('ns_order_shiping_line_item');
    //         // $('#ns_order_shiping_line_item').css('display','none');
    //     }
    // });


    $("input:radio[name='order_item_location']").on('change',function(){
        if($(this).val() == 3){
            // $(".hidden_tr_input").show();
            $("#hidden_tr_input").removeClass('hidden_tr_input');
            $("input[name='order_item_location_value']").focus();
            $("input[name='order_item_location_value']").prop('required',true);

        }else{
            $("input[name='order_item_location_value']").prop('required',false);
            $("#hidden_tr_input").addClass('hidden_tr_input');

             // $(".hidden_tr_input").hide();
         }
     });

    $('#ns_coupon_netsuite_sync').click(function(e){
        if($('#ns_coupon_netsuite_sync:checked').length > 0){
            // $('#promo_required_fields').css('display','');
            $("select[name='ns_promo_discount_id']").prop('required',true);
            $("select[name='ns_promo_custform_id']").prop('required',true);
            // $('ns_promo_custform_id').removeAttr('required');​​​​​
            // $('ns_promo_discount_id').removeAttr('required');​​​​​

            $( "#promo_required_fields" ).removeClass( "promo_required_fields" );
            

        }else{            
            $( "#promo_required_fields").addClass( "promo_required_fields" );
            $("select[name='ns_promo_discount_id']").prop('required',false);
            $("select[name='ns_promo_custform_id']").prop('required',false);


        }
    });

    $('#netsuite_countries').select2();    
    $('#netstuite_locations').select2(); 

    $('.inventoryDefaultLocation').on('change',function(){
        if(3 == $(this).val()){
            $('#netsuite_countries').parents('tr').removeClass('hidden');
            $('#load-ns-locations').parents('tr').removeClass('hidden');
            $('#netstuite_locations').parents('tr').removeClass('hidden');
        }else{
            $('#netsuite_countries').parents('tr').addClass('hidden');
            $('#load-ns-locations').parents('tr').addClass('hidden');
            $('#netstuite_locations').parents('tr').addClass('hidden');
        }
    });  

    $('#sku_mapping_field').on('change',function(){
        console.log($(this).val());
        if ('customFieldList' == $(this).val()) {
            $('#sku_mapping_custom_field').parents('tr').removeClass('hidden');
        } else {
            $('#sku_mapping_custom_field').parents('tr').addClass('hidden');
        }
    });   

});


jQuery(function ($) {
    $("#test_api_creds").on('click', function(){
        $(this).attr('disabled', true);
        if(tm_ns_validateForm()) {
            var data = {'action':'tm_validate_ns_credentials'};
            $.ajax({
                type: "post",
                dataType: "json",
                url: tmwni_admin_settings_js.ajax_url,
                data: {'action':'tm_validate_ns_credentials',nonce : tmwni_admin_settings_js.nonce,},
                success: function (response) {
                   $("#test_api_creds").attr('disabled', false);
                   alert(response.message);
               },
               complete: function(x) {
                   $("#test_api_creds").attr('disabled', false);
               }
           });
        } else {
            alert("Please 'enter & save' API credentials first");
        }
    });
    
    $(document).on('submit', '.tm_netsuite_ajax_form_save', function (e) {
        e.preventDefault();
        $('#loader-wrapper').show();
        var data = $(this).serialize();
        $.ajax({
            type: "post",
            dataType: "json",
            url: ajaxurl,
            data: data,
            success: function (response) {
                $("head").append('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">');
                $('#loader-wrapper').hide();
                if (response.type == "success"){
                    $.notify(" Settings have been successfully saved", {type: "success", icon:"check",align:"right"});
                    $('.tm_netsuite_ajax_form_save').find('input,select').each(function () {
                        $(this).css('border','');
                    });
                }else if(response.type == "blankfield"){
                    $.notify(' '+response.msg, {type: "danger", icon:"exclamation", align:"right"});
                    $('.tm_netsuite_ajax_form_save').find('input,select').each(function () {
                        $(this).css('border','');
                        $(this).next('.select2-container').find(".select2-selection").css('border','');
                        if ($.trim($(this).val()) == '' || $.trim($(this).val()) == 0 ) {
                            if($.trim($(this).attr('name')).indexOf('wc_field_value_prefix') == -1){
                                isValid = false;
                                $(this).css('border','1px solid red');
                            }
                            if($(this).hasClass("select2-hidden-accessible")){
                                $(this).next('.select2-container').find(".select2-selection").css('border','1px solid red');
                            }
                        }
                    });
                }else if(response.type == "Error"){
                    $.notify(' '+response.msg, {type: "danger", icon:"close", align:"right",color: "#fff", background: "#D44950"});
                }else{
                    $.notify(' '+response.msg, {type: "danger", icon:"close", align:"right",color: "#fff", background: "#D44950"});
                }
            }
        });

        return false;
    });




    jQuery(document).on('click', '#import_settings',function(e){
        e.preventDefault();


        var file = jQuery('#importfile')[0].files[0];
        if(file){
            var fd = new FormData();
            fd.append('importfile', file);
            fd.append( "action", 'import_netsuite_settings'); 
            fd.append( "nonce", tmwni_admin_settings_js.nonce);      
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                async: false,
                url: tmwni_admin_settings_js.ajax_url,
                data: fd,
        //processData: false,        
        success: function(response){
            if(response.status == 'false'){
                $.notify(' '+response.msg, {type: "danger", icon:"exclamation", align:"right"});
            }else{
             $.notify(' '+response.msg, {type: "success", icon:"check", align:"right"});

         }

         jQuery('input[name=importfile').val('');

     }

 });

        }else{
            $.notify(' '+'Please Choose a file', {type: "danger", icon:"exclamation", align:"right"});
        }
        return false;


    });










});


(function ($) {
    $(document).on('change', ".cm_operator", function () {
        var cm_operator = $(this).val();
        if (cm_operator != 0) {
            var this_table = $(this).closest('table');
            var cm_box_index = this_table.parent().data('index');
            if (cm_operator == 2) {
                this_table.find('tbody tr').eq(0).find('td:gt(0)').remove();
                processCM(1, 2, this_table);
            } else if (cm_operator == 1 || cm_operator == 3) {
                this_table.find('tbody tr:gt(0)').remove();

                getCMTypeDropdown(this_table, cm_box_index);
            }
        }
        makeSelectfieldsSelect2($);
    });

    $(document).on('change', ".cm_type", function () {
        var cm_type = $(this).val();
        if (cm_type != 0) {
            var cm_operator = $(this).closest('td').prev('td').find('.cm_operator').val();
            if (cm_operator != 0) {
                var this_table = $(this).closest('table');
                processCM(cm_type, cm_operator, this_table);
            }
        }
        makeSelectfieldsSelect2($);
    });

    $(document).on('change', ".attr_type", function () {
        var attr_type = $(this).val();
        
        if (attr_type != 0) {
            var cm_operator = $(this).closest('.netsuite_conditional_mapping').find('.cm_operator').val();
            var cm_type = $(this).closest('.netsuite_conditional_mapping').find('.cm_type').val();

            var cm_condition = cm_type != null ? getConditionVal($(this),cm_type) : [];

            if (cm_operator != 0) {
                var this_table = $(this).closest('table');
                processCM(cm_type, cm_operator, this_table, attr_type, cm_condition);
            }
        }
        makeSelectfieldsSelect2($);
    });

    $(document).on('click', ".removeCMRow", function () {
        if (confirm("This action can't be undone")) {
            //truncating first row instead of removing
            if ($('.netsuite_conditional_mapping').length == 1) {

                //reset input and select
                $('.netsuite_conditional_mapping').find('select.cm_type').remove();

                $('.netsuite_conditional_mapping tbody tr:gt(0)').remove();

                $('.netsuite_conditional_mapping tbody tr td').eq(1).empty();

                $('.netsuite_conditional_mapping').find('select.cm_operator').each(function () {
                    $(this).val(0);
                });
            } else {
                $(this).parent().remove();
            }
        }
    });

    $(document).on('click', "#addMoreConditionalMappingRows", function () {

        var clone_this = $(this).prev('div'); //get prev table to clone

        var current_index = clone_this[0].dataset.index; //get current index
        var next = parseInt(current_index) + 1; //increment table index   

        clone_this[0].dataset.index = next; //increment table index
        clone_this.find('tbody .cm_operator').attr('name', 'cm[' + next + '][operator]');
        $(this).before(clone_this.clone()); // add new mapping row by cloing prev table

        clone_this[0].dataset.index = current_index; //fix for prev table
        clone_this.find('tbody .cm_operator').attr('name', 'cm[' + current_index + '][operator]');

        //reset input and select
        $('.netsuite_conditional_mapping:last tbody tr:gt(0)').remove();

        $('.netsuite_conditional_mapping:last tbody tr').eq(0).find('td').eq(1).empty();
        
        if ($('.netsuite_conditional_mapping:last').prev('.requiredCM').length == 1) {
            $('.netsuite_conditional_mapping:last').prev('.requiredCM').replaceWith("<span style='float:right;' class='btn btn-danger removeCMRow'>X</span>");
        }
        
        $('.netsuite_conditional_mapping:last').parent().find('.update_checkbox').attr('checked', false);

        $('.netsuite_conditional_mapping:last').parent().find('.update_checkbox').attr('name', 'cm['+next+'][exlcude_in_update]');
        
        $('.netsuite_conditional_mapping:last').find('select').each(function () {
            $(this).val(0);
        });
    });

    $(document).on('change','.ns-field-key',function(){
        var $this = $(this);
        $this.parents('tr').find('input.ns-field-value').attr('placeholder','');
        $this.parents('tr').find('input.ns-field-type').val($('option:selected', $this).attr('data-type'));
        if($('option:selected', $this).attr('data-type') == 'dateTime'){
            $this.parents('tr').find('input.ns-field-value').attr('type','datetime-local');
        }else{
            $this.parents('tr').find('input.ns-field-value').attr('type','text');
        }

        if( $('option:selected', $this).attr('data-type') == "boolean" ){
            $this.parents('tr').find('input.ns-field-value').attr('placeholder','True or False only');
            $this.parents('tr').find('input.ns-field-value').attr('value', "");
        }

    });

    $(document).on('change','.ns-field-type',function(){
        var $this = $(this);
        $this.parents('tr').find('input.ns-field-value').attr('placeholder','');
        if($this.val() == 'dateTime'){
            $this.parents('tr').find('input.ns-field-value').attr('type','datetime-local');
        }else if($this.val() == 'customboolean'){
            $this.parents('tr').find('input.ns-field-value').attr('placeholder','True or False only');
            $this.parents('tr').find('input.ns-field-value').attr('value','');
        }else{
            $this.parents('tr').find('input.ns-field-value').attr('type','text');
        }

    });

    $(document).on('change','.wc_fieldkey',function(){
        var $this = $(this);
        $this.closest('.netsuite_conditional_mapping').find('[name$="[wc_field_value]"]').attr('placeholder','');
        
        if($this.val() == "country" || $this.val() == "state" || $this.val() == "order_currency" || $this.val() == "billing_country" || $this.val() == "billing_state" || $this.val() == "shipping_state" || $this.val() == "shipping_country"){
            $this.closest('.netsuite_conditional_mapping').find('[name$="[wc_field_value]"]').attr('placeholder','ISO alpha-2 code only.');
            $this.closest('.netsuite_conditional_mapping').find('[name$="[wc_field_value]"]').attr('value','');
        }

    });

    //Ajax for get custom form and Discount Id
    $("#Promofields").on('click', function(e){
        e.preventDefault();
        var current = $(this);
        $.ajax({
            type: "post",
            dataType: "json",
            url: tmwni_admin_settings_js.ajax_url,
            data: {'action':'tm_load_ns_promo_feilds_value',nonce : tmwni_admin_settings_js.nonce,},
            beforeSend: function() {
                current.find('.glyphicon-refresh').addClass("glyphicon-spin");
            },
            complete: function (response) {
             current.find('.glyphicon-refresh').removeClass("glyphicon-spin");
             location.reload(true);                 
         },
     });
    });


    //Ajax for get locations
    $("#locationRefresh").on('click', function(e){
        e.preventDefault();
        var current = $(this);
        $.ajax({
            type: "post",
            dataType: "json",
            url: tmwni_admin_settings_js.ajax_url,
            data: {'action':'tm_load_ns_locations',nonce : tmwni_admin_settings_js.nonce,},
            beforeSend: function() {
                current.find('.glyphicon-refresh').addClass("glyphicon-spin");
            },
            complete: function (response) {
             current.find('.glyphicon-refresh').removeClass("glyphicon-spin");
             location.reload(true);                 
         },
     });
    });



    //Ajax for get priceLists
    $("#priceLevelRefresh").on('click', function(e){
        e.preventDefault();
        var current = $(this);
        $.ajax({
            type: "post",
            dataType: "json",
            url: tmwni_admin_settings_js.ajax_url,
            data: {'action':'tm_load_ns_price_levels',nonce : tmwni_admin_settings_js.nonce,},
            beforeSend: function() {
                current.find('.glyphicon-refresh').addClass("glyphicon-spin");
            },
            complete: function (response) {
             current.find('.glyphicon-refresh').removeClass("glyphicon-spin");
             location.reload(true);                 
         },
     });
    });


    
})(jQuery);

function processCM(cm_type, cm_operator, this_table, attr_type="" , cm_condition = []) {
    var index = this_table.parent('div').data('index');
    // if (this_table.find("tbody tr").length > 2 && !confirm("This action can't be undone")) {
    //     return false;
    // }
    this_table.find("tr:gt(0)").remove();
    var wcfieldkey ="";
    var template = getCMTemplate(cm_type, cm_operator, index,wcfieldkey, attr_type, cm_condition );
    if (template !== false) {
        this_table.find("tbody").append(template);
    }
}

//get conditional mapping template based on type and operator
function getCMTemplate(type=0, operator, index, wcfieldkey="",attr_type="" , cm_condition=[]) {
    // $conditional_mapping_nonce = wp_create_nonce('conditional-mapping-nonce');
    var html_template = '';
    jQuery.ajax({
        url: ajaxurl,
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            'action': 'get_conditional_mapping_template',
            'type': type,
            'operator': operator,
            'index': index,
            'attr_type': attr_type,
            'cm_wc_field_key': cm_condition['wc_field_key'] != null ? cm_condition['wc_field_key'] : "",
            'cm_wc_field_value': cm_condition['wc_field_value'] != null ? cm_condition['wc_field_value'] : "",
            'cm_wc_where_op': cm_condition['wc_where_op'] != null ? cm_condition['wc_where_op'] : "",
            'tab' : getUrlParameter('tab'),
            'nonce': tmwni_admin_settings_js.nonce,

        },
        success: function (data) {
            if (data.status == 1) {
                html_template = data.template;
            }
        }
    });

    return html_template;
}

function getCMTypeDropdown(this_table, cm_box_index) {
    var template = '<td><span class="h5">WC Field Source</span><br/><select class="cm_type input-sm" name="cm[' + cm_box_index + '][type]"><option value="0" selected>-- select field type --</option><option value="1">Customer Field</option><option value="2">Customer Meta Field</option><option value="3">Order Field</option><option value="4">Order Meta Field</option></select></td>';
    this_table.find('tbody tr').eq(0).find('td:gt(0)').remove();
    this_table.find('tbody tr').eq(0).append(template);
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


function getConditionVal($this,cm_type){
    var conditions = [];
    conditions['wc_field_key'] = $this.closest('.netsuite_conditional_mapping').find('[name$="[wc_field_key]"]').val();
    conditions['wc_field_value'] = $this.closest('.netsuite_conditional_mapping').find('[name$="[wc_field_value]"]').val();
    conditions['wc_where_op'] = $this.closest('.netsuite_conditional_mapping').find('[name$="[wc_where_op]"]').val();
    return conditions;
}


function makeSelectfieldsSelect2($){
    $('select.ns-field-key').each(function (i, obj) {
        if (!$(obj).data('select2'))
        {
            $(obj).select2();
        }
    }); 

    $('select[name*="wc_field_key"]').each(function (i, obj) {
        if (!$(obj).data('select2'))
        {
            $(obj).select2();
        }
    }); 
}
var timeOutId = 0;

function fetchWooInventoryStatus(total_count){

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: tmwni_admin_settings_js.ajax_url,
        data: {action: "fetch_inventory_progress",nonce:tmwni_admin_settings_js.nonce},
        // async: false,
        success: function(response){
            if(response.success){


                var percent = response.processed_count / total_count * 100;
                var html="<div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow="+Math.ceil(percent)+" aria-valuemin='0' aria-valuemax='100' style='width:"+Math.ceil(percent)+"%'>"+Math.ceil(percent)+"%</div>";
                jQuery(".progress").html(html);
                jQuery('.inventory-loader').hide();
                jQuery('.progress_processed').show();
                jQuery('.processed_count').html(response.processed_count);
                jQuery('#of').html(total_count);
                jQuery('.progress_details').show();
                jQuery('.updated_records_count').html(response.updated_count);
                jQuery('.skipped_records_count').html(response.skus.length + response.empty_skus.length);
                jQuery('.inventory-logs').show();
                
                jQuery('.log-list').html(response.logs);
                jQuery('html, body').animate({
                    scrollTop: jQuery(".inventory-logs").offset().top
                }, 2000);
                var $t = jQuery('.inventory-logs');
                $t.animate({"scrollTop": jQuery('.inventory-logs')[0].scrollHeight}, "slow");


            }
        },
        complete:function(response){
            if(total_count === response.responseJSON.processed_count){
             clearTimeout(timeOutId);
             jQuery('.manual-update-inventory').attr("disabled", false);
             jQuery('.progress').remove();

         } else {
            timeOutId = setTimeout(fetchWooInventoryStatus, 2000, total_count);
        }
    }

});
}












