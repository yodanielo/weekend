$(document).ready( function(){
    $("#favoritos").click(function(){
        bookmarksite("Weekend", window.location.href);
        return false;
    });
    //inicio
    $("#foocol3 a:last").click(function(){
        this.style.behavior='url(#default#homepage)';
        this.setHomePage($(this).attr("href"));
        return false;
    });
    //$("#foocol1 a:last").attr("target", "_blank");
    $(".itemscroll").fancybox({
        opacity:0.8,
        overlayColor:'#000'
    });
    $(".item_banner").fancybox({
        opacity:0.8,
        overlayColor:'#000'
    });
    $(".banbtn").click(function(){
        ban=$(this).attr("href");
        ext=ban.substr(ban.length-3,3).toString().toLowerCase();
        switch(ext){
            case "jpg":
            case "gif":
            case "png":
                $("#despimg").html('<img src="'+ban+'" />');
                break;
        }
        $("#desptop").slideDown(450, function(){});
        return false;
    });
    $("#cerrarpubtxt").click(function(){
        $("#desptop").slideUp(450, function(){
            $("#despimg").empty();
        });
        return false;
    });
    $("#despimg img").click(function(){
        $("#desptop").slideUp(450, function(){
            $("#despimg").empty();
        });
        return false;
    });
    if($('.sec_selected:last').text()=="Portada"){
        $('#lofslidecontent45').lofJSidernews( {
            interval:10000,
            easing:'easeInOutQuad',
            duration:1200,
            auto:true
        } );
        $(".gruposcroll").each(function(){
            $(this).find(".itemscroll:last").css({
                "margin-right":0
            });
        });
        $('#visorscroll').cycle({
            fx:         'scrollLeft',
            pager:      '#pagerscroll',
            fastOnEvent: false,
            prev:'#scrollleft',
            next:'#scrollright',
            speed:    500,
            timeout:  7000,
            pagerAnchorBuilder:function(idx, slide){
                return '<a class="pagscroll" href="#"></a>';
            }
        });
    }
    if($("#breadcrumb a:last").length>0){
        load_articulos();
    }
});
load_articulos=function(){
    $("#breadcrumb a:last").addClass("bc_actual");
    $("#masactualidad").html("<strong>Más "+$("#breadcrumb a:last").text()+"</strong>");
    $("#togglearticulos span").html("Más "+$("#breadcrumb a:last").text());
    $("#togglearticulos,#separadorlistado").click(function(){
        if($("#notlistado1").css("display")=="block"){
            $("#notlistado1").slideUp(450, function(){});
            $("#togglearticulos img").attr("src",$("#togglearticulos img").attr("src").split("icoi10").join("icoi11"));
            $("#togglearticulos").removeClass("active");
        }else{
            $("#notlistado1").slideDown(450, function(){});
            $("#togglearticulos img").attr("src",$("#togglearticulos img").attr("src").split("icoi11").join("icoi10"));
            $("#togglearticulos").addClass("active");
        }
    })
}
function bookmarksite(title,url){

    var title=String(document.title);
    var url=String(window.location);

    if (window.sidebar) // firefox
        window.sidebar.addPanel(title, url, "");
    else if(window.opera && window.print){ // opera
        var elem = document.createElement('a');
        elem.setAttribute('href',href);
        elem.setAttribute('title',title);
        elem.setAttribute('rel','sidebar');
        elem.click();
    }
    else if(document.all)// ie
        window.external.AddFavorite(url, title);
    else {// otros web Browsers
        alert ("Presione Crtl+D para agregar a este sitio en sus Bookmarks");
    }
}