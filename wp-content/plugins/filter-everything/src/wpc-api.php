<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

// SEO API
/**
 * @param string $key title|description|h1|text
 * @return string|false Needed seo data
 */
function flrt_get_seo_data($key = 'title' ){
    if( ! did_action('wp') ){
        _doing_it_wrong(
            'flrt_get_seo_data',
            sprintf(
            /* translators: %s: rest_api_init */
                esc_html__( 'Please, do not call the "%s" function before the "wp" action', 'filter-everything' ),
                'flrt_get_seo_data'
            ),
            '4.6'
        );
        return false;
    }

    $possibleValues = array(
        'title'       => 'seoTitle',
        'description' => 'metaDescription',
        'h1'          => 'h1',
        'text'        => 'seoDescription',
    );

    if( in_array( $key, array_keys($possibleValues), true ) ){
        $seoFrontend = \FilterEverything\Filter\Container::instance()->getSeoFrontendService();
        return $seoFrontend->get( $possibleValues[$key] );
    }

    return false;
}

// Posts found quantity
/**
 * @return int|null number of posts found
 */
function flrt_posts_found_quantity( $setid, $all = false )
{
    $wpManager = \FilterEverything\Filter\Container::instance()->getWpManager();
    $em        = \FilterEverything\Filter\Container::instance()->getEntityManager();

    $count = NULL;

    if( $wpManager->getQueryVar('wpc_is_filter_request' ) ){

        $set_filter_keys = array_flip( $em->getSetFilterKeys( array( $setid ) ) );
        $queried_keys = [];

        foreach ( $wpManager->getQueryVar('queried_values') as $queried_value ){
            $key = $queried_value['entity'].'#'.$queried_value['e_name'];
            $queried_keys[ $key ] = true;
        }

        if( ! empty( array_intersect_key( $queried_keys, $set_filter_keys ) ) ){
            $count = count( $em->getAlreadyFilteredPostIds( $setid ) );
        }else if( $all ) {
            $count = count( $em->getAlreadyFilteredPostIds( $setid ) );
        }

    } else if ( $all ){
        $count = count( $em->getAlreadyFilteredPostIds( $setid ) );
    }

    return $count;
}

// Selected filter chips
/**
 * @param bool $include_reset - include Reset button term or not
 * @return array|false - selected terms
 */
function flrt_selected_filter_chips($include_reset = true )
{
    $chipsObj = new FilterEverything\Filter\Chips($include_reset);
    return $chipsObj->getChips();
}

// Selected filter terms
/**
 * @return array|false all selected filters or false
 */
function flrt_selected_filter_terms()
{
    $wpManager = \FilterEverything\Filter\Container::instance()->getWpManager();
    return $wpManager->getQueryVar('queried_values');
}

// Get all filters related with current page
/**
 * @return array of all filters from the Filter Set
 * related with current page
 * or empty array if there are no filters
 */
function flrt_get_page_related_filters(){
    $em = \FilterEverything\Filter\Container::instance()->getEntityManager();
    return $em->getSetsRelatedFilters();
}