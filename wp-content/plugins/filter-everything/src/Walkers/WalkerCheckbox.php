<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}


class WalkerCheckbox extends \Walker
{
    /**
     * What the class handles.
     *
     * @since 2.1.0
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'Checkbox';

    /**
     * Database fields to use.
     *
     * @since 2.1.0
     * @var array
     *
     * @see Walker::$db_fields
     * @todo Decouple this
     */
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
    );

    public $max_depth = 0;

    public $has_not_empty_children = [];

    public $parent_opened_elements = [];

    /**
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children'>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_el()
     *
     * @param string  $output   Used to append additional content (passed by reference).
     * @param WP_Term $term     Term data object.
     * @param int     $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array   $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int     $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $term, $depth = 0, $args = array(), $id = 0 ) {

        $term_name      = esc_attr( $term->name );
        $url_manager    = $args['url_manager'];
        $filter         = $args['filter'];
        $checked        = ( in_array( $term->slug, $filter['values'] ) ) ? 1 : 0;
        $id             = $id ? $id : $term->term_id;
        $toggleButton   = '';
        $visibility_class = '';

        // Don't generate an element if the term name is empty.
        if ( '' === $term_name ) {
            return;
        }

        $atts         = array();
        $atts['href'] = $url_manager->getTermUrl( $term->slug, $filter['e_name'] );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $link =  apply_filters( 'wpc_filters_checkbox_term_html', '<a'.$attributes.'>'.$term->name.'</a>', $attributes, $term, $filter );

        if ( ! empty( $args['show_count'] ) && $args['show_count'] === 'yes' ) {
            $link .= '&nbsp;'. flrt_get_count( $term );
        }

        $output     .= "\t<li";
        $cross_count = isset( $term->cross_count ) ? esc_attr( $term->cross_count ) : '';

        if( in_array( $id, $this->parent_opened_elements ) ){
            $visibility_class = ' wpc-opened';
        }

        if( $this->max_depth > 0) {
            $visibility_class = ' '. flrt_get_status_css_class( $id, FLRT_HIERARCHY_LIST_COOKIE_NAME );
        }

        $css_classes = array(
            0 => 'wpc-checkbox-item',
            1 => 'wpc-term-item',
            3 => 'wpc-term-count-' . $cross_count,
            4 => 'wpc-term-id-'.$id
        );

        if( $checked ){
            $css_classes[2] = 'wpc-term-selected';
        }

        if( $this->has_children ){
            $css_classes[] = 'wpc-has-children';
            $toggleButton = '<i class="wpc-toggle-children-list" data-tid="'.esc_attr($term->term_id).'"></i>';
        }

        if( in_array( $id, $this->has_not_empty_children ) ){
            $css_classes[] = 'wpc-has-not-empty-children';
        }

        $css_classes = implode( ' ', $css_classes );
        $css_classes .= $visibility_class;
        $css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';

        $output .= $css_classes;
        $output .= ' id="'.flrt_term_id('term', $filter, $id, false).'">';
        $output .= '<div class="wpc-term-item-content-wrapper'.esc_attr( $visibility_class ).'"><input '.checked( 1, $checked, false ).' type="checkbox" data-wpc-link="'.esc_url($atts['href']).'"';
        $output .= ' id="'.flrt_term_id('checkbox', $filter, $id, false).'" />'."\n";
        $output .= '<label for="'.flrt_term_id('checkbox', $filter, $id, false).'">';
        $output .= "$link\n";
        $output .= "</label>\n";
        $output .= $toggleButton;
        $output .= "</div>\n";

    }

    /**
     * Ends the element output, if needed.
     *
     * @since 2.1.0
     *
     * @see Walker::end_el()
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param object $page   Not used.
     * @param int    $depth  Optional. Depth of category. Not used.
     * @param array  $args   Optional. An array of arguments. Only uses 'list' for whether should append
     *                       to output. See wp_list_categories(). Default empty array.
     */
    public function end_el( &$output, $page, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }

    public function walk( $elements, $max_depth, ...$args ) {
        $output = '';

        $this->max_depth = $max_depth;

        // Invalid parameter or nothing to walk.
        if ( $max_depth < -1 || empty( $elements ) ) {
            return $output;
        }

        $parent_field = $this->db_fields['parent'];

        // Flat display.
        if ( -1 == $max_depth ) {
            $empty_array = array();
            foreach ( $elements as $e ) {
                $this->display_element( $e, $empty_array, 1, 0, $args, $output );
            }
            return $output;
        }

        /*
         * Need to display in hierarchical order.
         * Separate elements into two buckets: top level and children elements.
         * Children_elements is two dimensional array, eg.
         * Children_elements[10][] contains all sub-elements whose parent is 10.
         */
        $top_level_elements     = array();
        $children_elements      = array();
        $parent_opened_elements = array();

        foreach ( $elements as $e ) {
            if ( empty( $e->$parent_field ) ) {
                $top_level_elements[] = $e;
            } else {
                $children_elements[ $e->$parent_field ][] = $e;
            }

            if( ! empty( $args[0]['filter']['values'] ) ){
                if( in_array( $e->slug, $args[0]['filter']['values'] ) ){
                    $parent_opened_elements[] = $e->$parent_field;
                    flrt_get_all_parents( $elements, $e->$parent_field, $parent_opened_elements );
                }
            }

        }

        $this->parent_opened_elements = array_unique($parent_opened_elements);
        $this->has_not_empty_children = flrt_get_parents_with_not_empty_children($elements);

        /*
         * When none of the elements is top level.
         * Assume the first one must be root of the sub elements.
         */
        if ( empty( $top_level_elements ) ) {

            $first = array_slice( $elements, 0, 1 );
            $root  = $first[0];

            $top_level_elements = array();
            $children_elements  = array();
            foreach ( $elements as $e ) {
                if ( $root->$parent_field == $e->$parent_field ) {
                    $top_level_elements[] = $e;
                } else {
                    $children_elements[ $e->$parent_field ][] = $e;
                }
            }
        }

        foreach ( $top_level_elements as $e ) {
            $this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
        }

        /*
         * If we are displaying all levels, and remaining children_elements is not empty,
         * then we got orphans, which should be displayed regardless.
         */
        if ( ( 0 == $max_depth ) && count( $children_elements ) > 0 ) {
            $empty_array = array();
            foreach ( $children_elements as $orphans ) {
                foreach ( $orphans as $op ) {
                    $this->display_element( $op, $empty_array, 1, 0, $args, $output );
                }
            }
        }

        return $output;
    }
}