<?php get_header(); ?>

<!-- ===== SHOP HERO (ancho completo, fuera del container) ===== -->
<div class="shop-hero-section">
  <div class="shop-hero-content">
    <p class="shop-eyebrow">Un juego de cata a ciegas</p>
    <h1>Descubrí qué vino sos.</h1>
    <p class="shop-description">Probás sin ver la etiqueta y elegís desde lo que sentís.</p>
    <p class="shop-question">¿Cómo querés jugar?</p>
    <div class="shop-chips">
      <?php
      $chips = [
          ['slug' => 'para-grupos',   'icon' => 'fa-champagne-glasses', 'label' => 'Para grupos'],
          ['slug' => 'para-2',        'icon' => 'fa-heart',             'label' => 'Para dos'],
          ['slug' => 'para-regalar',  'icon' => 'fa-gift',              'label' => 'Para regalar'],
          ['slug' => 'segui-jugando', 'icon' => 'fa-rotate-right',      'label' => 'Seguí jugando'],
          ['slug' => 'combos',        'icon' => 'fa-box-open',          'label' => 'Combos'],
      ];
      
      $first_active = true;
      foreach ($chips as $chip) {
          $term = get_term_by('slug', $chip['slug'], 'product_cat');
          // Solo mostrar si existe la categoría y tiene al menos 1 producto publicado
          if ($term && $term->count > 0) {
              $active_class = $first_active ? 'active' : '';
              echo '<button class="chip-btn ' . esc_attr($active_class) . '" data-slug="' . esc_attr($chip['slug']) . '">';
              echo '<i class="fa-solid ' . esc_attr($chip['icon']) . '"></i> ' . esc_html($chip['label']);
              echo '</button>';
              $first_active = false;
          }
      }
      ?>
    </div>
  </div>
</div>

<main class="archive-container">

  <!-- ===== LOADER ===== -->
  <div class="shop-loader" id="shop-loader">
    <div class="shop-loader__spinner"></div>
    <span>Cargando productos...</span>
  </div>

  <!-- ===== GRID DE PRODUCTOS ===== -->
  <div id="productos-grid" class="container-catalogo">
    <?php
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );
    $all_products = new WP_Query( $args );

    if ( $all_products->have_posts() ) {
        while ( $all_products->have_posts() ) {
            $all_products->the_post();
            global $product;
            $product = wc_get_product( get_the_ID() );
            get_template_part( 'template-parts/product-card' );
        }
        wp_reset_postdata();
    } else {
        echo '<p style="grid-column:1/-1;text-align:center;padding:3rem;">No hay productos disponibles por el momento.</p>';
    }
    ?>
  </div>

  <!-- ===== TESTIMONIOS ===== -->
  <div class="reviews-tienda">
    <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
  </div>

</main>

<?php get_footer(); ?>
