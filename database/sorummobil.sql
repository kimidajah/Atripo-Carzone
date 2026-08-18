-- SQL Dump for MobilQ - Showroom Mobil Bekas
-- Database Export for MySQL / MariaDB / Docker
-- Generated on: 2026-08-13 15:24:16

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `transmission` enum('Manual','Automatic') NOT NULL DEFAULT 'Automatic',
  `plate_number` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cars_plate_number_unique` (`plate_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `kk_number` varchar(20) DEFAULT NULL,
  `npwp_number` varchar(30) DEFAULT NULL,
  `ktp_file` varchar(255) DEFAULT NULL,
  `kk_file` varchar(255) DEFAULT NULL,
  `salary_slip_file` varchar(255) DEFAULT NULL,
  `npwp_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sale_date` date NOT NULL,
  `sale_price` decimal(15,2) NOT NULL,
  `payment_type` enum('cash','credit') NOT NULL DEFAULT 'cash',
  `dp_amount` decimal(15,2) DEFAULT NULL,
  `tenor_months` int(11) DEFAULT NULL,
  `interest_rate_per_year` decimal(5,2) DEFAULT NULL,
  `total_interest` decimal(15,2) DEFAULT NULL,
  `monthly_installment` decimal(15,2) DEFAULT NULL,
  `payment_method` enum('cash','transfer') NOT NULL DEFAULT 'cash',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  KEY `sales_car_id_foreign` (`car_id`),
  KEY `sales_customer_id_foreign` (`customer_id`),
  KEY `sales_user_id_foreign` (`user_id`),
  CONSTRAINT `sales_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users` 
LOCK TABLES `users` WRITE;
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `phone`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Admin Operasional', 'admin', 'admin@mobilq.com', NULL, '$2y$12$pPX7ZuOdgOChnSrMOgXNS.3wGQKYrF.mgV8VGwtin45t/p0REt4Eu', 'admin', '081234567890', NULL, NULL, '2026-08-11 23:18:41', '2026-08-13 00:08:37');
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `phone`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', 'Pemilik Showroom', 'owner', 'owner@mobilq.com', NULL, '$2y$12$gSP7IDCZMg36V7Eo.hYqcOlTv55NTLzXPQ0r4Tr.NsUUvjZDVoVRO', 'owner', '081987654321', NULL, NULL, '2026-08-11 23:18:42', '2026-08-13 00:08:37');
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `phone`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'Staff Marketing', 'marketing', 'marketing@mobilq.com', NULL, '$2y$12$2JC8GHAf/YwVAH0We5Xc5eDoocvmZvbAhrbGU0Bj6/GcKmET9qJNy', 'marketing', '081345678901', NULL, NULL, '2026-08-13 00:08:37', '2026-08-13 00:08:37');
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `phone`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'Pengelola Mobil', 'pengelola', 'pengelola@mobilq.com', NULL, '$2y$12$ncVhvMheiuMX.4IuJ3L17.YEpWdgfIeVYEWzgPPwK/keG2akdvoWO', 'pengelola', '081456789012', NULL, NULL, '2026-08-13 00:08:38', '2026-08-13 00:08:38');
UNLOCK TABLES;

