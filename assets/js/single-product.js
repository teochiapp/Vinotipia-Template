// SINGLE PRODUCT PAGE JAVASCRIPT

// Tab functionality
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.tab-btn');
  const contents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      contents.forEach(c => c.classList.remove('active'));

      tab.classList.add('active');
      document.getElementById(tab.dataset.tab).classList.add('active');
    });
  });
});

// Wine rating system
document.addEventListener('DOMContentLoaded', () => {
  const ratingContainer = document.querySelector('.comment-form-rating');
  if (!ratingContainer) return;

  const wineRating = document.createElement('div');
  wineRating.classList.add('wine-rating');

  for (let i = 1; i <= 5; i++) {
    const copa = document.createElement('span');
    copa.classList.add('copa');
    copa.dataset.value = i;
    copa.innerHTML = '<i class="fa-solid fa-wine-glass"></i>';
    wineRating.appendChild(copa);
  }

  ratingContainer.insertBefore(wineRating, ratingContainer.querySelector('select'));

  const select = ratingContainer.querySelector('select');
  const copas = wineRating.querySelectorAll('.copa');

  // Selección fija al hacer clic
  copas.forEach(copa => {
    copa.addEventListener('click', () => {
      const value = parseInt(copa.dataset.value);
      select.value = value;
      updateSelected(value);
    });

    // Hover visual
    copa.addEventListener('mouseenter', () => {
      const value = parseInt(copa.dataset.value);
      updateHover(value);
    });

    copa.addEventListener('mouseleave', () => {
      clearHover();
    });
  });

  function updateSelected(value) {
    copas.forEach((copa, index) => {
      copa.classList.toggle('selected', index < value);
    });
  }

  function updateHover(value) {
    copas.forEach((copa, index) => {
      copa.classList.toggle('hovered', index < value);
    });
  }

  function clearHover() {
    copas.forEach(copa => copa.classList.remove('hovered'));
  }
});

// Display existing ratings as wine glasses
document.addEventListener('DOMContentLoaded', () => {
  const ratings = document.querySelectorAll('.star-rating');

  ratings.forEach(rating => {
    const span = rating.querySelector('span');
    if (!span) return;

    // Obtener porcentaje de rating
    const widthPercent = parseFloat(span.style.width);
    const total = 5;
    const ratingValue = (widthPercent / 100) * total;

    // Limpiar contenido original
    rating.innerHTML = '';

    // Crear copas
    for (let i = 1; i <= 5; i++) {
      const copa = document.createElement('i');
      copa.classList.add('fa-solid', 'fa-wine-glass');

      if (i <= Math.floor(ratingValue)) {
        copa.style.opacity = '1';
      } else if (i - ratingValue < 1) {
        copa.style.opacity = '0.5'; // copa "media"
      } else {
        copa.style.opacity = '0.2';
      }

      copa.style.color = '#b3002d';
      copa.style.marginRight = '5px';
      copa.style.fontSize = '1.2rem';

      rating.appendChild(copa);
    }
  });
});

// Auto-select first variation
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.variations_form');
  if (!form) return;

  const selects = form.querySelectorAll('select');

  selects.forEach(select => {
    // Si tiene opciones válidas
    if (select.options.length > 1) {
      // Omitimos la opción "Elige una opción" (value="")
      for (let i = 0; i < select.options.length; i++) {
        const option = select.options[i];
        if (option.value !== '') {
          select.value = option.value;
          const event = new Event('change', { bubbles: true });
          select.dispatchEvent(event);
          break;
        }
      }
    }
  });

  // Forzamos que WooCommerce actualice la variación seleccionada
  if (typeof jQuery !== 'undefined') {
    jQuery(form).trigger('check_variations');
  }
});

