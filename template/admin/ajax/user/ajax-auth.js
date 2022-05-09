
import baseUrl from "../base.js";
import basePath from "../domain.js";

$(document).on('submit','#formAct',function(e){
    e.preventDefault();
    var formData = new FormData(this);
  
  
  
        $.ajax({
            type:'POST',
            url:baseUrl+'auth/doLogin',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType :'json',
            beforeSend:function(){
                loading();
                $('#formAct input').attr('disabled',true);
                $('#formAct button').attr('disabled',true);

            },success:function(resp){
                
                if(resp.status == true){
                    window.location = resp.redirect;
                  
                }else{
                    
                    if(resp.conn == 1){
                        $('#password').val('');
                        $('#email').val('');
                    }else if(resp.conn == 0){
                        $('#password').val('');

                    }
                    error(resp.msg);
                }
            },complete:function(){
                $('#formAct input').attr('disabled',false);
                $('#formAct button').attr('disabled',false);


                loadingOut();
            }
       })
    
    
})
function error(msg){
    
    swal({
        title: 'Something Wrong!',
       
        text:msg,
        
          
        customClass: 'swal-wide',
         icon:'error',
        
        })

}
function success(msg){
swal({
    title: 'Successfully!',
   
    text:msg,
    
      
    customClass: 'swal-wide',
    icon:'success',
    
    })  
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