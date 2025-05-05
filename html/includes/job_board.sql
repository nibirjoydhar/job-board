-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: jobboard-db
-- Generation Time: Mar 28, 2025 at 07:45 PM
-- Server version: 8.0.41
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `job_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','accepted','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `user_id`, `cv`, `status`, `applied_at`) VALUES
(3, 9, 5, 'uploads/cvs/1742456444_data Science CA Marks.pdf', 'pending', '2025-03-20 07:41:01'),
(4, 9, 7, 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'pending', '2025-03-20 10:32:37'),
(5, 11, 7, 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'pending', '2025-03-20 10:32:52'),
(6, 10, 7, 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'pending', '2025-03-20 10:32:57'),
(8, 8, 11, 'uploads/cvs/1742492699_Nibir-Joydhar-FlowCV-Resume-20250226.pdf', 'pending', '2025-03-20 17:44:59'),
(11, 11, 11, 'uploads/cvs/1742504635_Nibir-Joydhar-FlowCV-Resume-20250226.pdf', 'pending', '2025-03-20 21:40:52'),
(14, 9, 11, 'uploads/cvs/1742504635_Nibir-Joydhar-FlowCV-Resume-20250226.pdf', 'pending', '2025-03-20 21:44:18'),
(15, 10, 11, 'uploads/cvs/1742504635_Nibir-Joydhar-FlowCV-Resume-20250226.pdf', 'pending', '2025-03-20 21:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `cvv` varchar(3) NOT NULL,
  `cardholder_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `card_details`
--

