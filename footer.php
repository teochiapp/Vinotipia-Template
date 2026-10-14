<?php get_template_part('template-parts/popup-bienvenida'); ?>
<?php wp_footer(); ?>
</body>
<footer class="footer">
  <div class="contentFooter">

    <div class="footer-left">
      <div class="footer-logo-container">
        <img src="<?php echo site_url(); ?>/wp-content/uploads/2025/06/unnamed.png" class="footer-logo" alt="vinotipia">
      </div>
      <p class="footer-description">
        Experiencias sensoriales que emocionan,
        fidelizan y transforman a través del vino.
      </p>
    </div>

    <img src="<?php echo site_url(); ?>/wp-content/uploads/2025/06/footer.png" class="footer-img" alt="vinotipia">

    <div class="footer-right-columns">

      <nav class="footer-nav">
        <a href="<?php echo home_url('#hero'); ?>">Inicio</a>
        <a href="<?php echo home_url('#about'); ?>">Experiencia</a>
        <a href="<?php echo home_url('#kit-includes'); ?>">Beneficios</a>
        <a href="<?php echo home_url('#experience'); ?>">Impacto</a>
        <a href="<?php echo home_url('#contact'); ?>">Contacto</a>
      </nav>

      <div class="footer-right-end">

        <div class="footer-right">
          <div class="footer-contact-section"></div>
          <strong class="footer-contact">Contacto</strong>
          <p><a href="mailto:contacto@vinotipia.com">contacto@vinotipia.com</a></p>
        </div>

        <div class="footer-social-section">
          <strong>Seguinos</strong>
          <div class="footer-social-icons">
            <a href="https://wa.me/5493564578554" aria-label="WhatsApp" target="_blank"><i class="fab fa-whatsapp"></i></a>
            <a href="https://www.instagram.com/vinotipiaok/" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/company/vinotipia" aria-label="LinkedIn" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.facebook.com/vinotipia" aria-label="Facebook" target="_blank"><i class="fab fa-facebook"></i></a>
          </div>
        </div>

      </div>
    </div>
  </div>
</footer>

</html>

<script>
  !function (f, b, e, v, n, t, s) {
    if (f.fbq) return; n = f.fbq = function () {
      n.callMethod ?
        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
    n.queue = []; t = b.createElement(e); t.async = !0;
    t.src = v; s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
  }(window, document, 'script',
    'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1374058147384818');
  fbq('track', 'PageView');

  // Smooth Scroll for Footer Links
  document.addEventListener("DOMContentLoaded", function () {
    const footerLinks = document.querySelectorAll(".footer-nav a");
    footerLinks.forEach(link => {
      link.addEventListener("click", function (e) {
        const url = new URL(this.href);
        const hash = url.hash;

        if (hash && (url.pathname === "/" || url.pathname === window.location.pathname)) {
          const target = document.querySelector(hash);
          if (target) {
            e.preventDefault();
            window.scrollTo({
              top: target.offsetTop - 80,
              behavior: "smooth"
            });
          }
        }
      });
    });

    // Video Modal Logic
    const videoTrigger = document.getElementById("video-trigger");
    const videoModal = document.getElementById("videoModal");
    const videoContainer = document.getElementById("videoContainer");
    const closeModal = document.querySelector(".video-modal-close");

    if (videoTrigger && videoModal && videoContainer) {
      videoTrigger.addEventListener("click", function (e) {
        e.preventDefault();
        const videoUrl = this.getAttribute("data-video-url");

        // Inyectar video dinámicamente para optimización
        videoContainer.innerHTML = `
          <video autoplay controls loop playsinline>
            <source src="${videoUrl}" type="video/mp4">
            Tu navegador no soporta el elemento de video.
          </video>
        `;

        videoModal.classList.add("active");
      });

      function closeVideoModal() {
        videoModal.classList.remove("active");
        videoContainer.innerHTML = ""; // Limpiar video para optimizar y detener audio
      }

      closeModal.addEventListener("click", closeVideoModal);

      videoModal.addEventListener("click", function (e) {
        if (e.target === videoModal) {
          closeVideoModal();
        }
      });

      // Cerrar con Escape
      document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && videoModal.classList.contains("active")) {
          closeVideoModal();
        }
      });
    }
  });
</script>
<noscript>
  <img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1374058147384818&ev=PageView&noscript=1" />
</noscript>