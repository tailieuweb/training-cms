<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class SettingsTab extends BaseSettings
{
    protected $page = 'wpc-filter-admin-settings';

    protected $group = 'wpc_filter';

    protected $optionName = 'wpc_filter_settings';

    public function init()
    {
        add_action('admin_init', array($this, 'initSettings'));
    }

    public function initSettings()
    {
        register_setting($this->group, $this->optionName);
        /**
         * @see https://developer.wordpress.org/reference/functions/add_settings_field/
        */
        $defaultPostsContainer = flrt_default_posts_container();
        $defaultPrimaryColor   = flrt_default_theme_color();

        $settings = array(
            'mobile_devices' => array(
                'label'  => esc_html__('Mobile devices', 'filter-everything'),
                'fields' => array(
                    'show_open_close_button'        => array(
                        'type'  => 'checkbox',
                        'title' => esc_html__('Collapse Filters Widget on Mobile devices', 'filter-everything'),
                        'id'    => 'show_open_close_button',
                        'label' => esc_html__('Collapse widget and show the Filters opening button', 'filter-everything'),
                    ),
                    'try_move_to_top_sidebar' => array(
                        'type'  => 'checkbox',
                        'title' => esc_html__('Sidebar on top', 'filter-everything'),
                        'id'    => 'try_move_to_top_sidebar',
                        'label' => esc_html__('Try to move sidebar to top on mobile devices', 'filter-everything'),
                    )
                )
            ),
            'ajax' => array(
                'label'  => esc_html__('AJAX', 'filter-everything'),
                'fields' => array(
                    'enable_ajax'        => array(
                        'type'  => 'checkbox',
                        'title' => esc_html__('AJAX for Filters', 'filter-everything'),
                        'id'    => 'enable_ajax',
                        'label' => esc_html__('Try to use AJAX', 'filter-everything'),
                        'description' => esc_html__( 'Please enable this option only after you have ensured that the filtering is working correctly', 'filter-everything' ),
                    ),
                    'posts_container' => array(
                        'type'      => 'text',
                        'title'     => esc_html__('CSS ID or Class of Posts Container', 'filter-everything'),
                        'id'        => 'posts_container',
                        'default'   => $defaultPostsContainer,
                        'description' => esc_html__( 'e.g. #primary or .main-content', 'filter-everything' ),
                        'label'     => '',
                    )
                )
            ),
            'common_settings' => array(
                'label'  => esc_html__('Other', 'filter-everything'),
                'fields' => array(
                    'primary_color' => array(
                        'type'    => 'text',
                        'title'   => esc_html__('Widget Primary Color', 'filter-everything'),
                        'id'      => 'wpc_primary_color',
                        'default' => $defaultPrimaryColor,
                        'label'   => '',
                    ),
                    'container_height' => array(
                        'type'  => 'text',
                        'title' => esc_html__('Filter Container max height, px', 'filter-everything'),
                        'id'    => 'container_height',
                        'label' => '',
                    ),
                    'show_terms_in_content' => array(
                        'type'  => 'select',
                        'title' => esc_html__('Selected Filters (Chips) integration', 'filter-everything'),
                        'id'    => 'show_terms_in_content',
                        'label' => esc_html__('Try to show selected terms above the posts container', 'filter-everything'),
                        'options' => array(),
                        'multiple' => true,
                        'description' => esc_html__( 'Select where to show Chips on your site. Or enter your theme\'s hooks. For example: before_main_content', 'filter-everything' )
                    ),
                    'widget_debug_messages' => array(
                        'type'  => 'checkbox',
                        'title' => esc_html__('Debug mode', 'filter-everything'),
                        'id'    => 'widget_debug_messages',
                        'label' => esc_html__('Enable debugging messages to help to configure filters', 'filter-everything'),
                    )
                )
            )
        );

        $settings = apply_filters('wpc_general_filters_settings', $settings);

        $this->registerSettings($settings, $this->page, $this->optionName);
    }

    public function getLabel()
    {
        return esc_html__('General', 'filter-everything');
    }

    public function getName()
    {
        return 'settings';
    }

    public function valid()
    {
        return true;
    }
}

