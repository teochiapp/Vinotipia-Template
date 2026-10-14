<?php

// Mostrar en la página de inicio, home o tienda (solo durante octubre)
if ((is_front_page() || is_home() || is_shop() || is_page('tienda')) && date('m') === '10'):
    ?>
    <div id="vinotipia-popup-bienvenida" class="vinotipia-popup-overlay" style="display: none;">
        <div class="vinotipia-popup-content bienvenida-popup">
            <button id="vinotipia-popup-bienvenida-close" class="vinotipia-popup-close" aria-label="Cerrar">&times;</button>
            <div class="bienvenida-popup-header">
                <h2>¡Bienvenido a Vinotipia!</h2>
            </div>
            <div class="bienvenida-popup-body">
                <p class="bienvenida-popup-text">En octubre aprovecha <strong>envío gratis</strong> a la sucursal de Andreani que quieras!</p>
                <div class="bienvenida-coupon-box">
                    <span class="bienvenida-coupon-code">octubre10</span>
                </div>
                <p class="bienvenida-popup-subtext">Cargá este código en tu carrito para aplicar el descuento.</p>
                <a href="<?php echo function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : site_url('/tienda'); ?>" class="vinotipia-popup-btn">
                    IR A LA TIENDA
                </a>
            </div>
        </div>
    </div>

    <style>
        .vinotipia-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
            backdrop-filter: blur(5px);
        }

        .vinotipia-popup-overlay.show {
            display: flex !important;
            opacity: 1;
            pointer-events: auto;
        }

        .vinotipia-popup-content.bienvenida-popup {
            position: relative;
            width: 90%;
            max-width: 450px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            transform: translateY(20px);
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            text-align: center;
        }

        .vinotipia-popup-content.bienvenida-popup::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://vinotipia.com/wp-content/uploads/2026/02/parejas-2.webp');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            z-index: 1;
            pointer-events: none;
        }

        .vinotipia-popup-overlay.show .vinotipia-popup-content {
            transform: translateY(0);
        }

        .bienvenida-popup-header {
            background-color: #591e2b;
            color: #deb867;
            padding: 30px 20px;
            position: relative;
            overflow: hidden;
        }

        .bienvenida-popup-header::after {
            content: "";
            position: absolute;
            bottom: -15px;
            left: -10%;
            width: 120%;
            height: 30px;
            background: #ffffff;
            border-radius: 50%;
        }

        .bienvenida-popup-header h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            position: relative;
            z-index: 2;
        }

        .bienvenida-popup-body {
            padding: 20px 30px 40px;
            color: #591e2b;
            position: relative;
            z-index: 2;
        }

        .bienvenida-popup-text {
            font-size: 1.15rem;
            margin-bottom: 25px;
            line-height: 1.6;
            color: #591e2b;
        }

        .bienvenida-coupon-box {
            background-color: #fcf9f2;
            border: 2px dashed #deb867;
            border-radius: 12px;
            padding: 15px 25px;
            margin: 0 auto 20px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .bienvenida-coupon-box:hover {
            background-color: #f7ecd5;
            transform: scale(1.02);
        }

        .bienvenida-coupon-box::before {
            content: "¡TOCÁ PARA COPIAR!";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #591e2b;
            color: #deb867;
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 10px;
            font-weight: bold;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .bienvenida-coupon-box:hover::before {
            opacity: 1;
        }

        .bienvenida-coupon-code {
            font-size: 1.8rem;
            font-weight: 800;
            color: #591e2b;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: monospace;
        }

        .bienvenida-popup-subtext {
            font-size: 0.95rem;
            color: #591e2b;
            margin-bottom: 30px;
        }

        .vinotipia-popup-btn {
            display: block;
            background-color: #deb867;
            color: #591e2b;
            text-align: center;
            padding: 16px 20px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(222, 184, 103, 0.4);
        }

        .vinotipia-popup-btn:hover {
            background-color: #d4a955;
            color: #591e2b;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(222, 184, 103, 0.6);
        }

        .vinotipia-popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.1);
            color: #deb867;
            border: 1px solid rgba(222, 184, 103, 0.5);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .vinotipia-popup-close:hover {
            background: #deb867;
            color: #591e2b;
            transform: rotate(90deg);
        }
        
        .toast-message {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 20;
        }

        .toast-message.show {
            opacity: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Doble verificación: Solo si estamos en la raíz o página de inicio configurada o tienda
            var path = window.location.pathname;
            var isInicio = (path === '/' || path === '/index.php' || path === '/vinotipia/' || path === '/vinotipia/index.php' || path.includes('/tienda') || path.includes('/shop'));

            if (!isInicio) return;

            var popupId = 'vinotipia-popup-bienvenida';
            var closeBtnId = 'vinotipia-popup-bienvenida-close';
            var storageKey = 'vinotipia_popup_bienvenida_last_closed';
            var cooldownHours = 24; 

            var popup = document.getElementById(popupId);
            var closeBtn = document.getElementById(closeBtnId);
            var couponBox = popup ? popup.querySelector('.bienvenida-coupon-box') : null;
            var couponCode = popup ? popup.querySelector('.bienvenida-coupon-code') : null;
            
            // Create toast element
            var toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.textContent = '¡Cupón copiado!';
            if (popup && popup.querySelector('.vinotipia-popup-content')) {
                popup.querySelector('.vinotipia-popup-content').appendChild(toast);
            }

            function setClosedFlag() {
                var now = new Date().getTime();
                localStorage.setItem(storageKey, now);
            }

            function showPopup() {
                if (!popup) return;
                popup.style.display = 'flex';
                popup.offsetHeight;
                popup.classList.add('show');
                setClosedFlag(); // Marcar como mostrado inmediatamente para que no vuelva a salir al navegar
            }

            function closePopup() {
                popup.classList.remove('show');
                setTimeout(function () {
                    popup.style.display = 'none';
                }, 300);
                setClosedFlag();
            }

            function checkPopup() {
                var lastClosed = localStorage.getItem(storageKey);

                if (!lastClosed) {
                    setTimeout(showPopup, 2000); 
                    return;
                }

                var now = new Date().getTime();
                var elapsed = now - parseInt(lastClosed);
                var cooldownMs = cooldownHours * 60 * 60 * 1000;

                if (elapsed > cooldownMs) {
                    setTimeout(showPopup, 2000);
                }
            }

            if (popup && closeBtn) {
                closeBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    closePopup();
                });

                popup.addEventListener('click', function (e) {
                    if (e.target === popup) {
                        closePopup();
                    }
                });

                // Copy to clipboard functionality
                if (couponBox && couponCode) {
                    couponBox.addEventListener('click', function() {
                        var textToCopy = couponCode.textContent || couponCode.innerText;
                        navigator.clipboard.writeText(textToCopy).then(function() {
                            toast.classList.add('show');
                            setTimeout(function() {
                                toast.classList.remove('show');
                            }, 2000);
                        }).catch(function(err) {
                            console.error('Error al copiar: ', err);
                        });
                    });
                }

                var contentLinks = popup.querySelectorAll('.vinotipia-popup-btn');
                contentLinks.forEach(function (link) {
                    link.addEventListener('click', function () {
                        setClosedFlag();
                        popup.classList.remove('show');
                    });
                });

                checkPopup();
            }
        });
    </script>
<?php endif; ?>
