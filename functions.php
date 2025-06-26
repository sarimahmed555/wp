<?php
// Theme setup
function petcare_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'petcare-pro'),
        'footer' => __('Footer Menu', 'petcare-pro'),
    ));
    
    // Image sizes
    add_image_size('sitter-thumbnail', 300, 300, true);
    add_image_size('sitter-large', 600, 400, true);
}
add_action('after_setup_theme', 'petcare_theme_setup');

// Enqueue styles and scripts
function petcare_scripts() {
    wp_enqueue_style('petcare-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('petcare-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('petcare-search-tabs', get_template_directory_uri() . '/js/search-tabs.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('petcare-aos', get_template_directory_uri() . '/js/aos.js', array(), '2.3.4', true);
    wp_enqueue_script('petcare-faq-accordion', get_template_directory_uri() . '/js/faq-accordion.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'petcare_scripts');

// Include email settings and mailer
require_once get_template_directory() . '/inc/email-settings.php';
require_once get_template_directory() . '/inc/mailer.php';

// Handle form submission and send email
function petcare_handle_form_submission() {
    // Check if the form was submitted
    if (isset($_POST['form_submitted']) && $_POST['form_submitted'] == 1) {
        try {
            // Enable error logging
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            
            // Log form submission
            error_log('Pet service form submitted');
            
            // Get recipient email from settings or use admin email as fallback
            $recipient_email = get_option('petcare_recipient_email', get_option('admin_email'));
            
            // Prepare email subject
            $subject = 'New Pet Service Request from ' . get_bloginfo('name');
            
            // Collect form data
            $pet_type = isset($_POST['search_pet_type']) ? sanitize_text_field($_POST['search_pet_type']) : 'Not specified';
            $service = '';
            
            // Determine which service was selected
            if (isset($_POST['service_tab'])) {
                $service = sanitize_text_field($_POST['service_tab']);
            }
            
            $location = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : 'Not specified';
            $drop_off = isset($_POST['drop_off']) ? sanitize_text_field($_POST['drop_off']) : 'Not specified';
            $pick_up = isset($_POST['pick_up']) ? sanitize_text_field($_POST['pick_up']) : 'Not specified';
            $street_address = isset($_POST['street_address']) ? sanitize_text_field($_POST['street_address']) : 'Not specified';
            $zip_code = isset($_POST['zip_code']) ? sanitize_text_field($_POST['zip_code']) : 'Not specified';
            $dog_size = isset($_POST['dog_size']) ? sanitize_text_field($_POST['dog_size']) : 'Not specified';
            
            // Prepare email message
            $message = "A new pet service request has been submitted:\n\n";
            $message .= "Pet Type: " . $pet_type . "\n";
            $message .= "Service: " . $service . "\n";
            $message .= "Location: " . $location . "\n";
            $message .= "Drop-off Date: " . $drop_off . "\n";
            $message .= "Pick-up Date: " . $pick_up . "\n";
            $message .= "Street Address: " . $street_address . "\n";
            $message .= "Zip Code: " . $zip_code . "\n";
            $message .= "Dog Size: " . $dog_size . "\n\n";
            $message .= "This email was sent from the pet service form on your website.";
            
            // Log the message
            error_log('Email message prepared: ' . $message);
            
            // Handle file uploads
            $attachments = array();
            $upload_dir = wp_upload_dir();
            $pet_photos_dir = $upload_dir['basedir'] . '/pet-photos';
            
            // Create directory if it doesn't exist
            if (!file_exists($pet_photos_dir)) {
                wp_mkdir_p($pet_photos_dir);
                error_log('Created pet photos directory: ' . $pet_photos_dir);
            }
            
            // Process each uploaded file
            for ($i = 1; $i <= 3; $i++) {
                $file_key = 'pet_photo_' . $i;
                
                if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES[$file_key]['tmp_name'];
                    $name = sanitize_file_name($_FILES[$file_key]['name']);
                    $type = $_FILES[$file_key]['type'];
                    
                    error_log('Processing file: ' . $name . ' (Type: ' . $type . ')');
                    
                    // Only process image files
                    if (strpos($type, 'image/') === 0) {
                        $destination = $pet_photos_dir . '/' . time() . '_' . $name;
                        
                        // Move the uploaded file
                        if (move_uploaded_file($tmp_name, $destination)) {
                            $attachments[] = array(
                                'path' => $destination,
                                'name' => $name,
                                'type' => $type
                            );
                            
                            // Add to email message
                            $message .= "\nPet Photo " . $i . ": " . $name;
                            error_log('File uploaded successfully: ' . $destination);
                        } else {
                            error_log('Failed to move uploaded file from ' . $tmp_name . ' to ' . $destination);
                        }
                    } else {
                        error_log('File is not an image: ' . $type);
                    }
                } else if (isset($_FILES[$file_key])) {
                    error_log('File upload error for ' . $file_key . ': ' . $_FILES[$file_key]['error']);
                }
            }
            
            // Use wp_mail as a fallback if PHPMailer is causing issues
            $headers = array(
                'Content-Type: text/plain; charset=UTF-8',
                'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
                'Reply-To: ' . get_option('admin_email')
            );
            
            // Try to send with PHPMailer first
            $mail_sent = false;
            try {
                error_log('Attempting to send email with PHPMailer');
                $mail_sent = petcare_send_email($recipient_email, $subject, $message, $attachments);
                error_log('PHPMailer result: ' . ($mail_sent ? 'success' : 'failed'));
            } catch (Exception $e) {
                error_log('PHPMailer exception: ' . $e->getMessage());
                // If PHPMailer fails, try wp_mail as fallback
                error_log('Falling back to wp_mail');
                $mail_sent = wp_mail($recipient_email, $subject, $message, $headers);
                error_log('wp_mail result: ' . ($mail_sent ? 'success' : 'failed'));
            }
            
            // Set a session variable to show a success message
            if ($mail_sent) {
                // Store success message in a session or transient
                set_transient('form_submission_success', true, 60);
                error_log('Email sent successfully');
            } else {
                // Store error message
                set_transient('form_submission_error', true, 60);
                error_log('Failed to send email');
            }
            
            // Check if thank-you page exists, if not redirect to home
            $thank_you_page = get_page_by_path('thank-you');
            if ($thank_you_page) {
                error_log('Redirecting to thank-you page');
                wp_redirect(home_url('/thank-you/'));
            } else {
                error_log('Thank-you page not found, redirecting to home');
                wp_redirect(home_url('/?form_status=' . ($mail_sent ? 'success' : 'error')));
            }
            exit;
        } catch (Exception $e) {
            // Log any exceptions
            error_log('Exception in form submission handler: ' . $e->getMessage());
            wp_redirect(home_url('/?form_status=error'));
            exit;
        }
    }
}
add_action('template_redirect', 'petcare_handle_form_submission');

// Register Custom Post Types
function petcare_register_post_types() {
    // Pet Sitters
    register_post_type('pet_sitter', array(
        'labels' => array(
            'name' => 'Pet Sitters',
            'singular_name' => 'Pet Sitter',
            'add_new' => 'Add New Sitter',
            'add_new_item' => 'Add New Pet Sitter',
            'edit_item' => 'Edit Pet Sitter',
            'new_item' => 'New Pet Sitter',
            'view_item' => 'View Pet Sitter',
            'search_items' => 'Search Pet Sitters',
            'not_found' => 'No pet sitters found',
            'not_found_in_trash' => 'No pet sitters found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-pets',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'sitter'),
        'show_in_rest' => true
    ));
    
    // Services
    register_post_type('service', array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new' => 'Add New Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'new_item' => 'New Service',
            'view_item' => 'View Service',
            'search_items' => 'Search Services',
            'not_found' => 'No services found',
            'not_found_in_trash' => 'No services found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'services'),
        'show_in_rest' => true
    ));
    
    // Reviews
    register_post_type('review', array(
        'labels' => array(
            'name' => 'Reviews',
            'singular_name' => 'Review',
            'add_new' => 'Add New Review',
            'add_new_item' => 'Add New Review',
            'edit_item' => 'Edit Review',
            'new_item' => 'New Review',
            'view_item' => 'View Review',
            'search_items' => 'Search Reviews',
            'not_found' => 'No reviews found',
            'not_found_in_trash' => 'No reviews found in trash'
        ),
        'public' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor'),
        'show_in_rest' => true
    ));
}
add_action('init', 'petcare_register_post_types');

// Register taxonomies
function petcare_register_taxonomies() {
    // Service Types
    register_taxonomy('service_type', array('pet_sitter', 'service'), array(
        'labels' => array(
            'name' => 'Service Types',
            'singular_name' => 'Service Type',
            'search_items' => 'Search Service Types',
            'all_items' => 'All Service Types',
            'edit_item' => 'Edit Service Type',
            'update_item' => 'Update Service Type',
            'add_new_item' => 'Add New Service Type',
            'new_item_name' => 'New Service Type Name',
            'menu_name' => 'Service Types'
        ),
        'hierarchical' => true,
        'public' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'service-type')
    ));
    
    // Locations
    register_taxonomy('location', array('pet_sitter'), array(
        'labels' => array(
            'name' => 'Locations',
            'singular_name' => 'Location',
            'search_items' => 'Search Locations',
            'all_items' => 'All Locations',
            'edit_item' => 'Edit Location',
            'update_item' => 'Update Location',
            'add_new_item' => 'Add New Location',
            'new_item_name' => 'New Location Name',
            'menu_name' => 'Locations'
        ),
        'hierarchical' => true,
        'public' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'location')
    ));
}
add_action('init', 'petcare_register_taxonomies');

