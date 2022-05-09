import baseUrl from "../base.js";
import basePath from "../domain.js";
var getUrl = window.location;
mainImg()
function mainImg(){
    var berita = getUrl.pathname.split('/')[2];
   
    $.ajax({
        type:'POST',
        url:baseUrl+'site/news/dataDetail',
        data:{berita:berita},
        dataType:'json',
        success:function(resp){
          
            if(resp.status == true){
                var imgUrl = resp.data.imageHeader;
              
                $('#mainImg').css('background-image','url('+imgUrl+')');
                $('#title').html(resp.data.title);
                $('#tanggal').html('<i class="fal fa-calendar-alt"></i> '+resp.data.date);
                $('#category').html(resp.data.category);
                $('#author').html('By <span> '+resp.data.author+' </span>');
                $('#authorImg').attr('src',resp.data.authorImg);
                $('#view').html('<i class="fal fa-eye"></i> '+resp.data.view);
                $('#desc').html(resp.data.desc);
                $('#detail').html(resp.data.imageBody);

                $('#tag').html(resp.data.tag);
            }else{
                window.location = baseUrl+'/news/';
            }
        }
        
    })
}
postCondutor();
function postCondutor(){
    var berita = getUrl.pathname.split('/')[2];
   
    $.ajax({
        type:'POST',
        url:baseUrl+'site/news/dataPost',
        data:{berita:berita},
        dataType:'json',
        success:function(resp){
          
            if(resp.status == true){
               if(resp.data.beforeUrl == null && resp.data.beforeName == null){
                   $('#connPrev').html('');
               }else{
                   $('#urlPrev').attr('href',resp.data.beforeUrl);
                   $('#namePrev').html(resp.data.beforeName);

               }
               if(resp.data.afterUrl == null && resp.data.afterName == null){
                    $('#connNext').html('');
                }else{
                    $('#urlNext').attr('href',resp.data.afterUrl);
                    $('#nameNext').html(resp.data.afterName);

                }
            }else{
                window.location = baseUrl+'/news/';
            }
        }
        
    })
}

dataMost();
function dataMost(){
    var berita = getUrl.pathname.split('/')[2];
   
    $.ajax({
        type:'POST',
        url:baseUrl+'site/news/dataMost',
        data:{berita:berita},
        dataType:'json',
        success:function(resp){
          
            if(resp.status == true){
               $('#mostPopuler').html(resp.populer);
               $('#mostRecent').html(resp.recent);

            }else{
                window.location = baseUrl+'/news/';
            }
        }
        
    })
}

dataGallery();
function dataGallery(){
    
   
    $.ajax({
        type:'POST',
        url:baseUrl+'site/news/dataGallery',
      
        dataType:'json',
        success:function(resp){
          
            if(resp.status == true){
               $('#video').html(resp.video);
               $('#photo').html(resp.photo);

            }else{
                window.location = baseUrl+'/news/';
            }
        }
        
    })
}