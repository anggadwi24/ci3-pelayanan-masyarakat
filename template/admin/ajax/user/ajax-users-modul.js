import baseUrl from "../base.js";
import basePath from "../domain.js";
__modul();
function __modul(){
    $.ajax({
        type:'POST',
        url:baseUrl+'users/dataModul',
        data:{id:basePath('id')},
        dataType:'json',
        beforeSend:function(){
            loading();
        },
        success:function(resp){
            if(resp.status == true){
                $('#__datamodul').html(resp.output);
            }else{
                error(resp.msg);
            }
        },complete:function(){
            loadingOut();
        }
    })
}
__yourmodul();
function __yourmodul(){
    $.ajax({
        type:'POST',
        url:baseUrl+'users/dataModulUsers',
        data:{id:basePath('id')},
        dataType:'json',
        beforeSend:function(){
            loading();
        },
        success:function(resp){
            if(resp.status == true){
                $('#__datamodulmu').html(resp.output);
            }else{
                error(resp.msg);
            }
        },complete:function(){
            loadingOut();
        }
    })
}
$(document).on('click','.__delakses',function(){
    var id = $(this).attr('data-id');
    swal({
        title: 'Apakah anda yakin?',
        text: 'menghapus akses ini',
        icon: 'success',
        buttons: true,
        dangerMode: true,
        buttons: [ 'Cancel','Yakin']
      }) .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type:'POST',
                url:baseUrl+'users/deleteAkses',
                data:{umod:id,id:basePath('id')},
                dataType:'json',
                success:function(resp){
                    if(resp.status == true){
                        success(resp.msg);
                        __modul();
                        __yourmodul();
                    }else{
                        error(resp.msg);
                    }
                }
            })
        } else {
          swal.close();
        }
    });
})
$(document).on('submit','#formMod',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('id', basePath('id'));
    
  
  
        $.ajax({
            type:'POST',
            url:baseUrl+'users/storeModul',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType :'json',
            beforeSend:function(){
                loading();
                $('#formMod input').attr('disabled',true);
                $('#formMod select').attr('disabled',true);
                $('#formMod button').attr('disabled',true);


            },success:function(resp){
                console.log(resp);
                if(resp.status == true){
                   __yourmodul();
                   __modul();
                }else{
                    error(resp.msg);
                }
            },complete:function(){
                $('#formMod input').attr('disabled',false);
                $('#formMod select').attr('disabled',false);
                $('#formMod button').attr('disabled',false);



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

$(document).on('click','.checkboxes',function(){


    var __target = $(this).attr('target');
    var classes = '.'+__target;
  
    $(classes).prop('checked', this.checked);
});
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