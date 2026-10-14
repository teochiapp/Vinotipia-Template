<?php

/* ============================================================
   VINOTIPO QUIZ â€” SISTEMA DE TRACKING ANÃ“NIMO
   Guarda el arquetipo elegido + timestamp + IP hasheada.
   Sin cookies, sin cuentas, sin molestias para el usuario.
============================================================ */

/**
 * 1. Crear tabla al activar el tema (o si no existe).
 */
function vinotipia_crear_tabla_tracking() {
    global $wpdb;
    $tabla  = $wpdb->prefix . 'vinotipo_resultados';
    $charset = $wpdb->get_charset_collate();

    // Solo crea si no existe
    if ( $wpdb->get_var( "SHOW TABLES LIKE '$tabla'" ) !== $tabla ) {
        $sql = "CREATE TABLE $tabla (
            id         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            arquetipo  VARCHAR(20)         NOT NULL,
            fecha      DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
            ip_hash    VARCHAR(64)         NOT NULL DEFAULT '',
            PRIMARY KEY (id),
            KEY arquetipo (arquetipo),
            KEY fecha (fecha)
        ) $charset;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
add_action( 'init', 'vinotipia_crear_tabla_tracking' );

/**
 * 2. AJAX handler â€” disponible para usuarios NO logueados.
 *    Endpoint: admin-ajax.php?action=vinotipo_guardar_resultado
 */
add_action( 'wp_ajax_nopriv_vinotipo_guardar_resultado', 'vinotipo_guardar_resultado_cb' );
add_action( 'wp_ajax_vinotipo_guardar_resultado',        'vinotipo_guardar_resultado_cb' );
function vinotipo_guardar_resultado_cb() {
    // Verificar nonce
    if ( ! check_ajax_referer( 'vinotipo_track', 'nonce', false ) ) {
        wp_send_json_error( 'nonce invÃ¡lido', 403 );
    }

    $permitidos = [
        'pinot','sauvblanc','syrah','cabsauv',
        'tempranillo','cabfranc','chardonnay','malbec','merlot'
    ];
    $arquetipo = isset( $_POST['arquetipo'] ) ? sanitize_key( $_POST['arquetipo'] ) : '';

    if ( ! in_array( $arquetipo, $permitidos, true ) ) {
        wp_send_json_error( 'arquetipo invÃ¡lido', 400 );
    }

    global $wpdb;
    $tabla = $wpdb->prefix . 'vinotipo_resultados';
    // Hash SHA-256 de la IP â€” anÃ³nimo pero permite deduplicar por sesiÃ³n si quisieras
    $ip_hash = hash( 'sha256', $_SERVER['REMOTE_ADDR'] ?? '' );

    $wpdb->insert( $tabla, [
        'arquetipo' => $arquetipo,
        'fecha'     => current_time( 'mysql' ),
        'ip_hash'   => $ip_hash,
    ] );

    wp_send_json_success( [ 'ok' => true ] );
}

/**
 * 3. Pasar ajaxurl + nonce al template del test de forma segura.
 */
add_action( 'wp_enqueue_scripts', 'vinotipia_localizar_test_tracking' );
function vinotipia_localizar_test_tracking() {
    // Solo en la pÃ¡gina del test (template name)
    if ( ! is_page_template( 'page-test.php' ) ) return;

    // Preconnect a Google Fonts (mejora velocidad de carga)
    add_action( 'wp_head', function() {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    }, 1 );

    // Enqueue correcto de las fuentes del test
    wp_enqueue_style(
        'vinotipo-test-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;1,500&family=Sofia+Sans+Condensed:wght@300;400;500;600&family=Shippori+Mincho:wght@400;500&display=block',
        [],
        null
    );

    // Script inline mÃ­nimo para tracking (no necesita archivo externo)
    // Nota: vinotipiaTrack (ajaxurl + nonce) se inyecta directo en page-test.php vÃ­a PHP.
}

/**
 * 4. PÃ¡gina de estadÃ­sticas en el admin de WordPress.
 *    Acceso: MenÃº "Vinotipo â†’ EstadÃ­sticas del Test".
 */
add_action( 'admin_menu', 'vinotipia_admin_stats_menu' );
function vinotipia_admin_stats_menu() {
    add_menu_page(
        'EstadÃ­sticas â€” Vinotipo Test',
        'Vinotipo Test',
        'manage_options',
        'vinotipo-stats',
        'vinotipia_admin_stats_page',
        'dashicons-chart-bar',
        30
    );
}
function vinotipia_admin_stats_page() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'vinotipo_resultados';

    // Totales por arquetipo
    $totales = $wpdb->get_results(
        "SELECT arquetipo, COUNT(*) AS total
         FROM $tabla
         GROUP BY arquetipo
         ORDER BY total DESC",
        ARRAY_A
    );

    // Total general
    $grand_total = array_sum( array_column( $totales ?? [], 'total' ) );

    // Ãšltimas 50 respuestas
    $recientes = $wpdb->get_results(
        "SELECT arquetipo, fecha FROM $tabla ORDER BY fecha DESC LIMIT 50",
        ARRAY_A
    );

    // Nombres amigables
    $nombres = [
        'pinot'       => 'Pinot Noir',
        'sauvblanc'   => 'Sauvignon Blanc',
        'syrah'       => 'Syrah',
        'cabsauv'     => 'Cabernet Sauvignon',
        'tempranillo' => 'Tempranillo',
        'cabfranc'    => 'Cabernet Franc',
        'chardonnay'  => 'Chardonnay',
        'malbec'      => 'Malbec',
        'merlot'      => 'Merlot',
    ];
    ?>
    <div class="wrap">
      <h1 style="font-family:Georgia,serif;color:#7C252E;">ðŸ· EstadÃ­sticas â€” Test del Vinotipo</h1>

      <?php if ( empty( $totales ) ) : ?>
        <p>TodavÃ­a no hay resultados registrados. Una vez que alguien complete el test, aparecerÃ¡n aquÃ­.</p>
      <?php else : ?>

        <h2>DistribuciÃ³n de arquetipos <small style="font-weight:400;color:#666;">(<?php echo $grand_total; ?> tests completados)</small></h2>

        <style>
          .vt-bar-wrap { margin: 24px 0 40px; }
          .vt-row { display:flex; align-items:center; gap:12px; margin-bottom:10px; font-family:sans-serif; font-size:14px; }
          .vt-label { width:180px; text-align:right; color:#333; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
          .vt-bar-bg { flex:1; background:#f0ebe3; border-radius:3px; height:24px; position:relative; }
          .vt-bar-fill { height:100%; background:linear-gradient(90deg,#7C252E,#DEB968); border-radius:3px; transition:width .4s; }
          .vt-count { min-width:56px; color:#555; }
        </style>

        <div class="vt-bar-wrap">
          <?php foreach ( $totales as $row ) :
            $nombre  = $nombres[ $row['arquetipo'] ] ?? $row['arquetipo'];
            $pct     = $grand_total > 0 ? round( ($row['total'] / $grand_total) * 100, 1 ) : 0;
          ?>
          <div class="vt-row">
            <span class="vt-label"><?php echo esc_html($nombre); ?></span>
            <div class="vt-bar-bg">
              <div class="vt-bar-fill" style="width:<?php echo $pct; ?>%"></div>
            </div>
            <span class="vt-count"><?php echo $row['total']; ?> <small>(<?php echo $pct; ?>%)</small></span>
          </div>
          <?php endforeach; ?>
        </div>

        <h2>Ãšltimos 50 resultados</h2>
        <table class="widefat striped" style="max-width:480px;">
          <thead><tr><th>Arquetipo</th><th>Fecha y hora</th></tr></thead>
          <tbody>
            <?php foreach ( $recientes as $r ) : ?>
            <tr>
              <td><?php echo esc_html( $nombres[ $r['arquetipo'] ] ?? $r['arquetipo'] ); ?></td>
              <td><?php echo esc_html( $r['fecha'] ); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      <?php endif; ?>
    </div>
    <?php
}
/* ============================================================ */

function vinotipia_enqueue_styles() {
    // Encola el main.css organizado
    wp_enqueue_style(
        'vinotipia-main', // Handle del estilo
        get_template_directory_uri() . '/assets/css/main.css', // Ruta al archivo main.css
        array(), // Dependencias
        filemtime( get_template_directory() . '/assets/css/main.css' ) // Cache busting automÃ¡tico al modificar el archivo
    );

    // Encola woocommerce.css directamente para evitar cachÃ© en el @import
    wp_enqueue_style(
        'vinotipia-woocommerce',
        get_template_directory_uri() . '/assets/css/woocommerce.css',
        array('vinotipia-main'),
        filemtime( get_template_directory() . '/assets/css/woocommerce.css' ) // Cache busting automÃ¡tico al modificar el archivo
    );

    // Encola utilities.css directamente para evitar cachÃ© en el @import
    wp_enqueue_style(
        'vinotipia-utilities',
        get_template_directory_uri() . '/assets/css/utilities.css',
        array('vinotipia-main'),
        filemtime( get_template_directory() . '/assets/css/utilities.css' ) // Cache busting automÃ¡tico al modificar el archivo
    );
}
add_action( 'wp_enqueue_scripts', 'vinotipia_enqueue_styles', 99 );


function cargar_font_awesome() {
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'cargar_font_awesome');

// Cargar JavaScript especÃ­fico para single product
function vinotipia_enqueue_scripts() {
    if (is_product()) {
        wp_enqueue_script(
            'vinotipia-single-product',
            get_template_directory_uri() . '/assets/js/single-product.js',
            array('jquery'),
            filemtime( get_template_directory() . '/assets/js/single-product.js' ), // Cache busting automÃ¡tico al modificar el archivo
            true
        );
        
        // Enqueue de los estilos aquÃ­ para evitar problemas de cachÃ© con los @import
        wp_enqueue_style(
            'vinotipia-single-product-css',
            get_template_directory_uri() . '/assets/css/single-product.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/single-product.css' ) // Cache busting automÃ¡tico al modificar el archivo
        );
    }
}
add_action('wp_enqueue_scripts', 'vinotipia_enqueue_scripts');

function add_aos_animation_scripts() {
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css');
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), null, true);

    // Inicia AOS
  wp_add_inline_script('aos-js', 'AOS.init({ once: true });');

}
add_action('wp_enqueue_scripts', 'add_aos_animation_scripts');

function mi_tema_registrar_menus() {
    register_nav_menus(
        array(
            'menu-principal' => __( 'MenÃº Principal' ),
        )
    );
}
add_action( 'after_setup_theme', 'mi_tema_registrar_menus' );

function mi_tema_soporte_woocommerce() {
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mi_tema_soporte_woocommerce');

add_action('init', function () {
    if (!is_page(array('contacto', 'formulario')) && !is_admin()) {
        remove_action('wp_loaded', 'wpforms_lite', 9);
    }
});

function diferir_scripts_wpforms($tag, $handle) {
    if (strpos($handle, 'wpforms') !== false) {
        // Agrega defer (o async si lo preferÃ­s)
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'diferir_scripts_wpforms', 10, 2);

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );

add_filter('woocommerce_payment_gateways', 'habilitar_transferencia_bancaria');
function habilitar_transferencia_bancaria($methods) {
    $methods[] = 'WC_Gateway_BACS';
    return $methods;
}

add_action('woocommerce_cart_calculate_fees', 'descuento_por_metodo_nave');
function descuento_por_metodo_nave() {
    if (is_admin() && !defined('DOING_AJAX')) return;

    if (isset(WC()->session)) {
        $chosen_payment_method = WC()->session->get('chosen_payment_method');

        if ($chosen_payment_method === 'nave_gateway') {
            $discount = WC()->cart->get_subtotal() * 0.05;
            WC()->cart->add_fee('-5% descuento pagando con QR desde tu app bancaria', -$discount);
        }
    }
}

// AÃ±adir campo DNI al checkout
add_action( 'woocommerce_after_checkout_billing_form', 'agregar_campo_dni_checkout' );
function agregar_campo_dni_checkout( $checkout ) {
    woocommerce_form_field( 'billing_dni', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('DNI'),
        'placeholder'   => __('Ingresa tu DNI'),
        'required'      => true,
    ), $checkout->get_value( 'billing_dni' ) );
}

// Guardar el campo DNI en el pedido
add_action( 'woocommerce_checkout_update_order_meta', 'guardar_campo_dni_en_pedido' );
function guardar_campo_dni_en_pedido( $order_id ) {
    if ( ! empty( $_POST['billing_dni'] ) ) {
        update_post_meta( $order_id, 'billing_dni', sanitize_text_field( $_POST['billing_dni'] ) );
    }
}

// Mostrar el DNI en el panel de administraciÃ³n
add_action( 'woocommerce_admin_order_data_after_billing_address', 'mostrar_dni_en_admin', 10, 1 );
function mostrar_dni_en_admin( $order ){
    $dni = get_post_meta( $order->get_id(), 'billing_dni', true );
    if ( $dni ) {
        echo '<p><strong>' . __( 'DNI' ) . ':</strong> ' . esc_html( $dni ) . '</p>';
    }
}

// Agregar el DNI en los correos de WooCommerce
add_filter( 'woocommerce_email_order_meta_fields', 'agregar_dni_a_emails', 10, 3 );
function agregar_dni_a_emails( $fields, $sent_to_admin, $order ) {
    $dni = get_post_meta( $order->get_id(), 'billing_dni', true );
    if ( $dni ) {
        $fields['billing_dni'] = array(
            'label' => __( 'DNI' ),
            'value' => $dni,
        );
    }
    return $fields;
}

/**
 * MEJORA DE EXPERIENCIA DE COMPRA
 * RedirecciÃ³n automÃ¡tica al carrito despuÃ©s de agregar un producto
 */

// OpciÃ³n 1: RedirecciÃ³n nativa para formularios sin AJAX
add_filter( 'woocommerce_add_to_cart_redirect', 'vinotipia_redirect_to_cart_after_add' );
function vinotipia_redirect_to_cart_after_add( $url ) {
    // Redirige al carrito despuÃ©s de agregar un producto
    return wc_get_cart_url();
}

// OpciÃ³n 2: Habilitar AJAX Add to Cart en pÃ¡ginas de archivo/catÃ¡logo
add_action( 'wp_enqueue_scripts', 'vinotipia_enqueue_cart_redirect_script' );
function vinotipia_enqueue_cart_redirect_script() {
    // Solo cargar en la pÃ¡gina de archivo de productos (catÃ¡logo)
    if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) ) {
        wp_enqueue_script(
            'vinotipia-cart-redirect',
            get_template_directory_uri() . '/assets/js/cart-redirect.js',
            array( 'jquery', 'wc-add-to-cart' ),
            wp_get_theme()->get('Version'),
            true
        );
        
        // Pasar la URL del carrito a JavaScript
        wp_localize_script( 'vinotipia-cart-redirect', 'vinotipiaCart', array(
            'cart_url' => wc_get_cart_url(),
            'ajax_url'  => admin_url( 'admin-ajax.php' )
        ));
    }
}

