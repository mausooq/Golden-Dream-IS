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

-- Insert values into collections
INSERT INTO collections (collection_name, collection_image_url, sort_order) VALUES 
    ('Gold Necklaces', 'http://example.com/images/necklaces.jpg', 1),
    ('Gold Rings', 'http://example.com/images/rings.jpg', 2),
    ('Gold Earrings', 'http://example.com/images/earrings.jpg', 3),
    ('Gold Bracelets', 'http://example.com/images/bracelets.jpg', 4),
    ('Gold Coins', 'http://example.com/images/coins.jpg', 5);

-- Insert values into social_media_links
INSERT INTO social_media_links (platform_name, link_url, sort_order) VALUES 
    ('Facebook', 'http://facebook.com/goldstore', 1),
    ('Instagram', 'http://instagram.com/goldstore', 2),
    ('Twitter', 'http://twitter.com/goldstore', 3),
    ('Pinterest', 'http://pinterest.com/goldstore', 4),
    ('LinkedIn', 'http://linkedin.com/company/goldstore', 5);

-- Insert values into popups
INSERT INTO popups (popup_image_url, title, link_url) VALUES 
    ('http://example.com/images/popup1.jpg', 'Summer Sale! 20% Off All Gold Items', 'http://example.com/sale'),
    ('http://example.com/images/popup2.jpg', 'New Arrivals! Check Our Latest Collection', 'http://example.com/new-arrivals'),
    ('http://example.com/images/popup3.jpg', 'Join Our Loyalty Program', 'http://example.com/loyalty'),
    ('http://example.com/images/popup4.jpg', 'Free Shipping on Orders Over $100', 'http://example.com/free-shipping'),
    ('http://example.com/images/popup5.jpg', 'Refer a Friend and Get 10% Off', 'http://example.com/refer-a-friend');

-- Insert values into faqs
INSERT INTO faqs (question, answer, sort_order) VALUES 
    ('What is the return policy?', 'Our return policy allows for returns within 30 days of purchase.', 1),
    ('Do you offer international shipping?', 'Yes, we offer international shipping to selected countries.', 2),
    ('How can I track my order?', 'You can track your order using the tracking link sent to your email after shipping.', 3),
    ('What payment methods do you accept?', 'We accept credit cards, PayPal, and bank transfers.', 4),
    ('Do you provide gift wrapping services?', 'Yes, we offer gift wrapping services for an additional charge.', 5);

-- Insert values into subscribers
INSERT INTO subscribers (email, status) VALUES 
    ('john.doe@example.com', 'active'),
    ('jane.smith@example.com', 'active'),
    ('emily.johnson@example.com', 'inactive'),
    ('michael.brown@example.com', 'active'),
    ('sarah.davis@example.com', 'inactive');

-- Insert values into trending_collections
INSERT INTO trending_collections (collection_name, collection_image_url, sort_order) VALUES 
    ('Elegant Gold Necklaces', 'http://example.com/images/necklaces.jpg', 1),
    ('Classic Gold Rings', 'http://example.com/images/rings.jpg', 2),
    ('Designer Gold Earrings', 'http://example.com/images/earrings.jpg', 3),
    ('Luxurious Gold Bracelets', 'http://example.com/images/bracelets.jpg', 4),
    ('Exclusive Gold Coins', 'http://example.com/images/coins.jpg', 5);

-- Insert values into collection_items
INSERT INTO collection_items (collection_id, item_name, item_image_url, item_description, original_price, selling_price, sort_order) VALUES 
    (1, '18K Gold Chain Necklace', 'http://example.com/images/item1.jpg', 'A stunning 18K gold chain necklace that adds elegance to any outfit.', 1500.00, 1200.00, 1),
    (1, 'Gold Pendant with Diamonds', 'http://example.com/images/item2.jpg', 'An exquisite gold pendant adorned with diamonds for a luxurious look.', 2500.00, 2000.00, 2),
    (2, 'Classic Solitaire Gold Ring', 'http://example.com/images/item3.jpg', 'A classic solitaire gold ring, perfect for engagements or special occasions.', 2000.00, 1800.00, 1),
    (2, 'Gold Wedding Band', 'http://example.com/images/item4.jpg', 'A timeless gold wedding band that symbolizes love and commitment.', 1200.00, 1000.00, 2),
    (3, 'Designer Hoop Earrings', 'http://example.com/images/item5.jpg', 'Stylish designer hoop earrings that make a statement.', 800.00, 650.00, 1);

-- Insert values into testimonials
INSERT INTO testimonials (customer_name, feedback, rating, customer_image_url, sort_order) VALUES 
    ('Alice Johnson', 'The gold necklace I purchased is absolutely stunning! Highly recommend!', 5, 'http://example.com/images/customer1.jpg', 1),
    ('Bob Smith', 'Great service and beautiful jewelry. I will definitely shop here again!', 4, 'http://example.com/images/customer2.jpg', 2),
    ('Catherine Lee', 'The quality of the gold items is exceptional. Very happy with my purchase!', 5, 'http://example.com/images/customer3.jpg', 3),
    ('David Brown', 'I received my order on time, and the earrings were exactly what I wanted!', 4, 'http://example.com/images/customer4.jpg', 4),
    ('Emma Wilson', 'Excellent customer support and a wide selection of beautiful gold pieces!', 5, 'http://example.com/images/customer5.jpg', 5);