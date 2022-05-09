import baseUrl from "../base.js";
import basePath from "../domain.js";

$(document).on('submit','#formAdd',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    
  
  
        $.ajax({
            type:'POST',
            url:baseUrl+'website/store',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType :'json',
            beforeSend:function(){
                loading();
                $('#formAdd input').attr('disabled',true);
                $('#formAdd button').attr('disabled',true);

            },success:function(resp){
                
                if(resp.status == true){
                    success(resp.msg);
                    $('input name[menu]').val('');
                    $('input name[link]').val('');

                    $('#addModal').modal('hide');
                    parent();
                    dataMenu();
                    data();
                    
                }else{
                    error(resp.msg);
                }
            },complete:function(){
                $('#formAdd input').attr('disabled',false);
                $('#formAdd button').attr('disabled',false);


                loadingOut();
            }
       })
    
    
})
$(document).on('submit','#formEdit',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    
  
  
        $.ajax({
            type:'POST',
            url:baseUrl+'website/updateMenu',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType :'json',
            beforeSend:function(){
                loading();
                $('#formEdit input').attr('disabled',true);
                $('#formEdit button').attr('disabled',true);

            },success:function(resp){
                
                if(resp.status == true){
                    success(resp.msg);
                    $('input name[menu]').val('');
                    $('input name[link]').val('');

                    $('#editModal').modal('hide');
                    parent();
                    dataMenu();
                    data();
                    
                }else{
                    error(resp.msg);
                }
            },complete:function(){
                $('#formEdit input').attr('disabled',false);
                $('#formEdit button').attr('disabled',false);


                loadingOut();
            }
       })
    
    
})

dataMenu();
function dataMenu(){
    $.ajax({
        type:'POST',
        url:baseUrl+'website/dataMenu',
        dataType:'json',
        beforeSend:function(){
            loading();
        },success:function(resp){
            $('#nestable-menu').html(resp);
            
            $('#nestable-menu').nestable({
                dropCallback: function(details) {
                    console.log(details.sourceId);
                  }
            })
            .on('change', updateOutput);
            updateOutput($('#nestable-menu').data('output', $('#nestable-menu-output')));
        },complete:function(){
            loadingOut();
        }

    })
}
data();
function data(){
    $.ajax({
        type:'POST',
        url:baseUrl+'website/data',
        dataType:'json',
        beforeSend:function(){
            loading();
        },success:function(resp){
            $('#dataMenu').html(resp);
            
            
        },complete:function(){
            loadingOut();
        }

    })
}
parent();
function parent(){
    $.ajax({
        type:'POST',
        url:baseUrl+'website/dataParent',
        dataType:'json',
        beforeSend:function(){
            loading();
        },success:function(resp){
           
           $('.parent').html(resp);
        },complete:function(){
            loadingOut();
        }

    })
}

var updateOutput = function(e) {
  
    var list = e.length ? e : $(e.target),
        output = list.data('output');
    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
    } else {
        output.val('JSON browser support required for this demo.');
    }
    // console.log(list.nestable('serialize'));
    $.ajax({
        type:'POST',
        url:baseUrl+'website/updateOrdering',
        data:{data:list.nestable('serialize')},
        dataType:'json',
        beforeSend:function(){
            loading();
        },success:function(resp){
            
            if(resp.status == false){
                error(resp.msg);
            }
        },complete:function(){
            data();
            loadingOut();
        }
    })
    // console.log(window.JSON.stringify(list.nestable('serialize')));
};

$(document).on('click','.delete',function(){
    var id=  $(this).attr('data-id');
    console.log(id);
    swal({
        title: 'Apakah anda yakin?',
        text: 'menu akan terhapus permanen',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        buttons: [ 'Batal','Hapus']
      }) .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type:'POST',
                url:baseUrl+'website/delete',
                data:{id:id},
                dataType:'json',
                beforeSend:function(){
                    loading();
                },success:function(resp){
                   if(resp.status == true){
                        data();
                        dataMenu();
                        parent();
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
$("body").on('dblclick', '.li-name', function(e) {
    var id=  $(this).attr('data-id');
    $.ajax({
        type:'POST',
        url:baseUrl+'website/menuEdit',
        data:{id:id},
        dataType:'json',
        success:function(resp){
            if(resp.status == true){
                $('#editModal').modal('show');
                $('#menu').val(resp.data.menu);
                $('#link').val(resp.data.link);
                $('#id').val(resp.data.id);
                $("#parents option").each(function (a, b) {
                    if ($(this).html() == resp.data.parent ) $(this).attr("selected", "selected");
                });
            }else{
                error(resp.msg);
            }
        }
    })

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