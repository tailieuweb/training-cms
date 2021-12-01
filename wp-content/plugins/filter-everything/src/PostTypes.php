<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class PostTypes
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'registerPostType' ) );
    }

    function registerPostType() {
        // No need to escape
        register_post_type( FLRT_FILTERS_SET_POST_TYPE, array(
            'label'    => esc_html__( 'Filter Sets', 'filter-everything' ),
            'labels'			=> array(
                'name'					=> esc_html__( 'Filter Sets', 'filter-everything' ),
                'singular_name'			=> esc_html__( 'Filters Set', 'filter-everything' ),
                'add_new'				=> esc_html__( 'Add Filter Set' , 'filter-everything' ),
                'add_new_item'			=> esc_html__( 'Add Filter Set' , 'filter-everything' ),
                'edit_item'				=> esc_html__( 'Edit Filter Set' , 'filter-everything' ),
                'new_item'				=> esc_html__( 'New Filter Set' , 'filter-everything' ),
                'view_item'				=> esc_html__( 'View Filter Set', 'filter-everything' ),
                'search_items'			=> esc_html__( 'Search Filter Sets', 'filter-everything' ),
                'not_found'				=> esc_html__( 'Filter Sets are Filters grouped together. Create your first Filter Set.', 'filter-everything' ),
                'not_found_in_trash'	=> esc_html__( 'No Filter Sets found in Trash', 'filter-everything' ),
            ),
            'has_archive'       => false,
            'public'			=> false,
            'show_ui'			=> true,
            '_builtin'			=> false,
            'capability_type'	=> 'post',
            'hierarchical'		=> true,
            'rewrite'			=> false,
            'query_var'			=> false,
            'supports' 			=> array('title'),
            'show_in_menu'		=> false,
        ) );

        register_post_type(FLRT_FILTERS_POST_TYPE, array(
            'labels'			=> array(
                'name'					=> esc_html__( 'Filters', 'filter-everything' ),
                'singular_name'			=> esc_html__( 'Filter', 'filter-everything' ),
                'add_new'				=> esc_html__( 'Add New' , 'filter-everything' ),
                'add_new_item'			=> esc_html__( 'Add New Filter' , 'filter-everything' ),
                'edit_item'				=> esc_html__( 'Edit Filter' , 'filter-everything' ),
                'new_item'				=> esc_html__( 'New Filter' , 'filter-everything' ),
                'view_item'				=> esc_html__( 'View Filter', 'filter-everything' ),
                'search_items'			=> esc_html__( 'Search Filters', 'filter-everything' ),
                'not_found'				=> esc_html__( 'No Filters found', 'filter-everything' ),
                'not_found_in_trash'	=> esc_html__( 'No Filters found in Trash', 'filter-everything' ),
            ),
            'public'			=> false,
            'show_ui'			=> false,
            '_builtin'			=> false,
            'capability_type'	=> 'post',
            'hierarchical'		=> true,
            'rewrite'			=> false,
            'query_var'			=> false,
            'supports' 			=> array('title'),
            'show_in_menu'		=> false,
        ) );
    }
}

new PostTypes();