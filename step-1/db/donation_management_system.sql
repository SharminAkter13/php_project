-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2025 at 07:01 AM
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
-- Database: `donation_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `required_support` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beneficiaries`
--

INSERT INTO `beneficiaries` (`id`, `name`, `email`, `phone`, `address`, `required_support`, `created_at`, `user_id`) VALUES
(1, 'johnny', 'johnny@gmail.com', '021457454', '4/78 los angle,usa', 'Fresh Water', '2025-08-13 06:32:32', 11),
(2, 'john', 'john@gmail.com', '021457454', '4/78 los angle,usa', 'Fresh Water', '2025-08-13 06:32:43', 12),
(5, 'Charlie Brown', 'charlie.b@email.com', '0148586356', '4/78 New York,, USA', 'Emergency relief', '2025-08-20 04:02:47', 7),
(6, 'Charlie Brown', 'charlie.b@email.com', '0148586356', '4/78 New York,, USA', 'Emergency relief', '2025-08-20 04:20:27', 7);

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descriptions` varchar(400) NOT NULL,
  `goal_amount` int(11) DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `event_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `name`, `descriptions`, `goal_amount`, `start_date`, `end_date`, `status`, `event_id`, `file_path`) VALUES
(1, 'Charity Run 2025', 'A marathon to raise funds for community development.', 20000, '2025-08-15 18:00:00', '2025-08-31', 'Active', 1, 'charity_run.jpg'),
(2, 'Food Donation Drive', 'Collecting and distributing food for underprivileged families.', 15000, '2025-08-16 07:57:17', '2025-02-15', 'Inactive', 2, 'food_drive.jpg'),
(4, 'Emergency Relief', 'Immediate assistance for families affected by natural disasters.', 30000, '2025-08-22 18:00:00', '2025-09-09', 'Active', 4, 'emergency_relief.jpg'),
(5, 'Health Checkup Camp', 'Free medical checkups and awareness sessions for the community.', 10000, '2025-09-30 18:00:00', '2025-11-01', 'Active', 5, 'health_camp.jpg'),
(6, 'Fresh Water ', 'Fresh water for village people', 100000, '2025-08-22 18:00:00', '2025-09-12', 'Active', 1, 'uploads/cause-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_management`
--

CREATE TABLE `campaign_management` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fund_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `beneficiary_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaign_management`
--

INSERT INTO `campaign_management` (`id`, `name`, `fund_id`, `user_id`, `beneficiary_id`) VALUES
(1, 'programmer diva\r\n', 3, 4, 2),
(2, '\r\nAlice Johnson\r\n', 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_id` int(11) DEFAULT NULL,
  `fund_id` int(11) DEFAULT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `pledge_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `name`, `amount`, `date`, `payment_id`, `fund_id`, `donor_id`, `pledge_id`, `campaign_id`) VALUES
(1, 'Bob Smith', 500, '2025-08-16 18:44:44', 3, 3, 11, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pledge_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `name`, `contact`, `type`, `user_id`, `pledge_id`) VALUES
(11, 'Bob Smith\r\n', 'bob.s@email.com', 'Individual', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `location`, `date`) VALUES
(1, 'Charity Run 2025', 'Central Park, New York', '2025-09-15 03:00:00'),
(2, 'Food Donation Drive', 'Community Hall, Boston', '2025-08-25 04:00:00'),
(3, 'School Fundraising Gala', 'Hilton Hotel, Chicago', '2025-10-05 13:00:00'),
(4, 'Emergency Relife  ', ' Gaza, Palestine', '2025-11-20 08:00:00'),
(5, 'Health Checkup Camp', 'Community Center, Dallas', '2025-09-30 02:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `name`, `status`) VALUES
(1, 'Disaster Relief Fund', 'Active'),
(2, 'Education Scholarship', 'Inactive'),
(3, 'Medical Aid', 'Active'),
(4, 'Community Development', 'Active'),
(5, 'Orphanage Support', 'Active'),
(6, 'Environmental Protection', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `type`) VALUES
(1, 'Credit Card'),
(2, 'PayPal'),
(3, 'Bank Transfer'),
(4, 'Check'),
(5, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `pledges`
--

CREATE TABLE `pledges` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pledge_amount` int(11) DEFAULT NULL,
  `pledge_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `donor_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pledges`
--

INSERT INTO `pledges` (`id`, `name`, `pledge_amount`, `pledge_date`, `status`, `donor_id`, `campaign_id`) VALUES
(2, 'Pledge for Education', 500, '2025-08-16 07:19:06', 'Pending', 11, 1),
(3, 'Pledge for Medical Aid', 1000, '2025-08-16 07:19:18', 'Pending', 11, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(5, 'beneficiary'),
(4, 'campaign_manager'),
(2, 'donor'),
(3, 'volunteer');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `status`, `date`, `amount`, `payment_id`, `donor_id`, `campaign_id`) VALUES
(3, 'complete', '2025-08-16 07:25:46', 500, 2, 11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role_id`, `created_at`) VALUES
(3, 'Sharmin', 'Akter', 'sharminakter@gmail.com', '$2y$10$uzHD1Z4lXppoB/Rck.pnIOImOQryJpFIu4XgPjVfmGrF0qHqJ4/w6', 1, '2025-08-15 18:16:30'),
(4, 'programmer', 'diva', 'programmer@gmail.com', '$2y$10$FDLcmWXz1IdOum52bD1OiO6SFVJ97Z2g1WgZlQsAdogeAJ4Lcg5Pe', 4, '2025-08-15 18:18:11'),
(5, 'Alice', 'Johnson', 'alice.j@email.com', 'password123', 3, '2025-08-16 06:57:21'),
(6, 'Bob', 'Smith', 'bob.s@email.com', 'password456', 3, '2025-08-16 06:57:21'),
(7, 'Charlie', 'Brown', 'charlie.b@email.com', 'password789', 5, '2025-08-16 06:57:21'),
(8, 'Diana', 'Miller', 'diana.m@email.com', 'passwordabc', 3, '2025-08-16 06:57:21'),
(9, 'Ayaan', 'Mohammad', 'ayaan@gmail.com', '$2y$10$JryyXYRfPOi50gP9asod3uJDcim3CpJMkKfz36K54QeH74iJojE2O', 2, '2025-08-20 03:18:34'),
(11, 'johnny', 'jonh', 'johnny@gmail.com', '$2y$10$N.PTawvJGtDua0OCtc6GDO2gnqqNpjh6Y8lME0bBYo7unLwOxg8bG', 5, '2025-08-20 03:53:04'),
(12, 'john', 'doe', 'john@gmail.com', '$2y$10$wWbdTZSK1gJqQ0sK4aXDTeFlbo8jnRGOUmG2pWBr/1dllyHjAc2Ei', 5, '2025-08-20 03:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `task` varchar(255) DEFAULT NULL,
  `availability_status` enum('Available','Unavailable') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`id`, `name`, `contact`, `task`, `availability_status`, `created_at`, `event_id`, `user_id`) VALUES
(3, 'Alice Johnson', 'alice.j@email.com', 'Event Management', 'Unavailable', '2025-08-16 06:59:59', 1, 5),
(4, 'Bob Smith', 'bob.s@email.com', 'Food Sorting', 'Available', '2025-08-16 06:59:59', 2, 5),
(5, 'Charlie Brown', 'charlie.b@email.com', 'Community Outreach', 'Available', '2025-08-16 06:59:59', 1, 5),
(6, 'Diana Miller', 'diana.m@email.com', 'Fundraising', 'Available', '2025-08-16 06:59:59', 3, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `campaign_management`
--
ALTER TABLE `campaign_management`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fund_id` (`fund_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `beneficiary_id` (`beneficiary_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `fund_id` (`fund_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `pledge_id` (`pledge_id`),
  ADD KEY `fk_campaign` (`campaign_id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_donors_pledges` (`pledge_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pledges`
--
ALTER TABLE `pledges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `fk_pledges_donors` (`donor_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `campaign_management`
--
ALTER TABLE `campaign_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pledges`
--
ALTER TABLE `pledges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `campaign_management`
--
ALTER TABLE `campaign_management`
  ADD CONSTRAINT `campaign_management_ibfk_1` FOREIGN KEY (`fund_id`) REFERENCES `funds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `campaign_management_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `campaign_management_ibfk_3` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`fund_id`) REFERENCES `funds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donations_ibfk_3` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donations_ibfk_4` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_campaign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donors`
--
ALTER TABLE `donors`
  ADD CONSTRAINT `donors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_donors_pledges` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pledges`
--
ALTER TABLE `pledges`
  ADD CONSTRAINT `fk_pledges_donors` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pledges_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD CONSTRAINT `volunteer_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volunteer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
