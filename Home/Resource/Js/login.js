define(function( require, exports, module ){

    var $ = require('jquery');


    exports.signSwitch = function () {

        $('#signup .js-next').on('click', function() {

            $('#signup').addClass('hidden');
            $('#signin').removeClass('hidden');
        });

        $('#signin .js-next').on('click', function() {

            $('#signin').addClass('hidden');
            $('#signup').removeClass('hidden');
        });

    };

});