/**
 * SEGUIMIENTO PIXEL DE META (AddToCart y Purchase)
 */

// Evento AddToCart (Seguimiento de agregaciÃ³n al carrito en el cliente)
add_action( 'wp_footer', 'vinotipia_meta_pixel_add_to_cart_js', 99 );
function vinotipia_meta_pixel_add_to_cart_js() {
    if ( ! is_product() && ! is_shop() && ! is_post_type_archive( 'product' ) && ! is_tax( 'product_cat' ) && ! is_cart() ) {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // 1. AJAX Add to Cart (PÃ¡ginas de catÃ¡logo)
        $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
            if ($button && $button.data('product_id')) {
                fbq('track', 'AddToCart', {
                    content_ids: [$button.data('product_id').toString()],
                    content_type: 'product'
                });
            }
        });

        // 2. Ficha de producto individual (Formulario normal)
        $('.single_add_to_cart_button').on('click', function() {
            var $form = $(this).closest('form.cart');
            var product_id = $form.find('[name="add-to-cart"]').val() || $(this).val();
            
            // Soporte para productos variables (toma el ID de variaciÃ³n elegido)
            var variation_id = $form.find('[name="variation_id"]').val();
            var final_id = variation_id && variation_id != 0 ? variation_id : product_id;

            if (final_id) {
                fbq('track', 'AddToCart', {
                    content_ids: [final_id.toString()],
                    content_type: 'product'
                });
            }
        });
    });
    </script>
    <?php
}

