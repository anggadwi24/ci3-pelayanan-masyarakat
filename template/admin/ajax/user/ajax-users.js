import baseUrl from "../base.js";
import basePath from "../domain.js";

$(document).ready(function(){
    $(document).on('click','.delete',function(){

        
    swal({
        title: 'Apakah anda yakin?',
        text: 'data akan terhapus permanen',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        buttons: [ 'Batal','Hapus']
      }) .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type:'POST',
                url:baseUrl+'users/delete',
                data:{id:$(this).attr('data-id')},
                dataType:'json',
                beforeSend:function(){
                    loading();
                },success:function(resp){
                   if(resp.status == true){
                        data();
                        success(resp.msg);
                          
                   }else{
                        error(resp.msg);
                   }
                },complete:function(){
                    loadingOut();
                }
        
            })
        } else {
          swal.close();
        }
    });
})
    function data(){
        $.ajax({
            type:'POST',
            url:baseUrl+'users/data',
            dataType:'json',
            beforeSend:function(){
                loading();
            },success:function(resp){
                $('#table').html(resp);
                $('#zero-configuration').DataTable();
            },complete:function(){
                loadingOut();
            }
    
        })
    }
    data();
    $(document).on('click','#refresh',function(){
        data();
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
})
