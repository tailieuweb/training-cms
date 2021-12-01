<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}
class ChipsWidget extends \WP_Widget
{
    public function __construct() {
        parent::__construct(
            'wpc_chips_widget', // Base ID
            esc_html__( 'Filter Everything &mdash; Chips', 'filter-everything'),
            array( 'description' => esc_html__( 'Chips Widget', 'filter-everything' ), )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $title  = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $set_id = isset( $instance['set_id'] ) ? preg_replace('/[^\d\,]?/', '', $instance['set_id'] ) : '';
        $mobile = ( !empty( $instance['mobile'] ) ) ? $instance['mobile'] : '';
        $setIds = $classes = [];

        if( isset( $_POST['action'] ) && $_POST['action'] === 'elementor_ajax' ){
            echo '<strong>'.esc_html__( 'Filter Everything &mdash; Chips', 'filter-everything' ).'</strong>';
            return;
        }

        if( isset( $_GET['action'] ) && $_GET['action'] === 'elementor' ){
            echo '<strong>'.esc_html__( 'Filter Everything &mdash; Chips', 'filter-everything' ).'</strong>';
            return;
        }

        if( $mobile ){
            $classes[] = 'wpc-show-on-mobile';
        }

        if( $set_id ){
            $setIds = explode( ",", $set_id );
        }

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        flrt_show_selected_terms(true, $setIds, $classes);

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        $title  = isset( $instance['title'] ) ? $instance['title'] : '';
        $set_id = isset( $instance['set_id'] ) ? $instance['set_id'] : '';
        $mobile = isset( $instance['mobile'] ) ? (bool) $instance['mobile'] : true;

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'set_id' ) ); ?>"><?php esc_html_e( 'Show Chips only for Set with IDs:', 'filter-everything' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'set_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'set_id' ) ); ?>" type="text" value="<?php echo esc_attr( $set_id ); ?>" placeholder="<?php esc_html_e( 'e.g. 2745, 324', 'filter-everything' ); ?>"/>
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'mobile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'mobile' ) ); ?>"<?php checked( $mobile ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'mobile' ) ); ?>"><?php esc_html_e( 'Show on mobile', 'filter-everything' ); ?></label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title']  = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['set_id'] = ( !empty( $new_instance['set_id'] ) ) ? $new_instance['set_id'] : '';
        $instance['mobile'] = ( !empty( $new_instance['mobile'] ) ) ? 1 : 0;

        return $instance;
    }
}