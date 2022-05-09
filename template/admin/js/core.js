import baseUrl from "../ajax/base.js";
import basePath from "../ajax/domain.js";
__datamenu();
$(function(){

    var url = window.location;
        
        // now grab every link from the navigation
        
        $(".pcoded-inner-navbar li a ").each(function(){
                console.log($(this).attr('href'));

            if($(this).attr("href")==url.href){
              
                $(this).addClass("active");
                
            }
        })

});
__datanotif();
function __datanotif(){
    var load = '<div class="d-flex justify-content-center my-3"><div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div></div>';
    $.ajax({
        type:'POST',
        url:baseUrl+'ajax/dataNotif',
        dataType:'json',
        beforeSend:function(){
            $('#notif').html(load);
        },success:function(resp){
            if(resp.status == true){
                $('#notif').html(resp.html);
            }
           
        }
    })
}
$(document).on('click','#readNotif',function(){
    $.ajax({
        type:'POST',
        url:baseUrl+'ajax/readNotif',
        dataType:'json',
    
        success:function(resp){
            if(resp.status == true){
               
                __datanotif();
            }
        }
    })
})
$(document).on('click','#clearNotif',function(){
    $.ajax({
        type:'POST',
        url:baseUrl+'ajax/clearNotif',
        dataType:'json',
    
        success:function(resp){
            if(resp.status == true){
               
                __datanotif();
            }
        }
    })
})
$(document).on('click','.notif',function(){
    var link = $(this).attr('data-href');
    var id = $(this).attr('data-notif');

    $.ajax({
        type:'POST',
        url:baseUrl+'ajax/updateNotif',
        dataType:'json',
        data:{id:id},
        success:function(resp){
            if(resp.status == true){
                window.location = link;

            }
        }
    })
});
function __datamenu(){
    var html = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>       ';
    $.ajax({
        type:'POST',
        url:baseUrl+'ajax/dataMenu',
        dataType:'json',
        beforeSend:function(){
            $('#__datamenu').html(html);
        },
        success:function(resp){
            if(resp.status == true){
                $('#__datamenu').html(resp.output);
                
            }else{
                error_redirect(resp.msg,baseUrl+'auth');
            }
            
        },
        complete:function(){
            $.fn.pcodedmenu = function(settings) {
                var oid = this.attr("id");
                var defaults = {
                    themelayout: 'vertical',
                    MenuTrigger: 'click',
                    SubMenuTrigger: 'click',
                };
                var settings = $.extend({}, defaults, settings);
                var PcodedMenu = {
                    PcodedMenuInit: function() {
                        PcodedMenu.HandleMenuTrigger();
                        PcodedMenu.HandleSubMenuTrigger();
                        PcodedMenu.HandleOffset();
                    },
                    HandleSubMenuTrigger: function() {
                        var $window = $(window);
                        var newSize = $window.width();
                        if ($('.pcoded-navbar').hasClass('theme-horizontal') == true) {
                            if (newSize >= 768) {
                                var $dropdown = $(".pcoded-inner-navbar .pcoded-submenu > li.pcoded-hasmenu");
                                $dropdown.off('click').off('mouseenter mouseleave').hover(
                                    function() {
                                        $(this).addClass('pcoded-trigger');
                                    },
                                    function() {
                                        $(this).removeClass('pcoded-trigger');
                                    }
                                );
                            } else {
                                var $dropdown = $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li");
                                $dropdown.off('mouseenter mouseleave').off('click').on('click',
                                    function() {
                                        var str = $(this).closest('.pcoded-submenu').length;
                                        if (str === 0) {
                                            if ($(this).hasClass('pcoded-trigger')) {
                                                $(this).removeClass('pcoded-trigger');
                                                $(this).children('.pcoded-submenu').slideUp();
                                            } else {
                                                $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                                $(this).addClass('pcoded-trigger');
                                                $(this).children('.pcoded-submenu').slideDown();
                                            }
                                        } else {
                                            if ($(this).hasClass('pcoded-trigger')) {
                                                $(this).removeClass('pcoded-trigger');
                                                $(this).children('.pcoded-submenu').slideUp();
                                            } else {
                                                $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                                $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                                $(this).addClass('pcoded-trigger');
                                                $(this).children('.pcoded-submenu').slideDown();
                                            }
                                        }
                                    });
                                $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li").on('click', function(e) {
                                    e.stopPropagation();
                                    alert( "click call" );
                                    var str = $(this).closest('.pcoded-submenu').length;
                                    if (str === 0) {
                                        if ($(this).hasClass('pcoded-trigger')) {
                                            $(this).removeClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideUp();
                                        } else {
                                            $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                            $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                            $(this).addClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideDown();
                                        }
                                    } else {
                                        if ($(this).hasClass('pcoded-trigger')) {
                                            $(this).removeClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideUp();
                                        } else {
                                            $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                            $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                            $(this).addClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideDown();
                                        }
                                    }
                                });
                            }
                        }
                        switch (settings.SubMenuTrigger) {
                            case 'click':
                                $('.pcoded-navbar .pcoded-hasmenu').removeClass('is-hover');
                                $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li").on('click', function(e) {
                                    e.stopPropagation();
                                    var str = $(this).closest('.pcoded-submenu').length;
                                    if (str === 0) {
                                        if ($(this).hasClass('pcoded-trigger')) {
                                            $(this).removeClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideUp();
                                        } else {
                                            $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                            $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                            $(this).addClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideDown();
                                        }
                                    } else {
                                        if ($(this).hasClass('pcoded-trigger')) {
                                            $(this).removeClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideUp();
                                        } else {
                                            $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                            $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                            $(this).addClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideDown();
                                        }
                                    }
                                });
                                $(".pcoded-submenu > li").on('click', function(e) {
                                    e.stopPropagation();
                                    var str = $(this).closest('.pcoded-submenu').length;
                                    if (str === 0) {
                                        if ($(this).hasClass('pcoded-trigger')) {
                                            $(this).removeClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideUp();
                                        } else {
                                            $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                            $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                            $(this).addClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideDown();
                                        }
                                    } else {
                                        if ($(this).hasClass('pcoded-trigger')) {
                                            $(this).removeClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideUp();
                                        } else {
                                            $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                            $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                            $(this).addClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideDown();
                                        }
                                    }
                                });
                                break;
                        }
                    },
                    HandleMenuTrigger: function() {
                        var $window = $(window);
                        var newSize = $window.width();
                        if ($('.pcoded-navbar').hasClass('theme-horizontal') == true) {
                            var $dropdown = $(".pcoded-inner-navbar > li");
                            if (newSize >= 768) {
                                $dropdown.off('click').off('mouseenter mouseleave').hover(
                                    function() {
                                        $(this).addClass('pcoded-trigger');
                                        if ($('.pcoded-submenu', this).length) {
                                            var elm = $('.pcoded-submenu:first', this);
                                            var off = elm.offset();
                                            var l = off.left;
                                            var w = elm.width();
                                            var docH = $(window).height();
                                            var docW = $(window).width();
            
                                            var isEntirelyVisible = (l + w <= docW);
                                            if (!isEntirelyVisible) {
                                                var temp = $('.sidenav-inner').attr('style');
                                                $('.sidenav-inner').css({'margin-left': (parseInt(temp.slice(12, temp.length - 3)) - 80)});
                                                $('.sidenav-horizontal-prev').removeClass('disabled');
                                            } else {
                                                $(this).removeClass('edge');
                                            }
                                        }
                                    },
                                    function() {
                                        $(this).removeClass('pcoded-trigger');
                                    }
                                );
                            } else {
                                $dropdown.off('mouseenter mouseleave').off('click').on('click',
                                    function() {
                                        if ($(this).hasClass('pcoded-trigger')) {
                                            $(this).removeClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideUp();
                                        } else {
                                            $('li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                            $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                            $(this).addClass('pcoded-trigger');
                                            $(this).children('.pcoded-submenu').slideDown();
                                        }
                                    }
                                );
                            }
                        }
                        switch (settings.MenuTrigger) {
                            case 'click':
                                $('.pcoded-navbar').removeClass('is-hover');
                                $(".pcoded-inner-navbar > li:not(.pcoded-menu-caption) ").on('click', function() {
                                    if ($(this).hasClass('pcoded-trigger')) {
                                        $(this).removeClass('pcoded-trigger');
                                        $(this).children('.pcoded-submenu').slideUp();
                                    } else {
                                        $('li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                        $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                        $(this).addClass('pcoded-trigger');
                                        $(this).children('.pcoded-submenu').slideDown();
                                    }
                                });
                                break;
                        }
                    },
                    HandleOffset: function() {
                        switch (settings.themelayout) {
                            case 'horizontal':
                                var trigger = settings.SubMenuTrigger;
                                if (trigger === "hover") {
                                    $("li.pcoded-hasmenu").on('mouseenter mouseleave', function(e) {
                                        if ($('.pcoded-submenu', this).length) {
                                            var elm = $('.pcoded-submenu:first', this);
                                            var off = elm.offset();
                                            var l = off.left;
                                            var w = elm.width();
                                            var docH = $(window).height();
                                            var docW = $(window).width();
            
                                            var isEntirelyVisible = (l + w <= docW);
                                            if (!isEntirelyVisible) {
                                                $(this).addClass('edge');
                                            } else {
                                                $(this).removeClass('edge');
                                            }
                                        }
                                    });
                                } else {
                                    $("li.pcoded-hasmenu").on('click', function(e) {
                                        e.preventDefault();
                                        if ($('.pcoded-submenu', this).length) {
                                            var elm = $('.pcoded-submenu:first', this);
                                            var off = elm.offset();
                                            var l = off.left;
                                            var w = elm.width();
                                            var docH = $(window).height();
                                            var docW = $(window).width();
            
                                            var isEntirelyVisible = (l + w <= docW);
                                            if (!isEntirelyVisible) {
                                                $(this).toggleClass('edge');
                                            }
                                        }
                                    });
                                }
                                break;
                            default:
                        }
                    },
                };
                PcodedMenu.PcodedMenuInit();
            };
            $("#pcoded").pcodedmenu({
                MenuTrigger: 'click',
                SubMenuTrigger: 'click',
            });
            var url = window.location;
            
        
            // now grab every link from the navigation
            
            $("li a ").each(function(){
                 
    
                if($(this).attr("href")==url.href){
                    // console.log($(this).attr('href'));
                    $(this).parent('li').addClass("active");
                    if($(this).parent('li').parent('ul').hasClass('pcoded-submenu')){
                        
                        $(this).parent('li').parent('ul').parent('li').addClass('active');
                        $(this).parent('li').parent('ul').parent('li').addClass('pcoded-trigger');

                    }
                  


                    
                }
            })
    
        }
    })
}
function error_redirect(msg,redirect){

    swal({
        title: 'Successfully',
        text: msg,
        icon: 'success',
        buttons: true,
        // dangerMode: true,
        // buttons: [ 'Tetap Dihalaman','Kemabli']
      }) .then((willDelete) => {
        if (willDelete) {
            window.location = redirect;
        } else {
          swal.close();
        }
    });
    }
