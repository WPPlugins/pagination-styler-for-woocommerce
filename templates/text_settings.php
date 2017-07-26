<?php $options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_text_settings' ); ?>
<input name="br_pagination_text_settings[settings_name]" type="hidden" value="br_pagination_text_settings">
<table class="form-table">
    <tr>
        <th><?php _e( 'Text for dots', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <div>
                <h4><?php _e( 'Previous', 'BeRocket_Pagination_domain' ) ?></h4>
                <input name="br_pagination_text_settings[dots_prev_text]" type="text" value="<?php echo $options['dots_prev_text']; ?>">
            </div>
            <div>
                <h4><?php _e( 'Next', 'BeRocket_Pagination_domain' ) ?></h4>
                <input name="br_pagination_text_settings[dots_next_text]" type="text" value="<?php echo $options['dots_next_text']; ?>">
            </div>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Text for previous and next buttons', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <div>
                <h4><?php _e( 'Previous', 'BeRocket_Pagination_domain' ) ?></h4>
                <input name="br_pagination_text_settings[prev_text]" type="text" value="<?php echo $options['prev_text']; ?>">
            </div>
            <div>
                <h4><?php _e( 'Next', 'BeRocket_Pagination_domain' ) ?></h4>
                <input name="br_pagination_text_settings[next_text]" type="text" value="<?php echo $options['next_text']; ?>">
            </div>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Text for current page', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_text_settings[current_page]" type="text" value="<?php echo $options['current_page']; ?>">
            <p><?php _e( '%PAGE% - Page number', 'BeRocket_Pagination_domain' ) ?></p>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Text for page', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_text_settings[page]" type="text" value="<?php echo $options['page']; ?>">
            <p><?php _e( '%PAGE% - Page number', 'BeRocket_Pagination_domain' ) ?></p>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Text for first page', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_text_settings[first_page]" type="text" value="<?php echo $options['first_page']; ?>">
            <p><?php _e( '%LAST% - Last page number', 'BeRocket_Pagination_domain' ) ?></p>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Text for last page', 'BeRocket_Pagination_domain' ) ?></th>
        <td>
            <input name="br_pagination_text_settings[last_page]" type="text" value="<?php echo $options['last_page']; ?>">
            <p><?php _e( '%LAST% - Last page number', 'BeRocket_Pagination_domain' ) ?></p>
        </td>
    </tr>
</table>