$(document).ready(function(){
    // var index = 0;
    // 首页联系方式图标鼠标划过表现效果
    // $(".connection>li>a>img").hover(activePic,defaultPic);

    $("#fullPage").fullpage({
        paddingTop:'60px',
        controlArrowColor:'#999',
        afterLoad:function(anchorLink,index){
            if (index == 1) {
                $(".logo").addClass("animated bounceInRight");
                $(".title").addClass("animated bounceInLeft");
            }
            if (index == 2) {
                $(".page2").addClass("current");
                $(".page2 .intro h1").show().addClass("animated fadeInDown");
                $(".page2 .intro p").show().addClass("animated rotateInUpLeft");
                $(".page2 .intro img").show().addClass("animated zoomIn");
            }
        }
    });
});

// function activePic(){
//     index = $(".connection>li>a>img").index($(this));
//     switch(index){
//         case 0:
//             $(".connection>li>a>img").eq(index).attr("src","img/weibo-d.png");
//             break;
//         case 1:
//             $(".connection>li>a>img").eq(index).attr("src","img/weixin-d.png");
//             $(".weixin-code").show();
//             break;
//         case 2:
//             $(".connection>li>a>img").eq(index).attr("src","img/mail-d.png");
//             break;
//     }
// }

// function defaultPic(){
//     switch(index){
//         case 0:
//             $(".connection>li>a>img").eq(index).attr("src","img/weibo.png");
//             break;
//         case 1:
//             $(".connection>li>a>img").eq(index).attr("src","img/weixin.png");
//             $(".weixin-code").hide();
//             break;
//         case 2:
//             $(".connection>li>a>img").eq(index).attr("src","img/mail.png");
//             break;
//     }
// }