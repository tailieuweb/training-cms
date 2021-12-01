<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

use \FilterEverything\Filter\Container;
use \FilterEverything\Filter\FilterSet;
use \FilterEverything\Filter\FilterFields;
use \FilterEverything\Filter\PostMetaNumEntity;

function flrt_the_set( $set_id = 0 ){
    global $flrt_sets;

    if( $set_id ){
        foreach ( $flrt_sets as $k => $set ){
            if( $set['ID'] === $set_id ){
                unset( $flrt_sets[$k] );
                return $set;
            }
        }
    }

    return array_shift( $flrt_sets );
}

function flrt_print_filters_for( $hook = '' ) {
    global $wp_filter;
    if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
        return;
    return $wp_filter[$hook];
}

function flrt_is_filter_request()
{
    $wpManager = Container::instance()->getWpManager();
    return $wpManager->getQueryVar('wpc_is_filter_request');
}

function flrt_include($filename )
{
    $path = flrt_get_path( $filename );

    if( file_exists($path) ) {
        include_once( $path );
    }
}

function flrt_get_path($path = '' )
{
    return FLRT_PLUGIN_DIR . ltrim($path, '/');
}

function flrt_ucfirst($text )
{
    if( ! is_string( $text ) ){
        return $text;
    }
    return mb_strtoupper( mb_substr( $text, 0, 1 ) ) . mb_substr( $text, 1 );
}

function flrt_sanitize_tooltip($var )
{
    return htmlspecialchars(
        wp_kses(
            html_entity_decode( $var ),
            array(
                'br'     => array(),
                'em'     => array(),
                'strong' => array(),
                'small'  => array(),
                'span'   => array(),
                'ul'     => array(),
                'li'     => array(),
                'ol'     => array(),
                'p'      => array(),
                'a'      => array('href'=>true)
            )
        )
    );
}

function flrt_help_tip($tip, $allow_html = false )
{
    if ( $allow_html ) {
        $tip = flrt_sanitize_tooltip( $tip );
    } else {
        $tip = esc_attr( $tip );
    }

    return '<span class="wpc-help-tip" data-tip="' . $tip . '"></span>';
}

function flrt_tooltip($attr )
{
    if( ! isset( $attr['tooltip'] ) || ! $attr['tooltip'] ){
        return false;
    }

    return flrt_help_tip($attr['tooltip'], true);
}

function flrt_field_instructions($attr)
{
    if( ! isset( $attr['instructions'] ) || ! $attr['instructions'] ){
        return false;
    }
    $instructions = wp_kses(
        $attr['instructions'],
        array(
            'br' => array(),
            'span' => array('class'=>true),
            'strong' => array(),
            'a' => array('href'=>true, 'title'=>true)
        )
    );
    return '<p class="wpc-field-description">'.$instructions.'</p>';
}

function flrt_add_query_arg(...$args ) {
    if ( is_array( $args[0] ) ) {
        if ( count( $args ) < 2 || false === $args[1] ) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            $uri = $args[1];
        }
    } else {
        if ( count( $args ) < 3 || false === $args[2] ) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            $uri = $args[2];
        }
    }

    $frag = strstr( $uri, '#' );
    if ( $frag ) {
        $uri = substr( $uri, 0, -strlen( $frag ) );
    } else {
        $frag = '';
    }

    if ( 0 === stripos( $uri, 'http://' ) ) {
        $protocol = 'http://';
        $uri      = substr( $uri, 7 );
    } elseif ( 0 === stripos( $uri, 'https://' ) ) {
        $protocol = 'https://';
        $uri      = substr( $uri, 8 );
    } else {
        $protocol = '';
    }

    if ( strpos( $uri, '?' ) !== false ) {
        list( $base, $query ) = explode( '?', $uri, 2 );
        $base                .= '?';
    } elseif ( $protocol || strpos( $uri, '=' ) === false ) {
        $base  = $uri . '?';
        $query = '';
    } else {
        $base  = '';
        $query = $uri;
    }

    wp_parse_str( $query, $qs );

    if ( is_array( $args[0] ) ) {
        foreach ( $args[0] as $k => $v ) {
            $qs[ $k ] = $v;
        }
    } else {
        $qs[ $args[0] ] = $args[1];
    }

    foreach ( $qs as $k => $v ) {
        if ( false === $v ) {
            unset( $qs[ $k ] );
        }
    }

    $ret = build_query( $qs );
    $ret = trim( $ret, '?' );
    $ret = preg_replace( '#=(&|$)#', '$1', $ret );
    $ret = $protocol . $base . $ret . $frag;
    $ret = rtrim( $ret, '?' );
    return $ret;
}

