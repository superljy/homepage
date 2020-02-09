// 微信端bgm自动播放

$(function(){
  setTimeout(function(){  
         $(window).scrollTop(1);  
     },0);  
      // var bgm = $("#bgm").get(0);
      // bgm.play();  
      document.addEventListener("WeixinJSBridgeReady", function () {  
            WeixinJSBridge.invoke('getNetworkType', {}, function (e) {  
                bgm.play();  
            });  
      }, false);
})
    
// 微信端bgm自动播放 end