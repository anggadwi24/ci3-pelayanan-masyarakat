import baseUrl from "../base.js";
import basePath from "../domain.js";

$("#sub_pelayanan").select2({
    placeholder: 'Pilih sub pelayanan'
});
$("#pelayanan").select2({
    placeholder: 'Pilih pelayanan'
});
$("#banjar").select2({
    placeholder: 'Pilih banjar'
});
$("#job").select2({
    placeholder: 'Pilih pekerjaan'
});

$("#country").select2({
    placeholder: 'Pilih negara'
});



$(document).on('change','#prov',function(){
    var id = $(this).val();
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/kabupaten',
        data:{id:id},
        dataType:'json',
        beforeSend:function(){
            $('#kab').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#kab').html(resp.data);
                
                
            }else{
                error(resp.msg);
            }
            
        }

    })

});
$(document).on('change','#kab',function(){
    var id = $(this).val();
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/kecamatan',
        data:{id:id},
        dataType:'json',
        beforeSend:function(){
            $('#kec').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#kec').html(resp.data);
                
                
            }else{
                error(resp.msg);
            }
            
        }

    })

});
$(document).on('change','#kec',function(){
    var id = $(this).val();
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/kelurahan',
        data:{id:id},
        dataType:'json',
        beforeSend:function(){
            $('#kel').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#kel').html(resp.data);
                
                
            }else{
                error(resp.msg);
            }
            
        }

    })

});
$(document).on('change','#country',function(){
    var val = $(this).val();
    if(val == 'Indonesia'){
        var province = '<label>Provinsi</label><select name="province" class="form-control" id="prov"></select>';
        var kabupaten = '<label>Kabupaten</label><select name="kabupaten" class="form-control" id="kab"></select>';
        var kecamatan = '<label>Kecamatan</label><select name="kecamatan" class="form-control" id="kec"></select>';
        var kelurahan = '<label>Kelurahan</label><select name="kelurahan" class="form-control" id="kel"></select>';

        $('#formProv').html(province);
        $('#formKab').html(kabupaten);
        $('#formKec').html(kecamatan);
        $('#formKel').html(kelurahan);
        $("#prov").select2({
            placeholder: 'Pilih Provinsi'
        });
        $("#kab").select2({
            placeholder: 'Pilih Kabupaten'
        });
        $("#kec").select2({
            placeholder: 'Pilih Kecamatan'
        });
        $("#kel").select2({
            placeholder: 'Pilih Kelurahan'
        });
        $.ajax({
            type:'POST',
            url:baseUrl+'administrasi/province',
            dataType:'json',
            beforeSend:function(){
                $('#prov').html($('<option>', {
                    
                    text: 'Loading...',
                }));
            },success:function(resp){
                if(resp.status == true){
                    $('#prov').html(resp.data);
                    
                    
                }else{
                    error(resp.msg);
                }
                
            }
    
        })
    }else{
        var province = '<label>Provinsi</label><input type="text" name="province" id="prov" class="form-control">';
        var kabupaten = '<label>Kabupaten</label><input type="text" name="kabupaten" id="kab" class="form-control">';
        var kecamatan = '<label>Kecamatan</label><input type="text" name="kecamatan" id="kec" class="form-control">';
        var kelurahan = '<label>Kelurahan</label><input type="text" name="kelurahan" id="kel" class="form-control">';

        $('#formProv').html(province);
        $('#formKab').html(kabupaten);
        $('#formKec').html(kecamatan);
        $('#formKel').html(kelurahan);


    }
})

// $('#formNext').css('display','none');
// $(document).on('click','#btnNext',function(){
    
