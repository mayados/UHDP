-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 22, 2024 at 09:20 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uhdp`
--

-- --------------------------------------------------------

--
-- Table structure for table `animal_memorial`
--

CREATE TABLE `animal_memorial` (
  `id` int NOT NULL,
  `categorie_animal_id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` datetime DEFAULT NULL,
  `date_deces` datetime NOT NULL,
  `lieu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `choses_aimees` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `choses_detestees` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `histoire` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `animal_memorial`
--

INSERT INTO `animal_memorial` (`id`, `categorie_animal_id`, `auteur_id`, `nom`, `sexe`, `date_naissance`, `date_deces`, `lieu`, `photo`, `presentation`, `choses_aimees`, `choses_detestees`, `histoire`, `date_creation`) VALUES
(54, 1, 104, 'Jack', 'Male', NULL, '2023-06-11 00:00:00', NULL, 'english-bulldog-ga3ed62e89-640-6486d2b57daf2.jpg', '<p>Jack &eacute;tait mon ami, un gentil chien qui aiamait conna&icirc;tre de nouvelles choses</p>', '<p>Les spaghettis bolognaise</p>', '<p>Les orages, il avait peur de la foudre</p>', '<p>J&#39;ai fais la connaissance de Jack dans un refuge</p>', '2023-06-12 08:09:25'),
(55, 2, NULL, 'Nala', 'Femelle', '2011-08-16 00:00:00', '2023-03-05 00:00:00', NULL, 'cat-g9db9150e3-640-6486d35c71942.jpg', '<p>Nala &eacute;tait mon amie depuis des ann&eacute;es</p>', '<p>Jouer sur l&#39;arbre &agrave; chat&nbsp;</p>', '<p>Les croquettes pour chat</p>', '<p>J&#39;ai trouv&eacute; Nala dans la rue il y a plusieurs ann&eacute;es. Sa propri&eacute;taire est d&eacute;c&eacute;d&eacute;e en la sauvant d&#39;un incendie</p>', '2023-06-12 08:12:12'),
(56, 3, 105, 'Noony', 'Male', NULL, '2023-06-06 00:00:00', NULL, 'chinchilla-ge3ba83549-640-6486e62f7ec56.jpg', '<p>Noony &eacute;tait un gentil Chinchilla qui aimait sauter partout.. m&ecirc;me sur les &eacute;paules</p>', '<p>Il aimait particuli&egrave;rement les roses sech&eacute;es, c&#39;&eacute;tait sa friandise pr&eacute;f&eacute;r&eacute;e.</p>', '<p>L&#39;eau. Comme tous les chinchillas, il se baignait dans du sable et adorait &ccedil;a</p>', '<p>J&#39;accompagnais un ami dans une animalerie lorsque je vis Noony. Je ne pouvais pas me r&eacute;soudre &agrave; le laisser l&agrave; bas</p>', '2023-06-12 08:29:44'),
(67, 2, 108, 'Luna', 'Femelle', NULL, '2023-07-01 00:00:00', NULL, 'kitten-ga587f4bee-640-6488804a16fc1.jpg', '<p>Luna &eacute;tait une petite boule d&#39;amour. Elle suivait les personnes partout, elle adorait les gens.. Elle avait l&#39;habitude de s&#39;asseoir &agrave; c&ocirc;t&eacute; de nous. Elle &eacute;tait encore petite et n&#39;avait que quelques mois.&nbsp;</p>', '<p>Elle aimait le saumon..enfin aimait est un bien petit mot, en r&eacute;alit&eacute; elle adorait &ccedil;a&nbsp;</p>', '<p>Que l&#39;on &eacute;l&egrave;ve la voix.. &agrave; chaque fois que quelqu&#39;un le faisait elle allait se cacher sous un meuble</p>', '<p>J&#39;ai trouv&eacute; Luna dans la rue quand elle n&#39;avait probablement que quelques jours. Plus tard j&#39;ai appris que plus loin dans le quartier, toute une famille de chats (avec des b&eacute;b&eacute;s) avaient &eacute;t&eacute; retrouv&eacute;e empoisonn&eacute;e et battue.. Luna devait &ecirc;tre une rescap&eacute;e. Je l&#39;ai toujours ador&eacute;e, elle &eacute;tait si douce&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-13 14:10:33'),
(76, 1, NULL, 'Romeo', 'Male', '2010-02-14 00:00:00', '2023-06-11 00:00:00', NULL, 'poodle-g9ade51109-640-648881a0d74c0.jpg', '<p>Rom&eacute;o &eacute;tait comme un enfant. Il aimait les sorties o&ugrave; il en profitait pour se rouler dans l&#39;herbe.</p>', '<p>Il aimait la pluie, surtout en &eacute;t&eacute;. Cela cr&eacute;ait une ambiance sp&eacute;ciale. Il rentrait tout tremp&eacute;</p>', '<p>Devoir s&#39;en aller de l&#39;endroit o&ugrave; il avait fait sa place pour une siest</p>', '<p>J&#39;ai eu Rom&eacute;o tout b&eacute;b&eacute; car une amie a eu une port&eacute;e et je n&#39;ai pas pu m&#39;emp&ecirc;cher de craquer pour cette petite bouille&nbsp;<img alt=\"angel\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/angel_smile.png\" title=\"angel\" width=\"23\" /></p>', '2023-06-13 14:48:00'),
(77, 3, 116, 'Oreo', 'Male', '2017-08-15 00:00:00', '2023-06-12 00:00:00', NULL, 'animal-g17cb2860a-640-648882871d1ef.jpg', '<p>Mon petit Or&eacute;o qui &eacute;tait &agrave; croquer, comme ton nom ! Tu &eacute;tais un lapin adorable&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '<p>Tu adorais t&#39;amuser &agrave; aller dans les labyrinthes g&eacute;ants que l&#39;on cr&eacute;ait pour toi&nbsp;</p>', '<p>Tu d&eacute;testais ne pas recevoir de carottes pour le petit d&eacute;jeuner. Tu faisais la t&ecirc;te</p>', '<p>Je t&#39;ai connu en animalerie, o&ugrave; j&#39;&eacute;tais all&eacute; m&#39;abriter alors qu&#39;il pleuvait</p>', '2023-06-13 14:51:50'),
(78, 3, 54, 'Nini', 'Male', NULL, '2019-07-02 00:00:00', NULL, 'canary-gf1fe36504-640-64888432b6015.jpg', '<p>Nini, tu &eacute;tait mon petit canari</p>', '<p>Se promener dans les coins ensoleill&eacute;s</p>', '<p>Les endroits sales</p>', '<p>Nini, je t&#39;ai eu de par le d&eacute;c&egrave;s de ma tante</p>', '2023-06-13 14:58:58'),
(79, 3, 1, 'Benjamin', 'Male', NULL, '2023-06-12 00:00:00', NULL, 'default.png', '<p>Benjamin &eacute;tait une souris curieuse et d&eacute;brouillarde, toujours &agrave; la recherche de nouvelles d&eacute;couvertes et de petites aventures.</p>', '<p>Benjamin aimait se faufiler dans les endroits &eacute;troits et d&eacute;couvrir de nouveaux recoins de la maison. Il adorait partager des moments de complicit&eacute; avec ses amis animaux et cr&eacute;er une petite communaut&eacute; chaleureuse. Mais par-dessus tout, il trouvait un bonheur infini dans la d&eacute;gustation de d&eacute;licieux morceaux de fromage qui r&eacute;veillaient ses papilles.</p>', '<p>Benjamin d&eacute;testait les pi&egrave;ges sournois qui mettaient sa vie en danger. Il fuyait &eacute;galement les bruits forts et les mouvements brusques des humains. Mais par-dessus tout, il avait une aversion profonde pour les chats, ces pr&eacute;dateurs redoutables qui repr&eacute;sentaient une menace constante pour sa s&eacute;curit&eacute;.</p>', '<p>Un jour, alors que je rentrais chez moi, j&#39;aper&ccedil;u une petite souris explorer le salon. Elle semblait avoir mal &agrave; la patte et ne pouvait pas trop avancer. Intrigu&eacute;, je m&#39;agenouilla doucement et tendit la main, offrant &agrave; la petit souris que je nommerais Benjamin, un morceau de fromage. Les yeux p&eacute;tillants de Benjamin rencontr&egrave;rent les miens, et une amiti&eacute; sinc&egrave;re avait commenc&eacute;e. Cela a dur&eacute; durant deux ans, jusqu&#39;&agrave; ce qu&#39;il nous quitte brusquemment&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-13 19:33:21'),
(80, 1, 1, 'Prisca', 'Femelle', '2015-05-17 00:00:00', '2023-05-19 00:00:00', NULL, 'default.png', '<p>Prisca &eacute;tait une chienne affectueuse. Avec son pelage doux et dor&eacute;, ses yeux &eacute;tincelants et sa queue qui remue constamment, elle &eacute;tait un rayon de soleil qui apporte de la joie et de l&#39;amour &agrave; tous ceux qui croisaient son chemin.</p>', '<p>Prisca adorait les moments de d&eacute;tente, se blottissant aux c&ocirc;t&eacute;s de ses humains pour recevoir des caresses et des c&acirc;lins qui le comblaient de bonheur. Elle appr&eacute;ciait &eacute;galement les moments de jeu.</p>', '<p>Prisca n&#39;appr&eacute;ciait pas les aspirateurs ou les bruits forts qui l&#39;effrayaient et la faisaient aboyer avec m&eacute;fiance</p>', '<p>Lors d&#39;une journ&eacute;e sp&eacute;ciale adoption pr&eacute;par&eacute;e par un refuge, je me suis approch&eacute;e d&#39;un groupe de chiots joueurs et mon regard se posa sur Prisca, avec ses yeux brillants et sa queue en mouvement. Je m&#39;agenouilla pour la caresser, et instantan&eacute;ment, une connexion sp&eacute;ciale se cr&eacute;a entre nous.&nbsp;</p>', '2023-06-13 19:41:52'),
(81, 3, 1, 'Gringow', 'Male', NULL, '2011-11-30 00:00:00', NULL, 'default.png', '<p>Gringow &eacute;tait un Chinchilla au pelage blanc qui adorait courir et sauter un peu partout dans la maison. Il aimait s&#39;accrocher fort aux mains des personnes qui le carressaient.</p>', '<p>Gringow aimait beaucoup les p&eacute;tales de roses, qui &eacute;taient sa friandise pr&eacute;f&eacute;r&eacute;e. Il adorait &eacute;galement monter sur les &eacute;paules des personnes qu&#39;il appr&eacute;ciait et..mordre leur nez. Il &eacute;tait accro &agrave; son petit nounours en peluche avec lequel il dormait toujours.</p>', '<p>Il d&eacute;testait devoir rentrer dans sa cage pour dormir.</p>', '<p>Lorsque j&#39;&eacute;tais petite, je me suis rendue dans une animalerie avec mes parents. Il y avait plein d&#39;animaux, mais je ne remarquais que ce petit Chinchilla tout mignon qui regardait vers les personnes avec sa petite patte sur le barreau de la cage. Nous sommes ainsi repartis avec et nnous ne nous sommes plus quitt&eacute;s jusqu&#39;&agrave; ce que la vie en d&eacute;cide autrement</p>', '2023-06-13 19:50:41'),
(82, 3, 1, 'Nala', 'Femelle', NULL, '2023-06-13 00:00:00', NULL, 'ferret-gff3a83aa1-640-6489608fdc87a.jpg', '<p>Nala &eacute;tait un furet espi&egrave;gle et curieux, dot&eacute; d&#39;une personnalit&eacute; attachante. Avec sa fourrure douce et ses yeux p&eacute;tillants, elle captivait imm&eacute;diatement l&#39;attention de tous ceux qui la rencontrent. Dot&eacute;e d&#39;une grande agilit&eacute;, Nala adorait explorer son environnement, se faufiler dans les espaces les plus &eacute;troits et grimper sur les meubles avec gr&acirc;ce.</p>', '<p>Nala aimait particuli&egrave;rement les tunnels, les balles rebondissantes et les puzzles interactifs qui stimulaient son intelligence. Elle &eacute;tait aussi tr&egrave;s affectueuse et appr&eacute;ciait les moments de c&acirc;lins et de complicit&eacute;.</p>', '<p>Bien que Nala &eacute;tait un furet aimable et joyeux, il y a certaines choses qu&#39;elle n&#39;appr&eacute;ciait pas particuli&egrave;rement : elle d&eacute;testait &ecirc;tre confin&eacute;e dans un espace restreint pendant de longues p&eacute;riodes, pr&eacute;f&eacute;rant avoir la libert&eacute; de se d&eacute;placer et d&#39;explorer. Aussi, Nala n&#39;aimait pas &ecirc;tre n&eacute;glig&eacute;e ou ignor&eacute;e. Elle cherchait constamment de l&#39;attention et de l&#39;affection.</p>', '<p>J&#39;avais rencontr&eacute; Nala un jour en me promenant dans une animalerie. Alors que je parcourais les all&eacute;es remplies d&#39;adorables animaux, mon regard avait &eacute;t&eacute; captiv&eacute; par une petite boule de poil joueuse et curieuse. C&#39;&eacute;tait Nala, le furet espi&egrave;gle qui se tr&eacute;moussait dans sa cage avec tant d&#39;&eacute;nergie.</p>\r\n\r\n<p>Intrigu&eacute; par son charme irr&eacute;sistible, j&#39;avais d&eacute;cid&eacute; de m&#39;approcher et de lui offrir un peu d&#39;attention. &Agrave; ma grande surprise, elle s&#39;&eacute;tait imm&eacute;diatement tourn&eacute;e vers moi, les yeux brillants d&#39;excitation. C&#39;&eacute;tait comme si nous avions &eacute;tabli une connexion instantan&eacute;e, un lien sp&eacute;cial.</p>\r\n\r\n<p>Passant du temps avec Nala, j&#39;avais rapidement r&eacute;alis&eacute; &agrave; quel point elle &eacute;tait unique. Son esprit joueur et sa personnalit&eacute; attachante m&#39;avaient conquis. Je savais au plus profond de moi que je ne pouvais pas la laisser derri&egrave;re moi. C&#39;&eacute;tait ainsi que notre aventure avait commenc&eacute;, et depuis ce jour, Nala &eacute;tait devenue une part essentielle de ma vie.</p>\r\n\r\n<p>Chaque jour, nous explorions ensemble de nouvelles aventures, jouions &agrave; cache-cache dans les recoins de mon appartement et partagions des moments de complicit&eacute;. Nala &eacute;tait bien plus qu&#39;un simple animal de compagnie pour moi, elle &eacute;tait devenue une amie fid&egrave;le et aimante, pr&ecirc;te &agrave; r&eacute;pandre joie et bonheur dans ma vie.</p>', '2023-06-14 06:39:11'),
(83, 3, 57, 'Coco', 'Male', NULL, '2023-06-10 00:00:00', NULL, 'hamster-g56c24fc2d-640-64896259c0f9d.jpg', '<p>Coco &eacute;tait un hamster dor&eacute; avec une fourrure douce et des yeux &eacute;tincelants. Depuis que je l&#39;avais accueilli chez moi, il avait apport&eacute; une dose de joie et d&#39;animation &agrave; mon quotidien. Avec ses petites pattes agiles et son museau d&eacute;licat, Coco &eacute;tait tout simplement irr&eacute;sistible.</p>\r\n\r\n<p>Il &eacute;tait extr&ecirc;mement actif et aimait explorer son environnement. Dans sa cage, il grimpait avec agilit&eacute; sur les barreaux et se faufilait dans les tunnels color&eacute;s. J&#39;adorais observer ses acrobaties et ses cabrioles pleines de vitalit&eacute;.</p>\r\n\r\n<p>Coco &eacute;tait &eacute;galement un gourmet. Il se d&eacute;lectait de graines, de fruits frais et de l&eacute;gumes croquants. J&#39;aimais lui pr&eacute;parer des collations sp&eacute;ciales et le voir d&eacute;guster avec enthousiasme. Nous avions d&eacute;velopp&eacute; une complicit&eacute; &agrave; travers nos moments de partage et de gourmandise.</p>', '<p>Bien que Coco f&ucirc;t un animal solitaire, il appr&eacute;ciait les moments de jeu et d&#39;interaction. Je lui avais am&eacute;nag&eacute; un espace de jeu s&eacute;curis&eacute; o&ugrave; nous pouvions interagir ensemble. Quand je tendais ma main pour lui offrir une friandise, il s&#39;approchait avec confiance et d&eacute;licatesse.</p>', '<p>Coco d&eacute;testait &ecirc;tre d&eacute;rang&eacute; pendant ses p&eacute;riodes de repos. Il &eacute;tait tr&egrave;s territorial et n&#39;appr&eacute;ciait pas que son espace personnel soit envahi. Il pouvait se montrer agit&eacute; ou agressif si quelqu&#39;un essayait de le manipuler ou de le prendre contre sa volont&eacute;. De plus, Coco n&#39;aimait pas les bruits forts ou soudains, qui pouvaient le rendre nerveux et l&#39;amener &agrave; se cacher. Il pr&eacute;f&eacute;rait la tranquillit&eacute; et le calme pour se sentir en s&eacute;curit&eacute; et d&eacute;tendu dans son environnement.</p>', '<p>J&#39;avais rencontr&eacute; Coco un jour dans une animalerie. Alors que je me promenais parmi les cages remplies de petits animaux, mon regard avait &eacute;t&eacute; attir&eacute; par un hamster dor&eacute; plein de vie. Ses yeux &eacute;tincelants et son allure espi&egrave;gle m&#39;avaient imm&eacute;diatement captiv&eacute;.</p>\r\n\r\n<p>Je m&#39;&eacute;tais approch&eacute; de sa cage et j&#39;avais tendu ma main pour lui offrir une friandise. &Agrave; ma grande surprise, Coco s&#39;&eacute;tait approch&eacute; avec m&eacute;fiance, mais curiosit&eacute;. C&#39;&eacute;tait comme si nous nous &eacute;tions instantan&eacute;ment li&eacute;s l&#39;un &agrave; l&#39;autre.</p>\r\n\r\n<p>J&#39;avais pass&eacute; du temps &agrave; l&#39;observer, &agrave; le voir courir dans sa roue et &agrave; explorer son environnement avec une &eacute;nergie d&eacute;bordante. Je m&#39;&eacute;tais senti instantan&eacute;ment attir&eacute; par sa personnalit&eacute; vive et intr&eacute;pide.</p>\r\n\r\n<p>Finalement, j&#39;avais d&eacute;cid&eacute; de l&#39;adopter et de l&#39;accueillir chez moi. Depuis ce jour, Coco &eacute;tait devenu un membre pr&eacute;cieux de ma famille. Nous avions partag&eacute; de nombreux moments de complicit&eacute; et de bonheur, cr&eacute;ant un lien sp&eacute;cial qui ne cessait de grandir.</p>', '2023-06-14 06:46:49'),
(84, 1, 1, 'Rex', 'Male', NULL, '2023-05-18 00:00:00', NULL, 'labrador-gc3df7c011-640-648964310730c.jpg', '<p>Rex &eacute;tait un adorable chien de race Labrador Retriever, au pelage luisant et au regard p&eacute;tillant. D&egrave;s que je l&#39;avais accueilli dans ma vie, il &eacute;tait devenu une source constante de bonheur et d&#39;amour inconditionnel. Son &eacute;nergie d&eacute;bordante et sa personnalit&eacute; joviale faisaient fondre mon c&oelig;ur &agrave; chaque instant.</p>\r\n\r\n<p>En plus d&#39;&ecirc;tre un excellent compagnon de jeu, Rex &eacute;tait &eacute;galement un chien extr&ecirc;mement loyal. Il &eacute;tait toujours &agrave; mes c&ocirc;t&eacute;s, pr&ecirc;t &agrave; me r&eacute;conforter dans les moments difficiles et &agrave; partager des moments de complicit&eacute;. Sa pr&eacute;sence r&eacute;confortante m&#39;apaisait et me remplissait de bonheur.</p>\r\n\r\n<p>Rex &eacute;tait aussi un gourmet. Il &eacute;tait ravi chaque fois que je lui pr&eacute;parais un d&eacute;licieux repas &eacute;quilibr&eacute;. Sa queue battait fr&eacute;n&eacute;tiquement de joie &agrave; la simple vue de sa gamelle remplie de nourriture savoureuse.</p>\r\n\r\n<p>En somme, Rex &eacute;tait bien plus qu&#39;un animal de compagnie pour moi. Il &eacute;tait devenu un membre pr&eacute;cieux de ma famille, un ami fid&egrave;le qui m&#39;accompagnait dans les hauts et les bas de la vie. Sa pr&eacute;sence aimante et son d&eacute;vouement sans faille faisaient de lui le chien parfait pour moi.</p>', '<p>Rex &eacute;tait un compagnon joueur et attentif. Il adorait jouer &agrave; la balle, courir dans le parc et s&#39;amuser avec ses jouets pr&eacute;f&eacute;r&eacute;s. Son enthousiasme &eacute;tait contagieux, et il ne manquait jamais une occasion de me faire rire avec ses pitreries.</p>', '<p>Rex d&eacute;testait les bruits forts et soudains. Chaque fois qu&#39;il entendait un son fort, il se mettait &agrave; trembler et cherchait &agrave; se cacher pour se sentir en s&eacute;curit&eacute;. Les p&eacute;tards, les orages et m&ecirc;me les aspirateurs &eacute;taient source de stress pour lui. J&#39;essayais toujours de cr&eacute;er un environnement calme et apaisant pour att&eacute;nuer ses peurs et le rassurer.</p>\r\n\r\n<p>De plus, Rex d&eacute;testait &ecirc;tre seul pendant de longues p&eacute;riodes. Il &eacute;tait tr&egrave;s attach&eacute; &agrave; moi et ressentait de l&#39;anxi&eacute;t&eacute; lorsqu&#39;il &eacute;tait s&eacute;par&eacute; de moi pendant trop longtemps. Il exprimait son m&eacute;contentement en g&eacute;missant ou en grattant &agrave; la porte. J&#39;ai donc veill&eacute; &agrave; lui accorder suffisamment d&#39;attention et &agrave; lui offrir des moments de jeu et de c&acirc;lins r&eacute;guliers pour combattre sa solitude.</p>\r\n\r\n<p>Enfin, Rex n&#39;appr&eacute;ciait pas les visites chez le v&eacute;t&eacute;rinaire. Il se mettait sur la d&eacute;fensive d&egrave;s qu&#39;il &eacute;tait dans la salle d&#39;attente et manifestait son m&eacute;contentement en grognant ou en se retirant dans un coin. C&#39;&eacute;tait un d&eacute;fi pour moi de le calmer et de le rassurer pendant ces visites, mais je veillais &agrave; lui apporter un soutien constant et &agrave; le r&eacute;compenser avec des friandises pour l&#39;aider &agrave; surmonter son appr&eacute;hension.</p>', '<p>J&#39;avais rencontr&eacute; Rex un jour en me promenant au parc. Alors que je fl&acirc;nais pr&egrave;s du lac, j&#39;avais aper&ccedil;u un chien solitaire assis sous un arbre. Son regard triste et sa d&eacute;marche h&eacute;sitante avaient attir&eacute; mon attention imm&eacute;diatement.</p>\r\n\r\n<p>Je m&#39;&eacute;tais approch&eacute; doucement de lui, et malgr&eacute; sa m&eacute;fiance initiale, il avait permis que je m&#39;approche. J&#39;avais pu voir la tristesse dans ses yeux, mais aussi une lueur d&#39;espoir. J&#39;avais su qu&#39;il avait besoin d&#39;un foyer aimant, et mon c&oelig;ur avait &eacute;t&eacute; touch&eacute; par sa vuln&eacute;rabilit&eacute;.</p>\r\n\r\n<p>Sans h&eacute;siter, j&#39;avais d&eacute;cid&eacute; de l&#39;accueillir chez moi. Nous avions travers&eacute; ensemble des moments d&#39;adaptation et de confiance. Peu &agrave; peu, sa tristesse s&#39;&eacute;tait dissip&eacute;e, remplac&eacute;e par une affection profonde et une gratitude mutuelle.</p>\r\n\r\n<p>Notre lien s&#39;&eacute;tait renforc&eacute; jour apr&egrave;s jour. Rex &eacute;tait devenu mon compagnon loyal, toujours pr&ecirc;t &agrave; partager nos aventures et &agrave; m&#39;offrir un amour inconditionnel. Je me sentais privil&eacute;gi&eacute; d&#39;avoir pu lui offrir une seconde chance et de l&#39;avoir trouv&eacute; parmi tant d&#39;autres.</p>\r\n\r\n<p>La rencontre avec Rex avait chang&eacute; ma vie. Il avait combl&eacute; un vide dans mon c&oelig;ur et m&#39;avait enseign&eacute; le v&eacute;ritable sens de l&#39;amour inconditionnel. Nous &eacute;tions destin&eacute;s &agrave; nous rencontrer, et je savais que notre amiti&eacute; serait &eacute;ternelle.</p>', '2023-06-14 06:54:40'),
(85, 1, 1, 'Daisy', 'Femelle', NULL, '2023-06-05 00:00:00', NULL, 'german-shepherd-g013104a98-640-6489662e390bd.jpg', '<p>Daisy &eacute;tait une chienne femelle de race Berger Allemand avec une &eacute;l&eacute;gance naturelle et un pelage lustr&eacute;. D&egrave;s que je l&#39;avais vue pour la premi&egrave;re fois, son regard doux et sa d&eacute;marche gracieuse m&#39;avaient imm&eacute;diatement charm&eacute;.</p>\r\n\r\n<p>Luna &eacute;tait une compagne affectueuse et protectrice. Elle &eacute;tait toujours l&agrave; pour moi, pr&ecirc;te &agrave; me r&eacute;conforter dans les moments de tristesse et &agrave; c&eacute;l&eacute;brer avec joie les moments de bonheur. Son amour inconditionnel et sa fid&eacute;lit&eacute; sans faille faisaient d&#39;elle une compagne extraordinaire.</p>\r\n\r\n<p>Daisy &eacute;tait &eacute;galement une chienne intelligente et ob&eacute;issante. Elle apprenait rapidement de nouveaux tours et &eacute;tait toujours pr&ecirc;te &agrave; satisfaire mes attentes. Sa capacit&eacute; d&#39;apprentissage et sa volont&eacute; de plaire rendaient notre relation encore plus forte.</p>\r\n\r\n<p>En somme, Daisy &eacute;tait bien plus qu&#39;une simple chienne. Elle &eacute;tait une amie fid&egrave;le, une compagne aimante et une source constante de bonheur dans ma vie.</p>', '<p>Daisy adorait les longues balades dans la nature. Chaque fois que je mettais sa laisse et prenais les cl&eacute;s pour sortir, elle se mettait &agrave; sauter de joie et &agrave; remuer la queue avec excitation. Nous explorions ensemble les sentiers bois&eacute;s, elle courant joyeusement &agrave; mes c&ocirc;t&eacute;s, le museau lev&eacute; pour sentir les diff&eacute;rentes odeurs de la nature.</p>\r\n\r\n<p>Elle aimait aussi jouer avec ses jouets pr&eacute;f&eacute;r&eacute;s. Que ce soit une balle rebondissante, une corde &agrave; tirer ou un jouet qui couine, Daisy s&#39;amusait sans rel&acirc;che. Elle &eacute;tait toujours partante pour une s&eacute;ance de jeu, pr&ecirc;te &agrave; attraper, courir et s&#39;amuser jusqu&#39;&agrave; ce que nous soyons tous les deux &eacute;puis&eacute;s.</p>\r\n\r\n<p>Daisy &eacute;tait &eacute;galement une gourmande. Elle attendait avec impatience les repas et adorait d&eacute;vorer sa nourriture avec enthousiasme. Chaque fois que je pr&eacute;parais sa gamelle, elle tournait autour de moi en remuant la queue, exprimant sa gratitude pour le festin qui l&#39;attendait.</p>\r\n\r\n<p>Enfin, Daisy aimait les moments de d&eacute;tente et de c&acirc;lins. Elle appr&eacute;ciait les moments de calme o&ugrave; nous nous allongions sur le canap&eacute; ensemble, moi la caressant doucement pendant qu&#39;elle ronronnait de contenteme</p>', '<p>Daisy d&eacute;testait les bains. D&egrave;s qu&#39;elle entendait le bruit de l&#39;eau qui coule dans la baignoire, elle se mettait &agrave; se cacher et &agrave; &eacute;viter tout contact avec l&#39;eau. Elle n&#39;appr&eacute;ciait pas du tout le processus de toilettage et pr&eacute;f&eacute;rait rester au sec autant que possible. C&#39;&eacute;tait toujours une petite bataille pour la convaincre de prendre un bain, mais avec patience et douceur, nous y arrivions.</p>\r\n\r\n<p>Enfin, Daisy avait une aversion pour les &eacute;trangers. Elle &eacute;tait tr&egrave;s protectrice envers sa famille et montrait souvent de la m&eacute;fiance envers les personnes qu&#39;elle ne connaissait pas. Elle pouvait aboyer et se montrer r&eacute;serv&eacute;e en leur pr&eacute;sence, mais une fois qu&#39;elle apprenait &agrave; les conna&icirc;tre, elle se d&eacute;tendait et se montrait amicale.</p>', '<p>J&#39;avais rencontr&eacute; Daisy &agrave; la SPA un apr&egrave;s-midi ensoleill&eacute;. Je m&#39;&eacute;tais rendu l&agrave;-bas avec l&#39;intention de trouver un compagnon &agrave; quatre pattes. Alors que je parcourais les rang&eacute;es de boxes, mon regard avait &eacute;t&eacute; attir&eacute; par une petite chienne au regard doux qui semblait perdue parmi les autres chiens.</p>\r\n\r\n<p>Je m&#39;&eacute;tais approch&eacute; lentement d&#39;elle, et &agrave; mesure que je m&#39;approchais, elle avait relev&eacute; les oreilles et avait inclin&eacute; la t&ecirc;te d&#39;un air curieux. Je m&#39;&eacute;tais agenouill&eacute; &agrave; c&ocirc;t&eacute; d&#39;elle et avais tendu la main, incertain de sa r&eacute;action. Mais &agrave; ma grande surprise, elle s&#39;&eacute;tait approch&eacute;e, posant sa t&ecirc;te sur ma main avec une expression de confiance.</p>\r\n\r\n<p>C&#39;&eacute;tait le coup de foudre instantan&eacute;. Je savais que Daisy &eacute;tait le chien que je cherchais. Son pelage doux et soyeux, ses yeux expressifs et son attitude aimante m&#39;avaient convaincu qu&#39;elle &eacute;tait faite pour moi.</p>\r\n\r\n<p>Daisy &eacute;tait un chien avec de nombreux plaisirs simples dans la vie. Sa joie de vivre et son enthousiasme contagieux rendaient chaque journ&eacute;e sp&eacute;ciale. J&#39;&eacute;tais reconnaissant d&#39;avoir pu partager tous ces moments d&#39;amour et de bonheur avec elle.</p>', '2023-06-14 07:03:10'),
(86, 3, 1, 'Fleur', 'Femelle', '2019-05-15 00:00:00', '2023-03-08 00:00:00', NULL, 'rabbit-gef50c21e1-640-648967e3b686e.jpg', '<p>Fleur &eacute;tait un lapin femelle avec une fourrure douce et soyeuse. D&egrave;s que je l&#39;avais vue pour la premi&egrave;re fois, ses yeux p&eacute;tillants et sa petite frimousse mignonne m&#39;avaient imm&eacute;diatement charm&eacute;.</p>\r\n\r\n<p>Fleur &eacute;tait une compagne curieuse et d&eacute;bordante d&#39;&eacute;nergie. Elle adorait explorer chaque recoin de son habitat, sautant et grignotant tout sur son passage. Sa vivacit&eacute; et son esprit joueur en faisaient une compagne amusante et divertissante.</p>\r\n\r\n<p>Son nom, Fleur, lui allait &agrave; merveille. Comme une d&eacute;licate fleur &eacute;panouie, elle apportait une touche de beaut&eacute; et de fra&icirc;cheur dans ma vie. Chaque jour pass&eacute; avec Fleur &eacute;tait un v&eacute;ritable &eacute;merveillement, rempli de moments de complicit&eacute; et de douceur.<img alt=\"angel\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/angel_smile.png\" title=\"angel\" width=\"23\" /><img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '<p>Fleur adorait grignoter des l&eacute;gumes frais. Chaque fois que je lui apportais une assiette de carottes croquantes ou de feuilles de laitue fra&icirc;che, elle devenait toute excit&eacute;e, agitant ses petites pattes avec impatience. Elle se d&eacute;lectait de ces friandises v&eacute;g&eacute;tales, les croquant avec enthousiasme et faisant entendre de petits bruits de satisfaction.</p>\r\n\r\n<p>Elle aimait &eacute;galement les moments de jeu interactif. Qu&#39;il s&#39;agisse de poursuivre une balle rebondissante ou de jouer &agrave; cache-cache, Fleur &eacute;tait toujours partante. Sa petite queue remuait joyeusement et elle bondissait avec agilit&eacute;, manifestant ainsi son plaisir et sa joie de jouer.</p>', '<p>Elle d&eacute;testait &eacute;galement &ecirc;tre manipul&eacute;e brusquement. Fleur &eacute;tait un lapin d&eacute;licat et sensible, et elle n&#39;appr&eacute;ciait pas les gestes brusques ou les manipulations trop &eacute;nergiques. Elle pr&eacute;f&eacute;rait &ecirc;tre approch&eacute;e avec douceur et respect, et r&eacute;agissait de mani&egrave;re positive aux caresses d&eacute;licates.</p>\r\n\r\n<p>Fleur avait &eacute;galement une aversion pour les temp&eacute;ratures extr&ecirc;mes. Elle n&#39;aimait ni le froid intense ni la chaleur excessive. Lorsque les temp&eacute;ratures &eacute;taient trop &eacute;lev&eacute;es ou trop basses, elle montrait des signes de malaise et cherchait des moyens de se rafra&icirc;chir ou de se r&eacute;chauffer.</p>\r\n\r\n<p>Enfin, Fleur n&#39;appr&eacute;ciait pas les confrontations avec d&#39;autres animaux. Elle &eacute;tait une lapine plut&ocirc;t timide et pacifique, et les interactions agressives ou intimidantes la mettaient mal &agrave; l&#39;aise. Elle pr&eacute;f&eacute;rait les environnements calmes et harmonieux o&ugrave; elle pouvait se sentir en s&eacute;curit&eacute;.</p>', '<p>J&#39;ai rencontr&eacute; Fleur lors d&#39;une visite &agrave; un refuge pour animaux. Je m&#39;&eacute;tais rendu l&agrave;-bas dans l&#39;espoir de trouver un compagnon &agrave; poils doux. Alors que je d&eacute;ambulais parmi les cages remplies de diff&eacute;rents animaux, mon regard s&#39;est pos&eacute; sur une petite lapine solitaire.</p>\r\n\r\n<p>Fleur &eacute;tait assise tranquillement dans un coin de sa cage, ses yeux brillants fix&eacute;s sur moi. J&#39;ai senti une connexion instantan&eacute;e. Je me suis approch&eacute; doucement, cherchant &agrave; &eacute;tablir un contact avec elle. Elle m&#39;a observ&eacute; avec curiosit&eacute;, et au fur et &agrave; mesure que je m&#39;approchais, elle s&#39;est mise &agrave; remuer son nez, semblant me saluer d&#39;une mani&egrave;re toute lapine.</p>\r\n\r\n<p>Je me suis agenouill&eacute; &agrave; c&ocirc;t&eacute; de sa cage, lui parlant doucement et tendant ma main pour la laisser renifler. &Agrave; ma grande joie, elle s&#39;est approch&eacute;e timidement et a commenc&eacute; &agrave; me renifler avec douceur. C&#39;&eacute;tait comme si elle avait compris que nous &eacute;tions destin&eacute;s l&#39;un &agrave; l&#39;autre.</p>\r\n\r\n<p>Apr&egrave;s avoir discut&eacute; avec les responsables du refuge et accompli les formalit&eacute;s n&eacute;cessaires, j&#39;ai enfin pu ramener Fleur chez moi. Ce jour-l&agrave;, une nouvelle aventure a commenc&eacute; pour nous.</p>\r\n\r\n<p>Fleur s&#39;est rapidement adapt&eacute;e &agrave; sa nouvelle maison. Elle a explor&eacute; chaque recoin, d&eacute;couvrant de nouvelles cachettes et marquant son territoire avec curiosit&eacute;. Au fil des jours, notre relation s&#39;est renforc&eacute;e. J&#39;ai appris &agrave; comprendre ses besoins et &agrave; r&eacute;pondre &agrave; ses attentes, et elle a combl&eacute; ma vie de joie et de douceur.</p>\r\n\r\n<p>Nous avons partag&eacute; de merveilleux moments ensemble. Fleur aimait se blottir contre moi pendant les soir&eacute;es calmes, tandis que je la caressais doucement derri&egrave;re les oreilles. Nous avons &eacute;galement jou&eacute; ensemble, utilisant des jouets et des tunnels sp&eacute;cialement con&ccedil;us pour elle. Chaque jour pass&eacute; avec Fleur &eacute;tait un cadeau, une source constante de bonheur et d&#39;amour.</p>\r\n\r\n<p>Je suis reconnaissant d&#39;avoir eu la chance de rencontrer Fleur ce jour-l&agrave;. Elle a apport&eacute; une telle lumi&egrave;re dans ma vie et a fait de chaque journ&eacute;e une aventure remplie de douceur. Notre histoire d&#39;amour et de complicit&eacute; restera grav&eacute;e dans mon c&oelig;ur pour toujours.&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-14 07:10:27'),
(87, 2, 1, 'Simba', 'Male', NULL, '2023-06-03 00:00:00', NULL, 'animal-g5d7da26aa-640-648968ebc4f33.jpg', '<p>Simba &eacute;tait un chat m&acirc;le au pelage roux &eacute;clatant et aux yeux verts per&ccedil;ants. D&egrave;s que je l&#39;ai vu pour la premi&egrave;re fois, j&#39;ai &eacute;t&eacute; captiv&eacute; par sa prestance et son air majestueux.</p>\r\n\r\n<p>Simba &eacute;tait un compagnon plein de gr&acirc;ce et d&#39;&eacute;l&eacute;gance. Il se d&eacute;pla&ccedil;ait avec une d&eacute;marche royale, faisant montre d&#39;une confiance inn&eacute;e. Son regard per&ccedil;ant r&eacute;v&eacute;lait une intelligence et une curiosit&eacute; sans limites.</p>\r\n\r\n<p>Son nom, Simba, lui allait &agrave; merveille. Comme le roi des animaux dans la savane, il avait cette aura de leadership et de noblesse. Chaque fois qu&#39;il entrait dans une pi&egrave;ce, il attirait tous les regards avec son charme magn&eacute;tique.</p>\r\n\r\n<p>En ma pr&eacute;sence, Simba se montrait affectueux et c&acirc;lin. Il aimait se blottir contre moi, ronronnant doucement et se frottant contre mes jambes pour me t&eacute;moigner son affection. Ces moments de tendresse partag&eacute;e &eacute;taient pr&eacute;cieux et renfor&ccedil;aient notre lien sp&eacute;cial.</p>', '<p>Simba aimait les moments de jeu et d&#39;exploration. Il adorait chasser les plumes suspendues &agrave; une canne &agrave; p&ecirc;che, bondissant avec agilit&eacute; et lan&ccedil;ant des miaulements de satisfaction. Ses mouvements gracieux et sa dext&eacute;rit&eacute; &eacute;taient impressionnants &agrave; observer.</p>', '<p>Simba d&eacute;testait les bruits forts et soudains. Chaque fois qu&#39;il entendait un bruit tonitruant, comme un coup de tonnerre ou un p&eacute;tard, il se cachait rapidement sous le lit ou dans un endroit isol&eacute;. Il &eacute;tait sensible aux bruits intenses, ce qui le rendait nerveux et anxieux.</p>\r\n\r\n<p>Il d&eacute;testait &eacute;galement les contraintes et les restrictions. Simba &eacute;tait un esprit libre et ind&eacute;pendant, et toute tentative de le maintenir dans un espace confin&eacute; ou de le contr&ocirc;ler provoquait son m&eacute;contentement. Il pr&eacute;f&eacute;rait avoir la libert&eacute; de se d&eacute;placer et d&#39;explorer &agrave; sa guise, sans se sentir restreint.</p>\r\n\r\n<p>Simba avait une aversion pour les situations stressantes. Les changements brusques dans son environnement ou les moments de tension pouvaient le perturber et l&#39;irriter. Il pr&eacute;f&eacute;rait la tranquillit&eacute; et l&#39;harmonie, et &eacute;vitait les situations conflictuelles autant que possible.</p>', '<p>J&#39;ai rencontr&eacute; Simba lors d&#39;une journ&eacute;e ensoleill&eacute;e o&ugrave; je me suis rendu &agrave; une exposition f&eacute;line locale. Alors que je parcourais les diff&eacute;rentes cages, un chat roux majestueux a attir&eacute; mon regard.</p>\r\n\r\n<p>Simba &eacute;tait l&agrave;, debout avec une fiert&eacute; incontestable, observant l&#39;assistance d&#39;un air confiant. Ses yeux verts p&eacute;tillants semblaient me fixer directement. Je me suis imm&eacute;diatement approch&eacute; de sa cage, attir&eacute; par sa beaut&eacute; et son charme ind&eacute;niable.</p>\r\n\r\n<p>Lorsque j&#39;ai tendu ma main vers lui, il s&#39;est approch&eacute; avec gr&acirc;ce, frottant sa t&ecirc;te contre mes doigts. Son pelage &eacute;tait doux et soyeux, et j&#39;ai senti un frisson d&#39;excitation parcourir mon corps. C&#39;&eacute;tait comme si nous &eacute;tions instantan&eacute;ment connect&eacute;s.</p>\r\n\r\n<p>Je suis rest&eacute; un moment &agrave; discuter avec le propri&eacute;taire de Simba, apprenant davantage sur son caract&egrave;re unique. Il m&#39;a confi&eacute; que Simba &eacute;tait un chat ind&eacute;pendant et confiant, mais aussi tr&egrave;s affectueux lorsqu&#39;il se sentait en confiance.</p>\r\n\r\n<p>Mon c&oelig;ur &eacute;tait conquis. Je savais que Simba &eacute;tait le compagnon f&eacute;lin id&eacute;al pour moi. J&#39;ai accompli toutes les d&eacute;marches n&eacute;cessaires et, apr&egrave;s quelques jours d&#39;attente, j&#39;ai enfin pu ramener Simba &agrave; la maison.</p>\r\n\r\n<p>Les premiers jours ont &eacute;t&eacute; une p&eacute;riode d&#39;adaptation pour nous deux. Simba explorait sa nouvelle demeure avec curiosit&eacute;, d&eacute;couvrant chaque recoin et s&#39;appropriant rapidement son territoire. Je me suis engag&eacute; &agrave; lui offrir un environnement s&eacute;curisant et stimulant, rempli d&#39;amour et de tendresse.</p>\r\n\r\n<p>Au fil du temps, notre lien s&#39;est renforc&eacute;. Simba est devenu un membre pr&eacute;cieux de ma famille, m&#39;apportant joie et r&eacute;confort au quotidien. Nous avons partag&eacute; d&#39;innombrables moments de jeux, de c&acirc;lins et de complicit&eacute;. Sa pr&eacute;sence apaisante a illumin&eacute; ma vie et a combl&eacute; mon c&oelig;ur d&#39;amour f&eacute;lin.</p>\r\n\r\n<p>Rencontrer Simba a &eacute;t&eacute; un tournant dans ma vie. Il m&#39;a enseign&eacute; l&#39;importance de la confiance, de la libert&eacute; et de l&#39;amour inconditionnel. Je suis reconnaissant d&#39;avoir eu la chance de partager ma vie avec un &ecirc;tre aussi extraordinaire que Simba, et notre histoire restera &agrave; jamais grav&eacute;e dans ma m&eacute;moire.</p>', '2023-06-14 07:14:51'),
(88, 2, 1, 'Azazel', 'Male', NULL, '2022-06-23 00:00:00', NULL, 'cat-g645401f9c-640-64896a1b3af5b.jpg', '<p>Azazel &eacute;tait un chat m&acirc;le au pelage noir d&#39;encre, ses yeux ambr&eacute;s &eacute;tincelants comme des joyaux. D&egrave;s que je l&#39;ai aper&ccedil;u pour la premi&egrave;re fois, j&#39;ai &eacute;t&eacute; imm&eacute;diatement attir&eacute; par sa beaut&eacute; myst&eacute;rieuse et son aura envo&ucirc;tante.</p>\r\n\r\n<p>Azazel &eacute;tait un chat ind&eacute;pendant et libre. Il aimait explorer les environs, se faufilant avec agilit&eacute; et &eacute;l&eacute;gance &agrave; travers les recoins les plus inaccessibles. Sa nature aventuri&egrave;re lui donnait un air intr&eacute;pide et courageux.</p>\r\n\r\n<p>Malgr&eacute; sa r&eacute;serve initiale, Azazel &eacute;tait aussi incroyablement affectueux. Il savait donner des c&acirc;lins avec d&eacute;licatesse et ses ronronnements profonds &eacute;taient une douce m&eacute;lodie apaisante. Les moments de tendresse partag&eacute;s avec lui &eacute;taient empreints de magie et de connexion profonde.</p>\r\n\r\n<p>Notre complicit&eacute; grandissait de jour en jour, et chaque instant pass&eacute; avec Azazel &eacute;tait une aventure captivante. Son nom rare refl&eacute;tait parfaitement sa nature unique et sa personnalit&eacute; envo&ucirc;tante. J&#39;&eacute;tais privil&eacute;gi&eacute; d&#39;avoir partag&eacute; ma vie avec lui, et notre lien ind&eacute;fectible restera grav&eacute; dans mon c&oelig;ur pour toujours.</p>', '<p>Azazel avait &eacute;galement une intelligence vive et une curiosit&eacute; insatiable. Il aimait r&eacute;soudre des &eacute;nigmes et jouer &agrave; des jeux interactifs, montrant une astuce et une ing&eacute;niosit&eacute; qui m&#39;&eacute;merveillaient.</p>', '<p>Azazel avait une certaine m&eacute;fiance envers les &eacute;trangers. Il &eacute;tait r&eacute;serv&eacute; et prenait du temps pour accorder sa confiance. Les interactions forc&eacute;es ou brusques avec des inconnus pouvaient le mettre mal &agrave; l&#39;aise, et il pr&eacute;f&eacute;rait &eacute;tablir des liens &eacute;troits avec les personnes qu&#39;il connaissait et en qui il avait confiance.</p>', '<p>J&#39;ai rencontr&eacute; Azazel d&#39;une mani&egrave;re inattendue lors d&#39;une promenade dans le parc. Alors que je fl&acirc;nais entre les arbres, j&#39;ai aper&ccedil;u un chat noir myst&eacute;rieux qui se faufilait parmi les buissons.</p>\r\n\r\n<p>Azazel &eacute;tait l&agrave;, majestueux et ind&eacute;pendant, avec son pelage lustr&eacute; scintillant &agrave; la lueur du soleil couchant. Ses yeux ambr&eacute;s me fixaient avec une intensit&eacute; captivante. Intrigu&eacute; par sa pr&eacute;sence envo&ucirc;tante, j&#39;ai d&eacute;cid&eacute; de m&#39;approcher doucement.</p>\r\n\r\n<p>&Agrave; ma grande surprise, Azazel ne s&#39;est pas enfui. Au contraire, il s&#39;est avanc&eacute; avec une assurance tranquille, me permettant de le caresser d&eacute;licatement. J&#39;ai senti une connexion instantan&eacute;e avec lui, comme si nos &acirc;mes s&#39;&eacute;taient reconnues.</p>\r\n\r\n<p>Nous avons pass&eacute; des heures &agrave; nous d&eacute;couvrir mutuellement ce jour-l&agrave;, &agrave; partager des moments d&#39;intimit&eacute; et de complicit&eacute;. J&#39;ai appris qu&#39;Azazel &eacute;tait un chat abadonn&eacute;, ind&eacute;pendant, mais qu&#39;il &eacute;tait &eacute;galement en qu&ecirc;te d&#39;affection et de s&eacute;curit&eacute;.</p>\r\n\r\n<p>Au fil du temps, notre relation s&#39;est approfondie. Azazel est venu &agrave; moi chaque fois que j&#39;&eacute;tais de retour au parc, et nous avons construit un lien solide et sp&eacute;cial. Sa pr&eacute;sence m&#39;apportait un sentiment de paix et de r&eacute;confort.</p>\r\n\r\n<p>Chaque aventure avec Azazel &eacute;tait une exploration de notre amiti&eacute; grandissante. Nous avons partag&eacute; des moments de jeu, des siestes paresseuses &agrave; l&#39;ombre des arbres, et des conversations silencieuses remplies de compr&eacute;hension mutuelle.</p>', '2023-06-14 07:19:55'),
(89, 3, 1, 'Avalanche', 'Male', NULL, '2023-06-09 00:00:00', NULL, 'horse-ge435f116e-640-64896d051f7f6.jpg', '<p>Avalanche &eacute;tait un majestueux &eacute;talon. D&egrave;s que je l&#39;ai aper&ccedil;u pour la premi&egrave;re fois, j&#39;ai &eacute;t&eacute; imm&eacute;diatement captiv&eacute; par sa beaut&eacute; sauvage et sa pr&eacute;sence imposante.</p>\r\n\r\n<p>Son nom rare, Avalanche, lui allait &agrave; merveille. Il &eacute;voquait la puissance brute de la nature et la force d&eacute;vastatrice d&#39;une avalanche qui emporte tout sur son passage. Chaque fois que je montais sur son dos, je sentais cette &eacute;nergie puissante qui m&#39;enveloppait.</p>\r\n\r\n<p>Avalanche &eacute;tait un cheval noble et courageux, dot&eacute; d&#39;une intelligence remarquable. Sa gr&acirc;ce et sa confiance en lui &eacute;taient palpables &agrave; chaque mouvement qu&#39;il faisait. Il &eacute;tait mon partenaire de confiance, toujours pr&ecirc;t &agrave; m&#39;emmener vers de nouvelles aventures.</p>\r\n\r\n<p>Son temp&eacute;rament noble et sensible faisait de lui un compagnon d&eacute;vou&eacute;. Il savait quand j&#39;avais besoin de r&eacute;confort et de soutien, et sa pr&eacute;sence apaisante m&#39;inspirait confiance et tranquillit&eacute; d&#39;esprit. Avalanche &eacute;tait un ami fid&egrave;le sur lequel je pouvais toujours compter.</p>\r\n\r\n<p>Notre complicit&eacute; grandissait &agrave; chaque instant pass&eacute; ensemble. Que ce soit lors de longues chevauch&eacute;es &agrave; travers les paysages sauvages ou de s&eacute;ances d&#39;entra&icirc;nement rigoureuses, Avalanche &eacute;tait toujours pr&ecirc;t &agrave; relever les d&eacute;fis avec moi.</p>\r\n\r\n<p>&nbsp;</p>', '<p>Avalanche aimait aussi les d&eacute;fis intellectuels. Les exercices d&#39;obstacles ou de dressage stimulaient son esprit vif et lui permettaient de montrer sa ma&icirc;trise de mouvements complexes. J&#39;admirais sa capacit&eacute; &agrave; apprendre rapidement et &agrave; se surpasser &agrave; chaque s&eacute;ance d&#39;entra&icirc;nement.</p>\r\n\r\n<p>Enfin, Avalanche aimait la compagnie des autres chevaux. Les moments de jeu et d&#39;interaction avec ses cong&eacute;n&egrave;res lui apportaient une joie indescriptible. Il appr&eacute;ciait les moments de partage et d&#39;&eacute;change d&#39;&eacute;nergie avec ses semblables, renfor&ccedil;ant ainsi ses liens sociaux.</p>', '<p>Avalanche d&eacute;testait les espaces confin&eacute;s et les environnements &eacute;troits. Sa nature libre et sa pr&eacute;f&eacute;rence pour les vastes &eacute;tendues lui rendaient difficile de se sentir &agrave; l&#39;aise dans des espaces restreints tels que les boxes ou les enclos &eacute;troits. Il avait besoin de pouvoir se d&eacute;placer librement et de ressentir l&#39;amplitude de l&#39;espace qui l&#39;entourait.</p>', '<p>J&#39;ai rencontr&eacute; Avalanche lors d&#39;une journ&eacute;e ensoleill&eacute;e &agrave; la ferme &eacute;questre locale. Je me souviens encore de l&#39;odeur de la paille fra&icirc;che et du doux hennissement des chevaux qui flottait dans l&#39;air.</p>\r\n\r\n<p>Alors que je me promenais entre les &eacute;curies, mes yeux se sont pos&eacute;s sur un majestueux cheval blanc qui se tenait fi&egrave;rement dans son box. Ses yeux per&ccedil;ants semblaient me fixer, comme s&#39;il savait d&eacute;j&agrave; que notre destin &eacute;tait li&eacute;.</p>\r\n\r\n<p>Curieux et attir&eacute; par sa pr&eacute;sence imposante, j&#39;ai d&eacute;cid&eacute; de m&#39;approcher doucement. Avalanche m&#39;a accueilli avec une certaine m&eacute;fiance, mais je pouvais voir une lueur de curiosit&eacute; dans ses yeux. Je lui ai parl&eacute; doucement, lui offrant des caresses timides pour gagner sa confiance.</p>\r\n\r\n<p>Au fil du temps, j&#39;ai commenc&eacute; &agrave; passer de plus en plus de temps avec Avalanche. Nous avons partag&eacute; des moments de promenades paisibles &agrave; travers les sentiers forestiers, d&eacute;couvrant ensemble de nouveaux paysages et sentant le vent caresser nos visages.</p>\r\n\r\n<p>&Agrave; mesure que notre relation se renfor&ccedil;ait, j&#39;ai appris &agrave; conna&icirc;tre la personnalit&eacute; unique d&#39;Avalanche. Il &eacute;tait &agrave; la fois fier et doux, r&eacute;serv&eacute; mais plein d&#39;amour. Nous avons d&eacute;velopp&eacute; une connexion profonde, bas&eacute;e sur la confiance mutuelle et le respect.</p>\r\n\r\n<p>Nous avons partag&eacute; de nombreux moments m&eacute;morables ensemble. Les moments de galop effr&eacute;n&eacute; dans les champs verdoyants, la sensation de libert&eacute; totale qui nous envahissait &agrave; chaque foul&eacute;e. Les s&eacute;ances d&#39;entra&icirc;nement, o&ugrave; nous avons travaill&eacute; en harmonie pour surmonter les obstacles et relever de nouveaux d&eacute;fis.</p>\r\n\r\n<p>Avalanche restera &agrave; jamais grav&eacute; dans ma m&eacute;moire, un compagnon de voyage extraordinaire qui a apport&eacute; de la passion et de l&#39;excitation &agrave; ma vie. Ensemble, nous avons d&eacute;fi&eacute; les limites et explor&eacute; de nouveaux horizons, cr&eacute;ant des souvenirs pr&eacute;cieux qui continueront de briller dans mon c&oelig;ur.</p>', '2023-06-14 07:32:20');
INSERT INTO `animal_memorial` (`id`, `categorie_animal_id`, `auteur_id`, `nom`, `sexe`, `date_naissance`, `date_deces`, `lieu`, `photo`, `presentation`, `choses_aimees`, `choses_detestees`, `histoire`, `date_creation`) VALUES
(90, 3, 1, 'Eclipse', 'Femelle', NULL, '2023-04-17 00:00:00', NULL, 'water-turtle-g5ac443c1e-640-64896eb49d007.jpg', '<p>&Eacute;clipse &eacute;tait une tortue fascinante avec une carapace aux motifs complexes et une d&eacute;marche d&eacute;lib&eacute;r&eacute;e. D&egrave;s que je l&#39;ai vue pour la premi&egrave;re fois, je savais qu&#39;elle &eacute;tait sp&eacute;ciale. Son allure tranquille et sa sagesse apparente ont attir&eacute; mon attention imm&eacute;diatement.</p>\r\n\r\n<p>Elle avait un app&eacute;tit insatiable pour les d&eacute;licieux l&eacute;gumes et les fruits juteux. Je me rappelle lui offrir des feuilles de salade croquantes et des morceaux de fruits frais, ce qui la rendait incroyablement heureuse. Chaque repas &eacute;tait un moment de d&eacute;lice et d&#39;&eacute;change complice entre nous.</p>\r\n\r\n<p>&Eacute;clipse &eacute;tait une exploratrice n&eacute;e. M&ecirc;me si elle se d&eacute;pla&ccedil;ait lentement, elle &eacute;tait toujours curieuse de d&eacute;couvrir de nouveaux recoins de son environnement. Nous avons partag&eacute; de nombreux moments d&#39;exploration.</p>', '<p>&Eacute;clipse aimait passer de longues heures sous les rayons chauds du soleil, se pr&eacute;lassant sur son rocher favori. Elle semblait appr&eacute;cier les moments de calme et de contemplation, trouvant une paix int&eacute;rieure dans le silence de la nature.</p>', '<p>&Eacute;clipse d&eacute;testait les environnements bruyants et agit&eacute;s. Les bruits forts et soudains la faisaient se r&eacute;tracter dans sa carapace et perturbaient sa qui&eacute;tude. Elle pr&eacute;f&eacute;rait les endroits paisibles et calmes o&ugrave; elle pouvait se sentir en s&eacute;curit&eacute; et se reposer. Elle d&eacute;testait &eacute;galement &ecirc;tre d&eacute;rang&eacute;e pendant ses p&eacute;riodes de repos. Comme les tortues ont besoin de beaucoup de temps pour se reposer et r&eacute;cup&eacute;rer, elle appr&eacute;ciait les moments de tranquillit&eacute; o&ugrave; elle pouvait se retirer dans un coin paisible de son habitat.</p>', '<p>Je me souviens encore de ce jour o&ugrave; j&#39;ai rencontr&eacute; &Eacute;clipse pour la premi&egrave;re fois. C&#39;&eacute;tait lors d&#39;une visite &agrave; un refuge pour animaux, o&ugrave; j&#39;esp&eacute;rais trouver un compagnon de vie sp&eacute;cial. Alors que je parcourais les diff&eacute;rentes sections, mon regard s&#39;est pos&eacute; sur une magnifique tortue, sa carapace brillant sous les rayons du soleil. Intrigu&eacute; par sa pr&eacute;sence tranquille, je me suis approch&eacute; doucement d&#39;elle. &Eacute;clipse semblait immobile, mais ses yeux vifs t&eacute;moignaient d&#39;une profonde curiosit&eacute;. J&#39;ai imm&eacute;diatement ressenti une connexion avec elle, comme si nos &acirc;mes s&#39;&eacute;taient reconnues.</p>\r\n\r\n<p>Sans h&eacute;siter, j&#39;ai demand&eacute; au personnel du refuge si je pouvais passer du temps avec &Eacute;clipse. Ils ont gentiment accept&eacute; et m&#39;ont expliqu&eacute; qu&#39;elle avait &eacute;t&eacute; abandonn&eacute;e et qu&#39;elle cherchait une nouvelle maison aimante.</p>\r\n\r\n<p>Les premiers instants pass&eacute;s avec &Eacute;clipse &eacute;taient empreints de calme et de silence. Assis &agrave; ses c&ocirc;t&eacute;s, j&#39;ai ressenti une s&eacute;r&eacute;nit&eacute; &eacute;manant de cette cr&eacute;ature majestueuse. Je lui ai parl&eacute; doucement, lui offrant ma pr&eacute;sence apaisante.</p>\r\n\r\n<p>Au fil des jours et des semaines pass&eacute;s ensemble, notre relation s&#39;est renforc&eacute;e. J&#39;ai appris &agrave; conna&icirc;tre les petites habitudes d&#39;&Eacute;clipse, ses moments pr&eacute;f&eacute;r&eacute;s de bains de soleil, ses repas gourmands de l&eacute;gumes frais et ses moments de retrait dans sa cachette pr&eacute;f&eacute;r&eacute;e.</p>\r\n\r\n<p>Chaque jour, nous partagions des instants de calme et de contemplation. J&#39;observais avec admiration sa lenteur paisible et son regard sage. &Agrave; travers notre connexion silencieuse, nous nous comprenions mutuellement sans avoir besoin de mots.</p>\r\n\r\n<p>&Eacute;clipse est devenue un membre pr&eacute;cieux de ma famille. Nous avons explor&eacute; ensemble les recoins de mon jardin, d&eacute;couvrant de nouveaux endroits o&ugrave; elle pouvait se sentir en s&eacute;curit&eacute; et en harmonie avec la nature.</p>\r\n\r\n<p>Cette rencontre avec &Eacute;clipse m&#39;a enseign&eacute; la valeur de la patience, de la tranquillit&eacute; et de l&#39;appr&eacute;ciation des petits moments. Elle m&#39;a rappel&eacute; que la beaut&eacute; et la sagesse se trouvent souvent dans les choses les plus simples de la vie.&nbsp;</p>\r\n\r\n<p>Ma ch&egrave;re Eclipse, tu me manque chaque jour&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-14 07:39:32'),
(91, 1, 1, 'Astérion', 'Male', '2017-09-18 00:00:00', '2022-12-12 00:00:00', NULL, 'dog-g324f33563-640-64897050ef5a6.jpg', '<p>Ast&eacute;rion &eacute;tait un chien d&#39;une beaut&eacute; et d&#39;une &eacute;l&eacute;gance exceptionnelles. Sa robe &eacute;tait d&#39;un noir profond, ses yeux p&eacute;tillaient d&#39;intelligence et sa stature imposante lui conf&eacute;rait une allure noble. D&egrave;s que nos regards se sont crois&eacute;s, j&#39;ai su que notre destin &eacute;tait li&eacute;.</p>', '<p>Ast&eacute;rion aimait les longues promenades dans la nature, se perdre parmi les arbres et sentir le vent caresser sa fourrure. Il &eacute;tait &eacute;galement un chien tr&egrave;s protecteur, veillant sur moi avec une loyaut&eacute; sans faille.</p>', '<p>Ce qu&#39;Ast&eacute;rion d&eacute;testait par-dessus tout, c&#39;&eacute;taient les situations stressantes et les environnements bruyants. Il pr&eacute;f&eacute;rait la tranquillit&eacute; et la s&eacute;r&eacute;nit&eacute;, cherchant toujours des endroits calmes o&ugrave; il pouvait se d&eacute;tendre et se reposer.</p>', '<p>J&#39;ai rencontr&eacute; Ast&eacute;rion dans un petit refuge, o&ugrave; il attendait patiemment sa chance d&#39;&ecirc;tre adopt&eacute;. Alors que je m&#39;approchais de sa cage, il m&#39;a fix&eacute; avec un m&eacute;lange de m&eacute;fiance et de curiosit&eacute;. Je me suis approch&eacute; lentement, essayant de lui montrer que j&#39;&eacute;tais un ami potentiel. Apr&egrave;s quelques instants, Ast&eacute;rion a doucement approch&eacute; sa truffe de ma main, acceptant ma pr&eacute;sence. C&#39;est &agrave; ce moment pr&eacute;cis que j&#39;ai su qu&#39;il &eacute;tait le compagnon id&eacute;al pour moi.</p>\r\n\r\n<p>Ast&eacute;rion et moi avons partag&eacute; de nombreuses aventures ensemble. Nous avons parcouru des sentiers bois&eacute;s, jou&eacute; dans des parcs ensoleill&eacute;s et partag&eacute; des moments de complicit&eacute; &agrave; la maison. Son nom rare, Ast&eacute;rion, refl&eacute;tait parfaitement son caract&egrave;re unique et sa place sp&eacute;ciale dans ma vie.</p>\r\n\r\n<p>Malheureusement, le temps que j&#39;ai pass&eacute; avec Ast&eacute;rion a &eacute;t&eacute; trop court. Son d&eacute;part a laiss&eacute; un vide immense dans mon c&oelig;ur. Mais je sais qu&#39;il restera &agrave; jamais grav&eacute; dans ma m&eacute;moire et que son h&eacute;ritage de fid&eacute;lit&eacute; et de douceur continuera de m&#39;inspirer chaque jour.</p>\r\n\r\n<p>Ast&eacute;rion, mon cher compagnon, tu resteras &agrave; jamais dans mes pens&eacute;es. Ton nom rare &eacute;tait le reflet de ta personnalit&eacute; extraordinaire, et ta pr&eacute;sence a illumin&eacute; ma vie d&#39;une lumi&egrave;re sp&eacute;ciale. Je suis reconnaissant d&#39;avoir eu la chance de te conna&icirc;tre et de t&#39;avoir aim&eacute;.<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-14 07:45:17'),
(92, 1, 1, 'Magnus', 'Male', NULL, '2022-06-14 00:00:00', NULL, 'pug-g38c97c403-640-64897129350ef.jpg', '<p>Magnus &eacute;tait un carlin au pelage d&#39;un noir brillant et aux yeux p&eacute;tillants de malice. Son apparence exotique et son charme unique attiraient tous les regards. D&egrave;s que j&#39;ai crois&eacute; son regard espi&egrave;gle, j&#39;ai su que notre rencontre &eacute;tait le d&eacute;but d&#39;une amiti&eacute; inoubliable.</p>', '<p>Magnus &eacute;tait un chien joueur et plein d&#39;&eacute;nergie. Il adorait courir et sauter, provoquant des &eacute;clats de rire chez tous ceux qui le regardaient. Son intelligence et sa vivacit&eacute; d&#39;esprit en faisaient un compagnon id&eacute;al pour les jeux interactifs et les exercices d&#39;agilit&eacute;. Il &eacute;tait &eacute;galement tr&egrave;s attach&eacute; &agrave; sa famille. Il &eacute;tait un chien fid&egrave;le et protecteur, toujours pr&ecirc;t &agrave; d&eacute;fendre ceux qu&#39;il aimait. Sa pr&eacute;sence r&eacute;confortante et son affection sans limite &eacute;taient des tr&eacute;sors inestimables.</p>', '<p>Ce que Magnus d&eacute;testait par-dessus tout, c&#39;&eacute;tait l&#39;ennui. Il avait constamment besoin de stimulation et d&#39;activit&eacute;s pour canaliser son &eacute;nergie d&eacute;bordante. Les longues promenades et les s&eacute;ances de jeu &eacute;taient essentielles pour maintenir son &eacute;quilibre et sa joie de vivre.</p>', '<p>J&#39;ai rencontr&eacute; Magnus lors d&#39;une exposition canine, o&ugrave; il repr&eacute;sentait fi&egrave;rement sa race. Il se distinguait par son enthousiasme contagieux et sa personnalit&eacute; vive. J&#39;ai &eacute;t&eacute; imm&eacute;diatement captiv&eacute; par sa pr&eacute;sence, et lui par la mienne.</p>\r\n\r\n<p>Son d&eacute;part a laiss&eacute; un vide immense dans ma vie. Mais je garde pr&eacute;cieusement les souvenirs de nos moments de complicit&eacute; et de bonheur partag&eacute;.</p>\r\n\r\n<p>Magnus, mon cher compagnon, tu resteras &agrave; jamais grav&eacute; dans mon c&oelig;ur. Ton nom rare &eacute;tait le reflet de ta personnalit&eacute; unique et de ton charme in&eacute;galable. Je suis reconnaissant d&#39;avoir partag&eacute; ma vie avec toi et d&#39;avoir &eacute;t&eacute; t&eacute;moin de ton amour inconditionnel.</p>', '2023-06-14 07:49:37'),
(93, 1, 1, 'Zephyra', 'Femelle', NULL, '2022-11-10 00:00:00', NULL, 'chihuahua-g537e6b3e0-640-648971f7c61a6.jpg', '<p>Zephyra &eacute;tait une chihuahua au pelage doux et soyeux. Malgr&eacute; sa petite taille, elle d&eacute;gageait une confiance et une d&eacute;termination qui for&ccedil;aient l&#39;admiration.</p>', '<p>Zephyra &eacute;tait une chienne pleine d&#39;&eacute;nergie et de vivacit&eacute;. Elle adorait se d&eacute;placer avec agilit&eacute;, montrant ses talents lors de s&eacute;ances d&#39;ob&eacute;issance et de sauts. Sa petite taille ne l&#39;emp&ecirc;chait pas d&#39;avoir une personnalit&eacute; d&eacute;bordante et un esprit vif.</p>', '<p>Ce que Zephyra d&eacute;testait par-dessus tout, c&#39;&eacute;tait l&#39;injustice. Elle &eacute;tait tr&egrave;s sensible &agrave; l&#39;&eacute;quilibre et &agrave; la justice, exprimant son m&eacute;contentement lorsque quelque chose lui semblait injuste ou d&eacute;s&eacute;quilibr&eacute;. Elle avait un fort sens de la loyaut&eacute; et de la justice.</p>', '<p>J&#39;ai rencontr&eacute; Zephyra lors d&#39;une exposition canine d&eacute;di&eacute;e aux races rares. Elle se distinguait par sa gr&acirc;ce et son &eacute;l&eacute;gance, captivant tous ceux qui la croisaient. Son regard vif et expressif m&#39;a imm&eacute;diatement captiv&eacute;, et je savais que notre rencontre allait &ecirc;tre sp&eacute;ciale.</p>', '2023-06-14 07:53:27'),
(94, 1, 1, 'Nyx', 'Femelle', NULL, '2023-06-01 00:00:00', NULL, 'jack-russel-g49717435f-640-648972b0210d1.jpg', '<p>Nyx &eacute;tait un v&eacute;ritable tourbillon d&#39;&eacute;nergie, une Jack Russell au pelage blanc et tachet&eacute; de noir. Sa petite taille et son allure athl&eacute;tique en faisaient un compagnon id&eacute;al pour les aventures en plein air. D&egrave;s que nos chemins se sont crois&eacute;s, j&#39;ai su que notre destin &eacute;tait scell&eacute;.</p>', '<p>Nyx &eacute;tait une chienne pleine de vie, toujours pr&ecirc;te &agrave; partir &agrave; l&#39;aventure. Elle adorait explorer les sentiers bois&eacute;s, courir &agrave; vive allure et sauter par-dessus les obstacles avec une agilit&eacute; &eacute;tonnante. Son &eacute;nergie contagieuse &eacute;tait un v&eacute;ritable baume pour mon esprit.</p>', '<p>Ce que Nyx d&eacute;testait par-dessus tout, c&#39;&eacute;tait l&#39;ennui et la monotonie. Elle recherchait constamment de nouveaux d&eacute;fis et des activit&eacute;s stimulantes pour canaliser son &eacute;nergie d&eacute;bordante. Les jouets interactifs, les jeux de recherche et les s&eacute;ances d&#39;entra&icirc;nement &eacute;taient essentiels pour satisfaire son app&eacute;tit insatiable de divertissement.</p>', '<p>J&#39;ai rencontr&eacute; Nyx dans un refuge pour animaux, o&ugrave; elle attendait impatiemment une famille aimante. Son regard espi&egrave;gle et sa queue agit&eacute;e t&eacute;moignaient de son temp&eacute;rament vif et joueur. Nous avons instantan&eacute;ment tiss&eacute; un lien sp&eacute;cial, une connexion ind&eacute;niable.</p>\r\n\r\n<p>Nyx, ma fid&egrave;le compagne, ton nom rare &eacute;tait le reflet de ton charme myst&eacute;rieux et de ton esprit intr&eacute;pide. Tu &eacute;tais bien plus qu&#39;un chien, tu &eacute;tais ma partenaire d&#39;aventure et ma confidente. Ta m&eacute;moire vivra &agrave; jamais dans mon c&oelig;ur, rappelant l&#39;amour et la vitalit&eacute; que tu as apport&eacute;s &agrave; ma vie.<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-14 07:56:31'),
(95, 1, 1, 'Aether', 'Male', NULL, '2022-04-02 00:00:00', NULL, 'dog-gccf06abd3-640-648973e87a665.jpg', '<p>Aether &eacute;tait un Husky au pelage &eacute;pais et aux yeux per&ccedil;ants d&#39;un bleu glacial. Sa silhouette imposante et sa d&eacute;marche gracieuse lui conf&eacute;raient une allure v&eacute;ritablement impressionnante. D&egrave;s que nos regards se sont crois&eacute;s, j&#39;ai su que notre rencontre allait &ecirc;tre inoubliable.</p>', '<p>Aether &eacute;tait un chien dot&eacute; d&#39;une &eacute;nergie d&eacute;bordante et d&#39;une passion pour l&#39;aventure. Il &eacute;tait toujours pr&ecirc;t &agrave; explorer de nouveaux territoires, &agrave; courir &agrave; vive allure et &agrave; se mesurer &agrave; tous les d&eacute;fis qui se pr&eacute;sentaient. Ses aboiements puissants r&eacute;sonnaient comme un chant de libert&eacute; dans l&#39;air pur des grands espaces.</p>', '<p>S&#39;il y a bien une chose qu&#39;Aether d&eacute;testait, c&#39;&eacute;tait la monotonie. Il aspirait &agrave; des activit&eacute;s stimulantes pour nourrir son esprit vif et sa soif de d&eacute;couvertes. Les longues promenades en nature, les courses effr&eacute;n&eacute;es dans les vastes &eacute;tendues enneig&eacute;es et les jeux d&#39;intelligence &eacute;taient indispensables pour satisfaire son besoin d&#39;excitation.</p>', '<p>J&#39;ai rencontr&eacute; Aether lors d&#39;une exposition canine consacr&eacute;e aux races nordiques. Il se d&eacute;marquait par sa beaut&eacute; saisissante et sa pr&eacute;sence imposante parmi ses cong&eacute;n&egrave;res. Son regard malicieux et son temp&eacute;rament joueur ont instantan&eacute;ment attir&eacute; mon attention, cr&eacute;ant un lien ind&eacute;niable entre nous.</p>', '2023-06-14 08:00:00'),
(96, 1, 1, 'Seraphina', 'Femelle', NULL, '2023-06-03 00:00:00', NULL, 'border-collie-g7cea4fb03-640-648978734ee44.jpg', '<p>Seraphina &eacute;tait une Border Collie d&#39;une beaut&eacute; saisissante, avec un pelage &eacute;pais noir et blanc qui mettait en valeur ses yeux p&eacute;tillants d&#39;intelligence. Sa silhouette &eacute;l&eacute;gante et sa posture attentive t&eacute;moignaient de sa nature agile et d&eacute;vou&eacute;e. D&egrave;s que nos chemins se sont crois&eacute;s, j&#39;ai su que notre relation serait unique.&nbsp;Seraphina &eacute;tait une chienne d&#39;une intelligence remarquable et d&#39;une &eacute;nergie d&eacute;bordante. Elle &eacute;tait une compagne id&eacute;ale pour les activit&eacute;s sportives et les d&eacute;fis mentaux. Les s&eacute;ances d&#39;ob&eacute;issance, les jeux de recherche et les courses fr&eacute;n&eacute;tiques &eacute;taient autant d&#39;occasions pour elle de briller et de se surpasser.</p>', '<p>Seraphina adorait relever des d&eacute;fis et &ecirc;tre constamment stimul&eacute;e. Elle aimait particuli&egrave;rement les activit&eacute;s qui faisaient appel &agrave; son intelligence et &agrave; sa capacit&eacute; d&#39;apprentissage. Les s&eacute;ances d&#39;ob&eacute;issance et de dressage &eacute;taient ses moments pr&eacute;f&eacute;r&eacute;s, car elle aimait montrer sa ma&icirc;trise des commandes et recevoir des &eacute;loges pour son travail acharn&eacute;. Seraphina &eacute;tait &eacute;galement passionn&eacute;e par les jeux interactifs et les &eacute;nigmes qui mettaient &agrave; l&#39;&eacute;preuve sa r&eacute;flexion et sa logique. Elle &eacute;tait toujours partante pour des sessions de recherche d&#39;objets cach&eacute;s, o&ugrave; elle pouvait d&eacute;montrer sa perspicacit&eacute; et sa pers&eacute;v&eacute;rance. En r&eacute;sum&eacute;, Seraphina trouvait son bonheur dans les activit&eacute;s qui mettaient son cerveau en action et lui permettaient de canaliser son &eacute;nergie d&eacute;bordante.</p>', '<p>Ce que Seraphina d&eacute;testait par-dessus tout, c&#39;&eacute;tait l&#39;ennui et la routine. Elle aspirait &agrave; de nouveaux apprentissages et &agrave; des d&eacute;fis stimulants pour nourrir son esprit vif. Elle &eacute;tait insatiablement curieuse, toujours en qu&ecirc;te de nouvelles t&acirc;ches &agrave; accomplir et de nouveaux territoires &agrave; explorer.</p>', '<p>J&#39;ai rencontr&eacute; Seraphina lors d&#39;une d&eacute;monstration de travail du b&eacute;tail, o&ugrave; elle montrait sa ma&icirc;trise exceptionnelle du troupeau. Son agilit&eacute; et son instinct inn&eacute; m&#39;ont imm&eacute;diatement captiv&eacute;. Son regard vif et concentr&eacute; a su capter mon attention, cr&eacute;ant une connexion profonde entre nous.</p>\r\n\r\n<p>Ma Seraphina, ta m&eacute;moire vivra &agrave; jamais dans mon c&oelig;ur, rappelant l&#39;intelligence et la gr&acirc;ce que tu as apport&eacute;es &agrave; ma vie.<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-14 08:21:07'),
(97, 1, 1, 'Zephyr', 'Femelle', NULL, '2022-08-15 00:00:00', NULL, 'dachshund-g272372bfb-640-648979f40c0f4.jpg', '<p>Zephyr &eacute;tait une Teckel d&#39;une &eacute;l&eacute;gance incomparable, avec un corps long et bas sur pattes, et des yeux vifs et expressifs.&nbsp;Elle &eacute;tait une compagne fid&egrave;le et affectueuse. Sa nature protectrice et son d&eacute;vouement inconditionnel ont fait d&#39;elle une v&eacute;ritable amie. Son regard doux et sa pr&eacute;sence r&eacute;confortante apaisaient mes soucis et me rappelaient chaque jour &agrave; quel point elle &eacute;tait pr&eacute;cieuse dans ma vie.</p>', '<p>Zephyr &eacute;tait une chienne pleine de vivacit&eacute; et d&#39;&eacute;nergie. Elle &eacute;tait toujours partante pour de longues promenades en plein air, explorant joyeusement chaque recoin de notre environnement. Son amour pour la nature et sa passion pour les d&eacute;couvertes rendaient chaque sortie avec elle pleine de surprises et de joie.</p>', '<p>Ce que Zephyr d&eacute;testait par-dessus tout, c&#39;&eacute;tait l&#39;ennui et la routine. Elle cherchait constamment de nouveaux jeux et de nouvelles activit&eacute;s pour satisfaire sa soif d&#39;aventure. Les jeux d&#39;agilit&eacute;, les s&eacute;ances de recherche d&#39;objets et les &eacute;nigmes stimulantes &eacute;taient des passe-temps favoris qui lui permettaient de mettre &agrave; profit son intelligence vive et sa perspicacit&eacute;.</p>', '<p>C&#39;&eacute;tait une journ&eacute;e chaude et claire lorsque je me suis rendu &agrave; un refuge pour animaux. Mon c&oelig;ur &eacute;tait rempli d&#39;espoir et d&#39;anticipation alors que je cherchais le compagnon id&eacute;al pour m&#39;accompagner dans ma vie. En me promenant entre les enclos, mon regard s&#39;est pos&eacute; sur une petite chienne Teckel qui semblait m&#39;observer avec curiosit&eacute;.</p>\r\n\r\n<p>Je suis rest&eacute; l&agrave;, devant l&#39;enclos de la petite chienne, et nous nous sommes fix&eacute;s mutuellement pendant un instant. J&#39;ai ressenti une connexion instantan&eacute;e, une sorte de complicit&eacute; silencieuse qui m&#39;a touch&eacute; en plein c&oelig;ur. Je savais que c&#39;&eacute;tait elle, celle que je cherchais.</p>\r\n\r\n<p>Sans perdre de temps, j&#39;ai demand&eacute; au personnel du refuge de me pr&eacute;senter cette adorable Teckel femelle. Ils m&#39;ont appris qu&#39;elle s&#39;appelait Zephyr, un nom rare qui semblait refl&eacute;ter sa nature douce et l&eacute;g&egrave;re. J&#39;ai &eacute;t&eacute; impressionn&eacute; par sa personnalit&eacute; joyeuse et enjou&eacute;e alors que nous faisions connaissance.</p>\r\n\r\n<p>Apr&egrave;s quelques formalit&eacute;s administratives, j&#39;ai pu ramener Zephyr chez moi. C&#39;&eacute;tait le d&eacute;but d&#39;une aventure incroyable. Elle s&#39;est rapidement adapt&eacute;e &agrave; sa nouvelle maison et a conquis nos c&oelig;urs avec son &eacute;nergie d&eacute;bordante et sa tendresse infinie.</p>\r\n\r\n<p>Au fil du temps, Zephyr est devenue bien plus qu&#39;un animal de compagnie, elle est devenue ma meilleure amie. Nous avons partag&eacute; d&#39;innombrables moments de complicit&eacute;, de rires et de r&eacute;confort. Sa pr&eacute;sence m&#39;a apport&eacute; une joie inestimable et une connexion profonde avec le monde animal.&nbsp;</p>', '2023-06-14 08:27:31'),
(98, 2, 1, 'Ophélia', 'Femelle', NULL, '2023-03-13 00:00:00', NULL, 'cat-g1325db0a1-640-64897b1a5cdb2.jpg', '<p>Ophelia &eacute;tait une chatte d&#39;une &eacute;l&eacute;gance in&eacute;gal&eacute;e, avec une fourrure soyeuse d&#39;un noir profond et des yeux d&#39;un vert &eacute;meraude &eacute;tincelant. Elle &eacute;tait ind&eacute;pendante et d&eacute;licate.</p>', '<p>Elle aimait passer ses journ&eacute;es &agrave; se pr&eacute;lasser au soleil, se pr&eacute;parant avec soin et &eacute;l&eacute;gance. Son amour pour les c&acirc;lins discrets, les caresses douces et les moments de tranquillit&eacute; &eacute;taient les moments privil&eacute;gi&eacute;s que nous partagions, cr&eacute;ant ainsi un lien profond entre nous.</p>', '<p>Ce que Ophelia d&eacute;testait par-dessus tout, c&#39;&eacute;tait le bruit et l&#39;agitation. Elle pr&eacute;f&eacute;rait la tranquillit&eacute; et le calme, recherchant des recoins confortables o&ugrave; elle pouvait se retirer pour se reposer et r&eacute;fl&eacute;chir. Les moments de silence &eacute;taient une v&eacute;ritable symphonie pour elle, lui permettant de trouver la s&eacute;r&eacute;nit&eacute; dont elle avait besoin.</p>', '<p>J&#39;ai rencontr&eacute; Ophelia dans un refuge pour animaux. Elle se tenait l&agrave;, majestueuse et myst&eacute;rieuse, attirant imm&eacute;diatement mon attention parmi les autres chats. Son allure noble et sa d&eacute;marche gracieuse m&#39;ont imm&eacute;diatement fascin&eacute;, cr&eacute;ant une connexion instantan&eacute;e entre nous.</p>\r\n\r\n<p><span style=\"color:#8e44ad;\">Ophelia, mon joyau rare, ton nom &eacute;tait le reflet de ta beaut&eacute; int&eacute;rieure et de ton esprit libre. Tu &eacute;tais bien plus qu&#39;un chat, tu &eacute;tais une muse, une compagne qui m&#39;a apport&eacute; s&eacute;r&eacute;nit&eacute; et inspiration. Ta pr&eacute;sence restera &agrave; jamais grav&eacute;e dans mon c&oelig;ur, rappelant la gr&acirc;ce et l&#39;amour que tu as apport&eacute;s dans ma vie</span>.<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-14 08:30:55'),
(99, 2, 1, 'Orion', 'Male', NULL, '2023-06-13 00:00:00', NULL, 'cat-g13b384d41-640-64897be886f92.jpg', '<p>Orion &eacute;tait un magnifique chat avec un pelage tigr&eacute; aux nuances dor&eacute;es, qui brillait comme les &eacute;toiles dans le ciel nocturne. D&egrave;s que nos regards se sont crois&eacute;s, j&#39;ai su que nous &eacute;tions destin&eacute;s &agrave; partager une aventure extraordinaire.</p>', '<p>Il aimait les d&eacute;fis et les jeux stimulants qui mettaient &agrave; l&#39;&eacute;preuve ses capacit&eacute;s mentales. Nos sessions de jeu &eacute;taient remplies de rires et d&#39;&eacute;merveillement, alors qu&#39;il d&eacute;montrait avec brio ses talents de chasseur et sa vivacit&eacute; d&#39;esprit.&nbsp;Orion &eacute;tait &eacute;galement un chat affectueux et loyal. Il aimait se blottir contre moi, ronronnant doucement comme une m&eacute;lodie apaisante. Ses c&acirc;lins chaleureux &eacute;taient un v&eacute;ritable baume pour mon &acirc;me, m&#39;offrant r&eacute;confort et affection dans les moments de tristesse ou de stress.</p>', '<p>Il d&eacute;testait s&#39;ennuyer, m&ecirc;me pour quelques secondes.&nbsp;Il avait constamment besoin de stimulation et de nouvelles exp&eacute;riences pour nourrir son esprit curieux. Les moments de routine monotone le rendaient agit&eacute;, alors nous avons explor&eacute; ensemble de nouveaux environnements, d&eacute;couvert de nouveaux jouets et partag&eacute; des moments d&#39;exploration palpitante.</p>', '<p>J&#39;ai rencontr&eacute; Orion lors d&#39;une visite chez un &eacute;leveur passionn&eacute;. Il se tenait l&agrave;, fier et confiant, avec une aura qui captivait imm&eacute;diatement mon attention parmi les autres chats. Sa d&eacute;marche majestueuse et son regard per&ccedil;ant &eacute;taient un m&eacute;lange envo&ucirc;tant de gr&acirc;ce et de d&eacute;termination.</p>', '2023-06-14 08:35:52'),
(100, 3, 1, 'Obsidian', 'Male', NULL, '2023-06-05 00:00:00', NULL, 'line-gf6f1a574a-640-64897d2dcf240.jpg', '<p>Obsidian &eacute;tait un serpent d&#39;une &eacute;l&eacute;gance myst&eacute;rieuse, avec un corps souple et gracieux qui s&#39;enroulait avec gr&acirc;ce. D&egrave;s que nos regards se sont crois&eacute;s, j&#39;ai su que notre relation serait unique et fascinante.</p>', '<p>Obsidian &eacute;tait un serpent curieux et observateur. Il aimait explorer son environnement avec une agilit&eacute; &eacute;tonnante, glissant silencieusement &agrave; travers les recoins les plus inaccessibles. Nos moments de jeu &eacute;taient empreints d&#39;une fascination mutuelle, tandis que j&#39;observais avec &eacute;merveillement sa fluidit&eacute; et sa capacit&eacute; &agrave; se fondre dans son habitat.</p>', '<p>Ce que Obsidian d&eacute;testait par-dessus tout, c&#39;&eacute;tait les bruits forts et les mouvements brusques. Il pr&eacute;f&eacute;rait les environnements calmes et s&eacute;curis&eacute;s, o&ugrave; il pouvait se d&eacute;tendre et se reposer en toute tranquillit&eacute;. Nos moments de qui&eacute;tude partag&eacute;e &eacute;taient des instants privil&eacute;gi&eacute;s o&ugrave; nous &eacute;tablissions une confiance mutuelle.</p>', '<p>J&#39;ai rencontr&eacute; Obsidian lors d&#39;une visite chez un &eacute;leveur passionn&eacute; de serpents domestiques. Il se tenait l&agrave;, silencieux et hypnotisant, attirant imm&eacute;diatement mon attention parmi les autres reptiles. Son allure imposante et sa beaut&eacute; hypnotique m&#39;ont imm&eacute;diatement captiv&eacute;, cr&eacute;ant une connexion &eacute;trange entre nous.</p>\r\n\r\n<p>Tu &eacute;tais bien plus qu&#39;un simple reptile, tu &eacute;tais une cr&eacute;ature fascinante qui a &eacute;largi mes horizons et &eacute;veill&eacute; ma curiosit&eacute;. Ta beaut&eacute; exotique et ton caract&egrave;re unique resteront &agrave; jamais grav&eacute;s dans mon c&oelig;ur, rappelant la magie et l&#39;&eacute;motion que tu as apport&eacute;es dans ma vie. Je ne t&#39;oublierais jamais.</p>', '2023-06-14 08:41:17'),
(101, 3, 1, 'Ignatus', 'Male', NULL, '2023-02-18 00:00:00', NULL, 'ignatus-64897ec495696.jpg', '<p>Ignatius &eacute;tait un iguane majestueux, avec des &eacute;cailles vertes &eacute;tincelantes et une queue agile qui lui conf&eacute;rait une &eacute;l&eacute;gance unique</p>\r\n\r\n<p>Ignatius &eacute;tait un compagnon calme et r&eacute;serv&eacute;. Bien qu&#39;il ne puisse pas exprimer son affection de la m&ecirc;me mani&egrave;re qu&#39;un animal de compagnie plus traditionnel, sa pr&eacute;sence apaisante et ses petits gestes d&#39;interaction &eacute;taient des preuves de son attachement. Nous avons d&eacute;velopp&eacute; une relation bas&eacute;e sur le respect mutuel et la compr&eacute;hension de ses besoins sp&eacute;cifiques.</p>', '<p>Ignatius &eacute;tait un iguane intelligent et territorial. Il aimait explorer son environnement en grimpant sur les branches et en s&#39;adaptant &agrave; diverses situations. Nos moments de jeu &eacute;taient remplis de d&eacute;fis et de d&eacute;couvertes, tandis que je lui proposais de nouvelles &eacute;nigmes &agrave; r&eacute;soudre ou de d&eacute;licieux l&eacute;gumes &agrave; d&eacute;guster.</p>', '<p>Ce que Ignatius d&eacute;testait par-dessus tout, c&#39;&eacute;tait le confinement. Il avait besoin d&#39;espace pour se d&eacute;placer et grimper librement. Les moments pass&eacute;s &agrave; l&#39;ext&eacute;rieur, o&ugrave; il pouvait profiter du soleil et explorer son environnement naturel, &eacute;taient les plus appr&eacute;ci&eacute;s pour lui.</p>', '<p>J&#39;ai rencontr&eacute; Ignatius lors d&#39;une visite chez un &eacute;leveur passionn&eacute; d&#39;animaux exotiques. Il se tenait l&agrave;, immobile et curieux, captivant imm&eacute;diatement mon attention parmi les autres reptiles. Son regard per&ccedil;ant et son allure fi&egrave;re me donnaient l&#39;impression d&#39;&ecirc;tre face &agrave; une cr&eacute;ature ancienne, emplie de myst&egrave;re.</p>', '2023-06-14 08:45:55'),
(102, 3, 1, 'Celestia', 'Femelle', NULL, '2023-06-12 00:00:00', NULL, 'mouse-ge60ca9aaa-640-64897ff28b956.jpg', '<p>Celestia &eacute;tait une gerbille d&#39;une beaut&eacute; remarquable, avec une fourrure douce et des yeux &eacute;tincelants d&#39;intelligence.&nbsp;Elle aimait se blottir dans mes mains, se laisser caresser et me t&eacute;moigner sa reconnaissance avec de petits baisers de gerbille. Sa pr&eacute;sence chaleureuse et sa douceur m&#39;apportaient r&eacute;confort et bonheur au quotidien.</p>', '<p>Celestia aimait jouer et se divertir. Elle adorait grimper sur les obstacles, creuser dans son bac &agrave; sable et courir avec une agilit&eacute; incroyable. Nos moments de jeu &eacute;taient remplis de joie et de complicit&eacute;, cr&eacute;ant des souvenirs inoubliables.</p>', '<p>Elle d&eacute;testait s&#39;ennuyer.&nbsp;Elle avait besoin de stimulations constantes pour s&#39;&eacute;panouir pleinement. Nous avons explor&eacute; divers jouets et activit&eacute;s pour satisfaire sa curiosit&eacute; insatiable, passant des heures &agrave; nous amuser ensemble.</p>', '<p>J&#39;ai rencontr&eacute; Celestia dans une animalerie, parmi d&#39;autres gerbilles. Elle se d&eacute;marquait par sa vivacit&eacute; et sa curiosit&eacute;, explorant son environnement avec agilit&eacute; et enthousiasme. Son &eacute;nergie contagieuse et son charme d&eacute;licat m&#39;ont imm&eacute;diatement captiv&eacute;. Nous avons pass&eacute; des moments exceptionnels que je n&#39;oublierais jamais.&nbsp;</p>', '2023-06-14 08:53:06'),
(103, 3, 1, 'Nimbus', 'Male', NULL, '2023-06-13 00:00:00', NULL, 'chinchilla-gf311669dc-640-648981f95141a.jpg', '<p>Nimbus &eacute;tait un chinchilla d&#39;une &eacute;l&eacute;gance incomparable, avec une fourrure dense et soyeuse d&#39;un gris argent&eacute; scintillant. J&#39;ai toujours ressenti une connexion sp&eacute;ciale avec ce petit &ecirc;tre fascinant.</p>', '<p>Il aimait sauter d&#39;une branche &agrave; l&#39;autre dans sa cage, grimper sur les perchoirs et jouer avec des jouets suspendus. Nos moments de jeu &eacute;taient remplis de rires et de complicit&eacute;, alors que je lui proposais de nouveaux d&eacute;fis et des activit&eacute;s stimulantes.</p>', '<p>Ce que Nimbus d&eacute;testait par-dessus tout, c&#39;&eacute;tait le confinement. Il avait besoin d&#39;espace pour se d&eacute;placer et exprimer sa nature enjou&eacute;e. J&#39;ai cr&eacute;&eacute; un environnement spacieux et s&eacute;curis&eacute; pour lui, avec des aires de jeu et des cachettes pour satisfaire son besoin d&#39;exploration.</p>', '<p>J&#39;ai rencontr&eacute; Nimbus lors d&#39;une exposition d&#39;animaux exotiques. Il &eacute;tait expos&eacute; avec d&#39;autres chinchillas, mais il se d&eacute;marquait par sa vivacit&eacute; et son charisme. Sa curiosit&eacute; sans limite et son regard espi&egrave;gle m&#39;ont imm&eacute;diatement captiv&eacute;.</p>\r\n\r\n<p>Nimbus &eacute;tait un compagnon affectueux et doux. Il aimait se blottir contre moi, se laisser caresser et me t&eacute;moigner sa confiance avec des petits sauts joyeux. Sa pr&eacute;sence calme et apaisante &eacute;tait un r&eacute;confort constant dans ma vie.</p>', '2023-06-14 08:58:19'),
(104, 1, 1, 'Kohana', 'Femelle', NULL, '2022-11-16 00:00:00', NULL, 'kohana-648983282ae7e.jpg', '<p>Kohana &eacute;tait une jolie Akita, ainsi qu&#39;une amie fid&egrave;le et attentionn&eacute;e. Elle savait intuitivement quand j&#39;avais besoin de r&eacute;confort et elle &eacute;tait toujours l&agrave; pour moi, pr&ecirc;te &agrave; partager des moments de joie ou &agrave; m&#39;&eacute;couter avec bienveillance. Sa pr&eacute;sence apaisante et son amour inconditionnel &eacute;taient des cadeaux inestimables.</p>', '<p>Kohana aimait les longues promenades en pleine nature, o&ugrave; elle pouvait d&eacute;ployer toute sa puissance et son endurance. Ensemble, nous avons explor&eacute; des sentiers pittoresques, d&eacute;couvert des paysages &agrave; couper le souffle et partag&eacute; des moments de complicit&eacute; profonde.</p>', '<p>Ce que Kohana d&eacute;testait par-dessus tout, c&#39;&eacute;tait l&#39;injustice. Elle &eacute;tait une protectrice n&eacute;e, pr&ecirc;te &agrave; d&eacute;fendre ceux qu&#39;elle aimait avec une loyaut&eacute; in&eacute;branlable. Sa pr&eacute;sence imposante dissuadait tout intrus, mais sa douceur envers les siens &eacute;tait palpable.</p>', '<p>J&#39;ai rencontr&eacute; Kohana lors d&#39;une exposition canine, o&ugrave; sa pr&eacute;sence imposante et sa prestance ont attir&eacute; tous les regards. Son attitude calme et confiante m&#39;a imm&eacute;diatement fascin&eacute;, et je savais que nous &eacute;tions destin&eacute;s &agrave; partager une aventure incroyable.</p>', '2023-06-14 09:06:48'),
(106, 1, 115, 'Bill', 'Male', '2007-06-21 00:00:00', '2022-06-08 00:00:00', '57Moselle + 88 Vosges', 'bill1-1-6498468e6f16e.jpg', '<p>Je n&#39;&eacute;coute pas mes maitres</p>\r\n\r\n<p>J&#39;adore les longues ballades et courir en for&ecirc;t; Parfois je cours apr&egrave;s les chevreuils, sanglier je n&#39;ai pas peur;</p>\r\n\r\n<p>Au d&eacute;part j&#39;etais tr&egrave;s social avec mes compatriotes mais apr&egrave;s plusieurs mauvaises experiences avec d&#39;autre chien pas sympa; Je suis devenu moi m&ecirc;me pas sympa avec les autres; J&#39;avais mes pr&eacute;f&eacute;rences;</p>\r\n\r\n<p>J&#39;aimais bien faire r&acirc;ler mon ma&icirc;tre, une fois je suis parti dans le champs de colza derri&egrave;re un renard et je ne suis revenu que quelque heure apr&egrave;s, mais j&#39;etais tout br&ucirc;l&eacute; au niveau des yeux, mes m&acirc;itres ont d&ucirc; m&#39;emmener chez le v&eacute;to apr&egrave;s uen bonne cr&egrave;me anti biotique c&#39;est pass&eacute;.&nbsp;</p>', '<p>les ballades les carresses courir et en faire qu&#39;a sa t&ecirc;te les petites r&eacute;compenses</p>\r\n\r\n<p>tout les matins je me mettais devant l&#39;evier de la cuisine et j&#39;avais le droit d&#39;en avoir une ou&nbsp; deux</p>', '<p>le v&eacute;to les chats</p>', '<p>J&#39;ai &eacute;t&eacute; adopt&eacute; en Belgique, et je suis rest&eacute; 15 ans avec mes ma&icirc;tres. Ma ma&icirc;tresse ne me voulait pas mais apr&egrave;s &eacute;lection au sain de la famille 3 voix pour 1 contre. J&#39;ai &eacute;t&eacute; adopt&eacute;. Au d&eacute;part je ne pouvais pas partir en vacances avec eux, car ils prenaient l&#39;avion, mais apr&egrave;s j&#39;ai eu le droit de passer les vacances et week-end dans les Vosges. J&#39;&eacute;tais beaucoup aim&eacute; et &ccedil;a a &eacute;t&eacute; tr&egrave;s dur de les laisser et eux de me laisser partir.</p>\r\n\r\n<p>J&#39;ai eu un cancer et j&#39;ai du &ecirc;tre amput&eacute; d&#39;une patte, mais je suis parti en mars 2022 voir la mer pour la premi&egrave;re fois.</p>', '2023-06-25 13:08:50'),
(108, 1, 113, 'Peki', 'Male', NULL, '2018-11-10 00:00:00', NULL, 'peki1-64a3c1dcd491c.jpg', '<p>Peki &eacute;tait un petit chien assez fier de son pelage. Il r&eacute;clamait toujours des caresses, et aimait n&#39;en faire qu&#39;&agrave; sa t&ecirc;te.&nbsp;</p>', '<p>Il adorait vraiment la neige, lorsqu&#39;il y en avait, il courait dessus et s&#39;amusait &agrave; creuser pour faire des terriers. Il adorait &eacute;galement particuli&egrave;rement les friandises au bacon et les os &agrave; macher trop grands pour lui.&nbsp;</p>\r\n\r\n<p>Ne lui parlez pas de coussin, la plupart du temps Peki &eacute;tait cach&eacute; sous ou derri&egrave;re un meuble pour faire une sieste tranquillement alors que ses ma&icirc;tres le cherchaient partout.&nbsp;</p>\r\n\r\n<p>Il adorait recevoir ses c&acirc;ins du soir, o&ugrave; il se mettait sur le dos, le temps que maman lui chantait une petite berceuse.</p>', '<p>Il avait horreur d&#39;entendre des bruits de cha&icirc;nes metalliques dans les films. Il avait aussi peur du bruit des feux d&#39;artifices.</p>', '<p>Peki venait d&#39;un autre coin de la France. Ses pr&eacute;c&eacute;dents ma&icirc;res cherchaient quelqu&#39;un pour s&#39;en occuper. Lorsque ma soeur vit Peki, elle ne pouvait plus le quitter, elle l&#39;a donc ramen&eacute; &agrave; la maison. La premi&egrave;re fois que je l&#39;ai vu, il descendait de la voiture et avait tellement de pelage que l&#39;on ne pouvait pas dire o&ugrave; &eacute;tait sa t&ecirc;te. Peki &eacute;tait directement devenu un membre de la famille. Il prenait chaque repas avec nous et allait se coucher en m&ecirc;me temps que nous. Il &eacute;tait devenu indispensable. Lorsque l&#39;on faisait des soir&eacute;es jeux vid&eacute;o, nous le prenions avec nous et il restait tranquillement &agrave; nous regarder jouer. Ca a &eacute;t&eacute; tr&egrave;s dur de te laisser partir, et le fait que tu aies d&ucirc; souffrir &agrave; cause d&#39;un probl&egrave;me de sant&eacute; a &eacute;t&eacute; tr&egrave;s douloureux. A ce jour nous ne t&#39;oublions toujours pas et ne t&#39;oublierons jamais, petit Peki&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-07-04 06:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `animal_memorial_user`
--

CREATE TABLE `animal_memorial_user` (
  `animal_memorial_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `animal_memorial_user`
--

INSERT INTO `animal_memorial_user` (`animal_memorial_id`, `user_id`) VALUES
(93, 108),
(103, 2),
(104, 1),
(106, 1),
(106, 2),
(106, 113),
(106, 116),
(108, 1);

-- --------------------------------------------------------

--
-- Table structure for table `belle_histoire`
--

CREATE TABLE `belle_histoire` (
  `id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `genre_id` int NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_publication` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `belle_histoire`
--

INSERT INTO `belle_histoire` (`id`, `auteur_id`, `genre_id`, `titre`, `texte`, `photo`, `slug`, `etat`, `date_creation`, `date_publication`) VALUES
(56, 1, 1, 'Max, héros de ses compères', '<p>Il &eacute;tait une fois un petit chien nomm&eacute; Max, au pelage brun et aux yeux &eacute;tincelants. Max vivait dans une petite maison au bord d&#39;une magnifique for&ecirc;t. Chaque jour, il explorait les bois, curieux et aventureux. Un jour, alors qu&#39;il se promenait pr&egrave;s d&#39;une clairi&egrave;re, il entendit un cri de d&eacute;tresse.</p>\r\n\r\n<p>Max suivit le son et d&eacute;couvrit un adorable &eacute;cureuil pris au pi&egrave;ge dans un filet de p&ecirc;che abandonn&eacute;. Sans h&eacute;siter, il se pr&eacute;cipita pour aider le petit animal. Avec patience et adresse, il parvint &agrave; d&eacute;faire les n&oelig;uds et lib&eacute;ra l&#39;&eacute;cureuil. Reconnaissant, l&#39;&eacute;cureuil lui proposa de l&#39;accompagner dans une qu&ecirc;te extraordinaire.</p>\r\n\r\n<p>Ils se dirig&egrave;rent vers une vieille maison abandonn&eacute;e en lisi&egrave;re de la for&ecirc;t. L&#39;&eacute;cureuil expliqua que cette maison &eacute;tait autrefois habit&eacute;e par un myst&eacute;rieux sorcier, qui avait disparu depuis de nombreuses ann&eacute;es. Des rumeurs disaient qu&#39;un tr&eacute;sor magique &eacute;tait cach&eacute; dans cette demeure.</p>\r\n\r\n<p>Max, intrigu&eacute; par cette histoire, d&eacute;cida d&#39;entrer dans la maison. Il explorait chaque pi&egrave;ce avec courage et d&eacute;termination, jusqu&#39;&agrave; ce qu&#39;il trouve une porte d&eacute;rob&eacute;e menant &agrave; une cave sombre. Sans h&eacute;siter, il descendit prudemment les marches, guid&eacute; par une lueur myst&eacute;rieuse.</p>\r\n\r\n<p>Au fond de la cave, Max d&eacute;couvrit un coffre en bois sculpt&eacute;, scell&eacute; par une serrure ancienne. L&#39;&eacute;cureuil lui r&eacute;v&eacute;la que seuls ceux qui avaient un c&oelig;ur pur et noble pouvaient ouvrir le coffre. Max posa alors sa patte sur le loquet et, avec &eacute;merveillement, la serrure se d&eacute;verrouilla.</p>\r\n\r\n<p>Le coffre s&#39;ouvrit, d&eacute;voilant un &eacute;clatant collier orn&eacute; d&#39;une pierre pr&eacute;cieuse. Le collier &eacute;tait magique et conf&eacute;rait &agrave; celui qui le portait la capacit&eacute; de comprendre et parler toutes les langues du monde. Max r&eacute;alisa que ce tr&eacute;sor &eacute;tait un cadeau destin&eacute; &agrave; quelqu&#39;un qui pouvait r&eacute;pandre la paix et la compr&eacute;hension entre les &ecirc;tres.</p>\r\n\r\n<p>Ainsi, Max devint le h&eacute;ros de la for&ecirc;t, utilisant le pouvoir du collier pour aider les animaux en difficult&eacute; et pour encourager les humains &agrave; prot&eacute;ger la nature. Il devint un symbole d&#39;espoir et d&#39;harmonie, un v&eacute;ritable ami de toutes les cr&eacute;atures vivantes.</p>\r\n\r\n<p>Et ainsi, gr&acirc;ce &agrave; la bravoure et &agrave; la g&eacute;n&eacute;rosit&eacute; d&#39;un petit chien nomm&eacute; Max, la for&ecirc;t retrouva sa splendeur d&#39;antan, et les animaux v&eacute;curent en paix et en harmonie pour toujours.</p>', 'default.jpg', 'max-heros-de-ses-comperes', 'STATE_APPROUVED', '2023-06-13 18:52:39', '2023-07-17 21:03:12'),
(57, 1, 1, 'Nemo, petit poisson aux grands accomplissements', '<p>Dans les profondeurs scintillantes de l&#39;oc&eacute;an, vivait un petit poisson nomm&eacute; Nemo. Il avait des &eacute;cailles chatoyantes et des nageoires &eacute;l&eacute;gantes qui le rendaient rapide et agile. Nemo r&ecirc;vait de d&eacute;couvrir le vaste monde au-del&agrave; de son r&eacute;cif corallien, o&ugrave; il entendait des r&eacute;cits d&#39;aventures fascinantes.</p>\r\n\r\n<p>Un jour, alors que Nemo se faufilait entre les r&eacute;cifs, il aper&ccedil;ut un myst&eacute;rieux objet brillant qui flottait &agrave; la surface. Intrigu&eacute;, il s&#39;approcha prudemment et r&eacute;alisa que c&#39;&eacute;tait une bouteille contenant un message. Nemo lut le message avec curiosit&eacute; : &quot;&Agrave; celui qui ose r&ecirc;ver grand, je te confie la cl&eacute; des oc&eacute;ans. Trouve-la, et tu auras le pouvoir de ma&icirc;triser les courants marins.&quot;</p>\r\n\r\n<p>D&eacute;termin&eacute; &agrave; relever ce d&eacute;fi, Nemo se lan&ccedil;a dans une qu&ecirc;te &eacute;pique &agrave; la recherche de la cl&eacute; des oc&eacute;ans. Il traversa des paysages sous-marins &eacute;blouissants, affronta des cr&eacute;atures redoutables et fit preuve d&#39;une ing&eacute;niosit&eacute; sans &eacute;gale pour r&eacute;soudre les &eacute;nigmes laiss&eacute;es par les gardiens de la cl&eacute;.</p>\r\n\r\n<p>Apr&egrave;s de nombreuses &eacute;preuves, Nemo arriva enfin &agrave; un ancien temple englouti. L&agrave;, il trouva la cl&eacute; des oc&eacute;ans, une &eacute;toile de mer &eacute;tincelante. En la saisissant avec sa nageoire, Nemo sentit une &eacute;nergie puissante l&#39;envahir. D&eacute;sormais, il pouvait influencer les courants marins et aider les cr&eacute;atures marines en d&eacute;tresse.</p>\r\n\r\n<p>Gr&acirc;ce &agrave; son nouveau pouvoir, Nemo devint le h&eacute;ros des oc&eacute;ans. Il d&eacute;jouait les filets de p&ecirc;che, prot&eacute;geait les coraux et guidait les poissons migrateurs vers des eaux plus s&ucirc;res. Sa renomm&eacute;e grandissait parmi les habitants de l&#39;oc&eacute;an, qui l&#39;appelaient le Gardien des Courants.</p>\r\n\r\n<p>Nemo n&#39;oubliait jamais son r&ecirc;ve initial de d&eacute;couvrir le monde au-del&agrave; de son r&eacute;cif. Gr&acirc;ce &agrave; la cl&eacute; des oc&eacute;ans, il voyagea jusqu&#39;aux r&eacute;cifs lointains, explorant les merveilles sous-marines et partageant ses aventures avec d&#39;autres poissons curieux.</p>\r\n\r\n<p>Ainsi, Nemo montra au monde que m&ecirc;me le plus petit des poissons pouvait accomplir de grandes choses. Sa d&eacute;termination, son courage et son amour pour l&#39;oc&eacute;an lui permirent de devenir un h&eacute;ros inoubliable, prouvant que chacun peut faire une diff&eacute;rence, peu importe sa taille.</p>', 'default.jpg', 'nemo-petit-poisson-aux-grands-accomplissements', 'STATE_APPROUVED', '2023-06-13 18:56:48', '2023-07-17 21:03:14'),
(58, 1, 2, 'Stubby, ami loyal', '<p>L&#39;histoire vraie de Stubby est celle d&#39;un chien extraordinaire qui est devenu un h&eacute;ros de guerre pendant la Premi&egrave;re Guerre mondiale. En 1917, Stubby, un Bull Terrier de race ind&eacute;termin&eacute;e, fut trouv&eacute; par le soldat am&eacute;ricain John Robert Conroy lors de son entra&icirc;nement &agrave; New Haven, dans le Connecticut.</p>\r\n\r\n<p>Stubby se lia rapidement d&#39;amiti&eacute; avec les soldats et devint leur mascotte non officielle. Lorsque le r&eacute;giment fut envoy&eacute; en Europe, Conroy parvint &agrave; faire embarquer Stubby clandestinement &agrave; bord du navire. Sur le front, Stubby d&eacute;montra des talents exceptionnels pour d&eacute;tecter les gaz toxiques, les obus et les ennemis.</p>\r\n\r\n<p>Son instinct et son intelligence furent rapidement reconnus, et Stubby commen&ccedil;a &agrave; participer activement aux combats. Il pr&eacute;venait les troupes des attaques imminentes en aboyant et en courant vers les lignes ennemies. Il a m&ecirc;me r&eacute;ussi &agrave; capturer un espion allemand en le mordant &agrave; la jambe et en refusant de le l&acirc;cher.</p>\r\n\r\n<p>Stubby fut bless&eacute; &agrave; plusieurs reprises, mais il se remit toujours rapidement et continua &agrave; servir avec courage et d&eacute;vouement. Il devint le chien le plus d&eacute;cor&eacute; de la Premi&egrave;re Guerre mondiale, recevant des m&eacute;dailles pour son courage et sa loyaut&eacute;.</p>\r\n\r\n<p>Apr&egrave;s la guerre, Stubby retourna aux &Eacute;tats-Unis en h&eacute;ros. Il fut accueilli avec enthousiasme et c&eacute;l&eacute;br&eacute; dans tout le pays. Il participa &agrave; des d&eacute;fil&eacute;s et &agrave; des &eacute;v&eacute;nements, rencontrant des pr&eacute;sidents et des personnalit&eacute;s de renom.</p>\r\n\r\n<p>Stubby v&eacute;cut une longue vie, aim&eacute; et ch&eacute;ri par tous ceux qui connaissaient son histoire. Il mourut en 1926, laissant derri&egrave;re lui un h&eacute;ritage de bravoure et d&#39;amour. Sa m&eacute;moire est honor&eacute;e aujourd&#39;hui dans diff&eacute;rents mus&eacute;es et monuments, rappelant au monde la force et le courage des animaux qui servent aux c&ocirc;t&eacute;s des hommes.</p>', 'default.jpg', 'stubby-ami-loyal', 'STATE_APPROUVED', '2023-06-13 18:59:32', '2023-07-17 21:03:16'),
(59, 116, 3, 'Pour toi cher Oréo, un lapin extraordinaire', '<p>En cet instant solennel, nous nous rassemblons pour rendre un vibrant hommage &agrave; Oreo, un lapin exceptionnel qui a illumin&eacute; nos vies de sa pr&eacute;sence douce et aimante. Bien qu&#39;il f&ucirc;t petit de taille, son impact sur nos c&oelig;urs &eacute;tait immense.</p>\r\n\r\n<p>Oreo &eacute;tait bien plus qu&#39;un simple animal de compagnie, il &eacute;tait un membre &agrave; part enti&egrave;re de notre famille. Avec ses doux yeux et ses longues oreilles adorables, il avait le don de nous faire sourire m&ecirc;me dans les moments les plus sombres. Sa pr&eacute;sence r&eacute;confortante &eacute;tait une source de joie et de r&eacute;confort inestimable.</p>\r\n\r\n<p>Oreo &eacute;tait dot&eacute; d&#39;une personnalit&eacute; unique, remplie de curiosit&eacute; et d&#39;exploration. Il &eacute;tait toujours pr&ecirc;t &agrave; s&#39;aventurer, &agrave; d&eacute;couvrir de nouveaux horizons, et nous l&#39;admirions pour son courage et sa t&eacute;nacit&eacute;. Son amour inconditionnel nous a touch&eacute;s au plus profond de notre &ecirc;tre, nous rappelant la beaut&eacute; de la puret&eacute; et de l&#39;affection sans limites.</p>\r\n\r\n<p>Nous nous souviendrons toujours des moments pass&eacute;s avec Oreo, des caresses tendres, des jeux joyeux et des moments de complicit&eacute; partag&eacute;e. Sa pr&eacute;sence a illumin&eacute; nos vies, et m&ecirc;me si son d&eacute;part laisse un vide dans nos c&oelig;urs, nous sommes reconnaissants d&#39;avoir eu le privil&egrave;ge de partager notre chemin avec lui.</p>\r\n\r\n<p>Oreo, tu resteras &agrave; jamais grav&eacute; dans nos souvenirs les plus pr&eacute;cieux. Tu as apport&eacute; de la douceur et de l&#39;amour &agrave; nos vies, et ton h&eacute;ritage perdurera &agrave; travers les histoires que nous raconterons. Puisses-tu gambader librement dans les vastes prairies de l&#39;au-del&agrave;, entour&eacute; de paix et de s&eacute;r&eacute;nit&eacute;.</p>\r\n\r\n<p>Adieu, cher Oreo. Tu nous manqueras &eacute;ternellement, mais ton esprit continuera de briller dans nos c&oelig;urs. Que ton voyage vers le pays des &eacute;toiles soit rempli de bonheur et de f&eacute;licit&eacute;. Repose en paix, petit compagnon, et sache que notre amour pour toi ne s&#39;&eacute;teindra jamais.</p>', 'animal-g17cb2860a-640-6488bdc087c7c.jpg', 'pour-toi-cher-oreo-un-lapin-extraordinaire', 'STATE_APPROUVED', '2023-06-13 19:04:32', '2023-07-17 21:03:18'),
(60, 1, 2, 'Balto, chien sauveur', '<p>L&#39;histoire vraie de Balto est celle d&#39;un chien de tra&icirc;neau devenu un symbole de courage et de d&eacute;termination. En 1925, une &eacute;pid&eacute;mie de dipht&eacute;rie frappa la ville de Nome, en Alaska. Les m&eacute;dicaments n&eacute;cessaires pour sauver la population se trouvaient &agrave; plus de 1 000 kilom&egrave;tres de l&agrave;, &agrave; Nenana.</p>\r\n\r\n<p>Dans des conditions extr&ecirc;mes de froid et de temp&ecirc;te, une &eacute;quipe de chiens de tra&icirc;neau fut form&eacute;e pour acheminer les m&eacute;dicaments aussi rapidement que possible. Balto, un chien de race Husky Sib&eacute;rien, prit la t&ecirc;te de l&#39;ultime &eacute;tape du relais, affrontant des vents violents et des temp&eacute;ratures glaciales.</p>\r\n\r\n<p>Malgr&eacute; les difficult&eacute;s et les dangers, Balto et son &eacute;quipe franchirent les &eacute;tendues enneig&eacute;es avec une d&eacute;termination sans faille. Ils parvinrent finalement &agrave; Nome, apportant les pr&eacute;cieux m&eacute;dicaments qui sauv&egrave;rent des vies. Balto devint un h&eacute;ros national et un symbole de bravoure.</p>\r\n\r\n<p>Apr&egrave;s cet exploit h&eacute;ro&iuml;que, Balto et son &eacute;quipe furent c&eacute;l&eacute;br&eacute;s et honor&eacute;s. Une statue fut &eacute;rig&eacute;e en l&#39;honneur de Balto dans Central Park, &agrave; New York, pour comm&eacute;morer leur incroyable exploit. Aujourd&#39;hui, Balto reste un symbole de courage et d&#39;endurance, rappelant au monde la force et la d&eacute;termination des chiens de tra&icirc;neau qui ont sauv&eacute; Nome de l&#39;&eacute;pid&eacute;mie mortelle.</p>', 'default.jpg', 'balto-chien-sauveur', 'STATE_APPROUVED', '2023-06-13 19:09:05', '2023-07-17 21:03:20'),
(61, 1, 3, 'Un hommage à ces compagnons', '<p>Dans ces moments de profonde tristesse, je veux partager une histoire réconfortante pour toi, qui viens de perdre ton cher compagnon &agrave; quatre pattes.</p>\r\n\r\n<p>Il y avait une fois un petit chien nomm&eacute; Peki, qui avait apport&eacute; tant de joie et d&#39;amour &agrave; sa famille. Max &eacute;tait un v&eacute;ritable rayon de soleil, toujours pr&ecirc;t &agrave; offrir un c&acirc;lin r&eacute;confortant ou &agrave; jouer avec une &eacute;nergie d&eacute;bordante.</p>\r\n\r\n<p>Un jour, alors que Peki vieillissait, il devint malade et sa famille dut prendre la difficile d&eacute;cision de le laisser partir. Leur chagrin &eacute;tait immense, et chaque coin de la maison semblait vide sans sa pr&eacute;sence joyeuse.</p>\r\n\r\n<p>Mais quelque chose de merveilleux se produisit : les souvenirs de Max commenc&egrave;rent &agrave; remplir les espaces vides. Sa famille se rappela les moments de bonheur partag&eacute;s, les balades en plein air, les c&acirc;lins chaleureux et les doux regards complices.</p>\r\n\r\n<p>Peu &agrave; peu, la tristesse se m&ecirc;la &agrave; la gratitude pour avoir eu la chance de conna&icirc;tre un &ecirc;tre si sp&eacute;cial. Les larmes laiss&egrave;rent place &agrave; des sourires m&eacute;lancoliques, et le souvenir de Peki devint une source d&#39;inspiration.</p>\r\n\r\n<p>Dans chaque &eacute;clat de soleil qui caressait leur visage, ils voyaient le rappel de l&#39;amour infini de Peki. Et &agrave; chaque fois qu&#39;ils croisaient un chien heureux dans la rue, ils savaient que l&#39;esprit joueur et aimant de Max continuait de briller &agrave; travers chaque animal.</p>\r\n\r\n<p>Peki restera &agrave; jamais dans leur c&oelig;ur, car l&#39;amour qu&#39;ils ont partag&eacute; &eacute;tait si profond qu&#39;il transcende le temps et l&#39;espace. Et m&ecirc;me s&#39;il n&#39;est plus physiquement pr&eacute;sent, son h&eacute;ritage d&#39;amour et de joie perdure, apportant réconfort et douceur dans les moments difficiles.</p>', 'default.jpg', 'un-hommage-a-ces-compagnons', 'STATE_APPROUVED', '2023-06-13 19:15:11', '2023-07-17 21:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `user_source` int NOT NULL,
  `user_target` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorie_animal`
--

CREATE TABLE `categorie_animal` (
  `id` int NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie_animal`
--

INSERT INTO `categorie_animal` (`id`, `nom`) VALUES
(1, 'Chiens'),
(2, 'Chats'),
(3, 'Nac');

-- --------------------------------------------------------

--
-- Table structure for table `comment_belle_histoire`
--

CREATE TABLE `comment_belle_histoire` (
  `id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `belle_histoire_id` int NOT NULL,
  `texte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_belle_histoire`
--

INSERT INTO `comment_belle_histoire` (`id`, `auteur_id`, `belle_histoire_id`, `texte`, `date_creation`) VALUES
(1, NULL, 56, 'Quel Max adorable', '2023-06-28 09:05:38'),
(10, 108, 58, '<p>Je ne connaissais pas cette histoire, ce brave toutou m&eacute;riterait plus d&#39;attention, bravo &agrave; lui !<img alt=\"angel\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/angel_smile.png\" title=\"angel\" width=\"23\" /></p>', '2023-07-04 08:34:39'),
(22, 56, 61, '<p>Tr&egrave;s belle histoire&nbsp;<img alt=\"angel\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/angel_smile.png\" title=\"angel\" width=\"23\" /></p>\r\n', '2023-07-17 20:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_belle_histoire_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`comment_belle_histoire_id`, `user_id`) VALUES
(1, 57),
(22, 116);

-- --------------------------------------------------------

--
-- Table structure for table `condoleance`
--

CREATE TABLE `condoleance` (
  `id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `memorial_id` int NOT NULL,
  `texte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `condoleance`
--

INSERT INTO `condoleance` (`id`, `auteur_id`, `memorial_id`, `texte`, `date_creation`) VALUES
(206, 1, 82, '<p>&lt;script&gt;alert(&quot;faille XSS&quot;);&lt;/script&gt;</p>', '2023-06-22 11:39:31'),
(207, NULL, 106, 'Pauuvre Bill, sincères condoléances', '2023-06-28 09:24:08'),
(224, 1, 106, '<p><img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-06-29 08:02:01'),
(227, 116, 106, '<p>Bill avait l&#39;air d&#39;&ecirc;tre un compagnon attachant, toutes mes pens&eacute;es vont &agrave; vous et lui&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-07-02 20:21:18'),
(228, 113, 106, '<p>Je connaissais bien ce cher Bill, il venait souvent &agrave; notre maison chercher de la charcuterie &agrave; manger, c&#39;&eacute;tait dr&ocirc;le de le voir venir, cela manque&nbsp;</p>', '2023-07-04 08:00:08'),
(229, 108, 93, '<p>Sinc&egrave;res condol&eacute;ances, Zephrya avait l&#39;air adorable&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-07-04 08:36:22'),
(249, 116, 108, '<p><img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" /></p>', '2023-07-18 12:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `favoris_user`
--

CREATE TABLE `favoris_user` (
  `belle_histoire_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favoris_user`
--

INSERT INTO `favoris_user` (`belle_histoire_id`, `user_id`) VALUES
(56, 1),
(57, 57),
(57, 116),
(58, 108),
(61, 116);

-- --------------------------------------------------------

--
-- Table structure for table `genre_histoire`
--

CREATE TABLE `genre_histoire` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genre_histoire`
--

INSERT INTO `genre_histoire` (`id`, `nom`) VALUES
(1, 'Fiction'),
(2, 'Histoire vraie'),
(3, 'Hommage');

-- --------------------------------------------------------

--
-- Table structure for table `histoire_likes`
--

CREATE TABLE `histoire_likes` (
  `belle_histoire_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histoire_likes`
--

INSERT INTO `histoire_likes` (`belle_histoire_id`, `user_id`) VALUES
(56, 1),
(57, 57),
(57, 116),
(58, 108),
(58, 113),
(61, 116);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `expediteur_id` int DEFAULT NULL,
  `destinataire_id` int DEFAULT NULL,
  `texte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `is_signaled` tinyint(1) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `expediteur_id`, `destinataire_id`, `texte`, `is_read`, `is_signaled`, `date_creation`) VALUES
(2, NULL, NULL, 'Je suis un autre message signalé de l\'expediteur 100', 1, 0, '2023-05-06 11:37:35'),
(3, NULL, 1, 'Bonjour marianne j\'espère que vous allez bien en cette belle soirée de printemps', 1, 1, '2023-05-18 19:30:54'),
(4, 1, NULL, '<p>Bonsoir Anouk, oui tout va bien, j&#39;esp&egrave;re que pour vous c&#39;est aussi le cas</p>', 1, 0, '2023-05-18 17:31:47'),
(18, 1, NULL, '<p>Bonjour&nbsp;<img alt=\"smiley\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/regular_smile.png\" title=\"smiley\" width=\"23\" /></p>', 0, 0, '2023-06-06 08:05:20'),
(19, 1, NULL, '<p><img alt=\"yes\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/thumbs_up.png\" title=\"yes\" width=\"23\" /></p>', 1, 0, '2023-06-06 13:17:08'),
(20, NULL, 1, '<p>test de la personne bloqu&eacute;e</p>', 1, 0, '2023-06-12 07:38:42'),
(21, NULL, 1, '<p>eee</p>', 1, 0, '2023-06-12 07:45:38'),
(22, 113, 1, '<p>coucou</p>\r\n\r\n<p>&nbsp;</p>', 1, 0, '2023-06-18 17:26:15'),
(23, 1, 113, '<p>Coucou Valentin<img alt=\"laugh\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/teeth_smile.png\" title=\"laugh\" width=\"23\" /></p>', 0, 0, '2023-06-25 09:41:08'),
(24, 119, 1, '<p>Bonjour</p>', 0, 0, '2023-07-05 08:14:52'),
(26, 116, 1, '<p>Bonsoir Marianne&nbsp;<img alt=\"smiley\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/regular_smile.png\" title=\"smiley\" width=\"23\" /></p>', 0, 0, '2023-07-17 18:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mot_commemoration`
--

CREATE TABLE `mot_commemoration` (
  `id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `mot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mot_commemoration`
--

INSERT INTO `mot_commemoration` (`id`, `auteur_id`, `mot`, `date_creation`) VALUES
(7, 1, '<p>Dans les cieux &eacute;toil&eacute;s, ils reposent en paix, Les animaux ch&eacute;ris, partis &agrave; jamais. Leurs &acirc;mes brillantes, dans nos c&oelig;urs subsistent, Leur amour infini, jamais ne s&#39;&eacute;teint. &Agrave; jamais grav&eacute;s, dans nos souvenirs intacts.</p>', '2023-06-14 09:34:24'),
(8, 1, '<p>Dans les cieux &eacute;toil&eacute;s, vos &acirc;mes brillent, Silencieux t&eacute;moins de nos vies &eacute;vanouies. Vous avez dans&eacute; sur Terre, libres et sereins, Maintenant, vous reposez au-del&agrave; de nos mains. Dans nos c&oelig;urs, vos souvenirs, &eacute;ternels compagnons.</p>', '2023-06-14 09:34:48'),
(9, 1, '<p>En hommage &agrave; tous les animaux d&eacute;c&eacute;d&eacute;s, nous rendons hommage &agrave; leur beaut&eacute;, leur innocence et leur amour inconditionnel. Leur pr&eacute;sence dans nos vies nous a enrichis et leurs souvenirs continuent de briller dans nos c&oelig;urs. Ils restent &agrave; jamais des compagnons fid&egrave;les, des &acirc;mes douces qui nous ont apport&eacute; joie et r&eacute;confort. Nous leur sommes reconnaissants pour les moments partag&eacute;s et nous les gardons vivants dans nos souvenirs les plus pr&eacute;cieux. &Agrave; tous les animaux qui ont travers&eacute; notre chemin, vous &ecirc;tes ch&eacute;ris et jamais oubli&eacute;s.</p>', '2023-06-14 09:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `id` int NOT NULL,
  `memorial_id` int NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `memorial_id`, `photo`) VALUES
(2, 106, 'bill2-64a1d84e31705.jpg'),
(3, 106, 'bill3-64a1d84e3687f.jpg'),
(4, 108, 'peki3-1-64a3cbe2764da.jpg'),
(5, 108, 'peki2-1-64a3cbe2848b6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `topic_id` int NOT NULL,
  `texte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `auteur_id`, `topic_id`, `texte`, `date_creation`) VALUES
(38, 105, 5, '<p>Chers membres du forum,</p>\r\n\r\n<p>Je vous invite aujourd&#39;hui &agrave; ouvrir votre c&oelig;ur et &agrave; partager vos rituels de deuil, vos fa&ccedil;ons uniques d&#39;honorer la m&eacute;moire de nos pr&eacute;cieux compagnons qui nous ont quitt&eacute;s. Que ce soit un animal de compagnie, un fid&egrave;le ami &agrave; plumes ou &agrave; &eacute;cailles, nous avons tous connu la douleur de perdre un &ecirc;tre cher.</p>\r\n\r\n<p>Partagez les traditions, les gestes symboliques ou les rituels que vous avez cr&eacute;&eacute;s pour rendre hommage &agrave; votre cher animal. Peut-&ecirc;tre que vous allumez une bougie sp&eacute;ciale chaque ann&eacute;e pour son anniversaire, que vous plantez un arbre en son honneur, ou que vous tenez un journal de souvenirs pour garder vivante sa pr&eacute;sence. Quelles que soient vos pratiques, elles sont pr&eacute;cieuses et peuvent inspirer et soutenir ceux qui traversent le deuil.</p>\r\n\r\n<p>Souvenons-nous ensemble de nos compagnons aim&eacute;s et cr&eacute;ons un espace d&#39;&eacute;change bienveillant o&ugrave; nous pourrons trouver du r&eacute;confort, des conseils et des id&eacute;es pour traverser cette p&eacute;riode difficile.</p>\r\n\r\n<p>Partagez vos histoires, vos rituels et vos conseils dans les commentaires ci-dessous. Ensemble, nous trouverons la force pour honorer nos animaux bien-aim&eacute;s et continuer &agrave; ch&eacute;rir leur souvenir.</p>', '2023-06-14 09:20:02'),
(39, 1, 6, '<p>Cher(e)s ami(e)s du forum,</p>\r\n\r\n<p>J&#39;ouvre ce topic pour nous permettre de partager nos exp&eacute;riences et de rendre hommage &agrave; nos animaux de compagnie qui nous ont quitt&eacute;s. Le deuil d&#39;un animal peut &ecirc;tre une exp&eacute;rience profond&eacute;ment &eacute;mouvante et douloureuse, mais il est important de se rappeler des merveilleux moments que nous avons partag&eacute;s avec eux.</p>\r\n\r\n<p>Je vous encourage &agrave; partager des histoires, des photos et m&ecirc;me des souvenirs sp&eacute;ciaux de votre animal bien-aim&eacute;. Racontez-nous comment votre animal de compagnie a enrichi votre vie, comment il vous a apport&eacute; du bonheur et de l&#39;amour inconditionnel. N&#39;h&eacute;sitez pas &agrave; exprimer vos sentiments de tristesse, de col&egrave;re ou de nostalgie, car nous sommes ici pour nous soutenir mutuellement.</p>\r\n\r\n<p>C&#39;est &eacute;galement un espace pour trouver du r&eacute;confort et des conseils dans le processus de deuil. Si vous avez des questions sur la mani&egrave;re de faire face &agrave; la perte de votre animal de compagnie, ou si vous cherchez des ressources pour traverser cette p&eacute;riode difficile, n&#39;h&eacute;sitez pas &agrave; les poser. Ensemble, nous pouvons partager nos exp&eacute;riences et apporter un soutien pr&eacute;cieux les uns aux autres.</p>\r\n\r\n<p>Rappelons-nous que nos animaux de compagnie ont occup&eacute; une place sp&eacute;ciale dans nos vies et que leur m&eacute;moire continuera &agrave; briller dans nos c&oelig;urs. Prendre le temps de se souvenir d&#39;eux et de c&eacute;l&eacute;brer leur vie est une &eacute;tape importante du processus de deuil.</p>\r\n\r\n<p>Partageons nos histoires, nos souvenirs et notre amour pour nos compagnons disparus, afin de rendre hommage &agrave; leur pr&eacute;cieuse pr&eacute;sence dans nos vies.</p>', '2023-06-14 09:21:29'),
(40, 108, 7, '<p>Chers membres, aujourd&#39;hui je cr&eacute;e ce topic pour exprimer et partager mes &eacute;motions, ma peine et ma gratitude suite &agrave; la perte de mon fid&egrave;le compagnon &agrave; quatre pattes. Cet animal a apport&eacute; tant de joie et d&#39;amour dans ma vie, et sa disparition laisse un vide immense. C&#39;est un endroit o&ugrave; je peux parler ouvertement de mon chagrin, partager les moments pr&eacute;cieux que nous avons v&eacute;cus ensemble et honorer sa m&eacute;moire. Je vous invite &agrave; vous joindre &agrave; moi, si vous le souhaitez, pour partager vos propres histoires de deuil, les souvenirs qui vous r&eacute;confortent et les gestes de reconnaissance que vous avez entrepris pour rendre hommage &agrave; votre animal. Ensemble, nous pouvons trouver du soutien, des conseils et du r&eacute;confort dans cette communaut&eacute; bienveillante qui comprend l&#39;importance d&#39;un animal de compagnie dans nos vies.</p>', '2023-06-14 09:24:08'),
(41, 1, 8, '<p>Chers membres, aujourd&#39;hui je souhaite partager mon exp&eacute;rience unique d&#39;adoption d&#39;un nouvel animal de compagnie apr&egrave;s avoir perdu mon pr&eacute;c&eacute;dent compagnon bien-aim&eacute;. Apr&egrave;s avoir travers&eacute; la peine et le deuil, j&#39;ai ressenti un vide dans ma vie sans la pr&eacute;sence d&#39;un animal &agrave; mes c&ocirc;t&eacute;s. J&#39;ai d&eacute;cid&eacute; de me lancer dans une nouvelle aventure en ouvrant mon c&oelig;ur et mon foyer &agrave; un nouvel ami &agrave; fourrure. Je vous invite &agrave; me rejoindre pour discuter de vos propres exp&eacute;riences d&#39;adoption apr&egrave;s une perte, partager les d&eacute;fis et les moments de joie que vous avez rencontr&eacute;s lors de cette transition, ainsi que les liens uniques que vous avez cr&eacute;&eacute;s avec votre nouvel animal. Ensemble, nous pouvons explorer les bienfaits de l&#39;adoption et trouver du soutien dans cette p&eacute;riode de renouveau et de connexion avec nos nouveaux compagnons. Bienvenue &agrave; tous et partageons nos histoires inspirantes de reconstruction et d&#39;amour retrouv&eacute; !&quot;</p>', '2023-06-14 09:25:15'),
(43, 1, 10, '<p>Chers membres, aujourd&#39;hui, je cr&eacute;e ce topic pour partager mon parcours de reconstruction physique et &eacute;motionnelle apr&egrave;s la perte de mon animal de compagnie bien-aim&eacute;. La perte d&#39;un &ecirc;tre cher peut laisser des traces profondes, tant sur le plan &eacute;motionnel que physique. J&#39;ai d&eacute;cid&eacute; de canaliser mon chagrin et ma tristesse en me concentrant sur ma propre sant&eacute; et mon bien-&ecirc;tre. Je vous invite &agrave; me rejoindre dans cette d&eacute;marche, o&ugrave; nous pouvons &eacute;changer nos exp&eacute;riences, conseils et motivations pour nous remettre en forme et retrouver l&#39;&eacute;quilibre. Que ce soit &agrave; travers l&#39;exercice physique, la pratique de la m&eacute;ditation, l&#39;adoption de nouvelles habitudes de vie saines, ou toute autre approche qui vous parle, partageons nos astuces et nos r&eacute;ussites pour avancer ensemble sur ce chemin de gu&eacute;rison. Ensemble, nous pouvons transformer notre douleur en force et honorer la m&eacute;moire de nos animaux en prenant soin de nous-m&ecirc;mes</p>', '2023-06-14 09:27:56'),
(52, 108, 5, '<p>Bonjour !&nbsp;</p>\r\n\r\n<p>C&#39;est un sujet int&eacute;ressant &agrave; aborder, il peut &ecirc;tre difficile de savoir comment honorer un &ecirc;tre perdu. Personnellement, apr&egrave;s avoir perdu ma petite Luna, je continue &agrave; lui dire &quot;bonne nuit&quot; &agrave; voix haute, car je suis persuad&eacute;e qu&#39;ils nous entendent du paradis&nbsp;<img alt=\"heart\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/heart.png\" title=\"heart\" width=\"23\" />&nbsp;Aussi, tous les matins, je vais &agrave; l&#39;endroit o&ugrave; elle cachait ses friandises.. pour en remettre. Finalement c&#39;est en perpetuant ses habitudes que je tiens le coup.</p>\r\n\r\n<p>Courage tout le monde, un jour nous reverons nos loulous&nbsp;<img alt=\"angel\" height=\"23\" src=\"http://localhost:8000/bundles/fosckeditor/plugins/smiley/images/angel_smile.png\" title=\"angel\" width=\"23\" /></p>', '2023-07-04 10:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `refuge`
--

CREATE TABLE `refuge` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refuge`
--

INSERT INTO `refuge` (`id`, `nom`, `numero`, `rue`, `ville`, `code_postal`, `departement`, `site`, `latitude`, `longitude`) VALUES
(2, 'Société Protectrice des animaux de Strasbourg (SPA)', '7', 'Rue de l\'Entenloch', 'Strasbourg', '67200', 'Bas-Rhin', 'https://www.spa-strasbourg.org/', '48.6003499', '7.7291577'),
(3, 'Association ERA', '1', 'Rue des Zouaves', 'Strasbourg', '67000', 'Bas-Rhin', 'https://www.assocera.com/', '48.5779403', '7.7577757'),
(4, 'Association 4newlife', '18', 'Rue de l\'Abbé Hanauer', 'Strasbourg', '67100', 'Bas-Rhin', 'https://association4newlife.org/', '48.5545597', '7.7517802'),
(5, 'Société Protectrice des animaux de Sarreguemines (SPA)', '100', 'Chemin du Bruchwies', 'Sarreguemines', '57200', 'Moselle', 'https://www.la-spa.fr/etablissement/refuge-spa-de-sarreguemines/?search=1&page=1&full=1&seed=undefined', '49.1101864', '7.1272298'),
(6, 'Société Protectrice des animaux de Sarrebourg (SPA)', NULL, 'Route de Réding', 'Sarrebourg', '57400', 'Moselle', 'https://www.spasarrebourg.com/', '48.7465961', '7.0813529'),
(7, 'Société Protectrice des animaux de Haguenau(SPA)', '111', 'Rte de Schirrhein', 'Haguenau', '67500', 'Bas-Rhin', 'https://spahaguenau.org/', '48.8165339', '7.8326723');

-- --------------------------------------------------------

--
-- Table structure for table `report_comment`
--

CREATE TABLE `report_comment` (
  `id` int NOT NULL,
  `commentaire_id` int NOT NULL,
  `signaleur_id` int NOT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_comment`
--

INSERT INTO `report_comment` (`id`, `commentaire_id`, `signaleur_id`, `date_creation`) VALUES
(8, 22, 116, '2023-07-18 12:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `report_condoleance`
--

CREATE TABLE `report_condoleance` (
  `id` int NOT NULL,
  `condoleance_id` int NOT NULL,
  `signaleur_id` int NOT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_histoire`
--

CREATE TABLE `report_histoire` (
  `id` int NOT NULL,
  `histoire_id` int NOT NULL,
  `signaleur_id` int NOT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_memorial`
--

CREATE TABLE `report_memorial` (
  `id` int NOT NULL,
  `memorial_id` int NOT NULL,
  `signaleur_id` int NOT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_mot`
--

CREATE TABLE `report_mot` (
  `id` int NOT NULL,
  `mot_id` int NOT NULL,
  `signaleur_id` int NOT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_post`
--

CREATE TABLE `report_post` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `signaleur_id` int NOT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_topic`
--

CREATE TABLE `report_topic` (
  `id` int NOT NULL,
  `topic_id` int NOT NULL,
  `signaleur_id` int NOT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_topic`
--

INSERT INTO `report_topic` (`id`, `topic_id`, `signaleur_id`, `date_creation`) VALUES
(1, 10, 116, '2023-07-17 18:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `verrouillage` tinyint(1) NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `auteur_id`, `titre`, `verrouillage`, `slug`, `date_creation`) VALUES
(5, 105, 'Honorer la mémoire de mon cher compagnon : partagez vos rituels de deuil', 0, 'honorer-la-memoire-de-mon-cher-compagnon-partagez-vos-rituels-de-deuil', '2023-06-14 09:20:02'),
(6, 1, 'Célébrons la mémoire de nos compagnons bien-aimés', 0, 'celebrons-la-memoire-de-nos-compagnons-bien-aimes', '2023-06-14 09:21:29'),
(7, 108, 'Mon compagnon à jamais dans mon cœur : partager mon deuil et ma gratitude', 0, 'mon-compagnon-a-jamais-dans-mon-coeur-partager-mon-deuil-et-ma-gratitude', '2023-06-14 09:24:08'),
(8, 1, 'Une nouvelle aventure, un nouvel amour : l\'adoption d\'un animal après la perte d\'un compagnon fidèle', 0, 'une-nouvelle-aventure-un-nouvel-amour-l-adoption-d-un-animal-apres-la-perte-d-un-compagnon-fidele', '2023-06-14 09:25:15'),
(10, 1, 'Renaître en mouvement : retrouver la forme physique et émotionnelle après la perte de mon animal de compagnie', 0, 'renaitre-en-mouvement-retrouver-la-forme-physique-et-emotionnelle-apres-la-perte-de-mon-animal-de-compagnie', '2023-06-14 09:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bannir` tinyint(1) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`, `photo`, `bannir`, `is_verified`, `date_inscription`) VALUES
(1, 'marianne@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$plQRhBOnkQepDB3SXMAUa.7xS.tv5z8x7HpeVL3WhO3M1wzoy/T9C', 'Marianne', 'default.jpg', 0, 1, '2023-04-27 10:18:15'),
(2, 'valentin@gmail.com', '[\"ROLE_MODERATEUR_HISTOIRES\"]', '$2y$13$0aWfu1QQoTM0mb9mDSneUOIVQaLvBHo5IJMwIPifDfp9qr9mAaNsW', 'Valentin67', 'default.jpg', 0, 1, '2023-04-27 10:18:36'),
(53, 'patrick30@orange.fr', '[\"ROLE_USER\"]', '$2y$13$1G7GHaYjY4WOehPf6qyYO.XrmkPrcMizFXTksg2wF7dBRF6Qobv8a', 'Alain', 'default.jpg', 0, 1, '2023-04-27 10:28:33'),
(54, 'gregoire.francois@millet.net', '[\"ROLE_MODERATEUR_MEMORIAUX\"]', '$2y$13$JH8rhbmD2aGcBe3T8jieh.7UGEkwyiMJsE2uiM5IwD.xkEKVJcjrC', 'Eugène', 'default.jpg', 0, 0, '2023-04-27 10:28:33'),
(55, 'gaudin.emmanuelle@tele2.fr', '[\"ROLE_MODERATEUR_FORUM\"]', '$2y$13$xA9nqwd7UOmzOc/4r/fGT.hStBK1aaHHyRYwQJ9wip0Ogy6DHQ8FS', 'Daniel', 'default.jpg', 0, 1, '2023-04-27 10:28:34'),
(56, 'imarchand@club-internet.fr', '[\"ROLE_MODERATEUR_COMMEMORATION\"]', '$2y$13$Iq4DMzzR6kpUaccUcFmkD.Nafv..jQcXHe1Rwek4vCndcfUZeBhMK', 'Antoine', 'default.jpg', 0, 1, '2023-04-27 10:28:34'),
(57, 'sebastien34@louis.fr', '[\"ROLE_USER\"]', '$2y$13$m2UmUGCXsQctZbNMuCgJs.R/FQUopnni.lOZFifrJ.JoNUGXFouzC', 'Emmanuelle', 'default.jpg', 0, 0, '2023-04-27 10:28:34'),
(104, 'thomas@gmail.com', '[\"ROLE_USER\"]', '$2y$13$kFTxBe8yCuUuI.tCHcI0GeOrc0j/SQVCTbggPUZPcQlitHT8oUPRC', 'Thomas', 'default.jpg', 0, 1, '2023-06-12 08:03:09'),
(105, 'michel@gmail.com', '[\"ROLE_USER\"]', '$2y$13$2jBaZTK/iLFnm6is9c1cteE0PWu6/anZuw1Lwz/UPjn9Mc0HRAU7.', 'Michel', 'default.jpg', 0, 1, '2023-06-12 08:03:46'),
(106, 'olivier@gmail.com', '[\"ROLE_USER\"]', '$2y$13$TuZDcJs4ood/mOZX0FaVc.Q1G..62GkPXDHd5ouk6M8uEa2nzHfCy', 'Olivier', 'default.jpg', 0, 1, '2023-06-12 08:05:06'),
(108, 'jessie@gmail.com', '[\"ROLE_USER\"]', '$2y$13$xio8TAUAjH6NDmb3znUZ2eb1eOd/R8SZfpl8KBPLN9KkvfIGLzLl6', 'Jessie', 'default.jpg', 0, 1, '2023-06-12 09:50:07'),
(113, 'valentintin@gmail.com', '[\"ROLE_USER\"]', '$2y$13$qiCMri3rjRUjgCsqWvCu2ezfIPEQi.vuioB0OhHHvPlSZrTy268nq', 'Valentin', 'default.jpg', 0, 1, '2023-06-18 17:16:51'),
(115, 'stephane@gmail.com', '[\"ROLE_USER\"]', '$2y$13$MheY1bFyZu5DChHakyDgbOROI.bdaT6IGI/Z79eb1V4SBQMbrBPfa', 'Stéphane', 'default.jpg', 0, 1, '2023-07-02 20:06:19'),
(116, 'marine@gmail.com', '[\"ROLE_USER\"]', '$2y$13$cHkAJNuBXmrAVpDyVcv5a.OO183rXjanTAclqg/yb/QPgaD8p4TU.', 'Marine', 'default.jpg', 0, 1, '2023-07-02 20:14:00'),
(119, 'amandine@gmail.com', '[\"ROLE_USER\"]', '$2y$13$1odLwUceziv.pkaw86t0.OCgBwYt1Tce0IgR/yW9Gjgja1GncYO.O', 'Amandine', 'default.jpg', 0, 0, '2023-07-05 07:32:24'),
(120, 'maya@gmail.com', '[\"ROLE_USER\"]', '$2y$13$UN63s99Sl5E2xcTlKtj4euVi3vGHI0/5O3gR9Q4I5thzVX/H7Sfde', 'maya', 'default.jpg', 0, 0, '2023-12-05 22:48:05'),
(121, 'mayaa@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$guUoDVaWCbvcZ/s25ob/du4xNTJWWFqXixYYnga1qGqu3VYKHUDHi', 'mayanou', 'default.jpg', 0, 0, '2023-12-05 22:49:26');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_pseudo_mail`
-- (See below for the actual view)
--
CREATE TABLE `user_pseudo_mail` (
`email` varchar(180)
,`pseudo` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `user_pseudo_mail`
--
DROP TABLE IF EXISTS `user_pseudo_mail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_pseudo_mail`  AS SELECT `user`.`email` AS `email`, `user`.`pseudo` AS `pseudo` FROM `user``user`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal_memorial`
--
ALTER TABLE `animal_memorial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_201B1CA923C92311` (`categorie_animal_id`),
  ADD KEY `IDX_201B1CA960BB6FE6` (`auteur_id`);

--
-- Indexes for table `animal_memorial_user`
--
ALTER TABLE `animal_memorial_user`
  ADD PRIMARY KEY (`animal_memorial_id`,`user_id`),
  ADD KEY `IDX_32B9DBA1DCFA374E` (`animal_memorial_id`),
  ADD KEY `IDX_32B9DBA1A76ED395` (`user_id`);

--
-- Indexes for table `belle_histoire`
--
ALTER TABLE `belle_histoire`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_DA312DEAFF7747B4` (`titre`),
  ADD UNIQUE KEY `UNIQ_DA312DEA989D9B62` (`slug`),
  ADD KEY `IDX_DA312DEA60BB6FE6` (`auteur_id`),
  ADD KEY `IDX_DA312DEA4296D31F` (`genre_id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`user_source`,`user_target`),
  ADD KEY `IDX_A3C2E4153AD8644E` (`user_source`),
  ADD KEY `IDX_A3C2E415233D34C1` (`user_target`);

--
-- Indexes for table `categorie_animal`
--
ALTER TABLE `categorie_animal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_belle_histoire`
--
ALTER TABLE `comment_belle_histoire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D2723C2360BB6FE6` (`auteur_id`),
  ADD KEY `IDX_D2723C23B3C0CA49` (`belle_histoire_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`comment_belle_histoire_id`,`user_id`),
  ADD KEY `IDX_E050D68C91B254B4` (`comment_belle_histoire_id`),
  ADD KEY `IDX_E050D68CA76ED395` (`user_id`);

--
-- Indexes for table `condoleance`
--
ALTER TABLE `condoleance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A39C3AB060BB6FE6` (`auteur_id`),
  ADD KEY `IDX_A39C3AB07B40E4F7` (`memorial_id`);

--
-- Indexes for table `favoris_user`
--
ALTER TABLE `favoris_user`
  ADD PRIMARY KEY (`belle_histoire_id`,`user_id`),
  ADD KEY `IDX_3E144C2EB3C0CA49` (`belle_histoire_id`),
  ADD KEY `IDX_3E144C2EA76ED395` (`user_id`);

--
-- Indexes for table `genre_histoire`
--
ALTER TABLE `genre_histoire`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histoire_likes`
--
ALTER TABLE `histoire_likes`
  ADD PRIMARY KEY (`belle_histoire_id`,`user_id`),
  ADD KEY `IDX_6F91D4F4B3C0CA49` (`belle_histoire_id`),
  ADD KEY `IDX_6F91D4F4A76ED395` (`user_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307F10335F61` (`expediteur_id`),
  ADD KEY `IDX_B6BD307FA4F84F6E` (`destinataire_id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `mot_commemoration`
--
ALTER TABLE `mot_commemoration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9D6E7D4760BB6FE6` (`auteur_id`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_14B784187B40E4F7` (`memorial_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8D60BB6FE6` (`auteur_id`),
  ADD KEY `IDX_5A8A6C8D1F55203D` (`topic_id`);

--
-- Indexes for table `refuge`
--
ALTER TABLE `refuge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_comment`
--
ALTER TABLE `report_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F4ED2F6CBA9CD190` (`commentaire_id`),
  ADD KEY `IDX_F4ED2F6CC5687B3E` (`signaleur_id`);

--
-- Indexes for table `report_condoleance`
--
ALTER TABLE `report_condoleance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_128491B87F0F3A95` (`condoleance_id`),
  ADD KEY `IDX_128491B8C5687B3E` (`signaleur_id`);

--
-- Indexes for table `report_histoire`
--
ALTER TABLE `report_histoire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD1454159B94373` (`histoire_id`),
  ADD KEY `IDX_FD145415C5687B3E` (`signaleur_id`);

--
-- Indexes for table `report_memorial`
--
ALTER TABLE `report_memorial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E6F883097B40E4F7` (`memorial_id`),
  ADD KEY `IDX_E6F88309C5687B3E` (`signaleur_id`);

--
-- Indexes for table `report_mot`
--
ALTER TABLE `report_mot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FAB83BAB63977652` (`mot_id`),
  ADD KEY `IDX_FAB83BABC5687B3E` (`signaleur_id`);

--
-- Indexes for table `report_post`
--
ALTER TABLE `report_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A681764B89032C` (`post_id`),
  ADD KEY `IDX_29A68176C5687B3E` (`signaleur_id`);

--
-- Indexes for table `report_topic`
--
ALTER TABLE `report_topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B75CD9621F55203D` (`topic_id`),
  ADD KEY `IDX_B75CD962C5687B3E` (`signaleur_id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9D40DE1BFF7747B4` (`titre`),
  ADD UNIQUE KEY `UNIQ_9D40DE1B989D9B62` (`slug`),
  ADD KEY `IDX_9D40DE1B60BB6FE6` (`auteur_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D64986CC499D` (`pseudo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animal_memorial`
--
ALTER TABLE `animal_memorial`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `belle_histoire`
--
ALTER TABLE `belle_histoire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `categorie_animal`
--
ALTER TABLE `categorie_animal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment_belle_histoire`
--
ALTER TABLE `comment_belle_histoire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `condoleance`
--
ALTER TABLE `condoleance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `genre_histoire`
--
ALTER TABLE `genre_histoire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mot_commemoration`
--
ALTER TABLE `mot_commemoration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `refuge`
--
ALTER TABLE `refuge`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `report_comment`
--
ALTER TABLE `report_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `report_condoleance`
--
ALTER TABLE `report_condoleance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `report_histoire`
--
ALTER TABLE `report_histoire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `report_memorial`
--
ALTER TABLE `report_memorial`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `report_mot`
--
ALTER TABLE `report_mot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `report_post`
--
ALTER TABLE `report_post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report_topic`
--
ALTER TABLE `report_topic`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animal_memorial`
--
ALTER TABLE `animal_memorial`
  ADD CONSTRAINT `FK_201B1CA923C92311` FOREIGN KEY (`categorie_animal_id`) REFERENCES `categorie_animal` (`id`),
  ADD CONSTRAINT `FK_201B1CA960BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `animal_memorial_user`
--
ALTER TABLE `animal_memorial_user`
  ADD CONSTRAINT `FK_32B9DBA1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_32B9DBA1DCFA374E` FOREIGN KEY (`animal_memorial_id`) REFERENCES `animal_memorial` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `belle_histoire`
--
ALTER TABLE `belle_histoire`
  ADD CONSTRAINT `FK_DA312DEA4296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre_histoire` (`id`),
  ADD CONSTRAINT `FK_DA312DEA60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD CONSTRAINT `FK_A3C2E415233D34C1` FOREIGN KEY (`user_target`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A3C2E4153AD8644E` FOREIGN KEY (`user_source`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_belle_histoire`
--
ALTER TABLE `comment_belle_histoire`
  ADD CONSTRAINT `FK_D2723C2360BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_D2723C23B3C0CA49` FOREIGN KEY (`belle_histoire_id`) REFERENCES `belle_histoire` (`id`);

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `FK_E050D68C91B254B4` FOREIGN KEY (`comment_belle_histoire_id`) REFERENCES `comment_belle_histoire` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E050D68CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `condoleance`
--
ALTER TABLE `condoleance`
  ADD CONSTRAINT `FK_A39C3AB060BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_A39C3AB07B40E4F7` FOREIGN KEY (`memorial_id`) REFERENCES `animal_memorial` (`id`);

--
-- Constraints for table `favoris_user`
--
ALTER TABLE `favoris_user`
  ADD CONSTRAINT `FK_3E144C2EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3E144C2EB3C0CA49` FOREIGN KEY (`belle_histoire_id`) REFERENCES `belle_histoire` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `histoire_likes`
--
ALTER TABLE `histoire_likes`
  ADD CONSTRAINT `FK_6F91D4F4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6F91D4F4B3C0CA49` FOREIGN KEY (`belle_histoire_id`) REFERENCES `belle_histoire` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307F10335F61` FOREIGN KEY (`expediteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_B6BD307FA4F84F6E` FOREIGN KEY (`destinataire_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mot_commemoration`
--
ALTER TABLE `mot_commemoration`
  ADD CONSTRAINT `FK_9D6E7D4760BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_14B784187B40E4F7` FOREIGN KEY (`memorial_id`) REFERENCES `animal_memorial` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  ADD CONSTRAINT `FK_5A8A6C8D60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `report_comment`
--
ALTER TABLE `report_comment`
  ADD CONSTRAINT `FK_F4ED2F6CBA9CD190` FOREIGN KEY (`commentaire_id`) REFERENCES `comment_belle_histoire` (`id`),
  ADD CONSTRAINT `FK_F4ED2F6CC5687B3E` FOREIGN KEY (`signaleur_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report_condoleance`
--
ALTER TABLE `report_condoleance`
  ADD CONSTRAINT `FK_128491B87F0F3A95` FOREIGN KEY (`condoleance_id`) REFERENCES `condoleance` (`id`),
  ADD CONSTRAINT `FK_128491B8C5687B3E` FOREIGN KEY (`signaleur_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report_histoire`
--
ALTER TABLE `report_histoire`
  ADD CONSTRAINT `FK_FD1454159B94373` FOREIGN KEY (`histoire_id`) REFERENCES `belle_histoire` (`id`),
  ADD CONSTRAINT `FK_FD145415C5687B3E` FOREIGN KEY (`signaleur_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report_memorial`
--
ALTER TABLE `report_memorial`
  ADD CONSTRAINT `FK_E6F883097B40E4F7` FOREIGN KEY (`memorial_id`) REFERENCES `animal_memorial` (`id`),
  ADD CONSTRAINT `FK_E6F88309C5687B3E` FOREIGN KEY (`signaleur_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report_mot`
--
ALTER TABLE `report_mot`
  ADD CONSTRAINT `FK_FAB83BAB63977652` FOREIGN KEY (`mot_id`) REFERENCES `mot_commemoration` (`id`),
  ADD CONSTRAINT `FK_FAB83BABC5687B3E` FOREIGN KEY (`signaleur_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report_post`
--
ALTER TABLE `report_post`
  ADD CONSTRAINT `FK_29A681764B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_29A68176C5687B3E` FOREIGN KEY (`signaleur_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report_topic`
--
ALTER TABLE `report_topic`
  ADD CONSTRAINT `FK_B75CD9621F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  ADD CONSTRAINT `FK_B75CD962C5687B3E` FOREIGN KEY (`signaleur_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_9D40DE1B60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
