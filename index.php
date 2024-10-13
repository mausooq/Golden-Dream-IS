<?php
require 'config.php';

function fetchCollections($pdo) {
    $stmt = $pdo->query("SELECT * FROM collections");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchCollectionItems($pdo) {
    $stmt = $pdo->query("SELECT * FROM collection_items");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchTestimonials($pdo) {
    $stmt = $pdo->query("SELECT * FROM testimonials");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchSocialMediaLinks($pdo) {
    $stmt = $pdo->query("SELECT * FROM social_media_links");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchPopups($pdo) {
    $stmt = $pdo->query("SELECT * FROM popups");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchFAQs($pdo) {
    $stmt = $pdo->query("SELECT * FROM faqs");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchSubscribers($pdo) {
    $stmt = $pdo->query("SELECT * FROM subscribers");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchTrendingCollections($pdo) {
    $stmt = $pdo->query("SELECT * FROM trending_collections");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$pdo = connectToDatabase();

$collections = fetchCollections($pdo);
$collectionItems = fetchCollectionItems($pdo);
$testimonials = fetchTestimonials($pdo);
$socialMediaLinks = fetchSocialMediaLinks($pdo);
$popups = fetchPopups($pdo);
$faqs = fetchFAQs($pdo);
$subscribers = fetchSubscribers($pdo);
$trendingCollections = fetchTrendingCollections($pdo);

echo "<div style='font-family: Arial, sans-serif; line-height: 1.6;'>";

// Print Collections
echo "<strong>Collections:</strong><br/>";
foreach ($collections as $collection) {
    echo "ID: {$collection['collection_id']}, Name: {$collection['collection_name']}, Image URL: {$collection['collection_image_url']}, Sort Order: {$collection['sort_order']}, Created At: {$collection['created_at']}<br/>";
}

// Print Collection Items
echo "<br/><strong>Collection Items:</strong><br/>";
foreach ($collectionItems as $item) {
    echo "ID: {$item['item_id']}, Collection ID: {$item['collection_id']}, Name: {$item['item_name']}, Image URL: {$item['item_image_url']}, Description: {$item['item_description']}, Original Price: {$item['original_price']}, Selling Price: {$item['selling_price']}, Sort Order: {$item['sort_order']}, Created At: {$item['created_at']}<br/>";
}

// Print Testimonials
echo "<br/><strong>Testimonials:</strong><br/>";
foreach ($testimonials as $testimonial) {
    echo "ID: {$testimonial['testimonial_id']}, Name: {$testimonial['customer_name']}, Feedback: {$testimonial['feedback']}, Rating: {$testimonial['rating']}, Image URL: {$testimonial['customer_image_url']}, Sort Order: {$testimonial['sort_order']}, Created At: {$testimonial['created_at']}<br/>";
}

// Print Social Media Links
echo "<br/><strong>Social Media Links:</strong><br/>";
foreach ($socialMediaLinks as $link) {
    echo "ID: {$link['id']}, Platform: {$link['platform_name']}, Link: {$link['link_url']}, Sort Order: {$link['sort_order']}, Created At: {$link['created_at']}<br/>";
}

// Print Popups
echo "<br/><strong>Popups:</strong><br/>";
foreach ($popups as $popup) {
    echo "ID: {$popup['popup_id']}, Image URL: {$popup['popup_image_url']}, Title: {$popup['title']}, Link: {$popup['link_url']}, Created At: {$popup['created_at']}<br/>";
}

// Print FAQs
echo "<br/><strong>FAQs:</strong><br/>";
foreach ($faqs as $faq) {
    echo "ID: {$faq['faq_id']}, Question: {$faq['question']}, Answer: {$faq['answer']}, Sort Order: {$faq['sort_order']}, Created At: {$faq['created_at']}<br/>";
}

// Print Subscribers
echo "<br/><strong>Subscribers:</strong><br/>";
foreach ($subscribers as $subscriber) {
    echo "ID: {$subscriber['subscriber_id']}, Email: {$subscriber['email']}, Subscribed At: {$subscriber['subscribed_at']}, Status: {$subscriber['status']}<br/>";
}

// Print Trending Collections
echo "<br/><strong>Trending Collections:</strong><br/>";
foreach ($trendingCollections as $trending) {
    echo "ID: {$trending['collection_id']}, Name: {$trending['collection_name']}, Image URL: {$trending['collection_image_url']}, Sort Order: {$trending['sort_order']}, Created At: {$trending['created_at']}<br/>";
}

echo "</div>";
?>
