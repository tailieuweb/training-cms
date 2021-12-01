<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class FiltersWidget extends \WP_Widget
{
    public $show_instance_in_rest = false;

    public function __construct() {
        parent::__construct(
            'wpc_filters_widget', // Base ID
            esc_html__( 'Filter Everything &mdash; Filters', 'filter-everything'),
            array(
                    'description' => esc_html__( 'Filters Widget', 'filter-everything' ),
                    'show_instance_in_rest' => false,
                )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $show_selected_class = ( !empty( $instance['chips'] ) ) ? ' wpc-show-on-desktop' : '';
        $show_count          = ( !empty( $instance['show_count'] ) ) ? $instance['show_count'] : '';
        $set_id              = isset( $instance['id'] ) ? preg_replace('/[^\d]?/', '', $instance['id'] ) : 0;
        $popup_title         = esc_html__('Filters', 'filter-everything');
        if( ! empty( $title ) ){
            $popup_title = $title;
        }

        // Display nothing if preview mode
        if( isset( $_GET['legacy-widget-preview'] ) || isset( $_GET['_locale'] ) ){
            return;
        }

        if( isset( $_POST['action'] ) && $_POST['action'] === 'elementor_ajax' ){
            echo '<strong>'.esc_html__( 'Filter Everything &mdash; Filters', 'filter-everything' ).'</strong>';
            return;
        }

        if( isset( $_GET['action'] ) && $_GET['action'] === 'elementor' ){
            echo '<strong>'.esc_html__( 'Filter Everything &mdash; Filters', 'filter-everything' ).'</strong>';
            return;
        }

        /**
         * @feature Add ability to choose what filter Set to display in widget settings
        */
        $debug_mode = flrt_is_debug_mode();
        $container  = Container::instance();
        $wpManager  = $container->getWpManager();

        if( ! $wpManager->getQueryVar( 'allowed_filter_page' ) ){
            if( $debug_mode ){

                if( defined('FLRT_FILTERS_PRO') ){
                    echo '<p class="wpc-debug-message">';
                    echo sprintf(
                            wp_kses(
                                __( 'No one Filter Set is related with this page. You can configure it in the <a href="%s">Filter Set</a> location field.', 'filter-everything' ),
                                    array( 'a' => array('href' => true) )
                            ),
                            admin_url( 'edit.php?post_type=filter-set' )
                    );
                    echo '</p>';
                }else{
                    if( is_singular() ){
                        echo '<p class="wpc-debug-message">';
                        echo sprintf(
                            wp_kses(
                                __( 'The free version of the plugin does not support filtering on singular pages. But <a href="%s">PRO version</a> supports.', 'filter-everything' ),
                                array( 'a' => array('href' => true) )
                            ),
                            esc_url(FLRT_PLUGIN_LINK .'/?get_pro=true')
                        );
                        echo '</p>';
                    }else{
                        echo '<p class="wpc-debug-message">';
                        echo sprintf(
                            wp_kses(
                                __( 'No one Filter Set is configured for this post type pages. You can create a new <a href="%s">Filter Set</a> for them.', 'filter-everything' ),
                                array( 'a' => array('href' => true) )
                            ),
                            admin_url( 'edit.php?post_type=filter-set' )
                        );
                        echo '</p>';
                    }
                }

                flrt_debug_title();
            }
            return false;
        }

        $templateManager    = $container->getTemplateManager();
        $em                 = $container->getEntityManager();
        $fss                = $container->getFilterSetService();
        $urlManager         = new UrlManager();

        $has_not_empty_children = [];
        $theSet                 = flrt_the_set( $set_id );

        if( ! $theSet ){
            return false;
        }

        $setId                  = $theSet['ID'];
        $posType                = $theSet['filtered_post_type'];
        $set                    = $fss->getSet( $theSet['ID'] );
        $chipsObj               = new Chips(true, array($setId) );
        $chips                  = $chipsObj->getChips();

        $set_edit_url           = ( isset( $theSet['ID'] )) ? admin_url('post.php?post='.$theSet['ID'].'&action=edit') : admin_url( 'edit.php?post_type=filter-set' );

        $related_filters        = $em->getSetsRelatedFilters( array( $theSet ) );
        $found_posts            = flrt_posts_found_quantity( $setId, true );
        $actionUrl              = $urlManager->getFormActionUrl(true);

        if( empty( $related_filters ) ){
            if( $debug_mode ){

                echo '<p class="wpc-debug-message">';
                echo sprintf(
                    wp_kses(
                        __( 'There are no filters in the Filter Set yet. Please add them to the <a href="%s">Filter Set</a> related to this page.', 'filter-everything' ),
                        array( 'a' => array('href' => true) )
                    ),
                    $set_edit_url
                );
                echo '</p>';

                flrt_debug_title();
            }
            return false;
        }

        echo $before_widget;
        echo '<div class="wpc-filters-widget-main-wrapper wpc-filter-set-'.esc_attr( $setId ).'" data-set="'.esc_attr( $setId ).'">'."\n";
        // Open/Closed status class
        $widgetContentClass = flrt_filters_widget_content_class($setId);
        if( flrt_get_experimental_option('disable_buttons') !== 'on' ) {
            flrt_filters_button($setId, $widgetContentClass);
        }

        echo flrt_spinner_html();

            echo '<div class="wpc-filters-widget-content'.esc_attr($widgetContentClass).'">';
                    echo '<div class="wpc-widget-close-container">
                            <a class="wpc-widget-close-icon">
                                <span class="wpc-icon-html-wrapper">
                                <span class="wpc-icon-line-1"></span><span class="wpc-icon-line-2"></span><span class="wpc-icon-line-3"></span>
                                </span>
                            </a>';

                    echo '<span class="wpc-widget-popup-title">'.$popup_title.'</span>';
                echo '</div>';
                echo '<div class="wpc-filters-widget-containers-wrapper">'."\r\n";
                echo '<div class="wpc-filters-widget-top-container">';
                    echo '<div class="wpc-widget-top-inside">';

                        // Add selected terms for mobile widget
                        echo '<div class="wpc-inner-widget-chips-wrapper'.esc_attr($show_selected_class).'">';
                        $templateManager->includeFrontView( 'chips', array( 'chips' => $chips, 'setid' => $setId ) );
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                if ( ! empty( $title ) ) {
                    echo '<div class="wpc-filter-set-widget-title">'."\n";
                    echo $before_title . $title . $after_title;
                    echo '</div>'."\n";
                }

                echo '<div class="wpc-filters-scroll-container">';

                    echo '<div class="wpc-filters-widget-wrapper">'."\r\n";

                            if( $show_count ){
                                flrt_posts_found( $setId );
                            }

                            foreach ( $related_filters as $filter ){

                                $entityObj  = $em->getEntityByFilter( $filter, $posType );
                                $entityObj->setExcludedTerms( $filter['exclude'] );

                                $terms = $entityObj->getTerms();
                                $terms = apply_filters( 'wpc_items_after_calc_term_count', $terms );

                                if( $filter['hierarchy'] === 'yes' ){
                                    $hierarchy_key = 'cross_count';
                                    if( $set['hide_empty']['value'] === 'initial' ){
                                        $hierarchy_key = 'count';
                                    }
                                   $has_not_empty_children = flrt_get_parents_with_not_empty_children( $terms, $hierarchy_key );
                                }

                                // Create a list with excluded empty terms
                                if( ( $set['hide_empty']['value'] === 'yes' ) || ( $set['hide_empty']['value'] === 'initial' ) || ( isset( $set['hide_empty_filter'] ) && $set['hide_empty_filter']['value'] === 'yes' ) ){
                                    $allWpQueriedPostIds = $em->getAllSetWpQueriedPostIds( $setId );
                                    $checkTerms = $terms;

                                    if( $set['hide_empty']['value'] === 'initial' ){
                                        foreach ($checkTerms as $index => $term) {
                                            if( $filter['hierarchy'] === 'yes' ){

                                                if(  empty( array_intersect( $allWpQueriedPostIds, $term->posts ) )
                                                    && ! in_array( $term->term_id, $has_not_empty_children ) ){
                                                    unset($checkTerms[$index]);
                                                }

                                            }else{
                                                if( empty( array_intersect( $allWpQueriedPostIds, $term->posts ) )  ){
                                                    unset($checkTerms[$index]);
                                                }
                                            }
                                        }
                                    }else{
                                        foreach ($checkTerms as $index => $term) {
                                            if( $filter['hierarchy'] === 'yes' ){

                                                if(  $term->cross_count === 0
                                                    && ! in_array( $term->term_id, $has_not_empty_children ) ){
                                                    unset($checkTerms[$index]);
                                                }

                                            }else{
                                                if( $term->cross_count === 0 ){
                                                    unset($checkTerms[$index]);
                                                }
                                            }
                                        }
                                    }

                                }

                                // Remove empty terms, if such option is enabled
                                if( ( $set['hide_empty']['value'] === 'yes' || $set['hide_empty']['value'] === 'initial' ) && ($filter['entity'] !== 'post_meta_num') ) {
                                    $terms = $checkTerms;
                                }

                                // Hide entire Filter if there are no posts in its terms
                                if( isset( $set['hide_empty_filter'] )
                                    &&
                                    $set['hide_empty_filter']['value'] === 'yes' ){

                                        if( $filter['entity'] === 'post_meta_num' ){
                                            // Temporary not ideal solution
                                            if( $terms[0]->max === NULL && $terms[1]->min === NULL ){
                                                // Huh, finally
                                                continue;
                                            }
                                        }else{
                                            if( empty( $checkTerms ) ){
                                                // Huh, finally
                                                continue;
                                            }
                                        }
                                }

                                $terms = flrt_extract_objects_vars( $terms, array(
                                    'term_id',
                                    'slug',
                                    'name',
                                    'count',
                                    'cross_count',
                                    'max',
                                    'min',
                                    'absMax',
                                    'absMin',
                                    'parent')
                                );

                                // Hook terms before display to allow developers modify them.
                                $terms = apply_filters( 'wpc_terms_before_display', $terms, $filter, $set, $urlManager );

                                $templateManager->includeFrontView(
                                        apply_filters( 'wpc_view_include_filename', $filter['view'], $filter, $set ),
                                        array(
                                            'filter'        => $filter,
                                            'terms'         => $terms,
                                            'set'           => $set,
                                            'url_manager'   => $urlManager
                                        )
                                );
                            }

                        echo '</div>'."\r\n";

                    echo '</div>' . "\r\n";

                echo '<div class="wpc-filters-widget-controls-container">
                    <div class="wpc-filters-widget-controls-wrapper">
                        <div class="wpc-filters-widget-controls-item wpc-filters-widget-controls-one">
                            <a class="wpc-filters-apply-button wpc-posts-loaded" href="'.esc_url($actionUrl).'">' . wp_kses( sprintf( __('Show %s', 'filter-everything'), '<span class="wpc-filters-found-posts-wrapper">(<span class="wpc-filters-found-posts">'.esc_html($found_posts).'</span>)</span>'),
                                array( 'span' => array('class'=>true) )
                            ). '</a>
                        </div>
                        <div class="wpc-filters-widget-controls-item wpc-filters-widget-controls-two">
                            <a class="wpc-filters-close-button" href="'.esc_url($actionUrl).'">' . esc_html__('Cancel', 'filter-everything') . '</a>
                        </div>
                    </div>
                </div>';

                if( current_user_can( 'manage_options' ) ){
                    echo '<div class="wpc-edit-filter-set">';
                    echo sprintf(
                        wp_kses(
                            __( '<a href="%s">Edit</a> Filter Set', 'filter-everything' ),
                            array( 'a' => array('href' => true) )
                        ),
                        $set_edit_url
                    );
                    echo '</div>';
                }

                echo '</div>' . "\r\n";
            echo '</div>' . "\r\n"; // end .wpc-filters-widget-content

            // Show button, that opens bottom filters container
            $wpc_mobile_width = flrt_get_mobile_width();
            echo '<style type="text/css">
@media screen and (max-width: '.$wpc_mobile_width.'px) {
    .wpc_show_bottom_widget .wpc-filters-widget-controls-container,
    .wpc_show_bottom_widget .wpc-filters-widget-top-container,
    .wpc_show_open_close_button .wpc-filters-open-button-container,
    .wpc_show_bottom_widget .wpc-filters-open-button-container{
            display: block;
    }
}
</style>'."\r\n";
            echo '</div>'."\n"; // <!-- wpc-filters-widget-main-wrapper -->
            echo $after_widget;
    }

    public function form( $instance ) {

        $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
        $chips = isset( $instance['chips'] ) ? (bool) $instance['chips'] : false;
        $show_count = isset( $instance['show_count'] ) ? (bool) $instance['show_count'] : true;

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'chips' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'chips' ) ); ?>"<?php checked( $chips ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'chips' ) ); ?>"><?php esc_html_e( 'Show selected terms (Chips)', 'filter-everything' ); ?></label>
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_count' ) ); ?>"<?php checked( $show_count ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_count' ) ); ?>"><?php esc_html_e( 'Show number of posts found', 'filter-everything' ); ?></label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title']      = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['chips']      = ( !empty( $new_instance['chips'] ) ) ? 1 : 0;
        $instance['show_count'] = ( !empty( $new_instance['show_count'] ) ) ? 1 : 0;

        return $instance;
    }
}