<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class ExperimentalTab extends BaseSettings
{
    protected $page = 'wpc-filter-experimental-settings';

    protected $group = 'wpc_filter_experimental';

    protected $optionName = 'wpc_filter_experimental';

    public function init()
    {
        add_action('admin_init', array($this, 'initSettings'));
    }

    public function initSettings()
    {
        register_setting($this->group, $this->optionName);

        $settings = array(
            'ajax_settings' => array(
                    'label'  => esc_html__('AJAX', 'filter-everything'),
                    'fields' => array(
                        'use_loader' => array(
                            'type'  => 'checkbox',
                            'title' => esc_html__('AJAX loading icon (on desktop only)', 'filter-everything'),
                            'id'    => 'use_loader',
                            'label' => esc_html__('Show icon', 'filter-everything'),
                        ),
                        'use_wait_cursor' => array(
                            'type'  => 'checkbox',
                            'title' => esc_html__('Wait Cursor (on desktop only)', 'filter-everything'),
                            'id'    => 'use_wait_cursor',
                            'label' => esc_html__('Use Wait Cursor for AJAX', 'filter-everything'),
                        ),
                        'dark_overlay' => array(
                            'type'  => 'checkbox',
                            'title' => esc_html__('Dark Overlay (on desktop only)', 'filter-everything'),
                            'id'    => 'dark_overlay',
                            'label' => esc_html__('Use dark transparent overlay instead of white', 'filter-everything'),
                        ),
                        'auto_scroll' => array(
                            'type'  => 'checkbox',
                            'title' => esc_html__('Smart Auto Scroll (on desktop only)', 'filter-everything'),
                            'id'    => 'auto_scroll',
                            'label' => esc_html__('Automatically Scroll to the top of posts grid', 'filter-everything'),
                        )
                    )
                ),
                'layout_settings' => array(
                    'label'  => esc_html__('Appearance', 'filter-everything'),
                    'fields' => array(
                        'styled_inputs' => array(
                            'type'  => 'checkbox',
                            'title' => esc_html__('Styled checkboxes and radio buttons', 'filter-everything'),
                            'id'    => 'styled_inputs',
                            'label' => esc_html__('Enable styling', 'filter-everything'),
                        ),
                        'select2_dropdowns' => array(
                            'type'  => 'checkbox',
                            'title' => esc_html__('Improved dropdowns', 'filter-everything'),
                            'id'    => 'styled_inputs',
                            'label' => esc_html__('Use improved dropdowns instead of regular ones (jQuery Select2)', 'filter-everything'),
                        ),
                    )
                )
        );

        if( flrt_is_woocommerce() ){
            $settings['woocommerce_settings'] = array(
                'label'  => esc_html__('WooCommerce', 'filter-everything'),
                'fields' => array(
                    'disable_woo_orderby' => array(
                        'type'  => 'checkbox',
                        'title' => esc_html__('Woocommerce Order By dropdown', 'filter-everything'),
                        'id'    => 'disable_woo_orderby',
                        'label' => esc_html__('Hide Woocommerce default sorting dropdown', 'filter-everything'),
                    ),
                )
            );
        }

        $settings['customization'] = array(
                    'label'  => esc_html__('Customization', 'filter-everything'),
                    'fields' => array(
                        'custom_css'        => array(
                            'type'  => 'textarea',
                            'title' => esc_html__('Custom CSS', 'filter-everything'),
                            'id'    => 'custom_css',
                            'label' => ''
                        )
                    )
                );

        $settings = apply_filters('wpc_experimental_filters_settings', $settings);

        $this->registerSettings($settings, $this->page, $this->optionName);
    }

    public function getLabel()
    {
        return esc_html__('Experimental', 'filter-everything');
    }

    public function getName()
    {
        return 'experimental';
    }

    public function valid()
    {
        return true;
    }
}