
<?php get_header(); ?>

<main class="main-content">
    <?php while (have_posts()) : the_post(); ?>
        <div class="sitter-profile">
            <div class="sitter-header">
                <div class="sitter-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>" class="sitter-avatar">
                    <?php else : ?>
                        <img src="https://via.placeholder.com/150x150/6B46C1/FFFFFF?text=<?php echo substr(get_the_title(), 0, 1); ?>" alt="<?php the_title(); ?>" class="sitter-avatar">
                    <?php endif; ?>
                </div>
                
                <div class="sitter-info">
                    <h1><?php the_title(); ?></h1>
                    <p class="sitter-location">📍 <?php echo esc_html(get_post_meta(get_the_ID(), 'location', true) ?: 'Location not specified'); ?></p>
                    
                    <div class="sitter-stats">
                        <div class="stat">
                            <div class="stat-number"><?php echo esc_html(get_post_meta(get_the_ID(), 'rating', true) ?: '5.0'); ?></div>
                            <div class="stat-label">Rating</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number"><?php echo esc_html(get_post_meta(get_the_ID(), 'reviews_count', true) ?: '0'); ?></div>
                            <div class="stat-label">Reviews</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number"><?php echo esc_html(get_post_meta(get_the_ID(), 'experience_years', true) ?: '1'); ?></div>
                            <div class="stat-label">Years Exp.</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">$<?php echo esc_html(get_post_meta(get_the_ID(), 'hourly_rate', true) ?: '25'); ?></div>
                            <div class="stat-label">Per Hour</div>
                        </div>
                    </div>
                    
                    <button class="book-button" style="max-width: 200px;">Book Now</button>
                </div>
            </div>
            
            <div class="sitter-details">
                <div class="services-offered" style="margin-bottom: 2rem;">
                    <h3 style="color: var(--primary-purple); margin-bottom: 1rem;">Services Offered</h3>
                    <div class="service-tags">
                        <?php 
                        $services = get_post_meta(get_the_ID(), 'services', true);
                        if (is_array($services) && !empty($services)) :
                            foreach ($services as $service) :
                        ?>
                            <span class="service-tag"><?php echo esc_html($service); ?></span>
                        <?php 
                            endforeach;
                        else :
                        ?>
                            <span class="service-tag">Dog Walking</span>
                            <span class="service-tag">Pet Sitting</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="sitter-bio">
                    <h3 style="color: var(--primary-purple); margin-bottom: 1rem;">About Me</h3>
                    <div class="bio-content" style="line-height: 1.8; color: var(--dark-gray);">
                        <?php 
                        if (get_the_content()) {
                            the_content();
                        } else {
                            echo '<p>I am a passionate pet lover with years of experience caring for animals. I provide reliable, loving care for your furry family members when you can\'t be there. Your pets\' safety and happiness are my top priorities.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
