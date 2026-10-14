<section class="kit-includes">
  <div class="kit-content">
    <div class="kit-header">
      <p class="subtitle">UN TESORO EN UNA CAJA</p>
      <h2>¿Qué incluye el <strong>kit</strong>?</h2>
    </div>

    <div class="kit-items">
      <?php if (have_rows('repetidor_de_partes_del_kit')): ?>
        <?php while (have_rows('repetidor_de_partes_del_kit')):
          the_row(); ?>
          <div class="kit-item">
            <img src="<?php the_sub_field('imagen_kit'); ?>" alt="Botellas de vino">
            <p>
              <?php the_sub_field('titulo_repetidor_kit'); ?>
            </p>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</section>