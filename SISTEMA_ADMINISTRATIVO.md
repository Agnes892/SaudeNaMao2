# Sistema Administrativo - Saúde na Mão

## 🎉 Implementação Completa!

O sistema administrativo do portal **Saúde na Mão** foi totalmente implementado com todas as funcionalidades solicitadas.

## 📋 Funcionalidades Implementadas

### ✅ Gestão de Conteúdo
- **Editor de Páginas**: Editor WYSIWYG com TinyMCE para editar conteúdo das páginas (home, sobre, saúde, postos, emergência)
- **SEO**: Campos para título, meta description e palavras-chave
- **Preview**: Visualização das páginas em tempo real

### ✅ Gestão de Unidades de Saúde
- **CRUD Completo**: Adicionar, listar, editar e excluir unidades
- **Geolocalização**: Suporte a coordenadas GPS para localização
- **Busca por Proximidade**: Algoritmo de busca por distância usando fórmula de Haversine
- **Especialidades**: Controle de especialidades médicas por unidade

### ✅ Gestão de Usuários
- **Relatórios**: Estatísticas e listagem de usuários
- **Controle de Acesso**: Sistema de permissões por tipo de usuário

### ✅ Configurações do Sistema
- **Configurações Globais**: Nome do site, contatos, endereço
- **SEO Global**: Meta descriptions e palavras-chave padrão
- **Validação**: Sistema de validação por tipo de configuração

### ✅ Ferramentas Administrativas
- **Backup**: Geração de backup do banco de dados
- **API**: Interface para integração com sistemas externos
- **Logs**: Sistema de auditoria e logs

## 🗂️ Estrutura de Arquivos Criados

### Controllers
- `app/Controllers/AdminPanel.php` - Controller principal com todas as funcionalidades administrativas

### Models
- `app/Models/Conteudo.php` - Gerenciamento de páginas e conteúdo
- `app/Models/UnidadeSaude.php` - Gestão de unidades de saúde
- `app/Models/Configuracao.php` - Configurações do sistema

### Views
- `app/Views/admin/editarPagina.php` - Editor de conteúdo com TinyMCE

### Helpers
- `app/Helpers/Auth.php` - Sistema de autenticação expandido

### Scripts Auxiliares
- `setup.php` - Página de configuração inicial
- `login_admin.php` - Login temporário como administrador
- `inicializar_admin.php` - Script de inicialização das tabelas

### Assets
- `public/js/painelAdmin.js` - JavaScript atualizado com rotas funcionais

## 🚀 Como Usar o Sistema

### 1. Primeira Configuração
1. Acesse: `http://localhost/SaudeNaMao/setup.php`
2. Clique em **"Inicializar Sistema"** para criar as tabelas
3. Clique em **"Login como Admin"** para fazer login administrativo

### 2. Acesso ao Painel Administrativo
- **URL**: `http://localhost/SaudeNaMao/usuarios/painelAdmin`
- **Requisito**: Login como administrador

### 3. Funcionalidades Principais

#### Editar Conteúdo das Páginas
- Clique em **"Editar Página"** no painel
- Escolha a página desejada (Home, Sobre, Saúde, Postos, Emergência)
- Use o editor TinyMCE para editar o conteúdo
- Configure SEO (título, meta description, palavras-chave)

#### Gerenciar Unidades de Saúde
- Acesse **"Unidades de Saúde"** no painel
- **Adicionar**: Cadastre novas unidades com endereço e especialidades
- **Listar**: Visualize e gerencie unidades existentes
- **Localização**: Sistema automático de coordenadas GPS

#### Configurações do Sistema
- Acesse **"Configurações"** no painel
- Edite informações globais do site
- Configure contatos e endereços
- Ajuste configurações de SEO

## 🛠️ Estrutura Técnica

### Banco de Dados
O sistema cria automaticamente 3 tabelas:

```sql
-- Gerenciamento de conteúdo
CREATE TABLE conteudos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pagina VARCHAR(50) NOT NULL UNIQUE,
    titulo VARCHAR(255) NOT NULL,
    conteudo LONGTEXT NOT NULL,
    meta_description TEXT,
    palavras_chave TEXT,
    ativo TINYINT(1) DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Unidades de saúde
CREATE TABLE unidades_saude (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    endereco TEXT NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    horario_funcionamento TEXT,
    especialidades TEXT,
    latitude DECIMAL(10, 8) DEFAULT 0,
    longitude DECIMAL(11, 8) DEFAULT 0,
    ativo TINYINT(1) DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Configurações do sistema
CREATE TABLE configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) NOT NULL UNIQUE,
    valor TEXT,
    descricao TEXT,
    tipo ENUM('texto', 'numero', 'boolean', 'email', 'url') DEFAULT 'texto',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Rotas Administrativas
- `/adminpanel/editarPagina/{pagina}` - Editor de páginas
- `/adminpanel/unidades` - Gestão de unidades
- `/adminpanel/usuarios` - Gestão de usuários
- `/adminpanel/configuracoes` - Configurações
- `/adminpanel/api` - Interface API
- `/adminpanel/gerarBackup` - Backup do sistema

### Sistema de Autenticação
- **Classe Auth expandida** com métodos para verificação de admin
- **Sessões seguras** com controle de permissões
- **Login temporário** para desenvolvimento/testes

## 🎨 Interface Administrativa

O painel administrativo conta com:
- **Design responsivo** com Bootstrap 5
- **Ícones Font Awesome** para navegação intuitiva
- **Editor TinyMCE** com localização em português
- **Animações CSS** para melhor experiência
- **Tema consistente** com o site principal

## 🔧 Próximos Passos (Opcionais)

Para expandir ainda mais o sistema:

1. **Sistema de usuários completo**:
   - Registro e login de usuários normais
   - Perfis de usuário com histórico

2. **Blog/Notícias**:
   - Sistema de posts com categorias
   - Comentários moderados

3. **Sistema de agendamentos**:
   - Agendamento online para unidades
   - Calendário integrado

4. **Notificações**:
   - Alertas de saúde pública
   - Newsletter automática

## 📞 Suporte

O sistema foi desenvolvido seguindo as melhores práticas:
- **MVC Pattern** para organização
- **PDO** para segurança do banco
- **Responsive Design** para acessibilidade
- **SEO Friendly** para indexação
- **Código documentado** para manutenção

---

**Sistema desenvolvido por GitHub Copilot para o projeto Saúde na Mão** 🏥💙