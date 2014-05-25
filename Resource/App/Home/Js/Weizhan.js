define( function( require, exports, module ){
    var $ = require('jquery');
    require('tmpl')($);
    require('uio')($);
    var TouchScroll = require('touchScroll').TouchScroll;
    var TouchSlider = require('touchSlider').TouchSlider;


    // 幻灯片
    exports.touchScroll = function() {
        var active=0,
            as=document.getElementById('pagenavi').getElementsByTagName('a');

        for(var i=0;i<as.length;i++){
            (function(){
                var j=i;
                as[i].onclick=function(){
                    t2.slide(j);
                    return false;
                }
            })();
        }

        var t1=new TouchScroll({id:'wrapper','width':5,'opacity':0.7,color:'#555',minLength:20});

        var t2=new TouchSlider({id:'slider', speed:600, timeout:6000, before:function(index){
            as[active].className='';
            active=index;
            as[active].className='active';
        }});
    }

    // 顶部导航栏下拉
    exports.headMenu = function() {
        var menu = $('#headMenu');
        var bg = $('#coverBg');

        $('#headMenuBtn').on('click', function(){
            bg.removeClass('hidden');
            menu.removeClass('hidden');
        });

        bg.on('click', function(){
            menu.addClass('hidden');
            $(this).addClass('hidden');
        });

    }

    // 分类列表
    exports.cateList = function() {
        var cate = $('#cate');
        var bg = $('#coverBg');

        $('#showCate').on('click', function(){
            //console.log('cateList');
            bg.removeClass('hidden');
            cate.show();
        });

        $('#closeCate').on('click', function(){
            cate.hide();
            bg.addClass('hidden');
        });
    }

    // 新闻列表异步加载
    exports.moreNews = function( uid ) {
        var i = 1;

        $('#moreNews').on('click', function(){
            var url, data
                ,_this = this
                ,cate_id = $.uio.getUrlParam('cate_id');

            url = $.uio.getWebUrl() +"/ajax.php?m=Weizhan&a=moreNews";
            data = {i: i, uid: uid, cate_id: cate_id};
            $.uio.post(url, data, function( dataJson ){
                if ( dataJson && dataJson.success && dataJson.list ) {
                    $('#newsGroup').append($('newsTmpl').tmpl(dataJson.list));
                    i++;
                } else {
                    $(_this).text('已是最后页');
                }
            });
        });
    }

    // 产品列表异步加载
    exports.morePro = function( uid ) {
        var i = 1;

        $('#morePro').on('click', function(){
            var url, data
                ,_this = this
                ,cate_id = $.uio.getUrlParam('cate_id');

            url = $.uio.getWebUrl() +"/ajax.php?m=Weizhan&a=morePro";
            data = {i: i, uid: uid, cate_id: cate_id};
            $.uio.post(url, data, function( dataJson ){
                if ( dataJson && dataJson.success && dataJson.list ) {
                    $('#proGroup').append($('proTmpl').tmpl(dataJson.list));
                    i++;
                } else {
                    $(_this).text('已是最后页');
                }
            });
        });
    }




} );