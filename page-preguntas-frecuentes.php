<?php
/**
 * Template Name: Preguntas Frecuentes
 */
get_header(); ?>

<main class="preguntas-frecuentes-page">
    <div class="faq-container">
        <h1>Preguntas Frecuentes</h1>
        <p class="faq-intro">Todo lo que necesitas saber sobre Vinotipia y cómo jugar.</p>

        <section class="faq-section">
            <h2>Acerca de la Experiencia</h2>
            <details class="faq-item">
                <summary>¿Y si no sé nada de vino?</summary>
                <div class="faq-content">
                    <p>Justamente por eso. Acá no hay respuestas correctas, se trata de sentir. Mejor todavía si no sabés.</p>
                </div>
            </details>
            <details class="faq-item">
                <summary>¿Y si ya sé de vino?</summary>
                <div class="faq-content">
                    <p>Mejor todavía. A ciegas, adivinar la cepa es un desafío hasta para los que saben. Te vas a sorprender.</p>
                </div>
            </details>
            <details class="faq-item">
                <summary>¿Para cuántas personas es?</summary>
                <div class="faq-content">
                    <p>Depende del kit que elijas. Tenemos kits para jugar en pareja (2 personas) y opciones como las Triadas o Kits Esenciales para grupos (de 2 a 6 personas).</p>
                </div>
            </details>
        </section>

        <section class="faq-section">
            <h2>Regalos y Envíos</h2>
            <details class="faq-item">
                <summary>¿Lo puedo regalar?</summary>
                <div class="faq-content">
                    <p>Sí. Es ideal para regalar cuando querés regalar algo más que vino. Si no sabés qué recorrido elegir, podés regalar una Gift Card y dejar que la persona elija.</p>
                </div>
            </details>
            <details class="faq-item">
                <summary>¿Cómo llega?</summary>
                <div class="faq-content">
                    <p>Recibís todo listo para abrir y jugar. Enviamos a todo el país. Solo necesitás reunir a tu gente, descorchar y dejarte sorprender.</p>
                </div>
            </details>
            <details class="faq-item">
                <summary>¿Por qué cuesta lo que cuesta?</summary>
                <div class="faq-content">
                    <p>Porque no estás comprando tres botellas. Estás comprando lo que pasa alrededor de ellas. Una experiencia diseñada para jugar, conversar, sorprenderse y descubrir qué vino te representa. Todo llega listo para que vos solo tengas que abrir la caja y disfrutar.</p>
                </div>
            </details>
        </section>
        
        <div class="faq-footer">
            <p>Te quedaron dudas?</p>
            <a href="https://wa.me/5493564578554" target="_blank" class="faq-btn">Escribinos por WhatsApp</a>
        </div>
    </div>
</main>

<style>
/* Estilos diferentes para la página de Preguntas Frecuentes */
.preguntas-frecuentes-page {
    background-color: #FFFFFF;
    padding: 100px 20px 60px;
    min-height: 100vh;
    font-family: 'Sofia Sans', sans-serif;
}

.faq-container {
    max-width: 1200px;
    margin: 0 auto;
    background: #F9F1EA;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.faq-container h1 {
    color: var(--primary-color);
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 10px;
}

.faq-intro {
    text-align: center;
    color: #555;
    font-size: 1.1rem;
    margin-bottom: 40px;
}

.faq-section {
    margin-bottom: 40px;
}

.faq-section h2 {
    color: var(--primary-color);
    font-size: 1.5rem;
    margin-bottom: 20px;
    border-bottom: 2px solid var(--secondary-color);
    padding-bottom: 10px;
}

.faq-item {
    margin-bottom: 15px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.faq-item summary {
    padding: 20px;
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--primary-color);
    cursor: pointer;
    position: relative;
    list-style: none;
    transition: background-color 0.3s;
}

.faq-item summary::-webkit-details-marker {
    display: none;
}

.faq-item summary:after {
    content: '+';
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.5rem;
    color: var(--secondary-color);
    transition: transform 0.3s ease;
}

.faq-item[open] summary:after {
    content: '+';
    transform: translateY(-50%) rotate(45deg);
}

.faq-item[open] summary {
    background-color: var(--primary-color);
    color: white;
}

.faq-content {
    padding: 20px;
    color: #444;
    line-height: 1.6;
    font-size: 1.05rem;
    border-top: 1px solid #eee;
}

.faq-item[open] .faq-content {
    animation: slideDownFade 0.35s ease-out forwards;
}

@keyframes slideDownFade {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.faq-footer {
    text-align: center;
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.faq-btn {
    display: inline-block;
    background-color: var(--secondary-color);
    color: var(--primary-color);
    padding: 12px 25px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: bold;
    margin-top: 15px;
    transition: transform 0.2s, background-color 0.2s;
}

.faq-btn:hover {
    transform: translateY(-3px);
    background-color: #c9a63e;
}

@media (max-width: 768px) {
    .preguntas-frecuentes-page {
        padding: 80px 15px 40px;
    }
    .faq-container {
        padding: 25px 15px;
    }
    .faq-container h1 {
        font-size: 1.8rem;
    }
    .faq-item summary {
        padding: 15px 40px 15px 15px;
        font-size: 1.1rem;
    }
    .faq-content {
        padding: 15px;
        font-size: 1rem;
    }
    .faq-item summary:after {
        right: 15px;
    }
}
</style>

<?php get_footer(); ?>
