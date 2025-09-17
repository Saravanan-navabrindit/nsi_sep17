var globnextcount=0;

var ajaxurl = ewcpm_php_vars.admin_url;

jQuery(document).ready(function(){
  // var fme_allcookies = document.cookie;

  // fme_cookiearray = fme_allcookies.split(';');

  // function getCookie(fme_name) {
  //   var fme_value = "; " + document.cookie;
  //   var fme_parts = fme_value.split("; " + fme_name + "=");
  //   if (fme_parts.length == 2) return fme_parts.pop().split(";").shift();
  // }
  // var fme_mode = getCookie('display');
  // // alert(fme_mode)

  // if(fme_mode == 'fme_switchcustomerbtn') {
  //   jQuery('#fme_switchcustomerbtn').click();
  // } else if ( fme_mode == 'fme_customerlogsbtn') {
  //   jQuery('#fme_customerlogsbtn').click();
  // } else if ( fme_mode == 'fme_settingsbtn') {
  //   // alert()
  //   jQuery('#fme_settingsbtn').click();
  // } 




  jQuery('.saveroles').click(function(){

    var allroless=jQuery('#select_roles').val();
    var defselectedp=jQuery('#selectdefpm').val();
    var fme_tabselect=jQuery('#fme_tabselect').val();
    console.log(fme_tabselect)
    jQuery.ajax({
      url : ajaxurl,
      type : 'post',
      data : {
        action : 'saveallroles', 
        allroless:allroless,
        fme_tabselect:fme_tabselect,
        defselectedp:defselectedp,
        notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',
      },
      success : function( response ) {
       
       
        jQuery('#savediv').show();
        setTimeout(function() {
          jQuery('#savediv').fadeOut(1000);
        }, 1700);


      }

    });
  });
  jQuery('#fme_switchcustomerbtn').click(function(){
    // document.cookie = "display=fme_switchcustomerbtn";
    
    jQuery(this).addClass('current');
    jQuery('#fme_taboflogs').show();
    
    jQuery('#fme_tableofswitch').hide();
    jQuery('#fme_tabofsettings').hide();
    
    jQuery('#fme_customerlogsbtn').removeClass('current');
    jQuery('#fme_settingsbtn').removeClass('current');
    
  });
  jQuery('#fme_customerlogsbtn').click(function(){
    // document.cookie = "display=fme_customerlogsbtn";
    jQuery(this).addClass('current');
    jQuery('#fme_tableofswitch').show();

    jQuery('#fme_taboflogs').hide();
    jQuery('#fme_tabofsettings').hide();

    jQuery('#fme_switchcustomerbtn').removeClass('current');
    jQuery('#fme_settingsbtn').removeClass('current');

    
  }); 
  jQuery('#fme_settingsbtn').click(function(){
    // document.cookie = "display=fme_settingsbtn";
    jQuery(this).addClass('current');
    jQuery('#fme_tabofsettings').show();

    jQuery('#fme_taboflogs').hide();
    jQuery('#fme_tableofswitch').hide();
    
    jQuery('#fme_switchcustomerbtn').removeClass('current');
    jQuery('#fme_customerlogsbtn').removeClass('current');
    
  });

  jQuery('#nextfind').click(function(){
    globnextcount=globnextcount+10;
    var nextvalue=jQuery('#cusname').val();
    jQuery.ajax({
      url : ajaxurl,
      
      type : 'post',
      data : {
        action : 'nextdatafind', 
        nextvalue:nextvalue,     
        globnextcount:globnextcount,
        notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',       
        
        

        
        
      },
      success : function( response ) {
        jQuery('.myownulbabes').remove();
        
        var data=JSON.parse(response);
        
        if (data.length==0) {
         jQuery('#nextfind').hide();
         jQuery('#fmse_nrf').show();
       }else{
         jQuery('#fmse_nrf').hide();
         if(data.length>=50){
          jQuery('#nextfind').show();
        }
        
        var app='<ul class="myownulbabes" style="margin: unset;"> ';
        for (var i = data.length - 1; i >= 0; i--) {
         
          app= jQuery(app).append('<li style="margin-bottom: 4%;margin-top: 4%;" value="'+data[i]['ID']+'">'+'User: '+data[i]['display_name']+'</li>');
        }
        app=jQuery(app).append('</ul>');
        jQuery('#cusname').after(app);
      }
      


    }
    
  });

  });

  
  jQuery('#cusname').keyup(function(){
   jQuery('#nextfind').hide();
   jQuery('#fmse_nrf').hide();
   var value=jQuery('#cusname').val();
   var countkk=value.length;
   globnextcount = 0;

   if(countkk<3){
    jQuery('.myownulbabes').remove();
  }
  if (countkk>=3){
    jQuery.ajax({
      url : ajaxurl,
      
      type : 'post',
      data : {
        action : 'my_action', 
        value:value,
        notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',            
        
        

        
        
      },
      success : function( response ) {

        jQuery('.myownulbabes').remove();
        var data='';
        
        try {
          data=JSON.parse(response);
        } catch (e) {
          alert('Something went wrong!')
          return ;
        }
        
        if (data.length==0) {
          jQuery('#nextfind').hide();
          jQuery('#fmse_nrf').show();
        }else{

          if(data.length>=10){
            jQuery('#nextfind').show();
          }
          jQuery('#fmse_nrf').hide();
          var app='<ul class="myownulbabes" style="margin: unset;"> ';
          for (var i = data.length - 1; i >= 0; i--) {
            
            app= jQuery(app).append('<li style="margin-bottom: 4%;margin-top: 4%;" value="'+data[i]['ID']+'">'+'User: '+data[i]['display_name']+'</li>');
          }
          app=jQuery(app).append('</ul>');
          jQuery('#cusname').after(app);
        }
        


      }
      
    });
  }

});

  jQuery(document).ready(function(){
   var pluginUrl = jQuery('#icon_image').val();
   jQuery('.buttonn').prepend('<img src="'+pluginUrl+'" id="setimage" alt="" />'); 

   
 });
  


  jQuery('#righticon').click(function(e){
    jQuery('#divtohide').show();
    
    jQuery('#righticon').hide();

  });
  jQuery('#lefticon').click(function(e){
    jQuery('#divtohide').show();
    
    jQuery('#lefticon').hide();

  });

  jQuery('#compresstoleft').click(function(e){
    jQuery('#divtohide').hide();
    
    jQuery('#lefticon').show();

  });
  jQuery('#compresstoright').click(function(e){
    jQuery('#divtohide').hide();
    
    jQuery('#righticon').show();

  });
  jQuery('.switchbtn').click(function(e){

    var id ='';
    if(jQuery(this).hasClass('frompage')){
      id=jQuery(this).val();
    } else{
      id=jQuery('#cusname1').val()
    }
    if(id==''){
      var x=1;
      alert('Please select any customer');
      return false;
    }
    e.preventDefault();
    
    
    
    jQuery.ajax({
      url : ajaxurl,
      type : 'post',
      data : {
        action : 'ajaxxx', 
        id: id, 
        x:x,
        notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',
        
        

        
        
      },
      success : function( response ) {
        if (response=='usernotmatched'){
          alert('You are not allowed to Switch!');
        } else {
          var tab = jQuery('#fme_tabselect').val()
          if( 'new' == tab ) {
            window.open(response,"_blank");
          } else {
            window.open(response,"_self");
          }
       }
       
       
       
     }
   });
  });


  jQuery('.sbavs').click(function(e){
   
    e.preventDefault();
    
    
    
    jQuery.ajax({
      url : ajaxurl,
      type : 'post',
      data : {
        action : 'sbavs', 
        notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',
        
        

        
        
      },
      success : function( response ) {
        window.location.assign(response);
        
        
      }
    });
  });
  jQuery('.vieworder').click(function(e){
    var id ='';
    if(jQuery(this).hasClass('frompage')){
      id=jQuery(this).val();
    } else{
      id=jQuery('#cusname1').val()
    }
    
    if(id==''){
      var x=1;
      alert('Please select any customer');
      return false;
    }
    e.preventDefault();
    
    
    
    jQuery.ajax({
      url : ajaxurl,
      type : 'post',
      data : {
        action : 'vieworder', 
        id:id,
        notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',
      },
      success : function( response ) {
        
       if (response=='usernotmatched'){
        alert('You are not allowed to View Orders!');
      } else {
       window.location.assign(response);
     }
     
     
     
   }
 });
  });
  jQuery('.editprofile').click(function(e){
   var id ='';
   if(jQuery(this).hasClass('frompage')){
    id=jQuery(this).val();
  } else{
    id=jQuery('#cusname1').val()
  }
  if(id==''){
    var x=1;
    alert('Please select any customer');
    return false;
  }
  e.preventDefault();
  
  
  jQuery.ajax({
    url : ajaxurl,
    type : 'post',
    data : {
      action : 'editprofile', 
      id:id,
      notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',
      

      
      
    },
    success : function( response ) {
      window.location.assign(response);
      
      
    }
  });
});


  jQuery('.btn1').click(function(e){
    
   jQuery('#loader_fme').show();
   e.preventDefault();
   
   jQuery.ajax({
    url : ajaxurl,
    type : 'post',
    data : {
      action : 'ajax', 
      notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e', 
      
      

      
      
    },
    success : function( response ) {
     let mainLocation =jQuery('#mainUrl').val();

     window.location.href = mainLocation + '/wp-admin/edit.php?post_type=shop_order';
       
   }
 });
 });



  jQuery(document).ready(function(){
    jQuery('center .disabled').click(function(e){
      e.preventDefault()
      alert('This user doesnt have Phone number')
      return
    })
    var found=jQuery('#pageefound').val();
    if (found=='found'){
      jQuery("#select_roles").select2();
      jQuery('#allcustomers').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      } );
      jQuery('#customers').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      } );

      
    }
    

    jQuery('.fade').css('opacity', 'unset');
    jQuery(".buttonn").click(function(){
      jQuery("#myModal").modal();
      jQuery('.myownulbabes').remove();
      jQuery('#cusname').val(''); jQuery('#fmse_nrf').hide();
      jQuery('#nextfind').hide();
      
    });

    jQuery(".buttonn1").click(function(e){
      e.preventDefault();
      jQuery.ajax({
        url : ajaxurl,
        
        type : 'post',
        data : {
          action : 'asguest', 
          notallowedpleasegoaway_fme_123e:  'fmessnotallowedpleasegoaway_fme_123#e',
        },
        success : function( response ) {
         
         if (response=='usernotmatched'){
          alert('You are not allowed to Switch!');
        } else {
          var tab = jQuery('#fme_tabselect').val()
          if( 'new' == tab ) {
            window.open(response,"_blank");
          } else {
            window.open(response,"_self");
          }
        }
        
        
        
      }

      
    });
    });




  });
});