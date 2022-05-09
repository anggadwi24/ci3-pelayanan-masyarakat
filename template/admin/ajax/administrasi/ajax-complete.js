import baseUrl from "../base.js";
import basePath from "../domain.js";


content();
function content(){
    var id = basePath('id');
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/contentPelayanan',
        data:{id:id},
        dataType:'json',
        beforeSend:function(){
            loadContent('#content');

        },success:function(resp){
            if(resp.status == true){
                $('#content').html(resp.content);
            }else{
                error(resp.msg);
            }
        }
    })
}
$(document).on('submit','#formAdd',function(e){
    e.preventDefault();
   
    var formData = new FormData(this);
        formData.append('id',basePath('id'));
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/storeComplete',
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

                
                success_redirect(resp.msg,resp.redirect);
            }else{
                error(resp.msg);
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
function error(msg){

    swal({
        title: 'Ooopss!',
       
        text:msg,
        
          
        customClass: 'swal-wide',
         icon:'error',
        
        })

}

function loadContent(elem){
    var html ='<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
    $(elem).html(html);
}
function loading(){
    $('.loading').css('display','');

}
function loadingOut(){
    setTimeout(function() {
        $('.loading').fadeOut('slow', function() {
            $(this).css('display','none');
        });
    },400);

}
function success(msg){
swal({
    title: 'Successfully!',
   
    text:msg,
    
      
    customClass: 'swal-wide',
    icon:'success',
    
    })  
}
function success_redirect(msg,redirect){

    swal({
        title: 'Successfully',
        text: msg,
        icon: 'success',
        allowOutsideClick: false,
        
        
      }) .then((willDelete) => {
        if (willDelete) {
            window.location = redirect;
        } 
    });
}