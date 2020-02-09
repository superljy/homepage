$(function(){
    // front page
    $('.open_door').on('click',function(){
        var video = $('.open_door').get(0);
        // $('.f_page').hide();
        // $('.open_door').show();
        video.play();
        document.addEventListener('WeixinJSBridgeReady',function(){
            video.play();
        },false);
        setTimeout(function(){
            $('.open_door').fadeOut();
            $('.bg_section').fadeIn(300);
            init();
            animate();
        },2800);

    });

    // main page VR 
    var camera, scene, renderer;

    var target = new THREE.Vector3();

    var lon = 90, lat = 0;
    var phi = 0, theta = 0;

    var touchX, touchY;
    

    function init() {

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera( 90, window.innerWidth / window.innerHeight, 1, 1000 );

        renderer = new THREE.CSS3DRenderer();
        renderer.setSize( window.innerWidth, window.innerHeight );
        document.body.appendChild( renderer.domElement );

        var sides = [
            {
                url: 'img/vrbankright.jpg',
                position: [ -512, 0, 0 ],
                rotation: [ 0, Math.PI / 2, 0 ]
            },
            {
                url: 'img/vrbankleft.jpg',
                position: [ 512, 0, 0 ],
                rotation: [ 0, -Math.PI / 2, 0 ]
            },
            {
                url: 'img/vrbanktop.jpg',
                position: [ 0,  512, 0 ],
                rotation: [ Math.PI / 2, 0, Math.PI ]
            },
            {
                url: 'img/vrbankbottom.jpg',
                position: [ 0, -512, 0 ],
                rotation: [ - Math.PI / 2, 0, Math.PI ]
            },
            {
                url: 'img/vrbankfront.jpg',
                position: [ 0, 0,  512 ],
                rotation: [ 0, Math.PI, 0 ]
            },
            {
                url: 'img/vrbankback.jpg',
                position: [ 0, 0, -512 ],
                rotation: [ 0, 0, 0 ]
            }
        ];

        for ( var i = 0; i < sides.length; i ++ ) {

            var side = sides[ i ];

            var element = document.getElementById('bg_section_'+i);
            // var element = document.createElement('img');
            element.width = 1026; // 2 pixels extra to close the gap.
            element.height = 1026;
            // element.src = side.url;

            var object = new THREE.CSS3DObject( element );
            object.position.fromArray( side.position );
            object.rotation.fromArray( side.rotation );
            scene.add( object );

        }


        document.addEventListener( 'mousedown', onDocumentMouseDown, false );
        // document.addEventListener( 'wheel', onDocumentMouseWheel, false );

        document.addEventListener( 'touchstart', onDocumentTouchStart, false );
        document.addEventListener( 'touchmove', onDocumentTouchMove, false );

        window.addEventListener( 'resize', onWindowResize, false );

    }

    function onWindowResize() {

        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();

        renderer.setSize( window.innerWidth, window.innerHeight );

    }

    function onDocumentMouseDown( event ) {

        // event.preventDefault();

        document.addEventListener( 'mousemove', onDocumentMouseMove, false );
        document.addEventListener( 'mouseup', onDocumentMouseUp, false );

    }

    function onDocumentMouseMove( event ) {

        var movementX = event.movementX || event.mozMovementX || event.webkitMovementX || 0;
        // var movementY = event.movementY || event.mozMovementY || event.webkitMovementY || 0;

        lon -= movementX * 0.1;
        // lat += movementY * 0.1;

    }

    function onDocumentMouseUp( event ) {

        document.removeEventListener( 'mousemove', onDocumentMouseMove );
        document.removeEventListener( 'mouseup', onDocumentMouseUp );

    }

    function onDocumentMouseWheel( event ) {

        var fov = camera.fov + event.deltaY * 0.05;

        camera.fov = THREE.Math.clamp( fov, 10, 75 );

        camera.updateProjectionMatrix();

    }

    function onDocumentTouchStart( event ) {

        // event.preventDefault();

        var touch = event.touches[ 0 ];

        touchX = touch.screenX;
        // touchY = touch.screenY;

    }

    function onDocumentTouchMove( event ) {

        // event.preventDefault();

        var touch = event.touches[ 0 ];

        lon -= ( touch.screenX - touchX ) * 0.1;
        // lat += ( touch.screenY - touchY ) * 0.1;

        touchX = touch.screenX;
        // touchY = touch.screenY;

    }

    function animate() {

        requestAnimationFrame( animate );

        // lon +=  0.1;
        lat = Math.max( -90, Math.min( 90, lat ) );
        phi = THREE.Math.degToRad( 90 - lat );
        theta = THREE.Math.degToRad( lon );

        target.x = Math.sin( phi ) * Math.cos( theta );
        target.y = Math.cos( phi );
        target.z = Math.sin( phi ) * Math.sin( theta );

        camera.lookAt( target );

        renderer.render( scene, camera );

    }

    // VR end


    // btn window

    $('.frk_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/frk.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/frk_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/themes/html/cscb/play_video/#1');
    });

    $('.zbj_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/zbj.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/zbj_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/index.php/home');
    });

    $('.wdy_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/wdy.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/wdy_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/themes/html/cscb/eroad/video.html');
    });

    $('.zqc_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/zqc.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/zqc_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/themes/html/cscb/play_video/#3');
    });

    $('.cf_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/cf.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/cf_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/themes/html/cscb/play_video/#2');
    });

    $('.y20_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/20y.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/20y_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/themes/html/cscb/play_video/#0');
    });

    $('.qd_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/qd.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/qd_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/index.php/home/attendance');
    });

    $('.wl_btn').on('click',function(){
        $('.tip_page').show();
        $('.tip_page>img').attr('src','img/tip_page/wl.png');
        $('.tip_btn>a>img').attr('src','img/tip_page/wl_btn.png');
        $('.tip_btn>a').attr('href','http://cscb.wqcfs.com/themes/html/cscb/play_video/#4');
    });

    $('.tip_close').on('click',function(){
        $('.tip_page').hide();
    });


    // 限制只能在微信打开
    // 对浏览器的UserAgent进行正则匹配，不含有微信独有标识的则为其他浏览器  
    var useragent = navigator.userAgent;  
    if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {  
        $('.weixin_tip').show();
        $('.weixin_tip').siblings().hide();
    }else{
        $('.weixin_tip').hide();
    }
}); 