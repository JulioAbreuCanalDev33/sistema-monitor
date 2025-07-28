-- Script SQL Completo - Sistema de Monitoramento
-- Criar o banco de dados com o nome corrigido
CREATE DATABASE IF NOT EXISTS informacoes_ocorrencias_veicular_2;

-- Usar o banco de dados corrigido
USE informacoes_ocorrencias_veicular_2;

-- Tabela de usuários do sistema
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel ENUM('admin', 'usuario') DEFAULT 'usuario',
    ativo BOOLEAN DEFAULT TRUE,
    ultimo_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de configurações do sistema
CREATE TABLE IF NOT EXISTS configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descricao VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de logs do sistema
CREATE TABLE IF NOT EXISTS logs_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    acao VARCHAR(100) NOT NULL,
    tabela_afetada VARCHAR(100),
    registro_id INT,
    detalhes TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabela de prestadores
CREATE TABLE tabela_prestadores (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_prestador VARCHAR(255) NOT NULL,
    equipes VARCHAR(255), -- Ex: "Equipe A, Equipe B" ou usar relacionamento futuro
    servico_prestador VARCHAR(255) NOT NULL,
    cpf_prestador VARCHAR(14) UNIQUE NOT NULL,
    rg_prestador VARCHAR(20) NULL,
    email_prestador VARCHAR(255) UNIQUE NOT NULL,
    telefone_1_prestador VARCHAR(15) NOT NULL,
    telefone_2_prestador VARCHAR(15) NULL,
    cep_prestador VARCHAR(10) NOT NULL,
    endereco_prestador VARCHAR(255) NOT NULL,
    numero_prestador VARCHAR(10) NOT NULL,
    bairro_prestador VARCHAR(100) NOT NULL,
    cidade_prestador VARCHAR(100) NOT NULL,
    estado_prestador CHAR(2) NOT NULL, -- Ex: SP, RJ
    observacao TEXT NULL,
    
    -- Uploads (armazenando caminhos dos arquivos)
    documento_prestador VARCHAR(255) NULL,
    foto_prestador VARCHAR(255) NULL,

    -- Dados Bancários
    codigo_do_banco VARCHAR(10) NOT NULL, -- Ex: 001 (Banco do Brasil), 341 (Itaú)
    pix_banco_prestadores VARCHAR(255) NULL,
    titular_conta VARCHAR(255) NOT NULL,
    tipo_de_conta VARCHAR(50) NOT NULL, -- Ex: "Conta Corrente", "Poupança"
    agencia_prestadores VARCHAR(20) NOT NULL,
    digito_agencia_prestadores VARCHAR(5) NULL,
    conta_prestadores VARCHAR(20) NOT NULL,
    digito_conta_prestadores VARCHAR(5) NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome_empresa VARCHAR(100),
    cnpj VARCHAR(18),
    contato VARCHAR(100),
    endereco VARCHAR(255),
    telefone VARCHAR(15)
);

-- Agentes
CREATE TABLE IF NOT EXISTS agentes (
    id_agente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    funcao VARCHAR(100),
    status ENUM('Ativo', 'Inativo') DEFAULT 'Ativo'
);

-- Atendimentos
CREATE TABLE IF NOT EXISTS atendimentos (
    id_atendimento INT AUTO_INCREMENT PRIMARY KEY,
    solicitante VARCHAR(100),
    motivo TEXT,
    valor_patrimonial DECIMAL(12,2),
    id_cliente INT,
    conta VARCHAR(50),
    id_validacao VARCHAR(50),
    filial VARCHAR(50),
    ordem_servico VARCHAR(50),
    cep VARCHAR(9),
    estado CHAR(2),
    cidade VARCHAR(100),
    endereco VARCHAR(255),
    numero VARCHAR(10),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    agentes_aptos TEXT,
    id_agente INT,
    equipe VARCHAR(100),
    responsavel VARCHAR(100),
    estabelecimento VARCHAR(100),
    hora_solicitada TIME,
    hora_local DATETIME,
    hora_saida DATETIME,
    status_atendimento ENUM('Em andamento', 'Finalizado'),
    tipo_de_servico ENUM('Ronda', 'Preservação'),
    tipos_de_dados VARCHAR(100),
    estabelecida_inicio TIME,
    estabelecida_fim TIME,
    indeterminado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE SET NULL,
    FOREIGN KEY (id_agente) REFERENCES agentes(id_agente) ON DELETE SET NULL
);

-- Rondas Periódicas
CREATE TABLE IF NOT EXISTS rondas_periodicas (
    id_ronda INT AUTO_INCREMENT PRIMARY KEY,
    id_atendimento INT,
    quantidade_rondas INT,
    data_final DATE,
    pagamento ENUM('Pago', 'Pendente'),
    contato_no_local ENUM('Sim', 'Não'),
    nome_local VARCHAR(100),
    funcao_local VARCHAR(100),
    verificado_fiacao ENUM('Sim', 'Não'),
    quadro_eletrico ENUM('Sim', 'Não'),
    verificado_portas_entradas ENUM('Sim', 'Não'),
    local_energizado ENUM('Sim', 'Não'),
    sirene_disparada ENUM('Sim', 'Não'),
    local_violado ENUM('Sim', 'Não'),
    observacao TEXT,
    FOREIGN KEY (id_atendimento) REFERENCES atendimentos(id_atendimento) ON DELETE CASCADE
);

