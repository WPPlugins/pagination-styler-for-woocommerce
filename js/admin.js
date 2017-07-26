(function ($){
    $(document).ready( function () {
        $('.berocket_pagination_style .colorpicker_field').each(function (i,o){
            $(o).css('backgroundColor', '#'+$(o).data('color'));
            $(o).colpick({
                layout: 'hex',
                submit: 0,
                color: '#'+$(o).data('color'),
                onChange: function(hsb,hex,rgb,el,bySetColor) {
                    $(el).css('backgroundColor', '#'+hex).next().val(hex);
                }
            })
        });
        $(document).on('click', '.berocket_pagination_style .theme_default', function (event) {
            event.preventDefault();
            var data = '';
            $(this).prev().prev().css('backgroundColor', '#' + data).colpickSetColor('#' + data);
            $(this).prev().val(data);
        });
        function block_changer( input_class ) {
            if ( $( '.'+input_class ).is('[type=checkbox]') ) {
                $( '.'+input_class ).change( function () {
                    if ( $(this).prop('checked') ) {
                        $( '.'+input_class+'_1').show();
                        $( '.'+input_class+'_0').hide();
                    } else {
                        $( '.'+input_class+'_0').show();
                        $( '.'+input_class+'_1').hide();
                    }
                });
                if ( $( '.'+input_class ).prop('checked') ) {
                    $( '.'+input_class+'_1' ).show();
                    $( '.'+input_class+'_0' ).hide();
                } else {
                    $( '.'+input_class+'_0' ).show();
                    $( '.'+input_class+'_1' ).hide();
                }
            } else if ( $( '.'+input_class ).is('select') ) {
                $( '.'+input_class ).change( function () {
                    var val = $(this).val();
                    $( '.'+input_class+'_blocks' ).hide();
                    $( '.'+input_class+'_'+val ).show();
                });
                var val = $( '.'+input_class ).val();
                $( '.'+input_class+'_blocks' ).hide();
                $( '.'+input_class+'_'+val ).show();
            }
        }
        block_changer( 'berocket_use_dots_text' );
        block_changer( 'berocket_use_next_prev_text' );
        $(document).on('change', '.br_use_spec_styles', function() {
            if( $(this).prop('checked') ) {
                $('.berocket_pagi_styles_'+$(this).data('id')).show();
            } else {
                $('.berocket_pagi_styles_'+$(this).data('id')).hide();
            }
        });
    });
})(jQuery);