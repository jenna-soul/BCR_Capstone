-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2025 at 12:03 AM
-- Server version: 8.0.41
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jsoldner_BCR`
--

-- --------------------------------------------------------

--
-- Table structure for table `Audit`
--

CREATE TABLE `Audit` (
  `AuditID` int NOT NULL,
  `ID` varchar(200) NOT NULL,
  `LoginDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Audit`
--

INSERT INTO `Audit` (`AuditID`, `ID`, `LoginDate`) VALUES
(1, '1', '2025-04-05 23:40:23'),
(2, '1', '2025-04-06 20:26:31'),
(3, '1', '2025-04-07 19:25:20'),
(4, 'user88@example.com', '2025-04-07 19:49:08'),
(5, 'user88@example.com', '2025-04-07 19:49:14'),
(6, '1', '2025-04-07 19:52:41'),
(7, 'user88@example.com', '2025-04-07 19:53:52'),
(8, 'user88@example.com', '2025-04-07 20:00:14'),
(9, '1', '2025-04-07 20:15:10'),
(10, '1', '2025-04-07 20:15:31'),
(11, 'user88@example.com', '2025-04-07 20:15:38'),
(12, 'user88@example.com', '2025-04-07 20:17:04'),
(13, 'user88@example.com', '2025-04-07 20:18:05'),
(14, 'user88@example.com', '2025-04-07 20:28:32'),
(15, 'user88@example.com', '2025-04-07 21:06:04'),
(16, 'user88@example.com', '2025-04-07 21:06:21'),
(17, 'user88@example.com', '2025-04-07 21:24:05'),
(18, 'user726@example.com', '2025-04-07 21:53:12'),
(19, 'user726@example.com', '2025-04-07 21:54:03'),
(20, 'user726@example.com', '2025-04-07 21:55:41'),
(21, '1', '2025-04-07 21:56:30'),
(22, 'user726@example.com', '2025-04-07 22:08:43'),
(23, 'user726@example.com', '2025-04-07 22:09:20'),
(24, 'user119@example.com', '2025-04-07 22:17:40'),
(25, 'user88@example.com', '2025-04-07 22:23:10'),
(26, 'user88@example.com', '2025-04-07 22:27:36'),
(27, 'user88@example.com', '2025-04-07 22:28:03'),
(28, 'user88@example.com', '2025-04-07 22:29:27'),
(29, 'user88@example.com', '2025-04-07 22:30:56'),
(30, 'user88@example.com', '2025-04-07 22:34:06'),
(31, 'user88@example.com', '2025-04-07 22:34:21'),
(32, 'user88@example.com', '2025-04-07 22:34:25'),
(33, 'user88@example.com', '2025-04-07 22:35:00'),
(34, 'user695@example.com', '2025-04-07 22:36:44'),
(35, '1', '2025-04-07 22:46:20'),
(36, '1', '2025-04-07 22:46:37'),
(37, 'user825@example.com', '2025-04-07 23:03:37'),
(38, '9', '2025-04-07 23:07:18'),
(39, '1', '2025-04-07 23:11:43'),
(40, '1', '2025-04-07 23:28:35'),
(41, 'user88@example.com', '2025-04-08 00:35:30'),
(42, '1', '2025-04-08 00:35:42'),
(43, '11', '2025-04-08 00:48:58'),
(44, '1', '2025-04-08 00:49:20'),
(45, 'user88@example.com', '2025-04-08 00:51:50'),
(46, '1', '2025-04-08 00:53:40'),
(47, '1', '2025-04-08 22:35:34'),
(48, '9', '2025-04-09 22:06:24'),
(49, 'user88@example.com', '2025-04-09 22:09:58');

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE `Customers` (
  `CustID` int NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `StreetAdr` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` int NOT NULL,
  `LateFees` decimal(10,2) NOT NULL DEFAULT '0.00',
  `password` varchar(20) DEFAULT 'password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Customers`
--

