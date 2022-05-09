import baseUrl from "../base.js";
import basePath from "../domain.js";
var getUrl = window.location;

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