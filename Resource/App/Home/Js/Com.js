define( function( require, exports, module ){
    var $ = require('jquery');

    // 分享
    exports.share = function() {
        var box = $('#shareBox');

        box.on('click', function(){
            $(this).addClass('hidden');
        });

        $('#share').on('click', function(){
            box.removeClass('hidden');
        });
    };
} );