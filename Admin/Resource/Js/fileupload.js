define( function( require, exports, module ) {
    var $ = require('jquery');

    require('upload.ui.css');
    require('upload.ui.widget')($);
    require('upload.iframe.transport')($);
    require('upload.fileupload')($);
    require('upload.xdr.transport')($);

    require('tmpl')($);
    require('json')($);
    require('uio')($);

    var Upload = {
        name: '',
        initialize: function() {

            this.init();
        },
        init: function() {

            $('#fileupload').fileupload({
                multipart: true,
                url: $('#uploadDemo').val(),
                done: function (e, data) {

                    var result = data.result;
                    result = $.json.decode( result );

                    Upload.render( result['files'] );
                }
            });

            if ( UploadObj['data']['name'] ) {
                Upload.render( UploadObj['data'] );
                Upload.name = UploadObj['data']['name'];
            }

        },
        render: function ( data ) {
            $('#files').empty().append($('#uploadTmpl').tmpl( data ));

            if ( Upload.name ) {
                Upload.doDelect( Upload.name );
            }

            for( var i=0; i<data.length; i++ ) {
                Upload.name = data[i]['name'];
            }

            Upload.onDelete();
        },
        onDelete: function() {
            $('.delete', $('#files')).unbind('click').bind('click', function() {
                var name = $(this).attr('data-name');
                Upload.doDelect( name );
            });
        },
        doDelect: function ( name ) {
            var url, data, _this;

            _this = this;
            url = $('#uploadDemo').val()+"/file/"+ name +"/_method/DELETE";
            $.uio.post( url, '', function( data ) {
                data = $.json.decode( data );

                if ( data[$(_this).attr('data-name') ] ) {
                    $(_this).parent().parent().remove();
                }
            });
        }
    };


    $(function() {
        Upload.initialize();

    });

});