// Grilla de Variaciones Personalizada (3x3)
function initCustomVariationGrid() {
  const form = document.querySelector('.variations_form');
  if (!form || form.dataset.customGridInitialized) return;
  form.dataset.customGridInitialized = 'true'; // Prevenir init duplicado

  const selects = form.querySelectorAll('table.variations select');
  
  selects.forEach(select => {
    // 1. Ocultamos el select original
    select.style.display = 'none';
    
    // 2. Creamos contenedor CSS Grid
    const grid = document.createElement('div');
    grid.className = 'custom-variation-grid';
    
    // 3. Obtenemos opciones válidas
    const options = Array.from(select.options).filter(opt => opt.value !== '');
    
    // Mapeo de iconos para cada valor
    const iconMap = {
      'festin': '<i class="fa-solid fa-wine-glass"></i>',
      'la-verdad': '<i class="fa-regular fa-circle"></i>',
      'el-rito': '<i class="fa-solid fa-fire-flame-simple"></i>', // Llama de vela
      'el-faro': '<i class="fa-solid fa-tower-observation"></i>',
      'la-mirada': '<i class="fa-regular fa-eye"></i>',
      'el-centro': '<i class="fa-solid fa-sun"></i>',
      'la-raiz': '<i class="fa-solid fa-seedling"></i>',
      'el-viaje': '<i class="fa-regular fa-compass"></i>',
      'el-umbral': '<i class="fa-solid fa-door-open"></i>'
    };

    // 4. Creamos un botón por cada opción
    options.forEach((opt) => {
      const btn = document.createElement('div');
      btn.className = 'custom-variation-btn';
      
      const iconHtml = iconMap[opt.value] || '<i class="fa-solid fa-wine-bottle"></i>';
      
      const isBlanco = (opt.value === 'el-faro' || opt.value === 'el-viaje');
      const typeText = isBlanco ? 'Blanco' : 'Tinto';
      
      // Diseño premium usando los iconos de FontAwesome
      btn.innerHTML = `
        <div class="btn-icon">${iconHtml}</div>
        <span class="btn-text">${opt.text}</span>
        <span class="btn-type" style="font-size: 0.75em; font-weight: 400; opacity: 0.9; margin-top: 4px; text-transform: uppercase; letter-spacing: 1px; color: white;">${typeText}</span>
      `;
      btn.dataset.value = opt.value;
      
      btn.addEventListener('click', () => {
        grid.querySelectorAll('.custom-variation-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        select.value = opt.value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        if (typeof jQuery !== 'undefined') {
            jQuery(select).trigger('change');
        }
      });
      
      grid.appendChild(btn);
    });
    
    // Insertamos la grilla
    select.parentNode.insertBefore(grid, select.nextSibling);

    // Si el select ya tiene un valor, activamos el botón correspondiente
    const updateActiveButton = () => {
        grid.querySelectorAll('.custom-variation-btn').forEach(b => b.classList.remove('active'));
        if (select.value) {
            const activeBtn = grid.querySelector(`.custom-variation-btn[data-value="${select.value}"]`);
            if (activeBtn) activeBtn.classList.add('active');
        }
    };

    updateActiveButton();
    
    // Escuchar cambios externos en el select
    select.addEventListener('change', updateActiveButton);
    if (typeof jQuery !== 'undefined') {
        jQuery(select).on('change', updateActiveButton);
    }
  });
}

// Ejecutar initCustomVariationGrid
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCustomVariationGrid);
} else {
    initCustomVariationGrid();
}

// Para estar 100% seguros con WooCommerce (que a veces dispara eventos tarde o re-crea la forma)
if (typeof jQuery !== 'undefined') {
    jQuery(document).on('wc_variation_form', initCustomVariationGrid);
}

// Product Gallery Logic
document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');

    if (!mainImage || thumbnails.length === 0) return;

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all
            thumbnails.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked
            this.classList.add('active');

            // Get image url
            const imageUrl = this.getAttribute('data-image-url');

            if (imageUrl) {
                // Fade effect
                mainImage.style.opacity = '0.5';
                
                setTimeout(() => {
                    mainImage.removeAttribute('srcset'); // Remove srcset to force src usage
                    mainImage.src = imageUrl;
                    mainImage.style.opacity = '1';
                }, 150);
            }
        });
    });
});
