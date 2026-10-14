<?php

// Solo mostrar en la página de inicio (front page, home o shop si es el inicio)
if (is_front_page() || is_home()):
    ?>
    <div id="vinotipia-popup-parejas" class="vinotipia-popup-overlay" style="display: none;">
        <div class="vinotipia-popup-content">
            <button id="vinotipia-popup-close" class="vinotipia-popup-close" aria-label="Cerrar">&times;</button>
            <a href="https://vinotipia.com/product/vinotipia-tipos-%c2%b7-sin-filtro/" class="popup-image-link">
                <img src="https://vinotipia.com/wp-content/uploads/2026/06/image0-1.png" alt="Edición Parejas">
            </a>
            <a href="https://vinotipia.com/product/edicion-parejas/" class="vinotipia-popup-btn">
                LO QUIERO
            </a>
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

        .vinotipia-popup-content {
            position: relative;
            width: 90%;
            max-width: 500px;
            background: transparent;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            transform: translateY(20px);
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            display: flex;
            flex-direction: column;
        }

        .vinotipia-popup-overlay.show .vinotipia-popup-content {
            transform: translateY(0);
        }

        .popup-image-link {
            display: block;
            width: 100%;
            height: auto;
        }

        .vinotipia-popup-content img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 16px 16px 0 0;
            transition: transform 0.3s ease;
        }

        .vinotipia-popup-content:hover img {
            transform: scale(1.0);
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
            border-radius: 0 0 16px 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .vinotipia-popup-btn:hover {
            background-color: #e1c088;
            color: #591e2b;
        }

        .vinotipia-popup-close {
            position: absolute;
            top: -12px;
            right: -12px;
            background: #ffffff;
            color: #333;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 10;
            transition: all 0.2s ease;
        }

        .vinotipia-popup-close:hover {
            background: #f5f5f5;
            transform: scale(1.1);
        }

        @media (max-width: 600px) {
            .vinotipia-popup-content {
                max-width: 90%;
            }

            .vinotipia-popup-close {
                top: -10px;
                right: -10px;
                width: 28px;
                height: 28px;
                font-size: 20px;
            }

            .vinotipia-popup-btn {
                padding: 14px;
                font-size: 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Doble verificación: Solo si estamos en la raíz o página de inicio configurada
            var path = window.location.pathname;
            var isInicio = (path === '/' || path === '/index.php' || path === '/vinotipia/' || path === '/vinotipia/index.php');

            if (!isInicio) return;

            var popupId = 'vinotipia-popup-parejas';
            var closeBtnId = 'vinotipia-popup-close';
            var storageKey = 'vinotipia_popup_last_closed';
            var cooldownHours = 24; // Se muestra solo una vez cada 24 horas

            var popup = document.getElementById(popupId);
            var closeBtn = document.getElementById(closeBtnId);

            function showPopup() {
                if (!popup) return;
                popup.style.display = 'flex';
                popup.offsetHeight;
                popup.classList.add('show');
            }

            function setClosedFlag() {
                var now = new Date().getTime();
                localStorage.setItem(storageKey, now);
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
                    setTimeout(showPopup, 2000); // 2 segundos de retraso para UX
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

                // Al hacer clic en cualquier enlace dentro del popup (imagen o botón), marcamos como cerrado
                var contentLinks = popup.querySelectorAll('.vinotipia-popup-content a');
                contentLinks.forEach(function (link) {
                    link.addEventListener('click', function () {
                        setClosedFlag();
                        // Opcionalmente cerramos el popup visualmente si hay algún retraso en la navegación
                        popup.classList.remove('show');
                    });
                });

                checkPopup();
            }
        });
    </script>
<?php endif; ?>