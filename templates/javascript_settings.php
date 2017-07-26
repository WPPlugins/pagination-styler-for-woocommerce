<?php $options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_javascript_settings' ); ?>
<input name="br_pagination_javascript_settings[settings_name]" type="hidden" value="br_pagination_javascript_settings">
<table class="form-table">
    <tr>
        <th><?php _e( 'On page load', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <textarea name="br_pagination_javascript_settings[page_load]"><?php echo $options['page_load']; ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Custom CSS', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <textarea name="br_pagination_javascript_settings[custom_css]"><?php echo $options['custom_css']; ?></textarea>
        </td>
    </tr>
</table>