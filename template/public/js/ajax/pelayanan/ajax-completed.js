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
content();
function content(){
    var id = basePath('id');
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/dataCompleted',
        data:{api:api},
        dataType:'json',
        beforeSend:function(){
            loadContent('#content');
            $('#btnDone').prop('disabled',true);

        },success:function(resp){
            if(resp.status == true){
                $('#content').html(resp.content);
                $('#btnDone').prop('disabled',false);

            }else{
                error('Oopps..',resp.msg);
            }
        }
    })
}
$(document).on('submit','#formAdd',function(e){
    e.preventDefault();
   
    var formData = new FormData(this);
        formData.append('api',api);
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'site/pelayanan/update',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        dataType :'json',
        beforeSend:function(){
            loading();
            $('input').attr('disabled',true);
            $('select').attr('disabled',true);
            $('button').attr('disabled',true);
            $('textarea').attr('disabled',true);



        },success:function(resp){
            
            if(resp.status == true){
                $('input').val('');
                $('select').val('');
                $('textarea').val('');

                
                successRedirect('Berhasil',resp.msg,resp.redirect);
            }else{
                error('Oooppss..',resp.msg);
                recaptcha();
            }
        },complete:function(){
            $('input').attr('disabled',false);
            $('select').attr('disabled',false);
            $('button').attr('disabled',false);
            $('textarea').attr('disabled',false);




            loadingOut();
        }
    })
            
   
})
function loadContent(elem){
    var html ='<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
    $(elem).html(html);
}