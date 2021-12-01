<?php
/**
 * @var \FilterEverything\Filter\TabInterface[] $tabs
 */

if ( ! defined('WPINC') ) {
    wp_die();
}

?>
<div class="wrap">
    <h1><?php esc_html_e( 'Filters Settings', 'filter-everything' ) ?></h1>
    <h2 class="nav-tab-wrapper">
		<?php foreach ( $tabs as $tab ): ?>
			<?php if ( $tab->valid() ): ?>
				<?php
                $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                $tabUrl   = admin_url( 'edit.php?post_type=filter-set&page=filters-settings&tab=' . $tab->getName() );
                ?>
                <a class='nav-tab<?php echo esc_attr( $class ); ?>'
                   href='<?php echo esc_url( $tabUrl ); ?>'><?php echo esc_html($tab->getLabel()) ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
    </h2>
	<?php echo $current->render() //already escaped in the method ?>
</div>