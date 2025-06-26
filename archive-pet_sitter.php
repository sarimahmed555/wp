
<?php get_header(); ?>

<main class="main-content">
    <!-- Search Form Section -->
    <section style="background: var(--light-gray); padding: 2rem;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h1 style="text-align: center; color: var(--primary-purple); margin-bottom: 2rem;">Find Pet Sitters</h1>
            
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
                <div class="search-row">
                    <div class="search-field">
                        <label for="min_rating">Minimum Rating</label>
                        <select id="min_rating" name="min_rating">
                            <option value="">Any Rating</option>
                            <option value="4" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '4'); ?>>4+ Stars</option>
                            <option value="4.5" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '4.5'); ?>>4.5+ Stars</option>
                            <option value="5" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '5'); ?>>5 Stars</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="max_rate">Max Hourly Rate ($)</label>
                        <input type="number" id="max_rate" name="max_rate" placeholder="50" value="<?php echo isset($_GET['max_rate']) ? esc_attr($_GET['max_rate']) : ''; ?>">
                    </div>
                </div>
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <section>
        <div class="services-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php
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
                <?php endwhile; ?>
            <?php else : ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <h3 style="color: var(--primary-purple); margin-bottom: 1rem;">No pet sitters found</h3>
                    <p style="color: var(--dark-gray);">Try adjusting your search criteria or browse all available sitters.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (have_posts()) : ?>
            <div style="text-align: center; padding: 2rem;">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ));
                ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
