<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

abstract class BaseSettings implements TabInterface{

    protected $page;

    protected $group;

    protected $optionName;

    protected $options;

    protected function registerSettings($settings, $page, $optionName)
    {
        $callbacks = array(
            'checkbox' => array($this, 'checkboxCallback'),
            'text'     => array($this, 'inputCallback'),
            'textarea' => array($this, 'textareaCallback'),
            'editor'   => array($this, 'textEditorCallback'),
            'select'   => array($this, 'selectCallback'),
            'hidden'   => array($this, 'hiddenCallback')
        );

        foreach ($settings as $sectionId => $section) {
            $callback = isset($section['callback']) ? $section['callback'] : null;
            add_settings_section($sectionId, $section['label'], $callback, $page);

            if( isset( $section['fields'] ) ){
                foreach ( $section['fields'] as $fieldId => $field) {
                    $title                = isset($field['title']) ? $field['title'] : '';
                    $field['label_for']   = $fieldId;
                    $field['option_name'] = $optionName;
                    $field['placeholder'] = isset($field['placeholder']) ? $field['placeholder'] : '';
                    $field['id']          = isset($field['id']) ? $field['id'] : $fieldId;
                    add_settings_field($fieldId, $title, $callbacks[$field['type']], $page, $sectionId, $field);
                }
            }
        }
    }

    public function checkBoxCallback($args)
    {
        $checkbox = '<label><input type="checkbox" name="%s[%s]" %s id="%s">%s</label>';
        $checkbox = apply_filters( 'wpc_settings_field_checkbox', $checkbox, $args );
        $checked  = $this->getOption($args['label_for']);

        if ($checked == '1') {
            $checked = 'on';
        }

        printf(
            $checkbox,
            esc_attr($args['option_name']),
            esc_attr($args['label_for']),
            checked('on', $checked, false),
            esc_attr($args['id']),
            esc_html($args['label'])
        );

        if( isset( $args['description'] ) ){
            printf( '<p class="description">%s</p>', esc_html( $args['description'] ) );
        }
    }

    public function inputCallback($args)
    {
        $input = '<input class="%s" type="text" name="%s[%s]" value="%s" placeholder="%s" id="%s">';
        $class = isset( $args['class'] ) ? $args['class'] : 'regular-text';
        if( isset( $args['default'] ) ){
            $value = $this->getOption($args['label_for']) ? $this->getOption($args['label_for']) : $args['default'];
        }else{
            $value = $this->getOption($args['label_for']);
        }

        $value = trim($value);

        printf(
            $input,
            esc_attr($class),
            esc_attr($this->optionName),
            esc_attr($args['label_for']),
            esc_attr($value),
            esc_attr($args['placeholder']),
            esc_attr($args['id'])
        );

        if( isset($args['id']) && $args['id'] === 'posts_container' ){

            if( flrt_get_option('enable_ajax') === 'on' && ! $value ){
                printf( '<p class="wpc-warning">%s</p>', esc_html__( 'You must specify Posts Container, otherwise AJAX will not work properly', 'filter-everything' ) );
            }
        }

        if( isset( $args['description'] ) ){
            printf( '<p class="description">%s</p>', esc_html( $args['description'] ) );
        }

    }

    public function hiddenCallback( $args )
    {
        $input = '<input class="%s" type="hidden" name="%s[%s]" value="%s" placeholder="%s" id="%s">';
        $class = isset( $args['class'] ) ? $args['class'] : 'regular-text';
        printf(
            $input,
            esc_attr($class),
            esc_attr($this->optionName),
            esc_attr($args['label_for']),
            esc_attr($this->getOption($args['label_for'])),
            esc_attr($args['placeholder']),
            esc_attr($args['id'])
        );
    }

    public function selectCallback($args)
    {
        $options = isset($args['options']) ? $args['options'] : [];
        $class = isset( $args['class'] ) ? $args['class'] : 'filter-settings-select';
        $value = $this->getOption($args['label_for']);

        $multiple = ! empty($args['multiple']) ? 'multiple' : null;

        $select = '<select name="%s[%s]%s" class="%s" placeholder="%s" id="%s" %s>';

        printf(
            $select,
            esc_attr($this->optionName),
            esc_attr($args['label_for']),
            $multiple ? '[]' : '',
            $class,
            esc_attr($args['placeholder']),
            esc_attr($args['id']),
            $multiple
        );

        foreach ($options as $key => $option) {
            if (! empty($value)) {
                if (is_null($multiple)) {
                    $selected = $key === $value ? 'selected' : '';
                } else {
                    $selected = in_array($key, $value) ? 'selected' : '';
                }
            } else {
                $selected = '';
            }

            printf('<option value="%s" %s>%s</option>', esc_attr($key), $selected, esc_html($option));
        }

        print('</select>');

        if (isset($args['help'])) {
            printf('<p>%s</p>', esc_html($args['help']));
        }

        if( isset( $args['description'] ) ){
            printf( '<p class="description">%s</p>', esc_html( $args['description'] ) );
        }

    }

