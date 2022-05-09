

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/"+getUrl.pathname.split('/')[2]+ "/";
    
  export default baseUrl;