// Evento Purchase (PÃ¡gina de confirmaciÃ³n de pedido / Thank You)
add_action( 'woocommerce_thankyou', 'vinotipia_meta_pixel_purchase' );
function vinotipia_meta_pixel_purchase( $order_id ) {
    if ( ! $order_id ) {
        return;
    }
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }
    
    // Evitar duplicados por recarga de pÃ¡gina
    if ( $order->get_meta( '_meta_pixel_purchase_tracked' ) ) {
        return;
    }
    
    $total = $order->get_total();
    $currency = $order->get_currency();
    $items = $order->get_items();
    $product_ids = array();
    
    foreach ( $items as $item ) {
        $product_ids[] = '"' . $item->get_product_id() . '"';
    }
    
    // Guardar flag de tracking
    $order->update_meta_data( '_meta_pixel_purchase_tracked', '1' );
    $order->save();
    ?>
    <script type="text/javascript">
        if (typeof fbq !== 'undefined') {
            fbq('track', 'Purchase', {
                value: <?php echo esc_js( $total ); ?>,
                currency: '<?php echo esc_js( $currency ); ?>',
                content_type: 'product',
                content_ids: [<?php echo implode( ',', $product_ids ); ?>]
            });
        }
    </script>
    <?php
}

// ==========================================
// NUEVOS EVENTOS: ViewContent, InitiateCheckout, Lead, CompleteRegistration
// ==========================================