    public function textareaCallback($args)
    {
        $textarea = '<textarea class="filter-settings-input large-text code" name="%s[%s]" placeholder="%s" cols="30" rows="10" id="%s">%s</textarea>';

        printf(
            $textarea,
            esc_attr($this->optionName),
            esc_attr($args['label_for']),
            esc_attr($args['placeholder']),
            esc_attr($args['id']),
            esc_textarea( $this->getOption($args['label_for']) )
        );

    }

    public function textEditorCallback($args)
    {
        wp_editor(
            $this->getOption( $args['label_for'] ),
            esc_attr( $args['id'] ),
            array( 'textarea_name' => esc_attr( $this->optionName . '[' . $args['label_for'] . ']' ) )
        );

    }

    public function render()
    {
        print('<form action="' . admin_url('options.php') . '" method="post">');

        settings_errors();

        settings_fields($this->group);

        do_action('wpc_before_sections_settings_fields', $this->page );

        $this->doSettingsSections($this->page);

        do_action('wpc_after_sections_settings_fields', $this->page );

        submit_button();
        print('</form>');
    }

    public function doSettingsSections( $page ) {
        global $wp_settings_sections, $wp_settings_fields;

        if ( ! isset( $wp_settings_sections[ $page ] ) ) {
            return;
        }

        foreach ( (array) $wp_settings_sections[ $page ] as $section ) {

            do_action('wpc_before_settings_fields_title', $page );

            if ( $section['title'] ) {
                echo "<h2>". wp_kses( $section['title'], array( 'span' => array( 'class' => true ) )) ."</h2>\n";
            }

            do_action('wpc_after_settings_fields_title', $page );

            if ( $section['callback'] ) {
                call_user_func( $section['callback'], $section );
            }

            if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
                continue;
            }

            $sortable = ( $section['id'] === 'wpc_slugs' ) ? ' wpc-sortable-table' : '';

            echo '<table class="wpc-form-table form-table'.esc_attr($sortable).'" role="presentation">';
            $this->doSettingsFields( $page, $section['id'] );
            echo '</table>';
        }
    }

    public function doSettingsFields( $page, $section ) {
        global $wp_settings_fields;

        if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
            return;
        }
        $i = 1;

        foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $field ) {
            $class = '';

            if( $field['id'] === 'bottom_widget_compatibility' ){
                if( flrt_get_option('show_bottom_widget') === 'on' ){
                    $field['args']['class'] .= ' wpc-opened';
                }
            }

            if ( ! empty( $field['args']['class'] ) ) {
                $class = ' class="' . esc_attr( $field['args']['class'] ) . '"';
            }

            echo "<tr{$class}>";

            $sortable = isset( $field['args']['sortable'] ) ? $i : '';
            if( $sortable ){
                echo '<td class="wpc-order-td">'.esc_html($sortable).'</td>';
            }

            $tooltip = isset( $field['args']['tooltip'] ) ? flrt_tooltip( array( 'tooltip' => $field['args']['tooltip'] ) ) : '';
            $tooltip = wp_kses(
                $tooltip,
                array(
                    'strong' => array(),
                    'br'      => array(),
                    'a'      => array( 'href'=>true, 'title'=>true, 'class'=>true ),
                    'span'   => array( 'class'=>true, 'data-tip'=>true)
                )
            );

            if ( ! empty( $field['args']['label_for'] ) ) {
                echo '<th scope="row"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . esc_html($field['title']) . '</label> ' .$tooltip. '</th>'; // $tooltip already escaped
            } else {
                echo '<th scope="row">'. esc_html($field['title'] ) . ' ' .$tooltip. '</th>'; // $tooltip already escaped
            }

            echo '<td>';
            call_user_func( $field['callback'], $field['args'] );
            echo '</td>';

            if( $sortable ){
                $title = ( ! defined( 'FLRT_FILTERS_PRO' ) ) ? __( 'Editing the order of URL prefixes is available in PRO version', 'filter-everything' ) : '';
                echo '<td class="wpc-order-sortable-handle-icon"><span class="dashicons dashicons-menu wpc-field-sortable-handle" title="'.esc_attr( $title ).'">&nbsp;</span></td>';
            }

            echo '</tr>';
            $i++;
        }
    }

    public function getOption($key, $default = null)
    {
        if (is_null($this->options)) {
            $this->options = get_option($this->optionName);
        }

        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }
}
