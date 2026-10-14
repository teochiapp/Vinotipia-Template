<?php
defined( 'ABSPATH' ) || exit;

global $product;

// Asegurarse de que el producto sea visible
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php wc_product_class( '', $product ); ?>>
	<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link imagen-producto">

		<?php
		// Imagen destacada (sin recorte)
		echo $product->get_image( 'full' );
		?>

		<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>

		<?php
		// Excerpt personalizado
		global $post;
		if ( $post->post_excerpt ) : ?>
			<p class="woocommerce-loop-product__excerpt">
				<?php echo wp_trim_words( $post->post_excerpt, 20, '...' ); ?>
			</p>
		<?php endif; ?>

		<?php
		// Precio
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</a>

	<?php
	// Botón (añadir al carrito, etc.)
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>

<style>
.woocommerce-loop-product__excerpt {
	font-size: 1.2rem;
	font-style: italic;
	color: var(--text-black);
	margin-top: 10px;
	line-height: 1.5;
	letter-spacing: 0.5px;
}

.woocommerce-LoopProduct-link img {
	width: 100%;
	height: auto;
	object-fit: contain;
}

</style>
