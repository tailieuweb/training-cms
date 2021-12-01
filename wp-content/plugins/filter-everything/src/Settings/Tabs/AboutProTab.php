<?php


namespace FilterEverything\Filter;

if ( ! defined('WPINC') ) {
    wp_die();
}

class AboutProTab extends BaseSettings{

    protected $page = 'wpc-filter-about-pro';

    protected $group = 'wpc_filter_about_pro';

    protected $optionName = 'wpc_filter_about_pro';

    public function init()
    {
        add_action( 'admin_init', array( $this, 'initSettings') );
    }

    public function initSettings()
    {
        register_setting($this->group, $this->optionName);
        add_action('wpc_before_sections_settings_fields', array( $this, 'aboutProInfo' ) );
    }

    public function aboutProInfo( $page ){

        if( $this->page == $page ){

            echo '<p><a href="'.esc_url(FLRT_PLUGIN_LINK).'" target="_blank">';
                echo '<img src="'.esc_url( FLRT_PLUGIN_URL . 'assets/img/pro-logo.jpg').'" width="320" height="auto" />';
            echo '</a></p>'."\n";

            echo '<p class="wpc-about-pro-explanation-message">';
                echo wp_kses(
                    __('The Filter Everything plugin plugin is also available in a professional version<br /> which includes additional features such as clean URLs, ability to customize SEO,<br /> individual Filter Sets for pages and other great features.', 'filter-everything'),
                    array( 'br' => array() )
                    );
                echo '<br /><a href="'.esc_url(FLRT_PLUGIN_LINK).'" target="_blank">'.esc_html__('Read more', 'filter-everything').'</a>';
            echo '</p>'."\n";

?>
        <table class="comparison-table" border="1" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <th valign="top" class="first-td"></th>
                <th valign="top" class="second-td"><p><?php esc_html_e('PRO', 'filter-everything' ); ?></p></th>
                <th valign="top" class="third-td"><p><?php echo wp_kses(
                        __('Current<br />version', 'filter-everything'),
                        array('br' => array())
                        ); ?></p></th>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Filters any Post Type (posts, products etc)', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="yes"></span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Supports AJAX', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="yes"></span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Count, dynamic recount in terms', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="yes"></span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Sorting widget', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="yes"></span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Custom URL prefixes for filters', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="yes"></span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Filtering by Taxonomies, Custom Fields, Post Author', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes rectification-star"></span></td>
                <td valign="top"><span class="yes"></span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Compatibility with any Page builder', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Filtering Custom WP Queries', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Clean URLs and Permalinks', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Smart filtering by Woo product variations', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('SEO Rules, indexing filtering result pages by Search Engines', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Individual Filter Sets for any pages and archives', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Special Pop-up Filters widget for Mobile Devices', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
            </tr><tr>
                <td valign="top"><?php esc_html_e('Individual AJAX containers for Filter Sets', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Hide filter if all terms are empty', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Stars for Product rating filter', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr>
                <td valign="top"><?php esc_html_e('Premium support', 'filter-everything' ); ?></td>
                <td valign="top"><span class="yes"></span></td>
                <td valign="top"><span class="no">—</span></td>
            </tr>
            <tr class="table-downloading-links">
                <td valign="top"></td>
                <td valign="top"><p><a href="<?php echo esc_url(FLRT_PLUGIN_LINK.'/?get_pro=true') ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Get PRO', 'filter-everything' ); ?></a></p></td>
                <td valign="top"></td>
            </tr>
            </tbody>
        </table>
<?php
        }
    }

    public function getLabel()
    {
        return esc_html__('About PRO', 'filter-everything');
    }

    public function getName()
    {
        return 'aboutpro';
    }

    public function valid()
    {
        return true;
    }
}