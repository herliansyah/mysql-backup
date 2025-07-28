-- Sample Database for Testing MySQL Backup Tool
-- This file creates a sample database with various objects for testing

CREATE DATABASE IF NOT EXISTS `sample_backup_db`;
USE `sample_backup_db`;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Sample Data
-- --------------------------------------------------------

-- Insert sample users
INSERT INTO `users` (`username`, `email`, `password`, `first_name`, `last_name`) VALUES
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User'),
('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe'),
('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Smith'),
('bob_wilson', 'bob@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bob', 'Wilson'),
('alice_brown', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alice', 'Brown');

-- Insert sample categories
INSERT INTO `categories` (`name`, `description`) VALUES
('Electronics', 'Electronic devices and gadgets'),
('Clothing', 'Apparel and fashion items'),
('Books', 'Books and educational materials'),
('Home & Garden', 'Home improvement and garden supplies'),
('Sports', 'Sports equipment and accessories');

INSERT INTO `categories` (`name`, `description`, `parent_id`) VALUES
('Smartphones', 'Mobile phones and accessories', 1),
('Laptops', 'Portable computers', 1),
('Men Clothing', 'Clothing for men', 2),
('Women Clothing', 'Clothing for women', 2);

-- Insert sample products
INSERT INTO `products` (`name`, `description`, `price`, `category_id`, `stock_quantity`, `created_by`) VALUES
('iPhone 14 Pro', 'Latest Apple smartphone with advanced features', 999.99, 6, 50, 1),
('Samsung Galaxy S23', 'High-end Android smartphone', 899.99, 6, 30, 1),
('MacBook Pro 16"', 'Professional laptop for developers and creators', 2499.99, 7, 15, 1),
('Dell XPS 13', 'Ultrabook with excellent performance', 1299.99, 7, 25, 1),
('Men\'s T-Shirt', 'Comfortable cotton t-shirt', 29.99, 8, 100, 2),
('Women\'s Dress', 'Elegant evening dress', 89.99, 9, 40, 2),
('Programming Book', 'Learn advanced programming concepts', 49.99, 3, 75, 1),
('Garden Tools Set', 'Complete set of gardening tools', 129.99, 4, 20, 2),
('Tennis Racket', 'Professional tennis racket', 199.99, 5, 35, 2),
('Running Shoes', 'Comfortable running shoes', 119.99, 5, 60, 1);

-- Insert sample orders
INSERT INTO `orders` (`user_id`, `total_amount`, `status`, `shipping_address`) VALUES
(2, 1029.98, 'delivered', '123 Main St, City, State 12345'),
(3, 159.98, 'shipped', '456 Oak Ave, Town, State 67890'),
(4, 2499.99, 'processing', '789 Pine Rd, Village, State 54321'),
(5, 249.97, 'pending', '321 Elm St, Borough, State 98765');

-- Insert sample order items
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 999.99),
(1, 5, 1, 29.99),
(2, 6, 1, 89.99),
(2, 7, 1, 49.99),
(2, 10, 1, 119.99),
(3, 3, 1, 2499.99),
(4, 8, 1, 129.99),
(4, 9, 1, 199.99);

-- --------------------------------------------------------
-- Views
-- --------------------------------------------------------

-- View for user orders summary
DROP VIEW IF EXISTS `user_orders_summary`;
CREATE VIEW `user_orders_summary` AS
SELECT 
    u.id as user_id,
    u.username,
    u.email,
    COUNT(o.id) as total_orders,
    COALESCE(SUM(o.total_amount), 0) as total_spent,
    MAX(o.order_date) as last_order_date
FROM users u
LEFT JOIN orders o ON u.id = o.user_id
GROUP BY u.id, u.username, u.email;

-- View for product sales summary
DROP VIEW IF EXISTS `product_sales_summary`;
CREATE VIEW `product_sales_summary` AS
SELECT 
    p.id as product_id,
    p.name as product_name,
    c.name as category_name,
    COALESCE(SUM(oi.quantity), 0) as total_sold,
    COALESCE(SUM(oi.quantity * oi.price), 0) as total_revenue,
    p.stock_quantity
FROM products p
LEFT JOIN categories c ON p.category_id = c.id
LEFT JOIN order_items oi ON p.id = oi.product_id
GROUP BY p.id, p.name, c.name, p.stock_quantity;

-- --------------------------------------------------------
-- Stored Procedures
-- --------------------------------------------------------

DELIMITER //

