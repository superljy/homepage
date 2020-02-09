$(function(){
	var mySwiper = new Swiper('.swiper-container',{
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

    
})