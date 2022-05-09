import baseUrl from "../base.js";
import basePath from "../domain.js";


$("#tot").bind('change keyup', function () {
                               
    var tot = $('#tot').val();
    var before = $('.formSP').length;
   
    if(tot > before){
        var count = tot - before;
        var html = "";
        console.log(count);
        for(let i = 0; i < count; i++){
            html += '<div class="col-md-12 form-group formSP">';
            html +=     '<div class="row">';
            html +=         '<div class="col-md-6 form-group">'
            html +=             '<label for="">Sub Pelayanan</label>'
            html +=             '<input type="text" name="subpelayanan[]" class="form-control"  placeholder="Nama Sub Pelayanan">'
            html +=          '</div>'
            html +=         '<div class="col-md-6 form-group">'
            html +=             '<label for="">Link Sub Pelayanan</label>'
            html +=             '<input type="text" name="link[]" class="form-control"  placeholder="Link Sub Pelayanan">'
            html +=         '</div>'
            html +=      '</div>'
            html += '</div>';
        }
       
        $('#thisForm').append(html);
    }else{
        $('#thisForm').children().last().remove();
    }  
                        
});

$(document).on('submit','#formAct',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'subpelayanan/store',
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
                $('#formAct input').val('');
                $('#formAct select').val('');
                $('#formAct textarea').val('');
                $('#tot').val(1).change();

                
                success_redirect(resp.msg,baseUrl+'subpelayanan');
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