// Evento ViewContent (Ver contenido de producto)
add_action( 'wp_footer', 'vinotipia_meta_pixel_view_content', 99 );
function vinotipia_meta_pixel_view_content() {
    if ( ! is_product() ) {
        return;
    }
    global $product;
    if ( ! $product ) {
        return;
    }
    
    $product_id = $product->get_id();
    $product_name = $product->get_name();
    $product_price = $product->get_price();
    $currency = get_woocommerce_currency();
    ?>
    <script type="text/javascript">
        if (typeof fbq !== 'undefined') {
            fbq('track', 'ViewContent', {
                content_ids: ['<?php echo esc_js( $product_id ); ?>'],
                content_name: '<?php echo esc_js( $product_name ); ?>',
                content_type: 'product',
                value: <?php echo esc_js( $product_price ? $product_price : 0 ); ?>,
                currency: '<?php echo esc_js( $currency ); ?>'
            });
        }
    </script>
    <?php
}

// Evento InitiateCheckout (Iniciar pago)
add_action( 'wp_footer', 'vinotipia_meta_pixel_initiate_checkout', 99 );
function vinotipia_meta_pixel_initiate_checkout() {
    // Solo en la pÃ¡gina de checkout (y no en order-received)
    if ( ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
        return;
    }
    
    $cart = WC()->cart;
    if ( ! $cart ) return;
    
    $total = $cart->total;
    $currency = get_woocommerce_currency();
    
    // Obtener IDs y cantidad
    $items = $cart->get_cart();
    $product_ids = array();
    $num_items = 0;
    foreach ( $items as $item ) {
        $product_ids[] = '"' . $item['product_id'] . '"';
        $num_items += $item['quantity'];
    }
    ?>
    <script type="text/javascript">
        if (typeof fbq !== 'undefined') {
            fbq('track', 'InitiateCheckout', {
                value: <?php echo esc_js( $total ? $total : 0 ); ?>,
                currency: '<?php echo esc_js( $currency ); ?>',
                content_ids: [<?php echo implode( ',', $product_ids ); ?>],
                num_items: <?php echo esc_js( $num_items ); ?>
            });
        }
    </script>
    <?php
}

