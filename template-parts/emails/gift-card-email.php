<?php
// Variables disponibles: $gift_to, $gift_from, $gift_message, $gift_price, $coupon_code
// Se incluye con ob_start() desde functions.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recibiste una Gift Card de Vinotipia</title>
</head>
<body style="margin:0;padding:0;background-color:#F9F1EA;font-family:Georgia,serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F9F1EA;padding:40px 20px;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 10px 40px rgba(89,30,43,0.12);">

        <!-- HEADER CON IMAGEN -->
        <tr>
          <td style="padding:0;text-align:center;">
            <img src="https://vinotipia.com/wp-content/uploads/2026/10/WhatsApp-Image-2026-10-07-at-14.44.10.jpeg" alt="Vinotipia Gift Card" style="width:100%; height:auto; display:block; max-height:400px; object-fit:cover;">
          </td>
        </tr>

        <!-- CUERPO -->
        <tr>
          <td style="padding:45px 45px 30px;">

            <!-- Saludo -->
            <p style="font-size:22px;color:#591E2B;margin:0 0 15px;font-weight:normal;">
              <strong><?php echo esc_html( $gift_to ?: 'Hola' ); ?></strong>, alguien quiso regalarte un momento para recordar.
            </p>
            <p style="font-size:16px;color:#666;margin:0 0 15px;line-height:1.7;font-family:Arial,sans-serif;">
              Te regalaron una experiencia Vinotipia.
            </p>
            <p style="font-size:16px;color:#666;margin:0 0 30px;line-height:1.7;font-family:Arial,sans-serif;">
              Una experiencia para descubrir, jugar, sentir y compartir alrededor del vino.
            </p>

            <!-- Tarjeta del monto y codigo -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#591E2B 0%,#7a2535 100%);border-radius:16px;margin-bottom:30px;overflow:hidden;">
              <tr>
                <td style="padding:30px;text-align:center;">
                  <p style="margin:0 0 6px;font-size:11px;letter-spacing:4px;color:#D4AF37;text-transform:uppercase;font-family:Arial,sans-serif;">Valor de tu Gift Card</p>
                  <p style="margin:0;font-size:42px;color:#ffffff;font-weight:bold;font-family:Georgia,serif;"><?php echo wp_kses_post( $gift_price ); ?></p>
                  
                  <div style="width:40px;height:1px;background:#D4AF37;margin:20px auto;"></div>
                  
                  <p style="margin:0 0 10px;font-size:12px;color:rgba(255,255,255,0.7);font-family:Arial,sans-serif;text-transform:uppercase;letter-spacing:1px;">Tu código de canje único:</p>
                  <div style="background-color:rgba(0,0,0,0.2); border: 2px dashed #D4AF37; padding: 12px 20px; border-radius: 8px; display:inline-block; margin-bottom: 20px;">
                      <span style="font-size:20px; letter-spacing: 2px; color:#D4AF37; font-weight:bold; font-family: Courier, monospace;"><?php echo esc_html( $coupon_code ); ?></span>
                  </div>

                  <p style="margin:0;font-size:12px;color:rgba(255,255,255,0.7);font-family:Arial,sans-serif;">Válida para canjear en <a href="https://vinotipia.com" style="color:#D4AF37;text-decoration:none;font-weight:bold;">vinotipia.com</a></p>
                </td>
              </tr>
            </table>

            <!-- Mensaje personal -->
            <?php if ( !empty( $gift_message ) ): ?>
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#F9F1EA;border-radius:12px;border-left:4px solid #D4AF37;margin-bottom:30px;">
              <tr>
                <td style="padding:20px 25px;">
                  <p style="margin:0 0 8px;font-size:11px;letter-spacing:3px;color:#D4AF37;text-transform:uppercase;font-family:Arial,sans-serif;">Mensaje de <?php echo esc_html( $gift_from ?: 'Alguien especial' ); ?></p>
                  <p style="margin:0;font-size:16px;color:#591E2B;line-height:1.7;font-style:italic;font-family:Georgia,serif;">"<?php echo esc_html( $gift_message ); ?>"</p>
                </td>
              </tr>
            </table>
            <?php endif; ?>

            <!-- Pasos -->
            <p style="font-size:13px;font-weight:bold;color:#591E2B;letter-spacing:2px;text-transform:uppercase;margin:0 0 15px;font-family:Arial,sans-serif;">Como usar tu Gift Card</p>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr><td style="padding:12px 0;border-bottom:1px solid #f0e8e0;">
                <table cellpadding="0" cellspacing="0"><tr>
                  <td style="width:36px;height:36px;background:#591E2B;border-radius:50%;text-align:center;vertical-align:middle;font-size:14px;color:#fff;font-family:Arial;font-weight:bold;">1</td>
                  <td style="padding-left:15px;font-size:14px;color:#555;font-family:Arial,sans-serif;line-height:1.5;">Ingresá a <a href="https://vinotipia.com/tienda" style="color:#591E2B;font-weight:bold;">vinotipia.com</a> y agregá tu kit al carrito.</td>
                </tr></table>
              </td></tr>
              <tr><td style="padding:12px 0;border-bottom:1px solid #f0e8e0;">
                <table cellpadding="0" cellspacing="0"><tr>
                  <td style="width:36px;height:36px;background:#591E2B;border-radius:50%;text-align:center;vertical-align:middle;font-size:14px;color:#fff;font-family:Arial;font-weight:bold;">2</td>
                  <td style="padding-left:15px;font-size:14px;color:#555;font-family:Arial,sans-serif;line-height:1.5;">En la pantalla de pago, aplicá tu <strong>código de canje</strong> para descontar el valor.</td>
                </tr></table>
              </td></tr>
              <tr><td style="padding:12px 0;">
                <table cellpadding="0" cellspacing="0"><tr>
                  <td style="width:36px;height:36px;background:#591E2B;border-radius:50%;text-align:center;vertical-align:middle;font-size:14px;color:#fff;font-family:Arial;font-weight:bold;">3</td>
                  <td style="padding-left:15px;font-size:14px;color:#555;font-family:Arial,sans-serif;line-height:1.5;">Nos encargamos del envío. ¡Disfrutá la experiencia y descubrí tu vinotipo!</td>
                </tr></table>
              </td></tr>
            </table>

            <!-- CTA -->
            <div style="text-align:center;margin:35px 0 10px;">
              <a href="https://vinotipia.com/tienda" style="display:inline-block;background-color:#591E2B;color:#ffffff;text-decoration:none;padding:16px 45px;border-radius:50px;font-size:15px;font-family:Arial,sans-serif;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">Ir a la tienda</a>
            </div>

          </td>
        </tr>

        <!-- SEPARADOR -->
        <tr><td style="padding:0 45px;"><div style="height:1px;background:linear-gradient(to right,transparent,#D4AF37,transparent);"></div></td></tr>

        <!-- FOOTER -->
        <tr>
          <td style="padding:25px 45px 35px;text-align:center;">
            <p style="margin:0 0 6px;font-size:11px;color:#591E2B;letter-spacing:3px;text-transform:uppercase;font-family:Arial,sans-serif;">Vinotipia</p>
            <p style="margin:0;font-size:12px;color:#999;font-family:Arial,sans-serif;line-height:1.7;">
              No se trata solo de saber. <em style="color:#591E2B;">Se trata de sentir.</em><br>
              <a href="https://vinotipia.com" style="color:#D4AF37;text-decoration:none;">vinotipia.com</a>
              &nbsp;·&nbsp;
              <a href="mailto:hola@vinotipia.com" style="color:#D4AF37;text-decoration:none;">hola@vinotipia.com</a>
            </p>
          </td>
        </tr>

      </table>
    </td></tr>
  </table>

</body>
</html>
