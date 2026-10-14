/**
 * Vinotipia - Redirección automática al carrito
 * Maneja la redirección después de agregar productos al carrito vía AJAX
 */

jQuery(document).ready(function($) {
    
    /**
     * Escuchar el evento de WooCommerce cuando se agrega un producto al carrito
     * Este evento se dispara cuando AJAX Add to Cart está habilitado
     */
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {

        if ($button && $button.length) {
            // Evitar que WooCommerce reemplace el ícono por "Ver carrito"
            $button
                .removeClass('added')
                .html('<i class="fas fa-cart-plus"></i>');

            // Eliminar el enlace "Ver carrito" que WooCommerce agrega automáticamente
            $button.next('.added_to_cart').remove();
        }

        // Opcional: Mostrar un mensaje breve antes de redirigir
        // Puedes comentar estas líneas si no quieres el mensaje
        console.log('Producto agregado al carrito. Redirigiendo...');
        
        // Pequeño delay para que el usuario vea que se agregó el producto
        // Ajusta el tiempo (en milisegundos) según prefieras: 300ms = 0.3 segundos
        setTimeout(function() {
            // Redirigir al carrito
            window.location.href = vinotipiaCart.cart_url;
        }, 300);
    });

    /**
     * Manejo adicional para formularios que no usen AJAX
     * Esto asegura que funcione incluso si AJAX falla
     */
    $('.form-agregar-carrito').on('submit', function(e) {
        // Si el formulario se envía de forma tradicional (sin AJAX),
        // el filtro PHP 'woocommerce_add_to_cart_redirect' se encargará
        // No necesitamos hacer nada aquí, solo dejamos que el formulario se envíe
    });

    /**
     * Opcional: Agregar clase de "loading" al botón mientras se procesa
     * Mejora la UX mostrando feedback visual
     */
    $(document).on('click', '.archive-agregar-carrito-btn', function() {
        var $button = $(this);
        $button.addClass('loading').prop('disabled', true);
        
        // El estado se revertirá automáticamente con la redirección
        // o puedes agregar un timeout de seguridad:
        setTimeout(function() {
            $button.removeClass('loading').prop('disabled', false);
        }, 5000); // 5 segundos de timeout
    });

});
