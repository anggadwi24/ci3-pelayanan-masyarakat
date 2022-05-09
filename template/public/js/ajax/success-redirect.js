export default function successRedirect(title,msg,redirect){
  swal({
    title:title,
    text: msg,
    icon: 'success',
    allowOutsideClick: false,
    
    
    
  }) .then((willDelete) => {
    if (willDelete) {
        window.location = redirect;
    } 
});
    }