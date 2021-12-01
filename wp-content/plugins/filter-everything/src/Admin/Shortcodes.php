<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class Shortcodes
{
    function __construct(){
        add_shortcode( 'fe_open_widget', '__return_false' );
        add_shortcode( 'fe_open_button', '__return_false' );
        add_shortcode( 'fe_chips', [$this, 'chipsShortcode'] );
        add_shortcode( 'fe_sort', [$this, 'sortingShortcode'] );
        add_shortcode( 'fe_widget', [$this, 'widgetFilterEverything'] );
    }

    public function chipsShortcode( $atts )
    {
        ob_start();

        $showReset  = true;
        $setIds     = [];
        $classes    = [];

        if( isset( $atts['reset'] ) && $atts['reset'] === 'no' ){
            $showReset = false;
        }

        if( isset( $atts['mobile'] ) && $atts['mobile'] ){
            $classes[] = 'wpc-show-on-mobile';
        }

        if( isset( $atts['id'] ) ){
            $atts['id'] = preg_replace('/[^\d\,]?/', '', $atts['id']);
            $setIds = explode( ",", $atts['id'] );
        }

        flrt_show_selected_terms($showReset, $setIds, $classes);

        $html = ob_get_clean();

        return $html;
    }

    public function widgetFilterEverything( $atts )
    {
        ob_start();

        $arguments = [];

        $arguments['title'] = isset( $atts['title'] ) ? $atts['title'] : '';

        if( isset( $atts['id'] ) ){
            $arguments['id'] = preg_replace('/[^\d]?/', '', $atts['id'] );
        }

        if( isset( $atts['show_chips'] ) || isset( $atts['show_selected'] ) ){
            $arguments['chips'] = 1;
        }

        if( isset( $atts['show_count'] ) ){
            $arguments['show_count'] = 1;
        }

        the_widget('\FilterEverything\Filter\FiltersWidget', $arguments );

        $html = ob_get_clean();
        return $html;
    }

    public function sortingShortcode( $atts )
    {
        ob_start();
        $debug_mode   = flrt_is_debug_mode();
        $all_widgets  = get_option( 'widget_wpc_sorting_widget' );
        $possible_ids = [];
        $arguments    = [];
        $widget_id    = 0;

        if( isset( $atts['id'] ) ){
            $widget_id = preg_replace('/[^\d]?/', '', $atts['id'] );
        }else{

            if( is_array( $all_widgets ) && $debug_mode ){
                foreach ( $all_widgets as $id => $widget_args ){
                    if( ! isset( $widget_args['title'] ) ){
                        continue;
                    }

                    $possible_ids[ $id ] = $widget_args['title'] ? $widget_args['title'] : esc_html__( 'No title','filter-everything' );
                }

                if( ! empty( $possible_ids ) ){
                    $first_id = key( $possible_ids );
                    echo '<p class="wpc-debug-message">';
                    echo esc_html__('Please, specify desired Sorting widget by adding id parameter to the shortcode.', 'filter-everything');
                    echo '<br />';

                    foreach ( $possible_ids as $id => $title ){
                        echo sprintf( esc_html__('Use «%d» as id for widget with title «%s»','filter-everything' ), $id, $title );
                        echo '<br />';
                    }

                    echo '</p>';
                }else{
                    esc_html_e('There are no Sorting widget yet. Create it please first.','filter-everything' );
                }

                flrt_debug_title();

            }
        }

        if( isset( $all_widgets[$widget_id] ) ){
            $arguments = $all_widgets[$widget_id];
            the_widget('\FilterEverything\Filter\SortingWidget', $arguments );
        }else{
            esc_html_e('Wrong Sorting widget id. Please, specify correct.','filter-everything' );
        }

        $html = ob_get_clean();

        return $html;
    }

}