INSERT INTO `Customers` (`CustID`, `FirstName`, `LastName`, `Phone`, `Email`, `StreetAdr`, `City`, `State`, `Zip`, `LateFees`, `password`) VALUES
(2, 'Janet', 'Smith', '555-5678', 'user88@example.com', '456 Oak St', 'Los Angeles', 'CA', 90002, 0.00, 'password'),
(3, 'Michael', 'Johnson', '555-8765', 'user542@example.com', '789 Pine St', 'Chicago', 'IL', 60601, 0.00, 'password'),
(4, 'Emily', 'Davis', '555-4321', 'user447@example.com', '321 Maple Ave', 'Houston', 'TX', 77001, 0.00, 'password'),
(5, 'Chris', 'Wilson', '555-6789', 'user607@example.com', '987 Birch St', 'Phoenix', 'AZ', 85001, 1.50, 'password'),
(6, 'Jessica', 'Martinez', '555-2345', 'user697@example.com', '741 Cedar Rd', 'Philadelphia', 'PA', 19101, 0.00, 'password'),
(7, 'David', 'Anderson', '555-3456', 'user664@example.com', '852 Spruce Dr', 'San Antonio', 'TX', 78201, 0.00, 'password'),
(8, 'Sarah', 'Thomas', '555-4567', 'user227@example.com', '963 Walnut Ln', 'San Diego', 'CA', 92101, 0.00, 'password'),
(9, 'James', 'Taylor', '555-5670', 'user147@example.com', '159 Elm St', 'Dallas', 'TX', 75201, 0.00, 'password'),
(10, 'Laura', 'Harris', '555-6781', 'user52@example.com', '357 Poplar Blvd', 'San Jose', 'CA', 95101, 0.00, 'password'),
(12, 'Megan', 'Lewis', '555-8903', 'user941@example.com', '369 Redwood Rd', 'San Francisco', 'CA', 94101, 0.00, 'password'),
(13, 'Kevin', 'Walker', '555-9014', 'user248@example.com', '753 Chestnut St', 'Columbus', 'OH', 43201, 3.00, 'password'),
(14, 'Ashley', 'Hall', '555-0125', 'user419@example.com', '852 Magnolia St', 'Fort Worth', 'TX', 76101, 1.50, 'password'),
(15, 'Matthew', 'Allen', '555-1236', 'user351@example.com', '951 Dogwood Dr', 'Charlotte', 'NC', 28201, 1.50, 'password'),
(16, 'Olivia', 'Young', '555-2347', 'user498@example.com', '753 Juniper St', 'Indianapolis', 'IN', 46201, 0.00, 'password'),
(17, 'Ethan', 'King', '555-3458', 'user438@example.com', '369 Sycamore Ln', 'Seattle', 'WA', 98101, 0.00, 'password'),
(18, 'Sophia', 'Scott', '555-4569', 'user695@example.com', '147 Willow Blvd', 'Denver', 'CO', 80201, 1.50, 'password'),
(19, 'Daniel', 'Green', '555-5671', 'user162@example.com', '258 Hickory Rd', 'Washington', 'DC', 20001, 0.00, 'password'),
(20, 'Ava', 'Adams', '555-6782', 'user726@example.com', '357 Aspen Ave', 'Boston', 'MA', 2101, 0.00, 'password'),
(21, 'Logan', 'Baker', '555-7893', 'user146@example.com', '741 Sequoia Dr', 'Nashville', 'TN', 37201, 0.00, 'password'),
(22, 'Emma', 'Perez', '555-8904', 'user551@example.com', '852 Palm St', 'Baltimore', 'MD', 21201, 0.00, 'password'),
(23, 'Alexander', 'Carter', '555-9015', 'user318@example.com', '963 Bayberry Rd', 'Louisville', 'KY', 40201, 0.00, 'password'),
(24, 'Madison', 'Mitchell', '555-0126', 'user938@example.com', '159 Cedar St', 'Portland', 'OR', 97201, 0.00, 'password'),
(25, 'Jackson', 'Roberts', '555-1237', 'user736@example.com', '753 Laurel Blvd', 'Oklahoma City', 'OK', 73101, 0.00, 'password'),
(26, 'Chloe', 'Campbell', '555-2348', 'user865@example.com', '258 Fir Rd', 'Las Vegas', 'NV', 89101, 3.00, 'password'),
(27, 'Lucas', 'Gonzalez', '555-3459', 'user119@example.com', '369 Olive St', 'Detroit', 'MI', 48201, 4.50, 'password'),
(28, 'Lily', 'Phillips', '555-4570', 'user2@example.com', '741 Mahogany Ln', 'Memphis', 'TN', 38101, 0.00, 'password'),
(29, 'Mason', 'Evans', '555-5672', 'user652@example.com', '852 Beech Blvd', 'Milwaukee', 'WI', 53201, 0.00, 'password'),
(30, 'Zoe', 'Torres', '555-6783', 'user254@example.com', '963 Pinecone Dr', 'Albuquerque', 'NM', 87101, 0.00, 'password'),
(31, 'Caleb', 'Morris', '555-7894', 'user316@example.com', '159 Hickory Ln', 'Tucson', 'AZ', 85701, 0.00, 'password'),
(32, 'Samantha', 'Rodriguez', '555-8905', 'user817@example.com', '357 Maple St', 'Fresno', 'CA', 93701, 1.50, 'password'),
(33, 'Henry', 'Walker', '555-9016', 'user138@example.com', '258 Oakwood Ave', 'Sacramento', 'CA', 95801, 0.00, 'password'),
(34, 'Ella', 'Hall', '555-0127', 'user238@example.com', '741 Alder Dr', 'Kansas City', 'MO', 64101, 0.00, 'password'),
(35, 'Benjamin', 'Nelson', '555-1238', 'user780@example.com', '852 Cypress St', 'Mesa', 'AZ', 85201, 0.00, 'password'),
(36, 'Avery', 'King', '555-2349', 'user184@example.com', '963 Spruce Ln', 'Atlanta', 'GA', 30301, 0.00, 'password'),
(37, 'Samuel', 'Wright', '555-3460', 'user579@example.com', '159 Willow Blvd', 'Colorado Springs', 'CO', 80901, 0.00, 'password'),
(38, 'Victoria', 'Lopez', '555-4571', 'user345@example.com', '753 Dogwood Dr', 'Virginia Beach', 'VA', 23450, 0.00, 'password'),
(39, 'Carter', 'Lee', '555-5673', 'user987@example.com', '258 Palm St', 'Raleigh', 'NC', 27601, 0.00, 'password'),
(40, 'Natalie', 'Martinez', '555-7895', 'user901@example.com', '369 Redwood Ave', 'Omaha', 'NE', 68101, 121.50, 'password'),
(41, 'Grayson', 'Anderson', '555-8906', 'user545@example.com', '741 Poplar Blvd', 'Miami', 'FL', 33101, 4.50, 'password'),
(42, 'Hailey', 'Thomas', '555-9017', 'user20@example.com', '852 Willow Rd', 'Oakland', 'CA', 94601, 0.00, 'password'),
(43, 'Jack', 'Hernandez', '555-0128', 'user468@example.com', '963 Spruce Blvd', 'Minneapolis', 'MN', 55401, 0.00, 'password'),
(44, 'Chloe', 'Nelson', '555-1238', 'user281@example.com', '258 Elm St', 'Arlington', 'TX', 76001, 0.00, 'password'),
(45, 'Landon', 'Scott', '555-2350', 'user2@example.com', '369 Cedar Rd', 'New Orleans', 'LA', 70101, 0.00, 'password'),
(46, 'Grace', 'Baker', '555-3461', 'user166@example.com', '741 Hickory St', 'Tampa', 'FL', 33601, 0.00, 'password'),
(47, 'Benjamin', 'Allen', '555-4572', 'user825@example.com', '852 Oak Ave', 'Newark', 'NJ', 7101, 0.00, 'password'),
(48, 'Amelia', 'Hernandez', '555-7896', 'user627@example.com', '963 Mahogany Rd', 'Orlando', 'FL', 32801, 0.00, 'password'),
(50, 'Madeline', 'Young', '555-0129', 'user429@example.com', '357 Sequoia Dr', 'Aurora', 'CO', 80001, 0.00, 'password'),
(51, 'Noah', 'Gonzalez', '555-2340', '', '258 Pine Rd', 'Minneapolis', 'MN', 55401, 0.00, 'password'),
(53, 'John', 'Deere', '123455786', 'john@doe.test.com', '123', 'Chicago', 'IL', 12345, 0.00, 'password');

