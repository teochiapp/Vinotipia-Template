<section class="tasting-section">
  <div class="tasting-content">
    <div class="tasting-text">
      <p><?php echo get_field("titulo_cta"); ?></p>
      <p class="cta-description">Ideal para vinotecas y eventos corporativos.</p>
      <div class="tasting-buttons">
        <?php
        $boton = get_field('boton_cta');
        if ($boton): ?>
          <a class="button cta-button" href="<?php echo esc_url($boton['url']); ?>"
            target="<?php echo esc_attr($boton['target']); ?>">
            <?php echo esc_html($boton['title']); ?></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="tasting-graphic">
      <div class="circle">
        <img src="<?php echo get_field("primer_imagen_del_circulo_del_cta"); ?>" class="icon icon-eye">
        <img src="<?php echo get_field("segunda_imagen_del_circulo_del_cta"); ?>" class="icon icon-hand">
        <img src="<?php echo get_field("tercera_imagen_del_circulo_del_cta"); ?>" class="icon icon-nose">
        <img src="<?php echo get_field("cuarta_imagen_del_circulo_del_cta"); ?>" class="icon icon-mouth">
        <img src="<?php echo get_field("quinta_imagen_del_circulo_del_cta"); ?>" class="icon icon-wine">
      </div>
    </div>
  </div>
</section>