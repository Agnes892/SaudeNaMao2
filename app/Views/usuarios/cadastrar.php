<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Saúde na Mão</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=URL?>/public/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URL?>/public/img/logo.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=URL?>/public/bootstrap/css/bootstrap.css"/>
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #2a6f97 0%, #2a8c7c 100%);
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
        }

        .cadastro-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .cadastro-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(42, 111, 151, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 900px;
            width: 100%;
        }

        .cadastro-header {
            text-align: center;
            padding: 2rem;
            border-bottom: 1px solid rgba(42, 111, 151, 0.1);
        }

        .logo-cadastro {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #2a6f97, #2a8c7c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 30px rgba(42, 111, 151, 0.3);
        }

        .cadastro-titulo {
            color: #2a6f97;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .cadastro-subtitulo {
            color: #6c757d;
            margin-top: 0.5rem;
        }

        .foto-perfil-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .foto-perfil-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #2a6f97;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .foto-perfil-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(42, 111, 151, 0.3);
        }

        .foto-perfil-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .foto-perfil-icon {
            font-size: 3rem;
            color: #6c757d;
        }

        .foto-perfil-input {
            display: none;
        }

        .foto-perfil-btn {
            background: linear-gradient(135deg, #2a6f97, #2a8c7c);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .foto-perfil-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 111, 151, 0.4);
        }

        .form-section {
            padding: 1.5rem 2rem;
        }

        .section-title {
            color: #2a6f97;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid rgba(42, 111, 151, 0.1);
            padding-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: #2a6f97;
            box-shadow: 0 0 0 0.2rem rgba(42, 111, 151, 0.2);
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .required {
            color: #e74c3c;
        }

        .btn-cadastrar {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-cadastrar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        .btn-voltar {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-voltar:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .cadastro-container {
                padding: 1rem;
            }
            
            .form-section {
                padding: 1rem;
            }
            
            .cadastro-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="cadastro-container">
        <div class="cadastro-card">
            <!-- Cabeçalho -->
            <div class="cadastro-header">
                <div class="logo-cadastro">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="cadastro-titulo">Cadastre-se</h1>
                <p class="cadastro-subtitulo">Crie sua conta no Saúde na Mão</p>
            </div>

            <form name="cadastrar" method="POST" action="<?=URL?>/usuarios/cadastrar" enctype="multipart/form-data">
                
                <!-- Foto de Perfil -->
                <div class="form-section">
                    <div class="foto-perfil-container">
                        <div class="foto-perfil-preview" onclick="document.getElementById('fotoPerfil').click()">
                            <i class="fas fa-camera foto-perfil-icon" id="fotoIcon"></i>
                            <img id="fotoPreview" style="display: none;" alt="Preview da foto">
                        </div>
                        <input type="file" id="fotoPerfil" name="foto_perfil" class="foto-perfil-input" accept="image/*" onchange="previewFoto(this)">
                        <button type="button" class="foto-perfil-btn" onclick="document.getElementById('fotoPerfil').click()">
                            <i class="fas fa-upload"></i> Escolher Foto
                        </button>
                        <p class="text-muted mt-2"><small>Clique para adicionar sua foto de perfil (opcional)</small></p>
                    </div>
                </div>

                <!-- Dados Pessoais -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Dados Pessoais
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome" class="form-label">Nome Completo <span class="required">*</span></label>
                                <input type="text" name="nome" id="nome" value="<?= $dados['nome'] ?? '' ?>" class="form-control" placeholder="Digite seu nome completo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">E-mail <span class="required">*</span></label>
                                <input type="email" name="email" id="email" value="<?= $dados['email'] ?? '' ?>" class="form-control" placeholder="seu@email.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf" class="form-label">CPF <span class="required">*</span></label>
                                <input type="text" name="cpf" id="cpf" value="<?= $dados['cpf'] ?? '' ?>" class="form-control" placeholder="000.000.000-00" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="data_nascimento" class="form-label">Data de Nascimento <span class="required">*</span></label>
                                <input type="date" name="data_nascimento" id="data_nascimento" value="<?= $dados['data_nascimento'] ?? '' ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" value="<?= $dados['telefone'] ?? '' ?>" class="form-control" placeholder="(00) 00000-0000">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Endereço
                    </h3>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="endereco" class="form-label">Endereço Completo</label>
                                <input type="text" name="endereco" id="endereco" value="<?= $dados['endereco'] ?? '' ?>" class="form-control" placeholder="Rua, número, bairro">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" name="cep" id="cep" value="<?= $dados['cep'] ?? '' ?>" class="form-control" placeholder="00000-000">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" name="cidade" id="cidade" value="<?= $dados['cidade'] ?? '' ?>" class="form-control" placeholder="Sua cidade">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" name="estado" id="estado" value="<?= $dados['estado'] ?? '' ?>" class="form-control" placeholder="SP">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações de Saúde -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-heartbeat"></i>
                        Informações de Saúde
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cartao_sus" class="form-label">Cartão do SUS</label>
                                <input type="text" name="cartao_sus" id="cartao_sus" value="<?= $dados['cartao_sus'] ?? '' ?>" class="form-control" placeholder="Número do SUS">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo</label>
                                <select name="tipo_sanguineo" id="tipo_sanguineo" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alergias" class="form-label">Alergias</label>
                                <textarea name="alergias" id="alergias" class="form-control" rows="3" placeholder="Descreva suas alergias (se houver)"><?= $dados['alergias'] ?? '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="condicoes_cronicas" class="form-label">Condições Crônicas</label>
                                <textarea name="condicoes_cronicas" id="condicoes_cronicas" class="form-control" rows="3" placeholder="Diabetes, hipertensão, etc."><?= $dados['condicoes_cronicas'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contatos de Emergência -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-phone-alt"></i>
                        Contato de Emergência
                    </h3>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="emergencia_nome" class="form-label">Nome Completo</label>
                                <input type="text" name="emergencia_nome" id="emergencia_nome" value="<?= $dados['emergencia_nome'] ?? '' ?>" class="form-control" placeholder="Nome da pessoa de contato">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergencia_telefone" class="form-label">Telefone</label>
                                <input type="text" name="emergencia_telefone" id="emergencia_telefone" value="<?= $dados['emergencia_telefone'] ?? '' ?>" class="form-control" placeholder="(00) 00000-0000">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="emergencia_parentesco" class="form-label">Parentesco</label>
                                <input type="text" name="emergencia_parentesco" id="emergencia_parentesco" value="<?= $dados['emergencia_parentesco'] ?? '' ?>" class="form-control" placeholder="Mãe, pai, cônjuge...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Senha -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-lock"></i>
                        Segurança
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senha" class="form-label">Senha <span class="required">*</span></label>
                                <input type="password" name="senha" id="senha" class="form-control" placeholder="Mínimo 6 caracteres" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmar_senha" class="form-label">Confirmar Senha <span class="required">*</span></label>
                                <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" placeholder="Repita a senha" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="form-section">
                    <a href="<?=URL?>/usuarios/loginPrincipal" class="btn-voltar">
                        <i class="fas fa-arrow-left"></i>
                        Voltar ao Login
                    </a>
                    
                    <button type="submit" class="btn-cadastrar">
                        <i class="fas fa-user-check"></i>
                        Criar Minha Conta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?=URL?>/public/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Preview da foto de perfil
        function previewFoto(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('fotoPreview').src = e.target.result;
                    document.getElementById('fotoPreview').style.display = 'block';
                    document.getElementById('fotoIcon').style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        }

        // Máscaras para campos
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d)(\d{4})$/, '$1-$2');
            e.target.value = value;
        });

        document.getElementById('cep').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Validação de senha
        document.getElementById('confirmar_senha').addEventListener('input', function() {
            const senha = document.getElementById('senha').value;
            const confirmar = this.value;
            
            if (senha !== confirmar) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '#28a745';
            }
        });
    </script>
</body>
</html>