/**
 * @param $terms array
 * @param $keys array
 *
 * @return array Array of objects with required keys
 */
function flrt_extract_objects_vars($terms, $keys = [] )
{
    $required = [];

    foreach( $terms as $i => $term ){
        $new_object = new \stdClass();

        foreach( $keys as $key ){
            if( isset( $term->$key ) ){
                $new_object->$key = $term->$key;
                $required[$term->term_id] = $new_object;
            }
        }

    }

    return $required;
}


function flrt_remove_level_array($array )
{
    /**
     * @feature maybe rewrite this full of shame code
     */
    if( ! is_array( $array ) ){
        return [];
    }

    $flatten = [];

    array_map( function ($a) use(&$flatten){
        if( is_array( $a ) ){
            $flatten = array_merge($flatten, $a);
        }
    },
        $array );

    return $flatten;
}

function flrt_get_forbidden_prefixes()
{
    //@todo it seems all existing tax prefixes should be there
    // All them actual only when permalinks off
    $forbidden_prefixes = [];
    $permalinksEnabled = defined('FLRT_PERMALINKS_ENABLED') ? FLRT_PERMALINKS_ENABLED : false;
    if( ! $permalinksEnabled ) {
        $forbidden_prefixes = array_merge( $forbidden_prefixes, array('cat', 'tag', 'page', 'author') );
    }

    if( flrt_wpml_active() ){
        $wpml_url_format = apply_filters( 'wpml_setting', 0, 'language_negotiation_type' );
        if( $wpml_url_format === '3' ){
            $forbidden_prefixes[] = 'lang';
        }
    }

    return apply_filters( 'wpc_forbidden_prefixes', $forbidden_prefixes );
}

function flrt_get_forbidden_meta_keys()
{
    $forbidden_meta_keys = array('wpc_filter_set_post_type', 'wpc_seo_rule_post_type');
    return apply_filters( 'wpc_forbidden_meta_keys', $forbidden_meta_keys );
}

function flrt_array_contains_duplicate($array )
{
    return count($array) != count( array_unique($array) );
}

function flrt_maybe_hide_row($atts )
{
    if( $atts['type'] === 'Hidden' ){
        echo ' style="display:none;"';
    }
}

function flrt_include_admin_view($path, $args = [] )
{
    $templateManager = Container::instance()->getTemplateManager();
    $templateManager->includeAdminView( $path, $args );
}

function flrt_include_front_view($path, $args = [] )
{
    $templateManager = Container::instance()->getTemplateManager();
    $templateManager->includeFrontView( $path, $args );
}

function flrt_create_filters_nonce()
{
    return FilterSet::createNonce();
}

function flrt_get_filter_fields_mapping()
{
    return Container::instance()->getFilterFieldsService()->getFieldsMapping();
}

function flrt_get_configured_filters($post_id )
{
    $filterFields   = Container::instance()->getFilterFieldsService();
    return $filterFields->getFiltersInputs( $post_id );
}

function flrt_get_filter_view_name($view_key )
{
    $view_options = FilterFields::getViewOptions();
    if( isset( $view_options[ $view_key ] ) ){
        return esc_html($view_options[ $view_key ]);
    }

    return esc_html($view_key);
}

