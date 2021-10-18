DROP TABLE IF EXISTS advogados;

CREATE TABLE `advogados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(35) NOT NULL,
  `especialidade` varchar(35) NOT NULL,
  `foto` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO advogados VALUES("6","Érica Limeira","444.444.444-44","(99) 99999-9999","erica@teste.com","Criminal",NULL);
INSERT INTO advogados VALUES("7","Maite Limeira","111.111.111-11","(21) 11111-1111","mlm@teste.com",NULL,NULL);


DROP TABLE IF EXISTS audiencias;

CREATE TABLE `audiencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_processo` varchar(35) NOT NULL,
  `descricao` varchar(35) NOT NULL,
  `data_audiencia` date NOT NULL,
  `hora_audiencia` time NOT NULL,
  `local` varchar(35) NOT NULL,
  `advogado` varchar(20) NOT NULL,
  `cliente` varchar(20) NOT NULL,
  `observacao` varchar(350) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO audiencias VALUES("5","1111111-11.1111.111.1111","Teste Quantidade","2021-09-27","22:33:00","teste 1 ","444.444.444-44","21.212.121/2121-21","Teste de Observação da Audiencia");
INSERT INTO audiencias VALUES("7","1111111-11.1111.111.1111","Reconhecimento de Firma","2021-09-28","15:15:00","Forum Meier2","444.444.444-44","21.212.121/2121-21",NULL);
INSERT INTO audiencias VALUES("8","7171717-17.1717.171.7170","Audiencia Open Line","2021-09-17","18:18:00","Forum Centro","444.444.444-44","21.252.254/0000-01","Testando Audiencia Open Line");
INSERT INTO audiencias VALUES("9","1111111-11.1111.111.1111","teste","2021-09-24","15:00:00","Forum Centro","444.444.444-44","21.212.121/2121-21",NULL);


DROP TABLE IF EXISTS cargos;

CREATE TABLE `cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO cargos VALUES("1","Advogado");
INSERT INTO cargos VALUES("2","Tesoureiro");
INSERT INTO cargos VALUES("4","Recepcionista");


DROP TABLE IF EXISTS clientes;

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(35) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `advogado` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `obs` varchar(350) NOT NULL,
  `tipo_pessoa` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO clientes VALUES("4","Chagas ","010.101.010-10","(10) 10101-0101","flc@teste.com","rua teixeira ","444.444.444-44","2021-08-04","teste pf","F");
INSERT INTO clientes VALUES("5","Open Line LTDA","21.252.254/0000-01","(21) 97777-7777","open_line@teste.com","Rua A","444.444.444-44","2021-08-04","teste teste","J");
INSERT INTO clientes VALUES("6","Rodrigo ","21.212.121/2121-21","(21) 21212-1212","t@t.com","rua CC","444.444.444-44","2021-08-05","resetekwjnkwlejrklew","J");


DROP TABLE IF EXISTS contas_pagar;

CREATE TABLE `contas_pagar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_vencimento` date NOT NULL,
  `data_pagamento` date DEFAULT NULL,
  `ind_pago` varchar(1) NOT NULL,
  `funcionario` varchar(20) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO contas_pagar VALUES("1","Conta de Luz","250.00","2021-09-14","2021-09-09","S","222.222.222-22","ArquivoFatura.pdf");
INSERT INTO contas_pagar VALUES("3","Conta de Gas","350.56","2021-09-10","2021-09-21","S","222.222.222-22","WhatsApp Image 2021-08-19 at 17.04.08.jpeg");
INSERT INTO contas_pagar VALUES("4","Conta de Gasolina","400.00","2021-09-10",NULL,"N","222.222.222-22","sem-foto.png");
INSERT INTO contas_pagar VALUES("5","Conta de Telefone","123.25","2021-09-10",NULL,"N","999.999.999-99","Novo Projeto.png");


DROP TABLE IF EXISTS contas_receber;

CREATE TABLE `contas_receber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(35) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `advogado` varchar(20) NOT NULL,
  `cliente` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `ind_pagamento` varchar(1) NOT NULL,
  `id_processo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO contas_receber VALUES("1","Custas Iniciais ","1800.00","444.444.444-44","21.252.254/0000-01","2021-10-05","S","13");
INSERT INTO contas_receber VALUES("3","Reconhecimento de Firma","150.00","444.444.444-44","21.212.121/2121-21","2021-09-30","S","11");
INSERT INTO contas_receber VALUES("4","Custo Inicial","1200.00","444.444.444-44","21.212.121/2121-21","2021-10-01","S","14");
INSERT INTO contas_receber VALUES("5","Testando positivo","6500.00","444.444.444-44","21.212.121/2121-21","2021-10-28","S","14");
INSERT INTO contas_receber VALUES("6","Custas de Documentos","1300.00","444.444.444-44","21.212.121/2121-21","2021-09-15","S","12");
INSERT INTO contas_receber VALUES("7","Custas Judiciais","2500.00","444.444.444-44","21.212.121/2121-21","2021-09-21","N","14");