// Add custom meta boxes
function petcare_add_meta_boxes() {
    add_meta_box(
        'sitter_details',
        'Sitter Details',
        'petcare_sitter_details_callback',
        'pet_sitter',
        'normal',
        'high'
    );
    
    add_meta_box(
        'service_details',
        'Service Details',
        'petcare_service_details_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'petcare_add_meta_boxes');

// Sitter details meta box callback
function petcare_sitter_details_callback($post) {
    wp_nonce_field('petcare_save_sitter_details', 'petcare_sitter_nonce');
    
    $hourly_rate = get_post_meta($post->ID, 'hourly_rate', true);
    $location = get_post_meta($post->ID, 'location', true);
    $experience_years = get_post_meta($post->ID, 'experience_years', true);
    $rating = get_post_meta($post->ID, 'rating', true);
    $reviews_count = get_post_meta($post->ID, 'reviews_count', true);
    $featured = get_post_meta($post->ID, 'featured', true);
    $services = get_post_meta($post->ID, 'services', true) ?: array();
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hourly_rate">Hourly Rate ($)</label></th>
            <td><input type="number" id="hourly_rate" name="hourly_rate" value="<?php echo esc_attr($hourly_rate); ?>" step="0.01" /></td>
        </tr>
        <tr>
            <th><label for="location">Location</label></th>
            <td><input type="text" id="location" name="location" value="<?php echo esc_attr($location); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="experience_years">Experience (Years)</label></th>
            <td><input type="number" id="experience_years" name="experience_years" value="<?php echo esc_attr($experience_years); ?>" /></td>
        </tr>
        <tr>
            <th><label for="rating">Rating (1-5)</label></th>
            <td><input type="number" id="rating" name="rating" value="<?php echo esc_attr($rating); ?>" step="0.1" min="1" max="5" /></td>
        </tr>
        <tr>
            <th><label for="reviews_count">Number of Reviews</label></th>
            <td><input type="number" id="reviews_count" name="reviews_count" value="<?php echo esc_attr($reviews_count); ?>" /></td>
        </tr>
        <tr>
            <th><label for="featured">Featured Sitter</label></th>
            <td><input type="checkbox" id="featured" name="featured" value="1" <?php checked($featured, '1'); ?> /></td>
        </tr>
        <tr>
            <th><label>Services Offered</label></th>
            <td>
                <?php
                $available_services = array('Dog Walking', 'Pet Sitting', 'Pet Boarding', 'Dog Training', 'Pet Grooming');
                foreach ($available_services as $service) :
                ?>
                    <label>
                        <input type="checkbox" name="services[]" value="<?php echo esc_attr($service); ?>" 
                               <?php checked(in_array($service, $services)); ?> />
                        <?php echo esc_html($service); ?>
                    </label><br>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>
    <?php
}

// Service details meta box callback
function petcare_service_details_callback($post) {
    wp_nonce_field('petcare_save_service_details', 'petcare_service_nonce');
    
    $price = get_post_meta($post->ID, 'price', true);
    $duration = get_post_meta($post->ID, 'duration', true);
    $featured = get_post_meta($post->ID, 'featured', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="price">Price ($)</label></th>
            <td><input type="number" id="price" name="price" value="<?php echo esc_attr($price); ?>" step="0.01" /></td>
        </tr>
        <tr>
            <th><label for="duration">Duration (minutes)</label></th>
            <td><input type="number" id="duration" name="duration" value="<?php echo esc_attr($duration); ?>" /></td>
        </tr>
        <tr>
            <th><label for="featured">Featured Service</label></th>
            <td><input type="checkbox" id="featured" name="featured" value="1" <?php checked($featured, '1'); ?> /></td>
        </tr>
    </table>
    <?php
}

// Save meta box data
function petcare_save_meta_boxes($post_id) {
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save sitter details
    if (isset($_POST['petcare_sitter_nonce']) && wp_verify_nonce($_POST['petcare_sitter_nonce'], 'petcare_save_sitter_details')) {
        if (isset($_POST['hourly_rate'])) {
            update_post_meta($post_id, 'hourly_rate', sanitize_text_field($_POST['hourly_rate']));
        }
        if (isset($_POST['location'])) {
            update_post_meta($post_id, 'location', sanitize_text_field($_POST['location']));
        }
        if (isset($_POST['experience_years'])) {
            update_post_meta($post_id, 'experience_years', sanitize_text_field($_POST['experience_years']));
        }
        if (isset($_POST['rating'])) {
            update_post_meta($post_id, 'rating', sanitize_text_field($_POST['rating']));
        }
        if (isset($_POST['reviews_count'])) {
            update_post_meta($post_id, 'reviews_count', sanitize_text_field($_POST['reviews_count']));
        }
        if (isset($_POST['featured'])) {
            update_post_meta($post_id, 'featured', '1');
        } else {
            update_post_meta($post_id, 'featured', '0');
        }
        if (isset($_POST['services'])) {
            update_post_meta($post_id, 'services', array_map('sanitize_text_field', $_POST['services']));
        } else {
            update_post_meta($post_id, 'services', array());
        }
    }
    
    // Save service details
    if (isset($_POST['petcare_service_nonce']) && wp_verify_nonce($_POST['petcare_service_nonce'], 'petcare_save_service_details')) {
        if (isset($_POST['price'])) {
            update_post_meta($post_id, 'price', sanitize_text_field($_POST['price']));
        }
        if (isset($_POST['duration'])) {
            update_post_meta($post_id, 'duration', sanitize_text_field($_POST['duration']));
        }
        if (isset($_POST['featured'])) {
            update_post_meta($post_id, 'featured', '1');
        } else {
            update_post_meta($post_id, 'featured', '0');
        }
    }
}
add_action('save_post', 'petcare_save_meta_boxes');

// Custom search functionality
function petcare_search_redirect() {
    if (isset($_GET['location']) || isset($_GET['service_type'])) {
        wp_redirect(home_url('/search/?' . http_build_query($_GET)));
        exit;
    }
}
// add_action('template_redirect', 'petcare_search_redirect'); // Temporarily commented out

/**
 * Programmatically create 'Coming Soon', 'Help Center', and 'FAQ' pages on theme activation.
 */
function petcare_create_special_pages() {
    $parent_page_ids = array(); // To store IDs of top-level pages

    // Define top-level pages first
    $top_level_pages = array(
        'coming-soon' => array(
            'title' => 'Coming Soon',
            'content' => 'We are working hard to bring you this content. Please check back later!',
            'template' => 'coming-soon.php',
        ),
        'help-center' => array(
            'title' => 'Help Center',
            'content' => 'Welcome to the Velvet Leash Co. Help Center. Here you\'ll find answers to common questions and resources to assist you.',
            'template' => 'page-help-center.php',
        ),
        'faq' => array(
            'title' => 'Frequently Asked Questions',
            'content' => 'Find answers to your common questions here.',
            'template' => 'page-faq.php',
        ),
    );

    foreach ( $top_level_pages as $slug => $page_data ) {
        $existing_page = get_page_by_title( $page_data['title'] );
        $page_id = 0;

        if ( ! $existing_page ) {
            $new_page_args = array(
                'post_title'    => $page_data['title'],
                'post_content'  => $page_data['content'],
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $slug,
            );
            $page_id = wp_insert_post( $new_page_args );
        } else {
            $page_id = $existing_page->ID;
        }

        if ( $page_id && ! is_wp_error( $page_id ) ) {
            // Assign custom template if specified
            if ( ! empty( $page_data['template'] ) ) {
                update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
            }
            $parent_page_ids[$slug] = $page_id; // Store ID for children
        }
    }

    // Define child pages
    $child_pages = array(
        'hc-booking-payments' => array(
            'title' => 'Booking & Payments',
            'content' => 'This page provides detailed information on how to book services, understand pricing, and manage your payments securely through Velvet Leash Co. Learn about different payment methods, refunds, and how to view your booking history.',
            'template' => 'page-help-center-sub.php',
            'parent_slug' => 'help-center',
        ),
        'hc-pet-safety' => array(
            'title' => 'Pet Safety & Guarantee',
            'content' => 'Your pet\'s safety is our top priority. Here you will find information about our sitter screening process, safety guidelines, and what to do in case of an emergency. Learn more about the Velvet Leash Co. Guarantee and how it protects you and your pet.',
            'template' => 'page-help-center-sub.php',
            'parent_slug' => 'help-center',
        ),
        'hc-for-sitters' => array(
            'title' => 'For Sitters',
            'content' => 'Are you a pet sitter looking to join our community or need help with your existing services? This section offers resources on setting up your profile, managing bookings, communicating with pet parents, and understanding sitter earnings.',
            'template' => 'page-help-center-sub.php',
            'parent_slug' => 'help-center',
        ),
        'hc-account-management' => array(
            'title' => 'Account Management',
            'content' => 'Find answers to questions about creating and managing your Velvet Leash Co. account. This includes updating your personal information, password resets, privacy settings, and managing notifications.',
            'template' => 'page-help-center-sub.php',
            'parent_slug' => 'help-center',
        ),
    );

    foreach ( $child_pages as $slug => $page_data ) {
        $existing_page = get_page_by_title( $page_data['title'] );
        $page_id = 0;
        $parent_id = 0;

        if ( isset( $page_data['parent_slug'] ) && isset( $parent_page_ids[$page_data['parent_slug']] ) ) {
            $parent_id = $parent_page_ids[$page_data['parent_slug']];
        }

        if ( ! $existing_page ) {
            $new_page_args = array(
                'post_title'    => $page_data['title'],
                'post_content'  => $page_data['content'],
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $slug,
                'post_parent'   => $parent_id, // Set parent directly here
            );
            $page_id = wp_insert_post( $new_page_args );
        } else {
            $page_id = $existing_page->ID;
            // If page exists but parent is wrong, update it
            if ( $parent_id && $existing_page->post_parent != $parent_id ) {
                wp_update_post(array(
                    'ID' => $page_id,
                    'post_parent' => $parent_id
                ));
            }
        }

        if ( $page_id && ! is_wp_error( $page_id ) ) {
            if ( ! empty( $page_data['template'] ) ) {
                update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
            }
        }
    }

    flush_rewrite_rules();
}

// Remove old action and add new one
remove_action( 'after_switch_theme', 'petcare_create_coming_soon_page' );
add_action( 'after_switch_theme', 'petcare_create_special_pages' );

?>
