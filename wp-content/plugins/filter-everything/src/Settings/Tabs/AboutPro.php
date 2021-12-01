<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class AboutPro extends BaseSettings{
    protected $page = 'wpc-filter-about-pro';

    protected $group = 'wpc_filter_about_pro';

    protected $optionName = 'wpc_filter_about_pro';
    
}