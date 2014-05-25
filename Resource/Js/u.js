define(function( require, exports, module ){
    var $ = require('jquery');

    require('scrollbar.css');
    require('mousewheel')($);
    require('scrollbar')($);

    $('.slide_bar').mCustomScrollbar();

    var Nav = {
        initialize: function() {
            this.setData();
            this.navLiEvent();
            this.menuBarEvent();
            this.fresh();
        },
        setData: function() {
            this.el = $('#nav');
            this.iframe = $('#display_frame');
            this.navas = $('a', this.el);
            this.menu_bars = $('.menu_bar ');
            this.menu_bars_as = $('.menu_bar a');
        },
        navLiEvent: function() {
            var rel, menu_bar, firstA;

            this.navas.on('click', function() {

                if( !$(this).hasClass('active') ) {

                    Nav.navas.removeClass('active');
                    $(this).addClass('active');

                    rel = $(this).attr('rel');
                    Nav.menu_bars.addClass('hidden');

                    menu_bar = $('#'+ rel);
                    menu_bar.removeClass('hidden');

                    Nav.menu_bars_as.removeClass('active');
                    firstA = $('a', menu_bar).eq(0);
                    firstA.addClass('active');
                    Nav.iframe.attr('src', firstA.attr('href'));
                }
            });
        },
        menuBarEvent: function() {
            var target,tar,dd;

            this.menu_bars.on('click', function(e){

                tar = e.target;
                if(tar.tagName == 'DT') {
                    dd = $(e.target).next('dd');

                    if( dd.css('display')== 'none') {
                        $(tar).find('i').removeClass('arrow_r').addClass('arrow_b');
                    }else{
                        $(tar).find('i').removeClass('arrow_b').addClass('arrow_r');
                    }

                    $(e.target).next('dd').slideToggle();
                }

                if(tar.tagName == 'A') {
                    Nav.menu_bars_as.removeClass('active');
                    $(tar).addClass('active');
                }
            });
        },
        fresh: function(){
            var fresh;

            fresh = $('#fresh');
            fresh.on('click', function(){
                document.getElementById("display_frame").contentDocument.location.reload(true);
            });
        }
    };

    (function(){
        $('#appClose').on('click', function(){
            $('#display_frame').attr('src', $(this).attr('linkurl'));
        });
    })();

    $(function(){
        Nav.initialize();
    });
});