DROP TABLE IF EXISTS documentos;

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `num_processo` varchar(30) NOT NULL,
  `arquivo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO documentos VALUES("2","Comprovante de Fatura paga","2021-09-20","1111111-11.1111.111.1111","imagem not.jpeg");


DROP TABLE IF EXISTS especialidades;

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO especialidades VALUES("1","Trabalhista");
INSERT INTO especialidades VALUES("2","Criminal");
INSERT INTO especialidades VALUES("3","Familiar");


DROP TABLE IF EXISTS funcionarios;

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

INSERT INTO funcionarios VALUES("14","Érica Limeira","444.444.444-44","(99) 99999-9999","erica@teste.com","Advogado");
INSERT INTO funcionarios VALUES("15","Maite Limeira","111.111.111-11","(21) 11111-1111","mlm@teste.com","Advogado");
INSERT INTO funcionarios VALUES("17","Tesoureiro","999.999.999-99","(11) 11111-1111","tesoureiro@gmail.com","Tesoureiro");
INSERT INTO funcionarios VALUES("18","Recepcionista","222.222.222-22","(11) 11111-1111","recepcionista@gmail.com","Recepcionista");


DROP TABLE IF EXISTS historico;

CREATE TABLE `historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `observacao` varchar(450) DEFAULT NULL,
  `data` date NOT NULL,
  `num_processo` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO historico VALUES("1","Envio de Petição 2","Petição Inicial do Processo 2","2021-09-23","1111111-11.1111.111.1111");
INSERT INTO historico VALUES("3","Movimentação 2"," Segunda movimentação do processo para resultado do teste","2021-09-27","1111111-11.1111.111.1111");
INSERT INTO historico VALUES("4","Foi para o juiz"," djahbdjahdhsadas","2021-09-21","1111111-11.1111.111.1111");
INSERT INTO historico VALUES("5","Juiz Open Line SAfado"," ","2021-09-21","7171717-17.1717.171.7170");


DROP TABLE IF EXISTS movimentacoes;

CREATE TABLE `movimentacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(1) NOT NULL COMMENT 'E - Entrada / S - Saida',
  `movimento` varchar(35) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `funcionario` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `id_movimento` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO movimentacoes VALUES("1","E","Processo","1800.00","222.222.222-22","2021-09-08","1");
INSERT INTO movimentacoes VALUES("2","S","Pagamento Conta","250.00","222.222.222-22","2021-09-09","1");
INSERT INTO movimentacoes VALUES("4","S","Pgto Funcionário","3650.25","222.222.222-22","2021-09-10","2");
INSERT INTO movimentacoes VALUES("5","E","Processo","150.00","222.222.222-22","2021-09-10","3");
INSERT INTO movimentacoes VALUES("6","E","Processo","1200.00","222.222.222-22","2021-09-10","4");
INSERT INTO movimentacoes VALUES("7","E","Processo","6500.00","222.222.222-22","2021-09-10","5");
INSERT INTO movimentacoes VALUES("8","S","Pagamento Conta","350.56","222.222.222-22","2021-09-21","3");
INSERT INTO movimentacoes VALUES("9","E","Processo","1300.00","222.222.222-22","2021-09-21","6");


DROP TABLE IF EXISTS pagamentos;

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionario` varchar(20) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `tesoureiro` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `nome_funcionario` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO pagamentos VALUES("2","111.111.111-11","3650.25","222.222.222-22","2021-09-10","Maite Limeira");


DROP TABLE IF EXISTS parte_contraria;

