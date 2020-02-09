$(document).ready(function(){
    // resize start
    var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';

    recalc();

    function recalc() {
        var clientWidth = $(document).width();
        if (!clientWidth) return;
        if(clientWidth>=750){
            $("html").css("fontSize","100px");
        }else{
            $("html").css("fontSize",100 * (clientWidth / 750 ) + "px");
        }
    };
    // resize end

    // random page
    var pageNum = Math.floor((Math.random()*6)+1);
    switch (pageNum){
        case 1:
        $(".page1").addClass("imp");
        $(".page1 .square").addClass("square-bottom");
        $(".page1 .r-square").addClass("r-square-l-imp");
        $(".page2").addClass("p2-imp");
        $(".page2 .square").addClass("square-bottom");
        $(".page2 .r-square").addClass("r-square-l-imp");
        $(".three-hit img").hide();
        $(".page3").addClass("p3-imp");
        $(".page3 .square").addClass("p3-square-bottom");
        $(".page3 .r-square").addClass("r-square-l-imp");
        break;
        case 2:
        $(".page1").addClass("arya");
        $(".page1 .square").addClass("square-bottom");
        $(".page1 .r-square").addClass("r-square-l-arya");
        $(".page2").addClass("p2-arya");
        $(".page2 .square").addClass("square-bottom");
        $(".page2 .r-square").addClass("r-square-l-arya");
        $(".three-hit img").attr("src","img/arya/arya-three-hit.jpg");
        $(".page3").addClass("p3-arya");
        $(".page3 .square").addClass("p3-square-bottom");
        $(".page3 .r-square").addClass("r-square-l-arya");
        break;
        case 3:
        $(".page1").addClass("dany");
        $(".page1 .square").addClass("square-bottom");
        $(".page1 .r-square").addClass("r-square-l-arya");
        $(".page2").addClass("p2-dany");
        $(".page2 .square").addClass("square-bottom");
        $(".page2 .r-square").addClass("r-square-l-arya");
        $(".three-hit img").attr("src","img/dany/dany-three-hit.jpg");
        $(".page3").addClass("p3-dany");
        $(".page3 .square").addClass("p3-square-bottom");
        $(".page3 .r-square").addClass("r-square-l-arya");
        break;
        case 4:
        $(".page1").addClass("john");
        $(".page1 .square").addClass("square-bottom");
        $(".page1 .r-square").addClass("r-square-l-arya");
        $(".page2").addClass("p2-john");
        $(".page2 .square").addClass("square-bottom");
        $(".page2 .r-square").addClass("r-square-l-arya");
        $(".three-hit img").attr("src","img/john/john-three-hit.jpg");
        $(".page3").addClass("p3-john");
        $(".page3 .square").addClass("p3-square-bottom");
        $(".page3 .r-square").addClass("r-square-l-arya");
        break;
        case 5:
        $(".page1").addClass("nightKing");
        $(".page1 .square").addClass("square-bottom");
        $(".page1 .r-square").addClass("r-square-l-arya");
        $(".page2").addClass("p2-nightKing");
        $(".page2 .square").addClass("square-bottom");
        $(".page2 .r-square").addClass("r-square-l-arya");
        $(".three-hit img").attr("src","img/nightking/nk-three-hit.jpg");
        $(".page3").addClass("p3-nightKing");
        $(".page3 .square").addClass("p3-square-bottom");
        $(".page3 .r-square").addClass("r-square-l-arya");
        break;
        case 6:
        $(".page1").addClass("jamie");
        $(".page1 .square").addClass("square-bottom");
        $(".page1 .r-square").addClass("r-square-l-arya");
        $(".page2").addClass("p2-jamie");
        $(".page2 .square").addClass("square-bottom");
        $(".page2 .r-square").addClass("r-square-l-arya");
        $(".three-hit img").attr("src","img/jamie/jamie-three-hit.jpg");
        $(".page3").addClass("p3-jamie");
        $(".page3 .square").addClass("p3-square-bottom");
        $(".page3 .r-square").addClass("r-square-l-arya");
        break;
    }
    // random page end

    // bgm icon
    var bgmIcon = $(".bgm-ico img");
    bgmIcon.addClass("bgm-ico-rotate");
    bgmIcon.on("click",function(){
        var pageBgm = $("#bgm").get(0);
        if (!pageBgm.paused) {
            bgmIcon.removeClass("bgm-ico-rotate").attr("src","img/bgm-muted.png");
            $(".bgm-ico-extra").hide();
            pageBgm.pause();
        }else{
            bgmIcon.addClass("bgm-ico-rotate").attr("src","img/bgm-player.png");
            $(".bgm-ico-extra").show();
            pageBgm.play();
        }
    });
    // bgm icon end


    // 选项选择 start
    var square = $(".square img");
    $(".square").on("click",function(){
        square.hide();
        $(this).children(square).show();
        btnEff();
    });
    // 选项选择 end

    // 选项显示 start
    function selcShow(){
        $(".square").off("click");
        if (theAnswer) {
            $(".l-square img").show();
        }else{
            $(".r-square img").show();
        }
    }
    // 选项显示 end

    // 首页确认 start
    var theAnswer;
    $(".c-btn").on("click",function(){
        if (square.eq(0).css("display")!="none") {
            theAnswer = true;
            $(".choose-tip").hide();
            $(".cover").show();
            $(".tip-box").show();
        }else if (square.eq(1).css("display")!="none"){
            theAnswer = false;
            $(".choose-tip").hide();
            $(".cover").show();
            $(".tip-box").show();
        }else{
            $(".cover").show();
            $(".choose-tip").show();
        }
        btnEff();
    });
    // 首页确认 end

    // 未选择答案弹窗确认
    $(".choose-btn").on("click",function(){
        $(".cover").hide();
        btnEff();
    });
    // 未选择答案弹窗确认 end

    // 第一次弹窗确认 start
    $(".tip-btn").on("click",function(){
        btnEff();
        $(".page1").hide();
        $(".cover").hide();
        $(".page2").show(selcShow());
        $(".hammer").addClass("hammer-rotate");
    });
    // 第一次弹窗确认 end

    // 敲冰 start
    breakIce($(".hammer"),"act-hammer");

    var hit = 1;    
    function breakIce(ele,className){
        ele.on("click",function(){
            ele.removeClass("hammer-rotate").addClass("act-hammer");
            
            if (hit == 1) {
                $(".break-ice-text").hide();
                $(".break-ice-line").hide();
                $(".break-ice img").show();
                $(".break-pic img").hide();
                hit++;
            }else if (hit == 2) {
                $(".break-ice img").hide();
                $(".break-pic img").show();
                $(".break-pic>img").attr("src","img/imp-two-hit.png");
                hit++;
            }else if (hit == 3){
                $(".break-pic img").hide();
                $(".broken-ice").show();
                $(".broken-ice img").show().addClass("brokenIce");
                $(".three-hit").show().fadeOut(800);
                $(".page2").fadeOut(800);
                $(".page3").fadeIn(900);
                setTimeout(function(){
                    $(".cover").show();
                    $(".tip-box").hide();
                    if (theAnswer) {
                        // $(".right-box").slideDown(200);
                        $(".right-box").fadeIn(200);
                    }else{
                        // $(".wrong-box").slideDown(200);
                        $(".wrong-box").fadeIn(200);
                    }
                },800);
                hit = 1;
            }
            iceEff();
        });
        ele.on("animationend",function(){
            ele.removeClass("hammer-rotate").removeClass("act-hammer");
        });
    }

    // 敲冰 end

    // 按钮音效
    function btnEff(){
        var btn = $("#btnEff").get(0);
        btn.play();
    }

    function iceEff(){
        var ice = $("#iceEff").get(0);
        ice.play();
    }
    // 按钮音效 end

    // 分享
    $(".share-btn").on("click",function(){
        $(".tip-box").hide();
        $(".cover").show();
        $(".share-page").show();
        btnEff();
    });

    $(".share-page").on("click",function(){
        $(".share-page").hide();
        btnEff();
    });
    // 分享 end


    // 限制只能在微信打开
    // 对浏览器的UserAgent进行正则匹配，不含有微信独有标识的则为其他浏览器  
    var useragent = navigator.userAgent;  
    if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {  
        $('.weixin_tip').show();
        $('.weixin_tip').siblings().hide(); 
        $("#bgm").get(0).pause();
    }
    
});