-- --------------------------------------------------------

--
-- Table structure for table `Movies`
--

CREATE TABLE `Movies` (
  `MovieID` int NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Category` enum('Current Hit','Current Release','Popular','Regular') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Cost` decimal(10,2) DEFAULT NULL,
  `Genre` varchar(100) NOT NULL,
  `ReleaseYear` year NOT NULL,
  `LengthMin` int NOT NULL,
  `Lang` varchar(100) NOT NULL,
  `LeadActors` varchar(200) NOT NULL,
  `Director` varchar(200) NOT NULL,
  `Status` enum('Available','Rented') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ReturnDate` date DEFAULT NULL,
  `PurchaseDate` date DEFAULT NULL,
  `PurchaseCost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Movies`
--

INSERT INTO `Movies` (`MovieID`, `Title`, `Category`, `Cost`, `Genre`, `ReleaseYear`, `LengthMin`, `Lang`, `LeadActors`, `Director`, `Status`, `ReturnDate`, `PurchaseDate`, `PurchaseCost`) VALUES
(1, 'Inception', 'Popular', 1.00, 'Sci-Fi', '2010', 149, 'Spanish', 'Leonardo DiCaprio, Joseph Gordon-Levitt', 'Christopher Nolan', 'Rented', '2025-04-08', '2018-06-27', 35.35),
(2, 'The Dark Knight', 'Current Hit', 2.00, 'Action', '2008', 152, 'English', 'Christian Bale, Heath Ledger', 'Christopher Nolan', 'Available', NULL, '2018-08-21', 97.46),
(3, 'Parasite', 'Current Release', 1.50, 'Thriller', '2019', 132, 'Korean', 'Song Kang-ho, Lee Sun-kyun', 'Bong Joon-ho', 'Available', NULL, '2022-09-12', 93.56),
(4, 'Spirited Away', 'Popular', 1.00, 'Animation', '2001', 125, 'Japanese', 'Rumi Hiiragi, Miyu Irino', 'Hayao Miyazaki', 'Rented', '2025-04-15', '2018-05-13', 90.54),
(5, 'The Godfather', 'Regular', 0.50, 'Crime', '1972', 175, 'English', 'Marlon Brando, Al Pacino', 'Francis Ford Coppola', 'Available', NULL, '2019-09-02', 68.21),
(6, 'Titanic', 'Popular', 1.00, 'Romance', '1997', 195, 'English', 'Leonardo DiCaprio, Kate Winslet', 'James Cameron', 'Available', NULL, '2023-05-12', 31.07),
(7, 'The Matrix', 'Current Hit', 2.00, 'Sci-Fi', '1999', 136, 'English', 'Keanu Reeves, Laurence Fishburne', 'Lana Wachowski, Lilly Wachowski', 'Available', NULL, '2021-08-31', 66.41),
(8, 'Pulp Fiction', 'Regular', 0.50, 'Crime', '1994', 154, 'English', 'John Travolta, Uma Thurman', 'Quentin Tarantino', 'Rented', '2025-04-14', '2016-05-14', 82.18),
(9, 'Coco', 'Current Release', 1.50, 'Animation', '2017', 105, 'English, Spanish', 'Anthony Gonzalez, Gael García Bernal', 'Lee Unkrich', 'Available', NULL, '2021-01-05', 63.79),
(10, 'La La Land', 'Current Hit', 2.00, 'Musical', '2016', 128, 'English', 'Ryan Gosling, Emma Stone', 'Damien Chazelle', 'Rented', '2025-04-14', '2016-11-10', 22.27),
(11, 'Tangled', 'Regular', 0.50, 'Family Friendly, Adventure, Princess', '2010', 100, 'English', 'Mandy Moore, Zachary Levi', 'Nathan Greno, Byron Howard', 'Rented', '2025-04-15', '2016-03-30', 29.13),
(12, 'Flow', 'Popular', 1.00, 'Animated, Family, Fantasy', '2024', 84, 'English', '', 'Gints Zilbalodis', 'Rented', '2025-04-08', '2021-11-27', 82.98),
(18, 'Inkheart', 'Regular', 0.50, 'Fantasy', '2010', 100, 'English', '', 'Iain Softley', 'Rented', '2025-04-08', '2024-11-11', 54.38),
(19, 'The Last Horizon', 'Current Hit', 2.00, 'Action, Adventure, Sci-Fi', '2025', 135, 'English', 'John Doe, Jane Smith', 'Sam Johnson', 'Available', NULL, '2020-02-09', 16.41),
(20, 'Interstellar', 'Popular', 1.00, 'Sci-Fi', '2014', 169, 'English', 'Matthew McConaughey, Anne Hathaway', 'Christopher Nolan', 'Available', NULL, '2023-04-09', 92.40),
(21, 'The Prestige', 'Regular', 0.50, 'Drama', '2006', 130, 'English', 'Christian Bale, Hugh Jackman', 'Christopher Nolan', 'Rented', '2025-04-08', '2016-01-02', 77.89),
(22, 'Django Unchained', 'Current Release', 1.50, 'Western', '2012', 165, 'English', 'Jamie Foxx, Christoph Waltz', 'Quentin Tarantino', 'Rented', '2025-04-15', '2019-09-20', 18.35),
(23, 'Blade Runner 2049', 'Current Hit', 2.00, 'Sci-Fi', '2017', 164, 'English', 'Ryan Gosling, Harrison Ford', 'Denis Villeneuve', 'Available', NULL, '2015-07-04', 97.70),
(24, 'The Lion King', 'Regular', 0.50, 'Animation', '1994', 88, 'English', 'Matthew Broderick, James Earl Jones', 'Roger Allers, Rob Minkoff', 'Available', NULL, '2022-03-19', 71.05),
(26, 'The Avengers', 'Current Hit', 2.00, 'Action', '2012', 143, 'English', 'Robert Downey Jr., Chris Evans', 'Joss Whedon', 'Available', NULL, '2017-04-22', 20.59),
(27, 'Finding Nemo', 'Regular', 0.50, 'Animation', '2003', 100, 'English', 'Albert Brooks, Ellen DeGeneres', 'Andrew Stanton', 'Rented', '2025-04-08', '2023-12-24', 21.83),
(28, 'Joker', 'Current Release', 1.50, 'Thriller', '2019', 122, 'English', 'Joaquin Phoenix, Robert De Niro', 'Todd Phillips', 'Rented', '2025-04-15', '2024-09-04', 49.40),
(29, 'The Social Network', 'Regular', 0.50, 'Drama', '2010', 120, 'English', 'Jesse Eisenberg, Andrew Garfield', 'David Fincher', 'Rented', '2025-04-08', '2017-11-25', 22.22),
(30, 'Rashomon', 'Popular', 1.00, 'Drama', '1950', 88, 'Japanese', 'Toshirô Mifune, Machiko Kyô', 'Akira Kurosawa', 'Rented', '2025-04-14', '2023-02-07', 67.52),
(31, 'Amélie', 'Popular', 1.00, 'Romance', '2001', 122, 'French', 'Audrey Tautou, Mathieu Kassovitz', 'Jean-Pierre Jeunet', 'Rented', '2025-04-07', '2022-09-07', 92.85),
(32, 'The Lives of Others', 'Popular', 1.00, 'Drama', '2006', 137, 'German', 'Ulrich Mühe, Martina Gedeck', 'Florian Henckel von Donnersmarck', 'Rented', '2025-04-08', '2018-01-03', 76.57),
(33, 'Pan’s Labyrinth', 'Current Release', 1.50, 'Fantasy', '2006', 118, 'Spanish', 'Ivana Baquero, Sergi López', 'Guillermo del Toro', 'Rented', '2025-04-14', '2022-12-26', 79.20),
(34, 'City of God', 'Current Hit', 2.00, 'Crime', '2002', 130, 'Portuguese', 'Alexandre Rodrigues, Leandro Firmino', 'Fernando Meirelles, Kátia Lund', 'Rented', '2025-04-08', '2019-07-10', 95.63),
(35, 'Crouching Tiger, Hidden Dragon', 'Popular', 1.00, 'Martial Arts', '2000', 120, 'Mandarin', 'Chow Yun-Fat, Michelle Yeoh', 'Ang Lee', 'Available', NULL, '2019-01-11', 24.22),
(36, 'Oldboy', 'Regular', 1.00, 'Thriller', '2003', 120, 'Korean', 'Choi Min-sik, Yoo Ji-tae', 'Park Chan-wook', 'Rented', '2025-04-14', '2020-10-30', 49.43),
(37, 'The Intouchables', 'Popular', 1.00, 'Comedy-Drama', '2011', 112, 'French', 'François Cluzet, Omar Sy', 'Olivier Nakache, Éric Toledano', 'Available', NULL, '2019-06-09', 91.18),
(38, 'The Grand Budapest Hotel', 'Current Hit', 2.00, 'Comedy', '2014', 99, 'English', 'Ralph Fiennes, Tony Revolori', 'Wes Anderson', 'Available', NULL, '2016-10-20', 27.50),
(39, 'Roma', 'Current Release', 1.50, 'Drama', '2018', 135, 'Spanish', 'Yalitza Aparicio, Marina de Tavira', 'Alfonso Cuarón', 'Available', NULL, '2019-04-29', 61.83),
(40, 'Hero', 'Regular', 0.50, 'Martial Arts', '2002', 99, 'Mandarin', 'Jet Li, Tony Leung Chiu-wai', 'Zhang Yimou', 'Rented', '2025-04-08', '2020-11-04', 27.23),
(41, 'Spirited Away', 'Popular', 1.00, 'Animation', '2001', 125, 'Japanese', 'Rumi Hiiragi, Miyu Irino', 'Hayao Miyazaki', 'Available', NULL, '2017-01-22', 50.95),
(42, 'The Handmaiden', 'Current Release', 1.50, 'Thriller', '2016', 145, 'Korean', 'Kim Min-hee, Ha Jung-woo', 'Park Chan-wook', 'Available', NULL, '2021-07-31', 92.91),
(43, 'A Separation', 'Popular', 1.00, 'Drama', '2011', 123, 'Persian', 'Leila Hatami, Peyman Moaadi', 'Asghar Farhadi', 'Rented', '2025-04-12', '2021-05-08', 46.73),
(44, 'Bicycle Thieves', 'Regular', 1.00, 'Drama', '1948', 89, 'Italian', 'Lamberto Maggiorani, Enzo Staiola', 'Vittorio De Sica', 'Rented', '2025-04-08', '2016-05-17', 51.64),
(45, 'Ip Man', 'Current Hit', 2.00, 'Martial Arts', '2008', 106, 'Cantonese', 'Donnie Yen, Simon Yam', 'Wilson Yip', 'Available', NULL, '2024-01-09', 20.57),
(46, 'Train to Busan', 'Current Release', 1.50, 'Horror', '2016', 118, 'Korean', 'Gong Yoo, Ma Dong-seok', 'Yeon Sang-ho', 'Rented', '2025-04-14', '2023-11-07', 16.10),
(47, 'Your Name', 'Popular', 1.00, 'Animation', '2016', 107, 'Japanese', 'Ryunosuke Kamiki, Mone Kamishiraishi', 'Makoto Shinkai', 'Available', NULL, '2021-11-16', 30.72),
(48, 'The Hunt', 'Regular', 0.50, 'Thriller', '2012', 115, 'Danish', 'Mads Mikkelsen, Thomas Bo Larsen', 'Thomas Vinterberg', 'Available', NULL, '2015-11-30', 78.89),
(49, 'Cinema Paradiso', 'Regular', 1.00, 'Drama', '1988', 155, 'Italian', 'Philippe Noiret, Enzo Cannavale', 'Giuseppe Tornatore', 'Available', NULL, '2020-07-16', 52.37),
(50, 'Infernal Affairs', 'Current Hit', 2.00, 'Crime', '2002', 101, 'Cantonese', 'Tony Leung, Andy Lau', 'Andrew Lau, Alan Mak', 'Available', NULL, '2021-12-11', 15.02),
(51, 'The Secret in Their Eyes', 'Popular', 1.00, 'Thriller', '2009', 129, 'Spanish', 'Ricardo Darín, Soledad Villamil', 'Juan José Campanella', 'Available', NULL, '2016-12-25', 84.12),
(52, 'The Pianist', 'Current Hit', 2.00, 'Biography', '2002', 150, 'Polish', 'Adrien Brody, Thomas Kretschmann', 'Roman Polanski', 'Available', NULL, '2020-03-28', 23.13),
(53, 'Babel', 'Current Release', 1.50, 'Drama', '2006', 143, 'English, Spanish, Arabic, Japanese', 'Brad Pitt, Cate Blanchett', 'Alejandro González Iñárritu', 'Rented', '2025-04-14', '2016-08-05', 42.28),
(54, 'La Dolce Vita', 'Regular', 1.00, 'Drama', '1960', 174, 'Italian', 'Marcello Mastroianni, Anita Ekberg', 'Federico Fellini', 'Rented', '2025-04-14', '2018-02-27', 55.13),
(55, 'Parasite', 'Current Release', 1.50, 'Thriller', '2019', 132, 'Korean', 'Song Kang-ho, Lee Sun-kyun', 'Bong Joon-ho', 'Rented', '2025-04-14', '2020-08-12', 36.97),
(56, 'The Great Beauty', 'Popular', 1.00, 'Drama', '2013', 142, 'Italian', 'Toni Servillo, Sabrina Ferilli', 'Paolo Sorrentino', 'Available', NULL, '2023-03-04', 26.34),
(57, 'The Motorcycle Diaries', 'Regular', 0.50, 'Drama', '2004', 126, 'Spanish', 'Gael García Bernal, Rodrigo de la Serna', 'Walter Salles', 'Rented', '2025-04-08', '2019-08-08', 77.78),
(58, 'The Raid: Redemption', 'Current Hit', 2.00, 'Action', '2011', 101, 'Indonesian', 'Iko Uwais, Joe Taslim', 'Gareth Evans', 'Rented', '2025-04-12', '2018-11-15', 70.77),
(59, 'The Battle of Algiers', 'Regular', 1.00, 'War', '1966', 121, 'Italian', 'Jean Martin, Saadi Yacef', 'Gillo Pontecorvo', 'Available', NULL, '2017-02-25', 14.53),
(60, 'Let the Right One In', 'Popular', 1.00, 'Horror', '2008', 115, 'Swedish', 'Kåre Hedebrant, Lina Leandersson', 'Tomas Alfredson', 'Rented', '2025-04-14', '2021-01-25', 89.15),
(61, 'The Matrix Reloaded', 'Current Hit', 2.00, 'Sci-Fi', '2003', 138, 'English', 'Keanu Reeves, Laurence Fishburne', 'Lana Wachowski', 'Available', NULL, '2020-10-18', 33.10),
(62, 'Gladiator', 'Current Hit', 2.00, 'Action', '2000', 155, 'English', 'Russell Crowe, Joaquin Phoenix', 'Ridley Scott', 'Rented', '2025-04-08', '2020-06-20', 96.54),
(63, 'The Lion King', 'Popular', 1.00, 'Animation', '1994', 88, 'English', 'Matthew Broderick, James Earl Jones', 'Roger Allers, Rob Minkoff', 'Rented', '2025-04-08', '2016-09-09', 96.36),
(64, 'Guardians of the Galaxy', 'Current Release', 1.50, 'Sci-Fi', '2014', 121, 'English', 'Chris Pratt, Zoe Saldana', 'James Gunn', 'Available', NULL, '2017-11-30', 61.95),
(65, 'Back to the Future', 'Regular', 0.50, 'Sci-Fi', '1985', 116, 'English', 'Michael J. Fox, Christopher Lloyd', 'Robert Zemeckis', 'Rented', '2025-04-08', '2015-02-15', 39.75),
(66, 'Wonder Woman', 'Current Release', 1.50, 'Action', '2017', 141, 'English', 'Gal Gadot, Chris Pine', 'Patty Jenkins', 'Available', NULL, '2021-03-01', 17.75),
(67, 'Shutter Island', 'Popular', 1.00, 'Thriller', '2010', 138, 'English', 'Leonardo DiCaprio, Mark Ruffalo', 'Martin Scorsese', 'Available', NULL, '2020-11-05', 69.54),
(68, 'Star Wars: A New Hope', 'Popular', 1.00, 'Sci-Fi', '1977', 121, 'English', 'Mark Hamill, Harrison Ford', 'George Lucas', 'Available', NULL, '2020-07-25', 81.51),
(69, 'The Shawshank Redemption', 'Regular', 0.50, 'Drama', '1994', 142, 'English', 'Tim Robbins, Morgan Freeman', 'Frank Darabont', 'Available', NULL, '2018-01-21', 22.82),
(70, 'Black Panther', 'Current Release', 1.50, 'Action', '2018', 134, 'English', 'Chadwick Boseman, Michael B. Jordan', 'Ryan Coogler', 'Available', NULL, '2022-12-23', 60.01),
(71, 'The Pianist', 'Popular', 1.00, 'Biography', '2002', 150, 'Polish', 'Adrien Brody, Thomas Kretschmann', 'Roman Polanski', 'Available', NULL, '2018-11-22', 34.89),
(72, 'Forrest Gump', 'Regular', 0.50, 'Drama', '1994', 142, 'English', 'Tom Hanks, Robin Wright', 'Robert Zemeckis', 'Rented', '2025-04-08', '2017-03-02', 32.69),
(73, 'The Departed', 'Current Hit', 2.00, 'Crime', '2006', 151, 'English', 'Leonardo DiCaprio, Matt Damon', 'Martin Scorsese', 'Available', NULL, '2021-02-13', 37.05),
(74, 'The Girl with the Dragon Tattoo', 'Current Release', 1.50, 'Mystery', '2011', 158, 'English, Swedish', 'Daniel Craig, Rooney Mara', 'David Fincher', 'Available', NULL, '2021-09-11', 49.80),
(75, 'Avatar', 'Popular', 1.00, 'Sci-Fi', '2009', 162, 'English', 'Sam Worthington, Zoe Saldana', 'James Cameron', 'Rented', '2025-04-07', '2017-01-18', 72.68),
(76, 'The Godfather: Part II', 'Regular', 0.50, 'Crime', '1974', 202, 'English', 'Al Pacino, Robert De Niro', 'Francis Ford Coppola', 'Available', NULL, '2023-09-12', 32.80),
(77, 'A Beautiful Mind', 'Current Hit', 2.00, 'Biography', '2001', 135, 'English', 'Russell Crowe, Jennifer Connelly', 'Ron Howard', 'Available', NULL, '2021-08-13', 58.98),
(79, 'The Shawshank Redemption', 'Popular', 1.00, 'Drama', '1994', 142, 'English', 'Tim Robbins, Morgan Freeman', 'Frank Darabont', 'Rented', '2025-04-08', '2022-05-24', 15.39),
(80, 'The Dark Knight Rises', 'Current Hit', 2.00, 'Action', '2012', 164, 'English', 'Christian Bale, Tom Hardy', 'Christopher Nolan', 'Available', NULL, '2015-11-03', 31.56),
(81, 'The Silence of the Lambs', 'Regular', 0.50, 'Thriller', '1991', 118, 'English', 'Jodie Foster, Anthony Hopkins', 'Jonathan Demme', 'Available', NULL, '2024-06-22', 11.15),
(82, '12 Angry Men', 'Popular', 1.00, 'Drama', '1957', 96, 'English', 'Henry Fonda, Lee J. Cobb', 'Sidney Lumet', 'Available', NULL, '2017-04-03', 17.86),
(83, 'The Green Mile', 'Current Release', 1.50, 'Fantasy', '1999', 189, 'English', 'Tom Hanks, Michael Clarke Duncan', 'Frank Darabont', 'Available', NULL, '2022-08-15', 58.92),
(84, 'The Wizard of Oz', 'Regular', 0.50, 'Fantasy', '1939', 102, 'English', 'Judy Garland, Frank Morgan', 'Victor Fleming', 'Rented', '2025-04-12', '2019-05-08', 58.70),
(85, 'Goodfellas', 'Popular', 1.00, 'Crime', '1990', 146, 'English', 'Ray Liotta, Robert De Niro', 'Martin Scorsese', 'Rented', '2025-04-08', '2019-01-12', 45.04),
(86, 'Schindler’s List', 'Current Hit', 2.00, 'Biography', '1993', 195, 'English', 'Liam Neeson, Ben Kingsley', 'Steven Spielberg', 'Rented', '2025-04-14', '2022-05-26', 57.42),
(87, 'The Matrix Reloaded', 'Current Release', 1.50, 'Action', '2003', 138, 'English', 'Keanu Reeves, Laurence Fishburne', 'Lana Wachowski, Lilly Wachowski', 'Available', NULL, '2019-03-08', 55.69),
(88, 'Deadpool', 'Regular', 0.50, 'Action', '2016', 108, 'English', 'Ryan Reynolds, Morena Baccarin', 'Tim Miller', 'Rented', '2025-04-08', '2017-11-10', 91.38),
(89, 'The Revenant', 'Popular', 1.00, 'Adventure', '2015', 156, 'English', 'Leonardo DiCaprio, Tom Hardy', 'Alejandro González Iñárritu', 'Available', NULL, '2021-08-28', 65.05),
(90, 'The Lion King', 'Current Hit', 2.00, 'Animation', '1994', 88, 'English', 'Matthew Broderick, James Earl Jones', 'Roger Allers, Rob Minkoff', 'Available', NULL, '2015-08-22', 53.59),
(91, 'The Incredibles', 'Regular', 0.50, 'Animation', '2004', 115, 'English', 'Craig T. Nelson, Holly Hunter', 'Brad Bird', 'Available', NULL, '2017-04-20', 72.63),
(92, 'The Big Lebowski', 'Popular', 1.00, 'Comedy', '1998', 117, 'English', 'Jeff Bridges, John Goodman', 'Joel Coen, Ethan Coen', 'Available', NULL, '2022-11-30', 87.75),
(93, 'Birdman', 'Current Release', 1.50, 'Drama', '2014', 119, 'English', 'Michael Keaton, Edward Norton', 'Alejandro González Iñárritu', 'Rented', '2025-04-08', '2024-06-30', 23.52),
(94, 'Whiplash', 'Current Hit', 2.00, 'Drama', '2014', 107, 'English', 'Miles Teller, J.K. Simmons', 'Damien Chazelle', 'Rented', '2025-04-08', '2024-01-27', 17.12),
(95, 'The Secret Life of Walter Mitty', 'Regular', 0.50, 'Adventure', '2013', 114, 'English', 'Ben Stiller, Kristen Wiig', 'Ben Stiller', 'Rented', '2025-04-08', '2021-10-14', 23.66),
(96, 'Catch Me If You Can', 'Popular', 1.00, 'Biography', '2002', 141, 'English', 'Leonardo DiCaprio, Tom Hanks', 'Steven Spielberg', 'Rented', '2025-04-15', '2022-04-06', 25.39),
(97, 'Inception', 'Current Release', 1.50, 'Sci-Fi', '2010', 148, 'Japanese', 'Leonardo DiCaprio, Joseph Gordon-Levitt', 'Christopher Nolan', 'Rented', '2025-04-14', '2021-10-20', 89.50),
(99, 'The Godfather', 'Popular', 1.00, 'Crime', '1972', 175, 'English', 'Marlon Brando, Al Pacino', 'Francis Ford Coppola', 'Available', NULL, '2015-11-22', 73.88),
(100, 'The Lord of the Rings: The Return of the King', 'Current Release', 1.50, 'Fantasy', '2003', 201, 'English', 'Elijah Wood, Viggo Mortensen', 'Peter Jackson', 'Available', NULL, '2017-10-27', 35.11);

-- --------------------------------------------------------

--
-- Table structure for table `TransactionMovies`
--

CREATE TABLE `TransactionMovies` (
  `TransID` int NOT NULL,
  `MovieID` int NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `TransactionMovies`
--

INSERT INTO `TransactionMovies` (`TransID`, `MovieID`, `Price`) VALUES
(86, 82, 1.00),
(87, 82, 1.00),
(88, 31, 1.00),
(89, 70, 1.50),
(89, 49, 1.00),
(89, 35, 1.00),
(90, 75, 1.00),
(91, 2, 2.00),
(91, 76, 0.50),
(92, 34, 2.00),
(92, 85, 1.00),
(93, 29, 0.50),
(95, 79, 1.00),
(96, 93, 1.50),
(96, 72, 0.50),
(96, 40, 0.50),
(96, 32, 1.00),
(96, 21, 0.50),
(97, 44, 1.00),
(97, 88, 0.50),
(98, 95, 0.50),
(99, 65, 0.50),
(99, 27, 0.50),
(99, 1, 1.00),
(99, 18, 0.50),
(100, 63, 1.00),
(100, 57, 0.50),
(101, 12, 1.00),
(102, 43, 1.00),
(102, 58, 2.00),
(102, 84, 0.50),
(103, 23, 2.00),
(103, 50, 2.00),
(104, 53, 1.50),
(104, 33, 1.50),
(104, 8, 0.50),
(104, 30, 1.00),
(105, 97, 1.50),
(105, 55, 1.50),
(106, 20, 1.00),
(106, 39, 1.50),
(107, 36, 1.00),
(108, 86, 2.00),
(109, 60, 1.00),
(109, 46, 1.50),
(110, 54, 1.00),
(111, 10, 2.00),
(112, 96, 1.00),
(112, 28, 1.50),
(112, 4, 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

CREATE TABLE `Transactions` (
  `TransID` int NOT NULL,
  `CustID` int NOT NULL,
  `EmpID` int NOT NULL,
  `RentalDate` date DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `Status` enum('Rented','Returned') NOT NULL DEFAULT 'Rented',
  `NumItems` int NOT NULL,
  `TotalCost` decimal(10,2) DEFAULT NULL,
  `PaymentMethod` enum('Cash','Card','Check','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PaymentDetails` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Transactions`
--

INSERT INTO `Transactions` (`TransID`, `CustID`, `EmpID`, `RentalDate`, `DueDate`, `ReturnDate`, `Status`, `NumItems`, `TotalCost`, `PaymentMethod`, `PaymentDetails`) VALUES
(86, 20, 1, '2025-03-31', NULL, '2025-03-31', 'Returned', 1, 1.00, '', ''),
(87, 47, 1, '2025-03-10', NULL, '2025-03-31', 'Returned', 1, 1.00, '', ''),
(88, 41, 1, '2025-03-31', '2025-04-07', NULL, 'Rented', 1, 1.00, '', ''),
(89, 47, 1, '2025-03-31', NULL, '2025-04-07', 'Returned', 3, 3.50, '', ''),
(90, 27, 1, '2025-03-31', '2025-04-07', NULL, 'Rented', 1, 1.00, '', ''),
(91, 40, 1, '2025-03-03', NULL, '2025-04-08', 'Returned', 2, 2.50, '', ''),
(92, 14, 2, '2025-04-01', '2025-04-08', NULL, 'Rented', 2, 3.00, '', ''),
(93, 5, 2, '2025-04-01', '2025-04-08', NULL, 'Rented', 1, 0.50, '', ''),
(95, 13, 7, '2025-04-01', '2025-04-08', NULL, 'Rented', 1, 1.00, '', ''),
(96, 13, 7, '2025-04-01', '2025-04-08', NULL, 'Rented', 5, 4.00, '', ''),
(97, 26, 8, '2025-04-01', '2025-04-08', NULL, 'Rented', 2, 1.50, '', ''),
(98, 26, 8, '2025-04-01', '2025-04-08', NULL, 'Rented', 1, 0.50, '', ''),
(99, 32, 9, '2025-04-01', '2025-04-08', NULL, 'Rented', 4, 2.50, '', ''),
(100, 18, 9, '2025-04-01', '2025-04-08', NULL, 'Rented', 2, 1.50, '', ''),
(101, 15, 1, '2025-04-01', '2025-04-08', NULL, 'Rented', 1, 1.00, '', ''),
(102, 25, 1, '2025-04-05', '2025-04-12', NULL, 'Rented', 3, 3.50, 'Card', 'Test card'),
(103, 41, 1, '2025-04-07', NULL, '2025-04-07', 'Returned', 2, 4.00, 'Card', '123'),
(104, 5, 1, '2025-04-07', '2025-04-14', NULL, 'Rented', 4, 4.50, 'Check', 'test'),
(105, 2, 1, '2025-04-07', '2025-04-14', NULL, 'Rented', 2, 3.00, 'Check', 'test'),
(106, 13, 1, '2025-04-07', NULL, '2025-04-07', 'Returned', 2, 2.50, 'Check', 'test'),
(107, 13, 1, '2025-04-07', '2025-04-14', NULL, 'Rented', 1, 1.00, 'Check', 'test'),
(108, 13, 1, '2025-04-07', '2025-04-14', NULL, 'Rented', 1, 2.00, 'Check', 'test'),
(109, 37, 1, '2025-04-07', '2025-04-14', NULL, 'Rented', 2, 2.50, 'Check', 'test'),
(110, 47, 1, '2025-04-07', '2025-04-14', NULL, 'Rented', 1, 1.00, 'Cash', ''),
(111, 8, 1, '2025-04-07', '2025-04-14', NULL, 'Rented', 1, 2.00, 'Check', ''),
(112, 8, 1, '2025-04-08', '2025-04-15', NULL, 'Rented', 3, 3.50, 'Check', '');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `EmpID` int NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Phone` int NOT NULL,
  `StreetAdr` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` int NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Salary` int NOT NULL,
  `WorkHours` int NOT NULL DEFAULT '40',
  `password` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'password',
  `IsManager` tinyint(1) NOT NULL DEFAULT '0',
  `HireDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`EmpID`, `FirstName`, `LastName`, `Phone`, `StreetAdr`, `City`, `State`, `Zip`, `Email`, `Salary`, `WorkHours`, `password`, `IsManager`, `HireDate`) VALUES
(1, 'Jenna', 'Soldner', 1112223456, '123 Sesame St', 'Milwaukee', 'WI', 12345, 'jsoldner@uwm.edu', 80000, 40, 'password', 1, '2024-01-01'),
(2, 'Hilly', 'Brew', 1112223344, '400 Test Ave', 'Milwaukee', 'WI', 12345, 'h.brew@bcr.com', 95000, 40, 'password', 1, '2015-02-01'),
(7, 'Hannah', 'Bannah', 1234567890, '123 TEst ST', 'test', 'wi', 12345, 'h@b.com', 15000, 20, 'password', 0, '2018-04-11'),
(8, 'John', 'Author', 1234567890, '123 TEst ST', 'test', 'wi', 12345, 'jsoldner@uwm.edu', 30000, 40, 'password', 0, '2025-01-06'),
(9, 'Janet', 'Brew', 1112223344, '400 Test Ave', 'Milwaukee', 'WI', 12345, 'h.brew@bcr.com', 45000, 25, 'password', 0, '2020-03-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Audit`
--
ALTER TABLE `Audit`
  ADD PRIMARY KEY (`AuditID`);

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`CustID`);

