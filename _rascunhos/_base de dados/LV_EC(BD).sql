CREATE TABLE Pagamento (
  codigoPagamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  descricao TEXT NOT NULL,
  tipo VARCHAR(30) NOT NULL,
  PRIMARY KEY(codigoPagamento)
);

CREATE TABLE Detalhes (
  codigoDetalhes INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  dataHora DATETIME NOT NULL,
  preco DECIMAL NOT NULL,
  PRIMARY KEY(codigoDetalhes)
);

CREATE TABLE Funcionario (
  codigoFuncionario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cargo VARCHAR(20) NOT NULL,
  PRIMARY KEY(codigoFuncionario)
);

CREATE TABLE Fornecedor (
  codigoFornecedor INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nomeF VARCHAR(40) NOT NULL,
  representante INTEGER UNSIGNED NOT NULL,
  fundacao DATE NOT NULL,
  dataDeCadastro DATE NOT NULL,
  OBS TEXT NOT NULL,
  iban TEXT NOT NULL,
  PRIMARY KEY(codigoFornecedor)
);

CREATE TABLE Cliente (
  codigoCliente INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  descontos INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(codigoCliente)
);

CREATE TABLE Banco (
  codigoBanco INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nomeBanco VARCHAR(60) NOT NULL,
  identificacao VARCHAR(80) NOT NULL,
  cartaoDeContribuente VARCHAR(80) NOT NULL,
  iban VARCHAR(80) NOT NULL,
  numeroDeConta VARCHAR(80) NOT NULL,
  salario DECIMAL NOT NULL,
  valorNaConta DECIMAL NOT NULL,
  fotografia BIT NOT NULL,
  senhaInformacao VARCHAR(60) NOT NULL,
  PRIMARY KEY(codigoBanco)
);

