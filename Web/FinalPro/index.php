<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Legado Digital S.A. — Custodia de Memoria</title>

<!-- PRO -->
 
<link rel="stylesheet" href="estilos.css">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Libre+Baskerville:wght@400;700&family=Cinzel:wght@400;600;900&family=Source+Code+Pro:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>

<!-- HERO -->
<section class="hero" id="inicio">
  <div class="hero-lines"></div>
  <div class="hero-inner">
    <div class="hero-eyebrow"><span>Legado Digital </span></div>
    <h1 class="hero-title">Cada byte<br>lleva una <span class="accent">historia payo</span></h1>
    <div class="hero-rule"></div>
    <p class="hero-sub">
      Legado Digital S.A. preserva documentos históricos que no pueden perderse.
    </p>
    <button class="btn-primary" onclick="document.getElementById('archivo').scrollIntoView({behavior:'smooth'})"><span>Ver Archivo</span></button>
  </div>
</section>

<!-- ARCHIVO -->
<section id="archivo" class="articles-section">
  <div class="articles-inner">

    <div class="section-tag">Documentos Históricos</div>
    <h2 class="section-title">Nuestro Legado</h2>
    <p class="section-body">
      Colección de documentos históricos custodiados por Legado Digital S.A.
    </p>

    <div class="search-container" style="margin-bottom: 2rem; text-align: center;">
      <input type="text" id="searchInput" placeholder="Buscar por título de artículo..." onkeyup="filtrarArticulos()" style="padding: 10px; width: 80%; max-width: 500px; border: 1px solid var(--gold-dark); border-radius: 5px; background: rgba(0,0,0,0.5); color: var(--text-light); font-family: 'Source Code Pro', monospace;">
    </div>

    <?php include "legado-digital-5.php"; ?>

  </div>
</section>

<!-- FOOTER -->
<footer>
  <p>Legado Digital S.A. · Proyecto Matriz · RFP #2025-LD-MATRIZ</p>
  <p style="margin-top:1rem;">"El olvido es la única muerte definitiva."</p>
</footer>

<!-- MODAL -->
<div id="modal" class="modal">
  <div class="modal-content">

    <button class="modal-close" onclick="cerrarModal()">✕</button>

    <h2 id="modal-titulo"></h2>

    <div class="modal-meta">
      <div><strong>Autor:</strong> <span id="modal-autor"></span></div>
      <div><strong>Fecha:</strong> <span id="modal-fecha"></span></div>
    </div>

    <!-- VISOR PDF -->
    <div id="visor-pdf" style="width:100%;height:65vh;border:1px solid rgba(184,150,62,0.4);margin-bottom:1rem;"></div>

    <!-- DOWNLOAD -->
    <a id="boton-descargar" class="btn-primary" target="_blank"><span>Descargar PDF</span></a>

  </div>
</div>

<script>
function filtrarArticulos() {
  const input = document.getElementById('searchInput');
  const filter = input.value.toLowerCase();
  const contenedor = document.getElementById('articulos');
  if (!contenedor) return;
  const cards = contenedor.getElementsByClassName('article-card');

  for (let i = 0; i < cards.length; i++) {
    const titleObj = cards[i].querySelector('h3');
    if (titleObj) {
      const titleText = titleObj.textContent || titleObj.innerText;
      if (titleText.toLowerCase().indexOf(filter) > -1) {
        cards[i].style.display = "";
      } else {
        cards[i].style.display = "none";
      }
    }
  }
}

function abrirModal(titulo, autor, fecha, ruta_pdf) {

  document.getElementById("modal-titulo").textContent = titulo;
  document.getElementById("modal-autor").textContent = autor;
  document.getElementById("modal-fecha").textHTML = `
    ${ruta_pdf}#toolbar=1&zoom=100
  `;

  document.getElementById("boton-descargar").href = ruta_pdf;

  document.getElementById("modal").classList.add("active");
}

function cerrarModal() {
  document.getElementById("modal").classList.remove("active");
}

document.getElementById("modal").addEventListener("click", e => {
  if (e.target === document.getElementById("modal")) cerrarModal();
});
</script>

</body>
</html>
