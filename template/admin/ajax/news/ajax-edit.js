import baseUrl from "../base.js";
import basePath from "../domain.js";
$(document).on('submit','#formMain',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('id',basePath('id'));
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'berita/updateMain',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        dataType :'json',
        beforeSend:function(){
            loading();
            $('#formMain input').attr('disabled',true);
            $('#formMain select').attr('disabled',true);
            $('#formMain button').attr('disabled',true);
            $('#formMain textarea').attr('disabled',true);



        },success:function(resp){
            
            if(resp.status == true){
                $('#formMain input').val('');
                $('#formMain select').val('');
                $('#formMain textarea').val('');

                
                success(resp.msg);
            }else{
                error(resp.msg);
            }
        },complete:function(){
            $('#formMain input').attr('disabled',false);
            $('#formMain select').attr('disabled',false);
            $('#formMain button').attr('disabled',false);
            $('#formMain textarea').attr('disabled',false);




            loadingOut();
        }
   })
});
$(document).on('submit','#formImg',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('id',basePath('id'));
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'berita/storeDetail',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        dataType :'json',
        beforeSend:function(){
            loading();
            $('#formImg input').attr('disabled',true);
            $('#formImg select').attr('disabled',true);
            $('#formImg button').attr('disabled',true);
            $('#formImg textarea').attr('disabled',true);



        },success:function(resp){
            
            if(resp.status == true){
                detail();
                $('#formImg input').val('');
                $('#formImg select').val('');
                $('#formImg textarea').val('');

                
                success(resp.msg);
            }else{
                error(resp.msg);
            }
        },complete:function(){
            $('#files').val('');
            $('#fileBase').html('');
            $('#formImg input').attr('disabled',false);
            $('#formImg select').attr('disabled',false);
            $('#formImg button').attr('disabled',false);
            $('#formImg textarea').attr('disabled',false);




            loadingOut();
        }
   })
});
$(document).on('submit','#formAct',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('id',basePath('id'));
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'berita/update',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        dataType :'json',
        beforeSend:function(){
            loading();
            $('#formAct input').attr('disabled',true);
            $('#formAct select').attr('disabled',true);
            $('#formAct button').attr('disabled',true);
            $('#formAct textarea').attr('disabled',true);



        },success:function(resp){
            
            if(resp.status == true){
               
                
                success(resp.msg);
            }else{
                error(resp.msg);
            }
        },complete:function(){
            $('#formAct input').attr('disabled',false);
            $('#formAct select').attr('disabled',false);
            $('#formAct button').attr('disabled',false);
            $('#formAct textarea').attr('disabled',false);




            loadingOut();
        }
   })
});
$(document).on('click','.delete',function(){

    
swal({
    title: 'Apakah anda yakin?',
    text: 'gambar akan terhapus permanen',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
    buttons: [ 'Batal','Hapus']
  }) .then((willDelete) => {
    if (willDelete) {
        $.ajax({
            type:'POST',
            url:baseUrl+'berita/deleteDetail',
            data:{id:$(this).attr('data-id')},
            dataType:'json',
            beforeSend:function(){
                loading();
            },success:function(resp){
               if(resp.status == true){
                    detail();
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
detail();
function detail(){
    $.ajax({
        type:'POST',
        url:baseUrl+'berita/detailImage',
        data:{id:basePath('id')},
        dataType :'json',
        success:function(resp){
            if(resp.status == true){
                $('#detailimg').html(resp.output);
            }
        }

    })
}
$('#switch-1').change(function() {
    // this will contain a reference to the checkbox   
   
    if (this.checked) {
        $('#formPublish').show();
        $('#date-format').prop('required',true);
    } else {
        $('#formPublish').hide();
        $('#date-format').prop('required',false);

        // the checkbox is now no longer checked
    }
});
$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
      
    $("#files").on("change", function(e) {
        $('#fileBase').html('');
        
        var files = e.target.files,
        filesLength = files.length;
        
      for (var i = 0; i < filesLength; i++) {

        var f = files[i]
        
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          
          var html = '<div class="col-md-6"><img src="'+e.target.result+'" class="img-fluid" title="'+f.name+'" alt="'+f.name+'"></img>';
         
        
            
          
          $("#fileBase").append(html);
          
        });
        fileReader.readAsDataURL(f);
       
      }
     
     
      
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
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