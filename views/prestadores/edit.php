<?php
$page_title = 'Editar Prestador';
$page = 'prestadores';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Prestador</h2>
    <a href="index.php?page=prestadores" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edição de Prestador</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row">
                <!-- Dados Pessoais -->
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-user"></i> Dados Pessoais</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome_prestador" class="form-label">Nome Completo *</label>
                        <input type="text" id="nome_prestador" name="nome_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->nome_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o nome completo.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="servico_prestador" class="form-label">Serviço Prestado *</label>
                        <input type="text" id="servico_prestador" name="servico_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->servico_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o serviço prestado.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cpf_prestador" class="form-label">CPF *</label>
                        <input type="text" id="cpf_prestador" name="cpf_prestador" class="form-control" data-mask="cpf" value="<?php echo htmlspecialchars($prestador->cpf_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe um CPF válido.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rg_prestador" class="form-label">RG</label>
                        <input type="text" id="rg_prestador" name="rg_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->rg_prestador); ?>">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="equipes" class="form-label">Equipes</label>
                        <input type="text" id="equipes" name="equipes" class="form-control" value="<?php echo htmlspecialchars($prestador->equipes); ?>" placeholder="Ex: Equipe A, Equipe B">
                    </div>
                </div>
                
                <!-- Contato -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-phone"></i> Contato</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email_prestador" class="form-label">Email *</label>
                        <input type="email" id="email_prestador" name="email_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->email_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe um email válido.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="telefone_1_prestador" class="form-label">Telefone Principal *</label>
                        <input type="text" id="telefone_1_prestador" name="telefone_1_prestador" class="form-control" data-mask="phone" value="<?php echo htmlspecialchars($prestador->telefone_1_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o telefone principal.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="telefone_2_prestador" class="form-label">Telefone Secundário</label>
                        <input type="text" id="telefone_2_prestador" name="telefone_2_prestador" class="form-control" data-mask="phone" value="<?php echo htmlspecialchars($prestador->telefone_2_prestador); ?>">
                    </div>
                </div>
                
                <!-- Endereço -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Endereço</h5>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cep_prestador" class="form-label">CEP *</label>
                        <input type="text" id="cep_prestador" name="cep_prestador" class="form-control" data-mask="cep" value="<?php echo htmlspecialchars($prestador->cep_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o CEP.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="endereco_prestador" class="form-label">Endereço *</label>
                        <input type="text" id="endereco_prestador" name="endereco_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->endereco_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o endereço.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="numero_prestador" class="form-label">Número *</label>
                        <input type="text" id="numero_prestador" name="numero_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->numero_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o número.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bairro_prestador" class="form-label">Bairro *</label>
                        <input type="text" id="bairro_prestador" name="bairro_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->bairro_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o bairro.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cidade_prestador" class="form-label">Cidade *</label>
                        <input type="text" id="cidade_prestador" name="cidade_prestador" class="form-control" value="<?php echo htmlspecialchars($prestador->cidade_prestador); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a cidade.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estado_prestador" class="form-label">Estado *</label>
                        <select id="estado_prestador" name="estado_prestador" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <?php
                            $estados = ['AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'];
                            foreach ($estados as $sigla => $nome) {
                                $selected = ($prestador->estado_prestador == $sigla) ? 'selected' : '';
                                echo "<option value=\"$sigla\" $selected>$nome</option>";
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o estado.</div>
                    </div>
                </div>
                
                <!-- Dados Bancários -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-university"></i> Dados Bancários</h5>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="codigo_do_banco" class="form-label">Código do Banco *</label>
                        <input type="text" id="codigo_do_banco" name="codigo_do_banco" class="form-control" value="<?php echo htmlspecialchars($prestador->codigo_do_banco); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o código do banco.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo_de_conta" class="form-label">Tipo de Conta *</label>
                        <select id="tipo_de_conta" name="tipo_de_conta" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Conta Corrente" <?php echo ($prestador->tipo_de_conta == 'Conta Corrente') ? 'selected' : ''; ?>>Conta Corrente</option>
                            <option value="Poupança" <?php echo ($prestador->tipo_de_conta == 'Poupança') ? 'selected' : ''; ?>>Poupança</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o tipo de conta.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="titular_conta" class="form-label">Titular da Conta *</label>
                        <input type="text" id="titular_conta" name="titular_conta" class="form-control" value="<?php echo htmlspecialchars($prestador->titular_conta); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o titular da conta.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="agencia_prestadores" class="form-label">Agência *</label>
                        <input type="text" id="agencia_prestadores" name="agencia_prestadores" class="form-control" value="<?php echo htmlspecialchars($prestador->agencia_prestadores); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a agência.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="digito_agencia_prestadores" class="form-label">Dígito da Agência</label>
                        <input type="text" id="digito_agencia_prestadores" name="digito_agencia_prestadores" class="form-control" value="<?php echo htmlspecialchars($prestador->digito_agencia_prestadores); ?>">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="conta_prestadores" class="form-label">Conta *</label>
                        <input type="text" id="conta_prestadores" name="conta_prestadores" class="form-control" value="<?php echo htmlspecialchars($prestador->conta_prestadores); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a conta.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="digito_conta_prestadores" class="form-label">Dígito da Conta</label>
                        <input type="text" id="digito_conta_prestadores" name="digito_conta_prestadores" class="form-control" value="<?php echo htmlspecialchars($prestador->digito_conta_prestadores); ?>">
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="pix_banco_prestadores" class="form-label">PIX</label>
                        <input type="text" id="pix_banco_prestadores" name="pix_banco_prestadores" class="form-control" value="<?php echo htmlspecialchars($prestador->pix_banco_prestadores); ?>" placeholder="Chave PIX (CPF, email, telefone ou chave aleatória)">
                    </div>
                </div>
                
                <!-- Upload de Arquivos -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-upload"></i> Upload de Arquivos</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="documento_prestador" class="form-label">Documento (PDF, DOC, DOCX, JPG, PNG)</label>
                        <input type="file" id="documento_prestador" name="documento_prestador" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">Tamanho máximo: 5MB</small>
                        <?php if ($prestador->documento_prestador): ?>
                        <div class="mt-2">
                            <small class="text-success">
                                <i class="fas fa-file"></i> Arquivo atual: <?php echo htmlspecialchars($prestador->documento_prestador); ?>
                            </small>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="foto_prestador" class="form-label">Foto (JPG, PNG)</label>
                        <input type="file" id="foto_prestador" name="foto_prestador" class="form-control" accept=".jpg,.jpeg,.png" onchange="previewImage(this, 'foto_preview')">
                        <small class="form-text text-muted">Tamanho máximo: 5MB</small>
                        <?php if ($prestador->foto_prestador): ?>
                        <div class="mt-2">
                            <img src="assets/uploads/<?php echo htmlspecialchars($prestador->foto_prestador); ?>" alt="Foto atual" class="img-thumbnail" style="max-width: 150px;">
                            <br><small class="text-success">Foto atual</small>
                        </div>
                        <?php endif; ?>
                        <img id="foto_preview" src="#" alt="Preview da foto" style="display: none; max-width: 200px; margin-top: 10px;" class="img-thumbnail">
                    </div>
                </div>
                
                <!-- Observações -->
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label for="observacao" class="form-label">Observações</label>
                        <textarea id="observacao" name="observacao" class="form-control" rows="3" placeholder="Observações adicionais sobre o prestador"><?php echo htmlspecialchars($prestador->observacao); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Prestador
                </button>
                <a href="index.php?page=prestadores" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
// Aplicar máscaras
applyInputMasks();

// Buscar endereço por CEP
document.getElementById("cep_prestador").addEventListener("blur", function() {
    const cep = this.value.replace(/\D/g, "");
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById("endereco_prestador").value = data.logradouro;
                    document.getElementById("bairro_prestador").value = data.bairro;
                    document.getElementById("cidade_prestador").value = data.localidade;
                    document.getElementById("estado_prestador").value = data.uf;
                }
            })
            .catch(error => console.log("Erro ao buscar CEP:", error));
    }
});
</script>
';

include 'views/layout.php';
?>

