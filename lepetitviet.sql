-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 19 oct. 2021 à 20:02
-- Version du serveur : 5.7.33
-- Version de PHP : 8.0.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lepetitviet`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Actualités'),
(2, 'Promotions');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `image`) VALUES
(3, 'Plat', 'plat', 'o.jpg'),
(4, 'Entrée', 'entree', 'nem.png'),
(5, 'Dessert', 'dessert', 'coco.jpeg'),
(6, 'Bubble Tea', 'bubbletea', 'bbtea.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210923083607', '2021-09-23 08:36:24', 683),
('DoctrineMigrations\\Version20210923090605', '2021-09-23 09:06:11', 56),
('DoctrineMigrations\\Version20210923100945', '2021-09-23 10:15:04', 273),
('DoctrineMigrations\\Version20210923110819', '2021-09-23 11:08:23', 287),
('DoctrineMigrations\\Version20210923111631', '2021-09-23 11:16:35', 234),
('DoctrineMigrations\\Version20210923202817', '2021-09-23 20:28:37', 145),
('DoctrineMigrations\\Version20210923211034', '2021-09-24 09:30:10', 294),
('DoctrineMigrations\\Version20210923211100', '2021-09-24 09:30:11', 43),
('DoctrineMigrations\\Version20210924091017', '2021-09-24 09:30:11', 36),
('DoctrineMigrations\\Version20210924093852', '2021-09-24 09:38:59', 216),
('DoctrineMigrations\\Version20210924094331', '2021-09-24 09:44:36', 305),
('DoctrineMigrations\\Version20210924095004', '2021-09-24 09:50:16', 235),
('DoctrineMigrations\\Version20210924095559', '2021-09-24 10:22:45', 43),
('DoctrineMigrations\\Version20210927110449', '2021-09-27 11:04:57', 278),
('DoctrineMigrations\\Version20210928084703', '2021-09-28 08:47:15', 360),
('DoctrineMigrations\\Version20210928124309', '2021-09-28 12:43:27', 501),
('DoctrineMigrations\\Version20211007062406', '2021-10-07 06:24:20', 437),
('DoctrineMigrations\\Version20211007064423', '2021-10-07 06:44:28', 143),
('DoctrineMigrations\\Version20211007075331', '2021-10-07 07:53:38', 751),
('DoctrineMigrations\\Version20211007135137', '2021-10-07 13:51:46', 321),
('DoctrineMigrations\\Version20211008124746', '2021-10-08 12:47:54', 290),
('DoctrineMigrations\\Version20211011093554', '2021-10-11 09:35:58', 267),
('DoctrineMigrations\\Version20211011114209', '2021-10-11 11:42:13', 149),
('DoctrineMigrations\\Version20211011182127', '2021-10-11 18:21:32', 698),
('DoctrineMigrations\\Version20211016214854', '2021-10-16 21:49:14', 315),
('DoctrineMigrations\\Version20211017132048', '2021-10-17 13:20:55', 344);

-- --------------------------------------------------------

--
-- Structure de la table `news_letters`
--

DROP TABLE IF EXISTS `news_letters`;
CREATE TABLE `news_letters` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `is_sent` tinyint(1) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `news_letters`
--

INSERT INTO `news_letters` (`id`, `categories_id`, `name`, `created_at`, `is_sent`, `content`) VALUES
(5, 1, 'Ouverture du site internet', '2021-09-24 10:46:30', 1, '<h2><strong>coucou</strong></h2><p><strong>ceci est un test de la premiere newsletter</strong></p><p><strong>ouverture du site en octobre soyez prêts !!</strong></p>'),
(6, 1, 'le restaurant le petit vietnamien', '2021-10-13 13:00:33', 1, '<p>bonjour,&nbsp;</p><p>promotion du tonnere un pho acheté, un pho offert venez vite !!!</p>'),
(7, 1, 'le petit vietnamien', '2021-10-13 14:05:40', 1, '<p>bonjour,</p><p>un bubble tea acheté un gratuit, venez vite !</p>'),
(9, 2, 'test2', '2021-10-13 14:07:30', 1, '<p>test2</p>'),
(10, 1, 'Admin', '2021-10-16 15:25:37', 1, '<p>Bonjour ceci est un test&nbsp;</p>');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `amount`, `status`, `reference`, `user_id`, `created_at`, `stripe_session_id`) VALUES
(199, 6, 0, '191021-616f22b788fee8.72794196', 6, '2021-10-19 19:55:35', NULL),
(200, 5, 1, '191021-616f2321c75b39.66647713', 3, '2021-10-19 19:57:21', 'cs_test_a1nIhFNk1dHlEC2dj7m7Aejg7yWvBo7Vg2tLMLprKcmNPqQG91VnXxztj2');

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `user_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`id`, `user_order_id`, `product_id`, `quantity`) VALUES
(285, 199, 11, 3),
(286, 200, 15, 1);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `publish_at` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `user_id`, `name`, `content`, `created_at`, `updated_at`, `publish_at`, `image`) VALUES
(6, 3, 'ouverture du site', '<p>merci de votre fidelité nous vous souhaitons une bonne visite sur notre site !</p>', '2021-10-07 09:00:15', NULL, NULL, NULL),
(8, 3, 'Bonjour', '<p>Bienvenue sur mon site</p>', '2021-10-11 19:23:26', NULL, NULL, NULL),
(12, 3, 'Fermeture du restaurant', '<p>Nous fermons le restaurant du lundi 18 octobre au 21 octobre 2021, toutes nos excuses !</p><p>A bientôt !</p>', '2021-10-16 18:45:07', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` tinyint(1) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `reference` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `slug` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `stock`, `price`, `quantity`, `reference`, `image`, `created_at`, `deleted_at`, `updated_at`, `description`, `user_id`, `categorie_id`, `slug`) VALUES
(8, 'Petit Bubble tea au thé matcha', 1, 5, 0, '100-1', 'matcha-616cc166289267.91168116.jpg', '2021-09-27 10:13:38', '2021-09-27 10:13:38', '2021-09-27 10:13:38', 'Boisson fraîche lacté accompagné de bille de tapioca.', 3, 6, 'Petit-Bubble-tea-au-the-matcha'),
(9, 'Mi Xao', 1, 10, 0, '111-2', 'mixao-616b4810e03bf1.48827179.jpg', '2021-09-27 10:11:47', '2021-09-27 10:11:47', '2021-09-27 10:11:47', 'Nouilles sautées ou croustillantes, servi avec une viande au choix avec légumes sautés et garniture au choix.\r\n\r\nnems', 3, 3, 'Mi-Xao'),
(10, 'bo bun', 1, 10, 0, '10-01', 'bobun-616cc176db8200.10696882.jpg', '2021-09-27 10:09:02', '2021-09-27 10:09:02', '2021-09-27 10:09:02', 'vermicelle\r\nnems\r\nlegumes au choix', 3, 3, 'bo-bun'),
(11, 'Nems au poulet', 1, 2, 0, '12-01', 'nempoulet-616f23023f2304.21806467.jpg', '2021-09-27 10:10:29', '2021-09-27 10:10:29', '2021-09-27 10:10:29', 'Faite de pâte de riz frit avec du poulet halal', 3, 4, 'Nems-au-poulet'),
(12, 'Nems au boeuf', 1, 2, 0, '11-02', 'nem-616cc19d580828.25214639.jpg', '2021-09-27 10:11:11', '2021-09-27 10:11:11', '2021-09-27 10:11:11', 'Nems viande au boeuf', 3, 4, 'Nems-au-boeuf'),
(13, 'Perle de coco', 1, 3, 0, '13-01', 'perles-de-coco-616cc1a9c0a3b2.60269740.jpg', '2021-09-27 10:16:06', '2021-09-27 10:16:06', '2021-09-27 10:16:06', 'Dessert savoureux à la coco, fondant à l\'interieur, fait de farine de tapioca pour son onctuosité à l\'exterieur et à l\'interieur une cacaouette.', 3, 5, 'Perle-de-coco'),
(15, 'Café su da', 1, 5, NULL, '67999', 'sua-da-coffee-616f2093e42b35.18816600.jpg', '2021-10-07 13:53:21', NULL, NULL, 'Café au lait frais à la façon vietnamienne', 3, 5, 'Cafe-su-da'),
(16, 'banh mi', 1, 10, NULL, '80000', 'banhmi-616f20a3ecfba1.59951360.jpg', '2021-10-07 14:22:10', NULL, NULL, 'pain blanc avec mayo vegetarien avec du toffu', 3, 3, 'banh-mi'),
(19, 'Grand Bubble tea au taro', 1, 6, NULL, '6663', 'taro-616f20b9aa21b9.05156539.jpg', '2021-10-13 10:55:10', NULL, NULL, 'Boisson fraîche lacté accompagné de bille de tapioca.', 3, 6, 'Grand-Bubble-tea-au-taro'),
(20, 'Petit Bubble tea à la pêche', 1, 5, NULL, '6664', 'smallbbtea-616f20cad6ab39.66194715.jpg', '2021-10-13 11:00:01', NULL, NULL, 'Boisson fraîche accompagné de bille aux fruits (selon saison)', 3, 6, 'Petit-Bubble-tea-a-la-peche'),
(21, 'Grand Bubble tea à la passion', 1, 6, NULL, '6699', 'bigbbtea-616f20dac690c3.91568929.jpg', '2021-10-13 11:03:04', NULL, NULL, 'Boisson fraîche lacté accompagné de bille fruitée selon la saison', 3, 6, 'Grand-Bubble-tea-a-la-passion');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(3, 3, 'MlJxRBBWANZ6OaFO2pzD', 'Po+tuMEBt7VXMM0aQq1O0pK8B2asiaNQ2AkXebasi38=', '2021-10-13 13:20:30', '2021-10-13 14:20:30');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `lastname`, `firstname`, `adress`, `zipcode`, `city`, `phone`, `created_at`, `updated_at`, `image`, `birthday`, `is_verified`) VALUES
(3, 'ju@ju.fr', '[\"ROLE_ADMIN\"]', '$2y$13$n2DXVFWi/JopkwwQuClF1.R4vrrOIwFS75Fzb8hK0up8PwJ9e1aLm', 'Ly-Minh', 'Julie', '10 rue du cerisier', 75012, 'paris', 304040044, NULL, NULL, NULL, NULL, 0),
(5, 'julie@julie.fr', '[\"ROLE_MANAGER\"]', '$2y$13$y55RzJqt0hkGwGtZOuIqrOO3aS7Zy7gBwo6T.PGtIrxkCkqQMhhsy', 'Lefur', 'Elisia', '10 rue de paris', 44600, 'st nazaire', 499000899, NULL, NULL, NULL, NULL, 0),
(6, 'user@test.fr', '[\"ROLE_USER\"]', '$2y$13$GccXO0wKDRicgrerHWF1celS3ANEmnicnvf3HHXgWpDFyC7HAyii2', 'Marceau', 'Sophie', '1 rue de paris', 93200, 'Aulnay sous bois', 499004400, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `is_rgpd` tinyint(1) NOT NULL,
  `validation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `created_at`, `is_rgpd`, `validation_token`, `is_valid`) VALUES
