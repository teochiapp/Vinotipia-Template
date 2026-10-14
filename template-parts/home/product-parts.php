 <section class="vinotipia-container">
    <div class="vinotipia-image">
      <img src="<?php the_field("image_partes_de_producto")?>" alt="Copas de vino">
    </div>
    <div class="vinotipia-text">
  <h2><?php the_field("titulo_partes_del_producto")?></h2>
  <ul class="vinotipia-list">
  <?php if( have_rows('partes_del_producto') ): ?>
    <?php while( have_rows('partes_del_producto') ): the_row(); ?>
      <li>
        <span class="num"><?php the_sub_field('numero_de_la_parte'); ?></span>
        <div>
          <strong><?php the_sub_field('titulo_de_la_parte'); ?></strong>
          <p><?php the_sub_field('descripcion_de_la_parte'); ?></p>
        </div>
      </li>
    <?php endwhile; ?>
  <?php endif; ?>
</ul>
</div>
  </section>