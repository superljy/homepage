$(document).ready(function(){
    // 响应式宽高
    // 宽度
    /*document.querySelector('html').style.fontSize = document.documentElement.clientWidth / 375 * 50 + 'px';
    // 高度
    var scaleStyle = document.createElement('style');  //增加style标签
    var scaleTemp = (750/window.innerWidth*window.innerHeight/1334).toFixed(2)*1;  //iPhone6为例，求宽高比（toFiexd是方法可把 Number 四舍五入为指定小数位数的数字。这里是两位。最后*1是为了转为整数，当然 -0也可以）
    scaleTemp=scaleTemp>1?1:scaleTemp;  //如果宽高比大于1，就让他等于1，否则就是它自己的比例（小于1）
    scaleStyle.innerHTML='html{font-size:'+document.documentElement.clientWidth / 375 * 50 + 'px}.auto_scale{-webkit-transform: scale('+scaleTemp+');transform: scale('+scaleTemp+');}';  //在刚创建的style标签里设置根元素的样式（这里是iphone6 ,1rem=50px;）,将他进行自由缩放
    document.documentElement.appendChild(scaleStyle);  //增加给它的子元素
    */
    

    var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function () {
            var clientWidth = $(document).width();
            if (!clientWidth) return;
            if(clientWidth>=640){
                // docEl.style.fontSize = '100px';
                $("html").css("fontSize","100px");
            }else{
                // docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
                $("html").css("fontSize",100 * (clientWidth / 640 ) + "px");
            }
        };
    recalc();

    // 页面
    $(".pg1").on("click",function(){
        $(".pg1").removeClass("active");
        $(".pg2").addClass("active");
        setTimeout(function(){
            // $(".pg2").removeClass("active");
            // $(".pg3").addClass("active");
            $(".pg2").fadeOut(1000);
            $(".pg3").fadeIn(1500);
        },12000);
    });

    
})


