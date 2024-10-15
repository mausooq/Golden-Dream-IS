-- Table to store trending collections
CREATE TABLE trending_collections (
    collection_id INT AUTO_INCREMENT PRIMARY KEY,
    collection_name VARCHAR(255) NOT NULL,
    collection_image_url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store general collections
CREATE TABLE collections (
    collection_id INT AUTO_INCREMENT PRIMARY KEY,
    collection_name VARCHAR(255) NOT NULL,
    collection_image_url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store items within collections
CREATE TABLE collection_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    collection_id INT NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    item_image_url VARCHAR(255) NOT NULL,
    item_description TEXT,
    original_price DECIMAL(10, 2) NOT NULL,
    selling_price DECIMAL(10, 2) NOT NULL,
    sort_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (collection_id) REFERENCES collections(collection_id)
);

-- Table to store customer testimonials
CREATE TABLE testimonials (
    testimonial_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    feedback TEXT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    customer_image_url VARCHAR(255),
    sort_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store social media links
CREATE TABLE social_media_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform_name VARCHAR(50) NOT NULL,
    link_url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store pop-up details
CREATE TABLE popups (
    popup_id INT AUTO_INCREMENT PRIMARY KEY,
    popup_image_url VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    link_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store FAQs
CREATE TABLE faqs (
    faq_id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Table to store subscriber information
CREATE TABLE subscribers (
    subscriber_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- admin users table:

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
