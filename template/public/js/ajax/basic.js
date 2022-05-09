$(document).on('click','.delete',function(){
    swal({
        title: 'Apakah anda yakin?',
        text: 'data akan terhapus',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        buttons: [ 'Batal','Hapus']
      }) .then((willDelete) => {
        if (willDelete) {
            window.location = $(this).attr('data-href');
        } else {
          swal.close();
        }
    });
})



  
    