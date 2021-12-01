<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class DefaultEntity implements Entity
{
    public $items = [];

    public $entityName = '';

    public function __construct( $postMetaName ){
        $this->entityName = $postMetaName;
    }

    function getName()
    {
        return $this->entityName;
    }

    function getAllExistingTerms( $force = false )
    {
        // TODO: Implement getAllExistingTerms() method.
        return array();
    }

    function addTermsToWpQuery($a, $b)
    {
        // TODO: Implement addTermsToWpQuery() method.
    }

    function populateTermsWithPostIds( $setId, $post_type )
    {
        // TODO: Implement populateTermsWithPostIds() method.
    }

    function getTermId($slug)
    {
        // TODO: Implement getTermId() method.
        return $slug;
    }

    function setExcludedTerms($excludedTerms)
    {
        // TODO: Implement setExcludedTerms() method.
    }

    public function getTermsForSelect()
    {
        // TODO: Implement getTermsForSelect() method.
        return array();
    }

    public function getTerms()
    {
        // TODO: Implement getTerms() method.
        return array();
    }

    public function setPostTypes($postTypes)
    {
        // TODO: Implement setPostTypes() method.
    }
}