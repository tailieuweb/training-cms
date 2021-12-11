<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<link href="/your-path-to-fontawesome/css/all.css" rel="stylesheet"> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
	
		<div class="col-full dayne">
		<div class="footer-widgets column-two grid-item">
			
			<div class="row">
  <div class="col-sm-4"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
  <div class="col-sm-8">
	  <h2>Liên hệ</h2>
 <div class="face">
	 <a href="facebook.com"><i class="fab fa-facebook-square" style="color:3399FF;">facebook</i></a><br> <br>
 <a href=""><messenger class="com" ></messenger><i class="fab fa-facebook-messenger" style="color:3399FF;">messenger</i></a><br><br>

 <a href="google.com"> <i class="fab fa-google-plus">google</i></a>

 </div>

 
 <p>địa chỉ 40/35 phước long b quận 9 thành phố HCM</p>
 <p>sdt: <span>031231231231</span></p>

</div>

</div>
<div class"footer1" style="text-align:center; font-size: 14px;color:#999999;" >
	<h3 style="color:#999999;">ShopSale</h3>
	<p>&copy; 2021 Công ty cổ phần sale Entertainment </p>
</div>

		

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