CREATE TABLE `parte_contraria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(35) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `advogado` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `obs` varchar(350) NOT NULL,
  `tipo_pessoa` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO parte_contraria VALUES("1","Hotel Nacional","11.111.111/1111-21","(12) 12121-2121","teste@teste.teste","rua 71","444.444.444-44","2021-08-05","empresa Z","J");
INSERT INTO parte_contraria VALUES("2","Caloteiro Silva","171.171.171-71","(71) 71717-1717","71@caloteiro.com","Rua 171","444.444.444-44","2021-08-05","Caloteiro 171","F");


DROP TABLE IF EXISTS processos;

CREATE TABLE `processos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_processo` varchar(35) DEFAULT NULL,
  `vara` varchar(35) NOT NULL,
  `tipo_acao` varchar(35) NOT NULL,
  `advogado` varchar(20) NOT NULL,
  `cliente` varchar(20) NOT NULL,
  `parte_contraria` varchar(20) DEFAULT NULL,
  `data_audiencia` date DEFAULT NULL,
  `hora_audiencia` time DEFAULT NULL,
  `data_peticao` date DEFAULT NULL,
  `data_abertura` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `tipo_pessoa` varchar(1) NOT NULL,
  `qtd_audiencias` int(11) NOT NULL,
  `observacao` varchar(350) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO processos VALUES("1","1111111-11.1111.111.1121","3","3","444.444.444-44","21.212.121/2121-21","171.171.171-71","2021-09-13","20:31:00","2021-08-18","2021-08-09","Concluido","F",NULL,NULL);
INSERT INTO processos VALUES("11","9999999-99.9999.999.9999","1","1","444.444.444-44","21.212.121/2121-21","11.111.111/1111-21",NULL,NULL,NULL,"2021-08-11","Cancelado","J",NULL,NULL);
INSERT INTO processos VALUES("12","4444444-44.4444.444.4444","3","3","444.444.444-44","21.212.121/2121-21","171.171.171-71",NULL,NULL,"0000-00-00","2021-08-11","Andamento","F",NULL,NULL);
INSERT INTO processos VALUES("13","7171717-17.1717.171.7170","3","1","444.444.444-44","21.252.254/0000-01","11.111.111/1111-21","2021-09-17","18:18:00","2021-08-18","2021-08-11","Arquivado","J","1",NULL);
INSERT INTO processos VALUES("14","1111111-11.1111.111.1111","2","3","444.444.444-44","21.212.121/2121-21","111.111.111-11","2021-09-21","15:00:00",NULL,"2021-09-10","Concluido","F","3","Teste de Obswercao no processo");


DROP TABLE IF EXISTS tarefas;

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `hora` time DEFAULT NULL,
  `advogado` varchar(20) NOT NULL,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO tarefas VALUES("1","Reunião Cliente","Reunião com cliente Open Line","2021-08-30","15:00:00","444.444.444-44","Agendada");
INSERT INTO tarefas VALUES("5","jdaijdaijdai","iosjdasijdjasi","2021-08-30","03:00:00","444.444.444-44","Agendada");
INSERT INTO tarefas VALUES("7","sdsadsa","asdsadsada","2021-08-31","02:22:00","444.444.444-44","Agendada");
INSERT INTO tarefas VALUES("8","Almoço com Cliente","asdasdas","2021-08-30","02:02:00","444.444.444-44","Agendada");
INSERT INTO tarefas VALUES("9","Reunião de Almoço Hotel 1","Reunião de almoço do cliente para saber sobre o ca","2021-12-07","16:00:00","444.444.444-44","Agendada");


DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `usuario` varchar(35) NOT NULL,
  `senha` varchar(150) NOT NULL,
  `senha_original` varchar(20) NOT NULL,
  `nivel` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

INSERT INTO usuarios VALUES("6","Rodrigo Monteiro","000.000.000-00","rodrigo.90.monteiro@gmail.com","202cb962ac59075b964b07152d234b70","123","admin");
INSERT INTO usuarios VALUES("12","Érica Limeira","444.444.444-44","erica@teste.com","da9d3427a781fc66847d855ed67c7ae7","44444444444","Advogado");
INSERT INTO usuarios VALUES("14","Maite Limeira","111.111.111-11","mlm@teste.com","adbc91a43e988a3b5b745b8529a90b61","11111111111","Advogado");
INSERT INTO usuarios VALUES("16","Chagas ","010.101.010-10","flc@teste.com","8e5c9db8a9ae5499768c4e921a9cfa65","01010101010","Cliente");
INSERT INTO usuarios VALUES("17","Open Line LTDA","21.252.254/0000-01","open_line@teste.com","e61abe3f08d4d26750b4c79e1f92f489","21252254000001","Cliente");
INSERT INTO usuarios VALUES("18","Rodrigo ","21.212.121/2121-21","t@t.com","e10adc3949ba59abbe56e057f20f883e","123456","Cliente");
INSERT INTO usuarios VALUES("21","Tesoureiro","999.999.999-99","tesoureiro@gmail.com","473a9b0f3477d9422fe57bfae5cdf290","99999999999","Tesoureiro");
INSERT INTO usuarios VALUES("22","Recepcionista","222.222.222-22","recepcionista@gmail.com","13723a026a1a9b499f0e9f9fb8f4f6ad","22222222222","Recepcionista");


DROP TABLE IF EXISTS varas;

CREATE TABLE `varas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO varas VALUES("1","3º Vara do Meier");
INSERT INTO varas VALUES("2","1º Vara");
INSERT INTO varas VALUES("3","Vara da Família");


