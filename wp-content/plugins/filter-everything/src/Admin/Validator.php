<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class Validator
{

    private $fse;

    private $em;

    public function __construct()
    {
        $this->em   = Container::instance()->getEntityManager();
        $this->fse  = Container::instance()->getFilterService();
    }

    public function validateEmptyPrefix( $prefix, $prefixesList, $prefixEntityKey )
    {
        if( empty( $prefix ) ){
            if( ! isset( $prefixesList[ $prefixEntityKey ] ) ){
                return false;
            }
        }
        return true;
    }

    public function validateExistingPrefix( $prefix, $prefixesList, $prefixEntityKey )
    {
        if( $prefixesList ){
            if( $entityKey = array_search( $prefix, $prefixesList ) ){
                if( $prefixEntityKey !== $entityKey ){
                    return false;
                }
            }
        }

        return true;
    }

    public function validateAlphabCharsExists($prefix )
    {
        if( ! preg_match('/[a-z]/i', $prefix ) ) {
            return false;
        }

        return true;
    }

    public function validatePrefixHyphens( $prefix, $prefixesList )
    {
        if( strpos( $prefix, '-' ) !== false ){
            $pieces = explode('-', $prefix, 2 );
            $firstPart = $pieces[0];

            if( $exist = array_search( $firstPart, $prefixesList ) ){
                return false;
            }
        }

        return true;
    }

    public function validateAllowedPrefixes( $prefix, $filter )
    {
        /**
         * @todo check forbidden prefixes only of GET parameters.
         * we need totally forbidden prefixes list and list only for GET parameters
         */
        $prefix = trim($prefix);
        $taxonomyNames = get_taxonomies( [], 'names');

        foreach ( $taxonomyNames as $name ){
            if( mb_strpos( $name, $prefix . '-' ) !== false ){
                return false;
            }
        }

        // Check for existing slug
        if( flrt_get_term_by_slug( $prefix ) ){
            return false;
        }

        $forbiddenPrefixes = flrt_get_forbidden_prefixes();

        if( in_array( $prefix, $forbiddenPrefixes ) ){
            return false;
        }

        return true;
    }

    public function validateDuplicates( $prefixesList )
    {
        return ( ! flrt_array_contains_duplicate( $prefixesList ) );
    }

    public function validateEscAttrCharacters($string )
    {
        if( $string !== esc_attr( $string ) ){
            return false;
        }
        return true;
    }

    public function validatePossibleEntity( $entity )
    {
        $entities       = $this->em->getPossibleEntities();
        $flatEntities   =  array_keys( $this->em->getFlatEntities( $entities ) );

        if( $entity === 'post_meta_exists' && ! defined('FLRT_FILTERS_PRO') ){
            return true;
        }

        if( ! in_array( $entity, $flatEntities, true ) ){
            return false;
        }

        return true;
    }

    public function validateExcludeTerms( $terms, $filter )
    {
        $entityTermIds  = [];
        $_filter        = $this->fse->splitEntityFullNameInFilter( $filter );
        $entity         = $this->em->getEntityByFilter( $_filter );

        if( $entity ){
            $entityTermIds = array_keys( $entity->getTermsForSelect() );
        }

        foreach( (array) $terms as $termId ) {

            if ( ! in_array( $termId, $entityTermIds ) ){
                return false;
            }
        }

        return true;
    }

    public function validateView( $filter, $viewOptions )
    {
        if( ! in_array( $filter['view'], $viewOptions, true ) ){
            return false;
        }

        if( $filter['view'] === 'range' && ( $filter['entity'] !== 'post_meta_num' ) ){
            return false;
        }

        return true;
    }
}