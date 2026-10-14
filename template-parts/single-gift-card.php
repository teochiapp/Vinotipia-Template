<main class="single-gift-card-container">
  <div class="volver-catalogo" style="margin-bottom: 20px;">
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-volver-catalogo">← Volver al catálogo</a>
  </div>

  <?php if (have_posts()):
    while (have_posts()):
      the_post();
      global $product;
      
      // Opciones solicitadas por el cliente
      $gift_card_options = array(
          array( 'price' => 49000,  'label' => 'Tipos Sin Filtro (para 2 personas)' ),
          array( 'price' => 88000,  'label' => 'Original Gama Media (de 2 a 6 personas)' ),
          array( 'price' => 90000,  'label' => 'Edición Parejas (para 2 personas)' ),
          array( 'price' => 103000, 'label' => 'Original Gama Alta (de 2 a 6 personas)' ),
      );
      
      $first_price     = $gift_card_options[0]['price'];
      $first_price_fmt = '$' . number_format( $first_price, 0, ',', '.' );
  ?>

  <!-- FILA 1: IMAGEN + INFO/PRECIO -->
  <section class="detalle-gift-card">
    
    <!-- Columna izquierda: Imagen -->
    <div class="imagen-gift-card">
       <div class="gift-card-mockup">
         <?php 
         if ( has_post_thumbnail() ) {
             echo get_the_post_thumbnail(get_the_ID(), 'large'); 
         } else {
             echo '<img src="https://vinotipia.com/wp-content/uploads/2026/03/unnamed-1.png" alt="Gift Card Vinotipia">';
         }
         ?>
       </div>
    </div>

    <!-- Columna derecha: Título + Descripción + Instrucciones + Selector de precio -->
    <div class="contenido-gift-card">
      <h1><?php the_title(); ?></h1>
      <div class="single-product-descripcion"><?php the_excerpt(); ?></div>
      
      <div class="instrucciones-regalo">
         <p><i class="fa-solid fa-gift"></i> <strong>¿Cómo funciona?</strong></p>
         <ol>
           <li>Elegí un monto de los Kits sugeridos o ingresá el tuyo.</li>
           <li>Completá los datos y la compra.</li>
           <li>Una vez confirmado el pago, nos ponemos en contacto con vos para coordinar cómo hacerle llegar la Gift Card a quien quieras.</li>
         </ol>
      </div>

      <h3 class="form-title">1. Elegí el valor de tu regalo</h3>
      <div class="monto-opciones">
      <?php
      $first = true;
      foreach ( $gift_card_options as $option ) :
          $kit_price = $option['price'];
          $kit_price_formatted = '$' . number_format( $kit_price, 0, ',', '.' );
          $label = $option['label'];
      ?>
          <button type="button" class="monto-btn <?php echo $first ? 'active' : ''; ?>" data-val="<?php echo esc_attr( $kit_price ); ?>">
              <span class="kit-name"><?php echo esc_html( $label ); ?></span>
              <span class="kit-price"><?php echo esc_html( $kit_price_formatted ); ?></span>
          </button>
      <?php $first = false; endforeach; ?>
      </div>

      <div class="monto-personalizado">
          <label for="custom_price">O ingresá un monto personalizado:</label>
          <div class="input-wrapper">
              <span class="currency-symbol">$</span>
              <input type="number" id="custom_price" placeholder="Ej: 100.000" min="10000" step="1000">
          </div>
      </div>
    </div>
  </section>

  <!-- FILA 2: DETALLES DEL REGALO — ANCHO COMPLETO -->
  <section class="gift-details-section">
    <form class="custom-gift-card-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
      <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>">
      <input type="hidden" name="gift_card_price" id="gift_card_price" value="<?php echo esc_attr( $first_price ); ?>">

      <h3 class="form-title">2. Detalles del regalo</h3>
      <div class="gift-details-grid">
        <div class="gift-detail-field">
          <label>Para (Nombre):</label>
          <input type="text" name="gift_to" required placeholder="Nombre">
        </div>
        <div class="gift-detail-field">
          <label>De (Tu nombre):</label>
          <input type="text" name="gift_from" required placeholder="Tu nombre">
        </div>
        <div class="gift-detail-field">
          <label>Email del destinatario (Opcional):</label>
          <input type="email" name="gift_recipient_email" placeholder="email@ejemplo.com">
          <p class="gift-field-hint"><i class="fa-solid fa-circle-info"></i> Si completás este campo, le enviamos la Gift Card directamente. Si no, nos ponemos en contacto con vos para coordinar la entrega.</p>
        </div>
        <div class="gift-detail-field">
          <label>Mensaje personal (Opcional):</label>
          <textarea name="gift_message" rows="3"></textarea>
        </div>
      </div>

      <button type="submit" class="single_add_to_cart_button">
        <i class="fa-solid fa-cart-shopping"></i> Añadir al carrito — <span id="btn_total"><?php echo esc_html( $first_price_fmt ); ?></span>
      </button>
    </form>
  </section>

  <?php endwhile; endif; ?>
</main>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const btns = document.querySelectorAll('.monto-btn');
    const customInput = document.getElementById('custom_price');
    const hiddenPrice = document.getElementById('gift_card_price');
    const btnTotal = document.getElementById('btn_total');

    function updatePrice(val) {
        hiddenPrice.value = val;
        btnTotal.textContent = '$' + parseInt(val).toLocaleString('es-AR');
    }

    btns.forEach(btn => {
        btn.addEventListener('click', function() {
            btns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            customInput.value = ''; // limpiar input custom
            updatePrice(this.getAttribute('data-val'));
        });
    });

    customInput.addEventListener('input', function() {
        if(this.value) {
            btns.forEach(b => b.classList.remove('active'));
            updatePrice(this.value);
        } else {
            // si borra, volvemos al primero
            btns[0].classList.add('active');
            updatePrice(btns[0].getAttribute('data-val'));
        }
    });
});
</script>

