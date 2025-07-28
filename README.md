![PHP Logo](https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg)



# Sistema de Monitoramento - Atendimento Veicular e Patrimonial

Sistema completo em PHP para monitoramento, atendimento veicular e atendimento patrimonial com funcionalidades CRUD, sistema de login, modo escuro/claro, relatórios em PDF/Excel, upload de arquivos e dashboard profissional.

## Características

- **Sistema de Login**: Administrador e usuário comum
- **CRUD Completo**: Para todas as entidades do sistema
- **Modo Escuro/Claro**: Interface adaptável com cores azul e branco
- **Dashboard Profissional**: Com gráficos e estatísticas
- **Relatórios**: Geração em PDF e Excel
- **Upload de Arquivos**: Para fotos e documentos
- **Responsivo**: Interface adaptada para desktop e mobile

## Módulos

### 1. Atendimento Patrimonial
- Gestão de clientes
- Gestão de agentes
- Atendimentos e rondas
- Fotos de evidências

### 2. Atendimento Veicular
- Ocorrências veiculares
- Gestão de prestadores
- Controle de gastos e quilometragem

### 3. Vigilância Veicular
- Monitoramento de veículos
- Dados de condutores
- Fotos de vigilância

## Instalação

### Pré-requisitos
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Apache/Nginx
- Extensões PHP: PDO, GD, ZIP

### Passos de Instalação

1. **Extrair arquivos**
   ```bash
   unzip sistema_monitoramento.zip
   cd sistema_monitoramento
   ```

2. **Configurar banco de dados**
   - Criar banco de dados MySQL
   - Executar script: `config/sistema_usuarios.sql`
   - Executar script fornecido pelo usuário com as tabelas principais

3. **Configurar conexão**
   - Editar `config/database.php`
   - Ajustar credenciais do banco de dados

4. **Configurar permissões**
   ```bash
   chmod 755 assets/uploads/
   chmod 755 reports/
   ```

5. **Instalar dependências (opcional)**
   ```bash
   composer install
   ```

## Configuração

### Banco de Dados
Edite o arquivo `config/database.php`:

```php
private $host = 'localhost';
private $db_name = 'informacoes_ocorrencias_veicular';
private $username = 'seu_usuario';
private $password = 'sua_senha';
```

### Login Padrão
- **Email**: admin@sistema.com
- **Senha**: password

## Estrutura do Projeto

```
sistema_monitoramento/
├── config/                 # Configurações
│   ├── database.php        # Conexão com banco
│   └── sistema_usuarios.sql # Script de usuários
├── controllers/            # Controladores MVC
├── models/                 # Modelos de dados
├── views/                  # Views/Templates
├── assets/                 # Recursos estáticos
│   ├── css/               # Estilos CSS
│   ├── js/                # JavaScript
│   ├── images/            # Imagens
│   └── uploads/           # Uploads de usuários
├── includes/              # Arquivos auxiliares
├── reports/               # Relatórios gerados
└── index.php             # Arquivo principal
```

## Funcionalidades

### Dashboard
- Estatísticas gerais do sistema
- Gráficos de atendimentos por mês
- Ações rápidas
- Últimas atividades
- Mapa de atendimentos

### CRUD Completo
- **Atendimentos**: Criar, visualizar, editar e excluir
- **Ocorrências Veiculares**: Gestão completa
- **Vigilância Veicular**: Monitoramento
- **Prestadores**: Cadastro com dados bancários
- **Clientes**: Empresas contratantes
- **Agentes**: Funcionários do sistema
- **Usuários**: Gestão de acesso (apenas admin)

### Relatórios
- **PDF**: Relatórios detalhados formatados
- **Excel**: Exportação de dados para planilhas
- **Filtros**: Por data, status, cliente, etc.

### Upload de Arquivos
- **Fotos**: Evidências de atendimentos
- **Documentos**: Arquivos de prestadores
- **Validação**: Tipos e tamanhos permitidos

### Temas
- **Modo Claro**: Fundo branco com detalhes azuis
- **Modo Escuro**: Fundo escuro com detalhes azuis
- **Alternância**: Botão para trocar entre modos
- **Persistência**: Tema salvo no localStorage

## Uso

### Login
1. Acesse o sistema pelo navegador
2. Use as credenciais padrão ou criadas
3. Será redirecionado para o dashboard

### Navegação
- **Sidebar**: Menu principal com todos os módulos
- **Header**: Informações do usuário e alternância de tema
- **Breadcrumb**: Navegação contextual

### Criação de Registros
1. Acesse o módulo desejado
2. Clique em "Novo" ou "Adicionar"
3. Preencha o formulário
4. Salve as informações

### Geração de Relatórios
1. Acesse "Relatórios" no menu
2. Selecione o tipo de relatório
3. Configure filtros (opcional)
4. Escolha formato (PDF ou Excel)
5. Baixe o arquivo gerado

## Segurança

- **Autenticação**: Sistema de login obrigatório
- **Autorização**: Níveis de acesso (admin/usuário)
- **CSRF Protection**: Proteção contra ataques CSRF
- **Sanitização**: Dados sanitizados antes do armazenamento
- **Logs**: Registro de ações dos usuários

## Personalização

### Cores e Temas
Edite `assets/css/style.css` para personalizar:
- Variáveis CSS para cores
- Temas claro e escuro
- Responsividade

### Funcionalidades
- Adicione novos módulos em `controllers/` e `models/`
- Crie novas views em `views/`
- Estenda funcionalidades existentes

## Suporte

Para suporte técnico ou dúvidas:
- Verifique a documentação
- Analise os logs de erro
- Consulte os comentários no código

## Versão

**v1.0.0** - Sistema completo com todas as funcionalidades solicitadas

---

**Desenvolvido especificamente conforme requisitos do usuário**

