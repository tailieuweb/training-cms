<?php
/**
 * Layout Name: Collapsible List
 *
 * @package   PT_Content_Views
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$random_id		 = PT_CV_Functions::string_random();
$heading		 = isset( $fields_html[ 'title' ] ) ? $fields_html[ 'title' ] : '';
unset( $fields_html[ 'title' ] );

// Get link
$matches = array();
preg_match( '/href="([^"]+)"/', $heading, $matches );
$href	 = !empty( $matches[ 1 ] ) ? "href='" . esc_url( $matches[ 1 ] ) . "' onclick='event.preventDefault()'" : '';
?>

<div class="panel-heading">
    <a class="panel-title" data-toggle="cvcollapse" data-parent="#<?php echo esc_attr( PT_CV_PREFIX_UPPER . 'ID' ); ?>" data-target="#<?php echo esc_attr( $random_id ); ?>" <?php echo $href; ?>>
		<?php
		// Remove title wrapper and anchor tags, remain original post's title
		$tt = tag_escape( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-title-tag' ) );
		echo preg_replace( array( '/<(' . $tt . '|a)[^>]*>/i', '/<\/(' . $tt . '|a)>/i' ), '', $heading );
		?>
	</a>
	<?php
	echo apply_filters( PT_CV_PREFIX_ . 'scrollable_toggle_icon', '' );
	?>
</div>
<div id="<?php echo esc_attr( $random_id ); ?>" class="panel-collapse collapse <?php echo esc_attr( PT_CV_PREFIX_UPPER . 'CLASS' ); ?>">
	<div class="panel-body">
		<?php
		echo implode( "\n", $fields_html );
		?>
	</div>
</div>