-- Fotos dos Atendimentos
CREATE TABLE IF NOT EXISTS fotos_atendimentos (
    id_foto INT AUTO_INCREMENT PRIMARY KEY,
    id_atendimento INT,
    legenda VARCHAR(255),
    caminho_foto VARCHAR(255),
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_atendimento) REFERENCES atendimentos(id_atendimento) ON DELETE CASCADE
);

-- Criar a tabela de ocorrências veiculares
CREATE TABLE ocorrencias_veiculares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(100),
    servico VARCHAR(100),
    id_validacao VARCHAR(50),
    valor_veicular DECIMAL(10,2),
    cep VARCHAR(10),
    estado CHAR(2),
    cidade VARCHAR(100),
    solicitante VARCHAR(100),
    motivo TEXT,
    endereco_da_ocorrencia VARCHAR(255),
    número VARCHAR(10),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    agentes_aptos TEXT,
    prestador VARCHAR(100),
    equipe VARCHAR(100),
    tipo_de_ocorrencia TEXT,
    data_hora_evento DATETIME,
    data_hora_deslocamento DATETIME,
    data_hora_transmissao DATETIME,
    data_hora_local DATETIME,
    data_hora_inicio_atendimento DATETIME,
    data_hora_fim_atendimento DATETIME,
    franquia_hora TIME,
    franquia_km DECIMAL(10,2),
    km_inicial_atendimento DECIMAL(10,2),
    km_final_atendimento DECIMAL(10,2),
    total_horas_atendimento TIME,
    total_km_percorrido DECIMAL(10,2),
    descricao_fatos TEXT,
    gastos_adicionais DECIMAL(10,2)
);

-- Tabela principal de vigilância veicular
CREATE TABLE vigilancia_veicular (
    id INT AUTO_INCREMENT PRIMARY KEY,
    veiculo_foi_recuperado ENUM('Sim', 'Não') NOT NULL,
    condutor_e_proprietario ENUM('Sim', 'Não') NOT NULL,
    tipo_de_equipamento_embarcado TEXT,
    placa VARCHAR(8) NOT NULL,
    renavam VARCHAR(11),
    cor VARCHAR(50),
    marca VARCHAR(100),
    modelo VARCHAR(100),
    cidade VARCHAR(100),
    dados_adicionais_veiculo TEXT,
    placa_carreta VARCHAR(8),
    renavam_carreta VARCHAR(11),
    cor_carreta VARCHAR(50),
    marca_carreta VARCHAR(100),
    modelo_carreta VARCHAR(100),
    cidade_carreta VARCHAR(100),
    dados_adicionais_carreta TEXT,
    nome_do_condutor VARCHAR(100),
    cpf_condutor VARCHAR(14),
    cnh_condutor VARCHAR(11),
    telefone_condutor VARCHAR(15),
    status_do_atendimento ENUM('Em andamento', 'Finalizado') NOT NULL
);

-- Tabela de fotos
CREATE TABLE fotos_vigilancia_veicular (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vigilancia_id INT,
    legenda VARCHAR(255),
    foto VARCHAR(255),
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vigilancia_id) REFERENCES vigilancia_veicular(id) ON DELETE CASCADE
);

-- Inserir usuário administrador padrão
INSERT INTO usuarios (nome, email, senha, nivel) VALUES 
('Administrador', 'admin@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Senha padrão: password

-- Inserir configurações básicas
INSERT INTO configuracoes (chave, valor, descricao) VALUES 
('sistema_nome', 'Sistema de Monitoramento', 'Nome do sistema'),
('sistema_versao', '1.0.0', 'Versão do sistema'),
('tema_padrao', 'claro', 'Tema padrão do sistema'),
('max_upload_size', '5242880', 'Tamanho máximo de upload em bytes'),
('timezone', 'America/Sao_Paulo', 'Fuso horário do sistema');

-- Inserir dados de exemplo
INSERT INTO clientes (nome_empresa, cnpj, contato, endereco, telefone) VALUES
('Empresa ABC Ltda', '12.345.678/0001-90', 'João Silva', 'Rua das Flores, 123', '(11) 99999-9999'),
('Corporação XYZ S.A.', '98.765.432/0001-10', 'Maria Santos', 'Av. Principal, 456', '(11) 88888-8888');

INSERT INTO agentes (nome, funcao, status) VALUES
('Carlos Oliveira', 'Agente de Segurança', 'Ativo'),
('Ana Costa', 'Supervisora', 'Ativo'),
('Pedro Almeida', 'Agente de Campo', 'Ativo');

