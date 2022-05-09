import baseUrl from "../base.js";
import basePath from "../domain.js";

function data(start,end,status){
   
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/data',
        data:{start:start,end:end,status:status},
        dataType:'json',
        beforeSend:function(){
            loading();
        },success:function(resp){
           if(resp.status == true){
                $('#table').html(resp.output);
                $('#zero-configuration').DataTable({
                    responsive:false,
                    ordering:false,
                });
           }else{
                 error(resp.msg);
           }
        },complete:function(){
            loadingOut();
        }

    })
}
var start = $('#start').val();
var end = $('#end').val();
var status = $('#status').val();
data(start,end,status);

$(document).on('submit','#formFilter',function(e){
    e.preventDefault();
    var start = $('#start').val();
    var end = $('#end').val();
    var status = $('#status').val();
    data(start,end,status);
})

$(document).on('click','#refresh',function(){
    var start = $('#start').val();
    var end = $('#end').val();
    var status = $('#status').val();
    data(start,end,status);
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
        title: 'Ooppss!',
       
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