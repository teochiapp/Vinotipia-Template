<?php 
// Plantilla específica para productos de categoría "Combos"
get_header(); 
global $product;
?>

<main class="single-product-container single-combo-container">
  <div class="volver-catalogo" style="margin-bottom: 20px;">
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-volver-catalogo">← Volver al catálogo</a>
  </div>
  
  <section class="detalle-producto">
    <div class="imagen-triada-container product-gallery-container">
      <?php 
      $attachment_ids = $product->get_gallery_image_ids();
      $main_image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
      
      if ( $attachment_ids && !empty($attachment_ids) ) {
        echo '<div class="product-gallery-thumbnails">';
        
        // Primer thumbnail (Imagen principal)
        echo '<div class="gallery-thumbnail active" data-image-url="' . esc_url($main_image_url) . '">';
        echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
        echo '</div>';

        // Resto de la galería
        foreach ( $attachment_ids as $attachment_id ) {
          $full_image_url = wp_get_attachment_image_url( $attachment_id, 'large' );
          echo '<div class="gallery-thumbnail" data-image-url="' . esc_url($full_image_url) . '">';
          echo wp_get_attachment_image( $attachment_id, 'thumbnail' );
          echo '</div>';
        }
        
        echo '</div>';
      }
      ?>

      <?php 
      $sticker = get_field('imagen_triada', $product->get_id());
      if ($sticker): ?>
          <img src="<?php echo esc_url($sticker); ?>" class="imagen-triada" alt="">
      <?php endif; ?>

      <div class="imagen-detalle main-image-wrapper">
        <?php 
          echo get_the_post_thumbnail(get_the_ID(), 'large', ['id' => 'main-product-image']); 
        ?>
      </div>
    </div>

    <div class="contenido-detalle">
      <h1><?php the_title(); ?></h1>
      <p class="single-product-precio"><?php echo $product->get_price_html(); ?></p>
      <div class="single-product-descripcion"><?php the_excerpt(); ?></div>
      <div class="single-product-descripcion-respuesta"><?php the_field("respuesta_excerpt"); ?></div>
      
      <div class="woocommerce-product-formulario">
        <style>
          .single-combo-container form.cart {
              flex-direction: column !important;
              align-items: stretch !important;
              flex-wrap: wrap !important;
          }
          .single-combo-container .quantity-add-wrapper {
              display: flex !important;
              flex-direction: row !important;
              gap: 15px !important;
              width: 100% !important;
          }
        </style>
        <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
            
            <div class="combo-selection-wrapper" style="margin: 25px 0; padding: 20px; border: 2px solid var(--primary-color-light); border-radius: 12px; background: #FFF4DD;">
                <h3 style="margin-top:0; margin-bottom: 8px; font-size: 1.2rem; color: var(--primary-color);">Elegí tu Kit Vinotipia Original</h3>
                <p style="font-size: 0.95rem; color: #555; margin-bottom: 12px; font-family: 'Sofia Sans', sans-serif;">Seleccioná qué kit querés incluir en este combo:</p>
                <select name="selected_combo_kit" style="width: 100%; padding: 12px 15px; border-radius: 8px; border: 1px solid #ccc; font-family: 'Sofia Sans', sans-serif; font-size:1rem; cursor: pointer;" required>
                    <option value="">-- Desplegar para seleccionar --</option>
                    <?php
                    // Obtenemos los productos de la categoría "Para grupos"
                    $kits = wc_get_products( array(
                        'status' => 'publish',
                        'limit' => -1,
                        'category' => array('para-grupos'),
                    ) );
                    foreach ( $kits as $kit ) {
                        echo '<option value="' . esc_attr( $kit->get_name() ) . '">' . esc_html( $kit->get_name() ) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
            
            <div class="quantity-add-wrapper" style="display:flex; flex-direction:column; gap: 15px; align-items:flex-start; width: 100%;">
                <?php
                woocommerce_quantity_input(
                    array(
                        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
                    )
                );
                ?>

                <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt" style="width: 100%;"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
            </div>
            
            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
        </form>
      </div>

      <!-- FAQ: Combos -->
      <div class="preguntas-frecuentes preguntas-frecuentes--combos">
        <p class="faq-label">Preguntas frecuentes</p>
        <details class="pregunta-item">
          <summary class="pregunta-titulo">¿Qué incluye el combo?</summary>
          <p class="pregunta-respuesta">Incluye 1 kit Vinotipia original (el que selecciones arriba) + 1 kit Vinotipia Tipos Sin Filtro.</p>
        </details>
        <details class="pregunta-item">
          <summary class="pregunta-titulo">¿Y si no sé nada de vino?</summary>
          <p class="pregunta-respuesta">Mejor. No hay respuestas correctas, se trata de sentir.</p>
        </details>
        <details class="pregunta-item">
          <summary class="pregunta-titulo">¿Lo puedo regalar?</summary>
          <p class="pregunta-respuesta">Sí, es ideal para regalar. Llegan listos en su caja.</p>
        </details>
        <details class="pregunta-item">
          <summary class="pregunta-titulo">¿Cómo llega?</summary>
          <p class="pregunta-respuesta">Con envío a todo el país, listos para abrir y jugar.</p>
        </details>
      </div>

      <div class="product-shipping-info">
        Envío disponible a todo el país<br>Envío gratis a San Francisco, Córdoba
      </div>
    </div>
  </section>

  <section class="tabs-producto">
    <div class="tab-buttons">
      <div class="tab-btn active" data-tab="descripcion">Descripción</div>
      <div class="tab-btn" data-tab="valoraciones">Valoraciones</div>
    </div>

    <div class="tab-content active" id="descripcion">
      <?php the_content(); ?>
    </div>

    <div class="tab-content" id="valoraciones">
      <?php comments_template(); ?>
    </div>
  </section>
</main>

<!-- JS / CSS específicos del single product normal sirven perfecto acá -->
<?php get_footer(); ?>
