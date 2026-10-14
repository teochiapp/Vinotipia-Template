<?php get_header(); ?>

<div class="vinotipia-404-wrapper">
    <div class="vinotipia-404-content">
        <h1>¡Ups! Página no encontrada</h1>
        <p class="zoom-area">Parece que esta copa quedó vacía. No pudimos encontrar la página que buscás en <b>Vinotipia</b>.</p>
        
        <section class="error-container">
          <span class="four"><span class="screen-reader-text">4</span></span>
          <span class="zero"><span class="screen-reader-text">0</span></span>
          <span class="four"><span class="screen-reader-text">4</span></span>
        </section>
        
        <div class="link-container">
          <a href="<?php echo site_url(); ?>" class="more-link">VOLVER AL INICIO</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,600,700');
@import url('https://fonts.googleapis.com/css?family=Catamaran:400,800');

.vinotipia-404-wrapper {
    background-color: #FDFAF5;
    padding: 80px 20px 100px;
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Montserrat', sans-serif;
}

.vinotipia-404-content {
    text-align: center;
    max-width: 600px;
    width: 100%;
}

.vinotipia-404-content h1 {
    color: #591e2b;
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    margin-top: 0;
}

.vinotipia-404-content .zoom-area { 
    font-size: 1.2rem;
    color: #4a4a4a;
    line-height: 1.6;
    margin-bottom: 40px;
}

.vinotipia-404-content .zoom-area b {
    color: #591e2b;
}

.error-container {
  text-align: center;
  font-size: 106px;
  font-family: 'Catamaran', sans-serif;
  font-weight: 800;
  margin: 40px auto;
}
.error-container > span {
  display: inline-block;
  position: relative;
}
.error-container > span.four {
  width: 136px;
  height: 43px;
  border-radius: 999px;
  background:
    linear-gradient(140deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.07) 43%, transparent 44%, transparent 100%),
    linear-gradient(105deg, transparent 0%, transparent 40%, rgba(0, 0, 0, 0.06) 41%, rgba(0, 0, 0, 0.07) 76%, transparent 77%, transparent 100%),
    linear-gradient(to right, #d4a955, #deb867);
}
.error-container > span.four:before,
.error-container > span.four:after {
  content: '';
  display: block;
  position: absolute;
  border-radius: 999px;
}
.error-container > span.four:before {
  width: 43px;
  height: 156px;
  left: 60px;
  bottom: -43px;
  background:
    linear-gradient(128deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.07) 40%, transparent 41%, transparent 100%),
    linear-gradient(116deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.07) 50%, transparent 51%, transparent 100%),
    linear-gradient(to top, #3b131c, #591e2b, #732a39, #8c3647, #a64255);
}
.error-container > span.four:after {
  width: 137px;
  height: 43px;
  transform: rotate(-49.5deg);
  left: -18px;
  bottom: 36px;
  background: linear-gradient(to right, #3b131c, #591e2b, #732a39, #8c3647, #a64255);
}

.error-container > span.zero {
  vertical-align: text-top;
  width: 156px;
  height: 156px;
  border-radius: 999px;
  background: linear-gradient(-45deg, transparent 0%, rgba(0, 0, 0, 0.06) 50%,  transparent 51%, transparent 100%),
    linear-gradient(to top right, #3b131c, #3b131c, #591e2b, #732a39, #8c3647, #a64255, #a64255);
  overflow: hidden;
  animation: bgshadow 5s infinite;
}
.error-container > span.zero:before {
  content: '';
  display: block;
  position: absolute;
  transform: rotate(45deg);
  width: 90px;
  height: 90px;
  background-color: transparent;
  left: 0px;
  bottom: 0px;
  background:
    linear-gradient(95deg, transparent 0%, transparent 8%, rgba(0, 0, 0, 0.07) 9%, transparent 50%, transparent 100%),
    linear-gradient(85deg, transparent 0%, transparent 19%, rgba(0, 0, 0, 0.05) 20%, rgba(0, 0, 0, 0.07) 91%, transparent 92%, transparent 100%);
}
.error-container > span.zero:after {
  content: '';
  display: block;
  position: absolute;
  border-radius: 999px;
  width: 70px;
  height: 70px;
  left: 43px;
  bottom: 43px;
  background: #FDFAF5;
  box-shadow: -2px 2px 2px 0px rgba(0, 0, 0, 0.1);
}

.screen-reader-text {
    position: absolute;
    top: -9999em;
    left: -9999em;
}
    
@keyframes bgshadow {
  0% {
    box-shadow: inset -160px 160px 0px 5px rgba(0, 0, 0, 0.4);
  }
  45% {
    box-shadow: inset 0px 0px 0px 0px rgba(0, 0, 0, 0.1);
  }
  55% {
    box-shadow: inset 0px 0px 0px 0px rgba(0, 0, 0, 0.1);
  }
  100% {
    box-shadow: inset 160px -160px 0px 5px rgba(0, 0, 0, 0.4);
  }
}

.link-container {
  margin-top: 40px;
}

a.more-link {
    text-transform: uppercase;
    font-size: 16px;
    background-color: #591e2b;
    padding: 15px 35px;
    border-radius: 50px;
    color: #deb867;
    display: inline-block;
    text-decoration: none;
    font-weight: 700;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(89, 30, 43, 0.2);
}

a.more-link:hover {
    background-color: #deb867;
    color: #591e2b;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(222, 184, 103, 0.4);
}
</style>