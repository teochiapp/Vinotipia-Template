<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?></title>

  <?php if (function_exists('rank_math_the_canonical_url')): ?>
    <link rel="canonical" href="<?php echo rank_math_the_canonical_url(); ?>" />
  <?php endif; ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans:ital,wght@0,1..1000;1,1..1000&display=block"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="preload" as="image" href="<?php echo site_url(); ?>/wp-content/uploads/2025/06/unnamed.png">

  <link rel="icon" href="<?php echo get_site_icon_url(); ?>" sizes="32x32" />
  <link rel="manifest" href="/site.webmanifest">
  <meta name="facebook-domain-verification" content="406m4rlvdi1if5szkdq1recdlnbek9" />

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-5KP2WE3W12"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-5KP2WE3W12');
  </script>

  <!-- Meta Pixel Code -->
  <script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1374058147384818');
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1374058147384818&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Meta Pixel Code -->

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php if (is_front_page()): ?>

    <?php get_template_part('template-parts/home/top-header'); ?>

    <div class="hero-container" <?php if (!is_404()): ?> style="background:var(--primary-color)" <?php endif; ?>>

      <!-- ✅ Header para la página de inicio -->
      <header class="site-header inicio">
        <a href="<?php echo site_url(); ?>">
          <img src="<?php echo site_url(); ?>/wp-content/uploads/2025/06/unnamed.png" class="logo" alt="Logo del sitio" />
        </a>

        <button class="menu-toggle" aria-label="Abrir menú">
          <i class="fas fa-bars"></i>
        </button>

        <nav class="main-nav">
          <ul>
            <li><a href="#about">¿Qué es?</a></li>
            <li><a href="#kit-includes">¿Qué incluye?</a></li>
            <li><a href="#how-it-works">Como se juega</a></li>
            <li><a href="#catalogue">Nuestros Kits</a></li>
            <li><a href="#quienes-somos">¿Quiénes somos?</a></li>
            <li><a href="<?php echo site_url('/preguntas-frecuentes/'); ?>">Preguntas Frecuentes</a></li>
            <div class="header-social-icons">
              <a href="https://wa.me/5493564578554" aria-label="WhatsApp" target="_blank"><i
                  class="fab fa-whatsapp"></i></a>
              <a href="https://www.instagram.com/vinotipiaok/" aria-label="Instagram" target="_blank"><i
                  class="fab fa-instagram"></i></a>
              <a href="https://www.tiktok.com/@vinotipia" aria-label="TikTok" target="_blank"><i
                  class="fab fa-tiktok"></i></a>
            </div>
          </ul>
        </nav>
      </header>

    <?php else: ?>
      <header class="site-header paginas">
        <!-- Logo -->
        <a href="<?php echo site_url(); ?>" class="logo-link">
          <img src="<?php echo site_url(); ?>/wp-content/uploads/2025/06/unnamed.png" class="logo" alt="Logo del sitio" />
        </a>

        <!-- Íconos de navegación -->
        <nav class="icon-nav">
          <a href="<?php echo site_url(); ?>" aria-label="Inicio">
            <i class="fas fa-home"></i>
          </a>
          <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" aria-label="Mi cuenta">
            <i class="fas fa-user"></i>
          </a>
          <a href="<?php echo wc_get_cart_url(); ?>" class="cart-icon" aria-label="Carrito">
            <i class="fas fa-shopping-cart"></i>
            <?php $count = WC()->cart->get_cart_contents_count(); ?>
            <?php if ($count > 0): ?>
              <span class="cart-count"><?php echo esc_html($count); ?></span>
            <?php endif; ?>
          </a>
        </nav>
      </header>
    <?php endif; ?>


    <div class="menu-overlay"></div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.querySelector(".menu-toggle");
        if (!toggleButton) return;
        
        const nav = document.querySelector(".main-nav");
        const icon = toggleButton.querySelector("i");
        const body = document.body;
        const overlay = document.querySelector(".menu-overlay");

        function closeMenu() {
          nav.classList.remove("open");
          icon.classList.add("fa-bars");
          icon.classList.remove("fa-times");
          body.classList.remove("no-scroll");
          overlay.classList.remove("active");
        }

        toggleButton.addEventListener("click", () => {
          const isOpen = nav.classList.toggle("open");
          icon.classList.toggle("fa-bars");
          icon.classList.toggle("fa-times");

          if (isOpen) {
            body.classList.add("no-scroll");
            overlay.classList.add("active");
          } else {
            body.classList.remove("no-scroll");
            overlay.classList.remove("active");
          }
        });

        overlay.addEventListener("click", closeMenu);

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            closeMenu();
            setTimeout(() => {
              if (target) {
                const elementPosition = target.getBoundingClientRect().top + window.scrollY;
                window.scrollTo({
                  top: elementPosition - 130,
                  behavior: "smooth"
                });
              }
            }, 300);
          });
        });
      });
    </script>

    <?php if (is_404()): ?>
      <style>
        .site-header {
          background-color: var(--primary-color-light);
        }

        .logo {
          padding: 20px 0;
        }
      </style>
    <?php endif; ?>