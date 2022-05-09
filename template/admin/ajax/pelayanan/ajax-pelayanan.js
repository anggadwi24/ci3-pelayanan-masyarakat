import baseUrl from "../base.js";
import basePath from "../domain.js";


$(document).on('click','.delete',function(){
    swal({
        title: 'Apakah anda yakin?',
        text: 'data akan terhapus',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        buttons: [ 'Batal','Hapus']
      }) .then((willDelete) => {
        if (willDelete) {
            window.location = $(this).attr('data-href');
        } else {
          swal.close();
        }
    });
})
$(document).on('click','.edit',function(){
    var id = $(this).data('id');
    $.ajax({
        type:'POST',
        url:baseUrl+'pelayanan/edit',
        data:{id:id},
        dataType:'json',
        beforeSend:function(){
            loading();
        },success:function(resp){
           
            if(resp.status == true){

                $('#pelayanan').val(resp.arr.pelayanan);
                $('#id').val(resp.arr.id);
                $('#modalEdit').modal('show');
            }else{
                error(resp.msg);
            
            }
        },complete:function(){
            loadingOut();
        }
            
    });
})
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
      swal.close();
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