// Evento Lead (para los formularios de contacto)
add_action( 'wp_footer', 'vinotipia_meta_pixel_lead', 99 );
function vinotipia_meta_pixel_lead() {
    // Escuchar el evento de WPForms AJAX submit success
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(document).on('wpformsAjaxSubmitSuccess', function(e, response) {
                if (typeof fbq !== 'undefined') {
                    fbq('track', 'Lead');
                }
            });
        });
    </script>
    <?php
}

// Evento CompleteRegistration (para WooCommerce mi cuenta / checkout)
add_action( 'user_register', 'vinotipia_meta_pixel_complete_registration' );
function vinotipia_meta_pixel_complete_registration( $user_id ) {
    update_user_meta( $user_id, '_meta_pixel_registration_tracked', '0' );
}

add_action( 'wp_footer', 'vinotipia_meta_pixel_complete_registration_js', 99 );
function vinotipia_meta_pixel_complete_registration_js() {
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $tracked = get_user_meta( $user_id, '_meta_pixel_registration_tracked', true );
        
        if ( $tracked === '0' ) {
            update_user_meta( $user_id, '_meta_pixel_registration_tracked', '1' );
            ?>
            <script type="text/javascript">
                if (typeof fbq !== 'undefined') {
                    fbq('track', 'CompleteRegistration');
                }
            </script>
            <?php
        }
    }
}
/**
 * ==========================================
 * TRADUCCIÃ“N DE BOTONES DE CARRITO
 * ==========================================
 */
