import baseUrl from "../base.js";
import basePath from "../domain.js";
var getUrl = window.location;

detail();
function detail(){
    var seo = getUrl.pathname.split('/')[3];
    var ip = $('#ip').val();
    $.ajax({
      url: baseUrl+'site/gallery/data',
      type: 'POST',
      data:{seo:seo,ip:ip},
      dataType: 'json',
      success: function(resp){
        if(resp.status == true){
            $('#detail').html(resp.output);
            var topbar_headline = jQuery('.binduz-er-blog-related-post-slide');
            topbar_headline.slick({
                dots: false,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: false,
                speed: 1500,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1201,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                        }
                },
                    {
                        breakpoint: 992,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                        }
                },
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            slidesToShow: 1,
                        }
                },
              ]
    
            });
        }else{
           
        }
      }
    });
}
dataMost();
function dataMost(){
    var berita = getUrl.pathname.split('/')[2];
   
    $.ajax({
        type:'POST',
        url:baseUrl+'site/gallery/dataMost',
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