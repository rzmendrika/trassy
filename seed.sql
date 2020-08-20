# TRUNCATE `accs`; TRUNCATE `acc_acc_type`; TRUNCATE `contacts`; TRUNCATE `rooms`;


INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `tel1`, `tel2`, `address`, `nifstat`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mendrika', 'rzmendrika@gmail.com', NULL, '033', NULL, 'Lot B 111 Anatihazo', NULL, '$2y$10$OPJ3u6r2NeHpBx/x8HLo0.VyW0oWvofwEwOQLiXDzx6StstVN9YqC', NULL, '2020-04-22 05:18:44', '2020-04-22 05:18:44');


INSERT INTO `acc_types` (`id`, `name`) VALUES
(1, 'Bungalows'),
(2, 'Villa'),
(3, 'Hôtel'),
(4, 'Maison d’hôte'),
(5, 'Dortoir'),
(6, 'Appartement'),
(7, 'Motel'),
(8, 'Auberge'),
(9, 'Maison familiale');


INSERT INTO `restau_types` (`id`, `name`) VALUES
(1, 'Karaoké'),
(2, 'Bar'),
(3, 'Cafétéria'),
(4, 'Gargotte'),
(5, 'Gastronomique'),
(6, 'Boulangerie'),
(7, 'Fast-food'),
(8, 'Buffet'),
(9, 'Halal');

INSERT INTO `restau_specialities` (`id`, `name`) VALUES
(1, 'Malagasy'),
(2, 'Française'),
(3, 'Japonnaise'),
(4, 'Créole'),
(5, 'Halal'),
(6, 'du monde');

INSERT INTO `room_categories` (`name`) VALUES ('Simple'),('Double ou Twin'),('Familiale et Affaires'),('Suites ou appartements'),('Communicantes');

INSERT INTO `acc_tarifs` (`id`, `name`, `pictures`, `monthly`, `half_yearly`, `yearly`, `annexes`, `events`) VALUES
(1, 'Bronze', 12, 20000, 110000, 200000, 0, 0),
(2, 'Silver', 20, 25000, 135000, 250000, 2, 1),
(3, 'Gold', 35, 35000, 200000, 350000, 5, 3),
(4, 'Platine', 42, 40000, 230000, 400000, 10, 5);

INSERT INTO `restau_tarifs` (`id`, `name`, `pictures`, `menus`, `monthly`, `half_yearly`, `yearly`, `localisations`, `events`) VALUES
(1, 'Bronze', 12, 10, 15000, 85000, 16000, 2, 1),
(2, 'Silver', 20, 15, 20000, 110000, 200000, 5, 3),
(3, 'Gold', 30, 30, 25000, 140000, 250000, 8, 5),
(4, 'Platine', 42, 42, 30000, 160000, 300000, 10, 7);