add_filter( 'woocommerce_product_single_add_to_cart_text', 'vinotipia_custom_cart_button_text' );
add_filter( 'woocommerce_product_add_to_cart_text', 'vinotipia_custom_cart_button_text' );
function vinotipia_custom_cart_button_text() {
    return 'AÃ±adir al carrito';
}

/**
 * ==========================================
 * SHOP INSTANT FILTER
 * ==========================================
 */

add_action( 'wp_enqueue_scripts', 'vinotipia_enqueue_shop_filter' );
function vinotipia_enqueue_shop_filter() {
    if ( ! is_post_type_archive( 'product' ) && ! is_shop() ) return;

    wp_enqueue_script(
        'vinotipia-shop-filter',
        get_template_directory_uri() . '/assets/js/shop-filter.js',
        array( 'jquery' ),
        filemtime( get_template_directory() . '/assets/js/shop-filter.js' ),
        true
    );
}

/**
 * ==========================================
 * GIFT CARD CUSTOMIZADA (MONTO DINÃMICO)
 * ==========================================
 */

// 0. Forzar que la Gift Card siempre sea "purchasable" aunque tenga precio 0
add_filter( 'woocommerce_is_purchasable', 'vinotipia_gift_card_is_purchasable', 10, 2 );
function vinotipia_gift_card_is_purchasable( $purchasable, $product ) {
    if ( $product->get_slug() === 'gift-card' ) {
        return true;
    }
    return $purchasable;
}

// 0b. Cambiar el texto del precio en la tienda (para que no diga "Gratis" si le pones precio 0)
add_filter( 'woocommerce_get_price_html', 'vinotipia_gift_card_catalog_price', 10, 2 );
function vinotipia_gift_card_catalog_price( $price, $product ) {
    if ( $product->get_slug() === 'gift-card' ) {
        return '<span class="woocommerce-Price-amount amount">Monto elegible</span>';
    }
    return $price;
}