function flrt_get_filter_entity_name($entity_key )
{
    $em = Container::instance()->getEntityManager();
    $entities = $em->getPossibleEntities();

    foreach( $entities as $key => $entity_array ){
        if( isset( $entity_array['entities'][ $entity_key ] ) ){
            return esc_html($entity_array['entities'][ $entity_key ]);
        }
    }

    if( $entity_key === 'post_meta_exists' && ! defined('FLRT_FILTERS_PRO') ){
        return esc_html__('Available in PRO', 'filter-everything');
    }

    return esc_html($entity_key);
}

function flrt_get_set_settings_fields($post_id)
{
    $filterSet = Container::instance()->getFilterSetService();
    return $filterSet->getSettingsTypeFields( $post_id );
}

function flrt_render_input($atts )
{
    $className = isset( $atts['type'] ) ? '\FilterEverything\Filter\\' . $atts['type'] : '\FilterEverything\Filter\Text';

    if( class_exists( $className ) ){
        $input = new $className( $atts );
        return $input->render();
    }

    return false;
}

function flrt_extract_vars(&$array, $keys )
{
    $r = [];
    foreach( $keys as $key ) {
        $var = flrt_extract_var( $array, $key );
        if( $var ){
            $r[ $key ] = $var;
        }
    }
    return $r;
}

function flrt_extract_var(&$array, $key, $default = null )
{
    // check if exists
    // - uses array_key_exists to extract NULL values (isset will fail)
    if( is_array($array) && array_key_exists($key, $array) ) {
        $v = $array[ $key ];
        unset( $array[ $key ] );
        return $v;
    }
    return $default;
}

function flrt_get_empty_filter()
{
    $filterFields = Container::instance()->getFilterFieldsService();
    return $filterFields->getEmptyFilterObject();
}

function flrt_excluded_taxonomies()
{
    $excluded_taxonomies = array(
        'nav_menu',
        'link_category',
        'post_format',
        'template_category',
        'element_category',
        'fusion_tb_category',
        'slide-page',
        'elementor_font_type'
    );

    return apply_filters( 'wpc_excluded_taxonomies', $excluded_taxonomies );
}

function flrt_force_non_unique_slug($notNull, $originalSlug )
{
    return $originalSlug;
}

function flrt_redirect_to_error($post_id, $errors )
{
    $redirect = get_edit_post_link( $post_id, 'url' );
    $error_code = 20; // Default error code

    if( !empty( $errors ) && is_array( $errors ) ){
        $error_code = reset( $errors );
    }

    $redirect = add_query_arg( 'message', $error_code, $redirect );
    wp_redirect( $redirect );
    exit;
}

function flrt_sanitize_int($var )
{
    return preg_replace('/[^\d]+/', '', $var );
}

function flrt_range_input_name($meta_key, $edge = 'min' )
{
    return PostMetaNumEntity::inputName( $meta_key, $edge );
}

