-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2025 pada 05.14
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `awbit_unimed`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('multiple_choice','essay','file_upload') NOT NULL DEFAULT 'multiple_choice',
  `due_date` datetime DEFAULT NULL,
  `points_possible` int(10) UNSIGNED NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignment_questions`
--

CREATE TABLE `assignment_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('multiple_choice','essay') NOT NULL DEFAULT 'multiple_choice',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignment_question_options`
--

CREATE TABLE `assignment_question_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assignment_question_id` bigint(20) UNSIGNED NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(2048) DEFAULT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `graded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `graded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignment_submission_answers`
--

CREATE TABLE `assignment_submission_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assignment_submission_id` bigint(20) UNSIGNED NOT NULL,
  `assignment_question_id` bigint(20) UNSIGNED NOT NULL,
  `assignment_question_option_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answer_text` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `points_awarded` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `badges`
--

CREATE TABLE `badges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon_path` varchar(2048) DEFAULT NULL,
  `required_points` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('points','activity','manual') NOT NULL DEFAULT 'points',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('frengkyaja@gmail.com|127.0.0.1', 'i:1;', 1749803513),
('frengkyaja@gmail.com|127.0.0.1:timer', 'i:1749803513;', 1749803513),
('frengkynihbos@gmail.com|127.0.0.1', 'i:1;', 1749803536),
('frengkynihbos@gmail.com|127.0.0.1:timer', 'i:1749803536;', 1749803536);

-- --------------------------------------------------------