// 1. Agregar datos al carrito
add_filter( 'woocommerce_add_cart_item_data', 'vinotipia_add_gift_card_data', 10, 3 );
function vinotipia_add_gift_card_data( $cart_item_data, $product_id, $variation_id ) {
    if ( isset( $_POST['gift_card_price'] ) && !empty( $_POST['gift_card_price'] ) ) {
        $cart_item_data['gift_card_price'] = sanitize_text_field( $_POST['gift_card_price'] );
        
        if ( !empty($_POST['gift_to']) ) {
            $cart_item_data['gift_to'] = sanitize_text_field( $_POST['gift_to'] );
        }
        if ( !empty($_POST['gift_from']) ) {
            $cart_item_data['gift_from'] = sanitize_text_field( $_POST['gift_from'] );
        }
        if ( !empty($_POST['gift_message']) ) {
            $cart_item_data['gift_message'] = sanitize_textarea_field( $_POST['gift_message'] );
        }
        if ( !empty($_POST['gift_recipient_email']) ) {
            $cart_item_data['gift_recipient_email'] = sanitize_email( $_POST['gift_recipient_email'] );
        }
        
        // Unique key para permitir agregar mÃºltiples gift cards
        $cart_item_data['unique_key'] = md5( microtime().rand() ); 
    }
    return $cart_item_data;
}

// 2. Mostrar datos en el carrito (COMENTADO A PEDIDO DEL USUARIO)
// add_filter( 'woocommerce_get_item_data', 'vinotipia_display_gift_card_cart', 10, 2 );
/*
function vinotipia_display_gift_card_cart( $item_data, $cart_item ) {
    if ( isset( $cart_item['gift_to'] ) ) {
        $item_data[] = array( 'name' => 'Para', 'value' => $cart_item['gift_to'] );
    }
    if ( isset( $cart_item['gift_from'] ) ) {
        $item_data[] = array( 'name' => 'De', 'value' => $cart_item['gift_from'] );
    }
    if ( isset( $cart_item['gift_message'] ) ) {
        $item_data[] = array( 'name' => 'Mensaje', 'value' => $cart_item['gift_message'] );
    }
    if ( isset( $cart_item['gift_recipient_email'] ) ) {
        $item_data[] = array( 'name' => 'Email destinatario', 'value' => $cart_item['gift_recipient_email'] );
    }
    return $item_data;
}
*/

// 3. Sobrescribir precio en el carrito
add_action( 'woocommerce_before_calculate_totals', 'vinotipia_custom_gift_card_price', 99, 1 );
function vinotipia_custom_gift_card_price( $cart_obj ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    foreach ( $cart_obj->get_cart() as $key => $value ) {
        if ( isset( $value['gift_card_price'] ) ) {
            $value['data']->set_price( (float) $value['gift_card_price'] );
        }
    }
}

// 4. Guardar los datos en el pedido (Order Meta)
add_action( 'woocommerce_checkout_create_order_line_item', 'vinotipia_save_gift_card_order', 10, 4 );
function vinotipia_save_gift_card_order( $item, $cart_item_key, $values, $order ) {
    if ( isset( $values['gift_to'] ) ) {
        $item->add_meta_data( 'Para', $values['gift_to'], true );
    }
    if ( isset( $values['gift_from'] ) ) {
        $item->add_meta_data( 'De', $values['gift_from'], true );
    }
    if ( isset( $values['gift_message'] ) ) {
        $item->add_meta_data( 'Mensaje', $values['gift_message'], true );
    }
    if ( isset( $values['gift_recipient_email'] ) ) {
        $item->add_meta_data( 'Email destinatario', $values['gift_recipient_email'], true );
    }
}

