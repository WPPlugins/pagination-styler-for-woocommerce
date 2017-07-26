<div class="wrap">
<?php 
$dplugin_name = 'WooCommerce Pagination Styler';
$dplugin_link = 'http://berocket.com/product/woocommerce-pagination-styler';
$dplugin_price = 14;
$dplugin_desc = '';
@ include 'settings_head.php';
@ include 'discount.php';
?>
<div class="wrap show_premium">  
    <div id="icon-themes" class="icon32"></div>  
    <h2>Pagination Styler Settings</h2>  
    <?php settings_errors(); ?>  

    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? @ $_GET[ 'tab' ] : 'general'; ?>  

    <h2 class="nav-tab-wrapper">  
        <a href="?page=br-pagination&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'BeRocket_Pagination_domain') ?></a>
        <a href="?page=br-pagination&tab=style" class="nav-tab <?php echo $active_tab == 'style' ? 'nav-tab-active' : ''; ?>"><?php _e('Style', 'BeRocket_Pagination_domain') ?></a>
        <a href="?page=br-pagination&tab=text" class="nav-tab <?php echo $active_tab == 'text' ? 'nav-tab-active' : ''; ?>"><?php _e('Text', 'BeRocket_Pagination_domain') ?></a>
        <a href="?page=br-pagination&tab=javascript" class="nav-tab <?php echo $active_tab == 'javascript' ? 'nav-tab-active' : ''; ?>"><?php _e('JavaScript / CSS', 'BeRocket_Pagination_domain') ?></a>
    </h2>  

    <form class="pagination_submit_form" method="post" action="options.php">  
        <?php 
        if( $active_tab == 'general' ) { 
            settings_fields( 'br_pagination_general_settings' );
            do_settings_sections( 'br_pagination_general_settings' );
        } else if( $active_tab == 'style' ) {
            settings_fields( 'br_pagination_style_settings' );
            do_settings_sections( 'br_pagination_style_settings' ); 
        } else if( $active_tab == 'text' ) {
            settings_fields( 'br_pagination_text_settings' );
            do_settings_sections( 'br_pagination_text_settings' ); 
        } else if( $active_tab == 'javascript' ) {
            settings_fields( 'br_pagination_javascript_settings' );
            do_settings_sections( 'br_pagination_javascript_settings' ); 
        }
        ?>             
        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'BeRocket_Pagination_domain') ?>" />
    </form> 
</div>
<?php
$feature_list = array(
    'Custom Position for next and previous buttons',
    'Fixed position for Pagination',
    'Pagination vertical orientation',
    'Separate Customization for each button types: next, previous, dots, current and other',
    'Custom Font-Awesome icon in Text for Pagination',
);
@ include 'settings_footer.php';
?>
</div>
