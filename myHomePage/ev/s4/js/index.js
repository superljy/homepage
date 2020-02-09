$(document).ready(function() {
    // screen resize
    var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function() {
            var clientWidth = $(document).width();
            if (!clientWidth) return;
            if (clientWidth >= 750) {
                $("html").css("fontSize", "100px");
            } else {
                $("html").css("fontSize", 100 * (clientWidth / 750) + "px");
            }
        };
    recalc();

    // select game
    $(".select>img").click(function() {
        $(".sel-menu").toggle();
    });

    var selPic = $(".sel-menu>img");
    var index;
    // 判断选择场次
    var bothGame = false,
        js = false,
        cq = false;
    selPic.click(function() {
        index = selPic.index($(this));
        switch (index) {
            case 0:
                $(".sel-menu .up").toggle();
                break;
            case 1:
                $(".sel-menu .down").toggle();
                break;
        }

        if ($(".sel-menu .up").css("display") != "none" && $(".sel-menu .down").css("display") != "none") {
            $(".select>img").attr("src", "img/sel_02.png");
            // 选择两场
            bothGame = true;
        } else if ($(".sel-menu .up").css("display") != "none" || $(".sel-menu .down").css("display") != "none") {
            $(".select>img").attr("src", "img/sel_01.png");
            // 选择一场,与具体场次江苏,或重庆;
            $(".sel-menu .up").css("display") != "none" ? js = true : js = false;
            $(".sel-menu .down").css("display") != "none" ? cq = true : cq = false;
        } else {
            $(".select>img").attr("src", "img/select.png");
        }
    });


    // 活动说明弹窗
    $(".introduce").click(function(){
        $(".intro-detail").show();
    });

    $(".intro-detail-btn").click(function(){
        $(".intro-detail").hide();
    });

    // 提示输入电信号码弹窗
    var numReg = /\D/g;

    function numRegFn(obj){
        obj.value = obj.value.replace(numReg,'');
        if (!obj.value) {
            $(".input-num-tip").show();
        }
    }

    $(".signup-btn").click(function(){
        numRegFn($(".input-num").get(0));
    });

    $(".input-num-tip-btn").click(function(){
        $(".input-num-tip").hide();
    });

    // 限制只能在微信打开
    // 对浏览器的UserAgent进行正则匹配，不含有微信独有标识的则为其他浏览器  
    var useragent = navigator.userAgent;  
    if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {  
        // 这里警告框会阻塞当前页面继续加载  
        alert('已禁止本次访问：您必须使用微信内置浏览器访问本页面！');  
        // 以下代码是用javascript强行关闭当前页面  
        var opened = window.open('about:blank', '_self');  
        opened.opener = null;  
        opened.close();  
    }  

})