INSERT INTO `card_details` (`id`, `user_id`, `card_number`, `expiry_date`, `cvv`, `cardholder_name`, `created_at`) VALUES
(2, 4, '1234', '2025-11', '123', 'nibir', '2025-03-28 19:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `requirements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `responsibilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `employer_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `description`, `location`, `salary`, `requirements`, `responsibilities`, `employer_id`, `created_at`) VALUES
(8, 'Quality Assurance (Pharmacist)', 'A Software Quality Assurance (SQA) engineer ensures software products meet quality standards by designing, executing, and documenting test plans, identifying and reporting defects, and collaborating with developers to ensure reliable and user-friendly software', ' Kachua, Chittagong', 0.00, 'Education\r\nMaster of Pharmacy (M.Pharm)\r\nFrom any repudiate Public or Private University\r\nExperience\r\nAt least 8 years\r\nThe applicants should have experience in the following business area(s):\r\nPharmaceutical/Medicine Companies\r\nAdditional Requirements\r\nAge at most 40 years\r\n', 'Responsibilities & Context\r\nKeep themselves updated with internal, external, local, national and global rules of manufacturing, selling and shipping\r\nPrepare and update the internal quality documentation based on recognized standards, such as the International Organization for Standardization (ISO)\r\nCreate industry-specific manuals and protocols\r\nWork with external organizations to get the company certified with applicable standards\r\nEnsure the implementation of quality control procedures at every step of the production process\r\nPlan, schedule and conduct internal quality audits\r\nEnsure the availability of tools to facilitate product quality checking\r\nSelect quality inspection software and tools to support the quality inspection team\r\nImplement product inspection and tests\r\nTake appropriate corrective actions to rectify quality problems\r\nTake preventive quality control actions by identifying potential sources of error and suggesting ways to eliminate them\r\nImplement continuous process improvements using the right strategies like Six Sigma and lean manufacturing\r\nCandidate must have experience to prepare Dossier.\r\nSkills & Expertise\r\nAnalytical Skill Computer skill Good communication skills Pharmaceuticals Quality Assurance/ Quality Control', 4, '2025-03-19 22:29:16'),
(9, 'Software Engineer (MERN & React Native)', 'We are seeking a talented Software Engineer with a strong background in MERN (MongoDB, Express.js, React, Node.js) stack and React Native. The ideal candidate will have a proven track record of developing high-quality software solutions and a keen interest in working on enterprise-level applications.', 'Dhaka', 30000.00, 'Job Requirements\r\nAt least 2 years of professional experience in software development, specifically with MERN stack and React Native.\r\nProfound knowledge of JavaScript, including ES6+.\r\nExpertise in MongoDB, Express.js, React, and Node.js.\r\nProficiency in React Native for mobile application development.\r\nFamiliarity with RESTful API integration.\r\nUnderstanding of modern authorization mechanisms (e.g., JSON Web Token).\r\nProficiency in front-end development tools (Babel, Webpack, NPM, etc.).\r\nAbility to convert business requirements into technical solutions.\r\nSkills in performance benchmarking and optimization.\r\nA meticulous and detail-oriented approach to software development\r\n[Bonus] Experience in Microsoft Azure cloud services.\r\n[Bonus] Prior involvement in developing ERP, CRM, or Project Management software.\r\nBachelor’s degree in Computer Science, Engineering, or related fields is preferred.', 'Develop and maintain web and mobile applications using the MERN stack and React Native.\r\nCollaborate with cross-functional teams to define, design, and ship new features.\r\nEnsure the performance, quality, and responsiveness of applications.\r\nIdentify and correct bottlenecks and fix bugs.\r\nHelp maintain code quality, organization, and automatization.\r\nDevelopment of ERP/CRM/Project Management solutions.\r\nUtilize Microsoft Azure for cloud-based solutions and services.', 4, '2025-03-19 22:32:02'),
(10, 'WordPress Web Developer', 'A WordPress Web Developer designs, builds, and maintains websites using the WordPress CMS, focusing on both front-end and back-end development, including creating custom themes and plugins, optimizing performance, and troubleshooting issues. ', 'Dhaka', 30000.00, 'Experience: We’d expect someone with the necessary skills to have 2+ years experience, but if you’re new and very eager we’re interested in hearing from you.\r\n\r\nYour written English must be good and ideally your spoken English should be strong too. Spoken English is less important than written English, but still highly valued.\r\n\r\nYou need to be very strong with PHP and MySQL.\r\n\r\nWordPress - Custom Plugin Development. Many web developers are familiar with WordPress, but can you create and customize plugins? This is the standard we’d prefer, and expect you to reach soon after joining the team.\r\n\r\nWordPress - Build Websites. Build websites from an existing structure, and be skilled enough to improve our structure. If you have either of the following skills they are highly valued, please tell us and give details.\r\n\r\nBuilding and managing Gutenberg blocks - from scratch or with plugins.\r\n\r\nBuild WordPress websites from scratch.\r\n\r\nWordPress Security - Know something about the vulnerabilities and (1) how to harden WordPress and (2) how to follow procedures to keep websites up to date and secure.\r\n\r\nLaravel - Have you built and maintained a Web App? You should, with support from the lead developer, be able to debug and solve complex problems, including but not limited to building and maintaining existing systems with RESTful APIs.\r\n\r\nExperience in a high performance team is highly valued.', 'You will report to the Senior Web Developer who is also based in Bangladesh, but you will also be expected to work with Australian based staff.\r\n\r\nDay to day you will be expected to use AI assisted programming technologies (cursor, claude, chatGPT) and your own hand-coding to generate reliable and robust solutions in the following technologies.\r\n\r\nWordPress Security: Regularly update a portfolio of WordPress websites using our tools, and give product feedback to improve the tools (Kaizen).\r\n\r\nWordPress Plugin Development: We often build plugins some of which have RESTful API endpoints.\r\n\r\nYou must know how to build a plugin.\r\n\r\nBuilding RESTful API endpoints is a highly desirable skill, but not a requirement as we can train you on how to build then (our way).\r\n\r\nWebsite builds: You will be given a queue of website builds to work through where other tasks are not pressing. We use repeatable patterns and structures and code re-use, so...\r\n\r\n(1) follow procedures to build reliable and secure websites and\r\n\r\n(2) skilled enough to spot opportunities to improve our structured approach and systems.\r\n\r\nThis applies to WordPress and Laravel Website Systems.\r\n\r\nLaravel - You will be asked to write and implement unit tests and trained to support existing clients and their web application systems.\r\n\r\nBeing able to write blog posts about the work you’re doing, learning and delivering for clients is highly valued. We’re a marketing company, we like to tell people what we’re doing!\r\n\r\nApplicants, please be ready to discuss and demonstrate your understanding of these skills, concepts and day to day responsibilities.', 4, '2025-03-19 22:33:51'),
(11, 'Software Engineer(Java/Kotlin)', 'We are looking for a talented Software Engineer with a strong focus on Java and Kotlin languages to join our team. The ideal candidate will have a solid foundation in Object-Oriented Programming (OOP), software design patterns, and expertise in building scalable and maintainable software. You will work on cutting-edge projects and leverage Java/Kotlin to deliver efficient, high-performance solutions.', 'Banani', 0.00, 'Strong foundation in OOP, design patterns, and software architecture.\r\nProficiency in Java/Kotlin and related frameworks such as Spring Boot, Micronaut etc.\r\nProficiency in building, maintaining, and optimizing RESTful APIs and microservices architectures.\r\nFamiliarity with database or ORM libraries including JPA/Hibernate, QueryDSL, JOOQ etc\r\nStrong knowledge of SQL and NoSQL databases (e.g., PostgreSQL, MySQL, ElasticSearch, Redis).\r\nExperience with build tools such as Gradle for managing dependencies and automating the build process.\r\nFamiliarity with version control systems, particularly Git.\r\nUnderstanding of security best practices, including encryption, authentication, and authorization mechanisms.\r\nFamiliarity with cloud platforms like AWS and containerization technologies such as Docker and Kubernetes.\r\nExperience with CI/CD pipelines and automated testing frameworks.', 'Develop and maintain back-end applications using Java/Kotlin.\r\nDesign and implement scalable, secure, and high-performance APIs, microservices, and system integrations.\r\nCollaborate with cross-functional teams to ensure seamless integration with front-end components and other systems.\r\nOptimize application performance, troubleshoot issues, and ensure high availability and reliability.\r\nWrite clean, maintainable, and well-documented code following industry best practices.\r\nParticipate in code reviews, testing, and deployment activities to ensure high-quality deliverables.\r\nStay updated with the latest tools, frameworks, and technologies to continuously improve development practices.', 4, '2025-03-19 22:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `profile_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `github` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `skills` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `experience` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `full_name`, `bio`, `profile_photo`, `phone`, `address`, `linkedin`, `github`, `website`, `cv`, `skills`, `experience`, `created_at`, `updated_at`) VALUES
(1, 4, 'Nibir Joydhar', 'bio', 'uploads/profile_photos/1742491638_nibir.jpg', '0152154683', 'N/A', 'N/A', 'N/A', 'N/A', 'uploads/cvs/1742469625_data Science CA Marks.pdf', 'cp', '4 years', '2025-03-19 18:36:39', '2025-03-20 17:27:18'),
(3, 2, 'Nibir', '.', 'uploads/profile_photos/1742511720_nibir.jpg', '.', '.', '.', '.', '.', 'uploads/cvs/1742511720_Nibir-Joydhar-FlowCV-Resume-20250226.pdf', '.', '.', '2025-03-19 21:35:11', '2025-03-20 23:02:00'),
(4, 5, 'Hemel Ahmed', 'na', 'uploads/profile_photos/1742422585_Screenshot 2025-03-16 152009.png', '01883938712', 'Sadarghat', '.', '.', '.', 'uploads/cvs/1742456444_data Science CA Marks.pdf', '.', '.', '2025-03-19 21:59:26', '2025-03-20 07:40:44'),
(5, 7, 'Shima Hasan', 'bio', 'uploads/profile_photos/1742492383_Shima.jpg', '01883938712', 'Sadarghat', 'https://www.linkedin.com/in/s-m-himel-ahmed-b69a07276/', '.', '.', 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'na', 'na', '2025-03-20 08:40:27', '2025-03-20 17:39:43'),
(8, 11, 'Joydhar', 'No Bio', 'uploads/profile_photos/1742504635_nibir.jpg', '01521546883', '9-10 Chittaranjan Avenue', 'https://www.linkedin.com/in/nibirjoydhar/', 'https://github.com/nibirjoydhar', 'N/A', 'uploads/cvs/1742504635_Nibir-Joydhar-FlowCV-Resume-20250226.pdf', 'Programming', 'Freshers', '2025-03-20 21:01:02', '2025-03-20 21:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('job_seeker','employer','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `is_verified` tinyint(1) DEFAULT '0',
  `verification_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `is_premium` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `status`, `is_verified`, `verification_code`, `reset_token`, `reset_expires`, `is_premium`) VALUES
(2, 'nibir', 'nibir@gmail.com', '$2y$10$CH.uQJdYZYNw6P9xH2MvYOJcOHTn4OLbnB0f2fbrBe/jJH2neisgq', 'admin', '2025-03-19 17:41:37', 'active', 1, NULL, NULL, NULL, 0),
(4, 'Nibir Joydhar', 'nibirjoydhar@gmail.com', '$2y$10$ioFqqqKy.lBedi0hTsC76OVxNS8MKyhK/VOKv06gyZqKPTmpi70qC', 'employer', '2025-03-19 18:00:56', 'active', 1, NULL, NULL, NULL, 1),
(5, 'Hemel Ahmed', 'ahmedhemel889@gmail.com', '$2y$10$GVu/6jTC0z1cKitDFmT9oOeh6.dx/PTTIhW3lXjcq8WZ9eodHXbDK', 'job_seeker', '2025-03-19 21:58:20', 'active', 1, NULL, NULL, NULL, 0),
(7, 'Shima Hasan', 'shima@gmail.com', '$2y$10$o3roolkKYHGzrcBAMLGwk.8zK1leJwqqboJTQKey1nVZEOiWTu9.u', 'job_seeker', '2025-03-20 08:27:13', 'active', 1, NULL, NULL, NULL, 0),
(8, 'Hemel ', 'hemelahmed092@gmail.com', '$2y$10$G6vBDT2XxHfZ0zdTGSvuM.Dvyp6V0wG7L.Wsx5hEvVmyVt24izp0y', 'employer', '2025-03-20 08:59:14', 'active', 1, NULL, NULL, NULL, 0),
(11, 'Joydhar', 'joydhar@gmail.com', '$2y$10$7TV.wHgGM/4GUZwjp90EwO0AZzavdCGAZgVpCnqKRim0TKiHel/Rq', 'job_seeker', '2025-03-20 11:02:48', 'active', 1, NULL, 'af0331e15b448dfbe25d54ffa4c0a7f1be3f8908e424f5d42923e5228139500adc5dea63d59b59729d65b56471f4bb27646b', '2025-03-21 18:37:16', 0),
(21, 'Nibir Joydhar', 'nibirjoydharnj@gmail.com', '$2y$10$7OjkRfdNznJ2I24VXbxLC.lKZrzWr3VepVmvh2yZdI/KfPIVW.htO', 'employer', '2025-03-21 02:05:48', 'active', 1, '25487e6fee7f8dfc5639887af082a7df', NULL, NULL, 0),
(22, 'Nibir Joydhar', 'b190305036@cse.jnu.ac.bd', '$2y$10$v/Ctvecv3tiXFNiVlylMuOyRdFNt0gTvUE0JO.QjqNPDYrwcO.mLi', 'employer', '2025-03-21 10:41:49', 'active', 1, 'd8ec658e731807a14bfde47875e2a2c9', NULL, NULL, 0),
(32, 'Fake', 'asibosi123@gmail.com', '$2y$10$Ve4uDtaDDdGdVBETbmAbDurSOQasRY5lAZj6k7VdCR.JG2iJqHxHq', 'job_seeker', '2025-03-22 20:24:35', 'active', 1, '6ae762144a96b4b7c2a64c5f3695acf2', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `card_details`
--
ALTER TABLE `card_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
