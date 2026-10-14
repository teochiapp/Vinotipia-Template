<?php
/**
 * Template Part: Product Card
 * Usado en archive-product.php y en el AJAX callback
 * Requiere: $post, $product globales seteados correctamente
 */

global $product;
if ( ! $product ) $product = wc_get_product( get_the_ID() );
if ( ! $product || ! $product->is_visible() ) return;

$es_variable    = $product->is_type( 'variable' ) || $product->get_slug() === 'gift-card' || has_term( 'combos', 'product_cat', $product->get_id() );
$sticker        = get_field( 'imagen_triada' );
$cantidad_vinos = get_field( 'cantidad_vinos', $product->get_id() );
$extra_class    = isset( $extra_class ) ? $extra_class : '';

if ( $product->get_slug() === 'gift-card' ) {
    $extra_class .= ' product-is-gift-card';
}

// Badge de jugadores basado en categorías
$terms     = get_the_terms( $product->get_id(), 'product_cat' );
$cat_slugs = [];
if ( $terms && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        $cat_slugs[] = $term->slug;
    }
}

$badge_text = '';
if ( array_intersect( ['vinotipia-tipos', 'edicion-especial', 'para-2'], $cat_slugs ) ) {
    $badge_text = '2 Jugadores';
} elseif ( array_intersect( ['kits-esenciales', 'para-grupos', 'triadas'], $cat_slugs ) ) {
    $badge_text = '2 a 6 Jugadores';
}
// Slugs de categorías del producto (para filtrado client-side)
$cat_slugs_str = implode( ' ', $cat_slugs );
?>
<section class="bloque-producto <?php echo esc_attr( $extra_class ); ?>" data-cat-slugs="<?php echo esc_attr( $cat_slugs_str ); ?>">

  <?php if ( $badge_text ) : ?>
    <div class="badge-jugadores"><?php echo esc_html( $badge_text ); ?></div>
  <?php endif; ?>

  <a href="<?php the_permalink(); ?>" class="imagen-producto">
    <?php if ( $sticker ) : ?>
      <img src="<?php echo esc_url( $sticker ); ?>" alt="<?php the_title_attribute(); ?>" class="imagen-triada-archive">
    <?php endif; ?>
    <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>" class="archive-product-image">
  </a>

  <div class="info-producto">
    <h2><a href="<?php the_permalink(); ?>" class="titulo-link"><?php the_title(); ?></a></h2>

    <div class="archive-product-descripcion"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>

    <?php if ( $cantidad_vinos ) : ?>
      <span class="archive-product-cantidad-vinos">
        <span>Incluye:</span> <?php echo esc_html( $cantidad_vinos ); ?>
      </span>
    <?php endif; ?>

    <p class="archive-product-precio">
      <?php echo $product->get_price_html(); ?>
    </p>

    <div class="buttons-container">
      <a href="<?php the_permalink(); ?>" class="archive-ver-detalle-btn">Ver detalles</a>

      <?php if ( $es_variable ) : ?>
        <a href="<?php the_permalink(); ?>" class="archive-agregar-carrito-btn" aria-label="Agregar al carrito">
          <i class="fas fa-cart-plus"></i>
        </a>
      <?php else : ?>
        <button type="button"
          class="archive-agregar-carrito-btn ajax_add_to_cart add_to_cart_button"
          data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
          data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
          data-quantity="1"
          aria-label="Agregar al carrito: <?php echo esc_attr( $product->get_name() ); ?>">
          <i class="fas fa-cart-plus"></i>
        </button>
      <?php endif; ?>
    </div>
  </div>

</section>
