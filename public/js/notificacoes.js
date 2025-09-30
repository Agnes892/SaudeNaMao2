// ========================================
// CONTROLE DE NOTIFICAÇÕES NO HEADER
// ========================================

// Dados das notificações do header
const notificacoesHeader = [
    {
        id: 'notificacao1',
        titulo: 'Vacinação contra gripe prorrogada',
        resumo: 'A campanha foi prorrogada até 30/09.',
        horario: 'Hoje, 09:30'
    },
    {
        id: 'notificacao2', 
        titulo: 'Alteração no horário do posto central',
        resumo: 'Funcionamento das 8h às 14h nesta semana.',
        horario: 'Ontem, 16:00'
    },
    {
        id: 'notificacao3',
        titulo: 'Campanha Outubro Rosa começa semana que vem',
        resumo: 'Haverá exames gratuitos e palestras.',
        horario: '25/09, 11:00'
    },
    {
        id: 'notificacao4',
        titulo: 'Novo posto de saúde inaugurado',
        resumo: 'UBS São José já está funcionando.',
        horario: '24/09, 14:30'
    },
    {
        id: 'notificacao5',
        titulo: 'Atualização no aplicativo',
        resumo: 'Nova versão com melhorias disponível.',
        horario: '23/09, 10:15'
    }
];

let notificacoesVisiveis = 2; // Inicialmente mostra apenas 2

// Funções helper para controlar o dropdown
function mostrarDropdown(dropdown) {
    dropdown.style.display = 'block';
    dropdown.style.opacity = '0';
    dropdown.style.transform = 'translateY(-5px) scale(0.95)';
    setTimeout(() => {
        dropdown.style.opacity = '1';
        dropdown.style.transform = 'translateY(0) scale(1)';
    }, 10);
}

function esconderDropdown(dropdown) {
    dropdown.style.opacity = '0';
    dropdown.style.transform = 'translateY(-5px) scale(0.95)';
    setTimeout(() => {
        dropdown.style.display = 'none';
    }, 250);
}

// Função para atualizar o badge de notificações
function atualizarBadgeNotificacoes() {
    const badge = document.getElementById('badgeNotificacao');
    const totalNotificacoes = notificacoesHeader.length;
    
    if (badge) {
        badge.textContent = totalNotificacoes;
        
        // Se não houver notificações, esconde o badge
        if (totalNotificacoes === 0) {
            badge.style.display = 'none';
        } else {
            badge.style.display = 'flex';
        }
    }
}

// Função para renderizar notificações no header
function renderizarNotificacoesHeader() {
    const dropdown = document.getElementById('notificacoesDropdown');
    if (!dropdown) return;
    
    const notificacoesParaMostrar = notificacoesHeader.slice(0, notificacoesVisiveis);
    const temMais = notificacoesVisiveis < notificacoesHeader.length;
    
    let html = '<div class="p-3 border-bottom" style="font-weight:600; color:#1f5461ff;">Notificações</div>';
    
    notificacoesParaMostrar.forEach(notif => {
        html += `
            <div class="p-3 border-bottom notificacao-item" data-id="${notif.id}" style="cursor:pointer; transition: background-color 0.2s;">
                <div style="font-weight:bold; color:#000;">${notif.titulo}</div>
                <div class="text-muted small">${notif.resumo}</div>
                <div class="text-muted" style="font-size:0.75rem; margin-top:4px;">${notif.horario}</div>
            </div>
        `;
    });
    
    // Botão "Ver mais" ou "Ver todas"
    if (temMais) {
        html += `
            <div class="p-3 text-center">
                <button id="verMaisNotificacoes" class="btn btn-ver-mais-notificacoes">
                    Ver mais notificações
                </button>
            </div>
        `;
    } else {
        html += `
            <div class="p-3 text-center">
                <button id="verTodasNotificacoes" class="btn btn-ver-mais-notificacoes" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;">
                    Ver todas notificações
                </button>
            </div>
        `;
    }
    
    dropdown.innerHTML = html;
    
    // Adicionar eventos de hover nas notificações
    document.querySelectorAll('.notificacao-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8fafc';
        });
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
        
        // Evento de clique na notificação
        item.addEventListener('click', function() {
            const notifId = this.getAttribute('data-id');
            abrirNotificacao(notifId);
            // Fechar dropdown
            esconderDropdown(dropdown);
        });
    });
    
    // Evento do botão "Ver mais"
    const btnVerMais = document.getElementById('verMaisNotificacoes');
    if (btnVerMais) {
        btnVerMais.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            notificacoesVisiveis = Math.min(notificacoesVisiveis + 2, notificacoesHeader.length);
            renderizarNotificacoesHeader();
            // Mantém o dropdown aberto
            mostrarDropdown(dropdown);
        });
    }
    
    // Evento do botão "Ver todas"  
    const btnVerTodas = document.getElementById('verTodasNotificacoes');
    if (btnVerTodas) {
        btnVerTodas.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            // Aqui você pode redirecionar para uma página de todas as notificações
            alert('Redirecionando para página de todas as notificações...');
            esconderDropdown(dropdown);
        });
    }
}

