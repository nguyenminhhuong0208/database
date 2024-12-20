-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 20, 2024 lúc 08:51 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

drop database if exists btlcsdl ;
create database btlcsdl;
use btlcsdl;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `btlcsdl`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `profile`) VALUES
('Q40u623KflRZY5x9JBXr', 'marry', 'marry123@gmail.com', '32d83f533a32c56d809fd64e056784a3da9df71c', ''),
('Sil8PB1PRqpxNzUwsbtR', 'dfasdf', 'adfadf@afdlasdfk.com', '7ab581d596bf97c110b2c6432a4566eebc88d5c7', ''),
('Thzdn0OfPVqaCQsv3Dnc', 'marry', 'json123@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', ''),
('2hHpXrOR0zIHrE1RAwnP', 'matcha', 'matcha@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '3gianwithlove.jpg'),
('KWezpz5hTqEo9Rjne1JD', 'tuyen', '123@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'anhthe.jpg'),
('kCCTdhQRzcGe4F1m5iu6', '123', '4@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bai3..jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(100) NOT NULL,
  `qty` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
('MWkKHPgeFA7ecMLE9TiX', '', '294kfCd9sCmRvOzSK2yy', 123, 6),
('8HhwBULNBWWs5fPAlE54', '', 'JeKnSOzWE4dWg4RZMIzn', 123, 5),
('NFeLQ3dqmihC4QanwCfD', 'lcTBHW4IgBaMdClIKolT', 'JeKnSOzWE4dWg4RZMIzn', 123, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `message`
--

CREATE TABLE `message` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
('', 'njwVeOMLxTfns68SqQ8O', 'tuyen cute nee', 'marry123@gmail.com', '', 'chao buoi toi nha'),
('', 'njwVeOMLxTfns68SqQ8O', 'tuyen', 'marry123@gmail.com', '', 'chao buoi toi '),
('', 'njwVeOMLxTfns68SqQ8O', 'tuyen cute ne ', 'marry123@gmail.com', '', 'hihihihi'),
('', 'njwVeOMLxTfns68SqQ8O', 'tuyen', 'marry123@gmail.com', '', 'hihihihi\r\n'),
('', 'njwVeOMLxTfns68SqQ8O', 'tuyenn', 'marry123@gmail.com', '', 'hihi to ne'),
('', 'njwVeOMLxTfns68SqQ8O', 'tuyen', 'marry123@gmail.com', '', 'do cau biet t la ai'),
('', '', 'tuyen', 'matcha@gmail.com', '', 'hihihi chao buoi trua');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` int(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(10) NOT NULL,
  `qty` varchar(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`, `payment_status`) VALUES
('yIeArxy9RO5b3ZaI5PLU', 'njwVeOMLxTfns68SqQ8O', 'marry', 98765432, 'marry123@gmail.com', '100, 144, hihi, hihi, 100000', 'home', 'cash on delivery', 'JeKnSOzWE4dWg4RZMIzn', 123, '5', '2024-12-15', 'in progress', ''),
('Mbjw57KlD2C311wU16qi', 'lcTBHW4IgBaMdClIKolT', 'marry', 1234567890, 'marry123@gmail.com', 'hihi, hihi, hihi, hihi, 1234', 'home', 'cash on delivery', '294kfCd9sCmRvOzSK2yy', 123, '1', '2024-12-19', 'in progress', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_products`
--

CREATE TABLE `order_products` (
  `order_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` int(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_detail` varchar(2000) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `product_detail`, `status`) VALUES
('JeKnSOzWE4dWg4RZMIzn', 'marrry', 123, '3gianwithlove.jpg', 'hoeqhfqndlksand', 'active'),
('294kfCd9sCmRvOzSK2yy', 'tom', 123, 'module_table_bottom.png', 'bajksjHDLAJSHD', 'active'),
('99N9NKNK9RVwPtjftwGz', '123', 12, 'thumb1.jpg', 'FEQHGJ', 'active'),
('qKhHzwhttmi8oJF9Ltcp', 'Trà xanh Tân Cương', 300, 'mau-sac-va-huong-vi-cua-luc-tra-nhai-2.jpg', 'trà ngon bổ rẻ', 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` varchar(20) primary key NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` varchar(100) NOT NULL DEFAULT 'user',
  `profile` varchar(255) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `dateob` date NOT NULL DEFAULT current_timestamp(),
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `profile`, `fullname`, `dateob`, `gender`) VALUES
('rIKw3fWZ6sJbSWMqmR8l', 'Satoru', '', 'Marry124', 'user', '', '', '0000-00-00', 'male'),
('avBlhfGDpYha3WLvICmO', 'Satoru', '', 'Hello123', 'user', '', '', '0000-00-00', 'male'),
('njwVeOMLxTfns68SqQ8O', 'Satoru', '', '1234', 'user', '', '', '0000-00-00', 'male'),
('AYvbOECYWlTFeZSOGpmT', 'marry', 'marry123@gmail.com', 'Thanhtuyen23586*', 'user', '', '', '2024-12-19', NULL),
('lcTBHW4IgBaMdClIKolT', 'meee', 'tuyen123@gmail.com', 'Tuyen@123', 'user', '0.jpg', 'meee', '2012-12-12', 'female');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
('B1n0kjkuQaZna9mu87yY', 'B1n0kjkuQaZna9mu87yY', '', 100),
('SnkufKGkP4LM5HMqj4Kx', 'SnkufKGkP4LM5HMqj4Kx', '', 100),
('9TT0YLM6sL7V6YkSuTSH', '9TT0YLM6sL7V6YkSuTSH', '', 100),
('b1ZyjHUxun0rtXdTtSHX', 'b1ZyjHUxun0rtXdTtSHX', '', 100),
('6oq2PdZtAG7IKTuZkMEu', '6oq2PdZtAG7IKTuZkMEu', '', 100),
('1hNt5PlqHI7ozz5FBq1d', '1hNt5PlqHI7ozz5FBq1d', '', 100),
('Mo25I3i8AZLQ0j4A0lJC', 'Mo25I3i8AZLQ0j4A0lJC', '', 100),
('vVwBYSsBWPrC77y2iopa', 'vVwBYSsBWPrC77y2iopa', '', 100),
('1yPI6z8k3UzHkpNjLACd', '1yPI6z8k3UzHkpNjLACd', '', 100),
('nCDWXmLlpCANOH2VlKB3', 'nCDWXmLlpCANOH2VlKB3', '', 100),
('Lr7Kv3mDnlp2oVQb40Y3', 'Lr7Kv3mDnlp2oVQb40Y3', '', 100),
('SyrzidIIDfxxKEovucqm', 'SyrzidIIDfxxKEovucqm', '', 100),
('siVEMk4uXFzvyemsA9sP', 'siVEMk4uXFzvyemsA9sP', '', 100),
('ghAIbiFNuRYlrv0llVfL', 'ghAIbiFNuRYlrv0llVfL', '', 100),
('AKzLXcCNUelEv0gBuxx2', 'njwVeOMLxTfns68SqQ8O', '$productId', 0),
('jD90MDlIeqZPLg2NehDy', '', '294kfCd9sCmRvOzSK2yy', 123),
('We7BBCyZmucBspMImXvM', '', '99N9NKNK9RVwPtjftwGz', 12),
('wafftgf38ZAq1AeVPqcB', 'njwVeOMLxTfns68SqQ8O', 'JeKnSOzWE4dWg4RZMIzn', 123);

--
-- Chỉ mục cho các bảng đã đổ
--

-- tạo bảo voucher
CREATE TABLE voucher (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Khóa chính
    discount DECIMAL(10,2) NOT NULL, -- Giảm giá
    requirement VARCHAR(255) NOT NULL, -- Điều kiện áp dụng
    description TEXT, -- Mô tả voucher
    qty INT NOT NULL, -- Số lượng voucher
    category VARCHAR(100) -- Loại voucher
);

-- Tạo bảng user_voucher
CREATE TABLE user_voucher (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Khóa chính cho bảng này (tùy chọn)
    voucher_id INT NOT NULL, -- Tham chiếu tới voucher
    user_id varchar(20) NOT NULL, -- Tham chiếu tới user
    qty INT NOT NULL, -- Số lượng voucher mà user sở hữu
    FOREIGN KEY (voucher_id) REFERENCES voucher(id) ON DELETE CASCADE, -- Ràng buộc khóa ngoại
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Ràng buộc khóa ngoại
);
--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD KEY `fk_order_id_idx` (`id`);

--
-- Chỉ mục cho bảng `order_products`
--
ALTER TABLE `order_products`
  ADD KEY `fk_order_id_idx` (`order_id`),
  ADD KEY `fk_productid_idx` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD KEY `fk_productid_idx` (`id`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productid` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
