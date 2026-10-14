<section class="vinotipia-contact" style="background: linear-gradient(90deg, #591E2B 42.78%, rgba(89, 30, 43, 0) 100.02%), url('<?php echo get_field("imagen_contacto")?>'); background-blend-mode: multiply; background-size: cover; background-position: center;">
  <div class="contact-content">
    <h4><?php echo get_field("titulo_contacto"); ?></h4>
    <h2><?php echo get_field("subtitulo_contacto"); ?></h2>
    <p><?php echo get_field("parrafo_contacto"); ?>.</p>

    <?php echo do_shortcode('[wpforms id="43"]'); ?>
  </div>
</section>
