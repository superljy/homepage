$(function(){
    var height = $('body').height();
    console.log(height);
    $('.swiper-container').height(height);

    var mySwiper = new Swiper('.swiper-container',{
        direction:'vertical',
        speed:800,
        effect:'fade',
        fadeEffect:{
        	crossFade: true
        },
        initialSlide:0,
        on:{
        	init:function(){
        		swiperAnimateCache(this);
        		swiperAnimate(this);
        	},
        	slideChangeTransitionEnd:function(){
        		swiperAnimate(this);
        	},
        	slideChangeTransitionStart:function(){
        		swiperAnimateCache(this);
        	}
        }
    });

    // bgm按钮
    $('.bgm_ico').on('click',function(){
        var bgmPlayer = $('#bgm').get(0);
        if (bgmPlayer.paused) {
            bgmPlayer.play();
            $('.bgm_ico').addClass('bgm_ico_ani');
        }else{
            bgmPlayer.pause();
            $('.bgm_ico').removeClass('bgm_ico_ani');
        }
    });

    // 地图
    var map = new AMap.Map('amap',{
        zoom:15,
        center:[113.321803,23.117347]
    });

    var marker = new AMap.Marker({
        position:[113.321803,23.117347]
    });

    marker.setMap(map);

    var info = new AMap.InfoWindow({
        content:'<span class="add">广州市天河区华夏路10号富力中心1006</span>',
        offset:new AMap.Pixel(0,-20)
    });
    info.open(map,marker.getPosition());

    AMap.event.addListener(marker,'click',function(){
        info.open(map,marker.getPosition());
    });

    // 报名
    var name = $('#name');
    var phone = $('#phone');
    var company = $('#company');

    function regNameFn(obj){
        var regName = /^[\u4E00-\u9FA5]+$/;
        if (!regName.test(obj)) {
            obj = '';
            alert('请输入中文名字');
            return false
        }else{
            return true;
        }
    }

    function regPhoneFn(obj){
        if (isNaN(obj) || obj.length != 11) {
            obj = '';
            alert('请输入11位的手机号码');
            return false;
        }else{
            return true;
        }
    }

    function regComFn(obj){
        if (obj.length == 0) {
            obj = '';
            alert('请输入公司名称');
            return false;
        }else{
            return true;
        }
    }

    $('.submit').on('click',function(e){
        e.preventDefault();
        var user = name.val();
        var txt = phone.val();
        var com = company.val();
        var nameResult = regNameFn(user);
        var phoneResult = regPhoneFn(txt);
        var companyResult = regComFn(com);

        if (!nameResult || !phoneResult || !companyResult) {
            name.val('');
            phone.val('');
            company.val('');
            return
        }else{
            var jsonData = {
                user : user,
                txt : txt,
                com : com
            };
            $.ajax({
                url:'../signup/comment.php',
                type:'POST',
                data:jsonData,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    if (data.code == 1) {
                        $('#message').show().html('报名成功').fadeOut(3000);
                        name.val('');
                        phone.val('');
                        company.val('');
                    }else{
                        $('#message').show().html(data.message).fadeOut(3000);
                    }
                },
                error:function(jqXHR,textStatus,errorThrown){console.log(jqXHR); console.log(textStatus); console.log(errorThrown); }
            });
        }
    });
})