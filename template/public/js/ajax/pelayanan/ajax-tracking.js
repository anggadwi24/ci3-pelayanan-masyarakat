import baseUrl from "../base.js";
import basePath from "../domain.js";
import loading from "../loadIn.js";
import loadingOut from "../loadOut.js";
import success from "../success.js";
import successRedirect from "../success-redirect.js";
import error from "../error.js";



var api = $('#apiKey').val();

recaptcha();
function recaptcha(){
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/reCaptcha',
        data:{api:api},
        dataType:'json',
        success:function(resp){
            if(resp.status == true){
                $('#recaptcha').html(resp.data.script);
                $('#recaptcha').append(resp.data.widget);
                
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })
}
$(document).on('submit','#formAct',function(e){
    e.preventDefault();
   
    var formData = new FormData(this);
        formData.append('api',api);
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'site/pelayanan/doTrack',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        dataType :'json',
        beforeSend:function(){
            loading();
            $('input').attr('disabled',true);
          
            $('button').attr('disabled',true);
           



        },success:function(resp){
            
            if(resp.status == true){
               

                
                $('#content').html(resp.output);

            }else{
                $('#content').html('');

                error('Oooppss..',resp.msg);
                recaptcha();
            }
        },complete:function(){
            $('input').attr('disabled',false);
        
            $('button').attr('disabled',false);
          




            loadingOut();
        }
    })
            
   
})