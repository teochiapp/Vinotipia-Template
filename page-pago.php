<?php
/* Template Name: Checkout personalizado */
get_header();
?>

<main class="checkout-container">
  <h1 class="checkout-title">Finalizar compra</h1>

  <div class="woocommerce">
    <?php echo do_shortcode('[woocommerce_checkout]'); ?>
  </div>
</main>

<?php get_footer(); ?>

<!-- CSS movido a /assets/css/checkout.css -->
