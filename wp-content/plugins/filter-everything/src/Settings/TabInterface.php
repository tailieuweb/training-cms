<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

interface TabInterface
{
    public function init();

    public function render();

    public function getLabel();

    public function getName();

    public function valid();
}
