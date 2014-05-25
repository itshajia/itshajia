define( function( require, exports, module ){
    var $ = require('jquery');
    require('zxFadeSlider.css');
    require('zxFadeSlider')($);

    // 首页幻灯片
    exports.fadeSlider = function () {
        $('#zxFadeSlider').zxFadeSlider({});
    }

} );