<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

?><tr class="wpc-filter-tr <?php echo esc_attr( $attributes['class'] ); ?>-tr"<?php flrt_maybe_hide_row( $attributes ); ?>><?php

    flrt_include_admin_view('filter-field-label', array(
            'field_key'  => $field_key,
            'attributes' =>  $attributes
        )
    );

    flrt_include_admin_view('filter-field-input', array(
            'field_key'  => $field_key,
            'attributes' =>  $attributes
        )
    );

?></tr>