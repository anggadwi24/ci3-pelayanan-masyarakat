import baseUrl from "../base.js";
import basePath from "../domain.js";
var getUrl = window.location;
var cat = getUrl.pathname.split('/')[3];


berita();
foto();
function berita(){
       
    $.ajax({
      url: baseUrl+'site/category/berita',
      type: 'POST',
      data:{cat:cat},
      dataType: 'json',
      success: function(resp){
        if(resp.status == true){
            $('#berita').html(resp.output);
           
        }
      }
    });
}
video();
function video(){
       
    $.ajax({
      url: baseUrl+'site/category/video',
      type: 'POST',
      data:{cat:cat},
      dataType: 'json',
      success: function(resp){
        if(resp.status == true){
            $('#video').html(resp.output);
           
        }
      }
    });
}

function foto(){
       
    $.ajax({
      url: baseUrl+'site/category/foto',
      type: 'POST',
      data:{cat:cat},
      dataType: 'json',
      success: function(resp){
        if(resp.status == true){
            $('#foto').html(resp.output);
           
        }
      }
    });
}