--
-- Indexes for table `Movies`
--
ALTER TABLE `Movies`
  ADD PRIMARY KEY (`MovieID`);

--
-- Indexes for table `TransactionMovies`
--
ALTER TABLE `TransactionMovies`
  ADD KEY `TranID` (`TransID`,`MovieID`),
  ADD KEY `MovieID` (`MovieID`);

--
-- Indexes for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`TransID`),
  ADD KEY `CustID` (`CustID`,`EmpID`),
  ADD KEY `EmpID` (`EmpID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`EmpID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Audit`
--
ALTER TABLE `Audit`
  MODIFY `AuditID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `Customers`
--
ALTER TABLE `Customers`
  MODIFY `CustID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `Movies`
--
ALTER TABLE `Movies`
  MODIFY `MovieID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `Transactions`
--
ALTER TABLE `Transactions`
  MODIFY `TransID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `EmpID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `TransactionMovies`
--
ALTER TABLE `TransactionMovies`
  ADD CONSTRAINT `TransactionMovies_ibfk_1` FOREIGN KEY (`TransID`) REFERENCES `Transactions` (`TransID`),
  ADD CONSTRAINT `TransactionMovies_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `Movies` (`MovieID`);

--
-- Constraints for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `Transactions_ibfk_1` FOREIGN KEY (`CustID`) REFERENCES `Customers` (`CustID`),
  ADD CONSTRAINT `Transactions_ibfk_2` FOREIGN KEY (`EmpID`) REFERENCES `Users` (`EmpID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