<style>
/* Estilos para el Single de Gift Card */
.single-gift-card-container {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Sofia Sans', sans-serif;
}
/* FILA 1: Imagen + Info */
.detalle-gift-card {
    display: flex;
    gap: 50px;
    background: #fff;
    border-radius: 20px;
    padding: 50px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    align-items: flex-start;
    margin-bottom: 24px;
}
.imagen-gift-card {
    flex: 1.4;
    min-width: 280px;
    max-width: 550px;
}
.gift-card-mockup {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(89,30,43,0.15);
    border: 3px solid var(--secondary-color);
}
.gift-card-mockup img {
    width: 100%;
    height: auto;
    display: block;
    aspect-ratio: 4/3;
    object-fit: cover;
}
.gift-card-text-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(transparent, rgba(89,30,43,0.95));
    color: white;
    padding: 40px 20px 20px;
    text-align: center;
}
.gift-card-text-overlay h3 {
    margin: 0;
    font-size: 2rem;
    color: var(--secondary-color);
    text-transform: uppercase;
    letter-spacing: 3px;
    font-weight: 800;
}
.contenido-gift-card {
    flex: 1;
}
.contenido-gift-card h1 {
    color: var(--primary-color);
    font-size: 2.4rem;
    margin-top: 0;
    margin-bottom: 12px;
    font-weight: 700;
}
.instrucciones-regalo {
    background: #F9F1EA;
    padding: 20px 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    border-left: 4px solid var(--secondary-color);
}
.instrucciones-regalo p {
    color: var(--primary-color);
    margin-top: 0;
    font-size: 1.1rem;
}
.instrucciones-regalo ol {
    margin: 0;
    padding-left: 20px;
    color: #555;
    line-height: 1.6;
}
.instrucciones-regalo li { margin-bottom: 8px; }

/* Selector de precio */
.form-title {
    font-size: 1.2rem;
    color: var(--primary-color);
    margin-bottom: 12px;
    font-weight: 700;
}
.monto-opciones {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 16px;
}
.monto-btn {
    background: white;
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 12px 8px;
    cursor: pointer;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-family: 'Sofia Sans', sans-serif;
}
.monto-btn:hover { border-color: var(--secondary-color); background: #FFF4DD; }
.monto-btn.active {
    border-color: var(--secondary-color);
    background: var(--secondary-color);
    color: var(--primary-color);
    box-shadow: 0 5px 15px rgba(212,175,55,0.3);
}
.monto-btn .kit-name { font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #555; }
.monto-btn.active .kit-name { color: var(--primary-color); }
.monto-btn .kit-price { font-size: 1.1rem; font-weight: 800; }
.monto-personalizado { margin-bottom: 0; }
.monto-personalizado label { display: block; font-size: 0.95rem; color: #666; margin-bottom: 6px; }
.input-wrapper { position: relative; display: flex; align-items: center; }
.input-wrapper .currency-symbol {
    position: absolute; left: 15px;
    font-size: 1.1rem; font-weight: 700; color: var(--primary-color);
}
.monto-custom, .input-wrapper input {
    width: 100%;
    padding: 13px 15px 13px 45px !important;
    font-size: 1.1rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-family: 'Sofia Sans', sans-serif;
    transition: all 0.3s;
}
.monto-custom:focus, .input-wrapper input:focus { outline: none; border-color: var(--secondary-color); }

/* FILA 2: Detalles del regalo - ancho completo */
.gift-details-section {
    background: #fff;
    border-radius: 20px;
    padding: 40px 50px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
}
.gift-details-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}
.gift-detail-field {
    display: flex;
    flex-direction: column;
}
.gift-detail-field label {
    font-size: 0.9rem;
    color: #444;
    font-weight: 600;
    margin-bottom: 6px;
}
.gift-detail-field input,
.gift-detail-field textarea {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: 'Sofia Sans', sans-serif;
    font-size: 0.95rem;
    transition: border-color 0.2s;
    flex: 1;
}
.gift-detail-field input:focus,
.gift-detail-field textarea:focus {
    border-color: var(--primary-color);
    outline: none;
}
.gift-detail-field textarea { resize: vertical; min-height: 80px; }
.gift-field-hint {
    margin: 6px 0 0;
    font-size: 0.78rem;
    color: #888;
    font-family: 'Sofia Sans', sans-serif;
    line-height: 1.4;
    display: flex;
    align-items: flex-start;
    gap: 5px;
}
.gift-field-hint i { color: var(--secondary-color); margin-top: 2px; flex-shrink: 0; }

/* Botón */
.single_add_to_cart_button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 30px !important;
    font-size: 1rem !important;
    font-weight: 700 !important;
    border-radius: 100px !important;
    background-color: var(--primary-color-light) !important;
    color: white !important;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    cursor: pointer;
    font-family: 'Sofia Sans', sans-serif;
}
.single_add_to_cart_button:hover {
    background-color: var(--secondary-color) !important;
    color: var(--primary-color) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(89,30,43,0.18);
}

/* RESPONSIVE */
@media (max-width: 1100px) {
    .gift-details-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .detalle-gift-card {
        flex-direction: column;
        padding: 25px;
        gap: 25px;
    }
    .imagen-gift-card { max-width: 100%; }
    .monto-opciones { grid-template-columns: 1fr; }
    .gift-details-section { padding: 25px; }
    .gift-details-grid { grid-template-columns: 1fr; }
}
</style>

<?php get_footer(); ?>
