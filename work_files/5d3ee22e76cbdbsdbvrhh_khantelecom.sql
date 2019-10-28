-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2019 at 05:37 AM
-- Server version: 10.1.40-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsdbvrhh_khantelecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_type_list`
--

CREATE TABLE `acc_type_list` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `name_key` varchar(255) NOT NULL,
  `expense_income` int(1) NOT NULL COMMENT '1=expense, 2=income'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acc_type_list`
--

INSERT INTO `acc_type_list` (`id`, `description`, `name_key`, `expense_income`) VALUES
(1, 'Expense', 'expense', 1),
(2, 'Purchase Payment', 'purchase_payment', 1),
(3, 'Sell Payment Receive', 'sell_payment_receive', 2),
(4, 'Other Income', 'other_income', 2),
(5, 'Customer Individual Payment', 'customer_individual_payment', 2),
(6, 'Supplier Individual Payment', 'supplier_individual_payment', 1),
(7, 'Customer Advance', 'customer_advance', 2),
(8, 'Customer Due', 'customer_due', 0),
(9, 'Supplier Advance', 'supplier_advance', 1),
(10, 'Supplier Due', 'supplier_due', 0),
(11, 'Receive Cash From Supplier', 'receive_cash_from_supplier', 2),
(12, 'Give Cash To Customer', 'give_cash_to_customer', 1),
(13, 'Company Give Loan To Person', 'company_give_loan_to_person', 1),
(14, 'Person Repay Their Loan To Company', 'person_repay_loan_to_company', 2),
(15, 'Company Take Loan From a Person', 'company_take_loan_from_person', 2),
(16, 'Company Repay Loan to the Person', 'company_repay_loan_to_person', 1),
(17, 'Company Received Security Money From Customer', 'company_received_s_money_from_customer', 2),
(18, 'Company Back Security Money To Customer', 'company_back_s_money_to_customer', 1),
(19, 'Company Provide Security Money To Supplier', 'company_provide_s_money_to_supplier', 1),
(20, 'Supplier Back Security Money to Company', 'supplier_back_s_money_to_company', 2),
(21, 'Company Give Payment To Employee', 'company_give_payment_to_employee', 1),
(22, 'Purchase Product Form Supplier(Bill)', 'purchase_product_from_supplier', 1),
(23, 'Sell Product To Customer', 'sell_product_to_customer', 2),
(24, 'Bank Withdrow', 'bank_withdrow', 0),
(25, 'Bank Deposit', 'bank_deposit', 0),
(26, 'Bank Opening Balance', 'bank_opening_balance', 0),
(27, 'Purchase Return', 'purchase_return', 0),
(28, 'Sales Return', 'Sales Return', 0),
(29, 'Customer Discount', 'customer_discount', 1),
(30, 'Purchase Discount', 'purchase_discount', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `account_id` int(11) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `chq_no` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `credit` int(8) NOT NULL,
  `debit` int(8) NOT NULL,
  `balance` int(11) NOT NULL,
  `withdraw_by` varchar(50) NOT NULL,
  `diposited_by` varchar(50) NOT NULL,
  `entry_by` int(3) NOT NULL,
  `entry_date` text NOT NULL,
  `update_by` int(4) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acc_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_registration`
--

CREATE TABLE `bank_registration` (
  `a_id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_no` varchar(100) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `entry_by` int(4) NOT NULL,
  `entry_date` date NOT NULL,
  `update_by` int(4) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(3) NOT NULL,
  `cus_or_sup_id` varchar(200) NOT NULL,
  `amount` int(11) NOT NULL,
  `entry_by` int(2) NOT NULL,
  `entry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `id` int(11) NOT NULL,
  `cus_id` varchar(20) NOT NULL,
  `sell_id` int(11) NOT NULL,
  `installment_month` int(11) NOT NULL,
  `total_installment` int(11) NOT NULL,
  `installment_due` int(11) NOT NULL,
  `punishment` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `installment_transaction`
--

CREATE TABLE `installment_transaction` (
  `id` int(11) NOT NULL,
  `installment_id` int(11) NOT NULL,
  `installment_payment` float NOT NULL,
  `is_late` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `acc_id` int(5) NOT NULL,
  `acc_head` int(2) NOT NULL,
  `purchase_or_sell_id` varchar(30) NOT NULL,
  `other_expense` int(3) NOT NULL,
  `acc_amount` int(8) NOT NULL,
  `acc_description` text NOT NULL,
  `acc_type` int(2) NOT NULL COMMENT 'Expense-1, Purchase=2, Sell=3, Other_Income=4, Customer=5, Supplier=6,Customer_Advance=7,Customer_Due=8,Supplier_Advance=9,Supplier_Due=10, receive_cash_from_supplier=11, give_cash_to_customer=12. loan_give=13, loan_repay=14',
  `cus_or_sup_id` varchar(30) NOT NULL,
  `payment_method` tinyint(4) NOT NULL COMMENT 'cash-1,bank-0',
  `entry_by` int(2) NOT NULL,
  `entry_date` date NOT NULL,
  `update_by` int(2) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ac_head_other_income`
--

CREATE TABLE `tbl_ac_head_other_income` (
  `acc_id` int(2) NOT NULL,
  `acc_name` varchar(100) NOT NULL,
  `acc_desc` text NOT NULL,
  `acc_status` int(1) NOT NULL,
  `entry_by` int(5) NOT NULL,
  `ac_head_or_other_income` int(1) NOT NULL COMMENT 'Acc Head = 1 & Other Income = 0',
  `entry_date` date NOT NULL,
  `update_by` int(5) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cat_id` int(2) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_name`, `status`) VALUES
(2, 'LED Television', 1),
(4, 'Refrigerator', 1),
(5, 'Voltage Stabilizer', 1),
(6, 'Gas stove', 1),
(7, 'Rice cooker', 1),
(8, 'Iron', 1),
(9, 'Blender', 1),
(10, 'Electric Kettle', 1),
(11, 'Pressure Cooker', 1),
(12, 'Water Pump', 1),
(13, 'Generator', 1),
(14, 'Room Heater', 1),
(15, 'Washing Machine', 1),
(16, 'Air conditioner', 1),
(17, 'Water Purifier', 1),
(18, 'WD1-JX32-SY150', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_lend`
--

CREATE TABLE `tbl_company_lend` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `loan_recieve` float(10,2) NOT NULL,
  `loan_repayment` float(10,2) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(5) NOT NULL,
  `cus_id` varchar(20) NOT NULL,
  `cus_name` varchar(100) NOT NULL,
  `cus_company` varchar(50) NOT NULL,
  `cus_mobile_no` varchar(20) NOT NULL,
  `cus_address` text NOT NULL,
  `cus_email` varchar(100) NOT NULL,
  `cus_comments` text NOT NULL,
  `cus_status` int(1) NOT NULL,
  `entry_by` int(2) NOT NULL,
  `entry_date` date NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery`
--

CREATE TABLE `tbl_delivery` (
  `id` int(4) NOT NULL,
  `sell_id` int(11) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entry_by` int(2) NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_item`
--

CREATE TABLE `tbl_delivery_item` (
  `id` int(11) NOT NULL,
  `sell_no` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `qty` int(6) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `id` int(5) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `employee_mobile_no` varchar(20) NOT NULL,
  `employee_address` text NOT NULL,
  `employee_email` varchar(100) NOT NULL,
  `employee_national_id` varchar(20) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `joining_date` date NOT NULL,
  `employee_status` int(1) NOT NULL,
  `entry_by` int(2) NOT NULL,
  `entry_date` date NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_transaction`
--

CREATE TABLE `tbl_employee_transaction` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_amount` float(10,2) NOT NULL,
  `conveyance` float(10,2) NOT NULL,
  `received_amount` float(10,2) NOT NULL,
  `received_due` int(1) NOT NULL COMMENT 'employee_salary_receive=1, employee_salary_due=0',
  `punishment` float(10,2) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_with_price`
--

CREATE TABLE `tbl_item_with_price` (
  `item_id` int(6) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` varchar(10) NOT NULL,
  `sell_price` double NOT NULL,
  `category` int(3) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_item_with_price`
--

INSERT INTO `tbl_item_with_price` (`item_id`, `item_name`, `item_price`, `sell_price`, `category`, `status`) VALUES
(1, 'WD1-JX32-SY150', '0', 0, 2, 1),
(2, 'WD1-JX32-SY200', '0', 0, 2, 1),
(3, 'WD1-JX32-SY250', '0', 0, 2, 1),
(4, 'WD1-JX32-TS100', '0', 0, 2, 1),
(5, 'W32Q19', '0', 0, 2, 1),
(6, 'W32Q20', '0', 0, 2, 1),
(7, 'WD1-DT24-RL150', '0', 0, 2, 1),
(8, 'WD1-DT24-MC150', '0', 0, 2, 1),
(9, 'WFB-2A8-GDEL-XX', '0', 0, 4, 1),
(10, 'WFB-2A8-GDXX-XX', '0', 0, 4, 1),
(11, 'WFB-2A8-ELXX-XX', '0', 0, 4, 1),
(12, 'WFA-2B0-GDXX-XX', '0', 0, 4, 1),
(13, 'WFA-2B0-GDEL-XX', '0', 0, 4, 1),
(14, 'WFB-2B6-GDXX-XX', '0', 0, 4, 1),
(15, 'WFB-2B6-GDEL-XX', '0', 0, 4, 1),
(16, 'WFA-2D4-GDEL-XX', '0', 0, 4, 1),
(17, 'WFA-2D4-GDXX-XX', '0', 0, 4, 1),
(18, 'WFB-2E0-GDEL-XX', '0', 0, 4, 1),
(19, 'WFB-2E4-GDEL-XX', '0', 0, 4, 1),
(20, 'WFB-2E4-GDXX-XX', '0', 0, 4, 1),
(21, 'WFE-2H2-GDEL-XX', '0', 0, 4, 1),
(22, 'WFE-2H2-GDXX-XX', '0', 0, 4, 1),
(23, 'WFE-2N5-GDEL-XX', '0', 0, 4, 1),
(24, 'WFE-2N5-GDXX-XX', '0', 0, 4, 1),
(25, 'WFC-3X7-GDEL-XX', '0', 0, 4, 1),
(26, 'WFC-3X7-GDXX-XX', '0', 0, 4, 1),
(27, 'WFE-3X9-GDEL-XX', '0', 0, 4, 1),
(28, 'WFE-3X9-GDXX-XX', '0', 0, 4, 1),
(29, 'WFE-3A2-GDEL-XX', '0', 0, 4, 1),
(30, 'WFE-3A2-GDXX-XX', '0', 0, 4, 1),
(31, 'WFC-3A7-GDNE-XX', '0', 0, 4, 1),
(32, 'WFC-3A7-GDXX-XX', '0', 0, 4, 1),
(33, 'WFE-3B0-GDEL-XX', '0', 0, 4, 1),
(34, 'WFE-3B0-GDXX', '0', 0, 4, 1),
(35, 'WFC-3D8-GDEL-XX', '0', 0, 4, 1),
(36, 'WFE-3C3-GDXX-XX', '0', 0, 4, 1),
(37, 'WFE-3E8-GDEL-XX', '0', 0, 4, 1),
(38, 'WFE-3E8-GDXX-XX', '0', 0, 2, 1),
(39, 'WFA-2A3-GDEL-XX', '0', 0, 4, 1),
(40, 'WFA-2A3-GDXX', '0', 0, 4, 1),
(41, 'WFB-2X1-GDEL-XX', '0', 0, 4, 1),
(42, 'WFE-2X1-GDXX-XX', '0', 0, 4, 1),
(43, 'WFB-1H5-GDEL-XX', '0', 0, 4, 1),
(44, 'WFB-1H5-GDXX-XX', '0', 0, 4, 1),
(45, 'WFD-1F3-GDEL-XX', '0', 0, 4, 1),
(46, 'WFD-1D4-GDEL-XX', '0', 0, 4, 1),
(47, 'WFD-1B6-GDEL-XX', '0', 0, 4, 1),
(48, 'WFD-1B6-RXXX-XX', '0', 0, 4, 1),
(49, 'WGS-GNS-1', '0', 0, 6, 1),
(50, 'WGS-GNS-2', '0', 0, 6, 1),
(51, 'WGS-NSB1-1501', '0', 0, 6, 1),
(52, 'WGS-SGH1', '0', 0, 6, 1),
(53, 'WGS-SCE1', '0', 0, 6, 1),
(55, 'WGS-GSHC1', '0', 0, 6, 1),
(58, 'WGS-WSGC1', '0', 0, 6, 1),
(59, 'rtyy6543', '45', 50, 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material_used`
--

CREATE TABLE `tbl_material_used` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `entry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person`
--

CREATE TABLE `tbl_person` (
  `id` int(5) NOT NULL,
  `person_id` varchar(20) NOT NULL,
  `person_name` varchar(100) NOT NULL,
  `person_mobile_no` varchar(20) NOT NULL,
  `person_address` text NOT NULL,
  `person_status` int(1) NOT NULL,
  `entry_by` int(2) NOT NULL,
  `entry_date` date NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person_loan`
--

CREATE TABLE `tbl_person_loan` (
  `id` int(11) NOT NULL,
  `person_id` int(3) NOT NULL,
  `loan_recieve` float(10,2) NOT NULL,
  `loan_repayment` float(10,2) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase`
--

CREATE TABLE `tbl_purchase` (
  `bill_id` int(11) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `less_amount` int(11) NOT NULL,
  `payment_recieved` int(11) NOT NULL,
  `due_to_company` int(11) NOT NULL,
  `material` tinyint(4) NOT NULL,
  `entry_date` date NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entry_by` int(2) NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_item`
--

CREATE TABLE `tbl_purchase_item` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(3) NOT NULL,
  `price` double(11,2) NOT NULL,
  `qty` int(6) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `material` tinyint(4) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(2) NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_qty_print`
--

CREATE TABLE `tbl_purchase_qty_print` (
  `id` int(11) NOT NULL,
  `purchase_item_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return`
--

CREATE TABLE `tbl_return` (
  `id` int(11) NOT NULL,
  `purchase_item_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `return_qty` int(11) NOT NULL,
  `return_price` int(11) NOT NULL,
  `total_return_price` int(11) NOT NULL,
  `cus_or_sup_id` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'Purchase Return= 1, Sell Return = 0',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_security_money_transaction`
--

CREATE TABLE `tbl_security_money_transaction` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `pay_receive` int(11) NOT NULL COMMENT 'company_pay=0, company_receive=1',
  `accounts_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sell`
--

CREATE TABLE `tbl_sell` (
  `sell_id` int(11) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `total_price` double(11,2) NOT NULL,
  `interest` double(11,2) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `payment_recieved` double(11,2) NOT NULL,
  `due_to_company` double(11,2) NOT NULL,
  `entry_date` date NOT NULL,
  `delivery_status` int(1) NOT NULL,
  `delivery_date` date NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entry_by` int(2) NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sell_invoice`
--

CREATE TABLE `tbl_sell_invoice` (
  `id` int(11) NOT NULL,
  `sell_id` int(11) NOT NULL,
  `ref_no` varchar(20) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_challan` varchar(20) NOT NULL,
  `delivery_address` text NOT NULL,
  `contact_ref` varchar(20) NOT NULL,
  `work_order_no` varchar(20) NOT NULL,
  `unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sell_item`
--

CREATE TABLE `tbl_sell_item` (
  `id` int(11) NOT NULL,
  `sell_no` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `price` double(11,2) NOT NULL,
  `qty` int(6) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `total_amount` double NOT NULL,
  `discount_exist` int(3) NOT NULL,
  `less_amount` float NOT NULL,
  `update_date` date NOT NULL,
  `delivery_status` int(1) NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shortage`
--

CREATE TABLE `tbl_shortage` (
  `id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `redA` int(11) NOT NULL,
  `redB` int(11) NOT NULL,
  `redC` int(11) NOT NULL,
  `whiteA` int(11) NOT NULL,
  `whiteB` int(11) NOT NULL,
  `whiteC` int(11) NOT NULL,
  `duckEgg` int(11) NOT NULL,
  `birdEgg` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id` int(5) NOT NULL,
  `supplier_id` varchar(20) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `supplier_company` varchar(50) NOT NULL,
  `supplier_mobile_no` varchar(20) NOT NULL,
  `supplier_address` text NOT NULL,
  `supplier_email` varchar(100) NOT NULL,
  `supplier_status` int(1) NOT NULL,
  `entry_by` int(2) NOT NULL,
  `entry_date` date NOT NULL,
  `update_by` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_accounts_with_acc_head_other_income`
-- (See below for the actual view)
--
CREATE TABLE `vw_accounts_with_acc_head_other_income` (
`acc_id` int(5)
,`cus_or_sup_id` varchar(30)
,`other_expense` int(3)
,`acc_head` int(2)
,`acc_name` varchar(100)
,`acc_desc` text
,`acc_amount` int(8)
,`acc_description` text
,`acc_type` int(2)
,`payment_method` tinyint(4)
,`entry_by` int(2)
,`entry_date` date
,`update_by` int(2)
,`last_update` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_purchase`
-- (See below for the actual view)
--
CREATE TABLE `vw_purchase` (
`bill_id` int(11)
,`supplier` varchar(50)
,`supplier_name` varchar(100)
,`total_price` int(11)
,`total_qty` int(11)
,`payment_recieved` int(11)
,`due_to_company` int(11)
,`material` tinyint(4)
,`entry_date` date
,`last_update` timestamp
,`entry_by` int(2)
,`update_by` int(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_purchase_dailly`
-- (See below for the actual view)
--
CREATE TABLE `vw_purchase_dailly` (
`entry_date` date
,`total_qty` decimal(32,0)
,`total_price` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_purchase_item`
-- (See below for the actual view)
--
CREATE TABLE `vw_purchase_item` (
`id` int(11)
,`bill_id` int(11)
,`product_id` int(3)
,`product_name` varchar(255)
,`price` double(11,2)
,`given_price` int(11)
,`qty` int(6)
,`supplier` varchar(255)
,`supplier_name` varchar(100)
,`entry_date` date
,`total_amount` int(11)
,`update_date` timestamp
,`status` int(2)
,`update_by` int(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_purchase_material_stock`
-- (See below for the actual view)
--
CREATE TABLE `vw_purchase_material_stock` (
`product_id` int(3)
,`product_name` varchar(255)
,`avg_purchase_price` double(15,6)
,`total_purchase_qty` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_purchase_monthly`
-- (See below for the actual view)
--
CREATE TABLE `vw_purchase_monthly` (
`entry_date` date
,`total_qty` decimal(32,0)
,`total_price` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_purchase_stock_item`
-- (See below for the actual view)
--
CREATE TABLE `vw_purchase_stock_item` (
`product_id` int(3)
,`product_name` varchar(255)
,`avg_purchase_price` double(15,6)
,`total_purchase_qty` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_purchase_yearly`
-- (See below for the actual view)
--
CREATE TABLE `vw_purchase_yearly` (
`entry_date` date
,`total_qty` decimal(32,0)
,`total_price` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell` (
`sell_id` int(11)
,`customer` varchar(50)
,`customer_name` varchar(100)
,`total_price` double(11,2)
,`total_qty` int(11)
,`payment_recieved` double(11,2)
,`due_to_company` double(11,2)
,`delivery_status` int(1)
,`entry_date` date
,`last_update` timestamp
,`entry_by` int(2)
,`update_by` int(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_daily`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_daily` (
`entry_date` date
,`total_qty` decimal(32,0)
,`total_price` double(19,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_item`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_item` (
`id` int(11)
,`sell_id` int(11)
,`product_id` int(5)
,`product_name` varchar(255)
,`original_price` double
,`price` double(11,2)
,`qty` int(6)
,`customer` varchar(50)
,`cus_name` varchar(100)
,`entry_date` date
,`total_amount` double
,`discount_exist` int(3)
,`less_amount` float
,`update_date` date
,`delivery_status` int(1)
,`update_by` int(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_monthly`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_monthly` (
`entry_date` date
,`total_qty` decimal(32,0)
,`total_price` double(19,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_purchase_item`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_purchase_item` (
`bill_or_sell_id` varchar(13)
,`purchase_sell_flag` varchar(1)
,`product_id` int(11)
,`product_name` varchar(255)
,`qty` int(11)
,`price` double(11,2)
,`total_amount` double
,`supplier_customer` varchar(255)
,`delivery_status` varchar(11)
,`supplier_customer_name` varchar(100)
,`entry_date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_purchase_item_daily`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_purchase_item_daily` (
`bill_or_sell_id` varchar(13)
,`purchase_sell_flag` varchar(1)
,`product_id` int(11)
,`product_name` varchar(255)
,`qty` decimal(32,0)
,`price` double(19,2)
,`total_amount` double
,`supplier_customer` varchar(255)
,`supplier_customer_name` varchar(100)
,`entry_date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_purchase_stock`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_purchase_stock` (
`product_id` int(3)
,`product_name` varchar(255)
,`avg_purchase_price` double(15,6)
,`total_purchase_qty` decimal(32,0)
,`avg_sell_price` double(15,6)
,`total_sell_qty` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_stock_item`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_stock_item` (
`product_id` int(5)
,`product_name` varchar(255)
,`avg_sell_price` double(15,6)
,`total_sell_qty` decimal(32,0)
,`delivery_status` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_sell_yearly`
-- (See below for the actual view)
--
CREATE TABLE `vw_sell_yearly` (
`entry_date` date
,`total_qty` decimal(32,0)
,`total_price` double(19,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_supplier_customer_advance_opening_balance`
-- (See below for the actual view)
--
CREATE TABLE `vw_supplier_customer_advance_opening_balance` (
`supplier_customer` varchar(30)
,`opening_due` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_supplier_customer_due_opening_balance`
-- (See below for the actual view)
--
CREATE TABLE `vw_supplier_customer_due_opening_balance` (
`supplier_customer` varchar(30)
,`opening_due` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_supplier_customer_total_recieved`
-- (See below for the actual view)
--
CREATE TABLE `vw_supplier_customer_total_recieved` (
`supplier_customer` varchar(30)
,`total_recieved` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_supplier_customer_total_transection`
-- (See below for the actual view)
--
CREATE TABLE `vw_supplier_customer_total_transection` (
`supplier_customer` varchar(50)
,`total_price` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_used_material`
-- (See below for the actual view)
--
CREATE TABLE `vw_used_material` (
`product_id` int(11)
,`product` varchar(255)
,`qty` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_user_info`
-- (See below for the actual view)
--
CREATE TABLE `vw_user_info` (
`UserId` int(6)
,`FullName` varchar(100)
,`UserName` varchar(100)
,`Password` varchar(32)
,`Email` varchar(100)
,`MobileNo` varchar(20)
,`NationalId` int(1)
,`Address` longtext
,`zone` varchar(255)
,`PhotoPath` longtext
,`Status` int(2)
,`UserType` varchar(20)
,`UserAccessId` int(6)
,`MenuPermission` longtext
,`WorkPermission` varchar(200)
,`EntryBy` int(5)
,`EntryDate` datetime
,`UpdateBy` int(5)
,`LastUpdate` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `_createuser`
--

CREATE TABLE `_createuser` (
  `UserId` int(6) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(32) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `MobileNo` varchar(20) DEFAULT NULL,
  `NationalId` int(1) DEFAULT NULL,
  `Address` longtext,
  `zone` varchar(255) NOT NULL,
  `PhotoPath` longtext,
  `Status` int(2) DEFAULT NULL,
  `EntryBy` int(5) DEFAULT NULL,
  `EntryDate` datetime DEFAULT NULL,
  `UpdateBy` int(5) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `_createuser`
--

INSERT INTO `_createuser` (`UserId`, `FullName`, `UserName`, `Password`, `Email`, `MobileNo`, `NationalId`, `Address`, `zone`, `PhotoPath`, `Status`, `EntryBy`, `EntryDate`, `UpdateBy`, `LastUpdate`) VALUES
(1, 'BSD', 'BSD', 'c4ca4238a0b923820dcc509a6f75849b', 'info@bsdbd.com', '01959919801', 1, 'house#15,Road#6,Nikunjo-2', '', 'asset/userphoto/BSTLDGJLOX6780.jpg', 1, 1, '2014-12-04 04:24:29', 1, '2017-04-16 05:06:30'),
(2, 'ALIM KHAN', 'alim', 'f1a8f4a7bd3dd919ad65fc9c908533a9', 'alim01713864259@gmail.com', '01711351537', NULL, 'Kadamtala', '0', '0', 1, 1, '2019-07-16 12:48:04', 1, '2019-07-16 06:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `_useraccess`
--

CREATE TABLE `_useraccess` (
  `UserAccessId` int(6) NOT NULL,
  `UserId` int(6) NOT NULL,
  `UserType` varchar(20) DEFAULT NULL,
  `MenuPermission` longtext,
  `WorkPermission` varchar(200) DEFAULT NULL,
  `EntryBy` int(5) DEFAULT NULL,
  `EntryDate` datetime DEFAULT NULL,
  `UpdateBy` int(5) DEFAULT NULL,
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `_useraccess`
--

INSERT INTO `_useraccess` (`UserAccessId`, `UserId`, `UserType`, `MenuPermission`, `WorkPermission`, `EntryBy`, `EntryDate`, `UpdateBy`, `LastUpdate`) VALUES
(1, 1, 'SA', '', '', 1, '2014-12-04 04:24:29', 1, '2017-01-31 15:51:27'),
(2, 2, 'SA', 'a:31:{i:0;s:10:\"usercreate\";i:1;s:9:\"view_user\";i:2;s:12:\"all_category\";i:3;s:8:\"all_item\";i:4;s:12:\"add_customer\";i:5;s:13:\"view_customer\";i:6;s:12:\"add_supplier\";i:7;s:13:\"view_supplier\";i:8;s:12:\"add_purchase\";i:9;s:17:\"view_all_purchase\";i:10;s:8:\"add_sell\";i:11;s:13:\"view_all_sell\";i:12;s:18:\"add_payment_person\";i:13;s:17:\"account_statement\";i:14;s:12:\"stock_report\";i:15;s:13:\"income_report\";i:16;s:14:\"expense_report\";i:17;s:15:\"purchase_report\";i:18;s:11:\"sale_report\";i:19;s:7:\"expense\";i:20;s:11:\"sale_report\";i:21;s:13:\"balance_sheet\";i:22;s:15:\"add_loan_person\";i:23;s:9:\"loan_list\";i:24;s:9:\"take_loan\";i:25;s:18:\"add_security_money\";i:26;s:19:\"view_security_money\";i:27;s:12:\"add_employee\";i:28;s:13:\"view_employee\";i:29;s:7:\"add_bnk\";i:30;s:9:\"view_bank\";}', 'a:0:{}', 1, '2019-07-16 12:48:04', 1, '2019-07-16 06:48:04');

-- --------------------------------------------------------

--
-- Structure for view `vw_accounts_with_acc_head_other_income`
--
DROP TABLE IF EXISTS `vw_accounts_with_acc_head_other_income`;

CREATE SQL SECURITY DEFINER VIEW `vw_accounts_with_acc_head_other_income`  AS  select `tbl_account`.`acc_id` AS `acc_id`,`tbl_account`.`cus_or_sup_id` AS `cus_or_sup_id`,`tbl_account`.`other_expense` AS `other_expense`,`tbl_account`.`acc_head` AS `acc_head`,`tbl_ac_head_other_income`.`acc_name` AS `acc_name`,`tbl_ac_head_other_income`.`acc_desc` AS `acc_desc`,`tbl_account`.`acc_amount` AS `acc_amount`,`tbl_account`.`acc_description` AS `acc_description`,`tbl_account`.`acc_type` AS `acc_type`,`tbl_account`.`payment_method` AS `payment_method`,`tbl_account`.`entry_by` AS `entry_by`,`tbl_account`.`entry_date` AS `entry_date`,`tbl_account`.`update_by` AS `update_by`,`tbl_account`.`last_update` AS `last_update` from (`tbl_account` left join `tbl_ac_head_other_income` on((`tbl_account`.`acc_head` = `tbl_ac_head_other_income`.`acc_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_purchase`
--
DROP TABLE IF EXISTS `vw_purchase`;

CREATE SQL SECURITY DEFINER VIEW `vw_purchase`  AS  select `tbl_purchase`.`bill_id` AS `bill_id`,`tbl_purchase`.`supplier` AS `supplier`,`tbl_supplier`.`supplier_name` AS `supplier_name`,`tbl_purchase`.`total_price` AS `total_price`,`tbl_purchase`.`total_qty` AS `total_qty`,`tbl_purchase`.`payment_recieved` AS `payment_recieved`,`tbl_purchase`.`due_to_company` AS `due_to_company`,`tbl_purchase`.`material` AS `material`,`tbl_purchase`.`entry_date` AS `entry_date`,`tbl_purchase`.`last_update` AS `last_update`,`tbl_purchase`.`entry_by` AS `entry_by`,`tbl_purchase`.`update_by` AS `update_by` from (`tbl_purchase` join `tbl_supplier` on((convert(`tbl_purchase`.`supplier` using utf8) = `tbl_supplier`.`supplier_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_purchase_dailly`
--
DROP TABLE IF EXISTS `vw_purchase_dailly`;

CREATE SQL SECURITY DEFINER VIEW `vw_purchase_dailly`  AS  select `vw_purchase`.`entry_date` AS `entry_date`,sum(`vw_purchase`.`total_qty`) AS `total_qty`,sum(`vw_purchase`.`total_price`) AS `total_price` from `vw_purchase` group by `vw_purchase`.`entry_date` order by `vw_purchase`.`entry_date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_purchase_item`
--
DROP TABLE IF EXISTS `vw_purchase_item`;

CREATE SQL SECURITY DEFINER VIEW `vw_purchase_item`  AS  select `tbl_purchase_item`.`id` AS `id`,`tbl_purchase_item`.`bill_id` AS `bill_id`,`tbl_purchase_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,`tbl_purchase_item`.`price` AS `price`,`tbl_purchase_qty_print`.`price` AS `given_price`,`tbl_purchase_item`.`qty` AS `qty`,`tbl_purchase_item`.`supplier` AS `supplier`,`tbl_supplier`.`supplier_name` AS `supplier_name`,`tbl_purchase`.`entry_date` AS `entry_date`,`tbl_purchase_item`.`total_amount` AS `total_amount`,`tbl_purchase_item`.`update_date` AS `update_date`,`tbl_purchase_item`.`status` AS `status`,`tbl_purchase_item`.`update_by` AS `update_by` from ((((`tbl_purchase_item` left join `tbl_item_with_price` on((`tbl_purchase_item`.`product_id` = `tbl_item_with_price`.`item_id`))) left join `tbl_purchase` on((`tbl_purchase_item`.`bill_id` = `tbl_purchase`.`bill_id`))) left join `tbl_purchase_qty_print` on((`tbl_purchase_item`.`id` = `tbl_purchase_qty_print`.`purchase_item_id`))) left join `tbl_supplier` on((convert(`tbl_purchase_item`.`supplier` using utf8) = `tbl_supplier`.`supplier_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_purchase_material_stock`
--
DROP TABLE IF EXISTS `vw_purchase_material_stock`;

CREATE SQL SECURITY DEFINER VIEW `vw_purchase_material_stock`  AS  select `tbl_purchase_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,avg(`tbl_purchase_item`.`price`) AS `avg_purchase_price`,sum(`tbl_purchase_item`.`qty`) AS `total_purchase_qty` from (`tbl_purchase_item` join `tbl_item_with_price` on((`tbl_purchase_item`.`product_id` = `tbl_item_with_price`.`item_id`))) where (`tbl_purchase_item`.`material` = 1) group by `tbl_purchase_item`.`product_id` order by `tbl_purchase_item`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_purchase_monthly`
--
DROP TABLE IF EXISTS `vw_purchase_monthly`;

CREATE SQL SECURITY DEFINER VIEW `vw_purchase_monthly`  AS  select `vw_purchase`.`entry_date` AS `entry_date`,sum(`vw_purchase`.`total_qty`) AS `total_qty`,sum(`vw_purchase`.`total_price`) AS `total_price` from `vw_purchase` group by month(`vw_purchase`.`entry_date`) order by `vw_purchase`.`entry_date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_purchase_stock_item`
--
DROP TABLE IF EXISTS `vw_purchase_stock_item`;

CREATE SQL SECURITY DEFINER VIEW `vw_purchase_stock_item`  AS  select `tbl_purchase_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,avg(`tbl_purchase_item`.`price`) AS `avg_purchase_price`,sum(`tbl_purchase_item`.`qty`) AS `total_purchase_qty` from (`tbl_purchase_item` join `tbl_item_with_price` on((`tbl_purchase_item`.`product_id` = `tbl_item_with_price`.`item_id`))) where (`tbl_purchase_item`.`material` = 0) group by `tbl_purchase_item`.`product_id` order by `tbl_purchase_item`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_purchase_yearly`
--
DROP TABLE IF EXISTS `vw_purchase_yearly`;

CREATE SQL SECURITY DEFINER VIEW `vw_purchase_yearly`  AS  select `vw_purchase`.`entry_date` AS `entry_date`,sum(`vw_purchase`.`total_qty`) AS `total_qty`,sum(`vw_purchase`.`total_price`) AS `total_price` from `vw_purchase` group by year(`vw_purchase`.`entry_date`) order by `vw_purchase`.`entry_date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell`
--
DROP TABLE IF EXISTS `vw_sell`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell`  AS  select `tbl_sell`.`sell_id` AS `sell_id`,`tbl_sell`.`customer` AS `customer`,`tbl_customer`.`cus_name` AS `customer_name`,`tbl_sell`.`total_price` AS `total_price`,`tbl_sell`.`total_qty` AS `total_qty`,`tbl_sell`.`payment_recieved` AS `payment_recieved`,`tbl_sell`.`due_to_company` AS `due_to_company`,`tbl_sell`.`delivery_status` AS `delivery_status`,`tbl_sell`.`entry_date` AS `entry_date`,`tbl_sell`.`last_update` AS `last_update`,`tbl_sell`.`entry_by` AS `entry_by`,`tbl_sell`.`update_by` AS `update_by` from (`tbl_sell` join `tbl_customer` on((convert(`tbl_sell`.`customer` using utf8) = `tbl_customer`.`cus_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_daily`
--
DROP TABLE IF EXISTS `vw_sell_daily`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_daily`  AS  select `vw_sell`.`entry_date` AS `entry_date`,sum(`vw_sell`.`total_qty`) AS `total_qty`,sum(`vw_sell`.`total_price`) AS `total_price` from `vw_sell` group by `vw_sell`.`entry_date` order by `vw_sell`.`entry_date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_item`
--
DROP TABLE IF EXISTS `vw_sell_item`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_item`  AS  select `tbl_sell_item`.`id` AS `id`,`tbl_sell_item`.`sell_no` AS `sell_id`,`tbl_sell_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,`tbl_item_with_price`.`sell_price` AS `original_price`,`tbl_sell_item`.`price` AS `price`,`tbl_sell_item`.`qty` AS `qty`,`tbl_sell_item`.`customer` AS `customer`,`tbl_customer`.`cus_name` AS `cus_name`,`tbl_sell`.`entry_date` AS `entry_date`,`tbl_sell_item`.`total_amount` AS `total_amount`,`tbl_sell_item`.`discount_exist` AS `discount_exist`,`tbl_sell_item`.`less_amount` AS `less_amount`,`tbl_sell_item`.`update_date` AS `update_date`,`tbl_sell_item`.`delivery_status` AS `delivery_status`,`tbl_sell_item`.`update_by` AS `update_by` from (((`tbl_sell_item` join `tbl_item_with_price` on((`tbl_sell_item`.`product_id` = `tbl_item_with_price`.`item_id`))) left join `tbl_sell` on((`tbl_sell_item`.`sell_no` = `tbl_sell`.`sell_id`))) left join `tbl_customer` on((convert(`tbl_sell_item`.`customer` using utf8) = `tbl_customer`.`cus_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_monthly`
--
DROP TABLE IF EXISTS `vw_sell_monthly`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_monthly`  AS  select `vw_sell`.`entry_date` AS `entry_date`,sum(`vw_sell`.`total_qty`) AS `total_qty`,sum(`vw_sell`.`total_price`) AS `total_price` from `vw_sell` group by month(`vw_sell`.`entry_date`) order by `vw_sell`.`entry_date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_purchase_item`
--
DROP TABLE IF EXISTS `vw_sell_purchase_item`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_purchase_item`  AS  select concat('p_',`tbl_purchase_item`.`bill_id`) AS `bill_or_sell_id`,'1' AS `purchase_sell_flag`,`tbl_purchase_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,`tbl_purchase_item`.`qty` AS `qty`,`tbl_purchase_item`.`price` AS `price`,`tbl_purchase_item`.`total_amount` AS `total_amount`,`tbl_purchase_item`.`supplier` AS `supplier_customer`,'N/A' AS `delivery_status`,`tbl_supplier`.`supplier_name` AS `supplier_customer_name`,`tbl_purchase`.`entry_date` AS `entry_date` from (((`tbl_purchase_item` join `tbl_item_with_price` on((`tbl_purchase_item`.`product_id` = `tbl_item_with_price`.`item_id`))) left join `tbl_purchase` on((`tbl_purchase_item`.`bill_id` = `tbl_purchase`.`bill_id`))) left join `tbl_supplier` on((convert(`tbl_purchase_item`.`supplier` using utf8) = `tbl_supplier`.`supplier_id`))) union select concat('s_',`tbl_sell_item`.`sell_no`) AS `bill_or_sell_id`,'0' AS `purchase_sell_flag`,`tbl_sell_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,`tbl_sell_item`.`qty` AS `qty`,`tbl_sell_item`.`price` AS `price`,`tbl_sell_item`.`total_amount` AS `total_amount`,`tbl_sell_item`.`customer` AS `supplier_customer`,`tbl_sell_item`.`delivery_status` AS `delivery_status`,`tbl_customer`.`cus_name` AS `supplier_customer_name`,`tbl_sell`.`entry_date` AS `entry_date` from (((`tbl_sell_item` join `tbl_item_with_price` on((`tbl_sell_item`.`product_id` = `tbl_item_with_price`.`item_id`))) left join `tbl_sell` on((`tbl_sell_item`.`sell_no` = `tbl_sell`.`sell_id`))) left join `tbl_customer` on((convert(`tbl_sell_item`.`customer` using utf8) = `tbl_customer`.`cus_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_purchase_item_daily`
--
DROP TABLE IF EXISTS `vw_sell_purchase_item_daily`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_purchase_item_daily`  AS  select concat('p_',`tbl_purchase_item`.`bill_id`) AS `bill_or_sell_id`,'1' AS `purchase_sell_flag`,`tbl_purchase_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,sum(`tbl_purchase_item`.`qty`) AS `qty`,sum(`tbl_purchase_item`.`price`) AS `price`,sum(`tbl_purchase_item`.`total_amount`) AS `total_amount`,`tbl_purchase_item`.`supplier` AS `supplier_customer`,`tbl_supplier`.`supplier_name` AS `supplier_customer_name`,`tbl_purchase`.`entry_date` AS `entry_date` from (((`tbl_purchase_item` join `tbl_item_with_price` on((`tbl_purchase_item`.`product_id` = `tbl_item_with_price`.`item_id`))) left join `tbl_purchase` on((`tbl_purchase_item`.`bill_id` = `tbl_purchase`.`bill_id`))) left join `tbl_supplier` on((convert(`tbl_purchase_item`.`supplier` using utf8) = `tbl_supplier`.`supplier_id`))) group by `tbl_purchase_item`.`product_id`,`tbl_purchase`.`entry_date` union select concat('s_',`tbl_sell_item`.`sell_no`) AS `bill_or_sell_id`,'0' AS `purchase_sell_flag`,`tbl_sell_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,sum(`tbl_sell_item`.`qty`) AS `qty`,sum(`tbl_sell_item`.`price`) AS `price`,sum(`tbl_sell_item`.`total_amount`) AS `total_amount`,`tbl_sell_item`.`customer` AS `supplier_customer`,`tbl_customer`.`cus_name` AS `supplier_customer_name`,`tbl_sell`.`entry_date` AS `entry_date` from (((`tbl_sell_item` join `tbl_item_with_price` on((`tbl_sell_item`.`product_id` = `tbl_item_with_price`.`item_id`))) left join `tbl_sell` on((`tbl_sell_item`.`sell_no` = `tbl_sell`.`sell_id`))) left join `tbl_customer` on((convert(`tbl_sell_item`.`customer` using utf8) = `tbl_customer`.`cus_id`))) group by `tbl_sell_item`.`product_id`,`tbl_sell`.`entry_date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_purchase_stock`
--
DROP TABLE IF EXISTS `vw_sell_purchase_stock`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_purchase_stock`  AS  select `vw_purchase_stock_item`.`product_id` AS `product_id`,`vw_purchase_stock_item`.`product_name` AS `product_name`,`vw_purchase_stock_item`.`avg_purchase_price` AS `avg_purchase_price`,`vw_purchase_stock_item`.`total_purchase_qty` AS `total_purchase_qty`,`vw_sell_stock_item`.`avg_sell_price` AS `avg_sell_price`,`vw_sell_stock_item`.`total_sell_qty` AS `total_sell_qty` from (`vw_purchase_stock_item` left join `vw_sell_stock_item` on((`vw_purchase_stock_item`.`product_id` = `vw_sell_stock_item`.`product_id`))) order by `vw_sell_stock_item`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_stock_item`
--
DROP TABLE IF EXISTS `vw_sell_stock_item`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_stock_item`  AS  select `tbl_sell_item`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product_name`,avg(`tbl_sell_item`.`price`) AS `avg_sell_price`,sum(`tbl_sell_item`.`qty`) AS `total_sell_qty`,`tbl_sell_item`.`delivery_status` AS `delivery_status` from (`tbl_sell_item` join `tbl_item_with_price` on((`tbl_sell_item`.`product_id` = `tbl_item_with_price`.`item_id`))) group by `tbl_sell_item`.`product_id` order by `tbl_sell_item`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_sell_yearly`
--
DROP TABLE IF EXISTS `vw_sell_yearly`;

CREATE SQL SECURITY DEFINER VIEW `vw_sell_yearly`  AS  select `vw_sell`.`entry_date` AS `entry_date`,sum(`vw_sell`.`total_qty`) AS `total_qty`,sum(`vw_sell`.`total_price`) AS `total_price` from `vw_sell` group by year(`vw_sell`.`entry_date`) order by `vw_sell`.`entry_date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_supplier_customer_advance_opening_balance`
--
DROP TABLE IF EXISTS `vw_supplier_customer_advance_opening_balance`;

CREATE SQL SECURITY DEFINER VIEW `vw_supplier_customer_advance_opening_balance`  AS  select `tbl_account`.`cus_or_sup_id` AS `supplier_customer`,sum(`tbl_account`.`acc_amount`) AS `opening_due` from `tbl_account` where (`tbl_account`.`acc_type` = 9) group by `tbl_account`.`cus_or_sup_id` union select `tbl_account`.`cus_or_sup_id` AS `supplier_customer`,sum(`tbl_account`.`acc_amount`) AS `total_recieved` from `tbl_account` where (`tbl_account`.`acc_type` = 7) group by `tbl_account`.`cus_or_sup_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_supplier_customer_due_opening_balance`
--
DROP TABLE IF EXISTS `vw_supplier_customer_due_opening_balance`;

CREATE SQL SECURITY DEFINER VIEW `vw_supplier_customer_due_opening_balance`  AS  select `tbl_account`.`cus_or_sup_id` AS `supplier_customer`,sum(`tbl_account`.`acc_amount`) AS `opening_due` from `tbl_account` where (`tbl_account`.`acc_type` = 10) group by `tbl_account`.`cus_or_sup_id` union select `tbl_account`.`cus_or_sup_id` AS `supplier_customer`,sum(`tbl_account`.`acc_amount`) AS `total_recieved` from `tbl_account` where (`tbl_account`.`acc_type` = 8) group by `tbl_account`.`cus_or_sup_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_supplier_customer_total_recieved`
--
DROP TABLE IF EXISTS `vw_supplier_customer_total_recieved`;

CREATE SQL SECURITY DEFINER VIEW `vw_supplier_customer_total_recieved`  AS  select `tbl_account`.`cus_or_sup_id` AS `supplier_customer`,sum(`tbl_account`.`acc_amount`) AS `total_recieved` from `tbl_account` where ((`tbl_account`.`acc_type` = 2) or (`tbl_account`.`acc_type` = 6)) group by `tbl_account`.`cus_or_sup_id` union select `tbl_account`.`cus_or_sup_id` AS `supplier_customer`,sum(`tbl_account`.`acc_amount`) AS `total_recieved` from `tbl_account` where ((`tbl_account`.`acc_type` = 3) or (`tbl_account`.`acc_type` = 5)) group by `tbl_account`.`cus_or_sup_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_supplier_customer_total_transection`
--
DROP TABLE IF EXISTS `vw_supplier_customer_total_transection`;

CREATE SQL SECURITY DEFINER VIEW `vw_supplier_customer_total_transection`  AS  select `tbl_purchase`.`supplier` AS `supplier_customer`,sum(`tbl_purchase`.`total_price`) AS `total_price` from `tbl_purchase` group by `tbl_purchase`.`supplier` union select `tbl_sell`.`customer` AS `supplier_customer`,sum(`tbl_sell`.`total_price`) AS `total_price` from `tbl_sell` group by `tbl_sell`.`customer` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_used_material`
--
DROP TABLE IF EXISTS `vw_used_material`;

CREATE SQL SECURITY DEFINER VIEW `vw_used_material`  AS  select `tbl_material_used`.`product_id` AS `product_id`,`tbl_item_with_price`.`item_name` AS `product`,sum(`tbl_material_used`.`qty`) AS `qty` from (`tbl_material_used` left join `tbl_item_with_price` on((`tbl_material_used`.`product_id` = `tbl_item_with_price`.`item_id`))) group by `tbl_material_used`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_user_info`
--
DROP TABLE IF EXISTS `vw_user_info`;

CREATE SQL SECURITY DEFINER VIEW `vw_user_info`  AS  select `_createuser`.`UserId` AS `UserId`,`_createuser`.`FullName` AS `FullName`,`_createuser`.`UserName` AS `UserName`,`_createuser`.`Password` AS `Password`,`_createuser`.`Email` AS `Email`,`_createuser`.`MobileNo` AS `MobileNo`,`_createuser`.`NationalId` AS `NationalId`,`_createuser`.`Address` AS `Address`,`_createuser`.`zone` AS `zone`,`_createuser`.`PhotoPath` AS `PhotoPath`,`_createuser`.`Status` AS `Status`,`_useraccess`.`UserType` AS `UserType`,`_useraccess`.`UserAccessId` AS `UserAccessId`,`_useraccess`.`MenuPermission` AS `MenuPermission`,`_useraccess`.`WorkPermission` AS `WorkPermission`,`_createuser`.`EntryBy` AS `EntryBy`,`_createuser`.`EntryDate` AS `EntryDate`,`_createuser`.`UpdateBy` AS `UpdateBy`,`_createuser`.`LastUpdate` AS `LastUpdate` from (`_createuser` left join `_useraccess` on((`_createuser`.`UserId` = `_useraccess`.`UserId`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_type_list`
--
ALTER TABLE `acc_type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `bank_registration`
--
ALTER TABLE `bank_registration`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `tbl_ac_head_other_income`
--
ALTER TABLE `tbl_ac_head_other_income`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `tbl_company_lend`
--
ALTER TABLE `tbl_company_lend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_delivery`
--
ALTER TABLE `tbl_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_delivery_item`
--
ALTER TABLE `tbl_delivery_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employee_transaction`
--
ALTER TABLE `tbl_employee_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_item_with_price`
--
ALTER TABLE `tbl_item_with_price`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tbl_material_used`
--
ALTER TABLE `tbl_material_used`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_person`
--
ALTER TABLE `tbl_person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_person_loan`
--
ALTER TABLE `tbl_person_loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `tbl_purchase_item`
--
ALTER TABLE `tbl_purchase_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_qty_print`
--
ALTER TABLE `tbl_purchase_qty_print`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_return`
--
ALTER TABLE `tbl_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_security_money_transaction`
--
ALTER TABLE `tbl_security_money_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sell`
--
ALTER TABLE `tbl_sell`
  ADD PRIMARY KEY (`sell_id`);

--
-- Indexes for table `tbl_sell_invoice`
--
ALTER TABLE `tbl_sell_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sell_item`
--
ALTER TABLE `tbl_sell_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_shortage`
--
ALTER TABLE `tbl_shortage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_createuser`
--
ALTER TABLE `_createuser`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `_useraccess`
--
ALTER TABLE `_useraccess`
  ADD PRIMARY KEY (`UserAccessId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_type_list`
--
ALTER TABLE `acc_type_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_registration`
--
ALTER TABLE `bank_registration`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `acc_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_ac_head_other_income`
--
ALTER TABLE `tbl_ac_head_other_income`
  MODIFY `acc_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cat_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_company_lend`
--
ALTER TABLE `tbl_company_lend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_delivery`
--
ALTER TABLE `tbl_delivery`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_delivery_item`
--
ALTER TABLE `tbl_delivery_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_employee_transaction`
--
ALTER TABLE `tbl_employee_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_item_with_price`
--
ALTER TABLE `tbl_item_with_price`
  MODIFY `item_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tbl_material_used`
--
ALTER TABLE `tbl_material_used`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_person`
--
ALTER TABLE `tbl_person`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_person_loan`
--
ALTER TABLE `tbl_person_loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_item`
--
ALTER TABLE `tbl_purchase_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_qty_print`
--
ALTER TABLE `tbl_purchase_qty_print`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_return`
--
ALTER TABLE `tbl_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_security_money_transaction`
--
ALTER TABLE `tbl_security_money_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sell`
--
ALTER TABLE `tbl_sell`
  MODIFY `sell_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sell_invoice`
--
ALTER TABLE `tbl_sell_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sell_item`
--
ALTER TABLE `tbl_sell_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_shortage`
--
ALTER TABLE `tbl_shortage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_createuser`
--
ALTER TABLE `_createuser`
  MODIFY `UserId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `_useraccess`
--
ALTER TABLE `_useraccess`
  MODIFY `UserAccessId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
