$(function(){
    // 输入提示
    $('.input_tip_btn').on('click',function(){
        $('.input_tip_page').hide();
    });

    var numReg = /\D/g;

    function numRegFn(obj){
        obj.value = obj.value.replace(numReg,'');
        if (!obj.value || obj.value.length != 11 ) {
            obj.value = "";
            $('.input_tip_page').show();
        }
    }

    $('.submit_btn').on('click',function(){
        numRegFn($('.tel').get(0));
    });

    // 说明页面
    $('.explain_btn').on('click',function(){
        $('.explain_page').show();
    });

    $('.explain_page_btn').on('click',function(){
        $('.explain_page').hide();
    });


    
})