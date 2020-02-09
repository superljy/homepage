$(function(){
    // var useragent = navigator.userAgent;  
    // if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {
    //     $('#bgm').get(0).pause();  
    //     $('.weixin_tip').show();
    //     $('.weixin_tip').siblings().hide();
    // }

    $('#fullpage').fullpage({
        resize:true,
        afterLoad:function(anchorLink,index){
            if (index == 1) {
                $('.logo').addClass('animated rotateInDownLeft');
                $('p').addClass('animated slideInRight');
            }
        }
    });

    $('.bgm_logo img').on('click',function(){
        var bgmPlayer = $('#bgm').get(0);
        if (bgmPlayer.paused) {
            bgmPlayer.play();
            $('.bgm_logo').addClass('bgm_logo_ani');
        }else{
            bgmPlayer.pause();
            $('.bgm_logo').removeClass('bgm_logo_ani');
        }
    });

    var name = $('#name');
    var phone = $('#phone');
    var company = $('#company');
    var job = $('#job');

    var regName = /^[\u4E00-\u9FA5]+$/;

    function regNameFn(obj){
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

    function regJFn(obj){
    	if (obj.length == 0) {
    		obj = '';
    		alert('请输入您的职位');
    		return false;
    	}else{
    		return true;
    	}
    }

    $('#submit').on('click',function(e){
    	e.preventDefault();
    	var user = name.val();
    	var txt = phone.val();
    	var com = company.val();
    	var j = job.val();
    	var nameResult = regNameFn(user);
    	var phoneResult = regPhoneFn(txt);
    	var companyResult = regComFn(com);
    	var jobResult = regJFn(j);

    	if (!nameResult || !phoneResult || !companyResult || !jobResult) {
    		name.val('');
    		phone.val('');
    		company.val('');
    		job.val('');
    		return
    	}else{
    		var jsonData = {
    			user : user,
    			txt : txt,
    			com : com,
    			job : j
    		};
    		$.ajax({
    			url:'../server/comment.php',
    			type:'POST',
    			data:jsonData,
    			datatype:'json',
    			success:function(res){
    				console.log(res);
    				if (res.code == 1) {
    					$('#message').show().html('报名成功').fadeOut(3000);
    					name.val('');
			    		phone.val('');
			    		company.val('');
			    		job.val('');
    				}else{
    					$('#message').show().html(res.message).fadeOut(3000);
    				}
    			},
                error:function(jqXHR,textStatus,errorThrown){console.log(jqXHR); console.log(textStatus); console.log(errorThrown); }
    		});
    	}
    });


})
