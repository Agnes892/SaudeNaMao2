
<!-- filepath: c:\xampp\htdocs\SaudeNaMao\app\Views\paginas\suporte.php -->
<div class="container my-4" style="max-width:700px;">

  <!-- Sobre o App -->
  <div class="mb-4 p-3 rounded" style="background:#e0f2fe;">
    <div style="font-weight:700; color:#2563eb; font-size:1.2rem;">Saúde na Mão</div>
    <div style="color:#1e293b;">Versão 1.0.0</div>
    <div style="color:#64748b;">Desenvolvido por Equipe Saúde Digital</div>
  </div>

  <!-- Canais de Suporte -->
  <div class="mb-4 p-3 rounded" style="background:#fafdff; border:1px solid #e0f2fe;">
    <div style="font-weight:700; color:#2563eb; margin-bottom:8px;">Canais de Suporte</div>
    <!-- Chat -->
    <div class="mb-3">
      <div style="font-weight:600; color:#1e293b;">Chat de Suporte</div>
      <div style="color:#64748b;">Converse em tempo real com nossa equipe para dúvidas rápidas.</div>
      <div style="color:#64748b;">Horário: Seg a Sex, 08h às 18h</div>
      <button class="btn btn-sm rounded-pill px-4 mt-2" style="background:#2563eb; color:#fff;">
        Iniciar Chat
      </button>
    </div>
    <!-- Email -->
    <div class="mb-3">
      <div style="font-weight:600; color:#1e293b;">Email de Suporte</div>
      <div style="color:#64748b;">Envie sua dúvida ou solicitação por email. Resposta em até 1 dia útil.</div>
      <div style="color:#64748b;">E-mail: <b>suporte@saudedigital.com.br</b></div>
      <a href="mailto:suporte@saudedigital.com.br" class="btn btn-sm rounded-pill px-4 mt-2" style="background:#2563eb; color:#fff;">
        Enviar Email
      </a>
    </div>
    <!-- Telefone -->
    <div>
      <div style="font-weight:600; color:#1e293b;">Telefone de Suporte</div>
      <div style="color:#64748b;">Fale diretamente com nossa equipe de atendimento.</div>
      <div style="color:#64748b;">Número: <b>(69) 99999-0000</b></div>
      <div style="color:#64748b;">Horário: Seg a Sex, 08h às 18h</div>
      <a href="tel:+5569999990000" class="btn btn-sm rounded-pill px-4 mt-2" style="background:#2563eb; color:#fff;">
        Ligar Agora
      </a>
    </div>
  </div>

  <!-- Reportar Problemas -->
  <div class="mb-4 p-3 rounded" style="background:#e0f2fe;">
    <div style="font-weight:700; color:#2563eb; margin-bottom:8px;">Reportar Problemas</div>
    <form>
      <div class="mb-2">
        <label class="form-label" for="bug">Reportar Bug</label>
        <textarea id="bug" class="form-control" rows="2" placeholder="Descreva o bug encontrado"></textarea>
      </div>
      <div class="mb-2">
        <label class="form-label" for="melhoria">Sugerir Melhoria</label>
        <textarea id="melhoria" class="form-control" rows="2" placeholder="Descreva sua sugestão"></textarea>
      </div>
      <div class="mb-2">
        <label class="form-label" for="duvida">Dúvida Técnica</label>
        <textarea id="duvida" class="form-control" rows="2" placeholder="Descreva sua dúvida"></textarea>
      </div>
      <button type="submit" class="btn btn-sm rounded-pill px-4 mt-2" style="background:#2563eb; color:#fff;">
        Enviar
      </button>
    </form>
  </div>

  <!-- Perguntas Frequentes -->
  <div class="mb-4 p-3 rounded" style="background:#fafdff; border:1px solid #e0f2fe;">
    <div style="font-weight:700; color:#2563eb; margin-bottom:8px;">Perguntas Frequentes</div>
    <div>
      <button class="faq-btn btn btn-link text-start w-100" type="button" data-faq="faq1" style="color:#1e293b; font-weight:600;">Como acesso minha carteira de vacinação?</button>
      <div class="faq-content" id="faq1" style="display:none; color:#334155; margin-bottom:8px;">
        Acesse o menu "Meu SUS Digital" e faça login para visualizar sua carteira de vacinação digital.
      </div>
      <button class="faq-btn btn btn-link text-start w-100" type="button" data-faq="faq2" style="color:#1e293b; font-weight:600;">Como agendar uma consulta?</button>
      <div class="faq-content" id="faq2" style="display:none; color:#334155; margin-bottom:8px;">
        Procure a unidade de saúde mais próxima ou utilize o aplicativo para verificar a disponibilidade de agendamento.
      </div>
      <button class="faq-btn btn btn-link text-start w-100" type="button" data-faq="faq3" style="color:#1e293b; font-weight:600;">Como atualizar meus dados cadastrais?</button>
      <div class="faq-content" id="faq3" style="display:none; color:#334155; margin-bottom:8px;">
        No menu "Meu Perfil", clique em "Editar Dados" e salve as alterações após preencher os campos.
      </div>
    </div>
  </div>

  <!-- Recursos Adicionais -->
  <div class="mb-4 p-3 rounded" style="background:#e0f2fe;">
    <div style="font-weight:700; color:#2563eb; margin-bottom:8px;">Recursos Adicionais</div>
    <ul style="color:#1e293b; padding-left:18px;">
      <li>
        <a href="https://www.gov.br/saude/pt-br" target="_blank" style="color:#2563eb; text-decoration:underline;">
          Portal do Ministério da Saúde
        </a>
      </li>
      <li>
        <a href="https://www.gov.br/saude/pt-br/assuntos/saude-digital/meu-sus-digital" target="_blank" style="color:#2563eb; text-decoration:underline;">
          Informações sobre o SUS Digital
        </a>
      </li>
    </ul>
  </div>
</div>