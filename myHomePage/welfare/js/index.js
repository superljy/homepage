$(function(){
    // screen resize
    var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function() {
            var clientWidth = $(document).width();
            if (!clientWidth) return;
            if (clientWidth >= 750) {
                $("html").css("fontSize", "100px");
            } else {
                $("html").css("fontSize", 100 * (clientWidth / 750) + "px");
            }
        };
    recalc();
})