/* =====================================================
   SHOP INSTANT FILTER (Client-side) — Vinotipia
===================================================== */
(function ($) {
    'use strict';

    const $grid     = $('#productos-grid');
    const $loader   = $('#shop-loader');
    const $chips    = $('.shop-chips .chip-btn');
    const $products = $('.bloque-producto');

    // Estado inicial: Buscar si la URL tiene un hash válido, sino usar el chip por defecto
    let currentCategory = '';
    const urlHash = window.location.hash.replace('#', '');
    
    if (urlHash && $chips.filter('[data-slug="' + urlHash + '"]').length) {
        currentCategory = urlHash;
        $chips.removeClass('active');
        $chips.filter('[data-slug="' + urlHash + '"]').addClass('active');
    } else {
        const $activeChip = $chips.filter('.active');
        if ($activeChip.length) {
            currentCategory = $activeChip.data('slug');
        }
    }

    function filterProducts(slug) {
        let count = 0;
        
        $products.each(function () {
            const $product   = $(this);
            const categories = $product.data('cat-slugs') || '';
            const catsArray  = categories.split(' ');
            
            // Si el slug está vacío (Todos) o el producto tiene la categoría
            if (!slug || catsArray.includes(slug)) {
                $product.show();
                count++;
            } else {
                $product.hide();
            }
        });

        // Manejar estado vacío si no hay productos que coincidan
        $('#empty-grid-msg').remove();
        $grid.removeClass('items-1 items-2 items-3 items-many');
        
        if (count === 0) {
            $grid.append('<p id="empty-grid-msg" style="grid-column:1/-1;text-align:center;padding:3rem;font-style:italic;color:#888;">No encontramos productos en esta categoría.</p>');
        } else if (count === 1) {
            $grid.addClass('items-1');
        } else if (count === 2) {
            $grid.addClass('items-2');
        } else if (count === 3) {
            $grid.addClass('items-3');
        } else {
            $grid.addClass('items-many');
        }
    }

    // Ejecutar filtro inicial al cargar la página
    filterProducts(currentCategory);

    $chips.on('click', function () {
        const $btn = $(this);
        const slug = $btn.data('slug');

        $chips.removeClass('active');
        $btn.addClass('active');

        // Efecto visual rápido para que no parezca que la web está congelada
        $loader.addClass('visible');
        $grid.css({ opacity: 0.3 });

        setTimeout(() => {
            filterProducts(slug);
            
            $loader.removeClass('visible');
            $grid.css({ opacity: 1 });
            
            // Refrescar AOS animations si existen
            if (typeof AOS !== 'undefined') { AOS.refreshHard(); }
            
            // Scroll suave hacia los productos
            $('html, body').animate({ scrollTop: $grid.offset().top - 100 }, 300);
        }, 150);
    });

})(jQuery);
