/**
 *  活动抽奖插件 -- jquery.zxLottery.js
 *  by itshajia <itshajia@gmail.com>
 *  个人博客 http://www.uioweb.com
 *
 *
 * */
define( function( require, exports, module ){

    return function( $ ) {
        var animationStartTime,requestId,requestSId;

        window.requestAnimFrame = (function(){
            return  window.requestAnimationFrame       ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame    ||

                function( callback ){
                    window.setTimeout(callback, 1000 / 60);
                };
        })();

        window.cancelAFrame = (function () {
            return window.cancelAnimationFrame ||
                window.webkitCancelAnimationFrame ||
                window.mozCancelAnimationFrame ||
                window.oCancelAnimationFrame ||

                function (id) {
                    window.clearTimeout(id);
                };
        })();

        // 图片预加载处理
        var IMG = {
            loadBack: function( src, callback, error ) {
                var img, userAgent;

                img = new Image();

                img.onerror = function() {
                    if( error ) error();
                    img.onload = img.onerror = null;
                    return;
                }

                img.src = src;
                if( img.readyState == "complete" || img.complete == true ) {
                    if( callback ) callback( img );
                    img.onload = img.onerror = null;
                    return;
                }

                img.onload = function() {
                    if( callback ) callback( img );
                    img.onload = img.onerror = null;
                    return;
                }

            }
        };

        $.fn.zxLottery = function ( options ) {

            // 默认配置
            var settings = {
                imgW: 180,              // 抽奖图片基准大小
                winW: 80,               // 获奖者头像大小
                winH: 150,              // 获奖者边框高度（zxWinner的高度）
                winM: 30,               // 获奖者头像间距
                bW: 3,                  // 抽奖边框宽度
                bC: 'red',              // 抽奖边框颜色
                startBtn: 'lotteryStart',   // 抽奖开始按钮ID
                stopBtn: 'lotteryStop',     // 抽奖停止按钮ID
                list: [],        // 图组对象列表
                winList: [],    // 获奖人名单
                showCount: 7,   // 抽奖框显示的数目
                winCount: 3,    // 抽奖名额数,
                winCurCount: 0,     // 已经获奖人数
                perInc: 20,
                indentPer: 8, // 图组缩进百分比
                bgWInc: 50,
                success: function( obj ){}
            };

            if( options ) $.extend( settings, options );

            var L = Lottery = {
                start: false,
                end: false,
                fast: true,     // 是否处于“加速状态”
                fasttime: 10000, // 加速时间，毫秒为单位
                width: 0,height: 0,
                pos:[],
                idex: 0, imgIdex: ( settings.showCount + 2 ), i: 0,
                maxZIndex: 0,
                speed: 100, // 初始速度
                startTime: 0, // 效果转动开始时间
                endTime: 0, // 效果转动结束时间
                endIdexs: [],
                imgShowList: [],
                imgHideList: [],
                loadCount: 0,  // 数据加载的数量
                totalCount: settings.list.length  // 数据总数量
            };

            L.el = $(this);

            $.extend( L, {
                initialize: function() {
                    L.initDom();
                    // 图片预加载处理
                    L.initImg();
                    /*L.initData();
                     L.onEvent();*/
                },
                initDom: function(){
                    var Dom = $(L.getBone());

                    L.el.append(Dom);
                    L.msgDom = $('.zxLotteryLoadMsg', Dom);
                    L.winDom = $('.zxLotteryWin', Dom);
                    L.nameDom = $('.zxLotteryName', Dom);
                    var WinnerDom = $(L.getWinnerBone());
                    L.winel = WinnerDom;
                    $('body').append(WinnerDom);
                },
                /**
                 * 获取各类容器DOM结构
                 * */
                getBone: function() {
                    var listHtm = L.getListBone();

                    var Htm = '<div id="zxLottery" class="zxLottery" style="'+ L.getLotteryStyle() +'">' +
                        '<div class="zxLotteryInner" style="position:relative;">'+
                        '<div class="zxLotteryLoadMsg">0/'+ L.totalCount +'%</div>'+
                        '<div class="zxLotteryWin" style="'+ L.getWinStyle() +'">'+
                        listHtm +
                        '</div>'+
                        '<div class="zxLotteryBg" style="'+ L.getBgStyle() +'">' +
                        '<div class="zxLotteryName" style="width:'+ (( 100 + settings.perInc ) * settings.imgW / 100) +'px;height:30px;"></div>' +
                        '</div>'+
                        '</div>'+
                        '</div>';
                    return Htm;
                },
                getWinnerBone: function(){
                    var Htm = '<div id="zxWinner" class="zxWinner" style="'+ L.getWinnerStyle() +'">' +
                        '<div class="zxWinnerInner" style="'+ L.getWinnerInnerStyle() +'">' +
                        L.getWinnerListBone() +
                        '</div>'
                    '</div>';
                    return Htm;
                },
                getWinnerListBone: function(){
                    var Htm = '';

                    for ( var i=0; i<settings.winCount; i++ ) {
                        if ( i< settings.winCurCount ) {
                            Htm += '<div class="zxWinnerItem win" style="'+ L.getWinItemStyle( i ) +'">' +
                                '<img src="'+ settings.winList[i]['src'] +'" style="width:100%;height:100%;" />' +
                                '<div class="zxWinnerName">'+ settings.winList[i]['name'] +'</div>' +
                                '</div>';
                        } else {
                            Htm += '<div class="zxWinnerItem" style="'+ L.getWinItemStyle( i ) +'"></div>';
                        }

                    }
                    return Htm;
                },
                getListBone: function(){
                    var Htm = '',pos={}, imgObj;



                    for ( var i=-1;i<=settings.showCount;i++ ) {
                        pos = L.getPosition(i);
                        //imgObj = L.getImgSrc(i+1);
                        Htm += '<div class="zxLotteryItem" style="'+ L.getLiStyle(pos) +'">' +
                            '<a href="javascript:;" class="zxLotteryA">'+
                            /*'<img style="width:100%;height:100%;" src="'+ imgObj['src'] +'" name="'+ imgObj['name'] +'" class="zxLotteryImg" />'+*/
                            '</a>'+
                            '</div>';
                    }
                    return Htm;
                },
                /**
                 * 获取各类容器样式
                 * */
                getLotteryStyle: function(){
                    var Style = 'width:'+ (L.getLotteryWidth()) +'px;height:'+
                        (L.height + settings.bW * 2) +'px;margin-left:auto;margin-right:auto;';
                    return Style;
                },
                getWinStyle: function() {
                    var Style = 'position:relative;width:'+ (L.getLotteryWidth()) +'px;height:'+
                        (L.height + settings.bW * 2) +'px;overflow:hidden;';
                    return Style;
                },
                getWinItemStyle: function( i ){
                    var Style = 'width:'+ settings.winW +'px;height:'+ settings.winW +
                        'px;border-radius:5px;border:1px solid #ffffff;position:absolute;top:0px;left:'+ i*(settings.winW + settings.winM) +'px;';
                    return Style;
                },
                getBgStyle: function() {
                    var Style = 'display:none;width:'+ (L.getLotteryWidth() + settings.bgWInc) +'px;height:'+
                        (settings.imgW + settings.bW * 2) +'px;position:absolute;left:-'+ (settings.bgWInc/2) +'px;top:'+
                        (L.height - settings.imgW)/2 +'px;z-index:'+ (L.maxZIndex+1)+';background:rgba(0,0,0,0.65);';
                    //return Style;
                },
                getLiStyle: function(pos){
                    var Style = 'position:absolute;border:'+ settings.bW +'px solid '+settings.bC+
                        ';top:'+ pos['top'] +'px;left:'+ pos['leftwidth'] +'px;z-index:'+
                        pos['zIndex']+';width:'+pos['width']+'px;height:'+pos['height']+'px;background:#ffffff;';
                    return Style;
                },
                /**
                 * 中奖人名单列表样式
                 * */
                getWinnerStyle: function(){
                    var Style = 'position:absolute;width:100%;height:'+ settings.winH +'px;left:0px;bottom:0px;background:rgba(0,0,0,0.8)';
                    return Style;
                },
                getWinnerInnerStyle: function(){
                    var Style = 'width:'+ (settings.winW * settings.winCount + settings.winM*( settings.winCount-1)) +'px;height:'+
                        settings.winW +'px;margin-left:auto;margin-right:auto;position:relative;margin-top:'+ (settings.winH - settings.winW)/2 +'px;';
                    return Style;
                },
                getPosition: function(i){
                    var mI, j, m, per, position, w, h, t, per_add, identWidth, left= 1;

                    mI = Math.ceil( settings.showCount / 2 );
                    j = i + 1;
                    per_add = 0;

                    if ( j < mI ) {
                        m = mI - j;
                        left = 1;
                    } else {
                        m = j - mI;
                        left = 0;
                    }

                    if ( m==0 ) per_add = settings.perInc;
                    L.height = ( 100 + settings.perInc ) * settings.imgW / 100;
                    per = 100 - m * 10 + per_add;

                    if ( m==0 ) L.maxZIndex = per;
                    w = settings.imgW * per / 100;
                    h = settings.imgW * per / 100;
                    t = ( L.height - h ) / 2;

                    identWidth = w*(100- (m)*(settings.indentPer ? settings.indentPer : 0)) / 100;

                    if ( !left ) {
                        identWidth = identWidth - (w*(settings.indentPer ? settings.indentPer : 0) / 100);
                    }


                    if ( j==0 ) {
                        L.width -= identWidth;
                    }

                    position = {
                        width: w,
                        height: h,
                        top: t,
                        zIndex: per,
                        indentWidth: identWidth,
                        leftwidth: L.width
                    };

                    if ( j <= settings.showCount ) {
                        L.width += identWidth;
                        /*console.log( L.width );*/
                    }

                    L.pos.push(position);
                    return position;
                },
                getLotteryWidth: function(){
                    var mI,identWidth, w,per;
                    mI = Math.ceil( settings.showCount / 2 );
                    per = 100 - mI * 10;

                    w = settings.imgW * per / 100;
                    identWidth = w*(mI)*(settings.indentPer ? settings.indentPer : 0) / 100;

                    return L.width + settings.bW * 2 + identWidth + 5;
                },
                initImg: function(){
                    var ImgObjArr, loaded = false;

                    // 获取图组对象列表，并进行初始化
                    ImgObjArr = settings.list
                    ImgObjArr.sort( L.randomSort );

                    // 图片预加载
                    for ( var i=0;i<ImgObjArr.length;i++ ) {
                        IMG.loadBack( ImgObjArr[i]['src'], function(){
                            L.loadCount++;
                            loaded = L.loadMsgOutput( L.loadCount, L.totalCount );
                            if ( loaded ) {
                                L.ImgObjArr = ImgObjArr;
                                L.initList();

                                /**
                                 * 抽奖开始前的成员展示效果
                                 * */
                                L.TIME = setInterval(function(){
                                    L.setList();
                                }, 10000);
                             }
                        } );
                    }


                },
                initList: function(){
                    // 图片显示index初始化
                    L.setShowElements(settings.showCount+2);
                    // 图片隐藏index初始化
                    L.setHideElements( settings.showCount+2, L.ImgObjArr.length );

                    L.initData();
                    L.List.each( function( i ){
                        var _this = this;
                        var Htm = '<img style="width:100%;height:100%;display:none;" src="'+ L.ImgObjArr[i]['src'] +
                            '" name="'+ L.ImgObjArr[i]['name'] +'" class="zxLotteryImg" />';
                        $(this).delay( i*400 , 'fade_'+ i).queue('fade_'+ i, function( next ){
                            $(_this).empty().append(Htm).find('img').fadeIn()
                            next();
                        }).dequeue('fade_'+ i);
                    } );
                    L.onEvent();

                },
                setList: function() {
                    var ImgObjArr;

                    //ImgObjArr = settings.list
                    //ImgObjArr.sort( L.randomSort );
                    L.ImgObjArr.sort( L.randomSort );
                    //L.ImgObjArr = ImgObjArr;

                    // 图片显示index初始化
                    L.setShowElements(settings.showCount+2);
                    // 图片隐藏index初始化
                    L.setHideElements( settings.showCount+2, L.ImgObjArr.length );

                    L.initData();
                    L.List.each( function( i ){
                        var _this = this;
                        var Htm = '<img style="width:100%;height:100%;display:none;" src="'+ L.ImgObjArr[i]['src'] +
                            '" name="'+ L.ImgObjArr[i]['name'] +'" class="zxLotteryImg" />';
                        $(this).delay( i * 400, 'fade_'+ i).queue('fade_'+ i, function( next ){
                            $(_this).empty().append(Htm).find('img').fadeIn();
                            next();
                        }).dequeue('fade_'+ i);
                    } );
                },
                // 预加载信息输出
                loadMsgOutput: function( i, t ){
                    var per, Htm;

                    per = Math.floor((i / t) * 100);
                    Htm = '<span class="zxLotteryLoadText">共'+ t +'人信息，正在加载第'+
                        i +'人数据...</span><span class="zxLotteryLoadPer">加载进度：'+ per +'%</span>';

                    L.msgDom.html( Htm );
                    if ( per ==100 ) {
                        $('#'+ settings.startBtn).show();
                        /*console.log( $('#'+ settings.startBtn) );*/
                        setTimeout( function(){
                         L.msgDom.fadeOut();
                         }, 1000);
                        return true;
                    } else {
                        return false;
                    }
                    //console.log( i+";"+ t+';百分比：'+ Math.floor((i / t) * 100) +'%');
                },
                getImgSrc: function( i ){
                    return L.ImgObjArr[i];
                },
                initData: function(){
                    L.List = $('.zxLotteryItem', L.el);
                },
                // 事件注册
                onEvent: function(){
                    L.onStart();
                    L.onStop();
                },
                onStart: function(){
                    $('#'+ settings.startBtn).unbind('click').bind('click', function(){
                        if( !L.endCheck() ) return;

                        L.startReset();
                        $('.zxLotteryBg', L.el).show().css({zIndex: (L.maxZIndex+1)});
                        window.cancelAFrame(requestSId);
                        window.cancelAFrame(requestId);
                        animationStartTime = window.performance.now();
                        requestId = window.requestAnimationFrame( L.run );
                    });
                },
                startReset: function() {
                    L.start = true;
                    L.end = false;
                    L.fast = true;
                    L.speed = 100;
                    L.nameDom.hide();
                    clearInterval(L.TIME);
                    $('#'+ settings.startBtn).hide();
                    $('#'+ settings.stopBtn).show();
                },
                onStop: function(){

                    $('#'+ settings.stopBtn).bind('click', function(){
                        L.doStop();
                    });
                },
                doStop: function(){

                    window.cancelAFrame(requestId);
                    L.start = false;
                },
                run: function( time ){
                    var b = true;

                    /**
                     * 增减滚动速度
                     * */
                    if ( L.fast && L.speed>3 ) {
                        L.speed -= L.speed/10;
                    } else {
                        if ( L.fast ) {
                            L.startTime = time;
                        }
                        L.fast = false;
                        if ( (time - L.startTime) > L.fasttime ) {
                            L.speed+= L.speed/10;
                            if (L.speed>=100 && L.start) {
                                L.doStop();
                            }
                        }

                    }
                    //console.log(L.speed);


                    L.List.each( function( i ){
                        var ci,_this, width, c_width, d_width, height, c_height, d_height, top, c_top, d_top, left, c_left, d_left, per, d_per;
                        var si = i % (settings.showCount + 2) - L.idex;
                        si = L.getSi(si);
                        //if ( !L.start && !L.end ) return;
                        _this = this;

                        if ( i!=L.idex ) {
                            width = L.pos[si]['width'];
                            c_width = width - L.pos[si-1]['width'];
                            d_width = width;
                            height = L.pos[si]['height'];
                            c_height = height - L.pos[si-1]['height'];
                            d_height = height;
                            top = L.pos[si]['top'];
                            c_top = top - L.pos[si-1]['top'];
                            d_top = top;
                            left = L.pos[si]['leftwidth'];
                            c_left = left - L.pos[si-1]['leftwidth'];
                            d_left = left;
                            per = L.speed;
                            d_per = per;

                            function go( timestamp ) {
                                timestamp = timestamp || Date.now();
                                d_width = d_width - c_width / per;
                                d_height = d_height - c_height / per;
                                d_top = d_top - c_top / per;
                                d_left = d_left - c_left / per;

                                if ( d_left <= (left - c_left/2) ) {
                                    $(_this).css({zIndex: L.pos[si-1]['zIndex']});
                                }

                                $(_this).css({
                                    width: d_width +'px',
                                    height: d_height +'px',
                                    top: d_top +'px',
                                    left: d_left +'px'
                                });

                                if ( d_per>1 ) {
                                    requestSId = window.requestAnimationFrame( go );
                                }else{
                                    if ( !L.start && !L.end ) {
                                        L.doWin();
                                        L.end = true;
                                    }
                                    if ( b ) {
                                        L.changePos(L.idex, L.imgIdex);
                                        L.doLoop();
                                        b = false;
                                    }
                                }
                                d_per--;
                            }

                            if ( L.start || !L.end ) {
                                requestSId = window.requestAnimationFrame( go );
                            }

                        } else {
                            $(_this).hide();
                        }

                    } );
                    //L.doLoop();
                },
                doLoop: function(){
                    L.idex++;
                    L.idex = L.idex % ( settings.showCount + 2 );

                    L.imgIdex++;
                    L.imgIdex = L.imgIdex % ( L.ImgObjArr.length );
                    requestId = window.requestAnimationFrame( L.run );
                },
                getSi: function( si ) {
                    if ( si <0 ) {
                        si = settings.showCount + 2 + si;
                    }else{
                        return si;
                    }
                    return L.getSi( si );
                },
                getEndIdex: function( endIdex ){
                    if ( endIdex <0 ) {
                        endIdex = L.ImgObjArr.length + endIdex;
                    } else {
                        return endIdex;
                    }
                    return L.getEndIdex( endIdex );
                },
                changePos: function(idex, imgIdex){
                    var nextIdex,r;

                    r = L.getRandom();
                    nextIdex = L.imgHideList[r];
                    delete(L.imgHideList[r]);
                    L.imgHideList = L.array_filter(L.imgHideList);

                    L.List.eq(idex).css({
                        left: L.pos[ settings.showCount+1 ]['leftwidth'],
                        top: L.pos[ settings.showCount+1]['top'],
                        zIndex:L.pos[ settings.showCount+1]['zIndex']
                    }).show().find('img').attr('src', L.ImgObjArr[nextIdex]['src']).attr('name',L.ImgObjArr[nextIdex]['name'] ).end();

                    L.imgShowList.push(nextIdex);
                    if ( !L.in_array(L.imgShowList[0], L.endIdexs) ) {
                        L.imgHideList.push(L.imgShowList[0]);
                    }
                    delete(L.imgShowList[0]);
                    L.imgShowList = L.array_filter(L.imgShowList);

                },
                doWin: function() {
                    var endIdex;

                    $('#'+ settings.stopBtn).hide();
                    $('#'+ settings.startBtn).show();
                    $('.zxLotteryBg', L.el).css({zIndex: (L.maxZIndex-1)});
                    endIdex = L.imgShowList[ Math.ceil( settings.showCount / 2 ) + 1];
                    // 显示获奖人名称
                    //console.log('L.idex='+ ( Math.ceil( settings.showCount / 2 ) + 1 + L.idex) %  ( settings.showCount + 2 ) );
                    //L.List.eq( ( Math.ceil( settings.showCount / 2 ) + 1 + L.idex) %  ( settings.showCount + 2 ) ).find('.zxLotteryName').show();
                    L.insertWinnerDom( endIdex );
                    //console.log('恭喜'+ L.ImgObjArr[endIdex]['name'] +'中奖啦！');
                },
                insertWinnerDom: function( endIdex ){
                    var Htm, obj;
                    L.endIdexs.push(endIdex);
                    obj = L.ImgObjArr[endIdex];
                    L.nameDom.text( obj['name']).show();
                    Htm = '<img src="'+ obj['src'] +'" style="width:100%;height:100%;" /><div class="zxWinnerName">'+ obj['name'] +'</div>';


                    $('.zxWinnerItem:not(.win)', L.winel).eq(0).append($(Htm).fadeIn()).addClass('win');
                    settings.winCurCount++;
                    if ( settings.success ) settings.success( obj );

                    if( !L.endCheck() ) return;
                },
                endCheck: function(){
                    if ( settings.winCurCount >= settings.winCount ) {
                        setTimeout( function(){
                            alert('本次抽奖已结束，谢谢您的参与！');
                        }, 1000 );
                        return false;
                    }else {
                        return true;
                    }
                },
                /**
                 * 工具类方法
                 * */
                // 过滤数组中空元素
                array_filter: function( arr ) {
                    var newArr = [];

                    for( var i=0;i<arr.length;i++ ) {
                        if ( arr[i] || arr[i]===0 ) newArr.push( arr[i] );
                    }
                    return newArr;
                },
                // 数组随机排列
                randomSort: function(){
                    return Math.random() - 0.5;
                },
                setShowElements: function( startIdex ){
                    for( var i=0;i<startIdex;i++ ) {
                        L.imgShowList.push(i);
                    }
                    //console.log(L.imgShowList);
                },
                setHideElements: function(startIdex, length){
                    for( var i=startIdex;i<length;i++ ) {
                        L.imgHideList.push(i);
                    }
                },
                // 获取随机数
                getRandom: function(){
                    return Math.floor(Math.random()*(L.imgHideList.length));
                },
                in_array: function( stringToSearch, arrayToSearch ){
                    for (s = 0; s < arrayToSearch.length; s++) {
                        thisEntry = arrayToSearch[s].toString();

                        if (thisEntry == stringToSearch) {
                            return true;
                        }
                    }
                    return false;
                }
            } );

            L.initialize();

        };
    }
} );