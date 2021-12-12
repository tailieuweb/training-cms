<?php if ( ! empty( $errors ) ) : ?>
	<?php foreach ( $errors as $error ) : ?>
		<div class="notice notice-error notice-alt inline" style="display:block!important">
			<p><?php echo $error; ?></p>
		</div>
	<?php endforeach; ?>
<?php elseif ( $token ) : ?>
	<div class="notice notice-success notice-alt inline" style="display:block!important;margin-bottom:15px!important">
		<p><?php echo __( 'Your token <strong>is valid</strong>. Thank you! Enjoy Flatsome and one-click updates.', 'flatsome' ) ?></p>
	</div>
<?php endif; ?>

<?php if ( ! $is_registered && $args['show_intro'] ) : ?>
<p>
	Enter your Envato token.
	<a href="<?php echo esc_attr( flatsome_envato()->get_create_token_url() ) ?>" target="_blank">
		Generate a token here.
	</a>
</p>
<?php endif; ?>

<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="POST" autocomplete="off" onsubmit="return onFlatsomeEnvatoSubmit(this);">
	<?php wp_nonce_field( 'flatsome_envato_register', 'flatsome_envato_register_nonce' ); ?>
	<input type="hidden" name="action" value="flatsome_envato_register" />
	<p>
		<?php if ( $is_registered ) : ?>
			<input type="text" value="<?php echo esc_attr( $token ) ?>" class="code" style="width:100%; padding:10px;" readonly>
		<?php else : ?>
			<input type="text" id="token" name="flatsome_envato_token" value="<?php echo esc_attr( $token ) ?>" class="code" placeholder="Token ( e.g. anfVrl8LDedSCPKp8ElRjOyVIhL90YjC )" style="width:100%; padding:10px;">
		<?php endif; ?>
	</p>
	<?php if ( $args['show_terms'] ) : ?>
		<?php if ( $is_registered ) : ?>
		<input type="hidden" name="flatsome_envato_terms" value="1" />
		<?php else : ?>
		<p>
			<input type="checkbox" <?php checked( $is_confirmed ); ?> id="flatsome_envato_terms" name="flatsome_envato_terms"  onclick="onFlatsomeEnvatoAgree(this);">
			<label for="flatsome_envato_terms" style="display: inline-block;vertical-align: top;width: 90%;margin-top: 2px;font-size: 14px">
				Confirm that, according to the Envato License Terms, each license entitles one person for a single project.
				Creating multiple unregistered installations is a copyright violation.
				<a href="https://themeforest.net/licenses/standard" target="_blank">More info</a>.
			</label>
		</p>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( $args['show_submit'] ) : ?>
	<p>
		<?php if ( $is_registered ) : ?>
		<input type="submit" class="button button-large button-primary" value="Unregister"/>
		<?php else : ?>
		<input type="submit" class="button button-large button-primary" value="Register"/>
		<?php endif; ?>
	</p>
	<?php endif; ?>
</form>

<script type="text/javascript">
function onFlatsomeEnvatoSubmit(form){
	<?php if ( $is_registered ) : ?>
	if (!confirm("<?php echo wp_slash( __( 'Are you sure you want to unregister Flatsome?', 'flatsome' ) ) ?>")) {
		return false;
	}
	<?php else : ?>
	if (!form.flatsome_envato_terms.checked) {
		form.flatsome_envato_terms.parentNode.style.color = "#dc3232";
		return false;
	}
	<?php endif; ?>
	return true;
}
function onFlatsomeEnvatoAgree(input) {
	input.parentNode.style.removeProperty("color");
	var button = document.getElementById("envato-activate");
	if (button) {
		if (input.checked) {
			button.classList.remove("disabled");
		} else {
			button.classList.add("disabled");
		}
	}
}
</script>
