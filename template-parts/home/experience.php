<section class="experience">
  <div class="intro">
    <h2><?php echo get_field("titulo_experiencia"); ?></h2>
    <p><?php echo get_field("subtitulo_experiencia"); ?></p>
    <a href="#contact" class="button">Quiero saber más</a>
  </div>

  <div class="experience-grid">
    <?php if (have_rows('repetidor_de_experiencia')): ?>
      <?php while (have_rows('repetidor_de_experiencia')): the_row(); ?>
        <div class="four-card">
          <div class="contentheigth">
            <img src="<?php the_sub_field('imagen_experiencia'); ?>">
            <div class="contentText">
              <h3><?php the_sub_field('titulo_repetidor_experiencia'); ?></h3>
              
              <p class="textplus"> <?php the_sub_field('primer_parrafo'); ?><br>
              <em><?php the_sub_field('segundo_parrafo'); ?><br>
              <small><?php the_sub_field('tercer_parrafo'); ?></small></p>
              </em>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>
