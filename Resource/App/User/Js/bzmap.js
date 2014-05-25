define( function( require, exports, module ){

    var $ = require('jquery');
    require('uio')($);

    exports.init = function( pointstr) {
        var city, address, pointarr;
        if ( pointstr ) {
            pointarr = pointstr.split(',');
        }

        city = $.uio.getUrlParam('city');
        address = $.uio.getUrlParam('address');
        if ( city ) $('#city').val( city );
        if ( address ) $('#address').val( address );

        // 百度地图API功能
        var map = new BMap.Map("allmap");            // 创建Map实例
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上，并调整地图视野
        if ( address ) {
            myGeo.getPoint(address, function(point){
                if (point) {
                    map.centerAndZoom(point, 15);   //设置查询地点中心点
                }else{
                    map.centerAndZoom(city,15);
                }
            }, city);
        } else {
            var point;

            if ( pointarr && pointarr[0] && pointarr[1] ) {
                point = new BMap.Point(pointarr[0], pointarr[1]);
                addMarker(point);
                map.centerAndZoom(point, 15);
            } else {
                point = new BMap.Point(116.404, 39.915);    // 创建点坐标
                map.centerAndZoom(point,15);                     // 初始化地图,设置中心点坐标和地图级别。
                map.enableScrollWheelZoom()
            }

        }


        getMapInfo();

        // 获取地图列表
        function getMapInfo() {
            var url,data;

            url = $.uio.getWebUrl() +"/ajax.php?m=Bzmap&a=getMap";
            $.uio.post( url, data, function( dataJson ) {
                if ( dataJson && dataJson.mapList ){
                    initMap( dataJson.mapList );
                }
            });
        }

        // 地图初始化
        function initMap(mapList) {
            var len,market,point,tt = [];

            if(mapList){
                len = mapList.length
                for(var i=0;i<len;i++) {
                    tt = mapList[i]['bzpoint'].split(",");
                    point = new BMap.Point(tt[0],tt[1]);
                    addMarker(point);
                    map.centerAndZoom(point, 15);
                }
            }else{
                map.centerAndZoom("北京", 15);
            }

            map.addEventListener("click", showInfo); //点击标注
            map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
            map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
            map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}));  //右上角，仅包含平移和缩放按钮

        }

        function showInfo(e){
            if (confirm('您是想在这标注地图？（确定/取消）')){
                bzpoint=document.getElementById('bzpoint').value;
                bzpointvalue=e.point.lng + "," + e.point.lat;
                document.getElementById('bzpoint').value=bzpointvalue;

                var point = new BMap.Point(e.point.lng,e.point.lat);
                map.centerAndZoom(point, 15);		   //设置中心点
                marker = new BMap.Marker(point);  // 创建标注
                map.addOverlay(marker);              // 将标注添加到地图中
                marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            }

        }

        function addMarker(point){
            var marker = new BMap.Marker(point);
            map.addOverlay(marker);
            marker.setAnimation(BMAP_ANIMATION_BOUNCE);
        }


    }

})