// Exibe/oculta a aba de notificações ao clicar no sino
document.addEventListener('DOMContentLoaded', function() {
    // Aguarda um pouco para garantir que o DOM esteja completo
    setTimeout(function() {
        var btn = document.getElementById('btnNotificacoes');
        var dropdown = document.getElementById('notificacoesDropdown');
        
        if (btn && dropdown) {
            // Renderizar notificações iniciais
            renderizarNotificacoesHeader();
            // Atualizar badge
            atualizarBadgeNotificacoes();
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Toggle simples com display
                if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                    mostrarDropdown(dropdown);
                } else {
                    esconderDropdown(dropdown);
                }
            });
            
            // Previne o fechamento quando clicar dentro do dropdown
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Fecha o dropdown quando clicar fora
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                    esconderDropdown(dropdown);
                }
            });
        }
    }, 100);
});

// ========================================
// SISTEMA DE NOTIFICAÇÕES - HOME
// ========================================

// Dados fictícios das notificações completas
const notificacoesSidebar = {
    notificacao1: {
        icone: "/SaudeNaMao/public/img/megafone.png",
        titulo: "Vacinação contra gripe prorrogada",
        resumo: "A campanha de vacinação contra gripe foi prorrogada até o dia 30/09.",
        horario: "Hoje, 09:30",
        texto: "A campanha de vacinação contra gripe foi prorrogada até o dia 30/09. Procure o posto mais próximo e mantenha sua vacinação em dia. Leve seu cartão de vacinação e documento com foto.",
        local: "UBS Central",
        data: "30/09/2025",
        autor: "Secretaria Municipal de Saúde"
    },
    notificacao2: {
        icone: "/SaudeNaMao/public/img/relogio.png",
        titulo: "Alteração no horário do posto central",
        resumo: "O posto central funcionará das 8h às 14h nesta semana.",
        horario: "Ontem, 16:00",
        texto: "Informamos que, excepcionalmente nesta semana, o posto central funcionará das 8h às 14h devido à manutenção elétrica. Para emergências, procure a UPA mais próxima.",
        local: "UBS Central",
        data: "27/09/2025",
        autor: "Secretaria Municipal de Saúde"
    },
    notificacao3: {
        icone: "/SaudeNaMao/public/img/lampada.png",
        titulo: "Campanha Outubro Rosa começa semana que vem",
        resumo: "Haverá exames gratuitos e palestras em todos os postos de saúde.",
        horario: "25/09, 11:00",
        texto: "Participe da campanha Outubro Rosa para prevenção do câncer de mama. Haverá exames gratuitos e palestras de conscientização em todos os postos de saúde da cidade.",
        local: "Todas as UBS",
        data: "01/10/2025",
        autor: "Secretaria Municipal de Saúde"
    },
    notificacao4: {
        icone: "/SaudeNaMao/public/img/info.png",
        titulo: "Novo posto de saúde inaugurado",
        resumo: "UBS São José já está funcionando.",
        horario: "24/09, 14:30",
        texto: "Foi inaugurada a nova UBS São José, oferecendo atendimento completo em clínica geral, pediatria e vacinação. Horário de funcionamento: segunda a sexta das 7h às 17h.",
        local: "UBS São José",
        data: "24/09/2025",
        autor: "Prefeitura Municipal"
    },
    notificacao5: {
        icone: "/SaudeNaMao/public/img/bell.png",
        titulo: "Atualização no aplicativo",
        resumo: "Nova versão com melhorias disponível.",
        horario: "23/09, 10:15",
        texto: "Nova versão do aplicativo Saúde na Mão disponível! Inclui melhorias na navegação, correção de bugs e novas funcionalidades para agendamento de consultas.",
        local: "Aplicativo",
        data: "23/09/2025",
        autor: "Equipe de Desenvolvimento"
    }
};

