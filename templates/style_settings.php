<?php $options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_style_settings' ); ?>
<input name="br_pagination_style_settings[settings_name]" type="hidden" value="br_pagination_style_settings">
<table class="form-table">
    <tr class="berocket_pagination_type_blocks berocket_pagination_type_default berocket_pagination_type_bottom">
        <th><?php _e( 'Position', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <select name="br_pagination_style_settings[pagination_pos]">
                <option value="center"<?php if ( $options['pagination_pos'] == 'center' ) echo ' selected'; ?>><?php _e( 'Center', 'BeRocket_Pagination_domain' ) ?></option>
                <option value="left"<?php if ( $options['pagination_pos'] == 'left' ) echo ' selected'; ?>><?php _e( 'Left', 'BeRocket_Pagination_domain' ) ?></option>
                <option value="right"<?php if ( $options['pagination_pos'] == 'right' ) echo ' selected'; ?>><?php _e( 'Right', 'BeRocket_Pagination_domain' ) ?></option>
            </select>
        </td>
    </tr>
    <tr class="berocket_pagination_type_blocks berocket_pagination_type_default">
        <th><?php _e( 'Position for pagination', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <p><label><input name="br_pagination_style_settings[default_show][after_products]" type="checkbox" value="1"<?php if ( $options['default_show']['after_products'] ) echo ' checked'; ?>><?php _e( 'After products', 'BeRocket_Pagination_domain' ) ?></label></p>
            <p><label><input name="br_pagination_style_settings[default_show][before_products]" type="checkbox" value="1"<?php if ( $options['default_show']['before_products'] ) echo ' checked'; ?>><?php _e( 'Before products', 'BeRocket_Pagination_domain' ) ?></label></p>
        </td>
    </tr>
</table>
<table class="berocket_pagination_style">
    <tr>
        <td colspan="8"><h3><?php _e( 'Pagination style', 'BeRocket_Pagination_domain' ) ?></h3></td>
    </tr>
    <tr>
        <td colspan="8"><h4><?php _e( 'Color', 'BeRocket_Pagination_domain' ) ?></h4></td>
    </tr>
    <tr>
        <th><?php _e( 'Background color', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Border color', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button text color', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button text color on mouse over', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button background color', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button background color on mouse over', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button border color', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button border color on mouse over', 'BeRocket_Pagination_domain' ) ?></th>
    </tr>
    <tr>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_style']['background-color'] ) ? $options['ul_style']['background-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_style']['background-color'] ) ? $options['ul_style']['background-color'] : '' ?>" name="br_pagination_style_settings[ul_style][background-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_style']['border-color'] ) ? $options['ul_style']['border-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_style']['border-color'] ) ? $options['ul_style']['border-color'] : '' ?>" name="br_pagination_style_settings[ul_style][border-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_li_a-span_style']['color'] ) ? $options['ul_li_a-span_style']['color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_li_a-span_style']['color'] ) ? $options['ul_li_a-span_style']['color'] : '' ?>" name="br_pagination_style_settings[ul_li_a-span_style][color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_li_a-span_hover_style']['color'] ) ? $options['ul_li_a-span_hover_style']['color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_li_a-span_hover_style']['color'] ) ? $options['ul_li_a-span_hover_style']['color'] : '' ?>" name="br_pagination_style_settings[ul_li_a-span_hover_style][color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_li_a-span_style']['background-color'] ) ? $options['ul_li_a-span_style']['background-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_li_a-span_style']['background-color'] ) ? $options['ul_li_a-span_style']['background-color'] : '' ?>" name="br_pagination_style_settings[ul_li_a-span_style][background-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_li_a-span_hover_style']['background-color'] ) ? $options['ul_li_a-span_hover_style']['background-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_li_a-span_hover_style']['background-color'] ) ? $options['ul_li_a-span_hover_style']['background-color'] : '' ?>" name="br_pagination_style_settings[ul_li_a-span_hover_style][background-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_li_style']['border-color'] ) ? $options['ul_li_style']['border-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_li_style']['border-color'] ) ? $options['ul_li_style']['border-color'] : '' ?>" name="br_pagination_style_settings[ul_li_style][border-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
        <td>
            <div class="colorpicker_field" data-color="<?php echo ( $options['ul_li_hover_style']['border-color'] ) ? $options['ul_li_hover_style']['border-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( $options['ul_li_hover_style']['border-color'] ) ? $options['ul_li_style']['border-color'] : '' ?>" name="br_pagination_style_settings[ul_li_hover_style][border-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_Pagination_domain') ?>" class="theme_default button">
        </td>
    </tr>
    <tr>
        <td colspan="8"><h4><?php _e( 'Size', 'BeRocket_Pagination_domain' ) ?></h4></td>
    </tr>
    <tr>
        <th><?php _e( 'Border width', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button border width', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Paddings', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button paddings', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Border round', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Button border round', 'BeRocket_Pagination_domain' ) ?></th>
        <th><?php _e( 'Padding between buttons', 'BeRocket_Pagination_domain' ) ?></th>
        <th></th>
    </tr>
    <tr>
        <td>
            <p><?php _e( 'Top', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-top-width]" type="text" value="<?php echo $options['ul_style']['border-top-width']; ?>">
            <p><?php _e( 'Bottom', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-bottom-width]" type="text" value="<?php echo $options['ul_style']['border-bottom-width']; ?>">
            <p><?php _e( 'Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-left-width]" type="text" value="<?php echo $options['ul_style']['border-left-width']; ?>">
            <p><?php _e( 'Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-right-width]" type="text" value="<?php echo $options['ul_style']['border-right-width']; ?>">
        </td>
        <td>
            <p><?php _e( 'Top', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-top-width]" type="text" value="<?php echo $options['ul_li_style']['border-top-width']; ?>">
            <p><?php _e( 'Bottom', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-bottom-width]" type="text" value="<?php echo $options['ul_li_style']['border-bottom-width']; ?>">
            <p><?php _e( 'Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-left-width]" type="text" value="<?php echo $options['ul_li_style']['border-left-width']; ?>">
            <p><?php _e( 'Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-right-width]" type="text" value="<?php echo $options['ul_li_style']['border-right-width']; ?>">
        </td>
        <td>
            <p><?php _e( 'Top', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][padding-top]" type="text" value="<?php echo $options['ul_style']['padding-top']; ?>">
            <p><?php _e( 'Bottom', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][padding-bottom]" type="text" value="<?php echo $options['ul_style']['padding-bottom']; ?>">
            <p><?php _e( 'Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][padding-left]" type="text" value="<?php echo $options['ul_style']['padding-left']; ?>">
            <p><?php _e( 'Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][padding-right]" type="text" value="<?php echo $options['ul_style']['padding-right']; ?>">
        </td>
        <td>
            <p><?php _e( 'Top', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_a-span_style][padding-top]" type="text" value="<?php echo $options['ul_li_a-span_style']['padding-top']; ?>">
            <p><?php _e( 'Bottom', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_a-span_style][padding-bottom]" type="text" value="<?php echo $options['ul_li_a-span_style']['padding-bottom']; ?>">
            <p><?php _e( 'Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_a-span_style][padding-left]" type="text" value="<?php echo $options['ul_li_a-span_style']['padding-left']; ?>">
            <p><?php _e( 'Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_a-span_style][padding-right]" type="text" value="<?php echo $options['ul_li_a-span_style']['padding-right']; ?>">
        </td>
        <td>
            <p><?php _e( 'Top-Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-top-left-radius]" type="text" value="<?php echo $options['ul_style']['border-top-left-radius']; ?>">
            <p><?php _e( 'Top-Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-top-right-radius]" type="text" value="<?php echo $options['ul_style']['border-top-right-radius']; ?>">
            <p><?php _e( 'Bottom-Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-bottom-right-radius]" type="text" value="<?php echo $options['ul_style']['border-bottom-right-radius']; ?>">
            <p><?php _e( 'Bottom-Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_style][border-bottom-left-radius]" type="text" value="<?php echo $options['ul_style']['border-bottom-left-radius']; ?>">
        </td>
        <td>
            <p><?php _e( 'Top-Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-top-left-radius]" type="text" value="<?php echo $options['ul_li_style']['border-top-left-radius']; ?>">
            <p><?php _e( 'Top-Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-top-right-radius]" type="text" value="<?php echo $options['ul_li_style']['border-top-right-radius']; ?>">
            <p><?php _e( 'Bottom-Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-bottom-right-radius]" type="text" value="<?php echo $options['ul_li_style']['border-bottom-right-radius']; ?>">
            <p><?php _e( 'Bottom-Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][border-bottom-left-radius]" type="text" value="<?php echo $options['ul_li_style']['border-bottom-left-radius']; ?>">
        </td>
        <td>
            <p><?php _e( 'Top', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][margin-top]" type="text" value="<?php echo $options['ul_li_style']['margin-top']; ?>">
            <p><?php _e( 'Bottom', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][margin-bottom]" type="text" value="<?php echo $options['ul_li_style']['margin-bottom']; ?>">
            <p><?php _e( 'Left', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][margin-left]" type="text" value="<?php echo $options['ul_li_style']['margin-left']; ?>">
            <p><?php _e( 'Right', 'BeRocket_Pagination_domain' ) ?></p>
            <input name="br_pagination_style_settings[ul_li_style][margin-right]" type="text" value="<?php echo $options['ul_li_style']['margin-right']; ?>">
        </td>
        <td></td>
    </tr>
</table>