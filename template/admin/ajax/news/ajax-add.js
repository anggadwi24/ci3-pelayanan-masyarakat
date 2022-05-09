import baseUrl from "../base.js";
import basePath from "../domain.js";
$(document).on('submit','#formAct',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'berita/store',
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

                
                success_redirect(resp.msg,baseUrl+'berita');
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