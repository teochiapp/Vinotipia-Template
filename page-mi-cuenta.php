<?php
get_header();
?>
<main class="container <?php echo (is_account_page() && is_user_logged_in()) ? 'cuenta-logueado' : 'cuenta-login'; ?>">
  <?php
  while (have_posts()) : the_post();
    the_content(); // Esto es FUNDAMENTAL para que aparezca el contenido (como el shortcode)
  endwhile;
  ?>
</main>

<?php
get_footer();
?>

<!-- CSS movido a /assets/css/my-account.css -->