-- Dumping data for table `cars` 
LOCK TABLES `cars` WRITE;
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('1', 'Toyota', 'Avanza 1.5 G CVT', '2022', 'Hitam Metalik', 'Automatic', 'D 1234 ABC', '215000000', 'cars/iNa7QIPE8eG7DLZ4qlQt3YegqxThWBZCx93em610.png', 'terjual', '2026-08-11 23:18:42', '2026-08-12 23:15:22');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('2', 'Honda', 'HR-V 1.5 E CVT', '2021', 'Putih Mutiara', 'Automatic', 'D 5678 EFG', '310000000', 'cars/tCFjlnXnMDaV8EWDeH0BkZFXnAlmR509iZ3WuHEw.png', 'terjual', '2026-08-11 23:18:42', '2026-08-11 23:39:36');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('3', 'Mitsubishi', 'Pajero Sport Dakar 4x2', '2020', 'Hitam', 'Automatic', 'D 9012 HIJ', '485000000', 'cars/5SX35qIhubFPZe9yTk2mjdlcRyP3gkwuIWc6qPpO.png', 'terjual', '2026-08-11 23:18:42', '2026-08-11 23:34:01');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('4', 'Toyota', 'Innova Reborn 2.4 V Diesel', '2021', 'Abu-abu Metalik', 'Automatic', 'D 3456 KLM', '375000000', 'cars/gC3GFOwp0fWV6yV7b6P5rHiRC6K7nybWGztQBIF8.png', 'terjual', '2026-08-11 23:18:42', '2026-08-12 23:27:49');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('5', 'Honda', 'Brio RS 1.2 CVT', '2023', 'Kuning', 'Automatic', 'D 7890 NOP', '180000000', 'cars/Oefi1XL5cY9AZsNyakWuRPuiFCAv1jn2M8ztG1l4.png', 'terjual', '2026-08-11 23:18:42', '2026-08-12 23:18:43');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('6', 'Suzuki', 'XL7 Alpha AT', '2022', 'Orange/Black', 'Automatic', 'D 2345 QRS', '235000000', 'cars/ojqJUDgHoQj7K2F3Wdq7ATnxMog9QkoDViIU2Bkz.png', 'tersedia', '2026-08-11 23:18:42', '2026-08-11 23:35:15');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('7', 'Daihatsu', 'Rocky 1.0 R Turbo CVT', '2021', 'Merah', 'Automatic', 'D 6789 TUV', '195000000', 'cars/4zoEa6ajUkUohQMwqAcosPJyDSfWLHW0pWORXESY.png', 'terjual', '2026-08-11 23:18:42', '2026-08-11 23:35:36');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('8', 'Toyota', 'Fortuner 2.8 VRZ 4x2', '2022', 'Hitam', 'Automatic', 'D 1122 WXY', '540000000', 'cars/bBOR4xe8HWzE3eX5wrtCibkwratMB4J5LoXvbyv9.png', 'terjual', '2026-08-11 23:18:42', '2026-08-12 23:23:00');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('9', 'Toyota', 'Hilux n70', '2011', 'putih', 'Manual', 'D 1234 ee', '74300000', 'cars/wvgBf0tlyImAD9UDl8jXLgqd2OaUKCiXNPLippQx.png', 'tersedia', '2026-08-11 23:24:53', '2026-08-11 23:24:53');
INSERT INTO `cars` (`id`, `brand`, `model_type`, `year`, `color`, `transmission`, `plate_number`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES ('10', 'hilman', 'kimid', '2026', 'pink', 'Manual', 'D 3456 KL', '1000000', 'cars/7ZobNJzznsbNDmQhK9lXSzsra66NZIgMKFedFG09.png', 'tersedia', '2026-08-12 23:52:20', '2026-08-12 23:52:42');
UNLOCK TABLES;

-- Dumping data for table `customers` 
LOCK TABLES `customers` WRITE;
INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `email`, `nik`, `kk_number`, `npwp_number`, `ktp_file`, `kk_file`, `salary_slip_file`, `npwp_file`, `created_at`, `updated_at`) VALUES ('1', 'Budi Santoso', '081223344556', 'Jl. Rayas Cileunyi No. 45, Bandung', 'budi.santoso@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-11 23:18:42', '2026-08-11 23:18:42');
INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `email`, `nik`, `kk_number`, `npwp_number`, `ktp_file`, `kk_file`, `salary_slip_file`, `npwp_file`, `created_at`, `updated_at`) VALUES ('2', 'Ahmad Rifa''i', '085711223344', 'Jl. Soekarno Hatta No. 120, Bandung', 'ahmad.rifai@yahoo.com', '3273011234560001', '3273019876540002', '09.123.456.7-401.000', NULL, NULL, NULL, NULL, '2026-08-11 23:18:42', '2026-08-12 23:23:00');
INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `email`, `nik`, `kk_number`, `npwp_number`, `ktp_file`, `kk_file`, `salary_slip_file`, `npwp_file`, `created_at`, `updated_at`) VALUES ('3', 'Siti Nurhaliza', '087899887766', 'Komplek Permata Biru Blok B No. 12, Cinunuk, Cileunyi', 'siti.nurhaliza@gmail.com', '3273011234560001', '3273019876540002', '09.123.456.7-401.000', 'customers/documents/tU8x49B0AxyHbVpUoMkL8PYlqSyK3GhMp7bPfTyp.png', 'customers/documents/Z94nZ8ufN9tib9DmcjHAGMbAGnZpSg5Lz59i9Nyj.png', 'customers/documents/8mf8zbyggP3WYZ54bEDC5WpGTD2HseWTZilooAaS.png', 'customers/documents/MYD5lBlRMNiB595wWav3hSxjqED2t2ML5bhafNQS.png', '2026-08-11 23:18:42', '2026-08-12 23:27:49');
INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `email`, `nik`, `kk_number`, `npwp_number`, `ktp_file`, `kk_file`, `salary_slip_file`, `npwp_file`, `created_at`, `updated_at`) VALUES ('4', 'Dedi Kurniawan', '082133445566', 'Jl. Raya Rancaekek No. 88, Sumedang', 'dedi.k@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-11 23:18:42', '2026-08-11 23:18:42');
INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `email`, `nik`, `kk_number`, `npwp_number`, `ktp_file`, `kk_file`, `salary_slip_file`, `npwp_file`, `created_at`, `updated_at`) VALUES ('5', 'Muhamad Hilman Nur Hakim', '083844452722', 'Kab Bandung, Indonesia', 'hilman@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-12 14:11:07', '2026-08-12 14:11:24');
INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `email`, `nik`, `kk_number`, `npwp_number`, `ktp_file`, `kk_file`, `salary_slip_file`, `npwp_file`, `created_at`, `updated_at`) VALUES ('6', 'Agus Perdana', '081299887766', 'Jl. Merdeka No. 45, Bandung', 'agus@example.com', '3273011234560001', '3273019876540002', '09.123.456.7-401.000', 'customers/documents/a8CIGRmZPtviS44qnUfAiiZVYxwAouZPttp8ViEo.png', 'customers/documents/LVvddnn4ZVHpwnDjYrnZjJZWEY1TR80Pp9pHXxES.png', 'customers/documents/FDklxVNwsMbSzJT3zWFEI3Yjhak4hrVYJKgnBtHH.png', 'customers/documents/yDuvqlvYlBZ0Fzz7qPtOsmrY3pqaC1piwULac7ml.png', '2026-08-12 23:15:22', '2026-08-12 23:18:43');
UNLOCK TABLES;