// 5. Enviar email de Gift Card cuando se pague el pedido
add_action( 'woocommerce_payment_complete', 'vinotipia_send_gift_card_email', 10, 1 );
add_action( 'woocommerce_order_status_processing', 'vinotipia_send_gift_card_email', 10, 1 );
function vinotipia_send_gift_card_email( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) return;

    foreach ( $order->get_items() as $item ) {
        $product = $item->get_product();
        if ( ! $product || $product->get_slug() !== 'gift-card' ) continue;

        $gift_to      = $item->get_meta( 'Para' );
        $gift_from    = $item->get_meta( 'De' );
        $gift_message = $item->get_meta( 'Mensaje' );
        $gift_email   = $item->get_meta( 'Email destinatario' );
        $gift_amount  = $item->get_total();
        $gift_price   = wc_price( $gift_amount );

        // Si no hay email de destinatario, no enviamos
        if ( empty( $gift_email ) || ! is_email( $gift_email ) ) continue;

        // Generar CupÃ³n Ãšnico AutomÃ¡ticamente
        $coupon_code = 'VINO-' . strtoupper( wp_generate_password( 6, false ) );
        $coupon = new WC_Coupon();
        $coupon->set_code( $coupon_code );
        $coupon->set_discount_type( 'fixed_cart' ); // Descuento fijo en el carrito
        $coupon->set_amount( $gift_amount );
        $coupon->set_description( 'Gift Card de ' . $gift_from . ' para ' . $gift_to . ' (Pedido #' . $order_id . ')' );
        $coupon->set_usage_limit( 1 ); // Solo se puede usar 1 vez
        $coupon->save();

        // Agregar el cupÃ³n a la meta del pedido por las dudas
        $item->add_meta_data( 'CÃ³digo Generado', $coupon_code, true );
        $item->save();

        $subject = 'Â¡Recibiste una Gift Card de Vinotipia!';

        ob_start();
        include get_template_directory() . '/template-parts/emails/gift-card-email.php';
        $message = ob_get_clean();

        $headers = array(
            'Content-Type: text/html; charset=UTF-8'
        );

        wp_mail( $gift_email, $subject, $message, $headers );
    }
}

/* ===================================================
   LÃ“GICA DEL CARRITO PARA COMBOS
=================================================== */

// 1. Guardar selecciÃ³n del kit en el carrito
add_filter( 'woocommerce_add_cart_item_data', 'vinotipia_save_combo_kit_to_cart', 10, 2 );
function vinotipia_save_combo_kit_to_cart( $cart_item_data, $product_id ) {
    if ( isset( $_POST['selected_combo_kit'] ) && ! empty( $_POST['selected_combo_kit'] ) ) {
        $cart_item_data['selected_combo_kit'] = sanitize_text_field( $_POST['selected_combo_kit'] );
        // Forzar que WooCommerce trate cada combo como un item separado en el carrito si eligen kits distintos
        $cart_item_data['unique_key'] = md5( microtime() . rand() );
    }
    if ( isset( $_POST['selected_combo_tipos'] ) && ! empty( $_POST['selected_combo_tipos'] ) ) {
        $cart_item_data['selected_combo_tipos'] = sanitize_text_field( $_POST['selected_combo_tipos'] );
    }
    return $cart_item_data;
}

// 2. Mostrar selecciÃ³n en el carrito y checkout
add_filter( 'woocommerce_get_item_data', 'vinotipia_display_combo_kit_in_cart', 10, 2 );
function vinotipia_display_combo_kit_in_cart( $item_data, $cart_item ) {
    if ( isset( $cart_item['selected_combo_kit'] ) ) {
        $item_data[] = array(
            'name'  => 'Kit Incluido',
            'value' => $cart_item['selected_combo_kit'],
        );
    }
    if ( isset( $cart_item['selected_combo_tipos'] ) ) {
        $item_data[] = array(
            'name'  => 'Vinotipia Tipos',
            'value' => $cart_item['selected_combo_tipos'],
        );
    }
    return $item_data;
}

// 3. Guardar selecciÃ³n en los detalles del pedido (Order Meta) para que lo vea el administrador
add_action( 'woocommerce_checkout_create_order_line_item', 'vinotipia_save_combo_kit_to_order', 10, 4 );
function vinotipia_save_combo_kit_to_order( $item, $cart_item_key, $values, $order ) {
    if ( isset( $values['selected_combo_kit'] ) ) {
        $item->add_meta_data( 'Kit Incluido', $values['selected_combo_kit'], true );
    }
    if ( isset( $values['selected_combo_tipos'] ) ) {
        $item->add_meta_data( 'Vinotipia Tipos', $values['selected_combo_tipos'], true );
    }
}