--
-- Struktur dari tabel `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `lecturer_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `course_code`, `lecturer_id`, `status`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 'testing', 'testtingep', '12345', 10, 'approved', '2025-06-13 00:53:54', '2025-06-13 00:37:14', '2025-06-13 00:53:54'),
(2, '2a', 'erwerwer', '2345', 10, 'approved', '2025-06-15 08:58:51', '2025-06-15 08:58:16', '2025-06-15 08:58:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `course_enrollments`
--

CREATE TABLE `course_enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `forums`
--

CREATE TABLE `forums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_thread_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `parent_post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum_threads`
--

CREATE TABLE `forum_threads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('book','ppt','video','file') NOT NULL,
  `content` text DEFAULT NULL,
  `file_path` varchar(2048) DEFAULT NULL,
  `points_reward` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `materials`
--

INSERT INTO `materials` (`id`, `section_id`, `title`, `type`, `content`, `file_path`, `points_reward`, `created_at`, `updated_at`) VALUES
(1, 1, 'pendahuluan', 'book', NULL, 'materials/7aXuJh90NTWT8Y67olFIUVwIpv7qvtbM4T0PY6sa.pdf', 0, '2025-06-15 08:51:41', '2025-06-15 09:17:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_06_07_141103_create_awbit_database_schema', 1),
(2, '2025_06_07_150939_add_status_to_courses_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('shbmimqbb0@vip-mail.info', '$2y$12$kOsQXKeio22NjFdgPtuQJ.cRGqpEW..soKhSXU9410bI3kJFLiL2y', '2025-06-07 12:04:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'dosen', NULL, NULL),
(3, 'mahasiswa', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `week_number` int(10) UNSIGNED DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sections`
--

INSERT INTO `sections` (`id`, `course_id`, `title`, `week_number`, `start_date`, `end_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'pendahuluan', 1, '2025-10-09 00:00:00', '2025-10-19 00:00:00', 'pert 1', '2025-06-15 07:55:12', '2025-06-15 08:50:36'),
(2, 2, 'test', 1, '2025-12-12 00:00:00', '2025-12-15 00:00:00', 'trhfh', '2025-06-15 09:18:48', '2025-06-15 09:18:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HTQpajn2Twk2BkluWzA22dB3G2DXWkLiPcw5urU1', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV0VFeXo4YVJqWlRsVTdiSGVCYXYwaFp1SEx0NHQ0MUdleVlSOE4zTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYWhhc2lzd2EvZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTt9', 1750004440),
('OdwQwaGvZ39ah0Pek8xshSduBZ2xhqfoB7sHLMXQ', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiclBWd3dScFNqRE9QOXNNODZjYUM4SmZGS0hBYXRYS1E1THlTMnlDdiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZG9zZW4vZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1750004330);

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_material_progress`
--

CREATE TABLE `student_material_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `nim_nidn` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `profile_photo_path`, `nim_nidn`, `status`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@awbit.test', NULL, '$2y$12$ptjZJOSZmny.yA6/gUfuSO8NPySm.Mx32icjSSYOhfzZz5isjXgju', NULL, 'profile-photos/2Zb1K6QqNginDtCt6y0vFnCaXpUMXsQSU3nnUaKI.jpg', NULL, 'active', NULL, '2025-06-07 10:58:41', '2025-06-13 00:57:39'),
(2, 3, 'frengky', 'frengkyaja@gmail.com', NULL, '$2y$12$x5rhPZ2KOubvbDKdg/oX2OO1.C9I8bdv9q0rsKc8EtQ3MvJlfAvfe', NULL, NULL, '42432423424', 'active', NULL, '2025-06-07 11:27:12', '2025-06-07 11:27:12'),
(3, 3, 'testing', 'tomas92342@linacit.com', NULL, '$2y$12$t0qbQHHiE9.h2whg/3trlOXjxlkzVp7E1pH1kjtOpwW0.ZYm2Z/fO', NULL, NULL, '4243234456', 'active', NULL, '2025-06-07 11:33:43', '2025-06-07 11:33:43'),
(4, 3, 'testing', 'shbmimqbb0@vip-mail.info', NULL, '$2y$12$ap8cEyLPzM0I/e/yuvHrbu6HBa1wl4BKjYCo2Y6LVy3nv25TRiIKu', NULL, NULL, '234262342', 'active', NULL, '2025-06-07 11:47:16', '2025-06-09 10:20:21'),
(5, 1, 'admin 2', 'admin2@awbit.test', NULL, 'password', NULL, NULL, NULL, 'active', NULL, NULL, NULL),
(6, 2, 'frengky', 'frengky123@gmail.com', NULL, '$2y$12$gELsiGe1hGVCUNBVFsjJY.B5vdck2nQvRvwqmrRCWNZxWTbES/NUe', NULL, NULL, '1234567890', 'active', NULL, '2025-06-09 05:44:13', '2025-06-13 00:58:02'),
(9, 3, 'rifqi', 'rifqi@gmail.com', NULL, '$2y$12$ZrsO.wEriynkfdKv.R0a0.lsTPjOlV3sI8Skw9FMHmd5K0cNwvap.', NULL, 'profile-photos/KxnJWjsv3M0PmS3CmeBgw8LIc5IImaRETXYIf2i0.jpg', '4243250031', 'active', NULL, '2025-06-09 10:56:25', '2025-06-15 09:20:34'),
(10, 2, 'asrurii', 'asruri@gmail.com', NULL, '$2y$12$omQoKHZ6MVXcUu1aY4HqGO/B0b9TlcgphKbo/GJcqsX/UrxvVcDQe', NULL, 'profile-photos/91ZyeZ3ZdPEmiHbrbQXeZ52CgaZOiM9x6fmrBZg1.jpg', '12345678', 'active', NULL, '2025-06-09 11:04:46', '2025-06-13 01:40:43'),
(14, 1, 'Admin2', 'admin2@awbit.beta', NULL, '$2y$12$.zBye/yc.arhPk0ep.Tbru0Pk4Ny/wP.iYqEqXRrTmyGbGKbtZW9e', NULL, 'profile-photos/IOpLtk0mgQTN0yrHXrBJTK7NX6Bipfc4nE5YaiuH.jpg', NULL, 'active', NULL, '2025-06-12 02:32:44', '2025-06-13 01:23:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_badges`
--

CREATE TABLE `user_badges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `badge_id` bigint(20) UNSIGNED NOT NULL,
  `awarded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_points`
--

CREATE TABLE `user_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `related_type` varchar(255) NOT NULL,
  `related_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignments_section_id_foreign` (`section_id`);

--
-- Indeks untuk tabel `assignment_questions`
--
ALTER TABLE `assignment_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_questions_assignment_id_foreign` (`assignment_id`);

--
-- Indeks untuk tabel `assignment_question_options`
--
ALTER TABLE `assignment_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_question_options_assignment_question_id_foreign` (`assignment_question_id`);

--
-- Indeks untuk tabel `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assignment_submissions_assignment_id_student_id_unique` (`assignment_id`,`student_id`),
  ADD KEY `assignment_submissions_student_id_foreign` (`student_id`),
  ADD KEY `assignment_submissions_graded_by_foreign` (`graded_by`);

--
-- Indeks untuk tabel `assignment_submission_answers`
--
ALTER TABLE `assignment_submission_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_submission_answers_assignment_submission_id_foreign` (`assignment_submission_id`),
  ADD KEY `assignment_submission_answers_assignment_question_id_foreign` (`assignment_question_id`),
  ADD KEY `asa_aqo_id_foreign` (`assignment_question_option_id`);

--
-- Indeks untuk tabel `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `badges_name_unique` (`name`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_course_code_unique` (`course_code`),
  ADD KEY `courses_lecturer_id_foreign` (`lecturer_id`);

--
-- Indeks untuk tabel `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_enrollments_student_id_course_id_unique` (`student_id`,`course_id`),
  ADD KEY `course_enrollments_course_id_foreign` (`course_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forums_course_id_foreign` (`course_id`),
  ADD KEY `forums_created_by_foreign` (`created_by`);

--
-- Indeks untuk tabel `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_posts_forum_thread_id_foreign` (`forum_thread_id`),
  ADD KEY `forum_posts_user_id_foreign` (`user_id`),
  ADD KEY `forum_posts_parent_post_id_foreign` (`parent_post_id`);

--
-- Indeks untuk tabel `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_threads_forum_id_foreign` (`forum_id`),
  ADD KEY `forum_threads_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_section_id_foreign` (`section_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indeks untuk tabel `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_course_id_foreign` (`course_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `student_material_progress`
--
ALTER TABLE `student_material_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_material_progress_student_id_material_id_unique` (`student_id`,`material_id`),
  ADD KEY `student_material_progress_material_id_foreign` (`material_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nim_nidn_unique` (`nim_nidn`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_badges_user_id_badge_id_unique` (`user_id`,`badge_id`),
  ADD KEY `user_badges_badge_id_foreign` (`badge_id`);

--
-- Indeks untuk tabel `user_points`
--
ALTER TABLE `user_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_points_user_id_foreign` (`user_id`),
  ADD KEY `user_points_course_id_foreign` (`course_id`),
  ADD KEY `user_points_related_type_related_id_index` (`related_type`,`related_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignment_questions`
--
ALTER TABLE `assignment_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignment_question_options`
--
ALTER TABLE `assignment_question_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignment_submission_answers`
--
ALTER TABLE `assignment_submission_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `badges`
--
ALTER TABLE `badges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `course_enrollments`
--
ALTER TABLE `course_enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `forums`
--
ALTER TABLE `forums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `forum_threads`
--
ALTER TABLE `forum_threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `student_material_progress`
--
ALTER TABLE `student_material_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_points`
--
ALTER TABLE `user_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `assignment_questions`
--
ALTER TABLE `assignment_questions`
  ADD CONSTRAINT `assignment_questions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `assignment_question_options`
--
ALTER TABLE `assignment_question_options`
  ADD CONSTRAINT `assignment_question_options_assignment_question_id_foreign` FOREIGN KEY (`assignment_question_id`) REFERENCES `assignment_questions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD CONSTRAINT `assignment_submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_submissions_graded_by_foreign` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assignment_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `assignment_submission_answers`
--
ALTER TABLE `assignment_submission_answers`
  ADD CONSTRAINT `asa_aqo_id_foreign` FOREIGN KEY (`assignment_question_option_id`) REFERENCES `assignment_question_options` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assignment_submission_answers_assignment_question_id_foreign` FOREIGN KEY (`assignment_question_id`) REFERENCES `assignment_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_submission_answers_assignment_submission_id_foreign` FOREIGN KEY (`assignment_submission_id`) REFERENCES `assignment_submissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD CONSTRAINT `course_enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forums_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `forum_posts_forum_thread_id_foreign` FOREIGN KEY (`forum_thread_id`) REFERENCES `forum_threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_posts_parent_post_id_foreign` FOREIGN KEY (`parent_post_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD CONSTRAINT `forum_threads_forum_id_foreign` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_threads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `student_material_progress`
--
ALTER TABLE `student_material_progress`
  ADD CONSTRAINT `student_material_progress_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_material_progress_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `user_badges_badge_id_foreign` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_badges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_points`
--
ALTER TABLE `user_points`
  ADD CONSTRAINT `user_points_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_points_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
