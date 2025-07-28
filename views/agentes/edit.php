<?php
$page_title = 'Editar Agente';
$page = 'agentes';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Agente</h2>
    <a href="index.php?page=agentes" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edição de Agente</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" class="needs-validation" novalidate>
            <div class="row">
                <!-- Dados Pessoais -->
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-user"></i> Dados Pessoais</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome_agente" class="form-label">Nome Completo *</label>
                        <input type="text" id="nome_agente" name="nome_agente" class="form-control" value="<?php echo htmlspecialchars($agente->nome_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o nome completo.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cpf_agente" class="form-label">CPF *</label>
                        <input type="text" id="cpf_agente" name="cpf_agente" class="form-control" data-mask="cpf" value="<?php echo htmlspecialchars($agente->cpf_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe um CPF válido.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="rg_agente" class="form-label">RG</label>
                        <input type="text" id="rg_agente" name="rg_agente" class="form-control" value="<?php echo htmlspecialchars($agente->rg_agente); ?>">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_nascimento" class="form-label">Data de Nascimento *</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" value="<?php echo $agente->data_nascimento; ?>" required>
                        <div class="invalid-feedback">Por favor, informe a data de nascimento.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email_agente" class="form-label">Email *</label>
                        <input type="email" id="email_agente" name="email_agente" class="form-control" value="<?php echo htmlspecialchars($agente->email_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe um email válido.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefone_agente" class="form-label">Telefone *</label>
                        <input type="text" id="telefone_agente" name="telefone_agente" class="form-control" data-mask="phone" value="<?php echo htmlspecialchars($agente->telefone_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o telefone.</div>
                    </div>
                </div>
                
                <!-- Endereço -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Endereço</h5>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cep_agente" class="form-label">CEP *</label>
                        <input type="text" id="cep_agente" name="cep_agente" class="form-control" data-mask="cep" value="<?php echo htmlspecialchars($agente->cep_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o CEP.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="endereco_agente" class="form-label">Endereço *</label>
                        <input type="text" id="endereco_agente" name="endereco_agente" class="form-control" value="<?php echo htmlspecialchars($agente->endereco_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o endereço.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="numero_agente" class="form-label">Número *</label>
                        <input type="text" id="numero_agente" name="numero_agente" class="form-control" value="<?php echo htmlspecialchars($agente->numero_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o número.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bairro_agente" class="form-label">Bairro *</label>
                        <input type="text" id="bairro_agente" name="bairro_agente" class="form-control" value="<?php echo htmlspecialchars($agente->bairro_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o bairro.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cidade_agente" class="form-label">Cidade *</label>
                        <input type="text" id="cidade_agente" name="cidade_agente" class="form-control" value="<?php echo htmlspecialchars($agente->cidade_agente); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a cidade.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estado_agente" class="form-label">Estado *</label>
                        <select id="estado_agente" name="estado_agente" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <?php
                            $estados = ['AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'];
                            foreach ($estados as $sigla => $nome) {
                                $selected = ($agente->estado_agente == $sigla) ? 'selected' : '';
                                echo "<option value=\"$sigla\" $selected>$nome</option>";
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o estado.</div>
                    </div>
                </div>
                
                <!-- Status e Observações -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-info-circle"></i> Informações Adicionais</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_agente" class="form-label">Status *</label>
                        <select id="status_agente" name="status_agente" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Ativo" <?php echo ($agente->status_agente == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                            <option value="Inativo" <?php echo ($agente->status_agente == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                            <option value="Licença" <?php echo ($agente->status_agente == 'Licença') ? 'selected' : ''; ?>>Em Licença</option>
                            <option value="Férias" <?php echo ($agente->status_agente == 'Férias') ? 'selected' : ''; ?>>Em Férias</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" class="form-control" rows="3" placeholder="Observações adicionais sobre o agente"><?php echo htmlspecialchars($agente->observacoes); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Agente
                </button>
                <a href="index.php?page=agentes" class="btn btn-secondary">
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
document.getElementById("cep_agente").addEventListener("blur", function() {
    const cep = this.value.replace(/\D/g, "");
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById("endereco_agente").value = data.logradouro;
                    document.getElementById("bairro_agente").value = data.bairro;
                    document.getElementById("cidade_agente").value = data.localidade;
                    document.getElementById("estado_agente").value = data.uf;
                }
            })
            .catch(error => console.log("Erro ao buscar CEP:", error));
    }
});
</script>
';

include 'views/layout.php';
?>

