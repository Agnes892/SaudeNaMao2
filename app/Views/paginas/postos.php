<!-- filepath: c:\xampp\htdocs\SaudeNaMao\app\Views\paginas\postos.php -->
<div class="container my-4">
  <h2 class="mb-4" style="color:#1e293b; font-weight:800;">Postos de Saúde</h2>
  <!-- Campo de pesquisa com lupa e histórico -->
  <div class="mb-4">
    <div class="input-group" style="width:100%;">
      <input type="text" id="pesquisaPosto" class="form-control" placeholder="Pesquisar posto por nome, bairro ou serviço...">
      <button class="btn btn-outline-secondary" type="button" id="btnPesquisarPosto">
        <i class="fa fa-search"></i>
      </button>
    </div>
    <!-- Histórico de pesquisa -->
    <div id="historicoPesquisaPosto" class="mt-2" style="display:none;">
      <div style="color:#64748b; font-size:0.97rem; font-weight:600;">Histórico de pesquisa:</div>
      <div id="itensHistoricoPosto" class="d-flex flex-wrap gap-2 mt-1"></div>
    </div>
  </div>

  <!-- Mapa dos postos -->
  <div class="mb-4">
    <div style="width:100%; height:350px; border-radius:16px; overflow:hidden; border:1px solid #d6e6f5;">
      <!-- Exemplo com Google Maps embed (ajuste o centro e os marcadores conforme sua cidade) -->
      <iframe
        id="mapaPostos"
        width="100%"
        height="350"
        frameborder="0"
        style="border:0;"
        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15794.123456789!2d-65.338889!3d-10.788889!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zQ2VudHJvIGRlIFNhw6l1ZGUgQWx0YW1pcm8gQmFyb3Nzbw!5e0!3m2!1spt-BR!2sbr!4v1710000000000"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
    <div class="text-muted small mt-1">Arraste e aproxime para ver todos os postos no mapa.</div>
  </div>

  <!-- Lista de postos -->
  <div id="listaPostos">
    <!-- Exemplo de posto -->
    <div class="card mb-3" style="border-radius:16px; border:1px solid #d6e6f5; background:#e0f2fe;">
      <div class="row g-0 align-items-center">
        <div class="col-3 text-center">
          <img src="<?=URL?>/public/img/altamiro.png" alt="Centro de Saúde Altamiro Barroso" class="img-fluid" style="width:100%; height:100px; object-fit:cover;">
        </div>
        <div class="col-9">
          <div class="card-body py-2 px-2" style="color:#1e293b;">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1" style="font-weight:700; color:#1e293b;">Centro de Saúde Altamiro Barroso</h6>
              <button class="btn btn-sm btn-outline-warning rounded-circle favorito-btn" title="Favoritar" type="button">
                <i class="fa fa-star"></i>
              </button>
            </div>
            <div class="mb-1">
              <span class="badge" style="background:#003366; color:#fff; font-size:0.85rem;">Aberto</span>
              <span class="ms-2" style="color:#fbbf24;">★★★★☆</span>
              <span class="text-muted ms-1" style="font-size:0.85rem;">4.2</span>
            </div>
            <div class="mb-1">
              <small class="text-muted">Av. Dr. Lewerger, 4734 - St. 05, Guajará-Mirim - RO</small>
            </div>
            <div class="mb-1">
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Clínica Geral</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Pediatria</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Vacinação</span>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=Av. Dr. Lewerger, 4734 - St. 05, Guajará-Mirim - RO, 76850-000" target="_blank"
               class="btn btn-outline-info btn-sm rounded-pill mt-1 px-3" style="font-size:0.95rem; color:#2563eb; border-color:#bae6fd;">
              Rota no Google Maps
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="border-radius:16px; border:1px solid #d6e6f5; background:#e0f2fe;">
      <div class="row g-0 align-items-center">
        <div class="col-3 text-center">
          <img src="<?=URL?>/public/img/sandoval.png" alt="UBS Sandoval Meira" class="img-fluid" style="width:100%; height:100px; object-fit:cover;">
        </div>
        <div class="col-9">
          <div class="card-body py-2 px-2" style="color:#1e293b;">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1" style="font-weight:700; color:#1e293b;">UBS Sandoval Meira</h6>
              <button class="btn btn-sm btn-outline-warning rounded-circle favorito-btn" title="Favoritar" type="button">
                <i class="fa fa-star"></i>
              </button>
            </div>
            <div class="mb-1">
              <span class="badge" style="background:#003366; color:#fff; font-size:0.85rem;">Aberto</span>
              <span class="ms-2" style="color:#fbbf24;">★★★★☆</span>
              <span class="text-muted ms-1" style="font-size:0.85rem;">4.2</span>
            </div>
            <div class="mb-1">
              <small class="text-muted">Av. José Bonifácio - Serraria</small>
            </div>
            <div class="mb-1">
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Clínica Geral</span>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=Av. Dr. Lewerger, 4734 - St. 05, Guajará-Mirim - RO, 76850-000" target="_blank"
               class="btn btn-outline-info btn-sm rounded-pill mt-1 px-3" style="font-size:0.95rem; color:#2563eb; border-color:#bae6fd;">
              Rota no Google Maps
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="border-radius:16px; border:1px solid #d6e6f5; background:#e0f2fe;">
      <div class="row g-0 align-items-center">
        <div class="col-3 text-center">
          <img src="<?=URL?>/public/img/agostinho.png" alt="UBS Irma M Agostinho Guajara Mirim" class="img-fluid" style="width:100%; height:100px; object-fit:cover;">
        </div>
        <div class="col-9">
          <div class="card-body py-2 px-2" style="color:#1e293b;">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1" style="font-weight:700; color:#1e293b;">UBS Irma M Agostinho Guajara Mirim</h6>
              <button class="btn btn-sm btn-outline-warning rounded-circle favorito-btn" title="Favoritar" type="button">
                <i class="fa fa-star"></i>
              </button>
            </div>
            <div class="mb-1">
              <span class="badge" style="background:#003366; color:#fff; font-size:0.85rem;">Aberto</span>
              <span class="ms-2" style="color:#fbbf24;">★★★★☆</span>
              <span class="text-muted ms-1" style="font-size:0.85rem;">3.8</span>
            </div>
            <div class="mb-1">
              <small class="text-muted">Av. 10 de Abril - St. 02, Guajará-Mirim </small>
            </div>
            <div class="mb-1">
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Clínica Geral</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Vacinação</span>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=Av. 10 de Abril - St. 02, Guajará-Mirim " target="_blank"
               class="btn btn-outline-info btn-sm rounded-pill mt-1 px-3" style="font-size:0.95rem; color:#2563eb; border-color:#bae6fd;">
              Rota no Google Maps
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="border-radius:16px; border:1px solid #d6e6f5; background:#e0f2fe;">
      <div class="row g-0 align-items-center">
        <div class="col-3 text-center">
          <img src="<?=URL?>/public/img/chargas.png" alt="UBS Carlos Chagas Guajara Mirim" class="img-fluid" style="width:100%; height:100px; object-fit:cover;">
        </div>
        <div class="col-9">
          <div class="card-body py-2 px-2" style="color:#1e293b;">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1" style="font-weight:700; color:#1e293b;">UBS Carlos Chagas Guajara Mirim</h6>
              <button class="btn btn-sm btn-outline-warning rounded-circle favorito-btn" title="Favoritar" type="button">
                <i class="fa fa-star"></i>
              </button>
            </div>
            <div class="mb-1">
              <span class="badge" style="background:#003366; color:#fff; font-size:0.85rem;">Aberto</span>
              <span class="ms-2" style="color:#fbbf24;">★★★★☆</span>
              <span class="text-muted ms-1" style="font-size:0.85rem;">4.2</span>
            </div>
            <div class="mb-1">
              <small class="text-muted">Av. 12 de Julho - Tamandaré, Guajará-Mirim</small>
            </div>
            <div class="mb-1">
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Clínica Geral</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Pediatria</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Cardiologista</span>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=Av. 12 de Julho - Tamandaré, Guajará-Mirim" target="_blank"
               class="btn btn-outline-info btn-sm rounded-pill mt-1 px-3" style="font-size:0.95rem; color:#2563eb; border-color:#bae6fd;">
              Rota no Google Maps
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="border-radius:16px; border:1px solid #d6e6f5; background:#e0f2fe;">
      <div class="row g-0 align-items-center">
        <div class="col-3 text-center">
          <img src="<?=URL?>/public/img/stoff.jpg" alt="UBS Irma Maria Salete Stoff" class="img-fluid" style="width:100%; height:100px; object-fit:cover;">
        </div>
        <div class="col-9">
          <div class="card-body py-2 px-2" style="color:#1e293b;">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1" style="font-weight:700; color:#1e293b;">UBS Irma Maria Salete Stoff</h6>
              <button class="btn btn-sm btn-outline-warning rounded-circle favorito-btn" title="Favoritar" type="button">
                <i class="fa fa-star"></i>
              </button>
            </div>
            <div class="mb-1">
              <span class="badge" style="background:#003366; color:#fff; font-size:0.85rem;">Aberto</span>
              <span class="ms-2" style="color:#fbbf24;">★★★★☆</span>
              <span class="text-muted ms-1" style="font-size:0.85rem;">4.2</span>
            </div>
            <div class="mb-1">
              <small class="text-muted">Guajará-Mirim, RO</small>
            </div>
            <div class="mb-1">
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Clínica Geral</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Pediatria</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Vacinação</span>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=Guajará-Mirim, RO, 76850-000" target="_blank"
               class="btn btn-outline-info btn-sm rounded-pill mt-1 px-3" style="font-size:0.95rem; color:#2563eb; border-color:#bae6fd;">
              Rota no Google Maps
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="border-radius:16px; border:1px solid #d6e6f5; background:#e0f2fe;">
      <div class="row g-0 align-items-center">
        <div class="col-3 text-center">
          <img src="<?=URL?>/public/img/socorro.png" alt="Hospital Municipal Perpétuo Socorro" class="img-fluid" style="width:100%; height:100px; object-fit:cover;">
        </div>
        <div class="col-9">
          <div class="card-body py-2 px-2" style="color:#1e293b;">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1" style="font-weight:700; color:#1e293b;">Hospital Municipal Perpétuo Socorro</h6>
              <button class="btn btn-sm btn-outline-warning rounded-circle favorito-btn" title="Favoritar" type="button">
                <i class="fa fa-star"></i>
              </button>
            </div>
            <div class="mb-1">
              <span class="badge" style="background:#003366; color:#fff; font-size:0.85rem;">Aberto</span>
              <span class="ms-2" style="color:#fbbf24;">★★★★☆</span>
              <span class="text-muted ms-1" style="font-size:0.85rem;">3.0</span>
            </div>
            <div class="mb-1">
              <small class="text-muted">Av. Mal. Deodoro, S/N - Centro, Guajará-Mirim - RO</small>
            </div>
            <div class="mb-1">
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Clínica Geral</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Cardiologista</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Terapeuta</span>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=Av. Mal. Deodoro, S/N - Centro, Guajará-Mirim - RO, 76850-000" target="_blank"
               class="btn btn-outline-info btn-sm rounded-pill mt-1 px-3" style="font-size:0.95rem; color:#2563eb; border-color:#bae6fd;">
              Rota no Google Maps
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="border-radius:16px; border:1px solid #d6e6f5; background:#e0f2fe;">
      <div class="row g-0 align-items-center">
        <div class="col-3 text-center">
          <img src="<?=URL?>/public/img/julio.png" alt="Hospital De Guajará-Mirim" class="img-fluid" style="width:100%; height:100px; object-fit:cover;">
        </div>
        <div class="col-9">
          <div class="card-body py-2 px-2" style="color:#1e293b;">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-1" style="font-weight:700; color:#1e293b;">Hospital De Guajará-Mirim</h6>
              <button class="btn btn-sm btn-outline-warning rounded-circle favorito-btn" title="Favoritar" type="button">
                <i class="fa fa-star"></i>
              </button>
            </div>
            <div class="mb-1">
              <span class="badge" style="background:#003366; color:#fff; font-size:0.85rem;">Fechado</span>
              <span class="ms-2" style="color:#fbbf24;">★★★★★</span>
              <span class="text-muted ms-1" style="font-size:0.85rem;">5.0</span>
            </div>
            <div class="mb-1">
              <small class="text-muted">Santa Luzia, Guajará-Mirim - RO, 76850-000</small>
            </div>
            <div class="mb-1">
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Clínica Geral</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Pediatria</span>
              <span class="badge" style="font-size:0.8rem; background:#bae6fd; color:#1e293b;">Vacinação</span>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination=Santa Luzia, Guajará-Mirim - RO, 76850-000" target="_blank"
               class="btn btn-outline-info btn-sm rounded-pill mt-1 px-3" style="font-size:0.95rem; color:#2563eb; border-color:#bae6fd;">
              Rota no Google Maps
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
