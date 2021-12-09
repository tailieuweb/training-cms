=== Plugin Name ===
Contributors: peachpay, eboxnet
Donate link: https://peachpay.app
Tags: products slider, random, related products, slider, woocommerce
Requires at least: 4.0
Tested up to: 5.8
Stable tag: 3.3.11
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display random related products in a slider based on product category, tag, or attribute on every product page.

== Description ==

Display fresh, random WooCommerce related products on every single product page load (in a slider or not) based on the current product's category, tags, or attributes.

Related products can be configured to display in posts, pages, and sidebar widgets, and can be configured to exclude categories.

Use the shortcode **`[woo-related]`** for product pages or **`[woo-related id='XX']`** / **`[woo-related product-id='XX' show-title='no']`** for posts, pages, and widgets.

Exclude taxonomies using the the option field in the settings page.

The shortcode accepts id, title and number.

### Shortcode examples

`
[woo-related id='15']
`

will display related products based on product ID 15.

`
[woo-related id='15' title='no']
`

is the same as above but will hide Related Products title. For sidebars, etc. you can use the widget title.

`
[woo-related id='15' title='no' number='1']
`

is the same as above but will return only 1 product.

`
[woo-related]
`

will use current product's ID. This should be used on product pages only.

### Related Products for WooCommerce can help you:

- Display real related products (using a slider or not)
- Set the related product's heading text (you can use HTML)
- Set the number of related products you want to display or disable them
- Set category or tag based related products
- Display related products using Flexslider
- Translate related products heading text
- Exclude taxonomies from your related products
- Use a shortcode to add related products to posts/pages and widgets

### Related Products block position

#### Move related products

Related Products for WooCommerce uses WordPress hooks to display related products on product pages. If you need to move the related products block you can remove the action and add it again using a different hook or priority. This is extremly helpful if you code your own theme or child theme.

To remove related products block you can use

`
remove_action( 'woocommerce_after_single_product', 'wrprrdisplay' );
`

in your theme's **functions.php** file.

If you want to add it again you can do something like this

`
add_action( 'woocommerce_after_single_product', 'wrprrdisplay', 55 );
`

or

`
add_action( 'ANY-OTHER-HOOK', 'wrprrdisplay', PRIORITY );
`

Check GitHub for all [single product page actions](https://github.com/woocommerce/woocommerce/blob/master/templates/content-single-product.php).

### Demo

You can see a [demo of the plugin here](http://woorelated.eboxnet.com).

### Requirements

- [WooCommerce](https://wordpress.org/plugins/woocommerce/)

### Plugin setup

1. Install the plugin—visit the [installation tab](https://wordpress.org/plugins/woo-related-products-refresh-on-reload/#installation) for more info
2. Use the plugin's option page, located in the WooCommerce menu, to set up the plugin

### Support

- Feel free to use the [support forum](https://wordpress.org/support/plugin/woo-related-products-refresh-on-reload/), and we will get back to you as soon as possible.

== Changelog ==

### 3.3.11 (11/09/2021)
* Docs - Revise plugin listing description

### 3.3.2 - 3.3.10 (08/10/2021 - 09/21/2021)
* Dev - Refactor and clean up code; update documentation

### 3.3.1 (06/29/2018)
* Fix - Function (re)name

### 3.3.0 (03/21/2017)
* Fix - Conflicts
* Dev - Related products will not include out of stock items

### 3.2.8 (10/01/2017)
* Fix - Relate by Attribute
* Tweak - Moved action out of the Class

### 3.2.5 (08/29/2017)
* Dev - Shortcode Refactor

### 3.2.2 (08/29/2017)
* Tweak - Slider HTML edits

### 3.2.1 (08/28/2017)
* Tweak - Undefined variable fix

### 3.2.0 (08/27/2017)
* Dev - Added the abillity to exclude taxonomies
* Dev - Added [woo-related] shortcode
* Tweak - Added woo-related-products-container CSS class to main div
* Tweak - Added woo-related-shortcode CSS class to shortcode's main div

### 3.1.0 (07/25/2017)
* Dev - Added the abillity to translate default H2

### 3.0.5 (07/12/2017)
* Tweak - Added CSS class to H2

### 3.0.5 (07/08/2017)
* Dev - WooCommerce 3.x functions

### 3.0.0 (01/23/2017)
* Dev - Relate Products by Product Attributes
* Tweak - Add Style rules

### 2.3.0 (11/22/2016)
* Tweak - Remove / Edit Functions
* Tweak - Remove / Add Style rules
* Dev - Add Owl-Carousel (boosts compatibility)
* Dev - Remove Flexslider

### 2.2.3 (11/11/2016)
* Dev - New options to control slider navigation and autoplay
* Tweak - Enable flexslider directionNav (previus - next buttons)

### 2.2.0 (11/11/2016)
* Fix - Final fix to make smooth the transition from 1.x to 2.x

### 2.1.5 (11/11/2016)
* Fix - Fix to avoid re post of plugin's options after upgrading to 2.x [Check forum post] (https://wordpress.org/support/topic/woo-related-products-version-2-0-x/)

### 2.1.1 (11/10/2016)
* Tweak - Conditional include of libraries

### 2.1 (11/10/2016)
* Fix - Slider ul fix for a few themes

### 2.0.1 (11/10/2016)
* Tweak - Option for 3 related products

### 2.0 (11/10/2016)
* Dev - Related products Slider
* Dev - Multi category & tags support
* Tweak - Improve Code
* Tweak - Exclude current product from related products
* Fix - Error for products with no category or tag

### 1.0 - 1.9
* Fix - Bug Fixes
* Dev - Add more options
* Dev - Initial Release

== Installation ==

### Automatic installation

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of Related Products for WooCommerce, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “Woo Related Products” and click Search Plugins. Once you’ve found the plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

### Manual installation

The manual installation method involves downloading Related Products for WooCommerce plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Updating

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.
