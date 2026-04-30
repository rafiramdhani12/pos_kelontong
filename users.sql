
-- Dumping structure for table pos_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('owner','admin') NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pos_db.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'arya', 'arya@gmail.com', 'arya123', 'owner', 1, '2026-04-18 00:14:16', '2026-04-18 00:14:16');
