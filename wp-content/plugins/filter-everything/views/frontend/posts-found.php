<?php
/**
 * The Template for displaying Filters found posts number.
 *
 * This template can be overridden by copying it to yourtheme/filter/posts-found.php.
 *
 * $posts_found - int|NULL, posts found number
 * $singular_label - string label for single found post
 * $plural_label - string label for multiple found posts
 *
 * @see https://filtereverything.pro/resources/templates-overriding/
 */

if ( ! defined('WPINC') ) {
    wp_die();
}

?>
<div class="wpc-posts-found" data-found="<?php echo esc_attr( $posts_found_count ); ?>">
<p><?php
    if( $posts_found_count !== NULL ) {
        $class = ( $posts_found_count > 1 ) ? 'wpc-posts-found-number wpc-plural' : 'wpc-posts-found-number';
        $label = ( $posts_found_count > 1 ) ? $plural_label : $singular_label;

        echo wp_kses(
            sprintf( _n(
                '<span class="%s">%d</span> %s found',
                '<span class="%s">%d</span> %s found',
                $posts_found_count,
                'filter-everything'
            ), $class, $posts_found_count, $label ),
            array(
                'span' => array('class' => true)
            )
        );

    }else{
        echo '&nbsp;';
    }
?></p>
</div>