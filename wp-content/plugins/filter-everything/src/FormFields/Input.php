<?php

namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class Input {

    public $validAttributes = array(
        'id',
        'class',
        'name',
        'value',
        'onclick',
        'disabled',
        'selected',
        'size',
        'data-',
        'placeholder',
        'readonly',
        'options',
        'textarea_rows',
        'multiple',
        'title'
    );

    public $attributes;

    public function __construct( $attributes = '' )
    {
        if ( $attributes ){
            $this->setAttributes( $attributes );
        }
    }

    public function setAttributes( $attributes )
    {
        if( ! is_array( $attributes ) ){
            $attributes = array( $attributes );
        }

        $this->attributes = $this->sanitizeAttributes( $attributes );
    }

    protected function getAttribute( $key ){
        if( isset( $this->attributes[ $key ] ) ){
            return $this->attributes[ $key ];
        }

        return false;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    protected function sanitizeAttributes( $attributes )
    {
        $sanitizedAttributes = [];
        $attributes = array_change_key_case( $attributes, CASE_LOWER );

        foreach ( $attributes as $key => $value ){
            if( in_array( $key, $this->validAttributes ) ){
                $sanitizedAttributes[ $key ] = $value;
            }

            if( mb_strpos( $key, 'data-' ) !== false ){
                $sanitizedAttributes[ $key ] = $value;
            }
        }

        return $sanitizedAttributes;

    }

    protected function renderAttributes( $skip = [] )
    {
        $html = '';

        foreach ( (array) $this->attributes as $key => $value ) {
            // do not sanitize attribute name because we already validated them
            if( in_array( $key, $skip ) ){
                continue;
            }
            $html .= ' ' .  esc_attr($key) . '="' . esc_attr( $value ).'"';
        }

        return $html;
    }

}

class Checkbox extends Input {
    public function render(){

        $html = '<input type="checkbox"';
        $html .= $this->renderAttributes( array('placeholder') );
        $html .= checked('yes', $this->getAttribute('value'), false );
        $html .= ' />';

        if( $this->getAttribute('placeholder') ){
            $html .= '<span class="wpc-checkbox-placeholder">'.esc_html( $this->getAttribute('placeholder') ).'</span>';
        }

        return apply_filters( 'wpc_input_type_checkbox', $html, $this->getAttributes() );
    }
}

class File extends Input {
    public function render(){
        $html = '<input type="file"';
        $html .= $this->renderAttributes();
        $html .= ' />';

        return apply_filters( 'wpc_input_type_file', $html, $this->getAttributes() );
    }
}

class Hidden extends Input {
    public function render(){
        $html = '<input type="hidden"';
        $html .= $this->renderAttributes();
        $html .= ' />'."\r\n";

        return apply_filters( 'wpc_input_type_hidden', $html, $this->getAttributes() );
    }
}

class Image extends Input {

}

class Password extends Input {
    public function render(){
        $html = '<input type="password"';
        $html .= $this->renderAttributes();
        $html .= ' />'."\r\n";

        return apply_filters( 'wpc_input_type_password', $html, $this->getAttributes() );
    }
}

class Radio extends Input {
    public function render(){
        $class = 'class';
        if(!$this -> $class){
            $class = ' class="radio"';
        }

        $html = '<input '.$class.' type="radio"';
        $html .= $this -> renderAttributes();
        $html .= ' value="'.$this -> value.'"';
        $html .= ' />';

        return apply_filters( 'wpc_input_type_radio', $html, $this->getAttributes() );
    }
}

class Submit extends Input {
    public function __construct($options, $validation = []){
        if(!is_array($options)){
            $o = [];
            $o['value'] = $options;
            $o['name'] = 'submit';
            $o['id'] = 'submit';
        } else {
            $o = $options;
        }
        parent::__construct($o, $validation);
    }

    public function render(){
        $class = 'class';
        if(!$this -> $class){
            $class = ' class="submit"';
        }

        $html = '<input '.$class.' type="submit"';
        $html .= $this -> renderAttributes();
        $html .= ' value="'.$this -> value.'"';
        $html .= ' />';

        return apply_filters( 'wpc_input_type_submit', $html, $this->getAttributes() );
    }
}

class Text extends Input {
    public function render(){
        $html = '<input type="text"';
        $html .= $this->renderAttributes();
        $html .= ' />'."\r\n";

        return apply_filters( 'wpc_input_type_text', $html, $this->getAttributes() );
    }
}

class Select extends Input {

    private function renderDropdown( $options, $selected, $disabled = [] )
    {
        $html = '';
        $option_group = false;

        // For multidimensional array
        foreach ( $options as $key => $option ){
            if( isset( $option['group_label'] ) ){
                $option_group = true;

                $html .= '<optgroup label="'.$option['group_label'].'" class="'.sanitize_title( $option['group_label'] ).'">';
                if( isset( $option['entities'] ) ){
                    $html .= $this->renderOptions( $option['entities'], $selected, $disabled );
                }
                $html .= '</optgroup>'."\r\n";
            }
        }

        // In case for simple options array
        if( ! $option_group ){
            $html .= $this->renderOptions( $options, $selected, $disabled );
        }

        return $html;
    }

    private function renderOptions( $options, $selected = '', $disabled = [] ){
        if( ! $options || ! is_array( $options ) ){
            return false;
        }
        $html = '';

        foreach ( $options as $value => $label ){
            $html .= $this->renderOption( $label, $value, $selected, $disabled );
        }

        return $html;
    }

    private function renderOption( $label, $value, $selected = '', $disabled = [] ){
        $attributes = '';
        $attr       = apply_filters( 'wpc_dropdown_option_attr', $label );
        $label      = flrt_extract_var( $attr, 'label' );

        foreach ( (array) $attr as $key => $val ){
            $attributes .= $key .'="'.$val.'" ';
        }

        $html = '<option value="'.$value.'" '.$attributes;

        if( is_array( $selected ) ){
            if( in_array( $value, $selected ) ){
                $html .= ' selected="selected"';
            }
        }else{
            if( $value == $selected ){
                $html .= ' selected="selected"';
            }
        }

        if( is_array( $disabled ) && ! empty( $disabled ) ){
            if( in_array( $value, $disabled ) ){
                $html .= ' disabled="disabled"';
            }
        }

        $html .= '>' . $label . '</option>'."\r\n";

        return $html;
    }

    public function render(){
        $html = '<select';
        $html .= $this->renderAttributes( array( 'value', 'options', 'disabled' ) );
        $html .= '>';

        $html .= $this->renderDropdown( $this->getAttribute('options' ) , $this->getAttribute('value' ), $this->getAttribute('disabled' ) );

        $html .= '</select>'."\r\n";

        return apply_filters( 'wpc_input_type_select', $html, $this->getAttributes() );
    }
}

class Textarea extends Input {
    public function render(){
        $html = '<textarea';
        $html .= $this->renderAttributes( array( 'value' ) );
        $html .= '>';
        $html .= esc_textarea( $this->getAttribute('value' ) );
        $html .= '</textarea>'."\r\n";

        return apply_filters( 'wpc_input_type_textarea', $html, $this->getAttributes() );
    }
}

class Wpeditor extends Input {
    public function render(){
        $settings = array(
            'textarea_rows' => $this->getAttribute('textarea_rows'),
            'textarea_name' => $this->getAttribute('name')
        );
        wp_editor( $this->getAttribute('value' ), $this->getAttribute('id' ), $settings );
    }
}