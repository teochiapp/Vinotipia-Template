<?php
/**
 * Template Name: Test del Vinotipo
 * Template Post Type: page
 *
 * Página del Test del Vinotipo — vinotipia.com/test
 * Usa header y footer del tema (variante "paginas").
 */

get_header();
?>
<style>
    /* Fuentes del test — @import garantiza que se cargan antes que cualquier regla CSS */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;1,500&family=Sofia+Sans+Condensed:wght@300;400;500;600&family=Shippori+Mincho:wght@400;500&display=block');

    /* =============================================
       TEST DEL VINOTIPO — Variables y reset scoped
    ============================================= */
    .test-wrap {
      --wine:       #7C252E;
      --wine-dark:  #3A1119;
      --gold:       #DEB968;
      --gold-soft:  #E0C088;
      --ink:        #170F0E;
      --cream:      #F3EADA;
      --cream-dim:  rgba(243,234,218,0.62);
      --line:       rgba(222,185,104,0.28);
    }

    /* Fondo oscuro del test — reemplaza body background */
    .test-wrap {
      width: 100%;
      max-width: 100vw;           /* nunca más ancho que la pantalla */
      overflow-x: hidden;         /* corta cualquier desborde horizontal */
      min-height: calc(100vh - 60px);
      background:
        radial-gradient(ellipse 80% 60% at 50% -10%, rgba(124,37,46,0.55), transparent 60%),
        linear-gradient(180deg, var(--ink) 0%, var(--wine-dark) 65%, var(--ink) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 18px 56px;
      -webkit-font-smoothing: antialiased;
      position: relative;
      font-family: 'Sofia Sans Condensed', sans-serif;
    }

    /* Box-sizing scoped: previene que padding/border causen overflow */
    .test-wrap,
    .test-wrap * {
      box-sizing: border-box;
    }

    /* Reset de fuente scoped: fuerza Sofia Sans Condensed en TODOS los hijos,
       anulando el "Sofia Sans" (sin Condensed) que el tema setea en body.
       Las reglas de Playfair/Shippori más abajo lo sobreescriben donde corresponde. */
    .test-wrap *,
    .test-wrap *::before,
    .test-wrap *::after {
      font-family: 'Sofia Sans Condensed', sans-serif;
    }

    /* ---- Botón Volver a la web ---- */
    .test-back-btn {
      position: absolute;
      top: 20px;
      left: 22px;
      display: flex;
      align-items: center;
      gap: 6px;
      font-family: 'Shippori Mincho', serif;
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--cream-dim);
      text-decoration: none;
      transition: color 0.2s ease;
      z-index: 10;
    }
    .test-back-btn:hover { color: var(--gold); text-decoration: none; }
    .test-back-btn svg {
      width: 13px; height: 13px; flex-shrink: 0;
      fill: none; stroke: currentColor;
      stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round;
    }
    @media (max-width: 480px) {
      .test-back-btn { top: 14px; left: 14px; font-size: 10px; }
    }

    .stage { width: 100%; max-width: 440px; min-width: 0; position: relative; }

    .eyebrow {
      font-family: 'Shippori Mincho', serif;
      font-size: 12px;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--gold-soft);
      text-align: center;
      margin-bottom: 14px;
      opacity: 0.85;
    }

    .label {
      border: 1px solid var(--line);
      border-radius: 2px;
      padding: 38px 26px;
      text-align: center;
      position: relative;
      background: linear-gradient(180deg, rgba(222,185,104,0.05), transparent);
      min-height: 150px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: border-color 0.6s ease, background 0.6s ease;
    }
    .label::before, .label::after {
      content: '';
      position: absolute;
      width: 22px; height: 22px;
      border: 1px solid var(--gold);
      opacity: 0.55;
    }
    .label::before { top: -1px;    left: -1px;  border-right: none; border-bottom: none; }
    .label::after  { bottom: -1px; right: -1px; border-left: none;  border-top: none;    }
    .label.filled {
      border-color: var(--gold);
      background: linear-gradient(180deg, rgba(222,185,104,0.14), rgba(222,185,104,0.02));
    }
    .label .blank-mark {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      font-size: 15px;
      color: var(--cream-dim);
      letter-spacing: 0.02em;
    }

    .screen { display: none; animation: rise 0.5s ease both; }
    .screen.active { display: block; }
    @keyframes rise {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .stage h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      font-size: clamp(28px, 7vw, 36px);
      line-height: 1.15;
      text-align: center;
      margin: 22px 0 14px;
      color: var(--cream);
    }
    .sub {
      text-align: center;
      color: var(--cream-dim);
      font-size: 16px;
      line-height: 1.5;
      max-width: min(360px, 100%);  /* nunca más ancho que el contenedor */
      margin: 0 auto 30px;
      font-weight: 300;
    }

    button { font-family: inherit; cursor: pointer; }
    .cta {
      display: block; width: 100%;
      background: var(--gold); color: var(--ink);
      border: none;
      padding: 16px 20px;
      font-size: 15px; font-weight: 600;
      letter-spacing: 0.03em;
      border-radius: 1px;
      transition: transform 0.2s ease, background 0.2s ease;
    }
    .cta:hover  { background: var(--gold-soft); transform: translateY(-1px); }
    .cta:active { transform: translateY(0); }

    .ghost {
      display: block; width: 100%;
      background: transparent;
      color: var(--cream-dim);
      border: 1px solid var(--line);
      padding: 14px 20px;
      font-size: 14px;
      margin-top: 12px;
      border-radius: 1px;
      transition: border-color 0.2s ease, color 0.2s ease;
    }
    .ghost:hover { border-color: var(--gold); color: var(--cream); }

    .progress-wrap { margin: 0 0 30px; }
    .progress-caption {
      display: flex; justify-content: space-between;
      font-family: 'Shippori Mincho', serif;
      font-size: 11px; letter-spacing: 0.12em;
      color: var(--cream-dim);
      margin-bottom: 8px;
      text-transform: uppercase;
    }
    .progress-track {
      height: 1px; background: var(--line);
      position: relative; overflow: hidden;
    }
    .progress-fill {
      position: absolute; left: 0; top: 0; bottom: 0;
      width: 0%;
      background: var(--gold);
      transition: width 0.6s cubic-bezier(0.4,0,0.2,1);
    }

    .question {
      font-family: 'Playfair Display', serif;
      font-weight: 500; font-size: 22px;
      line-height: 1.35; text-align: center;
      margin-bottom: 26px; color: var(--cream);
    }
    .options { display: flex; flex-direction: column; gap: 10px; }
    .option {
      text-align: left;
      background: rgba(243,234,218,0.03);
      border: 1px solid var(--line);
      color: var(--cream);
      padding: 16px 18px;
      font-size: 15.5px; font-weight: 300;
      border-radius: 1px;
      transition: border-color 0.2s ease, background 0.2s ease, padding-left 0.2s ease;
    }
    .option:hover {
      border-color: var(--gold);
      background: rgba(222,185,104,0.06);
      padding-left: 22px;
    }

    .tagline {
      font-family: 'Shippori Mincho', serif;
      font-size: 14px; color: var(--gold-soft);
      letter-spacing: 0.02em; margin-top: 2px;
    }
    .archetype-name {
      font-family: 'Playfair Display', serif;
      font-weight: 600; font-size: 30px;
      letter-spacing: 0.01em; color: var(--cream);
    }
    .desc {
      text-align: center; color: var(--cream-dim);
      line-height: 1.65; font-size: 16px; font-weight: 300;
      max-width: min(380px, 100%); margin: 26px auto 4px;
    }
    .philosophy {
      max-width: min(340px, 100%); margin: 22px auto 0;
      padding-top: 18px; border-top: 1px solid var(--line);
      text-align: center;
    }
    .philosophy-name {
      display: block;
      font-family: 'Playfair Display', serif;
      font-style: italic; font-size: 14px;
      color: var(--gold-soft); margin-bottom: 4px;
    }
    .philosophy-line {
      display: block; font-size: 14px;
      color: var(--cream-dim); font-weight: 300; line-height: 1.5;
    }
    .result-actions { margin-top: 30px; }
    .note {
      text-align: center; font-size: 11.5px;
      color: rgba(243,234,218,0.35);
      margin-top: 22px; line-height: 1.5;
    }

    @media (max-width: 480px) {
      .test-wrap { padding: 32px 14px 48px; }
      .label { padding: 28px 16px; min-height: 110px; }
      .question { font-size: 19px; }
      .option { font-size: 14.5px; padding: 13px 14px; }
      .option:hover { padding-left: 18px; }  /* hover menos agresivo en mobile */
      .archetype-name { font-size: 26px; }
      .sub { font-size: 15px; }
      .desc { font-size: 15px; }
    }
    @media (max-width: 360px) {
      .test-wrap { padding: 28px 10px 40px; }
      .stage h1 { font-size: 22px; }
      .label { padding: 22px 12px; min-height: 90px; }
      .cta { padding: 13px 12px; font-size: 13.5px; }
      .ghost { padding: 12px 12px; font-size: 13px; }
      .option { font-size: 13.5px; padding: 12px 12px; }
      .option:hover { padding-left: 16px; }
      .question { font-size: 17px; }
      .archetype-name { font-size: 22px; }
      .sub, .desc { font-size: 14px; }
      .eyebrow { font-size: 10px; letter-spacing: 0.2em; }
      .note { font-size: 10.5px; }
    }
    @media (prefers-reduced-motion: reduce) {
      .screen, .label, .progress-fill, .option, .cta {
        animation: none !important; transition: none !important;
      }
    }
  </style>

