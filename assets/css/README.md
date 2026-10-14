# Vinotipia CSS Architecture

## Estructura de Clases CSS

Este documento describe la arquitectura de clases CSS del tema Vinotipia para evitar conflictos entre estilos generales y específicos.

### Clases Globales (variables.css)
- `.container` - Contenedor general del sitio
- `.button` - Botones generales del tema
- Variables CSS globales definidas en `:root`

### Clases Específicas por Página

#### Archive Product (archive-product.css)
- `.archive-container` - Contenedor específico de la página de catálogo
- `.archive-product-precio` - Precios en el catálogo
- `.archive-product-descripcion` - Descripciones de productos en catálogo
- `.archive-ver-detalle-btn` - Botón "Ver detalles" en catálogo
- `.archive-agregar-carrito-btn` - Botón "Agregar al carrito" en catálogo

#### Single Product (single-product.css)
- `.single-product-container` - Contenedor específico de la página de producto
- `.single-product-precio` - Precio en la página individual
- `.single-product-descripcion` - Descripción principal del producto
- `.single-product-descripcion-respuesta` - Descripción adicional del producto
- `.single-agregar-carrito-btn` - Botón de agregar al carrito en página individual

#### Cart (cart.css)
- `.container-pagina` - Contenedor específico de la página del carrito
- `.contenido-pagina` - Contenido principal del carrito

#### Checkout (checkout.css)
- `.checkout-container` - Contenedor específico de checkout

#### My Account (my-account.css)
- `.cuenta-logueado` - Estado cuando el usuario está logueado
- `.cuenta-login` - Estado cuando el usuario no está logueado

### Principios de Nomenclatura

1. **Prefijos específicos**: Cada página tiene su prefijo (archive-, single-, cart-, etc.)
2. **Evitar conflictos**: Las clases globales como `.container`, `.button`, `.precio` no se redefinen
3. **Consistencia**: Misma estructura de nombres dentro de cada página
4. **Especificidad**: Las clases específicas tienen mayor especificidad que las generales

### Mejores Prácticas

1. **Siempre usar prefijos** para clases específicas de página
2. **No redefinir clases globales** en archivos específicos
3. **Usar variables CSS** para colores y valores comunes
4. **Mantener consistencia** en la estructura de nombres
5. **Documentar cambios** importantes en este archivo

### Conflictos Resueltos

- `.container` → `.archive-container` / `.single-product-container`
- `.precio` → `.archive-product-precio` / `.single-product-precio`
- `.button` → `.archive-ver-detalle-btn` / `.archive-agregar-carrito-btn`
- `.descripcion` → `.archive-product-descripcion` / `.single-product-descripcion`

