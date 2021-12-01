<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class TabRenderer
{

    private $tabs = [];

    public function register(TabInterface $tab)
    {
        $this->tabs[$tab->getName()] = $tab;
    }

    public function init()
    {
        foreach ($this->tabs as $tab) {
            $tab->init();
        }
    }

    public function render()
    {
        $tab = $this->get($this->current()) ?: reset($this->tabs);

        if ($tab && $tab->valid()) {
            flrt_include_admin_view( 'options', array('tabs' => $this->tabs, 'current' => $tab) );
        }
    }

    public function get($name)
    {
        return $this->has($name) ? $this->tabs[$name] : null;
    }

    public function has($name)
    {
        return isset($this->tabs[$name]);
    }

    public function current()
    {
        $get = Container::instance()->getTheGet();
        return isset($get['tab']) ? sanitize_key($get['tab']) : null;
    }
}
