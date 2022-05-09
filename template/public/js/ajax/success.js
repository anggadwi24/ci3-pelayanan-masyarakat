export default function success(title,msg){
    swal({
        title: title,
       
        text:msg,
        
          
        customClass: 'swal-wide',
        allowOutsideClick: false,
        icon:'success',
    })  
    }