<div class="test-wrap">

  <a href="<?php echo site_url(); ?>" class="test-back-btn" aria-label="Volver a la web">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Volver a la web
  </a>

  <div class="stage">

    <section class="screen active" id="screen-intro">
      <div class="eyebrow">Vinotipia &middot; Elegir sin etiquetas</div>
      <div class="label" id="intro-label">
        <span class="blank-mark">sin etiqueta, todav&#237;a</span>
      </div>
      <h1>Encontr&#225; tu Vinotipo</h1>
      <p class="sub">Cinco preguntas. Ninguna sobre vino. Al final, una cepa que se parece a vos m&#225;s de lo que esper&#225;s.</p>
      <button class="cta" id="btn-empezar" onclick="startQuiz()">Empezar</button>
    </section>

    <section class="screen" id="screen-quiz">
      <div class="progress-wrap">
        <div class="progress-caption">
          <span id="progress-label">Tu copa se llena</span>
          <span id="progress-count">1 / 5</span>
        </div>
        <div class="progress-track"><div class="progress-fill" id="progress-fill"></div></div>
      </div>
      <div class="question" id="question-text"></div>
      <div class="options" id="options-wrap"></div>
    </section>

    <section class="screen" id="screen-result">
      <div class="eyebrow">Tu etiqueta se revela</div>
      <div class="label filled">
        <div class="tagline" id="result-tagline"></div>
        <div class="archetype-name" id="result-name"></div>
      </div>
      <p class="desc" id="result-desc"></p>
      <div class="philosophy">
        <span class="philosophy-name" id="result-philosopher"></span>
        <span class="philosophy-line" id="result-philosophy-line"></span>
      </div>
      <div class="result-actions">
        <button class="cta" id="btn-descubrir" onclick="goToInstagram()">Descubr&#237; tu kit en Vinotipia</button>
        <button class="ghost" id="btn-reiniciar" onclick="restart()">Volver a elegir</button>
      </div>
      <p class="note">Esto es apenas una muestra de lo que pasa cuando eleg&#237;s sin prejuicios ni etiquetas. Imaginate lo que se revela catando a ciegas.</p>
    </section>

  </div>

