import baseUrl from "../base.js";
import basePath from "../domain.js";

$(document).on('submit','#formEdit',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    
  
  
        $.ajax({
            type:'POST',
            url:baseUrl+'profile/update',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType :'json',
            beforeSend:function(){
                loading();
                $('#formEdit input').attr('disabled',true);
                $('#formEdit select').attr('disabled',true);
                $('#formEdit button').attr('disabled',true);


            },success:function(resp){
                
                if(resp.status == true){
                    $('#displayName').html($('#name').val());
                   success(resp.msg);
                }else{
                    error(resp.msg);
                }
            },complete:function(){
                $('#formEdit input').attr('disabled',false);
                $('#formEdit select').attr('disabled',false);
                $('#formEdit button').attr('disabled',false);



                loadingOut();
            }
       })
    
    
})
$(document).on('submit','#formPass',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    
  
  
        $.ajax({
            type:'POST',
            url:baseUrl+'profile/updatePassword',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType :'json',
            beforeSend:function(){
                loading();
                $('#formPass input').attr('disabled',true);
                $('#formPass button').attr('disabled',true);

            },success:function(resp){
                
                if(resp.status == true){
                    success(resp.msg);
                    $('#modalChange').modal('hide');
                }else{
                    error(resp.msg);
                }
            },complete:function(){
                $('#formPass input').attr('disabled',false);
                $('#formPass button').attr('disabled',false);


                loadingOut();
            }
       })
    
    
})
$(document).on('click','#btnFile',function(){
    $('#fileUp').click();
})
$(document).on('change', '#fileUp', function(e) {

    e.preventDefault();
    var file_data = $('#fileUp').prop('files')[0];
    var form_data = new FormData();
    
 
    form_data.append('file', file_data);
    form_data.append('id', basePath('id'));

 
             $.ajax({
                 url: baseUrl+'profile/updateImage', // point to server-side PHP script
                 dataType: 'json',  // what to expect back from the PHP script, if anything
                 cache: false,
                 contentType: false,
                 processData: false,
                 data: form_data,
                 type: 'post',
                 success: function(resp){
                     //alert(php_script_response); // display response from the PHP script, if any
                     if (resp.status == true) {
                         $('#fileUp').val('');
                         $('#profilePhoto').attr('src',resp.url);
                         $('#displayImg').attr('src',resp.url);
                       
                         
                     }else{
                        error(resp.msg);
                         
 
                     }
                 }
             });
 });
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
function success_redirect(msg,redirect){

swal({
    title: 'Successfully',
    text: msg,
    icon: 'success',
    buttons: true,
    dangerMode: true,
    buttons: [ 'Tetap Dihalaman','Kembali']
  }) .then((willDelete) => {
    if (willDelete) {
        window.location = redirect;
    } else {
      location.reload();
    }
});
}
function success_redirect1(msg,redirect){

swal({
    title: 'Successfully',
    text: msg,
    icon: 'success',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Lanjut',
    cancelButtonText: 'Stay'
  }).then(result => {
   
      // handle confirm
      window.location =redirect;
    
  });
}
