=== Google Listings & Ads ===
Contributors: automattic, google, woocommerce
Tags: woocommerce, google, listings, ads
Requires at least: 5.5
Tested up to: 5.8
Requires PHP: 7.3
Stable tag: 1.5.1
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Native integration with Google that allows merchants to easily display their products across Google’s network.

== Description ==

https://www.youtube.com/watch?v=lYCx7ZqA1uo

Google Listings & Ads makes it simple to showcase your products to shoppers across Google. Whether you’re brand new to digital advertising or a marketing expert, you can expand your reach and grow your business, for free and with ads.

Sync your store with Google to list products for free, run paid ads, and track performance straight from your store dashboard.

With Google Listings & Ads:
- **Connect your store seamlessly** with Google Merchant Center.
- **Reach online shoppers** with free listings.
- **Boost store traffic and sales** with Smart Shopping Campaigns.

= Connect your store seamlessly =

Integrate with Google Merchant Center to upload relevant store and product data to Google. Your products will sync automatically to make the information available for free listings, Google Ads, and other Google services.

Create a new Merchant Center account or link an existing one to connect your store and list products across Google for free and  with ads.

= Reach online shoppers with free listings =

Showcase eligible products to shoppers looking for what you offer and drive traffic to your store with Google’s free listings on the Shopping tab.

Your products can also appear on Google Search, Google Images, and Gmail if you’re selling in the United States.

*Learn more about supported countries for Google free listings [here](https://support.google.com/merchants/answer/10033607?hl=en).*

= Boost store traffic and sales with Google Ads =

Grow your business with Smart Shopping campaigns. Create an ad campaign to promote your products across Google Search, Shopping, YouTube, Gmail, and the Display Network.

Connect your Google Ads account, choose a budget, and launch your campaign straight from your WooCommerce dashboard. You can also review campaign analytics and access automated reports to easily see how your ads are performing.

*Learn more about supported countries and currencies for Smart Shopping campaigns [here](https://support.google.com/merchants/answer/160637#countrytable).*

= Get started with up to $150 in ad credit when you create a Google Ads account =

Get up to  $150\* in ad credit to help you get started on Smart Shopping Campaigns. The promotional code will be applied when you start spending and serve your first ad impression, and whatever you spend over the next 30 days, up to $150, will be added back to your account.

*\*Ad credit amounts vary by country and region.*

= The eligibility criteria: =
- The account has no other promotions applied.
- The account is billed to a country where Google Partners promotions are offered.
- The account served its first ad impression within the last 14 days.

*Review the static terms [here](http://www.google.com/ads/coupons/terms.html).*

== Installation ==

= Minimum Requirements =

* WordPress 5.6 or greater
* WooCommerce 5.5 or greater
* PHP version 7.3 or greater (PHP 7.4 or greater is recommended)
* MySQL version 5.6 or greater

Visit the [WooCommerce server requirements documentation](https://docs.woocommerce.com/document/server-requirements/) for a detailed list of server requirements.

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of this plugin, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “Google Listings and Ads” and click Search Plugins. Once you’ve found this plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

= Manual installation =

The manual installation method involves downloading the plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Where can I report bugs or contribute to the project? =

Bugs should be reported in the [Google Listings and Ads GitHub repository](https://github.com/woocommerce/google-listings-and-ads/).

= This is awesome! Can I contribute? =

Yes you can! Join in on our [GitHub repository](https://github.com/woocommerce/google-listings-and-ads/) :)

Release and roadmap notes available on the [WooCommerce Developers Blog](https://woocommerce.wordpress.com/)

== FAQ ==

= What is Google Merchant Center? =
The Google Merchant Center helps you sync your store and product data with Google and makes the information available for both free listings on the Shopping tab and Google Shopping Ads. That means everything about your stores and products is available to shoppers when they search on a Google property.

= Which countries are available for Google Listings & Ads? =
Learn more about supported countries for Google free listings [here](https://support.google.com/merchants/answer/10033607?hl=en).

Learn more about supported countries and currencies for Smart Shopping campaigns [here](https://support.google.com/merchants/answer/160637#countrytable).

= Where will my products appear? =
If you’re selling in the US, then eligible free listings can appear in search results across Google Search, Google Images, and the Google Shopping tab. If you're selling outside the US, free listings will appear on the Shopping tab.

If you’re running a Smart Shopping campaign, your approved products can appear on Google Search, the Shopping tab, Gmail, Youtube and the Google Display Network.

= What are Smart Shopping campaigns? =
Smart Shopping campaigns are Google Ads that combine Google’s machine learning with automated bidding and ad placements to maximize conversion value and strategically display your ads to people searching for products like yours, at your given budget. The best part? You only pay when people click on your ad.

= How much do Smart Shopping campaigns cost? =
Smart Shopping campaigns are pay-per-click, meaning you only pay when someone clicks on your ads. You can customize your daily budget in Google Listings & Ads but we recommend starting off with the suggested minimum budget, and you can change this budget at any time.

= Can I run both free listings and Smart Shopping campaigns at the same time? =
Yes, you can run both at the same time, and we recommend it! In the US, advertisers running free listings and ads together have seen an average of over 50% increase in clicks and over 100% increase in impressions on both free listings and ads on the Shopping tab. Your store is automatically opted into free listings automatically and can choose to run a paid Smart Shopping campaign.

== Changelog ==

= 1.5.1 - 2021-10-13 =
* Update - Changed minimum version of WordPress to 5.6 and WooCommerce to 5.5.
* Fix - Change the way of getting WooCommerce admin settings to fix a compatibility issue in WooCommerce 5.8.
* Tweak - WooCommerce 5.8 compatibility.

= 1.5.0 - 2021-10-01 =
* Add - Verify user's phone number via SMS or phone call at the last step of the onboarding flow and on the settings page. And update the verified phone number to user's connected Google Merchant Center account.
* Add - Allow backorder stock availability for products.
* Add - Set pre-order availability for products using the WooCommerce Pre-Orders extension.
* Add - Warning notice when the Ads' currency is different from the store's one.
* Add - Unit tests for the Merchant Google Service class.
* Fix - Retry Merchant account creation after detecting invalid terms.
* Fix - Render Ads Account's currency in Dashboard's table.
* Fix - Don't render `DifferentCurrencyNotice` when the Ads account is disconnected.
* Fix - Limit the number of synced additional product images to 10.
* Fix - Split contact information settings page to phone and address settings.
* Fix - Update phone number and store address pages flow.
* Fix - Correct spelling/capitalization of "WordPress.com".
* Fix - PHP notice when creating a product variation.
* Fix - Bump E2E-related devDeps, bump tested WC version.
* Tweak - Hide channel visibility box and attributes tab if the setup is not completed.
* Tweak - Added a few more e2e tests and utils.
* Tweak - WC 5.7 compatibility.

= 1.4.3 - 2021-09-08 =
* Fix - PHP notice when creating a product variation.
* Tweak - Hide channel visibility box and attributes tab if the setup is not completed.

[See changelog for all versions](https://raw.githubusercontent.com/woocommerce/google-listings-and-ads/trunk/changelog.txt).
