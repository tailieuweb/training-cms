<?php
/**
 * The API module.
 *
 * @package WooCommerce\PayPalCommerce\ApiClient
 */

declare(strict_types=1);

namespace WooCommerce\PayPalCommerce\ApiClient;

use Dhii\Container\ServiceProvider;
use Dhii\Modular\Module\ModuleInterface;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

/**
 * Class ApiModule
 */
class ApiModule implements ModuleInterface {

	/**
	 * Sets up the module.
	 *
	 * @return ServiceProviderInterface
	 */
	public function setup(): ServiceProviderInterface {
		return new ServiceProvider(
			require __DIR__ . '/../services.php',
			require __DIR__ . '/../extensions.php'
		);
	}

	/**
	 * Runs the module.
	 *
	 * @param ContainerInterface $container The container.
	 */
	public function run( ContainerInterface $container ): void {
		add_action(
			'woocommerce_after_calculate_totals',
			function ( \WC_Cart $cart ) {
				$fees = $cart->fees_api()->get_fees();
				WC()->session->set( 'ppcp_fees', $fees );
			}
		);
	}

	/**
	 * Returns the key for the module.
	 *
	 * @return string|void
	 */
	public function getKey() {
	}
}