function abrirNotificacao(id) {
    const n = notificacoesSidebar[id];
    document.getElementById('notificacaoIcone').src = n.icone;
    document.getElementById('notificacaoTituloSidebar').innerText = n.titulo;
    document.getElementById('notificacaoResumoSidebar').innerText = n.resumo;
    document.getElementById('notificacaoHorarioSidebar').innerText = n.horario;
    document.getElementById('notificacaoTextoSidebar').innerText = n.texto;
    document.getElementById('notificacaoLocalSidebar').innerText = n.local;
    document.getElementById('notificacaoDataSidebar').innerText = n.data;
    document.getElementById('notificacaoAutorSidebar').innerText = n.autor;
    document.getElementById('notificacaoSidebar').style.display = 'block';
    document.getElementById('notificacaoSidebarOverlay').style.display = 'block';
    setTimeout(() => {
        document.getElementById('notificacaoSidebar').style.right = '0';
    }, 10);
    document.body.style.overflow = 'hidden';
}

function fecharNotificacaoSidebar() {
    document.getElementById('notificacaoSidebar').style.right = '-400px';
    setTimeout(() => {
        document.getElementById('notificacaoSidebar').style.display = 'none';
        document.getElementById('notificacaoSidebarOverlay').style.display = 'none';
        document.body.style.overflow = '';
    }, 250);
}

function compartilharNotificacao() {
    alert('Link para compartilhamento copiado!');
}

// ========================================
// SISTEMA DE CAMPANHAS - HOME
// ========================================

// Dados fictícios das campanhas completas (Modal)
const campanhas = {
    campanha1: {
        titulo: "Março Lilás: Prevenção do Câncer do Colo do Útero",
        conteudo: `
            <p><b>Categoria:</b> Prevenção</p>
            <p><b>Data de publicação:</b> 25/09/2025</p>
            <p><b>Visualizações:</b> 1.234</p>
            <p>
              A campanha Março Lilás visa conscientizar sobre a importância do exame preventivo do câncer do colo do útero. Durante todo o mês, as UBSs estarão realizando exames gratuitos e distribuindo materiais informativos.
            </p>
            <hr>
            <b>Feedback de pessoas:</b>
            <ul>
              <li><b>Maria S.:</b> "Fui muito bem atendida, recomendo a todas!"</li>
              <li><b>Juliana P.:</b> "Campanha essencial para nossa saúde."</li>
            </ul>
        `
    },
    campanha2: {
        titulo: "Campanha Nacional de Vacinação contra Gripe",
        conteudo: `
            <p><b>Categoria:</b> Vacinação</p>
            <p><b>Data de publicação:</b> 20/09/2025</p>
            <p><b>Visualizações:</b> 2.045</p>
            <p>
              A vacinação contra gripe está disponível para crianças, idosos, gestantes e profissionais da saúde. Não perca o prazo e mantenha sua carteira de vacinação em dia!
            </p>
            <hr>
            <b>Feedback de pessoas:</b>
            <ul>
              <li><b>Carlos M.:</b> "Vacinei toda a família, atendimento rápido."</li>
              <li><b>Fernanda L.:</b> "Muito importante para evitar doenças."</li>
            </ul>
        `
    },
    campanha3: {
        titulo: "Setembro Amarelo: Valorização da Vida",
        conteudo: `
            <p><b>Categoria:</b> Conscientização</p>
            <p><b>Data de publicação:</b> 15/09/2025</p>
            <p><b>Visualizações:</b> 3.012</p>
            <p>
              O Setembro Amarelo promove ações de valorização da vida e prevenção ao suicídio. Participe das palestras e procure apoio psicológico nas UBSs.
            </p>
            <hr>
            <b>Feedback de pessoas:</b>
            <ul>
              <li><b>Lucas R.</b> "As palestras foram esclarecedoras."</li>
              <li><b>Patrícia D.</b> "Muito bom saber que temos esse apoio."</li>
            </ul>
        `
    }
};

