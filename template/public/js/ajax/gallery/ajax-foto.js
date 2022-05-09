import baseUrl from "../base.js";
import basePath from "../domain.js";

function loadPage(pagno){
       
    $.ajax({
      url: baseUrl+'site/foto/data/'+pagno,
      type: 'POST',
    //   data:{pagno:pagno},
      dataType: 'json',
      success: function(resp){
        if(resp.status == true){
            $('#foto').html(resp.output);
            $('#pagination').html(resp.arr.pagination);
           
            var newurl = baseUrl+'site/foto/index/'+resp.arr.row;
            window.history.pushState({ path: newurl }, '', newurl);
        }
      }
    });
  }
$('#pagination').on('click','a',function(e){
    e.preventDefault(); 
    var pageno = $(this).attr('data-ci-pagination-page');
    $('#pagination a').removeClass('active');
    $(this).addClass('active');
    loadPage(pageno);
  });

  loadPage(0);