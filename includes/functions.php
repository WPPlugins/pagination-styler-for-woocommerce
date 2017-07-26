<?php
function berocket_pagination() {
    global $wp_query, $wp_rewrite;
    $options = BeRocket_Pagination::get_pagination_option ( 'br_pagination_general_settings' );

    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $url_parts    = explode( '?', $pagenum_link );

    $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    ?>
    <nav class="woocommerce-pagination berocket_pagination">
    <?php
    if( $total > 1 ) {

    $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

    $args = apply_filters( 'woocommerce_pagination_args', array(
        'base'                  => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format'                => $format, // ?page=%#% : %#% is replaced by the page number
        'total'                 => $total,
        'current'               => $current,
        'show_all'              => false,
        'prev_next'             => true,
        'prev_text'             => '«',
        'next_text'             => '»',
        'dots_prev_text'        => '…',
        'dots_next_text'        => '…',
        'first_page'            => '1',
        'last_page'             => '%LAST%',
        'current_page'          => '%PAGE%',
        'page'                  => '%PAGE%',
        'end_size'              => 2,
        'mid_size'              => 1,
        'type'                  => 'plain',
        'add_args'              => array(), // array of query args to add
        'add_fragment'          => '',
        'before_page_number'    => '',
        'after_page_number'     => ''
    ) );

    if ( ! is_array( $args['add_args'] ) ) {
        $args['add_args'] = array();
    }

    if ( isset( $url_parts[1] ) ) {
        $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
        $format_query = isset( $format[1] ) ? $format[1] : '';
        wp_parse_str( $format_query, $format_args );

        wp_parse_str( $url_parts[1], $url_query_args );

        foreach ( $format_args as $format_arg => $format_arg_value ) {
            unset( $url_query_args[ $format_arg ] );
        }

        $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
    }

    $total = (int) $args['total'];
    if ( $total < 2 ) {
        return;
    }
    $current  = (int) $args['current'];
    $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
    if ( $end_size < 0 ) {
        $end_size = 0;
    }
    $mid_size = (int) $args['mid_size'];
    if ( $mid_size < 0 ) {
        $mid_size = 0;
    }
    $add_args = $args['add_args'];
    $r = '';
    $page_links = array();
    $dots = false;
    $next_dots = false;

    $link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
    $link = str_replace( '%#%', $current - 1, $link );
    if ( $add_args )
        $link = add_query_arg( $add_args, $link );
    $link .= $args['add_fragment'];
    $page_before = '<li class="prev"><a class="prev page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['prev_text'] . '</a></li>';
    $page_before = apply_filters( 'berocket_pagination_previous', $page_before );

    $link = str_replace( '%_%', $args['format'], $args['base'] );
    $link = str_replace( '%#%', $current + 1, $link );
    if ( $add_args )
        $link = add_query_arg( $add_args, $link );
    $link .= $args['add_fragment'];

    $page_after = '<li class="next"><a class="next page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['next_text'] . '</a></li>';
    $page_after = apply_filters( 'berocket_pagination_next', $page_after );

    $dots_prev_text = '<li class="dots"><span class="page-numbers dots">'.$args['dots_prev_text'].'</span></li>';
    $dots_prev_text = apply_filters( 'berocket_pagination_dots_previous', $dots_prev_text );
    $dots_next_text = '<li class="dots"><span class="page-numbers dots">'.$args['dots_next_text'].'</span></li>';
    $dots_next_text = apply_filters( 'berocket_pagination_dots_next', $dots_next_text );

    if( $args['prev_next'] && $current && 1 < $current ) {
        $page_links[] = $page_before;
    }
    $start = true;
    $total_n = number_format_i18n( $total );
    for ( $n = 1; $n <= $total; $n++ ) :
        $current_n = number_format_i18n( $n );
        if ( $n == $current ) :
            $current_n = berocket_replace_data_pagination ( $args['current_page'], $current_n, $total_n );
            $page_links[] = "<li class='current'><span class='page-numbers current'>" . $args['before_page_number'] . $current_n . $args['after_page_number'] . "</span></li>";
            $dots = true;
            $next_dots = true;
        else :
            if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
                if ( $n == $total ) {
                    $current_n = berocket_replace_data_pagination ( $args['last_page'], $current_n, $total_n );
                } else if ( $n == 1 ) {
                    $current_n = berocket_replace_data_pagination ( $args['first_page'], $current_n, $total_n );
                } else {
                    $current_n = berocket_replace_data_pagination ( $args['page'], $current_n, $total_n );
                }
                $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
                $link = str_replace( '%#%', $n, $link );
                if ( $add_args )
                    $link = add_query_arg( $add_args, $link );
                    $link .= $args['add_fragment'];

                    $page_links[] = "<li class='other'><a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . $current_n . $args['after_page_number'] . "</a></li>";
                    $dots = true;
                elseif ( $dots && ! $args['show_all'] ) :
                if ( $options['use_dots'] ) {
                    if ( $next_dots ) {
                        $page_links[] = $dots_next_text;
                    } else {
                        $page_links[] = $dots_prev_text;
                    }
                }
                $dots = false;
                $start = false;
            endif;
        endif;
    endfor;
    if( $args['prev_next'] && $current && ( $current < $total || -1 == $total ) ) {
        $page_links[] = $page_after;
    }
    $r .= "<ul class='page-numbers'>\n\t";
    $r .= join("\n\t", $page_links);
    $r .= "\n</ul>\n";

    do_action( 'berocket_ps_before_pagination' );
    echo $r;
    do_action( 'berocket_ps_after_pagination' );
    }
    ?>
    </nav>
    <?php
}
function berocket_replace_data_pagination ( $text, $page, $lastpage ) {
    $text = str_replace( '%PAGE%', $page, $text );
    $text = str_replace( '%LAST%', $lastpage, $text );
    return $text;
}
if( ! function_exists( 'br_pagination_general_callback' ) ) {
    /**
     * Function for general settings callback
     *
     * @return void
     */
    function br_pagination_general_callback() { 
        include Pagination_TEMPLATE_PATH . "general_settings.php";
    }
}