function abrirCampanha(id) {
    document.getElementById('campanhaTitulo').innerHTML = campanhas[id].titulo;
    document.getElementById('campanhaConteudo').innerHTML = campanhas[id].conteudo;
    document.getElementById('campanhaModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function fecharCampanha() {
    document.getElementById('campanhaModal').style.display = 'none';
    document.body.style.overflow = '';
}

// Dados das campanhas para sidebar
const campanhasSidebar = {
    campanha1: {
        imagem: "/SaudeNaMao/public/img/marcoLilas.jpg",
        titulo: "Março Lilás: Prevenção do Câncer do Colo do Útero",
        resumo: "Campanha de prevenção e conscientização sobre o câncer do colo do útero.",
        data: "01/03/2025 a 31/03/2025",
        bairros: "Centro, Jardim das Palmeiras, Nova Esperança",
        publico: "Mulheres de 25 a 64 anos",
        ubs: "Centro de Saúde Altamiro Barroso",
        horarios: "Seg a Sex: 07h às 17h<br>Sábado: 08h às 12h",
        acoes: [
            "Exames preventivos gratuitos",
            "Palestras educativas",
            "Distribuição de materiais informativos",
            "Atendimento psicológico"
        ],
        contato: "Telefone: (69) 1234-5678<br>Email: altamiro@saude.gov.br",
        comentarios: [
            {nome: "Maria S.", texto: "Fui muito bem atendida, recomendo a todas!"},
            {nome: "Juliana P.", texto: "Campanha essencial para nossa saúde."}
        ]
    },
    campanha2: {
        imagem: "/SaudeNaMao/public/img/vacina.jpg",
        titulo: "Campanha Nacional de Vacinação contra Gripe",
        resumo: "Vacinação contra gripe para públicos prioritários em toda a cidade.",
        data: "20/09/2025 a 30/09/2025",
        bairros: "Todos os bairros",
        publico: "Crianças, idosos, gestantes, profissionais da saúde",
        ubs: "Centro de Saúde Irmã Maria Agostinho",
        horarios: "Seg a Sex: 08h às 16h<br>Sábado: 08h às 12h",
        acoes: [
            "Vacinação gratuita",
            "Orientação sobre prevenção",
            "Atualização da carteira de vacinação"
        ],
        contato: "Telefone: (69) 2345-6789<br>Email: agostinho@saude.gov.br",
        comentarios: [
            {nome: "Carlos M.", texto: "Vacinei toda a família, atendimento rápido."},
            {nome: "Fernanda L.", texto: "Muito importante para evitar doenças."}
        ]
    },
    campanha3: {
        imagem: "/SaudeNaMao/public/img/setembroAmarelo.jpg",
        titulo: "Setembro Amarelo: Valorização da Vida",
        resumo: "Ações de valorização da vida e prevenção ao suicídio.",
        data: "01/09/2025 a 30/09/2025",
        bairros: "Centro, Tamandaré, Dez de Abril",
        publico: "Toda a população",
        ubs: "Centro de Saúde Carlos Chagas",
        horarios: "Seg a Sex: 07h às 17h",
        acoes: [
            "Palestras sobre saúde mental",
            "Rodas de conversa",
            "Atendimento psicológico",
            "Distribuição de materiais informativos"
        ],
        contato: "Telefone: (69) 3456-7890<br>Email: chagas@saude.gov.br",
        comentarios: [
            {nome: "Lucas R.", texto: "As palestras foram esclarecedoras."},
            {nome: "Patrícia D.", texto: "Muito bom saber que temos esse apoio."}
        ]
    }
};

let campanhaAtual = null;

function abrirCampanhaSidebar(id) {
    campanhaAtual = id;
    const c = campanhasSidebar[id];
    document.getElementById('campanhaImagemSidebar').src = c.imagem;
    document.getElementById('campanhaTituloSidebar').innerText = c.titulo;
    document.getElementById('campanhaResumoSidebar').innerText = c.resumo;
    document.getElementById('campanhaDataSidebar').innerText = c.data;
    document.getElementById('campanhaBairrosSidebar').innerText = c.bairros;
    document.getElementById('campanhaPublicoSidebar').innerText = c.publico;
    document.getElementById('campanhaUBSSidebar').innerText = c.ubs;
    document.getElementById('campanhaHorariosSidebar').innerHTML = c.horarios;
    // Ações
    let acoesHtml = '';
    c.acoes.forEach(a => { acoesHtml += `<li>${a}</li>`; });
    document.getElementById('campanhaAcoesSidebar').innerHTML = acoesHtml;
    // Contato
    document.getElementById('campanhaContatoSidebar').innerHTML = c.contato;
    // Comentários
    renderizarComentarios();
    // Exibe a sidebar
    document.getElementById('campanhaSidebar').style.display = 'block';
    document.getElementById('campanhaSidebarOverlay').style.display = 'block';
    setTimeout(() => {
        document.getElementById('campanhaSidebar').style.right = '0';
    }, 10);
    document.body.style.overflow = 'hidden';
}

function fecharCampanhaSidebar() {
    document.getElementById('campanhaSidebar').style.right = '-440px';
    setTimeout(() => {
        document.getElementById('campanhaSidebar').style.display = 'none';
        document.getElementById('campanhaSidebarOverlay').style.display = 'none';
        document.body.style.overflow = '';
    }, 250);
}

// Sistema de comentários das campanhas
function renderizarComentarios() {
    const comentariosDiv = document.getElementById('comentariosCampanhaSidebar');
    const comentarios = campanhasSidebar[campanhaAtual].comentarios;
    comentariosDiv.innerHTML = comentarios.length
        ? comentarios.map(c => `<div class="mb-2"><b>${c.nome}:</b> <span>${c.texto}</span></div>`).join('')
        : '<div class="text-muted">Nenhum comentário ainda.</div>';
}

// Inicializar sistema de comentários
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formComentarioCampanha');
    if(form){
        form.onsubmit = function(e){
            e.preventDefault();
            const input = document.getElementById('comentarioInput');
            const texto = input.value.trim();
            if(texto && campanhaAtual){
                campanhasSidebar[campanhaAtual].comentarios.push({nome: "Você", texto});
                input.value = '';
                renderizarComentarios();
            }
        }
    }
});

