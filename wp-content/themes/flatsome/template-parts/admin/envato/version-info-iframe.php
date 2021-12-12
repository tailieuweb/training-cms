<?php iframe_header(); ?>

<div id="wpwrap" class="flatsome-panel" style="text-align:center;">
	<a href="<?php echo esc_url( $url ); ?>#item-description__change-log" style="display:inline-block;" target="_blank" rel="noopener noreferrer">
		<div class="wp-badge fl-badge">
			<?php /* translators: 1: Version. */ ?>
			<?php echo sprintf( __( 'Version %s', 'flatsome' ), $version ); ?>
		</div>
		<div style="margin-top:8px;">
			<?php echo __( 'Read change log here', 'flatsome' ); ?>
		</div>
	</a>
</div>

<?php iframe_footer(); ?>
