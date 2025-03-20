-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 01:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `user_id`, `cv`, `status`, `applied_at`) VALUES
(3, 9, 5, 'uploads/cvs/1742456444_data Science CA Marks.pdf', 'pending', '2025-03-20 07:41:01'),
(4, 9, 7, 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'pending', '2025-03-20 10:32:37'),
(5, 11, 7, 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'pending', '2025-03-20 10:32:52'),
(6, 10, 7, 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'pending', '2025-03-20 10:32:57'),
(7, 9, 12, 'uploads/cvs/1742469805_data Science CA Marks.pdf', 'pending', '2025-03-20 11:23:25');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `requirements` text DEFAULT NULL,
  `responsibilities` text DEFAULT NULL,
  `employer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `description`, `location`, `salary`, `requirements`, `responsibilities`, `employer_id`, `created_at`) VALUES
(8, 'Quality Assurance (Pharmacist)', 'A Software Quality Assurance (SQA) engineer ensures software products meet quality standards by designing, executing, and documenting test plans, identifying and reporting defects, and collaborating with developers to ensure reliable and user-friendly software', ' Kachua, Chittagong', 0.00, 'Education\r\nMaster of Pharmacy (M.Pharm)\r\nFrom any repudiate Public or Private University\r\nExperience\r\nAt least 8 years\r\nThe applicants should have experience in the following business area(s):\r\nPharmaceutical/Medicine Companies\r\nAdditional Requirements\r\nAge at most 40 years\r\n', 'Responsibilities & Context\r\nKeep themselves updated with internal, external, local, national and global rules of manufacturing, selling and shipping\r\nPrepare and update the internal quality documentation based on recognized standards, such as the International Organization for Standardization (ISO)\r\nCreate industry-specific manuals and protocols\r\nWork with external organizations to get the company certified with applicable standards\r\nEnsure the implementation of quality control procedures at every step of the production process\r\nPlan, schedule and conduct internal quality audits\r\nEnsure the availability of tools to facilitate product quality checking\r\nSelect quality inspection software and tools to support the quality inspection team\r\nImplement product inspection and tests\r\nTake appropriate corrective actions to rectify quality problems\r\nTake preventive quality control actions by identifying potential sources of error and suggesting ways to eliminate them\r\nImplement continuous process improvements using the right strategies like Six Sigma and lean manufacturing\r\nCandidate must have experience to prepare Dossier.\r\nSkills & Expertise\r\nAnalytical Skill Computer skill Good communication skills Pharmaceuticals Quality Assurance/ Quality Control', 4, '2025-03-19 22:29:16'),
(9, 'Software Engineer (MERN & React Native)', 'We are seeking a talented Software Engineer with a strong background in MERN (MongoDB, Express.js, React, Node.js) stack and React Native. The ideal candidate will have a proven track record of developing high-quality software solutions and a keen interest in working on enterprise-level applications such as ERP, CRM, and Project Management Systems.', 'Dhaka', 30000.00, 'Job Requirements\r\nAt least 2 years of professional experience in software development, specifically with MERN stack and React Native.\r\nProfound knowledge of JavaScript, including ES6+.\r\nExpertise in MongoDB, Express.js, React, and Node.js.\r\nProficiency in React Native for mobile application development.\r\nFamiliarity with RESTful API integration.\r\nUnderstanding of modern authorization mechanisms (e.g., JSON Web Token).\r\nProficiency in front-end development tools (Babel, Webpack, NPM, etc.).\r\nAbility to convert business requirements into technical solutions.\r\nSkills in performance benchmarking and optimization.\r\nA meticulous and detail-oriented approach to software development\r\n[Bonus] Experience in Microsoft Azure cloud services.\r\n[Bonus] Prior involvement in developing ERP, CRM, or Project Management software.\r\nBachelor’s degree in Computer Science, Engineering, or related fields is preferred.', 'Develop and maintain web and mobile applications using the MERN stack and React Native.\r\nCollaborate with cross-functional teams to define, design, and ship new features.\r\nEnsure the performance, quality, and responsiveness of applications.\r\nIdentify and correct bottlenecks and fix bugs.\r\nHelp maintain code quality, organization, and automatization.\r\nDevelopment of ERP/CRM/Project Management solutions.\r\nUtilize Microsoft Azure for cloud-based solutions and services.', 4, '2025-03-19 22:32:02'),
(10, 'WordPress Web Developer', 'A WordPress Web Developer designs, builds, and maintains websites using the WordPress CMS, focusing on both front-end and back-end development, including creating custom themes and plugins, optimizing performance, and troubleshooting issues. ', 'Dhaka', 30000.00, 'Experience: We’d expect someone with the necessary skills to have 2+ years experience, but if you’re new and very eager we’re interested in hearing from you.\r\n\r\nYour written English must be good and ideally your spoken English should be strong too. Spoken English is less important than written English, but still highly valued.\r\n\r\nYou need to be very strong with PHP and MySQL.\r\n\r\nWordPress - Custom Plugin Development. Many web developers are familiar with WordPress, but can you create and customize plugins? This is the standard we’d prefer, and expect you to reach soon after joining the team.\r\n\r\nWordPress - Build Websites. Build websites from an existing structure, and be skilled enough to improve our structure. If you have either of the following skills they are highly valued, please tell us and give details.\r\n\r\nBuilding and managing Gutenberg blocks - from scratch or with plugins.\r\n\r\nBuild WordPress websites from scratch.\r\n\r\nWordPress Security - Know something about the vulnerabilities and (1) how to harden WordPress and (2) how to follow procedures to keep websites up to date and secure.\r\n\r\nLaravel - Have you built and maintained a Web App? You should, with support from the lead developer, be able to debug and solve complex problems, including but not limited to building and maintaining existing systems with RESTful APIs.\r\n\r\nExperience in a high performance team is highly valued.', 'You will report to the Senior Web Developer who is also based in Bangladesh, but you will also be expected to work with Australian based staff.\r\n\r\nDay to day you will be expected to use AI assisted programming technologies (cursor, claude, chatGPT) and your own hand-coding to generate reliable and robust solutions in the following technologies.\r\n\r\nWordPress Security: Regularly update a portfolio of WordPress websites using our tools, and give product feedback to improve the tools (Kaizen).\r\n\r\nWordPress Plugin Development: We often build plugins some of which have RESTful API endpoints.\r\n\r\nYou must know how to build a plugin.\r\n\r\nBuilding RESTful API endpoints is a highly desirable skill, but not a requirement as we can train you on how to build then (our way).\r\n\r\nWebsite builds: You will be given a queue of website builds to work through where other tasks are not pressing. We use repeatable patterns and structures and code re-use, so...\r\n\r\n(1) follow procedures to build reliable and secure websites and\r\n\r\n(2) skilled enough to spot opportunities to improve our structured approach and systems.\r\n\r\nThis applies to WordPress and Laravel Website Systems.\r\n\r\nLaravel - You will be asked to write and implement unit tests and trained to support existing clients and their web application systems.\r\n\r\nBeing able to write blog posts about the work you’re doing, learning and delivering for clients is highly valued. We’re a marketing company, we like to tell people what we’re doing!\r\n\r\nApplicants, please be ready to discuss and demonstrate your understanding of these skills, concepts and day to day responsibilities.', 4, '2025-03-19 22:33:51'),
(11, 'Software Engineer(Java/Kotlin)', 'We are looking for a talented Software Engineer with a strong focus on Java and Kotlin languages to join our team. The ideal candidate will have a solid foundation in Object-Oriented Programming (OOP), software design patterns, and expertise in building scalable and maintainable software. You will work on cutting-edge projects and leverage Java/Kotlin to deliver efficient, high-performance solutions.', 'Banani', 0.00, 'Strong foundation in OOP, design patterns, and software architecture.\r\nProficiency in Java/Kotlin and related frameworks such as Spring Boot, Micronaut etc.\r\nProficiency in building, maintaining, and optimizing RESTful APIs and microservices architectures.\r\nFamiliarity with database or ORM libraries including JPA/Hibernate, QueryDSL, JOOQ etc\r\nStrong knowledge of SQL and NoSQL databases (e.g., PostgreSQL, MySQL, ElasticSearch, Redis).\r\nExperience with build tools such as Gradle for managing dependencies and automating the build process.\r\nFamiliarity with version control systems, particularly Git.\r\nUnderstanding of security best practices, including encryption, authentication, and authorization mechanisms.\r\nFamiliarity with cloud platforms like AWS and containerization technologies such as Docker and Kubernetes.\r\nExperience with CI/CD pipelines and automated testing frameworks.', 'Develop and maintain back-end applications using Java/Kotlin.\r\nDesign and implement scalable, secure, and high-performance APIs, microservices, and system integrations.\r\nCollaborate with cross-functional teams to ensure seamless integration with front-end components and other systems.\r\nOptimize application performance, troubleshoot issues, and ensure high availability and reliability.\r\nWrite clean, maintainable, and well-documented code following industry best practices.\r\nParticipate in code reviews, testing, and deployment activities to ensure high-quality deliverables.\r\nStay updated with the latest tools, frameworks, and technologies to continuously improve development practices.', 4, '2025-03-19 22:38:34'),
(12, 'Software Engineer', 'What we are looking for:\r\n• Computer Science (or related technical field) graduates or final semester students\r\n• Good programming skills in at least one of the following languages: C/C++, C#, Java or Python\r\n• Knowledge of Data Structures and Algorithms\r\n• Basic knowledge of SQL and relational databases\r\n• Ability to communicate technical concepts clearly and effectively', 'Therap (BD) Ltd. • Dhaka • via Jobs At Therap (BD) Ltd. - Trakstar', 30000.00, 'What we are looking for:\r\n• Computer Science (or related technical field) graduates or final semester students\r\n• Good programming skills in at least one of the following languages: C/C++, C#, Java or Python\r\n• Knowledge of Data Structures and Algorithms\r\n• Basic knowledge of SQL and relational databases\r\n• Ability to communicate technical concepts clearly and effectively', 'What we are looking for:\r\n• Computer Science (or related technical field) graduates or final semester students\r\n• Good programming skills in at least one of the following languages: C/C++, C#, Java or Python\r\n• Knowledge of Data Structures and Algorithms\r\n• Basic knowledge of SQL and relational databases\r\n• Ability to communicate technical concepts clearly and effectively', 13, '2025-03-20 11:58:01'),
(13, 'a', 'a', 'a', 0.00, 'a', 'a', 13, '2025-03-20 11:59:26'),
(15, 'a', 'a', 'a', 0.00, 'a', 'a', 13, '2025-03-20 12:04:40'),
(17, '1', '1', '1', 1.00, '1', '1', 13, '2025-03-20 12:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `full_name`, `bio`, `profile_photo`, `phone`, `address`, `linkedin`, `github`, `website`, `cv`, `skills`, `experience`, `created_at`, `updated_at`) VALUES
(1, 4, 'Nibir Joydhar', 'bio', 'uploads/profile_photos/1742469625_Screenshot 2025-03-16 152009.png', '0152154683', 'N/A', 'N/A', 'N/A', 'N/A', 'uploads/cvs/1742469625_data Science CA Marks.pdf', 'cp', '4 years', '2025-03-19 18:36:39', '2025-03-20 11:20:25'),
(3, 2, 'Nibir', '.', 'uploads/profile_photos/1742422528_Screenshot 2025-03-16 152009.png', '.', '.', '.', '.', '.', 'uploads/cvs/1742422438_data Science CA Marks.pdf', '.', '.', '2025-03-19 21:35:11', '2025-03-19 22:15:28'),
(4, 5, 'Hemel Ahmed', 'na', 'uploads/profile_photos/1742422585_Screenshot 2025-03-16 152009.png', '01883938712', 'Sadarghat', '.', '.', '.', 'uploads/cvs/1742456444_data Science CA Marks.pdf', '.', '.', '2025-03-19 21:59:26', '2025-03-20 07:40:44'),
(5, 7, 'Shima Akter', 'bio', 'uploads/profile_photos/1742460581_476045490_4040210449577469_6040317946914963445_n.png', '01883938712', 'Sadarghat', 'https://www.linkedin.com/in/s-m-himel-ahmed-b69a07276/', '.', '.', 'uploads/cvs/1742460581_data Science CA Marks.pdf', 'na', 'na', '2025-03-20 08:40:27', '2025-03-20 08:49:41'),
(6, 12, 'new', 'na', 'uploads/profile_photos/1742469935_476045490_4040210449577469_6040317946914963445_n.png', ',', ',', ',', ',', ',', 'uploads/cvs/1742469935_data Science CA Marks.pdf', ',', ',', '2025-03-20 11:25:12', '2025-03-20 11:25:35'),
(7, 13, 'hello', 'ok,', 'uploads/profile_photos/1742471749_Screenshot 2025-03-16 152009.png', 'ok', 'ok', 'ok', 'ok', 'ok', 'uploads/cvs/1742471749_data Science CA Marks.pdf', 'ok', 'ok', '2025-03-20 11:32:14', '2025-03-20 11:55:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('job_seeker','employer','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `status`) VALUES
(2, 'nibir', 'nibir@gmail.com', '$2y$10$CH.uQJdYZYNw6P9xH2MvYOJcOHTn4OLbnB0f2fbrBe/jJH2neisgq', 'admin', '2025-03-19 17:41:37', 'active'),
(4, 'Nibir Joydhar', 'nibirjoydhar@gmail.com', '$2y$10$ioFqqqKy.lBedi0hTsC76OVxNS8MKyhK/VOKv06gyZqKPTmpi70qC', 'employer', '2025-03-19 18:00:56', 'active'),
(5, 'Hemel Ahmed', 'ahmedhemel889@gmail.com', '$2y$10$GVu/6jTC0z1cKitDFmT9oOeh6.dx/PTTIhW3lXjcq8WZ9eodHXbDK', 'job_seeker', '2025-03-19 21:58:20', 'active'),
(7, 'Shima Hasan', 'shima@gmail.com', '$2y$10$o3roolkKYHGzrcBAMLGwk.8zK1leJwqqboJTQKey1nVZEOiWTu9.u', 'job_seeker', '2025-03-20 08:27:13', 'active'),
(8, 'Hemel ', 'hemelahmed092@gmail.com', '$2y$10$G6vBDT2XxHfZ0zdTGSvuM.Dvyp6V0wG7L.Wsx5hEvVmyVt24izp0y', 'employer', '2025-03-20 08:59:14', 'active'),
(10, 'MST SHIMA', 'mst@gmail.com', '$2y$10$DDV3TC4.6bEcsaZ.0yOSA.fZZEmKHdXplksdOYN6d0ppm1SXdZKN.', 'employer', '2025-03-20 09:04:22', 'active'),
(11, 'Joydhar', 'joydhar@gmail.com', '$2y$10$7TV.wHgGM/4GUZwjp90EwO0AZzavdCGAZgVpCnqKRim0TKiHel/Rq', 'job_seeker', '2025-03-20 11:02:48', 'active'),
(12, 'new', 'new@gmail.com', '$2y$10$2NOkqz/AD1Gq6XgcYBkLPOKoxgjOZ674Nu0D9NVQonZpnlGO1DNfG', 'job_seeker', '2025-03-20 11:22:48', 'active'),
(13, 'hi', 'hi@gmail.com', '$2y$10$2NOkqz/AD1Gq6XgcYBkLPOKoxgjOZ674Nu0D9NVQonZpnlGO1DNfG', 'employer', '2025-03-20 11:28:11', 'active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