// ========================================
// SISTEMA DE PESQUISA DE VÍDEOS - SAÚDE
// ========================================

// Histórico de pesquisa simples usando localStorage
document.addEventListener('DOMContentLoaded', function() {
    const campoPesquisa = document.getElementById('campoPesquisaVideo');
    const btnPesquisar = document.getElementById('btnPesquisarVideo');
    const historicoDiv = document.getElementById('historicoPesquisaVideo');
    const itensHistorico = document.getElementById('itensHistoricoVideo');

    if (campoPesquisa && btnPesquisar) {
        function atualizarHistorico() {
            let historico = JSON.parse(localStorage.getItem('historicoPesquisaVideo') || '[]');
            if (historico.length > 0 && historicoDiv && itensHistorico) {
                historicoDiv.style.display = '';
                itensHistorico.innerHTML = '';
                historico.slice(-5).reverse().forEach(item => {
                    const span = document.createElement('span');
                    span.className = 'badge rounded-pill';
                    span.style.background = '#fafdff';
                    span.style.color = '#2563eb';
                    span.style.cursor = 'pointer';
                    span.textContent = item;
                    span.onclick = () => { campoPesquisa.value = item; };
                    itensHistorico.appendChild(span);
                });
            } else if (historicoDiv) {
                historicoDiv.style.display = 'none';
            }
        }

        function adicionarAoHistorico(valor) {
            if (!valor.trim()) return;
            let historico = JSON.parse(localStorage.getItem('historicoPesquisaVideo') || '[]');
            historico = historico.filter(item => item !== valor);
            historico.push(valor);
            localStorage.setItem('historicoPesquisaVideo', JSON.stringify(historico));
            atualizarHistorico();
        }

        btnPesquisar.onclick = function() {
            adicionarAoHistorico(campoPesquisa.value);
            // Aqui você pode adicionar a lógica de pesquisa real
        };

        campoPesquisa.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                adicionarAoHistorico(campoPesquisa.value);
                // Aqui você pode adicionar a lógica de pesquisa real
            }
        });

        atualizarHistorico();
    }
});