</div><!-- /.test-wrap -->

<?php get_footer(); ?>

<script>
    /* Tracking — variables inyectadas directamente desde PHP */
    const vinotipiaTrack = {
        ajaxurl: '<?php echo esc_js( admin_url("admin-ajax.php") ); ?>',
        nonce:   '<?php echo esc_js( wp_create_nonce("vinotipo_track") ); ?>'
    };

    const questions = [
      {
        text: "Un viernes ideal para vos es...",
        options: [
          { label: "Una cena íntima, pocas personas que de verdad importan",    type: "pinot"      },
          { label: "Estar en el centro de la reunión, sin haberlo buscado",     type: "malbec"     },
          { label: "Un plan nuevo que nadie más se animó a hacer",              type: "syrah"      },
          { label: "Silencio, algo para leer, nadie que interrumpa",            type: "cabfranc"   },
          { label: "Juntar a todos, que nadie quede afuera",                    type: "merlot"     },
        ]
      },
      {
        text: "Frente a una decisión importante, primero...",
        options: [
          { label: "Analizás cada variable, con método",                        type: "cabsauv"    },
          { label: "Confías en lo que sentís, aunque no lo puedas explicar",    type: "pinot"      },
          { label: "Preguntás, comparás, escuchás antes de resolver",           type: "chardonnay" },
          { label: "Actuás. Ya vas a ver qué pasa",                             type: "syrah"      },
          { label: "Volvés a lo que siempre funcionó, a la tradición",          type: "tempranillo"},
        ]
      },
      {
        text: "La gente que te conoce te describe como alguien...",
        options: [
          { label: "Con una intensidad que se nota",                            type: "malbec"     },
          { label: "Elegante, pero difícil de descifrar",                       type: "cabfranc"   },
          { label: "Directo al hueso, sin vueltas",                             type: "sauvblanc"  },
          { label: "Con una calidez que nunca falla",                           type: "tempranillo"},
          { label: "Con un magnetismo que incomoda a algunos y fascina a otros",type: "syrah"      },
        ]
      },
      {
        text: "Lo que más te cuesta soltar es...",
        options: [
          { label: "El control",                                                type: "cabsauv"    },
          { label: "La imagen que mostrás hacia afuera",                        type: "cabfranc"   },
          { label: "La necesidad de tener razón",                               type: "sauvblanc"  },
          { label: "Adaptarte según el lugar donde estás",                      type: "chardonnay" },
          { label: "Decir que no, aunque te cueste a vos",                      type: "merlot"     },
        ]
      },
      {
        text: "En los vínculos que elegís sostener, sos de...",
        options: [
          { label: "Amar con toda la intensidad, sin medias tintas",            type: "malbec"     },
          { label: "Dar todo, pero en silencio",                                type: "pinot"      },
          { label: "Sostener con lealtad, pase lo que pase",                    type: "tempranillo"},
          { label: "Necesitar libertad para respirar",                          type: "sauvblanc"  },
          { label: "Suavizar cualquier conflicto antes de que escale",          type: "merlot"     },
        ]
      },
    ];

    const archetypes = {
      pinot:       { name:"Pinot Noir",           tagline:"Sofisticación en voz baja",                  desc:"Sos de quienes no necesitan alzar la voz para hacerse sentir. Tu sensibilidad es tu forma de inteligencia: intimidad antes que espectáculo, ternura antes que impacto. Mostrarte vulnerable no te debilita — es ahí donde florecés.",               philosopher:"Sartre",      philosophyLine:"Te hacés a vos misma eligiendo, no explicando." },
      sauvblanc:   { name:"Sauvignon Blanc",      tagline:"La lucidez que no se guarda nada",           desc:"Sos de quienes ven claro y lo dicen. Tu frescura no es superficialidad: es honestidad, discernimiento, ganas genuinas de descubrir. Elegís la singularidad antes que encajar, y ahí está tu vitalidad.",                                         philosopher:"Locke",       philosophyLine:"La verdad se conoce con los sentidos, no con la teoría." },
      syrah:       { name:"Syrah",                tagline:"La intensidad que sabe hasta dónde llegar",  desc:"Tenés una energía que no pasa desapercibida: intensa, magnética, con algo de misterio que invita a acercarse. Buscás la aventura, pero con el poder de saber elegir el momento. Tu audacia tiene criterio.",                                     philosopher:"Epicuro",     philosophyLine:"El placer profundo se construye, no se improvisa." },
      cabsauv:     { name:"Cabernet Sauvignon",   tagline:"La estructura que sostiene todo",            desc:"Tenés la disciplina de quien construye para que dure. Liderás sin necesidad de imponerte: la coherencia y el autocontrol son tu forma de cuidar lo que te importa. Bajo la solidez, hay una determinación que no se negocia.",                    philosopher:"Kant",        philosophyLine:"Lo que percibís también lo construye tu propia mirada." },
      tempranillo: { name:"Tempranillo",           tagline:"La calidez que no se apaga",                desc:"Sos de quienes no fallan. Tu calidez tiene raíces firmes: valorás la tradición, la mesa compartida, la palabra que se cumple. Elegís quedarte cuando otros se van, y esa firmeza es puro cariño genuino.",                                       philosopher:"Estoicismo",  philosophyLine:"La fortaleza está en sostenerse sin necesitar impresionar." },
      cabfranc:    { name:"Cabernet Franc",        tagline:"La elegancia que no pide permiso",          desc:"Hay algo en vos que no se entrega fácil. Tu elegancia convive con una rebeldía silenciosa: preferís la autenticidad antes que encajar, la introspección antes que la exposición. Buscás tu identidad con valentía, aunque eso implique ir a contramano.", philosopher:"Nietzsche",   philosophyLine:"La libertad es crear tu propio camino." },
      chardonnay:  { name:"Chardonnay",            tagline:"La versatilidad que no se pierde a sí misma",desc:"Te adaptás a cada contexto sin perder tu esencia: la curiosidad te lleva a explorar, la resiliencia te sostiene, y el refinamiento está en saber leer cada momento con gratitud.",                                                                philosopher:"Sócrates",    philosophyLine:"Saber que no sabés todo es el comienzo de aprender." },
      malbec:      { name:"Malbec",                tagline:"La pasión que llena cualquier lugar",       desc:"Sos de quienes llenan una sala sin proponérselo. Tu presencia es cálida, generosa, con una intensidad que se nota. Elegís vivir con plenitud y gratitud, sin medias tintas — esa es tu forma de estar en el mundo.",                               philosopher:"Epicuro",     philosophyLine:"El placer abundante también es una forma de gratitud." },
      merlot:      { name:"Merlot",                tagline:"Armonía encarnada",                         desc:"Sos de quienes sostienen el centro sin apagarse. Elegís el equilibrio antes que el extremo, la calidez antes que la exhibición — no por miedo, sino porque sabés que ahí está la verdadera fortaleza. Tu armonía no es tibieza: es una decisión consciente.", philosopher:"Aristóteles", philosophyLine:"La virtud vive en el punto medio." },
    };

    let current = 0;
    const scores = {};

    function showScreen(id) {
      document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
      document.getElementById(id).classList.add('active');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function startQuiz() {
      current = 0;
      Object.keys(scores).forEach(k => delete scores[k]);
      showScreen('screen-quiz');
      renderQuestion();
    }

    function renderQuestion() {
      const q = questions[current];
      document.getElementById('question-text').textContent = q.text;
      document.getElementById('progress-count').textContent = (current + 1) + ' / ' + questions.length;
      document.getElementById('progress-fill').style.width = ((current / questions.length) * 100) + '%';
      const wrap = document.getElementById('options-wrap');
      wrap.innerHTML = '';
      q.options.forEach(opt => {
        const btn = document.createElement('button');
        btn.className = 'option';
        btn.textContent = opt.label;
        btn.setAttribute('type', 'button');
        btn.onclick = () => selectOption(opt.type);
        wrap.appendChild(btn);
      });
    }

    function selectOption(type) {
      scores[type] = (scores[type] || 0) + 1;
      current++;
      if (current < questions.length) {
        renderQuestion();
      } else {
        document.getElementById('progress-fill').style.width = '100%';
        setTimeout(showResult, 350);
      }
    }

    function showResult() {
      let winner = null, max = -1;
      Object.keys(archetypes).forEach(k => {
        const s = scores[k] || 0;
        if (s > max) { max = s; winner = k; }
      });
      if (!winner) winner = 'malbec';
      const a = archetypes[winner];
      document.getElementById('result-tagline').textContent         = a.tagline;
      document.getElementById('result-name').textContent            = a.name;
      document.getElementById('result-desc').textContent            = a.desc;
      document.getElementById('result-philosopher').textContent     = a.philosopher;
      document.getElementById('result-philosophy-line').textContent = a.philosophyLine;
      showScreen('screen-result');

      // — Tracking silencioso: guarda el resultado en la BD de WordPress —
      const fd = new FormData();
      fd.append('action',    'vinotipo_guardar_resultado');
      fd.append('nonce',     vinotipiaTrack.nonce);
      fd.append('arquetipo', winner);
      fetch(vinotipiaTrack.ajaxurl, { method: 'POST', body: fd, credentials: 'same-origin' })
        .catch(() => {}); // silencio total ante cualquier error de red
    }

    function restart() { showScreen('screen-intro'); }
    function goToInstagram() { window.open('https://instagram.com/vinotipiaok', '_blank'); }
  </script>
