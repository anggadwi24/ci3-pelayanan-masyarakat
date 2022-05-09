$("#tot").bind('change', function () {
                               
    tampil();
                        
});
$( "#sbmTot" ).click(function(e) {
    e.preventDefault();
   tampil();


});
tampil();
function tampil(){
  var tot = $('#tot').val();
   var html = "";
                                      
    for (let i = 0; i < tot; i++) {
        html += " <div class='col-md-4 form-group'><label>Submodul</label><input type='text' name='submodul[]'  class='form-control' ></div><div class='col-md-4 form-group'><label>Link</label><input type='text' name='link[]'  class='form-control' ></div><div class='col-md-4 form-group'><h6>Publish</h6><select class='form-control' name='publish[]' ><option value='y'>Tampil</option><option value='n' selected>Tidak Tampil</option></select></div><div class='col-12 form-group'><hr></div>";;
     }
    $('#tampilInput').html(html);
                                          
}