CREATE TABLE Pessoa (
  codigoPessoa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Banco_codigoBanco INTEGER UNSIGNED NULL,
  nome VARCHAR(45) NOT NULL,
  dataDeNascimento DATE NOT NULL,
  identificacao VARCHAR(20) NOT NULL,
  palavraChave VARCHAR(20) NOT NULL,
  situacao VARCHAR(15) NOT NULL,
  nivel VARCHAR(15) NOT NULL,
  dataDeCadastro DATETIME NOT NULL,
  PRIMARY KEY(codigoPessoa),
  INDEX Pessoa_FKIndex1(Banco_codigoBanco),
  FOREIGN KEY(Banco_codigoBanco)
    REFERENCES Banco(codigoBanco)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE Produtos (
  codigoProdutos INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Funcionario_codigoFuncionario INTEGER UNSIGNED NULL,
  nome VARCHAR(20) NOT NULL,
  quantidadeDisponivel INTEGER UNSIGNED NOT NULL,
  quantidadeVendida INTEGER UNSIGNED NOT NULL,
  descricao TEXT NOT NULL,
  valor DECIMAL NOT NULL,
  estado VARCHAR(20) NOT NULL,
  PRIMARY KEY(codigoProdutos),
  INDEX Produtos_FKIndex1(Funcionario_codigoFuncionario),
  FOREIGN KEY(Funcionario_codigoFuncionario)
    REFERENCES Funcionario(codigoFuncionario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE filiacao (
  codigoFiliacao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Pessoa_codigoPessoa INTEGER UNSIGNED NULL,
  nomeDoPai VARCHAR(45) NOT NULL,
  nomeDaMae VARCHAR(45) NOT NULL,
  PRIMARY KEY(codigoFiliacao),
  INDEX filiacao_FKIndex1(Pessoa_codigoPessoa),
  FOREIGN KEY(Pessoa_codigoPessoa)
    REFERENCES Pessoa(codigoPessoa)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE contactos (
  codigoContactos INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Fornecedor_codigoFornecedor INTEGER UNSIGNED NULL,
  Pessoa_codigoPessoa INTEGER UNSIGNED NULL,
  telefone1 VARCHAR(45) NOT NULL,
  telefone2 VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  PRIMARY KEY(codigoContactos),
  INDEX contactos_FKIndex1(Pessoa_codigoPessoa),
  INDEX contactos_FKIndex2(Fornecedor_codigoFornecedor),
  FOREIGN KEY(Pessoa_codigoPessoa)
    REFERENCES Pessoa(codigoPessoa)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Fornecedor_codigoFornecedor)
    REFERENCES Fornecedor(codigoFornecedor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE endereco (
  codigoEndereco INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Fornecedor_codigoFornecedor INTEGER UNSIGNED NULL,
  Pessoa_codigoPessoa INTEGER UNSIGNED NULL,
  provincia VARCHAR(45) NOT NULL,
  municipio VARCHAR(45) NOT NULL,
  bairro VARCHAR(45) NOT NULL,
  rua VARCHAR(45) NOT NULL,
  numeroDeCasa VARCHAR(45) NOT NULL,
  PRIMARY KEY(codigoEndereco),
  INDEX endereco_FKIndex1(Pessoa_codigoPessoa),
  INDEX endereco_FKIndex2(Fornecedor_codigoFornecedor),
  FOREIGN KEY(Pessoa_codigoPessoa)
    REFERENCES Pessoa(codigoPessoa)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Fornecedor_codigoFornecedor)
    REFERENCES Fornecedor(codigoFornecedor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE Compras (
  codigoCompras INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Detalhes_codigoDetalhes INTEGER UNSIGNED NULL,
  Fornecedor_codigoFornecedor INTEGER UNSIGNED NULL,
  Produtos_codigoProdutos INTEGER UNSIGNED NULL,
  PRIMARY KEY(codigoCompras),
  INDEX Compras_FKIndex1(Produtos_codigoProdutos),
  INDEX Compras_FKIndex2(Fornecedor_codigoFornecedor),
  INDEX Compras_FKIndex3(Detalhes_codigoDetalhes),
  FOREIGN KEY(Produtos_codigoProdutos)
    REFERENCES Produtos(codigoProdutos)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Fornecedor_codigoFornecedor)
    REFERENCES Fornecedor(codigoFornecedor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Detalhes_codigoDetalhes)
    REFERENCES Detalhes(codigoDetalhes)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE Vendas (
  codigoVendas INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Detalhes_codigoDetalhes INTEGER UNSIGNED NULL,
  Pagamento_codigoPagamento INTEGER UNSIGNED NULL,
  Compras_codigoCompras INTEGER UNSIGNED NULL,
  Cliente_codigoCliente INTEGER UNSIGNED NULL,
  Funcionario_codigoFuncionario INTEGER UNSIGNED NULL,
  PRIMARY KEY(codigoVendas),
  INDEX Vendas_FKIndex1(Funcionario_codigoFuncionario),
  INDEX Vendas_FKIndex2(Cliente_codigoCliente),
  INDEX Vendas_FKIndex3(Compras_codigoCompras),
  INDEX Vendas_FKIndex4(Pagamento_codigoPagamento),
  INDEX Vendas_FKIndex5(Detalhes_codigoDetalhes),
  FOREIGN KEY(Funcionario_codigoFuncionario)
    REFERENCES Funcionario(codigoFuncionario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Cliente_codigoCliente)
    REFERENCES Cliente(codigoCliente)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Compras_codigoCompras)
    REFERENCES Compras(codigoCompras)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Pagamento_codigoPagamento)
    REFERENCES Pagamento(codigoPagamento)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Detalhes_codigoDetalhes)
    REFERENCES Detalhes(codigoDetalhes)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE login (
  codigoLogin INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Pessoa_codigoPessoa INTEGER UNSIGNED NULL,
  dataDeEntrada DATETIME NOT NULL,
  dataDeSaida DATETIME NOT NULL,
  PRIMARY KEY(codigoLogin),
  INDEX login_FKIndex1(Pessoa_codigoPessoa),
  FOREIGN KEY(Pessoa_codigoPessoa)
    REFERENCES Pessoa(codigoPessoa)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);