// ========================================
// SISTEMA DE PESQUISA DE POSTOS - POSTOS
// ========================================

// Histórico de pesquisa simples usando localStorage para postos
document.addEventListener('DOMContentLoaded', function() {
    const campoPesquisaPosto = document.getElementById('pesquisaPosto');
    const btnPesquisarPosto = document.getElementById('btnPesquisarPosto');
    const historicoDivPosto = document.getElementById('historicoPesquisaPosto');
    const itensHistoricoPosto = document.getElementById('itensHistoricoPosto');

    if (campoPesquisaPosto && btnPesquisarPosto) {
        function atualizarHistoricoPosto() {
            let historico = JSON.parse(localStorage.getItem('historicoPesquisaPosto') || '[]');
            if (historico.length > 0 && historicoDivPosto && itensHistoricoPosto) {
                historicoDivPosto.style.display = '';
                itensHistoricoPosto.innerHTML = '';
                historico.slice(-5).reverse().forEach(item => {
                    const span = document.createElement('span');
                    span.className = 'badge rounded-pill';
                    span.style.background = '#fafdff';
                    span.style.color = '#2563eb';
                    span.style.cursor = 'pointer';
                    span.textContent = item;
                    span.onclick = () => { campoPesquisaPosto.value = item; };
                    itensHistoricoPosto.appendChild(span);
                });
            } else if (historicoDivPosto) {
                historicoDivPosto.style.display = 'none';
            }
        }

        function adicionarAoHistoricoPosto(valor) {
            if (!valor.trim()) return;
            let historico = JSON.parse(localStorage.getItem('historicoPesquisaPosto') || '[]');
            historico = historico.filter(item => item !== valor);
            historico.push(valor);
            localStorage.setItem('historicoPesquisaPosto', JSON.stringify(historico));
            atualizarHistoricoPosto();
        }

        btnPesquisarPosto.onclick = function() {
            adicionarAoHistoricoPosto(campoPesquisaPosto.value);
            // Aqui você pode adicionar a lógica de pesquisa real
        };

        campoPesquisaPosto.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                adicionarAoHistoricoPosto(campoPesquisaPosto.value);
                // Aqui você pode adicionar a lógica de pesquisa real
            }
        });

        // Filtro visual dos cards (mantém o filtro anterior)
        campoPesquisaPosto.addEventListener('input', function() {
            var termo = this.value.toLowerCase();
            const listaPostos = document.getElementById('listaPostos');
            if (listaPostos) {
                listaPostos.querySelectorAll('.card').forEach(function(card) {
                    card.style.display = card.innerText.toLowerCase().includes(termo) ? '' : 'none';
                });
            }
        });

        atualizarHistoricoPosto();
    }
});

// ========================================
// SISTEMA FAQ - SUPORTE
// ========================================

// FAQ toggle
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            var id = this.getAttribute('data-faq');
            var content = document.getElementById(id);
            if(content && (content.style.display === 'none' || content.style.display === '')){
                document.querySelectorAll('.faq-content').forEach(function(div){ 
                    div.style.display = 'none'; 
                });
                content.style.display = 'block';
            } else if(content) {
                content.style.display = 'none';
            }
        });
    });
});
