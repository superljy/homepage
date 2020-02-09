// window.onload = function rain(){
//  var image = document.getElementById("background");

//  image.onload=function(){
//      var rainyDay = new RainyDay({
//          image:this
//      });
//      rainyDay.rain([rainyDay.preset(3,2,2),rainyDay.preset(5,5,2),100]);
//  }
//  image.src="image/forest.jpg"
// }

(function() {
    var ua = navigator.userAgent;
    if (/Safari|iPhone/i.test(ua) && /chrome/i.test(ua) == false) {
        document.body.classList.add('nofilter');
    }

    var rainyDay = new RainyDay({
        image: "background"
    });

    document.getElementById("me").onclick = function(){
        document.getElementById("about-me").classList.add("show-left");
    }

    document.getElementById("back").onclick = function(){
        document.getElementById("about-me").classList.remove("show-left");
    }

    document.getElementById("it").onclick = function(){
        if (screen.width < 420 ) {
            document.getElementById("right-side").style.transform = "perspective(600px) rotateY(0)";
        }else{
            window.location.hash = "about-it"; //跳转至锚点
        }
        
    }

    document.getElementById("it-back").onclick = function(){
        document.getElementById("right-side").style.transform = "perspective(600px) rotateY(-120deg)";
    }

    // swiper
    var aboutIt = new Swiper(".it-content",{
        effect : "coverflow"
    })
})();