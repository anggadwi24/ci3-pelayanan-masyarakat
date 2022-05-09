export default function error(title,msg){
    swal({
        title: title,
       
        text:msg,
        
          
        customClass: 'swal-wide',
        allowOutsideClick: false,
        icon:'error',
        
        })  
    }