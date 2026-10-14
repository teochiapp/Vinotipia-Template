<?php get_header(); ?>

<?php 
global $post;
if ( $post && $post->post_name === 'gift-card' ) {
    get_template_part('template-parts/single', 'gift-card');
    return;
}
if ( has_term('combos', 'product_cat', $post->ID) ) {
    get_template_part('template-parts/single', 'combo');
    return;
}
?>
<main class="single-product-container">
  <div class="volver-catalogo" style="margin-bottom: 20px;">
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-volver-catalogo">← Volver al
      catálogo</a>
  </div>
  <?php if (have_posts()):
    while (have_posts()):
      the_post();
      global $product; ?>
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
          <?php $cantidad_vinos = get_field('cantidad_vinos', $product->get_id()); ?>
          <?php if ($cantidad_vinos) : ?>
            <div class="single-product-cantidad-vinos">
              <span>Incluye:</span> <?php echo esc_html($cantidad_vinos); ?>
            </div>
          <?php endif; ?>
          <?php
          $cats_producto   = wp_get_post_terms( get_the_ID(), 'product_cat', array('fields' => 'slugs') );
          $es_tipos        = in_array('vinotipia-tipos', $cats_producto);
          $es_edicion      = in_array('edicion-especial', $cats_producto);
          // Triadas = kits-esenciales; Edición Parejas = edicion-especial
          // Vinotipia Tipos = vinotipia-tipos
          ?>
          
          <?php if (!$es_tipos && get_field("respuesta_excerpt")) : ?>
            <div class="single-product-descripcion-respuesta"><?php the_field("respuesta_excerpt"); ?></div>
          <?php endif; ?>
          
          <div class="woocommerce-product-formulario">
            <?php woocommerce_template_single_add_to_cart(); ?>
          </div>

          <!-- PREGUNTAS FRECUENTES (dinámicas según categoría) -->

          <?php if ($es_tipos) : ?>
          <!-- FAQ: Vinotipia Tipos · Sin Filtro -->
          <div class="preguntas-frecuentes preguntas-frecuentes--tipos">
            <p class="faq-label">Preguntas frecuentes</p>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Y si no sé nada de vino?</summary>
              <p class="pregunta-respuesta">Justamente por eso. Acá no hay respuestas correctas, se trata de sentir.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Y si ya sé de vino?</summary>
              <p class="pregunta-respuesta">Mejor todavía. A ciegas, adivinar la cepa es un desafío hasta para los que saben. Te vas a sorprender.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Para cuántas personas es?</summary>
              <p class="pregunta-respuesta">Para dos.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Lo puedo regalar?</summary>
              <p class="pregunta-respuesta">Sí. Es el regalo perfecto: regalá vino sin tener idea de vino.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Cómo llega?</summary>
              <p class="pregunta-respuesta">Con envío a todo el país, listo para abrir y jugar.</p>
            </details>
          </div>

          <?php elseif ($es_edicion) : ?>
          <!-- FAQ: Edición Parejas -->
          <div class="preguntas-frecuentes preguntas-frecuentes--parejas">
            <p class="faq-label">Preguntas frecuentes</p>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Y si no sé nada de vino?</summary>
              <p class="pregunta-respuesta">Mejor. No hay respuestas correctas, se trata de sentir.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Para cuántas personas es?</summary>
              <p class="pregunta-respuesta">Para jugar en pareja (2 personas).</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Lo puedo regalar?</summary>
              <p class="pregunta-respuesta">Sí, es ideal para regalar. Llega listo en su caja.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Cómo llega?</summary>
              <p class="pregunta-respuesta">Con envío a todo el país, listo para abrir y jugar.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Por qué cuesta lo que cuesta?</summary>
              <p class="pregunta-respuesta">Viene listo con 2 copas y todo el kit para una cata a ciegas. Es una experiencia distinta en pareja y un regalo que se recuerda.</p>
            </details>
          </div>

          <?php else : ?>
          <!-- FAQ: Triadas -->
          <div class="preguntas-frecuentes preguntas-frecuentes--triadas">
            <p class="faq-label">Preguntas frecuentes</p>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Y si no sé nada de vino?</summary>
              <p class="pregunta-respuesta">Mejor. No hay respuestas correctas, se trata de sentir.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Y si ya sé de vino?</summary>
              <p class="pregunta-respuesta">Mejor todavía. A ciegas, adivinar la cepa es un desafío hasta para los que saben. Te vas a sorprender.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Para cuántas personas es?</summary>
              <p class="pregunta-respuesta">De 2 a 6 personas.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Lo puedo regalar?</summary>
              <p class="pregunta-respuesta">Sí. Es ideal para regalar cuando querés regalar algo más que vino. Si no sabés qué recorrido elegir, podés regalar una Gift Card y dejar que la persona elija.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Cómo llega?</summary>
              <p class="pregunta-respuesta">Recibís todo listo para abrir y jugar. Enviamos a todo el país. Solo necesitás reunir a tu gente, descorchar y dejarte sorprender.</p>
            </details>
            <details class="pregunta-item">
              <summary class="pregunta-titulo">¿Por qué cuesta lo que cuesta?</summary>
              <p class="pregunta-respuesta">Porque no estás comprando tres botellas. Estás comprando lo que pasa alrededor de ellas. Una experiencia diseñada para jugar, conversar, sorprenderse y descubrir qué vino te representa. Todo llega listo para que vos solo tengas que abrir la caja y disfrutar.</p>
            </details>
          </div>
          <?php endif; ?>

          <div class="product-shipping-info">
            Envío disponible a todo el país<br>Envío gratis a San Francisco, Córdoba
          </div>
        </div>
      </section>

      <section class="tabs-producto">
        <div class="tab-buttons">
          <div class="tab-btn active" data-tab="descripcion">Descripción</div>
          <div class="tab-btn" data-tab="otros">Otros productos</div>
          <div class="tab-btn" data-tab="valoraciones">Valoraciones</div>
        </div>

        <div class="tab-content active" id="descripcion">
          <?php the_content(); ?>
          <?php if ($product->has_weight()): ?>
            <li><strong>Peso:</strong> <?php echo wc_format_weight($product->get_weight()); ?></li>
          <?php endif; ?>

          <?php if ($product->has_dimensions()): ?>
            <li><strong>Dimensiones:</strong> <?php echo wc_format_dimensions($product->get_dimensions(false)); ?></li>
          <?php endif; ?>
        </div>

        <div class="tab-content" id="otros">
          <h3 class="otros-productos">
            También te puede interesar
          </h3>
          <div class="productos-relacionados">
            <?php 
            $cats = wp_get_post_terms( get_the_ID(), 'product_cat', array('fields' => 'slugs') );
            $cat_slugs = (!empty($cats) && !is_wp_error($cats)) ? implode(',', $cats) : 'para-dos';
            echo do_shortcode('[products limit="3" columns="3" category="' . esc_attr($cat_slugs) . '" orderby="rand"]'); 
            ?>
          </div>
        </div>

        <div class="tab-content" id="valoraciones">
          <?php comments_template(); ?>
        </div>
      </section>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>


<!-- CSS movido a /assets/css/single-product.css -->

<!-- JavaScript movido a /assets/js/single-product.js -->