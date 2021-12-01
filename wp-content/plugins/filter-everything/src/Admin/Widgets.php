<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class Widgets
{
    function __construct(){
        add_action( 'widgets_init', array( $this, 'register' ) );
    }

    public function register(){
        register_widget( '\FilterEverything\Filter\FiltersWidget' );
        register_widget( '\FilterEverything\Filter\ChipsWidget' );
        register_widget( '\FilterEverything\Filter\SortingWidget' );
    }
}

new Widgets();