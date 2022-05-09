import baseUrl from "../base.js";
import basePath from "../domain.js";
var getUrl = window.lokeyion;
var key = basePath('key');

berita();
foto();
function berita(){
       
    $.ajax({
      url: baseUrl+'site/search/berita',
      type: 'POST',
      data:{key:key},
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
      url: baseUrl+'site/search/video',
      type: 'POST',
      data:{key:key},
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
      url: baseUrl+'site/search/foto',
      type: 'POST',
      data:{key:key},
      dataType: 'json',
      success: function(resp){
        if(resp.status == true){
            $('#foto').html(resp.output);
           
        }
      }
    });
}