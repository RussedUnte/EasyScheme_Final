-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 08:38 AM
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
-- Database: `easyscheme`
--

-- --------------------------------------------------------

--
-- Table structure for table `concerns`
--

CREATE TABLE `concerns` (
  `id` bigint(20) NOT NULL,
  `faculty_id` bigint(20) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `concerns`
--

INSERT INTO `concerns` (`id`, `faculty_id`, `title`, `description`, `status`) VALUES
(2, 52, 'nangongopya', 'sila ano ay nangongopya', 0),
(3, 52, 'asda', 'sdaszxczxc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` bigint(20) NOT NULL,
  `title` varchar(256) NOT NULL,
  `program` bigint(20) NOT NULL,
  `code` varchar(256) NOT NULL,
  `designation` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `title`, `program`, `code`, `designation`, `status`) VALUES
(1, 'programming fundamentals', 1, 'pf1', 'Major', 0),
(2, 'title2', 2, 'coasd', 'Major', 1),
(3, 'Bachelor of science in information system', 1, 'bsis', 'Major', 0),
(4, 'Title1', 2, 'Teaere', 'Major', 0),
(5, 'basic accountant', 4, 'ba1', 'Major', 0),
(9, 'course 1 bsig', 3, 'code 1', 'Minor', 0),
(10, 'g', 3, 'g', 'Minor', 0),
(11, 'hello', 3, 'a', 'Major', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_links`
--

CREATE TABLE `exam_links` (
  `id` bigint(20) NOT NULL,
  `schedule_details_id` bigint(20) NOT NULL,
  `link` text NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` bigint(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`, `status`) VALUES
(1, 'institute of education arts and sciences', 0),
(2, 'institute of business and management', 0),
(3, 'institute of computing studies and library information science', 0);

-- --------------------------------------------------------

--
-- Table structure for table `prof_schedule`
--

CREATE TABLE `prof_schedule` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `monday` varchar(256) NOT NULL,
  `tuesday` varchar(256) NOT NULL,
  `wednesday` varchar(256) NOT NULL,
  `thursday` varchar(256) NOT NULL,
  `friday` varchar(256) NOT NULL,
  `saturday` varchar(256) NOT NULL,
  `sunday` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prof_schedule`
--

INSERT INTO `prof_schedule` (`id`, `user_id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `status`) VALUES
(15, 76, '8:00AM - 5:00PM', 'not available', 'not available', '8:00AM - 5:00PM', '4:00PM - 5:00PM', '4:00PM - 5:00PM', '4:00PM - 5:00PM', 0),
(16, 77, '8:00AM - 5:00PM', '8:00AM - 10:00AM', 'not available', '8:00AM - 10:00AM', 'not available', '8:00AM - 10:00AM', 'not available', 0),
(17, 78, '8:00AM - 5:00PM', '8:00AM - 10:00AM', 'not available', 'not available', '2:30PM - 4:30PM', 'not available', '8:00AM - 10:00AM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `program_details`
--

CREATE TABLE `program_details` (
  `id` bigint(20) NOT NULL,
  `program_name` varchar(256) NOT NULL,
  `institute` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_details`
--

INSERT INTO `program_details` (`id`, `program_name`, `institute`, `status`) VALUES
(1, 'BSIS', 3, 0),
(2, 'BSIT', 3, 0),
(3, 'BSIG', 3, 0),
(4, 'ABM', 2, 0),
(5, 'xxxx', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` bigint(20) NOT NULL,
  `room_number` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_number`, `status`) VALUES
(1, 'Room 225', 0),
(2, 'Room 1', 0),
(3, 'Room 356', 0),
(4, 'Room 23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` bigint(20) NOT NULL,
  `semester` varchar(256) NOT NULL,
  `exam_type` varchar(256) NOT NULL,
  `institute` bigint(20) NOT NULL,
  `program` bigint(20) NOT NULL,
  `year_level` varchar(256) NOT NULL,
  `school_year` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `semester`, `exam_type`, `institute`, `program`, `year_level`, `school_year`, `status`) VALUES
(13, '2nd Semester', 'Midterm', 3, 3, '2nd year', '2024-2025', 0),
(14, '1st Semester', 'Midterm', 3, 2, '2nd year', '2023-2024', 0),
(15, '1st Semester', 'Prelim', 3, 3, '1st year', '2023-2024', 0),
(16, '2nd Semester', 'Midterm', 2, 5, '2nd year', '2024-2025', 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_details`
--

CREATE TABLE `schedule_details` (
  `id` bigint(20) NOT NULL,
  `section_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `room_id` bigint(20) NOT NULL,
  `proctor_id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_details`
--

INSERT INTO `schedule_details` (`id`, `section_id`, `course_id`, `schedule_id`, `date`, `time_start`, `time_end`, `room_id`, `proctor_id`, `status`) VALUES
(79, 40, 3, 14, '2024-09-24', '16:26:00', '17:26:00', 4, 49, 0),
(134, 47, 10, 13, '2024-09-27', '16:00:00', '17:00:00', 2, 76, 0),
(135, 47, 11, 13, '2024-09-26', '18:25:00', '19:25:00', 3, 76, 0),
(138, 46, 10, 13, '2024-09-23', '11:25:00', '12:25:00', 1, 77, 0),
(139, 46, 11, 13, '2024-09-23', '11:25:00', '12:25:00', 2, 76, 0);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` bigint(20) NOT NULL,
  `section` varchar(256) NOT NULL,
  `year_level` varchar(256) NOT NULL,
  `program_id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `section`, `year_level`, `program_id`, `status`) VALUES
(36, 'Bsit1A', '1st Year', 2, 0),
(37, 'Bsit1B', '1st Year', 2, 0),
(38, 'BSIT3B', '3rd Year', 2, 0),
(40, 'BSIT2C', '2nd Year', 2, 0),
(46, 'zzzz', '2nd Year', 3, 0),
(47, 'hakdog', '2nd Year', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `section_course`
--

CREATE TABLE `section_course` (
  `id` int(11) NOT NULL,
  `section_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_course`
--

INSERT INTO `section_course` (`id`, `section_id`, `course_id`, `status`) VALUES
(16, 36, 3, 0),
(17, 36, 4, 0),
(18, 36, 5, 0),
(19, 37, 3, 0),
(20, 38, 4, 0),
(21, 38, 3, 0),
(22, 37, 4, 0),
(24, 40, 3, 0),
(26, 37, 1, 0),
(28, 46, 10, 0),
(29, 38, 10, 0),
(30, 46, 11, 0),
(31, 47, 10, 0),
(32, 47, 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `id` bigint(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `student_number` varchar(256) NOT NULL,
  `institute` bigint(20) NOT NULL,
  `section` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`id`, `name`, `student_number`, `institute`, `section`, `status`) VALUES
(15, 'test student', '143', 2, 36, 0),
(43, 'Fredrin Goegro', '123112', 3, 36, 0),
(45, 'Renzo Ji', '112-3111', 3, 38, 0),
(46, 'Yu zong', '3321123', 3, 40, 0),
(55, 'asd', '123123', 3, 36, 0),
(56, 'asd', '12312111', 3, 36, 0),
(57, 'asdasd', '091231-1231', 3, 36, 0),
(58, 'Asds', '3123', 2, 46, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `position` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `position`, `status`) VALUES
(1, 'Alice Gou', 'scheduler', '$2y$10$LHSRNnV8fTpZaRpKJuC2Kem0DY5yjMFwIw9DdiwpQ0Ul4HEEQb70W', 'scheduler', 0),
(49, 'Faculty', 'faculty', '$2y$10$odhowgemTjsr7HGz62xd1uWnKVtuxWs0HNp7T0dnyRm1O7BOjf5wG', 'faculty', 0),
(50, 'Faczxc', 'facultyss', '$2y$10$6BYEzcZ8HBof.FLF4tChf.5bLos8T23jMkOD.3.P8W35LHg81aAMK', 'faculty', 1),
(52, 'zxczxczxc', 'zxczxczxc', '$2y$10$gpCMLhJeAW4h1oDJOvLj3O31t37DgyUvlrpBbUREGz0ySSOHlrOby', 'faculty', 0),
(53, 'ybone', 'ak', '$2y$10$yOHSjWyx9FFAYKvgLbyo/eNMeefArY447NaOzr21thtGSYubBbOES', 'faculty', 0),
(54, 'igado', 'igado', '$2y$10$R.kl7HhAc5RKw5whsFD/Wek2f5lVWAqTXmWuiQXd8ucvw2opxsKFy', 'faculty', 0),
(55, 'testing lang', 'testinglang', '$2y$10$Aq7GAfL18gqb8Eip9sZ8SeAzWtIha08q1s9ZP9XnPXltkRqdWD/f.', 'faculty', 1),
(56, 'hatdog', 'asdasd', '$2y$10$3XhUNiiKO4Jfz3RQvCXKW.3ahV7jvgdrIKpaiXVRBew6tBKN5uGrO', 'faculty', 0),
(57, 'test', 'test', '$2y$10$DJsLAbQz63HOi/Iaqh9GiuMakjj9jQdvQV03lDs4IAgqp6ukRWHxe', 'faculty', 0),
(76, 'Ji Hama', 'JiHama', '$2y$10$pW9tg0MFAf6H.jgV2x6nveb13WQVFSPDyv8XKNx/eQQABeivD8gHu', 'faculty', 0),
(77, 'Rara Mi', 'RaraMi', '$2y$10$3aqS9aXBUGE0urPiaApEiOeBRLgKDodjVL0fo7nlsiH.iHzHE6EVu', 'faculty', 0),
(78, 'Facundo Yi', 'FacundoYi', '$2y$10$p8boFeKzzCOqwt5mv6JS0.iPGC.e1fk6CqyzujdrKU2yH7pjhdV6e', 'faculty', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `salutation` varchar(20) NOT NULL,
  `status` varchar(256) NOT NULL,
  `institute` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `salutation`, `status`, `institute`) VALUES
(30, 57, 'Mr.', 'Full-time', 3),
(34, 76, 'mr', 'Full-time', 1),
(35, 77, 'ms', 'Part-time', 2),
(36, 78, 'mr', 'Full-time', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `concerns`
--
ALTER TABLE `concerns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_links`
--
ALTER TABLE `exam_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_links_ibfk_1` (`schedule_details_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prof_schedule`
--
ALTER TABLE `prof_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_details`
--
ALTER TABLE `program_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_details`
--
ALTER TABLE `schedule_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_course`
--
ALTER TABLE `section_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_number` (`student_number`),
  ADD KEY `section` (`section`),
  ADD KEY `institute` (`institute`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `institute` (`institute`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `concerns`
--
ALTER TABLE `concerns`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `exam_links`
--
ALTER TABLE `exam_links`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prof_schedule`
--
ALTER TABLE `prof_schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `program_details`
--
ALTER TABLE `program_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `schedule_details`
--
ALTER TABLE `schedule_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `section_course`
--
ALTER TABLE `section_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_links`
--
ALTER TABLE `exam_links`
  ADD CONSTRAINT `exam_links_ibfk_1` FOREIGN KEY (`schedule_details_id`) REFERENCES `schedule_details` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_details`
--
ALTER TABLE `student_details`
  ADD CONSTRAINT `student_details_ibfk_2` FOREIGN KEY (`section`) REFERENCES `section` (`id`),
  ADD CONSTRAINT `student_details_ibfk_3` FOREIGN KEY (`institute`) REFERENCES `institutes` (`id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_details_ibfk_2` FOREIGN KEY (`institute`) REFERENCES `institutes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
