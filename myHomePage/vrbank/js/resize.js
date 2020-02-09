// resize start
$(function(){
    var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';

    recalc();

    function recalc() {
        var clientWidth = $(document).width();
        if (!clientWidth) return;
        if(clientWidth>=640){
            $("html").css("fontSize","100px");
        }else{
            $("html").css("fontSize",100 * (clientWidth / 640 ) + "px");
        }
    };
})
    
// resize end