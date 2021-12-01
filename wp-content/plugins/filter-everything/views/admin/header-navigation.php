<?php

    if ( ! defined('WPINC') ) {
        wp_die();
    }

    global $submenu, $parent_file, $submenu_file, $plugin_page, $pagenow;

    // Vars.
    $parent_slug = 'edit.php?post_type=' . FLRT_FILTERS_SET_POST_TYPE;

    // Generate array of navigation items.
    $tabs = array();
    if( isset($submenu[ $parent_slug ]) ) {
        foreach( $submenu[ $parent_slug ] as $i => $sub_item ) {

            // Check user can access page.
            if ( !current_user_can( $sub_item[1] ) ) {
                continue;
            }

            // Ignore "Add New".
            if( $i === 1 ) {
                continue;
            }

            // Define tab.
            $tab = array(
                'text'	=> $sub_item[0],
                'url' => $sub_item[2]
            );

            // Convert submenu slug "test" to "$parent_slug&page=test".
            if( !strpos($sub_item[2], '.php') ) {
                $tab['url'] = add_query_arg( array( 'page' => $sub_item[2] ), $parent_slug );
            }

            // Detect active state.
            if( $submenu_file === $sub_item[2] || $plugin_page === $sub_item[2] ) {
                $tab['is_active'] = true;
            }

            // Special case for "Add New" page.
            if( $i === 0 && $submenu_file === 'post-new.php?post_type=' . FLRT_FILTERS_SET_POST_TYPE ) {
                $tab['is_active'] = true;
            }
            $tabs[] = $tab;
        }
    }

    $tabs = apply_filters( 'wpc_header_nav_tabs', $tabs );

    // Bail early if set to false.
    if( $tabs === false ) {
        return;
    }
?>
<div class="wpc-admin-toolbar">
    <h2><img src="<?php echo esc_attr( flrt_get_icon_svg('#333333') ); ?>" alt="" width="20" /> <?php echo esc_html( flrt_get_plugin_name() ); ?></h2>
    <?php foreach( $tabs as $tab ) {
        $is_active = !empty( $tab['is_active'] ) ? ' is-active' : '';

        printf(
            '<a class="wpc-tab%s" href="%s">%s</a>', $is_active, esc_url( $tab['url'] ), esc_html( $tab['text'] )
        );
    } ?>

    <div class="wpc-admin-right">
        <?php do_action('wpc_admin_toolbar_right'); ?>
    </div>
</div>