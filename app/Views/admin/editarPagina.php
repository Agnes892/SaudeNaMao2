<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $dados['titulo'] ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=URL?>/public/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URL?>/public/img/logo.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=URL?>/public/bootstrap/css/bootstrap.css"/>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- TinyMCE Editor -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    
    <!-- CSS Admin -->
    <link rel="stylesheet" href="<?=URL?>/public/css/painelAdmin.css">
    
    <style>
        .editor-container {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(42, 111, 151, 0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #2a6f97;
            box-shadow: 0 0 0 3px rgba(42, 111, 151, 0.1);
        }
        
        .btn-salvar {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-salvar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.3);
        }
        
        .btn-voltar {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-voltar:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container admin-container">
        <!-- Header -->
        <div class="admin-header">
            <div class="admin-welcome">
                <div class="welcome-text">
                    <h1>
                        <div class="logo-admin">
                            <i class="fas fa-edit"></i>
                        </div>
                        Editar Página - <?= ucfirst($dados['pagina']) ?>
                    </h1>
                    <p>Edite o conteúdo da página <?= ucfirst($dados['pagina']) ?></p>
                </div>
                <div class="admin-actions">
                    <a href="<?=URL?>/usuarios/painelAdmin" class="btn-admin">
                        <i class="fas fa-arrow-left"></i>
                        Voltar ao Painel
                    </a>
                </div>
            </div>
        </div>

        <!-- Mensagens -->
        <?php if(Sessao::mensagem('conteudo')): ?>
            <div class="<?= Sessao::tipoMensagem('conteudo') ?> alert-dismissible fade show">
                <?= Sessao::mensagem('conteudo') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Formulário de Edição -->
        <div class="editor-container">
            <form method="POST" action="<?=URL?>/adminpanel/editarPagina/<?= $dados['pagina'] ?>">
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="titulo" class="form-label">
                                <i class="fas fa-heading"></i> Título da Página
                            </label>
                            <input type="text" class="form-control" id="titulo" name="titulo" 
                                   value="<?= isset($dados['conteudo']->titulo) ? $dados['conteudo']->titulo : '' ?>" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-toggle-on"></i> Status
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="ativo" name="ativo" 
                                       <?= (isset($dados['conteudo']->ativo) && $dados['conteudo']->ativo) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="ativo">Página Ativa</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="conteudo" class="form-label">
                        <i class="fas fa-file-alt"></i> Conteúdo
                    </label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="15">
                        <?= isset($dados['conteudo']->conteudo) ? $dados['conteudo']->conteudo : '' ?>
                    </textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="meta_description" class="form-label">
                                <i class="fas fa-tags"></i> Meta Descrição
                            </label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" 
                                      placeholder="Descrição para mecanismos de busca (máx. 160 caracteres)">
                                <?= isset($dados['conteudo']->meta_description) ? $dados['conteudo']->meta_description : '' ?>
                            </textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="palavras_chave" class="form-label">
                                <i class="fas fa-key"></i> Palavras-chave
                            </label>
                            <textarea class="form-control" id="palavras_chave" name="palavras_chave" rows="3" 
                                      placeholder="Palavras-chave separadas por vírgula">
                                <?= isset($dados['conteudo']->palavras_chave) ? $dados['conteudo']->palavras_chave : '' ?>
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group d-flex gap-3">
                    <button type="submit" class="btn-salvar">
                        <i class="fas fa-save"></i>
                        Salvar Alterações
                    </button>
                    
                    <a href="<?=URL?>/adminpanel/listarPaginas" class="btn-voltar">
                        <i class="fas fa-list"></i>
                        Ver Todas as Páginas
                    </a>
                    
                    <?php if(isset($dados['pagina'])): ?>
                        <a href="<?=URL?>/paginas/<?= $dados['pagina'] ?>" target="_blank" class="btn-voltar">
                            <i class="fas fa-external-link-alt"></i>
                            Visualizar Página
                        </a>
                    <?php endif; ?>
                </div>
                
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?=URL?>/public/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- TinyMCE Configuration -->
    <script>
        tinymce.init({
            selector: '#conteudo',
            height: 400,
            language: 'pt_BR',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | removeformat | ' +
                    'link image media | table | code preview fullscreen help',
            content_style: 'body { font-family: Inter, Arial, sans-serif; font-size: 16px; }',
            branding: false,
            menubar: 'file edit view insert format tools table help',
            image_advtab: true,
            link_assume_external_targets: true,
            file_picker_types: 'image',
            paste_data_images: true,
            automatic_uploads: true,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });

        // Contador de caracteres para meta descrição
        document.getElementById('meta_description').addEventListener('input', function() {
            const maxLength = 160;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            let label = this.parentElement.querySelector('label');
            let counter = label.querySelector('.char-counter');
            
            if (!counter) {
                counter = document.createElement('span');
                counter.className = 'char-counter ms-2 small';
                label.appendChild(counter);
            }
            
            counter.textContent = `(${currentLength}/${maxLength})`;
            counter.style.color = remaining < 20 ? '#e74c3c' : '#666';
        });

        // Trigger inicial para o contador
        document.getElementById('meta_description').dispatchEvent(new Event('input'));
    </script>
    
</body>
</html>