(1, 'test@test.fr', '2021-10-04 16:21:03', 1, '5ef8301e794a5239672c6078b50add302d47b9c32c5094e055244e0732d4ea01', 1),
(2, 'test@test.fr', '2021-10-06 09:39:18', 1, '137b22c4be4c18c78f88d9612ab7c821fc2e8fa2e58c274469b3962203a61cbe', 0),
(3, 'julie@julie.fr', '2021-10-13 14:06:27', 1, 'ffe59c64943ca08cdef394d7b2b69b5d1ad4200bd7352eee581dfa4e9c2a5ecd', 1),
(4, 'remidromat@gmail.com', '2021-10-16 22:50:21', 1, '7e78f716057aba79b606b9b2f86e439a30d9ca5a7fe27b4447ae9311e5a009d6', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users_categories`
--

DROP TABLE IF EXISTS `users_categories`;
CREATE TABLE `users_categories` (
  `users_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users_categories`
--

INSERT INTO `users_categories` (`users_id`, `categories_id`) VALUES
(2, 1),
(3, 1),
(3, 2),
(4, 1),
(4, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `news_letters`
--
ALTER TABLE `news_letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ACB1381DA21214B7` (`categories_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Index pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_845CA2C16D128938` (`user_order_id`),
  ADD KEY `IDX_845CA2C14584665A` (`product_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8DA76ED395` (`user_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04ADA76ED395` (`user_id`),
  ADD KEY `IDX_D34A04ADBCF5E72D` (`categorie_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_categories`
--
ALTER TABLE `users_categories`
  ADD PRIMARY KEY (`users_id`,`categories_id`),
  ADD KEY `IDX_ED98E9FC67B3B43D` (`users_id`),
  ADD KEY `IDX_ED98E9FCA21214B7` (`categories_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `news_letters`
--
ALTER TABLE `news_letters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT pour la table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `news_letters`
--
ALTER TABLE `news_letters`
  ADD CONSTRAINT `FK_ACB1381DA21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `FK_845CA2C14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_845CA2C16D128938` FOREIGN KEY (`user_order_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D34A04ADBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `users_categories`
--
ALTER TABLE `users_categories`
  ADD CONSTRAINT `FK_ED98E9FC67B3B43D` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ED98E9FCA21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