//     var sub= $('#sub_pelayanan').val();
//     var pelayanan= $('#pelayanan').val();
//     var no= $('#no_pengajuan').val();
//     var banjar = $('#banjar').val();
//     var nik = $('#nik').val();
//     var nama = $('#fullname').val();
//     var gender = $('#gender').val();
//     var email = $('#email').val();
//     if(sub != null && pelayanan != null && no != null && banjar != null && nik != null && nama != null && gender != null && email != null){
//         $('#formNext').css('display','');
//         $.ajax({
//             type:'POST',
//             url:baseUrl+'administrasi/checkPelayanan',
//             data:{sub:sub},
//             dataType:'json',
//             beforeSend:function(){
//                 loadContent('#dataPemohon');
//             },success:function(resp){
//                 if(resp.status == true){
//                     $('#btnPengajuan').css('display','');
//                     $('#dataPemohon').html(resp.content);
//                 }else{
//                     $('#btnPengajuan').css('display','none');
//                     $('#dataPemohon').html('');
//                     $('#formNext').css('display','none');
//                     error(resp.msg);
//                 }
//                 $('#btnNext').css('display','none');
//             },complete:function(){
//                 $([document.documentElement, document.body]).animate({
//                     scrollTop: $("#formNext").offset().top
//                 }, 2000);
//             }
//         })
//     }else{
//         error('Data tidak boleh kosong');
//         $('#formNext').css('display','none');
//     }
 
// })

pelayanan();
function pelayanan(){
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/pelayanan',
        dataType:'json',
        beforeSend:function(){
            $('#pelayanan').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#pelayanan').html(resp.data);
                
                
            }else{
                error(resp.msg);
            }
            
        }

    })
    
}
job();
function job(){
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/job',
        dataType:'json',
        beforeSend:function(){
            $('#job').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#job').html(resp.data);
                
                
            }else{
                error(resp.msg);
            }
            
        }

    })
    
}

$(document).on('submit','#formAdd',function(e){
    e.preventDefault();
   
    var formData = new FormData(this);
                // formData.append('')
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/store',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        dataType :'json',
        beforeSend:function(){
            loading();
            $('input').attr('disabled',true);
            $('select').attr('disabled',true);
            $('button').attr('disabled',true);
            $('textarea').attr('disabled',true);



        },success:function(resp){
            
            if(resp.status == true){
                $('input').val('');
                $('select').val('');
                $('textarea').val('');

                
                success_redirect(resp.msg,resp.redirect);
            }else{
                error(resp.msg);
            }
        },complete:function(){
            $('input').attr('disabled',false);
            $('select').attr('disabled',false);
            $('button').attr('disabled',false);
            $('textarea').attr('disabled',false);




            loadingOut();
        }
    })
            
   
})
$(document).on('change','#file',function(e){
    var fileName = e.target.files[0].name;
    $('#labelFile').html(fileName);
    var file = $("#file").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#imgFile").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
})
country();
function country(){
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/country',
        dataType:'json',
        beforeSend:function(){
            $('#country').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#country').html(resp.data);
                $('#country').val('Indonesia').change();
              
                
            }else{
                error(resp.msg);
            }
            
        }

    })
    
}
banjar();
function banjar(){
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/banjar',
        dataType:'json',
        beforeSend:function(){
            $('#banjar').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#banjar').html(resp.data);
                
            }else{
                error(resp.msg);
            }
            
        }

    })
    
}
// $(document).on('change','#sub_pelayanan',function(){
//     $('#formNext').css('display','none');
//     // $('#btnNext').css('display','');
//     $('#btnPengajuan').css('display','none');
// });
$(document).on('change','#pelayanan',function(){
    // $('#formNext').css('display','none');
    // $('#btnNext').css('display','');
    $.ajax({
        type:'POST',
        url:baseUrl+'administrasi/subPelayanan',
        data:{id:$(this).val()},
        dataType:'json',
        beforeSend:function(){
            $('#sub_pelayanan').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#sub_pelayanan').html(resp.data);
             
            }else{
              

                $('#sub_pelayanan').html('');
                error(resp.msg);
            }
            
        }

    })
})

function loadContent(elem){
    var html ='<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
    $(elem).html(html);
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
function error(msg){

    swal({
        title: 'Oooppss!',
       
        text:msg,
        
          
        customClass: 'swal-wide',
         icon:'error',
         allowOutsideClick: false,
        
        })

}
function success(msg){
swal({
    title: 'Successfully!',
   
    text:msg,
    
      
    customClass: 'swal-wide',
    allowOutsideClick: false,
    icon:'success',
    
    })  
}
function success_redirect(msg,redirect){

    swal({
        title: 'Successfully',
        text: msg,
        icon: 'success',
        allowOutsideClick: false,
        
        
        
      }) .then((willDelete) => {
        if (willDelete) {
            window.location = redirect;
        } 
    });
}