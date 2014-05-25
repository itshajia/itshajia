define( function( require, exports, module ) {

    return function ( jQuery ) {

        (function($) {
            $.uio = {
                post: function( url, data, callback, dataType ) {
                    var promise = $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        dataType: dataType ? dataType : 'json'
                    });

                    promise.always();
                    promise.done( function( dataJson ) {
                        if( callback) callback( dataJson );
                    } );
                    promise.error();

                    return promise;
                },
                getWebUrl: function() {
                    var origin;

                    if( !window.location.origin ) {
                        origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
                    } else {
                        origin = window.location.origin + (window.location.port ? ':' + window.location.port: '');
                    }
                    return origin;
                },
                array_filter: function( arr ) {
                    var newArr = [];

                    for( var i=0;i<arr.length;i++ ) {
                        if ( arr[i] ) newArr.push( arr[i] );
                    }
                    return newArr;
                },
                getUrlParam: function( name ) {
                    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
                    var r = window.location.search.substr(1).match(reg);

                    if (r != null) return decodeURIComponent(r[2]);
                    return null;
                }
            };

        })(jQuery);

    };

} );