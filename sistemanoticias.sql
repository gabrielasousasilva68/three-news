-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Tempo de geração: 25/09/2026 às 13:23
-- Versão do servidor: 8.0.44
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistemanoticias`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int NOT NULL,
  `id_noticia` int NOT NULL,
  `id_usuario` int NOT NULL,
  `comentario` text NOT NULL,
  `data_comentario` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('ativo','analise','excluido') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_noticia`, `id_usuario`, `comentario`, `data_comentario`, `status`) VALUES
(2, 8, 2, 'muito bom', '2026-09-18 11:21:30', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curtidas_comentarios`
--

CREATE TABLE `curtidas_comentarios` (
  `id_curtida` int NOT NULL,
  `id_comentario` int NOT NULL,
  `id_usuario` int NOT NULL,
  `data_curtida` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id_noticia` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumo` varchar(500) DEFAULT NULL,
  `conteudo` mediumtext NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `data_publicacao` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id_noticia`, `titulo`, `resumo`, `conteudo`, `imagem`, `categoria`, `autor`, `data_publicacao`) VALUES
(3, 'Minha Melhor Amiga', 'nova comédia nacional dirigida por Susana Garcia e estrelada por Mônica Martelli, Ingrid Guimarães, Giulia Benite e Gabi Amaral. O longa que nasceu porque Mônica e Ingrid com suas filhas viralizaram na internet e agora ganharam uma versão ficcional nos cinemas.', '<p>Na trama, Júlia e Clara são melhores amigas que chegam aos 50 anos enfrentando diferentes crises pessoais. Enquanto suas filhas adolescentes estão em Portugal estudar, as duas decidem embarcar para a Europa também. O que deveria ser uma viagem tranquila rapidamente vira uma sucessão de encontros, confusões e descobertas que fazem as duas repensarem suas próprias vidas.</p>  \r\n\r\n<p>O maior acerto de Minha Melhor Amiga é justamente a química entre Mônica e Ingrid. Existe uma intimidade muito natural entre as duas, e o filme sabe aproveitar isso em uma sequência quase incessante de piadas, discussões e situações absurdas. É fácil acreditar que estamos acompanhando duas amigas reais, especialmente porque algumas situações foram inspiradas nas experiências que elas realmente viveram.</p>  \r\n\r\n<p>A comédia também ganha força por não tratar suas protagonistas como mulheres que precisam ter a vida resolvida. Júlia e Clara estão lidando com relacionamentos, trabalho, maternidade, envelhecimento e a sensação de que talvez seja tarde demais para recomeçar. A viagem funciona, então, como uma oportunidade de recuperar uma liberdade que parecia ter ficado para trás. Giulia Benite e Gabi Amaral também funcionam bem como contraponto mais jovem às protagonistas. Além disso, muitas referências as situações que realmente aconteceram nas viagens delas são genialmente colocadas para quem acompanhou, sem nichar o filme, o que vale para algumas outras referências do filme, inclusive para uma bonita homenagem ao Paulo Gustavo, muito amigo das duas.</p>  \r\n\r\n<p>Por outro lado, o filme nem sempre consegue reproduzir a espontaneidade que tornou os “causos” da dupla tão divertidos fora das telas. Principalmente quando ele tenta ser sério ou tenta se ensinar alguma lição, que é quando o roteiro deixa de ser natural e parece uma palestra coach. A fórmula também se repete bastante, e nem todas as piadas acertam.</p>  \r\n\r\n<p>Ainda assim, Minha Melhor Amiga entende perfeitamente o seu público e entrega exatamente o que promete: uma comédia leve, caótica e carismática sobre amizade, viagens e recomeços. É uma ótima oportunidade para rir das desgraças alheias e, talvez, sair do cinema querendo marcar uma viagem com sua própria melhor amiga.</p> \r\n\r\n<p>Divertido e caótico, Minha Melhor Amiga estreia nos cinemas brasileiros em 3 de setembro.</p>\r\n\r\n\r\n', 'uploads/c321c6113d388a3d8011eaadc710f3e7.png', 'Filmes e Series', 'Lívia Campos ', '2026-09-18 10:29:14'),
(4, 'Saiba tudo sobre o Emmy Awards 2026', 'Quais são os indicados?', '<p>A série dramática \"The Pitt\" lidera a edição com 25 indicações, consagrando-se como a favorita nas categorias de drama.</p>\r\n\r\n<p>Logo atrás aparece \"Hacks\", cuja temporada final conquistou 24 indicações, um recorde para uma série de comédia em um único ano. A produção disputará o prêmio de Melhor Série de Comédia ao lado de títulos como \"Abbott Elementary\", \"The Bear\", \"Only Murders in the Building\", \"Shrinking\", \"Nobody Wants This\", \"Margo\'s Got Money Troubles\" e \"Widow\'s Bay\".</p>\r\n\r\n<p>Antecipando alguns dos prêmios e diminuindo o tempo da cerimônia, a Academia de Artes e Ciências da Televisão já anunciou, no dia 7 de setembro, os vencedores das categorias técnicas do evento. A lista consagrou as produções \"Widow\'s Bay\", \"DTF: St. Louis\" e a recém-cancelada \"Spider-Noir\" como as grandes premiadas.</p> \r\n\r\n<p>Quais são os apresentadores?</p>\r\n<p>A apresentação ficará a cargo de Mariska Hargitay, primeira mulher a ocupar a função em 15 anos.</p>\r\n\r\n<p>Para a entrega dos prêmios no palco, a Television Academy listou alguns nomes, como Zendaya, Florence Pugh, Macaulay Culkin, Jamie Lee Curtis e Emma D\'Arcy.</p>\r\n\r\n<p>Que horas e onde assistir?</p>\r\n<p>Este ano, a HBO e a TNT são responsáveis pela transmissão oficial do evento ao vivo. A programação terá início com a cobertura do tapete vermelho, comandada pela correspondente Carol Ribeiro. Antes da cerimônia, o canal da TNT Brasil no YouTube também exibirá o pré-show.</p>\r\n\r\n<p>A partir das 21h, a transmissão da premiação no canal linear e na plataforma de streaming contará com comentários da especialista em séries e filmes Aline Diniz e tradução simultânea de Regina Pierantoni Mccarthy e Robert Greathouse.</p>\r\n', 'uploads/46a53bf92edbed8fb82486f878b3565c.png', 'Entretenimento', 'Ingrid Rocha', '2026-09-18 10:33:23'),
(5, 'A Hipótese do Amor', 'Do BookTok ao Prime Video com Lili Reinhart', '<p>O que começou como uma fanfic de Star Wars acabou virando um dos romances mais queridinhos dos últimos anos. A Hipótese do Amor, de Ali Hazelwood, conquistou leitores, viralizou no BookTok e agora está prestes a ganhar uma versão nas telas.</p>\r\n\r\n<p>O filme chega ao Prime Video em 23 de setembro, com Lili Reinhart como Olive Smith e Tom Bateman no papel de Adam Carlsen. Mas, antes de os dois personagens ganharem vida nas páginas, a história de Ali Hazelwood tinha outros protagonistas: Rey e Kylo Ren, de Star Wars.</p>\r\n\r\n<p>A autora começou escrevendo uma história inspirada na dupla e, com o tempo, transformou a ideia em algo completamente novo. Foi assim que nasceram Olive e Adam.</p>\r\n\r\n<p>De fanfic de Star Wars a fenômeno literário\r\nNa história que chegou às livrarias, Olive Smith é uma doutoranda dedicada à carreira e pouco interessada em relacionamentos. Até que sua melhor amiga, Ahn, demonstra interesse por Jeremy, um antigo affair de Olive.</p>\r\n\r\n<p>Para provar que já superou o rapaz, ela toma uma decisão impulsiva: beija Adam Carlsen, um professor conhecido pelo temperamento nada amigável.</p>\r\n\r\n<p>O problema? O momento dá início a um relacionamento de mentira entre os dois.</p>\r\n\r\n<p>A partir daí, o que deveria ser apenas um acordo começa a ficar cada vez mais complicado. E foi justamente essa mistura de romance, vida acadêmica e muita tensão entre os protagonistas que conquistou os leitores.</p>\r\n\r\n<p>A Hipótese do Amor também encontrou uma enorme comunidade nas redes sociais. O livro viralizou no BookTok, comunidade literária do TikTok, e esteve entre os títulos mais vendidos na Bienal do Livro do Rio de 2025.</p>\r\n\r\n<p>E o filme tem uma conexão curiosa com Star Wars\r\nSe a origem da história já é curiosa, a escalação do filme deixou tudo ainda mais interessante.</p>\r\n\r\n<p>Tom Bateman foi uma das inspirações de Ali Hazelwood para criar Adam Carlsen. E o ator tem uma conexão direta com Star Wars: ele é casado com Daisy Ridley, intérprete de Rey, uma das personagens que inspiraram a fanfic original.</p>\r\n\r\n<p>Ou seja, a história deu uma volta e tanto. Rey e Kylo Ren inspiraram a fanfic, que virou o livro de Olive e Adam, e agora chega às telas com o próprio Tom Bateman no papel do protagonista.</p>\r\n\r\n<p>Na adaptação, Lili Reinhart interpreta Olive, enquanto Bateman vive Adam. O filme acompanha a mesma dinâmica do livro e promete levar para as telas a relação de mentira que começa a ficar cada vez mais real.</p>\r\n\r\n', 'uploads/a003265d34f393a5e61b414e9b5ba03f.png', 'Livros', 'Gabriela de Sousa Silva', '2026-09-18 10:37:22'),
(6, 'Zara Larsson conquista o público com show cheio de energia', 'Cantora sueca apresentou seus maiores sucessos e músicas de sua nova fase, levando muita música e animação aos fãs', '<p>A cantora sueca Zara Larsson voltou a ser destaque entre os fãs de música pop após realizar um show que reuniu seus principais sucessos e músicas de sua nova fase. Conhecida internacionalmente por canções como “Lush Life”, “Never Forget You” e “Symphony”, a artista apresentou uma performance marcada por muita energia, dança e interação com o público.</p>\r\n\r\n<p>Durante a apresentação, Zara mostrou diferentes momentos de sua carreira e também cantou músicas mais recentes. O repertório misturou faixas dançantes e canções que destacam os vocais da cantora, fazendo com que o público acompanhasse a apresentação do início ao fim.</p>\r\n\r\n<p>Além das músicas, a produção do espetáculo chamou atenção pelos efeitos de iluminação, coreografias e pelo visual do palco. Zara também conversou com os fãs durante o show, criando momentos de proximidade com o público e demonstrando sua animação em estar diante dos admiradores.</p>\r\n\r\n<p>Nas redes sociais, vídeos e fotos da apresentação começaram a circular entre os fãs, que comentaram sobre a performance da cantora. A repercussão mostrou que Zara Larsson continua tendo uma forte presença no cenário internacional do pop.</p>\r\n\r\n<p>Com uma carreira que já soma vários sucessos e milhões de fãs ao redor do mundo, Zara segue investindo em novas músicas e apresentações. O show também reforça a atual fase da artista, que busca apresentar ao público uma versão mais madura de seu trabalho sem deixar de lado o pop dançante que marcou sua trajetória.</p>\r\n\r\n', 'uploads/a6840103d2efdae7b984c4c8cea6672e.png', 'Musica', 'Gabriela de Sousa Silva', '2026-09-18 10:47:03'),
(7, 'Maior São João do Cerrado retorna a Ceilândia e celebra a cultura nordestina', 'Festival reuniu música, quadrilhas, gastronomia e tradições populares em dez dias de programação gratuita', 'O Maior São João do Cerrado voltou para Ceilândia, no Distrito Federal, em 2026. Realizado entre os dias 7 e 16 de agosto, o festival retornou à cidade onde nasceu e ocupou diferentes espaços da região.\r\n\r\nDurante os dez dias de evento, o público acompanhou apresentações musicais, quadrilhas juninas, forró, manifestações da cultura popular, além de comidas típicas e feiras de artesanato.\r\n\r\nAs quadrilhas juninas foram um dos destaques da programação. A Arena do <p>Folclore recebeu apresentações de quadrilhas juninas e grupos de danças folclóricas, além de um concurso de quadrilhas juninas escolares que contou com a participação de oito escolas.</p>\r\n\r\n<p>As apresentações levaram ao público figurinos coloridos, coreografias e músicas tradicionais das festas juninas. Além de entreter, as quadrilhas ajudam a preservar manifestações da cultura popular e aproximam os jovens das tradições nordestinas.</p>\r\n\r\n<p>Entre os principais shows da edição estiveram Alceu Valença, Michel Teló e Mari Fernandez. O evento também contou com espaços dedicados ao forró, artesanato, gastronomia e outras manifestações culturais.</p>\r\n\r\n<p>O retorno do festival para Ceilândia teve ainda um significado especial, já que a festa possui uma ligação histórica com a cidade. A programação reuniu música e tradições populares, valorizando a cultura nordestina e as manifestações culturais presentes no Distrito Federal.</p>\r\n\r\n', 'uploads/7747bdfef72039e2c0bad79ddcefd855.png', 'Cultura', 'Lívia Campos', '2026-09-18 10:54:10'),
(8, 'Quadrilha Bimboca representa o CEM 1 de Brazlândia em grandes eventos juninos', 'Do pátio da escola aos grandes palcos: Bimboca conquista Brazlândia e leva o CEM 1 ao Maior São João do Cerrado.', 'A cultura junina ganhou ainda mais destaque no Centro de Ensino Médio 1 de Brazlândia com a trajetória da quadrilha escolar Bimboca. O grupo conquistou o primeiro lugar no concurso de quadrilhas realizado pela própria escola e, posteriormente, levou sua dança para eventos importantes do Distrito Federal.\r\n\r\n<p>Após a vitória no concurso escolar, a Bimboca se apresentou na tradicional festa junina de Brazlândia, reunindo estudantes e comunidade em uma celebração marcada por música, dança e elementos da cultura popular.</p>\r\n\r\n<p>A trajetória do grupo também chegou a Ceilândia. A quadrilha participou do Maior São João do Cerrado, um dos eventos juninos de destaque do Distrito Federal, competindo no concurso de quadrilhas escolares.</p>\r\n<img src=\"../assets/img/anaclara.png\">\r\n<p>Para os integrantes, participar dessas apresentações representa mais do que uma competição. A quadrilha também se tornou uma forma de valorizar a cultura popular, fortalecer os vínculos entre os estudantes e levar o nome do CEM 1 de Brazlândia para outros espaços.</p>\r\n\r\n<p>Com coreografias, figurinos e muita dedicação, a Bimboca transformou os ensaios e a experiência escolar em uma trajetória que ultrapassou os limites da escola. A participação em diferentes eventos mostra como as festas juninas continuam sendo um espaço de encontro entre juventude, tradição e cultura no Distrito Federal.</p>', 'uploads/fe79e419b5c50c6b1b9fa4c53f8eb5f0.png', 'Cultura', 'Gabriela de Sousa Silva', '2026-09-18 11:13:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` enum('admin','moderador','leitor') DEFAULT 'leitor',
  `pergunta_seguranca` varchar(255) NOT NULL,
  `resposta_seguranca` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `tipo_usuario`, `pergunta_seguranca`, `resposta_seguranca`, `foto_perfil`, `data_cadastro`) VALUES
