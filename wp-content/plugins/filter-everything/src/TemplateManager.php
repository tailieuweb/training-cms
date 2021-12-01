<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class TemplateManager
{
    private $pluginRootDir;

    private $themeRootDir;

    private $pluginUrl;

    public function __construct( $pluginFilePath )
    {
        $this->pluginRootDir = $pluginFilePath;
        $this->pluginUrl     = plugin_dir_url( $pluginFilePath );
        $this->themeRootDir  = get_stylesheet_directory();
    }

    public function includeAdminView( $path, array $variables = [] )
    {
        $file = $this->pluginRootDir . 'views/admin/' . $path . '.php';

        if( file_exists( $file ) ){
            extract( $variables );
            include $file;
        }

    }

    public function includeFrontView( $path, $variables = [] )
    {
        $file = locate_template( array( FLRT_TEMPLATES_DIR_NAME . '/' . $path . '.php') );

        if( '' === $file ){
            $file = $this->pluginRootDir . 'views/frontend/' . $path . '.php';
        }

        if( file_exists( $file ) ){
            extract( $variables );
            include $file;
        }
    }

    public function locateTemplate( $path )
    {

    }

}