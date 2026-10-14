<?php get_header(); ?>

<section id="hero">
    <?php get_template_part('template-parts/home/hero'); ?>
</section>

<section id="about" data-aos="fade-up" data-aos-delay="100">
    <?php get_template_part('template-parts/home/about'); ?>
</section>

<section id="kit-includes" data-aos="fade-up" data-aos-delay="300">
    <?php get_template_part('template-parts/home/kit-includes'); ?>
</section>

<section id="how-it-works" data-aos="fade-up" data-aos-delay="200">
    <?php get_template_part('template-parts/home/how-it-works'); ?>
</section>

<section id="catalogue" data-aos="fade-up" data-aos-delay="500">
    <?php get_template_part('template-parts/home/catalogue'); ?>
</section>

<section id="reviews" data-aos="fade-up" data-aos-delay="500" style="padding: 4rem 2rem;">
    <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
</section>

<section id="product-parts" data-aos="fade-up" data-aos-delay="400">
    <?php get_template_part('template-parts/home/product-parts'); ?>
</section>

<section id="cta-section" data-aos="fade-up" data-aos-delay="500">
    <?php get_template_part('template-parts/home/cta-section'); ?>
</section>

<section id="experience" data-aos="fade-up" data-aos-delay="600">
    <?php get_template_part('template-parts/home/experience'); ?>
</section>

<section id="tamara-hero" data-aos="fade-up" data-aos-delay="700">
    <?php get_template_part('template-parts/home/tamara-hero'); ?>
</section>

<section id="contact" data-aos="fade-up" data-aos-delay="800">
    <?php get_template_part('template-parts/home/contact'); ?>
</section>

<?php get_footer(); ?>