-- Dumping data for table `sales` 
LOCK TABLES `sales` WRITE;
INSERT INTO `sales` (`id`, `invoice_number`, `car_id`, `customer_id`, `user_id`, `sale_date`, `sale_price`, `payment_type`, `dp_amount`, `tenor_months`, `interest_rate_per_year`, `total_interest`, `monthly_installment`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES ('1', 'INV-20260801-001', '3', '1', '1', '2026-08-01 00:00:00', '485000000', 'cash', NULL, NULL, NULL, NULL, NULL, 'transfer', 'Pembayaran lunas via transfer Bank BCA.', '2026-08-11 23:18:42', '2026-08-11 23:18:42');
INSERT INTO `sales` (`id`, `invoice_number`, `car_id`, `customer_id`, `user_id`, `sale_date`, `sale_price`, `payment_type`, `dp_amount`, `tenor_months`, `interest_rate_per_year`, `total_interest`, `monthly_installment`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES ('2', 'INV-20260805-002', '7', '2', '1', '2026-08-06 00:00:00', '195000000', 'cash', NULL, NULL, NULL, NULL, NULL, 'cash', 'Pembayaran tunai di showroom.', '2026-08-11 23:18:42', '2026-08-11 23:18:42');
INSERT INTO `sales` (`id`, `invoice_number`, `car_id`, `customer_id`, `user_id`, `sale_date`, `sale_price`, `payment_type`, `dp_amount`, `tenor_months`, `interest_rate_per_year`, `total_interest`, `monthly_installment`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES ('3', 'INV-20260811-003', '2', '2', '1', '2026-08-11 00:00:00', '309800000', 'cash', NULL, NULL, NULL, NULL, NULL, 'cash', 'mantap men', '2026-08-11 23:39:36', '2026-08-11 23:39:36');
INSERT INTO `sales` (`id`, `invoice_number`, `car_id`, `customer_id`, `user_id`, `sale_date`, `sale_price`, `payment_type`, `dp_amount`, `tenor_months`, `interest_rate_per_year`, `total_interest`, `monthly_installment`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES ('4', 'INV-20260812-001', '1', '6', '1', '2026-08-12 00:00:00', '100000000', 'credit', '20000000', '36', '6', '14400000', '2622222.2222222', 'transfer', 'Studi kasus Agus kredit 100jt DP 20jt Bunga 6% 36 bln', '2026-08-12 23:15:22', '2026-08-12 23:15:22');
INSERT INTO `sales` (`id`, `invoice_number`, `car_id`, `customer_id`, `user_id`, `sale_date`, `sale_price`, `payment_type`, `dp_amount`, `tenor_months`, `interest_rate_per_year`, `total_interest`, `monthly_installment`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES ('5', 'INV-20260812-002', '5', '6', '1', '2026-08-12 00:00:00', '180000000', 'credit', '50000000', '24', '6.1', '15860000', '6077500', 'cash', 'pembayaran lewat dana', '2026-08-12 23:18:43', '2026-08-12 23:18:43');
INSERT INTO `sales` (`id`, `invoice_number`, `car_id`, `customer_id`, `user_id`, `sale_date`, `sale_price`, `payment_type`, `dp_amount`, `tenor_months`, `interest_rate_per_year`, `total_interest`, `monthly_installment`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES ('6', 'INV-20260812-003', '8', '2', '1', '2026-08-12 00:00:00', '540000000', 'credit', '40000000', '60', '6', '150000000', '10833333.333333', 'transfer', NULL, '2026-08-12 23:23:00', '2026-08-12 23:23:00');
INSERT INTO `sales` (`id`, `invoice_number`, `car_id`, `customer_id`, `user_id`, `sale_date`, `sale_price`, `payment_type`, `dp_amount`, `tenor_months`, `interest_rate_per_year`, `total_interest`, `monthly_installment`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES ('7', 'INV-20260812-004', '4', '3', '1', '2026-08-12 00:00:00', '375000000', 'credit', '75000000', '36', '6', '54000000', '9833333.3333333', 'cash', 'mantap men', '2026-08-12 23:27:49', '2026-08-12 23:27:49');
UNLOCK TABLES;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
