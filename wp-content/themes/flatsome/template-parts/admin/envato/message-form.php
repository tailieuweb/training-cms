<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="POST">
	<?php wp_nonce_field( 'flatsome_envato_migrate', 'flatsome_envato_migrate_nonce' ); ?>
	<input type="hidden" name="action" value="flatsome_envato_migrate" />
	<div class="notice notice-info notice-alt notice-large inline" style="display:block!important">
		<p>
			Flatsome supports registering with an Envato token to receive theme updates.
		</p>
		<p>
			<button class="button button-primary">Register with token</button>
		</p>
		<p class="description">
			<small>This will clear your purchase code.</small>
		</p>
	</div>
</form>
