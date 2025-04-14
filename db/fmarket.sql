-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 02:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fmarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

CREATE TABLE `apply` (
  `f_username` varchar(200) NOT NULL,
  `job_id` varchar(30) NOT NULL,
  `bid` int(11) NOT NULL,
  `cover_letter` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `apply`
--

INSERT INTO `apply` (`f_username`, `job_id`, `bid`, `cover_letter`) VALUES
('freelancer1', '10', 20, 'This is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter'),
('freelancer2', '10', 80, 'This is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter'),
('freelancer3', '10', 100, 'This is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter\r\nThis is a cover letter'),
('Rituraj', '20', 2, 'hii i am');

-- --------------------------------------------------------

--
-- Table structure for table `company_preference`
--

CREATE TABLE `company_preference` (
  `company_username` varchar(50) NOT NULL,
  `first_pref` varchar(50) DEFAULT NULL,
  `second_pref` varchar(50) DEFAULT NULL,
  `third_pref` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_preference`
--

INSERT INTO `company_preference` (`company_username`, `first_pref`, `second_pref`, `third_pref`) VALUES
('Amazon', 'Bhargov', 'Rituraj', 'shyam123'),
('Amazon', 'Bhargov', 'Rituraj', 'shyam123'),
('xopuntech', 'Rituraj', 'Bhargov', 'Achyut'),
('WIpro', 'Achyut', 'Rituraj', 'Bhargov');

-- --------------------------------------------------------

--
-- Table structure for table `company_scores`
--

CREATE TABLE `company_scores` (
  `id` int(11) NOT NULL,
  `freelancer_username` varchar(255) DEFAULT NULL,
  `admin_username` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_scores`
--

INSERT INTO `company_scores` (`id`, `freelancer_username`, `admin_username`, `score`, `comments`, `created_at`) VALUES
(0, 'Amazon', 'admin', 90, '', '2024-11-14 17:28:09'),
(0, 'xopuntech', 'admin', 70, '', '2024-11-20 18:37:39'),
(0, 'Wipro', 'admin', 80, '', '2024-11-20 18:37:53');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `birthdate` date NOT NULL,
  `company` varchar(200) NOT NULL,
  `profile_sum` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`username`, `password`, `Name`, `email`, `contact_no`, `address`, `gender`, `birthdate`, `company`, `profile_sum`) VALUES
('Amazon', 'password', 'Amazon', 'Amazon@gmail.com', '7893737311', 'delhi', 'male', '2019-09-19', 'Amazon', ''),
('Wipro', 'password', 'Wipro', 'wipro@gmail.com', '123456', 'Delhi', 'male', '1999-11-11', 'Wipro', 'This is a profile summery'),
('xopuntech', 'password', 'xopuntech', 'xopuntech@gmail.com', '708684489', 'guwahati', 'male', '2001-09-22', 'xopuntech', 'Frontend Developer');

-- --------------------------------------------------------

--
-- Table structure for table `e_social`
--

CREATE TABLE `e_social` (
  `e_username` varchar(200) NOT NULL,
  `social_prof` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freelancer`
--

CREATE TABLE `freelancer` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `birthdate` date NOT NULL,
  `prof_title` varchar(200) NOT NULL,
  `profile_sum` varchar(1000) NOT NULL,
  `education` varchar(200) NOT NULL,
  `experience` varchar(200) NOT NULL,
  `skills` varchar(200) NOT NULL,
  `resume_link` varchar(255) DEFAULT NULL,
  `certificate_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `freelancer`
--

INSERT INTO `freelancer` (`username`, `password`, `Name`, `email`, `contact_no`, `address`, `gender`, `birthdate`, `prof_title`, `profile_sum`, `education`, `experience`, `skills`, `resume_link`, `certificate_link`) VALUES
('Achyut', 'password', 'f', 'Achyut@gmail.com', '123456', 'f', 'other', '2222-11-11', 'gggggggggg', 'lllllllll', 'Tezpur University', '2years', 'Reactjs', NULL, NULL),
('Bhargov', 'Bhargov@123', 'Bhargov gogoi', 'Bhargov@gmail.com', '7086534267', 'lakhimpum', 'male', '2001-09-19', '', '', '', '', '', NULL, NULL),
('Rituraj', 'password', 'Rituraj', 'dekarituraj95@gmail.com', '7086325788', 'mangaldai', 'male', '2001-09-22', 'Frontend Developer', 'i have experienced in React js', 'tezpur university', '2', 'ReactJs', 'https://drive.google.com/file/u/1/d/109MAjyl3PzvMBqFxJK5C62TJPzVWLkjQ/view?usp=sharing', 'https://my-portfolio-seven-rust-78.vercel.app/');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_preference`
--

CREATE TABLE `freelancer_preference` (
  `id` int(11) NOT NULL,
  `freelancer_username` varchar(255) NOT NULL,
  `first_pref` int(11) DEFAULT NULL,
  `second_pref` int(11) DEFAULT NULL,
  `third_pref` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancer_preference`
--

INSERT INTO `freelancer_preference` (`id`, `freelancer_username`, `first_pref`, `second_pref`, `third_pref`) VALUES
(4, 'Rituraj', 18, 16, 20),
(5, 'Bhargov', 16, 18, 20),
(6, 'Achyut', 20, 16, 18);

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_scores`
--

CREATE TABLE `freelancer_scores` (
  `id` int(11) NOT NULL,
  `freelancer_username` varchar(255) DEFAULT NULL,
  `admin_username` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancer_scores`
--

INSERT INTO `freelancer_scores` (`id`, `freelancer_username`, `admin_username`, `score`, `comments`, `created_at`) VALUES
(1, 'Achyut', 'admin', 20, '', '2024-10-20 18:29:10'),
(2, 'Rituraj', 'admin', 30, '', '2024-10-20 18:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `f_skill`
--

CREATE TABLE `f_skill` (
  `f_username` varchar(200) NOT NULL,
  `skill` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `f_social`
--

CREATE TABLE `f_social` (
  `f_username` varchar(200) NOT NULL,
  `social_prof` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_offer`
--

CREATE TABLE `job_offer` (
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `budget` int(11) NOT NULL,
  `skills` varchar(200) NOT NULL,
  `special_skill` varchar(200) NOT NULL,
  `e_username` varchar(200) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `job_offer`
--

INSERT INTO `job_offer` (`job_id`, `title`, `type`, `description`, `budget`, `skills`, `special_skill`, `e_username`, `valid`, `timestamp`) VALUES
(16, 'backend developer', 'WLK', 'WDKL', 20, 'DWKQ', 'DWQL', 'xopuntech', 1, '2024-10-18 18:36:39'),
(18, 'Frontend Developer', 'Full Stack developer', 'Mern Stack', 30000, 'React,js,MongoDB,ExpressJs,Node.js', 'Above 7cgpa', 'Amazon', 1, '2024-10-20 20:21:54'),
(20, 'FullStack developer', 'software development', 'Assamese', 20000, 'ReactJS', 'Frontend Development', 'Amazon', 1, '2024-11-14 16:09:35');

-- --------------------------------------------------------

--
-- Table structure for table `job_skill`
--

CREATE TABLE `job_skill` (
  `job_id` varchar(30) NOT NULL,
  `skill` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `sender` varchar(200) NOT NULL,
  `receiver` varchar(200) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`sender`, `receiver`, `msg`, `timestamp`) VALUES
('dddddd', 'mmmmmm', 'this is the first message', '2018-06-22 03:58:57'),
('dddddd', 'mmmmmm', 'second msg', '2018-06-22 04:01:16'),
('dddddd', 'ffffff', 'this message is for ffffff', '2018-06-22 05:14:33'),
('ffffff', 'dddddd', 'Hey i have got your message', '2018-06-22 05:16:16'),
('dddddd', 'ffffff', 'this is a reply', '2018-06-24 08:53:46'),
('dddddd', 'ssssss', 'Hey whats up dude', '2018-06-25 07:20:09'),
('ssssss', 'dddddd', 'I am fine', '2018-06-25 07:20:50'),
('freelancer1', 'employer3', 'This is a message', '2018-07-01 01:52:58'),
('freelancer2', 'employer3', 'This is message 2', '2018-07-01 01:54:45'),
('freelancer3', 'employer3', 'This is message 3', '2018-07-01 01:55:36'),
('employer3', 'freelancer3', 'this is reply 1', '2018-07-01 01:57:30'),
('employer3', 'freelancer2', 'this is reply 2', '2018-07-01 01:57:37'),
('employer3', 'freelancer1', 'this is reply 3', '2018-07-01 01:57:43'),
('Gajen18', 'employer1', 'hi ', '2020-02-12 20:20:10'),
('employer1', 'employer3', 'need report by today evening.', '2020-02-17 18:55:55'),
('employer1', 'Gajen18', 'i want a website in php multivender', '2020-02-17 18:56:56'),
('Gajen18', 'employer1', 'ok sir the price of multivender is 1000$', '2020-02-17 18:58:51'),
('Rituraj', 'xopuntech', 'i am interested', '2024-10-20 18:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `selected`
--

CREATE TABLE `selected` (
  `f_username` varchar(200) NOT NULL,
  `job_id` varchar(30) NOT NULL,
  `e_username` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `selected`
--

INSERT INTO `selected` (`f_username`, `job_id`, `e_username`, `price`, `valid`) VALUES
('ffffff', '8', 'dddddd', 50, 0),
('ssssss', '9', 'dddddd', 50, 1),
('Rituraj', '17', 'xopuntech', 20, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `e_social`
--
ALTER TABLE `e_social`
  ADD PRIMARY KEY (`e_username`);

--
-- Indexes for table `freelancer`
--
ALTER TABLE `freelancer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `freelancer_preference`
--
ALTER TABLE `freelancer_preference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freelancer_scores`
--
ALTER TABLE `freelancer_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_skill`
--
ALTER TABLE `f_skill`
  ADD PRIMARY KEY (`f_username`);

--
-- Indexes for table `f_social`
--
ALTER TABLE `f_social`
  ADD PRIMARY KEY (`f_username`);

--
-- Indexes for table `job_offer`
--
ALTER TABLE `job_offer`
  ADD PRIMARY KEY (`job_id`),
  ADD UNIQUE KEY `job_id` (`job_id`);

--
-- Indexes for table `job_skill`
--
ALTER TABLE `job_skill`
  ADD PRIMARY KEY (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `freelancer_preference`
--
ALTER TABLE `freelancer_preference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `freelancer_scores`
--
ALTER TABLE `freelancer_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `job_offer`
--
ALTER TABLE `job_offer`
  MODIFY `job_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