-- Procedure to get user statistics
DROP PROCEDURE IF EXISTS `GetUserStatistics`//
CREATE PROCEDURE `GetUserStatistics`(IN user_id INT)
BEGIN
    SELECT 
        u.username,
        u.email,
        COUNT(o.id) as total_orders,
        COALESCE(SUM(o.total_amount), 0) as total_spent,
        AVG(o.total_amount) as avg_order_value
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    WHERE u.id = user_id
    GROUP BY u.id, u.username, u.email;
END//

-- Procedure to update product stock
DROP PROCEDURE IF EXISTS `UpdateProductStock`//
CREATE PROCEDURE `UpdateProductStock`(
    IN product_id INT, 
    IN quantity_change INT,
    OUT new_stock INT
)
BEGIN
    DECLARE current_stock INT DEFAULT 0;
    
    SELECT stock_quantity INTO current_stock 
    FROM products 
    WHERE id = product_id;
    
    SET new_stock = current_stock + quantity_change;
    
    UPDATE products 
    SET stock_quantity = new_stock 
    WHERE id = product_id;
END//

DELIMITER ;

-- --------------------------------------------------------
-- Functions
-- --------------------------------------------------------

DELIMITER //

-- Function to calculate order total
DROP FUNCTION IF EXISTS `CalculateOrderTotal`//
CREATE FUNCTION `CalculateOrderTotal`(order_id INT) 
RETURNS DECIMAL(10,2)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE total DECIMAL(10,2) DEFAULT 0;
    
    SELECT SUM(quantity * price) INTO total
    FROM order_items
    WHERE order_items.order_id = order_id;
    
    RETURN COALESCE(total, 0);
END//

-- Function to get category product count
DROP FUNCTION IF EXISTS `GetCategoryProductCount`//
CREATE FUNCTION `GetCategoryProductCount`(category_id INT) 
RETURNS INT
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE product_count INT DEFAULT 0;
    
    SELECT COUNT(*) INTO product_count
    FROM products
    WHERE products.category_id = category_id;
    
    RETURN product_count;
END//

DELIMITER ;

-- --------------------------------------------------------
-- Triggers
-- --------------------------------------------------------

-- Trigger to update order total when order items change
DROP TRIGGER IF EXISTS `update_order_total_after_insert`;
DELIMITER //
CREATE TRIGGER `update_order_total_after_insert`
AFTER INSERT ON `order_items`
FOR EACH ROW
BEGIN
    UPDATE orders 
    SET total_amount = CalculateOrderTotal(NEW.order_id)
    WHERE id = NEW.order_id;
END//
DELIMITER ;

-- Trigger to update order total when order items are updated
DROP TRIGGER IF EXISTS `update_order_total_after_update`;
DELIMITER //
CREATE TRIGGER `update_order_total_after_update`
AFTER UPDATE ON `order_items`
FOR EACH ROW
BEGIN
    UPDATE orders 
    SET total_amount = CalculateOrderTotal(NEW.order_id)
    WHERE id = NEW.order_id;
END//
DELIMITER ;

-- Trigger to update order total when order items are deleted
DROP TRIGGER IF EXISTS `update_order_total_after_delete`;
DELIMITER //
CREATE TRIGGER `update_order_total_after_delete`
AFTER DELETE ON `order_items`
FOR EACH ROW
BEGIN
    UPDATE orders 
    SET total_amount = CalculateOrderTotal(OLD.order_id)
    WHERE id = OLD.order_id;
END//
DELIMITER ;

-- Trigger to log product stock changes
DROP TABLE IF EXISTS `stock_log`;
CREATE TABLE `stock_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `old_stock` int(11) NOT NULL,
  `new_stock` int(11) NOT NULL,
  `change_type` varchar(20) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_log_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TRIGGER IF EXISTS `log_stock_changes`;
DELIMITER //
CREATE TRIGGER `log_stock_changes`
AFTER UPDATE ON `products`
FOR EACH ROW
BEGIN
    IF OLD.stock_quantity != NEW.stock_quantity THEN
        INSERT INTO stock_log (product_id, old_stock, new_stock, change_type)
        VALUES (NEW.id, OLD.stock_quantity, NEW.stock_quantity, 'UPDATE');
    END IF;
END//
DELIMITER ;

-- --------------------------------------------------------
-- Indexes for better performance
-- --------------------------------------------------------

CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_products_name ON products(name);
CREATE INDEX idx_orders_date ON orders(order_date);
CREATE INDEX idx_orders_status ON orders(status);

-- --------------------------------------------------------
-- Final message
-- --------------------------------------------------------

SELECT 'Sample database created successfully!' as message;