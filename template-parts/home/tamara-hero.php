<section class="tamara-hero-section" id="quienes-somos">
  <div class="tamara-hero-content">
    <h2>
      <?php echo get_field("titulo_banner"); ?><span class="line-break"><br /></span>
      <?php echo get_field("final_del_titulo"); ?>
    </h2>
    <p>
     <?php echo get_field("primer_parrafo"); ?>
    </p>
    <p>
     <?php echo get_field("segundo_parrafo"); ?>
    </p>
    <p>
     <?php echo get_field("tercer_parrafo"); ?>
    </p>
  </div>
  <div class="tamara-hero-image">
    <img class="tamara-imagen" src="<?php echo get_field("imagen_persona"); ?>" alt="Tamara Rolfo" />
    <img class="tamara-bg" src="<?php echo get_field("imagen_atras_de_la_persona"); ?>" alt="Tamara BG" />
  </div>
</section>
