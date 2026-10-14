<div class="how-it-works-section">

  <div class="how-header">
    <h3 class="how-title"><?php echo get_field("titulo_como_funciona"); ?></h3>
    <div class="how-pills">
      <!-- Jugadores -->
      <span class="how-pill">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M7.50012 16.8748C9.36408 16.8748 10.8751 15.3637 10.8751 13.4998C10.8751 11.6358 9.36408 10.1248 7.50012 10.1248C5.63616 10.1248 4.12512 11.6358 4.12512 13.4998C4.12512 15.3637 5.63616 16.8748 7.50012 16.8748Z"
            stroke="#F9F1EA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <path
            d="M16.5001 9.37476C18.3641 9.37476 19.8751 7.86372 19.8751 5.99976C19.8751 4.13579 18.3641 2.62476 16.5001 2.62476C14.6362 2.62476 13.1251 4.13579 13.1251 5.99976C13.1251 7.86372 14.6362 9.37476 16.5001 9.37476Z"
            stroke="#F9F1EA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <path
            d="M11.6251 13.8748C11.6251 12.3748 12.7501 9.37476 16.5001 9.37476C20.2501 9.37476 21.3751 12.3748 21.3751 13.8748M2.62512 21.3748C2.62512 19.8748 3.75012 16.8748 7.50012 16.8748C11.2501 16.8748 12.3751 19.8748 12.3751 21.3748"
            stroke="#F9F1EA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        </svg> 2 – 6 Catadores
      </span>
      <!-- Tiempo -->
      <span class="how-pill">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
          style="flex-shrink:0">
          <path
            d="M11.9998 13V9M20.9998 6L18.9998 4M9.99982 2H13.9998M11.9998 21C9.87808 21 7.84325 20.1571 6.34296 18.6569C4.84267 17.1566 3.99982 15.1217 3.99982 13C3.99982 10.8783 4.84267 8.84344 6.34296 7.34315C7.84325 5.84285 9.87808 5 11.9998 5C14.1215 5 16.1564 5.84285 17.6567 7.34315C19.157 8.84344 19.9998 10.8783 19.9998 13C19.9998 15.1217 19.157 17.1566 17.6567 18.6569C16.1564 20.1571 14.1215 21 11.9998 21Z"
            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg> 1 hs – ∞
      </span>
      <!-- Edad -->
      <span class="how-pill">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M17.25 12C17.8467 12 18.419 12.2371 18.841 12.659C19.2629 13.081 19.5 13.6533 19.5 14.25V15C19.5 17.9565 16.71 21 12 21C7.29 21 4.5 17.9565 4.5 15V14.25C4.5 13.6533 4.73705 13.081 5.15901 12.659C5.58097 12.2371 6.15326 12 6.75 12H17.25ZM12 2.25C13.094 2.25 14.1432 2.6846 14.9168 3.45818C15.6904 4.23177 16.125 5.28098 16.125 6.375C16.125 7.46902 15.6904 8.51823 14.9168 9.29182C14.1432 10.0654 13.094 10.5 12 10.5C10.906 10.5 9.85677 10.0654 9.08318 9.29182C8.3096 8.51823 7.875 7.46902 7.875 6.375C7.875 5.28098 8.3096 4.23177 9.08318 3.45818C9.85677 2.6846 10.906 2.25 12 2.25Z"
            stroke="#F9F1EA" stroke-width="1.5" />
        </svg>

        +18
      </span>
    </div>
  </div>

  <div class="how-cards-wrapper">
    <?php if (have_rows('repetidor_tarjetas')): ?>
      <?php while (have_rows('repetidor_tarjetas')):
        the_row();
        $numero = get_sub_field('numero_repeater');
        $descripcion = get_sub_field('descripcion');
        $imagen = get_sub_field('imagen_repeater');
        ?>
        <div class="how-card">
          <div class="how-number"><?= esc_html($numero); ?></div>
          <img src="<?= esc_url($imagen); ?>" alt="Paso <?= esc_attr($numero); ?>">
          <p class="how-text"><?= $descripcion; ?></p>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>