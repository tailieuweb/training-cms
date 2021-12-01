<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class MetaBoxes
{
    public function __construct()
    {
        add_action( 'admin_head', array( $this, 'adminHead' ) );
    }

    public function adminHead()
    {
        add_meta_box(
            'filters-set-items',
            esc_html__( "Filters", 'filter-everything' ), // Do not need to escape because of 'trust WordPress'
            array( $this, 'filtersMetabox' ),
            FLRT_FILTERS_SET_POST_TYPE,
            'normal',
            'high'
        );

        add_meta_box(
            'filters-set-settings',
            esc_html__( "Settings", 'filter-everything' ),
            array( $this, 'settingsMetabox' ),
            FLRT_FILTERS_SET_POST_TYPE,
            'normal',
            'high'
        );

        add_meta_box(
            'filters-set-notes',
            esc_html__( "Popular Meta keys", 'filter-everything' ),
            array( $this, 'notesMetabox' ),
            FLRT_FILTERS_SET_POST_TYPE,
            'normal',
            'low'
        );

        remove_meta_box(
            'submitdiv',
            array( FLRT_FILTERS_SET_POST_TYPE ),
            'side'
        );

        add_meta_box(
            'submitdiv',
            esc_html__( 'Publish', 'filter-everything' ),
            [ 'FilterEverything\Filter\MetaBoxes', 'commonSideMetaBox' ],
            array( FLRT_FILTERS_SET_POST_TYPE ),
            'side'
        );

    }

    public function filtersMetabox( $post, $meta )
    {
        $args = array(
            'post'  => $post,
            'meta'  => $meta
        );

        flrt_include_admin_view('filters-set', $args );

    }

    public function settingsMetabox( $post, $meta ){
        $args = array(
            'post'  => $post,
            'meta'  => $meta
        );

        flrt_include_admin_view('filters-set-settings', $args );
    }

    public function notesMetabox( $post, $meta ){
        $args = array(
            'post'  => $post,
            'meta'  => $meta
        );

        flrt_include_admin_view('filters-set-notes', $args );
    }

    public static function commonSideMetaBox( $post, $args = array() ) {
        global $action;

        $post_id          = (int) $post->ID;
        $post_type        = $post->post_type;
        $post_type_object = get_post_type_object( $post_type );
        $can_publish      = current_user_can( $post_type_object->cap->publish_posts );
        ?>
    <div class="submitbox" id="submitpost">

        <div id="minor-publishing">

        <?php // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key. ?>
        <div style="display:none;">
            <?php submit_button( esc_html__( 'Save' ), '', 'save' ); ?>
        </div>

        <div id="minor-publishing-actions">
<?php


    /**
     * Fires before the post time/date setting in the Publish meta box.
     *
     * @since 4.4.0
     *
     * @param WP_Post $post WP_Post object for the current post.
     */
    do_action( 'post_submitbox_minor_actions', $post );
?>
        <div class="clear"></div>
        </div>

        <div id="misc-publishing-actions">
            <div class="misc-pub-section misc-pub-post-status">
                <?php esc_html_e( 'Status:' ); ?>
                <span id="post-status-display">
                    <?php
                    switch ( $post->post_status ) {
                        case 'private':
                            esc_html_e( 'Privately Published' );
                            break;
                        case 'publish':
                            esc_html_e( 'Published' );
                            break;
                        case 'future':
                            esc_html_e( 'Scheduled' );
                            break;
                        case 'pending':
                            esc_html_e( 'Pending Review' );
                            break;
                        case 'draft':
                        case 'auto-draft':
                            esc_html_e( 'Draft' );
                            break;
                    }
                    ?>
                </span>
            </div>

            <?php
            /* translators: Publish box date string. 1: Date, 2: Time. See https://www.php.net/manual/datetime.format.php */
            $date_string = esc_html__( '%1$s at %2$s' );
            /* translators: Publish box date format, see https://www.php.net/manual/datetime.format.php */
            $date_format = _x( 'M j, Y', 'publish box date format' );
            /* translators: Publish box time format, see https://www.php.net/manual/datetime.format.php */
            $time_format = _x( 'H:i', 'publish box time format' );

            if ( 0 !== $post_id ) {
                if ( 'future' === $post->post_status ) { // Scheduled for publishing at a future date.
                    /* translators: Post date information. %s: Date on which the post is currently scheduled to be published. */
                    $stamp = esc_html__( 'Scheduled for: %s' );
                } elseif ( 'publish' === $post->post_status || 'private' === $post->post_status ) { // Already published.
                    /* translators: Post date information. %s: Date on which the post was published. */
                    $stamp = esc_html__( 'Published on: %s' );
                } elseif ( '0000-00-00 00:00:00' === $post->post_date_gmt ) { // Draft, 1 or more saves, no date specified.
                    $stamp = wp_kses( __( 'Publish <b>immediately</b>' ), array( 'b' => array() ) );
                } elseif ( time() < strtotime( $post->post_date_gmt . ' +0000' ) ) { // Draft, 1 or more saves, future date specified.
                    /* translators: Post date information. %s: Date on which the post is to be published. */
                    $stamp = esc_html__( 'Schedule for: %s' );
                } else { // Draft, 1 or more saves, date specified.
                    /* translators: Post date information. %s: Date on which the post is to be published. */
                    $stamp = esc_html__( 'Publish on: %s' );
                }
                $date = sprintf(
                    $date_string,
                    date_i18n( $date_format, strtotime( $post->post_date ) ),
                    date_i18n( $time_format, strtotime( $post->post_date ) )
                );
            } else { // Draft (no saves, and thus no date specified).
                $stamp = wp_kses( __( 'Publish <b>immediately</b>' ), array( 'b' => array() ) );
                $date  = sprintf(
                    $date_string,
                    date_i18n( $date_format, strtotime( current_time( 'mysql' ) ) ),
                    date_i18n( $time_format, strtotime( current_time( 'mysql' ) ) )
                );
            }

            if ( ! empty( $args['args']['revisions_count'] ) ) :
                ?>
                <div class="misc-pub-section misc-pub-revisions">
                    <?php
                    /* translators: Post revisions heading. %s: The number of available revisions. */
                    echo wp_kses(
                            sprintf(  __( 'Revisions: %s' ), '<b>' . number_format_i18n( $args['args']['revisions_count'] ) . '</b>' ),
                            array( 'b' => array() )
                        );
                    ?>
                    <a class="hide-if-no-js" href="<?php echo esc_url( get_edit_post_link( $args['args']['revision_id'] ) ); ?>"><span aria-hidden="true"><?php esc_html( _ex( 'Browse', 'revisions' ) ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Browse revisions' ); ?></span></a>
                </div>
            <?php
            endif;

            if ( $can_publish ) : // Contributors don't get to choose the date of publish.
                ?>
                <div class="misc-pub-section curtime misc-pub-curtime">
                    <span id="timestamp">
                        <?php printf( $stamp, '<b>' . $date . '</b>' ); ?>
                    </span>
                </div>
            <?php
            endif;

            if ( 'draft' === $post->post_status && get_post_meta( $post_id, '_customize_changeset_uuid', true ) ) :
                ?>
                <div class="notice notice-info notice-alt inline">
                    <p>
                        <?php
                        echo wp_kses(
                                sprintf(
                                /* translators: %s: URL to the Customizer. */
                                    __( 'This draft comes from your <a href="%s">unpublished customization changes</a>. You can edit, but there&#8217;s no need to publish now. It will be published automatically with those changes.' ),
                                    esc_url(
                                        add_query_arg(
                                            'changeset_uuid',
                                            rawurlencode( get_post_meta( $post_id, '_customize_changeset_uuid', true ) ),
                                            admin_url( 'customize.php' )
                                        )
                                    )
                                ),
                                array('a' => array( 'href' => true ) )
                            );
                        ?>
                    </p>
                </div>
            <?php
            endif;

            /**
             * Fires after the post time/date setting in the Publish meta box.
             *
             * @since 2.9.0
             * @since 4.4.0 Added the `$post` parameter.
             *
             * @param WP_Post $post WP_Post object for the current post.
             */
            do_action( 'post_submitbox_misc_actions', $post );
            ?>
        </div>
        <div class="clear"></div>
        </div>

        <div id="major-publishing-actions">
            <?php
            /**
             * Fires at the beginning of the publishing actions section of the Publish meta box.
             *
             * @since 2.7.0
             * @since 4.9.0 Added the `$post` parameter.
             *
             * @param WP_Post|null $post WP_Post object for the current post on Edit Post screen,
             *                           null on Edit Link screen.
             */
            do_action( 'post_submitbox_start', $post );
            ?>
            <div id="delete-action">
                <?php
                if ( current_user_can( 'delete_post', $post_id ) ) {
                    if ( ! EMPTY_TRASH_DAYS ) {
                        $delete_text = esc_html__( 'Delete permanently' );
                    } else {
                        $delete_text = esc_html__( 'Move to Trash' );
                    }
                    ?>
                    <a class="submitdelete deletion" href="<?php echo get_delete_post_link( $post_id ); ?>"><?php echo esc_html( $delete_text ); ?></a>
                    <?php
                }
                ?>
            </div>

            <div id="publishing-action">
                <span class="spinner"></span>
                <?php
                if ( ! in_array( $post->post_status, array( 'publish', 'future', 'private' ), true ) || 0 === $post_id ) {
                    if ( $can_publish ) :
                        if ( ! empty( $post->post_date_gmt ) && time() < strtotime( $post->post_date_gmt . ' +0000' ) ) :
                            ?>
                            <input name="original_publish" type="hidden" id="original_publish" value="<?php echo esc_attr_x( 'Schedule', 'post action/button label' ); ?>" />
                            <?php submit_button( _x( 'Schedule', 'post action/button label' ), 'primary large', 'publish', false ); ?>
                        <?php
                        else :
                            ?>
                            <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Publish' ); ?>" />
                            <?php submit_button( esc_html__( 'Publish' ), 'primary large', 'publish', false ); ?>
                        <?php
                        endif;
                    else :
                        ?>
                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Submit for Review' ); ?>" />
                        <?php submit_button( esc_html__( 'Submit for Review' ), 'primary large', 'publish', false ); ?>
                    <?php
                    endif;
                } else {
                    ?>
                    <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Update' ); ?>" />
                    <?php submit_button( esc_html__( 'Update' ), 'primary large', 'save', false, array( 'id' => 'publish' ) ); ?>
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>

        </div>
        <?php
    }
}

new MetaBoxes();