function flrt_query_string_form_fields($values = null, $exclude = [], $current_key = '', $return = false ) {

    $filter_everything_exclude = array_keys( apply_filters( 'wpc_unnecessary_get_parameters', [] ) );
    $exclude = array_merge( $exclude, $filter_everything_exclude );

    if ( is_null( $values ) ) {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $values = Container::instance()->getTheGet();
        // For compatibility with some Nginx configurations
        unset($values['q']);
    } elseif ( is_string( $values ) ) {
        $url_parts = wp_parse_url( $values );
        $values    = [];

        if ( ! empty( $url_parts['query'] ) ) {
            // This is to preserve full-stops, pluses and spaces in the query string when ran through parse_str.
            $replace_chars = array(
                '.' => '{dot}',
                '+' => '{plus}',
            );

            $query_string = str_replace( array_keys( $replace_chars ), array_values( $replace_chars ), $url_parts['query'] );

            // Parse the string.
            parse_str( $query_string, $parsed_query_string );

            // Convert the full-stops, pluses and spaces back and add to values array.
            foreach ( $parsed_query_string as $key => $value ) {
                $new_key            = str_replace( array_values( $replace_chars ), array_keys( $replace_chars ), $key );
                $new_value          = str_replace( array_values( $replace_chars ), array_keys( $replace_chars ), $value );
                $values[ $new_key ] = $new_value;
            }
        }
    }
    $html = '';

    foreach ( $values as $key => $value ) {
        if ( in_array( $key, $exclude, true ) ) {
            continue;
        }
        if ( $current_key ) {
            $key = $current_key . '[' . $key . ']';
        }
        if ( is_array( $value ) ) {
            $html .= flrt_query_string_form_fields( $value, $exclude, $key, true );
        } else {
            $html .= '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( wp_unslash( $value ) ) . '" />';
        }
    }

    if ( $return ) {
        return $html;
    }

    echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

function flrt_get_query_string_parameters()
{
    $container  = Container::instance();
    $get        = $container->getTheGet();
    $post       = $container->getThePost();

    // For compatibility with some Nginx configurations
    unset($get['q']);

    if( isset( $post['flrt_ajax_link'] ) ){
        $parts = parse_url( $post['flrt_ajax_link'] );
        if( isset( $parts['query'] ) ){
            parse_str( $parts['query'], $output );
            return $output;
        }
    }

    return $get;
}

function flrt_count($term, $show = 'yes' )
{
    if( $show === 'yes' ) :
        echo flrt_get_count( $term );
    endif;
}

/**
 * @since 1.0.5
 * @param $term
 * @return string
 */
function flrt_get_count($term ){
    return '<span class="wpc-term-count">(<span class="wpc-term-count-value">'.esc_html( $term->cross_count ).'</span>)</span>';
}

function flrt_spinner_html()
{
    return '<div class="wpc-spinner"></div>';
}

function flrt_filters_widget_content_class( $setId )
{
    if ( isset( $_COOKIE[ FLRT_OPEN_CLOSE_BUTTON_COOKIE_NAME ] ) ) {

        if ( $_COOKIE[ FLRT_OPEN_CLOSE_BUTTON_COOKIE_NAME ] === $setId ) {
            return ' wpc-opened';
        }else{
            return ' wpc-closed';
        }
    }
}

function flrt_filters_button( $setId = 0, $class = '' )
{
    /**
     * @feature add nice wrapper to this functions to allow users put it into themes.
     */
    $classes         = [];
    $wpManager       = \FilterEverything\Filter\Container::instance()->getWpManager();
    $templateManager = \FilterEverything\Filter\Container::instance()->getTemplateManager();

    if( ! $wpManager->getQueryVar( 'allowed_filter_page' ) ){
        return false;
    }

    $sets = $wpManager->getQueryVar('wpc_page_related_set_ids');

    if( ! $setId && isset( $sets[0]['ID'] ) ){
        $setId = $sets[0]['ID'];
    }

    foreach ( $sets as $set ){
        if( $set['ID'] === $setId ){
            $theSet = $set;
            break;
        }
    }

    if( flrt_get_option('show_bottom_widget') === 'on' ){
        $classes[] = 'wpc-filters-open-widget';
    }else{
        $classes[] = 'wpc-open-close-filters-button';
    }

    if( $class ){
        $classes[] = trim($class);
    }

    $attrClass = implode(" ", $classes);
    $setId = preg_replace('/[^\d]+/', '', $setId);

    $wpc_found_posts = NULL;

    if( $wpManager->getQueryVar('wpc_is_filter_request' ) ){
        $wpc_found_posts = flrt_posts_found_quantity( $setId );
    }

    $templateManager->includeFrontView( 'filters-button', array( 'wpc_found_posts' => $wpc_found_posts, 'class' => $attrClass, 'set_id' => $setId ) );
}

function flrt_posts_found( $setid = 0 )
{
    $templateManager = \FilterEverything\Filter\Container::instance()->getTemplateManager();
    $fss             = \FilterEverything\Filter\Container::instance()->getFilterSetService();
    $count           = flrt_posts_found_quantity( $setid );

    $theSet          = $fss->getSet( $setid );
    $postType        = isset( $theSet['post_type']['value'] ) ? $theSet['post_type']['value'] : '';

    $obj             = get_post_type_object($postType);
    $pluralLabel     = isset( $obj->label ) ? apply_filters( 'wpc_label_singular_posts_found_msg', $obj->label ) : esc_html__('items', 'filter-everything');
    $singularLabel   = isset( $obj->labels->singular_name ) ? apply_filters( 'wpc_label_plural_posts_found_msg', $obj->labels->singular_name ) : esc_html__('item', 'filter-everything');

    $templateManager->includeFrontView( 'posts-found', array( 'posts_found_count' => $count, 'singular_label' => $singularLabel, 'plural_label' => $pluralLabel) );
}

function flrt_get_option( $key, $default = false )
{
    $settings = get_option('wpc_filter_settings');

    if( isset( $settings[$key] ) ){
        return apply_filters( 'wpc_get_option', $settings[$key], $key);
    }

    if( $default ){
        return $default;
    }

    return false;

}

function flrt_remove_option($key )
{
    $settings = get_option('wpc_filter_settings');

    if (isset($settings[$key]) && $settings[$key]) {
        unset($settings[$key]);
        return update_option('wpc_filter_settings', $settings);
    }

    return false;
}

function flrt_get_experimental_option($key, $default = false )
{
    /**
     * @todo This should be rewritten
     */
    $settings = get_option('wpc_filter_experimental');

    if( isset( $settings[$key] ) ){
        return apply_filters( 'wpc_get_option', $settings[$key], $key);
    }

    if( $default ){
        return apply_filters( 'wpc_get_option', $default, $key);
    }

    return apply_filters( 'wpc_get_option', false, $key);

}

function flrt_get_saved_visibility_class($filter, $cookieName )
{
    if( $filter['collapse'] !== 'yes' ){
        return false;
    }

    return flrt_get_status_css_class( $filter['ID'], $cookieName );
}

function flrt_get_status_css_class($id, $cookieName ){

    if ( isset( $_COOKIE[ $cookieName ] ) ) {
        $openediDs = explode(",", $_COOKIE[ $cookieName ] );
        if ( in_array( $id, $openediDs) ) {
            return 'wpc-opened';
        }else{
            return 'wpc-closed';
        }
    }

    return '';
}

function flrt_collapsible_class($filter )
{
    /**
     * Idea is that if user open filter we add cookie with filter ID.
     * Then, if we see current filter ID in cookie IDs list, we make this filter open
     */

    if( $filter['collapse'] !== 'yes' ){
        return false;
    }

    $collapsibleClass = ' wpc-filter-collapsible';

    if( $remembered = flrt_get_saved_visibility_class($filter, FLRT_STATUS_COOKIE_NAME) ){
        $collapsibleClass .= ' '.$remembered;
    }

    return $collapsibleClass;
}

function flrt_filter_header($filter, $terms )
{
    $openButton     = ($filter['collapse'] === 'yes') ? '<button><span class="wpc-wrap-icons">' : '';
    $closeButton    = ($filter['collapse'] === 'yes') ? '</span><span class="wpc-open-icon"></span></button>' : '';
    $tooltip        = '';

    if ($filter['collapse'] === 'yes' && !empty($filter['values']) && !empty($terms)) {
        $selected = [];
        $list = '<div class="wpc-filter-selected-values">&mdash; ';

        foreach ( $terms as $id => $term_object ) {
            if ( in_array( $term_object->slug, $filter['values'] ) ) {
                $selected[] = $term_object->name;
            }
        }

        $list .= implode(", ", $selected) . '</div>';

        $closeButton = $list . $closeButton;
    }

    if( isset( $filter['tooltip'] ) && $filter['tooltip'] ){
        $tooltip = flrt_help_tip( $filter['tooltip'], true );
    }

    ?>
    <div class="wpc-filter-header<?php echo esc_attr( flrt_collapsible_class( $filter ) ); ?>">
        <div class="widget-title wpc-filter-title">
            <?php echo $openButton . esc_html( $filter['label'] ) . $tooltip . $closeButton;  ?>
        </div>
    </div>
    <?php
}

function flrt_filter_class($filter, $default_classes = [] )
{
    $classes = array(
        'wpc-filters-section',
        'wpc-filters-section-'.esc_attr($filter['ID']),
        'wpc-filter-'.esc_attr($filter['e_name']),
        'wpc-filter-'.esc_attr($filter['entity']),
        'wpc-filter-layout-'.esc_attr($filter['view'])
    );

    if( isset( $filter['values'] ) && ! empty( $filter['values'] ) ){
        $classes[] = 'wpc-filter-has-selected';
    }

    if( ! empty( $default_classes ) ){
        $classes = array_merge( $classes, $default_classes );
    }

    return implode( " ", $classes );
}

function flrt_filter_content_class($filter, $default_classes = [] )
{
    $classes = array(
        'wpc-filter-content'
    );

    if( $remembered = flrt_get_saved_visibility_class($filter, FLRT_STATUS_COOKIE_NAME) ){
        $classes[] = $remembered;
    }

    if( isset( $filter['e_name'] ) ){
        $classes[] = 'wpc-filter-'.$filter['e_name'];
    }

    if( isset( $filter['hierarchy'] ) && $filter['hierarchy'] === 'yes' ){
        $classes[] = 'wpc-filter-has-hierarchy';
    }

    if( ! empty( $default_classes ) ){
        $classes = array_merge( $classes, $default_classes );
    }

    return implode( " ", $classes );

}

function flrt_get_contrast_color($hexColor)
{
    // hexColor RGB
    $R1 = hexdec(substr($hexColor, 1, 2));
    $G1 = hexdec(substr($hexColor, 3, 2));
    $B1 = hexdec(substr($hexColor, 5, 2));

    // Black RGB
    $blackColor = "#000000";
    $R2BlackColor = hexdec(substr($blackColor, 1, 2));
    $G2BlackColor = hexdec(substr($blackColor, 3, 2));
    $B2BlackColor = hexdec(substr($blackColor, 5, 2));

    // Calc contrast ratio
    $L1 = 0.2126 * pow($R1 / 255, 2.2) +
        0.7152 * pow($G1 / 255, 2.2) +
        0.0722 * pow($B1 / 255, 2.2);

    $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
        0.7152 * pow($G2BlackColor / 255, 2.2) +
        0.0722 * pow($B2BlackColor / 255, 2.2);

    $contrastRatio = 0;
    if ($L1 > $L2) {
        $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
    } else {
        $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
    }

    // If contrast is more than 5, return black color

    if ($contrastRatio > 10) {
        return '#333333';
    } else {
        // if not, return white color.
        return '#f5f5f5';
    }
}

function flrt_default_posts_container()
{
    return  apply_filters( 'wpc_theme_posts_container', '#primary' );
}

function flrt_default_theme_color()
{
    return  apply_filters( 'wpc_theme_color', '#0570e2' );
}

function flrt_term_id($name, $filter, $id, $echo = true )
{
    $attr = esc_attr( "wpc-" . $name . "-" . $filter['entity'] . "-" . esc_attr( $filter['e_name'] ) . "-" . $id );
    if( $echo ){
        echo $attr;
    } else {
        return $attr;
    }
}

function flrt_get_icon_svg($color = '#ffffff' )
{
    $svg = '<svg enable-background="new 0 0 26 26" id="Layer_1" version="1.1" viewBox="0 0 26 26" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M1.75,7.75h6.6803589c0.3355713,1.2952271,1.5039063,2.2587891,2.9026489,2.2587891   S13.9000854,9.0452271,14.2356567,7.75H24.25C24.6640625,7.75,25,7.4140625,25,7s-0.3359375-0.75-0.75-0.75H14.2356567   c-0.3355713-1.2952271-1.5039063-2.2587891-2.9026489-2.2587891S8.7659302,4.9547729,8.4303589,6.25H1.75   C1.3359375,6.25,1,6.5859375,1,7S1.3359375,7.75,1.75,7.75z M11.3330078,5.4912109   c0.8320313,0,1.5087891,0.6767578,1.5087891,1.5087891s-0.6767578,1.5087891-1.5087891,1.5087891S9.8242188,7.8320313,9.8242188,7   S10.5009766,5.4912109,11.3330078,5.4912109z" fill="'.$color.'"/><path d="M24.25,12.25h-1.6061401c-0.3355713-1.2952271-1.5039063-2.2587891-2.9026489-2.2587891   S17.1741333,10.9547729,16.838562,12.25H1.75C1.3359375,12.25,1,12.5859375,1,13s0.3359375,0.75,0.75,0.75h15.088562   c0.3355713,1.2952271,1.5039063,2.2587891,2.9026489,2.2587891s2.5670776-0.963562,2.9026489-2.2587891H24.25   c0.4140625,0,0.75-0.3359375,0.75-0.75S24.6640625,12.25,24.25,12.25z M19.7412109,14.5087891   c-0.8320313,0-1.5087891-0.6767578-1.5087891-1.5087891s0.6767578-1.5087891,1.5087891-1.5087891S21.25,12.1679688,21.25,13   S20.5732422,14.5087891,19.7412109,14.5087891z" fill="'.$color.'"/><path d="M24.25,18.25H9.7181396c-0.3355103-1.2952271-1.5037842-2.2587891-2.9017334-2.2587891   c-1.3987427,0-2.5670776,0.963562-2.9026489,2.2587891H1.75C1.3359375,18.25,1,18.5859375,1,19s0.3359375,0.75,0.75,0.75h2.1637573   c0.3355713,1.2952271,1.5039063,2.2587891,2.9026489,2.2587891c1.3979492,0,2.5662231-0.963562,2.9017334-2.2587891H24.25   c0.4140625,0,0.75-0.3359375,0.75-0.75S24.6640625,18.25,24.25,18.25z M6.8164063,20.5087891   c-0.8320313,0-1.5087891-0.6767578-1.5087891-1.5087891s0.6767578-1.5087891,1.5087891-1.5087891   c0.8310547,0,1.5078125,0.6767578,1.5078125,1.5087891S7.6474609,20.5087891,6.8164063,20.5087891z" fill="'.$color.'"/></g></svg>';

    return 'data:image/svg+xml;base64,' . base64_encode( $svg );

}

function flrt_get_icon_html()
{
    ?>
    <span class="wpc-icon-html-wrapper">
    <span class="wpc-icon-line-1"></span>
    <span class="wpc-icon-line-2"></span>
    <span class="wpc-icon-line-3"></span>
</span>
    <?php
}

function flrt_get_plugin_name()
{
    if( defined('FLRT_FILTERS_PRO')){
        return esc_html__( 'Filter Everything Pro', 'filter-everything' );
    }else{
        return esc_html__( 'Filter Everything', 'filter-everything' );
    }
}

function flrt_get_plugin_url($type = 'about', $full = false )
{
    if( $full ){
        return esc_url($full);
    }

    return esc_url(FLRT_PLUGIN_LINK . '/' . $type );
}

function flrt_get_term_by_slug($prefix ){
    global $wpdb;

    $sql    = "SELECT {$wpdb->terms}.slug FROM {$wpdb->terms} WHERE {$wpdb->terms}.slug = '%s'";
    $sql    = $wpdb->prepare( $sql, $prefix );
    $result = $wpdb->get_row( $sql );

    if( isset($result->slug) && $result->slug ){
        return $result->slug;
    }

    return false;
}

function flrt_walk_terms_tree($terms, $args ){
    $walker = new \FilterEverything\Filter\WalkerCheckbox();

    $depth = -1;
    if( isset( $args['filter']['hierarchy'] ) && $args['filter']['hierarchy'] === 'yes' ){
        $depth = 10;
    }

    return $walker->walk( $terms, $depth, $args );
}

function flrt_get_all_parents($elements, $parent_id, &$ids ){
    if( isset( $elements[$parent_id]->parent ) && $elements[$parent_id]->parent > 0 ){
        $id = $elements[$parent_id]->parent;

        if( ! in_array( $id, $ids, true ) ){
            $ids[] = $id;
        }

        flrt_get_all_parents( $elements, $id, $ids );
    }else{
        return $ids;
    }
}

function flrt_get_parents_with_not_empty_children($elements, $key = 'cross_count' ){
    $has_posts_in_children = [];

    if( empty( $elements ) || ! is_array( $elements ) ){
        return $has_posts_in_children;
    }

    $new_elements = [];

    foreach ( $elements as $k => $e ) {
        $new_elements[$e->term_id] = $e;
    }

    foreach ( $new_elements as $e ) {
        if ( isset( $e->parent ) && ! empty( $e->parent ) && $e->$key > 0 ) {
            // Find all parents for term that contains posts
            if( ! in_array( $e->parent, $has_posts_in_children, true ) ){
                $has_posts_in_children[] = $e->parent;
            }

            flrt_get_all_parents( $new_elements, $e->parent, $has_posts_in_children );
        }
    }

    return $has_posts_in_children;
}

function flrt_get_sets_with_the_same_query( $all_sets, $set_id ){
    $queryRelatedSets = [];
    // First detect desired query index;
    $query = '';
    $post_type = '';
    foreach( $all_sets as $set ){
        if( $set['ID'] === $set_id ){
            $query = $set['query'];
            $post_type = $set['filtered_post_type'];
            break;
        }
    }

    // Then find all sets with such query
    foreach( $all_sets as $set ){
        if( $set['query'] === $query && $post_type === $set['filtered_post_type'] ){
            $queryRelatedSets[] = $set['ID'];
        }
    }

    return $queryRelatedSets;
}

function flrt_find_all_descendants($arr) {
    $all_results = [];

    if( empty( $arr ) || ! is_array( $arr ) ){
        return $all_results;
    }

    foreach ($arr as $k => $v) {
        $curr_result = [];

        for ($stack = [$k]; count($stack);) {
            $el = array_pop($stack);

            if (array_key_exists($el, $arr) && is_array($arr[$el])) {
                foreach ($arr[$el] as $child) {
                    $curr_result []= $child;
                    $stack []= $child;
                }
            }
        }

        if (count($curr_result)) {
            $all_results[$k] = $curr_result;
        }
    }

    return $all_results;
}

function flrt_debug_title(){

    echo '<div class="wpc-debug-title">'.esc_html__('Filter Everything debug', 'filter-everything');
    echo  '&nbsp;'.flrt_help_tip(
            sprintf(
                __('Debug messages are visible for logged in administrators only. You can disable them in Filters -> <a href="%s">Settings</a> -> Debug mode.', 'filter-everything'),
                admin_url( 'edit.php?post_type=filter-set&page=filters-settings' )
            ), true ).'</div>';
}

function flrt_is_debug_mode(){
    $debug_mode = false;
    if( flrt_get_option( 'widget_debug_messages' ) === 'on' ) {
        if( current_user_can( 'manage_options' ) ){
            $debug_mode = true;
        }
    }

    return $debug_mode;
}

function wpc_clean( $var ) {
    if ( is_array( $var ) ) {
        return array_map( 'wpc_clean', $var );
    } else {
        return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
    }
}

function flrt_sorting_option_value(  $order_by_value, $meta_keys, $orders, $i ){
    $meta_key     = isset( $meta_keys[$i] ) ? $meta_keys[$i] : '';
    $order        = isset( $orders[$i] ) ? $orders[$i] : '';

    $option_value = $order_by_value;

    if( in_array( $order_by_value, ['m', 'n'], true ) ){
        $option_value .= $meta_key;
    }

    $option_value .= ( $order === 'desc' ) ? '-'.$order : '';

    return $option_value;
}

function flrt_get_active_plugins(){

    if( is_multisite() ){
        $active_plugins = get_site_option('active_sitewide_plugins');
        if( is_array( $active_plugins ) ){
            $active_plugins = array_keys( $active_plugins );
        }
    }else{
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
    }

    return $active_plugins;
}

function flrt_get_terms_transient_key( $salt ){
    return 'wpc_terms_' . $salt;
}

function flrt_get_post_ids_transient_key( $salt ){
    return 'wpc_posts_' . $salt;
}

function flrt_get_variations_transient_key( $salt ){
    return 'wpc_variations_' . $salt;
}