if( ! function_exists( 'br_pagination_style_callback' ) ) {
    /**
     * Function for style settings callback
     *
     * @return void
     */
    function br_pagination_style_callback() { 
        include Pagination_TEMPLATE_PATH . "style_settings.php";
    }
}

if( ! function_exists( 'br_pagination_text_callback' ) ) {
    /**
     * Function for text settings callback
     *
     * @return void
     */
    function br_pagination_text_callback() { 
        include Pagination_TEMPLATE_PATH . "text_settings.php";
    }
}

if( ! function_exists( 'br_pagination_javascript_callback' ) ) {
    /**
     * Function for javascript settings callback
     *
     * @return void
     */
    function br_pagination_javascript_callback() { 
        include Pagination_TEMPLATE_PATH . "javascript_settings.php";
    }
}

if( ! function_exists( 'br_pagination_license_callback' ) ) {
    /**
     * Function for license settings callback
     *
     * @return void
     */
    function br_pagination_license_callback() { 
        include Pagination_TEMPLATE_PATH . "license_settings.php";
    }
}

if( ! function_exists( 'br_get_woocommerce_version' ) ){
    /**
     * Public function to get WooCommerce version
     *
     * @return float|NULL
     */
    function br_get_woocommerce_version() {
        if ( ! function_exists( 'get_plugins' ) )
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
        $plugin_folder = get_plugins( '/' . 'woocommerce' );
        $plugin_file = 'woocommerce.php';

        if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
            return $plugin_folder[$plugin_file]['Version'];
        } else {
            return NULL;
        }
    }
}
if( ! function_exists( 'br_is_plugin_active' ) ) {
    function br_is_plugin_active( $plugin_name, $version = '1.0.0.0', $version_end = '9.9.9.9' ) { 
        switch ( $plugin_name ) {
            case 'filters':
                if ( defined ( "BeRocket_AJAX_filters_version" ) && 
                BeRocket_AJAX_filters_version >= $version && 
                BeRocket_AJAX_filters_version <= $version_end ) {
                    return true;
                } else {
                    return false;
                }
            case 'list-grid':
                if ( defined ( "BeRocket_List_Grid_version" ) && 
                BeRocket_List_Grid_version >= $version && 
                BeRocket_List_Grid_version <= $version_end ) {
                    return true;
                } else {
                    return false;
                }
            case 'more-products':
                if ( defined ( "BeRocket_Load_More_Products_version" ) && 
                BeRocket_Load_More_Products_version >= $version && 
                BeRocket_Load_More_Products_version <= $version_end ) {
                    return true;
                } else {
                    return false;
                }
        }
    }
}
if ( ! function_exists( 'berocket_font_select_upload' ) ) {
    /**
     * Public function to add to plugin settings buttons to upload or select icons
     *
     * @param string $text - Text above buttons
     * @param string $id - input ID
     * @param string $name - input name
     * @param string $value - current value link or font awesome icon class
     * @param bolean $show_fa - show font awesome button and generate font awesome icon table
     * @param bolean $show_upload - show upload button that allow upload custom icons
     * @param bolean $show_remove - show remove button that allow clear input
     * @param string $data_sc - add data-sc options with this value into input 
     *
     * @return string html code with all needed blocks and buttons
     */
    function berocket_font_select_upload( $text, $id, $name, $value, $show_fa = true, $show_upload = true, $show_remove = true, $data_sc = '' ) {
        if ( $show_fa ) {
            $font_awesome_list = fa_icons_list();
            $font_awesome      = "";
            foreach ( $font_awesome_list as $font ) {
                $font_awesome .= '<label><span data-value="' . $font . '" 
                    class="berocket_aapf_icon_select"></span><i class="fa ' . $font . '"></i></label>';
            }
        }
        $result = '<div>';
        if ( $text && $text != '' ) {
            $result .= '<p>' . $text . '</p>';
        }
        $result .= '<input id="' . @ $id . '" type="text" name="' . @ $name . '" '.( ( $data_sc ) ? 'data-sc="'.$data_sc.'" ' : '' ).'value="' . @ $value . '"
            readonly style="display:none;" class="' . @ $name . ' '.( ( $data_sc ) ? 'berocket_aapf_widget_sc ' : '' ).'berocket_aapf_icon_text_value"/><span class="berocket_aapf_selected_icon_show">
            ' . ( ( @ $value ) ? ( ( substr( $value, 0, 3 ) == 'fa-' ) ? '<i class="fa ' . $value . '"></i>' : '<i class="fa">
            <image src="' . $value . '" alt=""></i>' ) : '' ) . '</span>';
        if ( $show_fa ) {
            $result .= '<input type="button" class="berocket_aapf_font_awesome_icon_select button" value="'.__('Font awesome', 'BeRocket_Pagination_domain').'"/>
            <div style="display: none;" class="berocket_aapf_select_icon"><div><p>Font Awesome Icons<i class="fa fa-times"></i></p>
            ' . $font_awesome . '</div></div>';
        }
        if ( $show_upload ) {
            $result .= '<input type="button" class="berocket_aapf_upload_icon button" value="'.__('Upload', 'BeRocket_Pagination_domain').'"/> ';
        }
        if ( $show_remove ) {
            $result .= '<input type="button" class="berocket_aapf_remove_icon button" value="'.__('Remove', 'BeRocket_Pagination_domain').'"/>';
        }
        $result .= '</div>';

        return $result;
    }
}
if ( ! function_exists( 'fa_icons_list' ) ) {
    function fa_icons_list() {
        return array(
            "fa-glass",
            "fa-music",
            "fa-search",
            "fa-envelope-o",
            "fa-heart",
            "fa-star",
            "fa-star-o",
            "fa-user",
            "fa-film",
            "fa-th-large",
            "fa-th",
            "fa-th-list",
            "fa-check",
            "fa-times",
            "fa-search-plus",
            "fa-search-minus",
            "fa-power-off",
            "fa-signal",
            "fa-cog",
            "fa-trash-o",
            "fa-home",
            "fa-file-o",
            "fa-clock-o",
            "fa-road",
            "fa-download",
            "fa-arrow-circle-o-down",
            "fa-arrow-circle-o-up",
            "fa-inbox",
            "fa-play-circle-o",
            "fa-repeat",
            "fa-refresh",
            "fa-list-alt",
            "fa-lock",
            "fa-flag",
            "fa-headphones",
            "fa-volume-off",
            "fa-volume-down",
            "fa-volume-up",
            "fa-qrcode",
            "fa-barcode",
            "fa-tag",
            "fa-tags",
            "fa-book",
            "fa-bookmark",
            "fa-print",
            "fa-camera",
            "fa-font",
            "fa-bold",
            "fa-italic",
            "fa-text-height",
            "fa-text-width",
            "fa-align-left",
            "fa-align-center",
            "fa-align-right",
            "fa-align-justify",
            "fa-list",
            "fa-outdent",
            "fa-indent",
            "fa-video-camera",
            "fa-picture-o",
            "fa-pencil",
            "fa-map-marker",
            "fa-adjust",
            "fa-tint",
            "fa-pencil-square-o",
            "fa-share-square-o",
            "fa-check-square-o",
            "fa-arrows",
            "fa-step-backward",
            "fa-fast-backward",
            "fa-backward",
            "fa-play",
            "fa-pause",
            "fa-stop",
            "fa-forward",
            "fa-fast-forward",
            "fa-step-forward",
            "fa-eject",
            "fa-chevron-left",
            "fa-chevron-right",
            "fa-plus-circle",
            "fa-minus-circle",
            "fa-times-circle",
            "fa-check-circle",
            "fa-question-circle",
            "fa-info-circle",
            "fa-crosshairs",
            "fa-times-circle-o",
            "fa-check-circle-o",
            "fa-ban",
            "fa-arrow-left",
            "fa-arrow-right",
            "fa-arrow-up",
            "fa-arrow-down",
            "fa-share",
            "fa-expand",
            "fa-compress",
            "fa-plus",
            "fa-minus",
            "fa-asterisk",
            "fa-exclamation-circle",
            "fa-gift",
            "fa-leaf",
            "fa-fire",
            "fa-eye",
            "fa-eye-slash",
            "fa-exclamation-triangle",
            "fa-plane",
            "fa-calendar",
            "fa-random",
            "fa-comment",
            "fa-magnet",
            "fa-chevron-up",
            "fa-chevron-down",
            "fa-retweet",
            "fa-shopping-cart",
            "fa-folder",
            "fa-folder-open",
            "fa-arrows-v",
            "fa-arrows-h",
            "fa-bar-chart",
            "fa-twitter-square",
            "fa-facebook-square",
            "fa-camera-retro",
            "fa-key",
            "fa-cogs",
            "fa-comments",
            "fa-thumbs-o-up",
            "fa-thumbs-o-down",
            "fa-star-half",
            "fa-heart-o",
            "fa-sign-out",
            "fa-linkedin-square",
            "fa-thumb-tack",
            "fa-external-link",
            "fa-sign-in",
            "fa-trophy",
            "fa-github-square",
            "fa-upload",
            "fa-lemon-o",
            "fa-phone",
            "fa-square-o",
            "fa-bookmark-o",
            "fa-phone-square",
            "fa-twitter",
            "fa-facebook",
            "fa-github",
            "fa-unlock",
            "fa-credit-card",
            "fa-rss",
            "fa-hdd-o",
            "fa-bullhorn",
            "fa-bell",
            "fa-certificate",
            "fa-hand-o-right",
            "fa-hand-o-left",
            "fa-hand-o-up",
            "fa-hand-o-down",
            "fa-arrow-circle-left",
            "fa-arrow-circle-right",
            "fa-arrow-circle-up",
            "fa-arrow-circle-down",
            "fa-globe",
            "fa-wrench",
            "fa-tasks",
            "fa-filter",
            "fa-briefcase",
            "fa-arrows-alt",
            "fa-users",
            "fa-link",
            "fa-cloud",
            "fa-flask",
            "fa-scissors",
            "fa-files-o",
            "fa-paperclip",
            "fa-floppy-o",
            "fa-square",
            "fa-bars",
            "fa-list-ul",
            "fa-list-ol",
            "fa-strikethrough",
            "fa-underline",
            "fa-table",
            "fa-magic",
            "fa-truck",
            "fa-pinterest",
            "fa-pinterest-square",
            "fa-google-plus-square",
            "fa-google-plus",
            "fa-money",
            "fa-caret-down",
            "fa-caret-up",
            "fa-caret-left",
            "fa-caret-right",
            "fa-columns",
            "fa-sort",
            "fa-sort-desc",
            "fa-sort-asc",
            "fa-envelope",
            "fa-linkedin",
            "fa-undo",
            "fa-gavel",
            "fa-tachometer",
            "fa-comment-o",
            "fa-comments-o",
            "fa-bolt",
            "fa-sitemap",
            "fa-umbrella",
            "fa-clipboard",
            "fa-lightbulb-o",
            "fa-exchange",
            "fa-cloud-download",
            "fa-cloud-upload",
            "fa-user-md",
            "fa-stethoscope",
            "fa-suitcase",
            "fa-bell-o",
            "fa-coffee",
            "fa-cutlery",
            "fa-file-text-o",
            "fa-building-o",
            "fa-hospital-o",
            "fa-ambulance",
            "fa-medkit",
            "fa-fighter-jet",
            "fa-beer",
            "fa-h-square",
            "fa-plus-square",
            "fa-angle-double-left",
            "fa-angle-double-right",
            "fa-angle-double-up",
            "fa-angle-double-down",
            "fa-angle-left",
            "fa-angle-right",
            "fa-angle-up",
            "fa-angle-down",
            "fa-desktop",
            "fa-laptop",
            "fa-tablet",
            "fa-mobile",
            "fa-circle-o",
            "fa-quote-left",
            "fa-quote-right",
            "fa-spinner",
            "fa-circle",
            "fa-reply",
            "fa-github-alt",
            "fa-folder-o",
            "fa-folder-open-o",
            "fa-smile-o",
            "fa-frown-o",
            "fa-meh-o",
            "fa-gamepad",
            "fa-keyboard-o",
            "fa-flag-o",
            "fa-flag-checkered",
            "fa-terminal",
            "fa-code",
            "fa-reply-all",
            "fa-star-half-o",
            "fa-location-arrow",
            "fa-crop",
            "fa-code-fork",
            "fa-chain-broken",
            "fa-question",
            "fa-info",
            "fa-exclamation",
            "fa-superscript",
            "fa-subscript",
            "fa-eraser",
            "fa-puzzle-piece",
            "fa-microphone",
            "fa-microphone-slash",
            "fa-shield",
            "fa-calendar-o",
            "fa-fire-extinguisher",
            "fa-rocket",
            "fa-maxcdn",
            "fa-chevron-circle-left",
            "fa-chevron-circle-right",
            "fa-chevron-circle-up",
            "fa-chevron-circle-down",
            "fa-html5",
            "fa-css3",
            "fa-anchor",
            "fa-unlock-alt",
            "fa-bullseye",
            "fa-ellipsis-h",
            "fa-ellipsis-v",
            "fa-rss-square",
            "fa-play-circle",
            "fa-ticket",
            "fa-minus-square",
            "fa-minus-square-o",
            "fa-level-up",
            "fa-level-down",
            "fa-check-square",
            "fa-pencil-square",
            "fa-external-link-square",
            "fa-share-square",
            "fa-compass",
            "fa-caret-square-o-down",
            "fa-caret-square-o-up",
            "fa-caret-square-o-right",
            "fa-eur",
            "fa-gbp",
            "fa-usd",
            "fa-inr",
            "fa-jpy",
            "fa-rub",
            "fa-krw",
            "fa-btc",
            "fa-file",
            "fa-file-text",
            "fa-sort-alpha-asc",
            "fa-sort-alpha-desc",
            "fa-sort-amount-asc",
            "fa-sort-amount-desc",
            "fa-sort-numeric-asc",
            "fa-sort-numeric-desc",
            "fa-thumbs-up",
            "fa-thumbs-down",
            "fa-youtube-square",
            "fa-youtube",
            "fa-xing",
            "fa-xing-square",
            "fa-youtube-play",
            "fa-dropbox",
            "fa-stack-overflow",
            "fa-instagram",
            "fa-flickr",
            "fa-adn",
            "fa-bitbucket",
            "fa-bitbucket-square",
            "fa-tumblr",
            "fa-tumblr-square",
            "fa-long-arrow-down",
            "fa-long-arrow-up",
            "fa-long-arrow-left",
            "fa-long-arrow-right",
            "fa-apple",
            "fa-windows",
            "fa-android",
            "fa-linux",
            "fa-dribbble",
            "fa-skype",
            "fa-foursquare",
            "fa-trello",
            "fa-female",
            "fa-male",
            "fa-gittip",
            "fa-sun-o",
            "fa-moon-o",
            "fa-archive",
            "fa-bug",
            "fa-vk",
            "fa-weibo",
            "fa-renren",
            "fa-pagelines",
            "fa-stack-exchange",
            "fa-arrow-circle-o-right",
            "fa-arrow-circle-o-left",
            "fa-caret-square-o-left",
            "fa-dot-circle-o",
            "fa-wheelchair",
            "fa-vimeo-square",
            "fa-try",
            "fa-plus-square-o",
            "fa-space-shuttle",
            "fa-slack",
            "fa-envelope-square",
            "fa-wordpress",
            "fa-openid",
            "fa-university",
            "fa-graduation-cap",
            "fa-yahoo",
            "fa-google",
            "fa-reddit",
            "fa-reddit-square",
            "fa-stumbleupon-circle",
            "fa-stumbleupon",
            "fa-delicious",
            "fa-digg",
            "fa-pied-piper",
            "fa-pied-piper-alt",
            "fa-drupal",
            "fa-joomla",
            "fa-language",
            "fa-fax",
            "fa-building",
            "fa-child",
            "fa-paw",
            "fa-spoon",
            "fa-cube",
            "fa-cubes",
            "fa-behance",
            "fa-behance-square",
            "fa-steam",
            "fa-steam-square",
            "fa-recycle",
            "fa-car",
            "fa-taxi",
            "fa-tree",
            "fa-spotify",
            "fa-deviantart",
            "fa-soundcloud",
            "fa-database",
            "fa-file-pdf-o",
            "fa-file-word-o",
            "fa-file-excel-o",
            "fa-file-powerpoint-o",
            "fa-file-image-o",
            "fa-file-archive-o",
            "fa-file-audio-o",
            "fa-file-video-o",
            "fa-file-code-o",
            "fa-vine",
            "fa-codepen",
            "fa-jsfiddle",
            "fa-life-ring",
            "fa-circle-o-notch",
            "fa-rebel",
            "fa-empire",
            "fa-git-square",
            "fa-git",
            "fa-hacker-news",
            "fa-tencent-weibo",
            "fa-qq",
            "fa-weixin",
            "fa-paper-plane",
            "fa-paper-plane-o",
            "fa-history",
            "fa-circle-thin",
            "fa-header",
            "fa-paragraph",
            "fa-sliders",
            "fa-share-alt",
            "fa-share-alt-square",
            "fa-bomb",
            "fa-futbol-o",
            "fa-tty",
            "fa-binoculars",
            "fa-plug",
            "fa-slideshare",
            "fa-twitch",
            "fa-yelp",
            "fa-newspaper-o",
            "fa-wifi",
            "fa-calculator",
            "fa-paypal",
            "fa-google-wallet",
            "fa-cc-visa",
            "fa-cc-mastercard",
            "fa-cc-discover",
            "fa-cc-amex",
            "fa-cc-paypal",
            "fa-cc-stripe",
            "fa-bell-slash",
            "fa-bell-slash-o",
            "fa-trash",
            "fa-copyright",
            "fa-at",
            "fa-eyedropper",
            "fa-paint-brush",
            "fa-birthday-cake",
            "fa-area-chart",
            "fa-pie-chart",
            "fa-line-chart",
            "fa-lastfm",
            "fa-lastfm-square",
            "fa-toggle-off",
            "fa-toggle-on",
            "fa-bicycle",
            "fa-bus",
            "fa-ioxhost",
            "fa-angellist",
            "fa-cc",
            "fa-ils",
            "fa-meanpath",
        );
    }
}
?>