

-- ************scrap_items table query***************

-- CREATE TABLE scrap_items (
--     id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each item
--     item_description VARCHAR(255) NOT NULL,  -- Description of the scrap item
--     qty INT NOT NULL,  -- Quantity of the item
--     remark TEXT,  -- Additional remarks about the item
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Timestamp when the record was created
-- );



-- ***********user account create*****************

-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     username VARCHAR(50) NOT NULL,
--     email VARCHAR(100) NOT NULL UNIQUE,
--     password VARCHAR(255) NOT NULL,
--     reset_token VARCHAR(255) DEFAULT NULL,
--     token_expiry DATETIME DEFAULT NULL
-- );

-- ************received_items table****************

-- CREATE TABLE IF NOT EXISTS received_items (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     consumable_list VARCHAR(50) NOT NULL,
--     item_description VARCHAR(100) NOT NULL,
--     quantity INT NOT NULL,
--     transfer_date DATE NOT NULL,
--     total_price DECIMAL(10, 2) NOT NULL,
--     branch VARCHAR(50) NOT NULL,
--     dsr_no VARCHAR(100),
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );


-- ***************transfer_items table*************

-- CREATE TABLE IF NOT EXISTS transfers (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     consumable_list VARCHAR(50) NOT NULL,
--     item_description VARCHAR(100) NOT NULL,
--     quantity INT NOT NULL,
--     transfer_date DATE NOT NULL,
--     total_price DECIMAL(10, 2) NOT NULL,
--     branch VARCHAR(50) NOT NULL,
--     dsr_no VARCHAR(100),
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

-- ***************requests table**************

-- CREATE TABLE requests (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     item VARCHAR(255) NOT NULL,
--     priority VARCHAR(50) NOT NULL,
--     delivery_type VARCHAR(50) NOT NULL,
--     from_branch VARCHAR(255),
--     to_branch VARCHAR(255),
--     other_item TEXT,
--     branch VARCHAR(255),
--     status VARCHAR(50) DEFAULT 'pending'
-- );