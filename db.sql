CREATE DATABASE  IF NOT EXISTS `dbpay2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbpay2`;
-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: localhost    Database: dbpay2
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `deptno` int NOT NULL,
  `dept_name` varchar(20) DEFAULT NULL,
  `loc` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`deptno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (10,'account','kolhapur'),(20,'HR','pune'),(30,'Admin','kolhapur');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dept`
--

DROP TABLE IF EXISTS `dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dept` (
  `dept_id` int NOT NULL AUTO_INCREMENT,
  `department` varchar(20) DEFAULT NULL,
  `dept_location` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dept`
--

LOCK TABLES `dept` WRITE;
/*!40000 ALTER TABLE `dept` DISABLE KEYS */;
INSERT INTO `dept` VALUES (1,'HR','pune'),(2,'Accountant','kolhapur'),(3,'employee','kolhapur');
/*!40000 ALTER TABLE `dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
  `empid` int NOT NULL,
  `emp_name` varchar(20) DEFAULT NULL,
  `emp_address` varchar(30) DEFAULT NULL,
  `phone` bigint DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `job` varchar(20) DEFAULT NULL,
  `joindate` date DEFAULT NULL,
  `salary` bigint DEFAULT NULL,
  PRIMARY KEY (`empid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'pranav','kolhapur',9022210104,'pranavp@gmail.com','developer','2024-01-12',35000),(2,'bhushan','kolhapur',9893920934,'bhushann@gmail.com','clerk','2024-01-14',30000),(3,'atharv','pune',77788334345,'atharvp@gmail.com','manager','2020-04-01',55000),(4,'sahil','mumbai',9342578392,'sahils@gmail.com','soft_testor','2019-08-12',45000);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbladmin`
--

DROP TABLE IF EXISTS `tbladmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbladmin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbladmin`
--

LOCK TABLES `tbladmin` WRITE;
/*!40000 ALTER TABLE `tbladmin` DISABLE KEYS */;
INSERT INTO `tbladmin` VALUES (1,'admin','pass123','patiltech@gmail.com');
/*!40000 ALTER TABLE `tbladmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblattendance`
--

DROP TABLE IF EXISTS `tblattendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblattendance` (
  `emp_id` int NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  KEY `emp_id` (`emp_id`),
  CONSTRAINT `tblattendance_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `tblemp` (`emp_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblattendance`
--

LOCK TABLES `tblattendance` WRITE;
/*!40000 ALTER TABLE `tblattendance` DISABLE KEYS */;
INSERT INTO `tblattendance` VALUES (1,'2025-04-20','Present'),(1,'2025-04-01','Present'),(1,'2025-04-02','Present'),(1,'2025-04-03','Absent'),(1,'2025-04-04','Present'),(1,'2025-04-05','Present'),(1,'2025-04-07','Present'),(1,'2025-04-08','Absent'),(1,'2025-04-09','Present'),(1,'2025-04-10','Present'),(1,'2025-04-11','Present'),(1,'2025-04-12','Present'),(1,'2025-04-14','Present'),(1,'2025-04-15','Present'),(1,'2025-04-16','Present'),(1,'2025-04-17','Present'),(1,'2025-04-18','Present'),(1,'2025-04-19','Present'),(2,'2025-04-20','Present'),(3,'2025-04-20','Absent'),(1,'2025-04-21','Present'),(1,'2025-04-23','Present'),(1,'2025-05-17','Absent (Paid)'),(4,'2025-05-21','Absent (Paid)');
/*!40000 ALTER TABLE `tblattendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblemp`
--

DROP TABLE IF EXISTS `tblemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblemp` (
  `emp_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `emp_address` varchar(255) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `emp_email` varchar(100) DEFAULT NULL,
  `emp_password` varchar(255) DEFAULT NULL,
  `monthly_paid_leaves` int DEFAULT '5',
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `emp_email` (`emp_email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblemp`
--

LOCK TABLES `tblemp` WRITE;
/*!40000 ALTER TABLE `tblemp` DISABLE KEYS */;
INSERT INTO `tblemp` VALUES (1,'Pranav','patil','9022210104','Kolhapur','HR','pranavpatil9066@gmail.com','pass123',4),(2,'Omkar','patil','7666238072','Kolhapur','HR','omkarpatil4414@gmail.com','omkar',5),(3,'sahil','patil','8967765998','Kolhapur','HR','sahilp@gmail.com','sahil',5),(4,'Esha','patil','8088294909','Kolhapur','HR','eshapatil@gmail.com','pass123',4);
/*!40000 ALTER TABLE `tblemp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblhistory`
--

DROP TABLE IF EXISTS `tblhistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblhistory` (
  `emp_id` int DEFAULT NULL,
  `emp_name` varchar(255) DEFAULT NULL,
  `basic_sal` decimal(10,2) DEFAULT NULL,
  `da` decimal(10,2) DEFAULT NULL,
  `ta` decimal(10,2) DEFAULT NULL,
  `pf` decimal(10,2) DEFAULT NULL,
  `net_sal` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_month` varchar(50) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'Cash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblhistory`
--

LOCK TABLES `tblhistory` WRITE;
/*!40000 ALTER TABLE `tblhistory` DISABLE KEYS */;
INSERT INTO `tblhistory` VALUES (4,'Esha',78000.00,42900.00,23400.00,15600.00,115500.00,'2025-04-23','April','BOB','32346565432','Bank Transfer'),(1,'Pranav ',100000.00,55000.00,30000.00,20000.00,156267.00,'2025-05-18','May','BOB','384504000137451','Cash');
/*!40000 ALTER TABLE `tblhistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblleave`
--

DROP TABLE IF EXISTS `tblleave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblleave` (
  `emp_id` int NOT NULL,
  `leave_date` date NOT NULL,
  `leave_type` enum('Paid','Unpaid') NOT NULL,
  `reason` text,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblleave`
--

LOCK TABLES `tblleave` WRITE;
/*!40000 ALTER TABLE `tblleave` DISABLE KEYS */;
INSERT INTO `tblleave` VALUES (1,'2025-04-25','Paid','sdfghjkjhgf','Approved'),(1,'2025-04-24','Unpaid','qwertyu','Approved'),(1,'2025-04-26','Unpaid','lkjhgfds','Approved'),(1,'2025-04-27','Unpaid','sdfv','Approved'),(4,'2025-04-23','Unpaid','1234567','Approved'),(1,'2025-04-01','Paid','Family event','Approved'),(1,'2025-04-05','Unpaid','Personal reasons','Approved'),(1,'2025-04-08','Paid','Medical appointment','Approved'),(1,'2025-04-12','Unpaid','Travel','Approved'),(1,'2025-04-15','Paid','Vacation','Approved'),(1,'2025-04-18','Unpaid','Family emergency','Approved'),(1,'2025-04-22','Paid','Mental health day','Approved'),(4,'2025-04-24','Unpaid','sick','Approved'),(4,'2025-04-26','Unpaid','hjkl;\'','Approved'),(1,'2025-05-17','Paid','sick leave','Approved'),(1,'2025-05-18','Unpaid','sick leave','Approved'),(4,'2025-05-21','Paid','Sick leave','Approved');
/*!40000 ALTER TABLE `tblleave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpayment`
--

DROP TABLE IF EXISTS `tblpayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblpayment` (
  `emp_id` int DEFAULT NULL,
  `emp_name` varchar(30) DEFAULT NULL,
  `basic_sal` bigint DEFAULT NULL,
  `da` bigint DEFAULT NULL,
  `ta` bigint DEFAULT NULL,
  `pf` bigint DEFAULT NULL,
  `net_salary` bigint DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpayment`
--

LOCK TABLES `tblpayment` WRITE;
/*!40000 ALTER TABLE `tblpayment` DISABLE KEYS */;
INSERT INTO `tblpayment` VALUES (1,'Pranav',50000,27500,15000,10000,52500,'2024-03-09','March'),(4,'Atharv',45000,24750,13500,9000,47250,'2024-03-09','March'),(5,'Sahil',35000,19250,10500,7000,36750,'2024-03-15','March'),(13,'samarth',34000,18700,10200,6800,35700,'2024-04-15','April'),(1,'Pranav',50000,27500,15000,10000,52500,'2024-04-15','April'),(1,'Pranav',50000,27500,15000,10000,52500,'2024-04-15','April'),(1,'Pranav ',100000,55000,30000,20000,105000,'2025-04-20','April'),(4,'Esha',78000,42900,23400,15600,115500,'2025-04-23','April'),(2,'Omkar',75000,41250,22500,15000,118350,'2025-04-23','April'),(1,'Pranav ',100000,55000,30000,20000,156267,'2025-05-18','May');
/*!40000 ALTER TABLE `tblpayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsalary`
--

DROP TABLE IF EXISTS `tblsalary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblsalary` (
  `emp_id` int NOT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`emp_id`),
  CONSTRAINT `tblsalary_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `tblemp` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsalary`
--

LOCK TABLES `tblsalary` WRITE;
/*!40000 ALTER TABLE `tblsalary` DISABLE KEYS */;
INSERT INTO `tblsalary` VALUES (1,100000.00),(2,75000.00),(3,80000.00),(4,78000.00);
/*!40000 ALTER TABLE `tblsalary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `v1`
--

DROP TABLE IF EXISTS `v1`;
/*!50001 DROP VIEW IF EXISTS `v1`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v1` AS SELECT 
 1 AS `emp_id`,
 1 AS `first_name`,
 1 AS `basic_salary`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `v1`
--

/*!50001 DROP VIEW IF EXISTS `v1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = cp850 */;
/*!50001 SET character_set_results     = cp850 */;
/*!50001 SET collation_connection      = cp850_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v1` AS select `e`.`emp_id` AS `emp_id`,`e`.`first_name` AS `first_name`,`s`.`basic_salary` AS `basic_salary` from (`tblemp` `e` join `tblsalary` `s` on((`e`.`emp_id` = `s`.`emp_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-21 10:20:01
