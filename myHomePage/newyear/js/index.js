$(function(){
    // swiper主控
    var mySwiper = new Swiper('.swiper-container',{
        direction:'vertical',
        speed:800,
        effect:'fade',
        fadeEffect:{
        	crossFade: true
        },
        initialSlide:9,
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

    // 音乐开关
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

    // 报名表单
    var name = $('#name');
    var phone = $('#phone');
    var company = $('#company');
    var remark = $('#remark');

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

    function regMarkFn(obj){
        if (obj.length == 0) {
            obj = '';
            alert('请输入备注信息,如报名类型,参展商品等');
            return false;
        }else{
            return true;
        }
    }

    $('.submit').on('click',function(e){
        e.preventDefault();
        var user = name.val();
        var tel = phone.val();
        var com = company.val();
        var mark = remark.val();
        var nameResult = regNameFn(user);
        var phoneResult = regPhoneFn(tel);
        var companyResult = regComFn(com);
        var markResult = regMarkFn(mark);

        if (!nameResult || !phoneResult || !companyResult || !markResult) {
            name.val('');
            phone.val('');
            company.val('');
            remark.val('');
            return
        }else{
            var jsonData = {
                user : user,
                phone : tel,
                com : com,
                mark : mark
            };
            $.ajax({
                url:'../server/comment.php',
                type:'POST',
                data:jsonData,
                dataType:'json',
                success:function(data){
                    console.log(data)
                    if (data.code == 1) {
                        $('#message').show().html('报名成功').fadeOut(3000);
                        name.val('');
                        phone.val('');
                        company.val('');
                        remark.val('');
                    }else{
                        $('#message').show().html(data.message).fadeOut(3000);
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(XMLHttpRequest.status);
                    console.log(XMLHttpRequest.readyState);
                    console.log(textStatus);
                }
            });
        }
    });
});