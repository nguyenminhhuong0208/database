-- Xóa cơ sở dữ liệu nếu đã tồn tại
DROP DATABASE IF EXISTS BTLcsdl;
CREATE DATABASE BTLcsdl;
USE BTLcsdl;

-- Tạo các bảng
CREATE TABLE admin (
  id varchar(20) NOT NULL,
  name varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(50) NOT NULL,
  profile varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE cart (
  id varchar(20) NOT NULL,
  user_id varchar(20) NOT NULL,
  product_id varchar(20) NOT NULL,
  price int(100) NOT NULL,
  qty int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE message (
  id varchar(20) NOT NULL,
  user_id varchar(20) NOT NULL,
  name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  subject varchar(200) NOT NULL,
  message varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE orders (
  id varchar(20) NOT NULL,
  user_id varchar(20) NOT NULL,
  name varchar(100) NOT NULL,
  number int(20) NOT NULL,
  email varchar(100) NOT NULL,
  address varchar(255) NOT NULL,
  address_type varchar(10) NOT NULL,
  method varchar(50) NOT NULL,
  product_id varchar(20) NOT NULL,
  price int(10) NOT NULL,
  qty varchar(2) NOT NULL,
  date date NOT NULL DEFAULT current_timestamp(),
  status varchar(100) NOT NULL,
  payment_status varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE products (
  id varchar(20) NOT NULL,
  name varchar(20) NOT NULL,
  price int(50) NOT NULL,
  image varchar(255) NOT NULL,
  product_detail varchar(2000) NOT NULL,
  status varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE users (
  id varchar(20) NOT NULL,
  name varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(50) NOT NULL,
  user_type varchar(100) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE wishlist (
  id varchar(20) NOT NULL,
  user_id varchar(20) NOT NULL,
  product_id varchar(20) NOT NULL,
  price int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Thêm khóa ngoại cho các bảng
ALTER TABLE cart ENGINE = InnoDB;
ALTER TABLE users ENGINE = InnoDB;
ALTER TABLE products ENGINE = InnoDB;

ALTER TABLE cart MODIFY COLUMN user_id VARCHAR(20);
ALTER TABLE cart MODIFY COLUMN product_id VARCHAR(20);

CREATE INDEX idx_users_id ON users`(id`);
CREATE INDEX idx_products_id ON products`(id`);


ALTER TABLE cart
  ADD CONSTRAINT fk_cart_user
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE cart
  ADD CONSTRAINT fk_cart_product
  FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE orders
  ADD CONSTRAINT fk_orders_user
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE orders
  ADD CONSTRAINT fk_orders_product
  FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE message
  ADD CONSTRAINT fk_message_user
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE wishlist
  ADD CONSTRAINT fk_wishlist_user
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE wishlist
  ADD CONSTRAINT fk_wishlist_product
  FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE;
