<?php $options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_general_settings' ); ?>
<input name="br_pagination_general_settings[settings_name]" type="hidden" value="br_pagination_general_settings">
<table class="form-table">
    <tr>
        <th><?php _e( 'Enable previous and next buttons on pagination', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_general_settings[use_next_prev]" type='checkbox' value="1"<?php if ( $options['use_next_prev'] ) echo ' checked'; ?>/>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'First and last button count in pagination', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_general_settings[page_end_size]" type='number' min="0" value="<?php echo $options['page_end_size']; ?>"/>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Button count around current page', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_general_settings[page_mid_size]" type='number' min="0" value="<?php echo $options['page_mid_size']; ?>"/>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Enable pagination dots', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_general_settings[use_dots]" type='checkbox' value="1"<?php if ( $options['use_dots'] ) echo ' checked'; ?>/>
        </td>
    </tr>
</table>