(1, 'Lucas dos Santos Camilo', 'lucas.6161@df.senac.br', '$2y$10$/udTA6QeUq3FHZdOjSezGOR2oTeHlYGyDS.cdhpYIxJ/5Ez6KntVq', 'admin', 'Qual o nome do seu primeiro animal de estimação?', '$2y$10$UXiryxyNeLrB7//XOVHKIOwIze5qtYQYEJDvixWq6lnWI0zbcllIC', NULL, '2026-09-04 11:03:59'),
(2, 'gabriela de sousa', 'gabriela.sousasilva68@gmail.com', '$2y$10$2dJGlKcJyTRhPMA5lex14.weiCovEUfWVQdWMiinpo1MkYfe7kADC', 'admin', 'Qual o nome do seu primeiro animal de estimação?', '$2y$10$EnXCgW7l2pAgqclriBLDVeJmp6zzqBek.oFgGz6rZhEtOek5kgP96', NULL, '2026-09-09 08:23:06');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_noticia` (`id_noticia`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `curtidas_comentarios`
--
ALTER TABLE `curtidas_comentarios`
  ADD PRIMARY KEY (`id_curtida`),
  ADD UNIQUE KEY `id_comentario` (`id_comentario`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `curtidas_comentarios`
--
ALTER TABLE `curtidas_comentarios`
  MODIFY `id_curtida` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id_noticia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_noticia`) REFERENCES `noticias` (`id_noticia`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `curtidas_comentarios`
--
ALTER TABLE `curtidas_comentarios`
  ADD CONSTRAINT `curtidas_comentarios_ibfk_1` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`id_comentario`) ON DELETE CASCADE,
  ADD CONSTRAINT `curtidas_comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
