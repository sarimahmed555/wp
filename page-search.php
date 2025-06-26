<?php
/*
Template Name: Search Results
*/
get_header(); ?>

<main class="main-content">
    <!-- Search Form Section -->
    <section style="background: var(--light-gray); padding-top: 0; padding-bottom: 0; position: sticky; top: 62px; z-index: 1001;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h1 style="text-align: center; color: var(--primary-purple); margin-bottom: 1rem; font-size: 2rem;">Search Results</h1>
            
            <form class="search-form" action="" method="GET" style="max-width: 800px;">
                <div class="search-row">
                    <div class="search-field">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="Enter your city or zip code" value="<?php echo isset($_GET['location']) ? esc_attr($_GET['location']) : ''; ?>">
                    </div>
                    <div class="search-field">
                        <label for="service_type">Service Type</label>
                        <select id="service_type" name="service_type">
                            <option value="">All Services</option>
                            <option value="dog-walking" <?php selected(isset($_GET['service_type']) ? $_GET['service_type'] : '', 'dog-walking'); ?>>Dog Walking</option>
                            <option value="pet-sitting" <?php selected(isset($_GET['service_type']) ? $_GET['service_type'] : '', 'pet-sitting'); ?>>Pet Sitting</option>
                            <option value="pet-boarding" <?php selected(isset($_GET['service_type']) ? $_GET['service_type'] : '', 'pet-boarding'); ?>>Pet Boarding</option>
                            <option value="dog-training" <?php selected(isset($_GET['service_type']) ? $_GET['service_type'] : '', 'dog-training'); ?>>Dog Training</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <section>
        <div class="services-grid">
            <?php
            // Build query args based on search parameters
            $args = array(
                'post_type' => 'pet_sitter',
                'posts_per_page' => 12,
                'post_status' => 'publish'
            );

            // Add meta query for filters
            $meta_query = array();

            if (isset($_GET['location']) && !empty($_GET['location'])) {
                $meta_query[] = array(
                    'key' => 'location',
                    'value' => sanitize_text_field($_GET['location']),
                    'compare' => 'LIKE'
                );
            }

            if (isset($_GET['min_rating']) && !empty($_GET['min_rating'])) {
                $meta_query[] = array(
                    'key' => 'rating',
                    'value' => floatval($_GET['min_rating']),
                    'compare' => '>='
                );
            }

            if (isset($_GET['max_rate']) && !empty($_GET['max_rate'])) {
                $meta_query[] = array(
                    'key' => 'hourly_rate',
                    'value' => floatval($_GET['max_rate']),
                    'compare' => '<='
                );
            }

            if (!empty($meta_query)) {
                $args['meta_query'] = $meta_query;
            }

            // Add taxonomy query for service types
            if (isset($_GET['service_type']) && !empty($_GET['service_type'])) {
                $args['meta_query'][] = array(
                    'key' => 'services',
                    'value' => sanitize_text_field($_GET['service_type']),
                    'compare' => 'LIKE'
                );
            }

            $search_query = new WP_Query($args);

            if ($search_query->have_posts()) :
                while ($search_query->have_posts()) : $search_query->the_post();
                    $sitter_id = get_the_ID();
                    $rating = get_post_meta($sitter_id, 'rating', true) ?: '5.0';
                    $reviews_count = get_post_meta($sitter_id, 'reviews_count', true) ?: '0';
                    $hourly_rate = get_post_meta($sitter_id, 'hourly_rate', true) ?: '25';
                    $location = get_post_meta($sitter_id, 'location', true) ?: 'Location not specified';
                    $services = get_post_meta($sitter_id, 'services', true) ?: array();
                    ?>
                    <div class="service-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title(); ?>" class="service-image">
                        <?php else : ?>
                            <img src="https://via.placeholder.com/300x200/6B46C1/FFFFFF?text=<?php echo substr(get_the_title(), 0, 1); ?>" alt="<?php the_title(); ?>" class="service-image">
                        <?php endif; ?>
                        
                        <div class="service-content">
                            <h3 class="service-title"><?php the_title(); ?></h3>
                            <p style="color: var(--dark-gray); margin-bottom: 0.5rem;">📍 <?php echo esc_html($location); ?></p>
                            <div class="service-meta">
                                <div class="service-rating">
                                    <span>⭐ <?php echo $rating; ?></span>
                                    <span>(<?php echo $reviews_count; ?> reviews)</span>
                                </div>
                                <div class="service-price">$<?php echo $hourly_rate; ?>/hr</div>
                            </div>
                            <p class="service-description"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                            <div class="service-tags">
                                <?php if (is_array($services) && !empty($services)) : ?>
                                    <?php foreach (array_slice($services, 0, 3) as $service) : ?>
                                        <span class="service-tag"><?php echo esc_html($service); ?></span>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <span class="service-tag">Pet Care</span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="book-button">View Profile</a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <h3 style="color: var(--primary-purple); margin-bottom: 1rem;">No pet sitters found</h3>
                    <p style="color: var(--dark-gray);">Try adjusting your search criteria or browse all available sitters.</p>
                    <a href="<?php echo home_url('/sitter/'); ?>" class="book-button" style="display: inline-block; margin-top: 1rem;">Browse All Sitters</a>
                </div>
                <?php
            endif;
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
