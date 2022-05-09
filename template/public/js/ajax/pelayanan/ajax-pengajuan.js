import baseUrl from "../base.js";
import basePath from "../domain.js";
import loading from "../loadIn.js";
import loadingOut from "../loadOut.js";
import success from "../success.js";
import successRedirect from "../success-redirect.js";
import error from "../error.js";



var api = $('#apiKey').val();
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

recaptcha();
function recaptcha(){
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/reCaptcha',
        data:{api:api},
        dataType:'json',
        success:function(resp){
            if(resp.status == true){
                $('#recaptcha').html(resp.data.script);
                $('#recaptcha').append(resp.data.widget);
                
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })
}



$(document).on('change','#prov',function(){
    var id = $(this).val();
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/kabupaten',
        data:{id:id,api:api},
        dataType:'json',
        beforeSend:function(){
            $('#kab').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#kab').html(resp.data);
                
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })

});
$(document).on('change','#kab',function(){
    var id = $(this).val();
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/kecamatan',
        data:{id:id,api:api},
        dataType:'json',
        beforeSend:function(){
            $('#kec').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#kec').html(resp.data);
                
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })

});
$(document).on('change','#kec',function(){
    var id = $(this).val();
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/kelurahan',
        data:{id:id,api:api},
        dataType:'json',
        beforeSend:function(){
            $('#kel').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#kel').html(resp.data);
                
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })

});
$(document).on('change','#country',function(){
    var val = $(this).val();
    if(val == 'Indonesia'){
        var province = '<label class="form-label">Provinsi</label><select name="province" class="form-control" id="prov"></select>';
        var kabupaten = '<label class="form-label">Kabupaten</label><select name="kabupaten" class="form-control" id="kab"></select>';
        var kecamatan = '<label class="form-label">Kecamatan</label><select name="kecamatan" class="form-control" id="kec"></select>';
        var kelurahan = '<label class="form-label">Kelurahan</label><select name="kelurahan" class="form-control" id="kel"></select>';

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
            url:baseUrl+'site/ajax/province',
            data:{api:api},
            dataType:'json',
            beforeSend:function(){
                $('#prov').html($('<option>', {
                    
                    text: 'Loading...',
                }));
            },success:function(resp){
                if(resp.status == true){
                    $('#prov').html(resp.data);
                    
                    
                }else{
                    error('Ooopss..',resp.msg);
                }
                
            }
    
        })
    }else{
        var province = '<label class="form-label">Provinsi</label><input type="text" name="province" id="prov" placeholder="Masukan Provinsi" class="form-control">';
        var kabupaten = '<label class="form-label">Kabupaten</label><input type="text" name="kabupaten"  placeholder="Masukan Kabupaten" id="kab" class="form-control">';
        var kecamatan = '<label class="form-label">Kecamatan</label><input type="text" name="kecamatan" placeholder="Masukan Kecamatan" id="kec" class="form-control">';
        var kelurahan = '<label class="form-label">Kelurahan</label><input type="text" name="kelurahan" placeholder="Masukan Kelurahan" id="kel" class="form-control">';

        $('#formProv').html(province);
        $('#formKab').html(kabupaten);
        $('#formKec').html(kecamatan);
        $('#formKel').html(kelurahan);


    }
})
pelayanan();
function pelayanan(){
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/pelayanan',
        data:{api:api},
        dataType:'json',
        beforeSend:function(){
            $('#pelayanan').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#pelayanan').html(resp.data);
                
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })
    
}
job();
function job(){
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/job',
        data:{api:api},
        dataType:'json',
        beforeSend:function(){
            $('#job').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#job').html(resp.data);
                
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })
    
}
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
        url:baseUrl+'site/ajax/country',
        data:{api:api},
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
                error('Ooopss..',resp.msg);
            }
            
        }

    })
    
}
banjar();
function banjar(){
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/banjar',
        data:{api:api},
        dataType:'json',
        beforeSend:function(){
            $('#banjar').html($('<option>', {
                
                text: 'Loading...',
            }));
        },success:function(resp){
            if(resp.status == true){
                $('#banjar').html(resp.data);
                
            }else{
                error('Ooopss..',resp.msg);
            }
            
        }

    })
    
}

$(document).on('submit','#formAct',function(e){
    e.preventDefault();
   
    var formData = new FormData(this);
    formData.append('api',api);
              
    
    
  
    $.ajax({
        type:'POST',
        url:baseUrl+'site/pelayanan/store',
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

                
                successRedirect('Berhasil',resp.msg,resp.redirect);
            }else{
                error('Ooppss..',resp.msg);
                recaptcha();
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
$(document).on('change','#pelayanan',function(){
  
    $.ajax({
        type:'POST',
        url:baseUrl+'site/ajax/subPelayanan',
        data:{id:$(this).val(),api:api},
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
                error('Ooopss..',resp.msg);
            }
            
        }

    })
})