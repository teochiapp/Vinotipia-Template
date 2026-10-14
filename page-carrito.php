<?php
get_header();
?>

<main class="container-pagina">
  <div class="volver-catalogo">
    <a href="<?php echo site_url('/tienda'); ?>" class="btn-volver">← Volver al catálogo</a>
  </div>

  <div class="contenido-pagina">
    <?php
    while (have_posts()) : the_post();
      the_content();
    endwhile;
    ?>
  </div>
</main>

<?php
get_footer();
?>

<!-- CSS movido a /assets/css/cart.css -->