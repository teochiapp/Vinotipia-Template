<div class="about-wrapper" id="about">
  <img class="image-about-left" src="<?php echo get_field("imagen_de_la_izquierda"); ?>">
  
  <div class="about-container">
    <div class="content-about">
      <h3 class="about-title"><?php echo get_field("titulo_about"); ?></h3>
      <p class="about-subtitle"><?php echo get_field("subtitulo_about"); ?>
      </p>
      <p class="about-description">
        <?php echo get_field("descripcion_about"); ?>
        <img class="about-separator" src="<?php echo get_field("imagen_separador"); ?>">
        <?php echo get_field("footer_about"); ?>
          <strong class="footer-about-desktop"><?php echo get_field("footer_about_final"); ?></strong>
          <strong class="footer-about-mobile"><?php echo get_field("footer_about_final_mobile"); ?></strong>
      </p>
    </div>
  </div>

  <img class="image-about-right" src="<?php echo get_field("imagen_de_la_derecha"); ?>">
</div>
