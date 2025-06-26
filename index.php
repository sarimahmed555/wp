<meta name="viewport" content="width=device-width, initial-scale=1">

<?php get_header(); ?>
<style>
    .animated-pic-sec {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
</style>
<main class="main-content">
   
<!-- Hero Section -->
    <section class="hero-section">
        <div class="site-logo">
            <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/velvet-leash-logo.png" alt="Velvet Leash Co." class="custom-logo"></a>
        </div>
        <div class="animated-pic-sec">
            <dotlottie-player src="https://lottie.host/0e0b6344-0430-4365-97e7-b55a359f9dec/VErshxYIM3.lottie" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay class="hero-dog-animation2"></dotlottie-player> <!-- Dog Animation moved outside hero-content-text-wrapper for absolute positioning -->
            <dotlottie-player src="https://lottie.host/9506e324-e9f8-4d34-bdef-e8db9f0a3f55/IwAZnOaAq1.lottie" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay class="hero-dog-animation1"></dotlottie-player>
        </div>

        <div class="hero-content-text-wrapper"> <!-- New wrapper to center the text -->
            <div class="hero-content-text">
            <h1 class="hero-title">Local, Trusted, and Tail-Wagging Approved<span class="trademark">™</span></h1>
            <p class="hero-subtitle">Book trusted sitters and dog walkers.</p>
            </div>
        </div>
            <!-- Search Form Wrapper -->
            <div class="search-form-wrapper">
                <form class="search-form" action="<?php echo home_url('/search/'); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="form_submitted" value="1">
                    <div class="service-type-toggle">
                    <label><input type="radio" name="search_pet_type" value="dog" checked> <span>Dog</span></label>
                    <label><input type="radio" name="search_pet_type" value="cat"> <span>Cat</span></label>
                    </div>

                    <div class="date-selection-tabs">
                        <button type="button" class="date-tab active" data-tab="away">For When You're Away</button>
                        <button type="button" class="date-tab" data-tab="at-work">For When You're At Work</button>
                    </div>

                <div class="service-tabs-heading" style="text-align: center; margin-bottom: 1rem;">
                    <h3>Services</h3>
                </div>

                    <div class="service-tabs-container">
                    <div class="service-tabs" id="all-services">
                            <button type="button" class="service-tab active" data-service="boarding">Boarding</button>
                            <button type="button" class="service-tab" data-service="house-sitting">House Sitting</button>
                            <button type="button" class="service-tab" data-service="drop-in-visits">Drop-In Visits</button>
                            <button type="button" class="service-tab" data-service="doggy-day-care">Doggy Day Care</button>
                            <button type="button" class="service-tab" data-service="dog-walking">Dog Walking</button>
                        </div>
                        <input type="hidden" name="service_tab" id="selected_service" value="boarding">
                    </div>

                    <div class="search-row">
                        <div class="search-field large">
                            <label for="location">Address</label>
                        <input type="text" id="location" name="location" placeholder="Enter your address" value="<?php echo isset($_GET['location']) ? esc_attr($_GET['location']) : ''; ?>" autocomplete="off">
                        <div id="address-suggestions" class="address-suggestions"></div>
                        </div>
                        <div class="search-field date-field" id="drop_off_field">
                            <label for="drop_off">Drop-off</label>
                            <input type="date" id="drop_off" name="drop_off" placeholder="mm/dd/yyyy" value="<?php echo isset($_GET['drop_off']) ? esc_attr($_GET['drop_off']) : ''; ?>">
                        </div>
                        <div class="search-field date-field" id="pick_up_field">
                            <label for="pick_up">Pick up</label>
                            <input type="date" id="pick_up" name="pick_up" placeholder="mm/dd/yyyy" value="<?php echo isset($_GET['pick_up']) ? esc_attr($_GET['pick_up']) : ''; ?>">
                        </div>
                    </div>
                <div class="search-row address-details-row" style="display: none;">
                    <div class="search-field large">
                        <label for="street_address">Street Address</label>
                        <input type="text" id="street_address" name="street_address" placeholder="e.g. 123 Main Street">
                    </div>
                    <div class="search-field">
                        <label for="zip_code">Zip Code</label>
                        <input type="text" id="zip_code" name="zip_code" placeholder="e.g. 90210">
                        <div id="zip-code-suggestions" class="address-suggestions"></div>
                    </div>
                </div>

                <div class="pet-photo-upload-section">
                    <label>Add Your Pet's Photo</label>
                    <div class="pet-photo-upload-container">
                        <div class="pet-photo-upload-box" id="pet-photo-upload-1">
                            <input type="file" id="pet-photo-input-1" name="pet_photo_1" accept="image/*" style="display: none;">
                            <div class="upload-placeholder">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Upload Photo 1</span>
                            </div>
                        </div>
                        <div class="pet-photo-upload-box" id="pet-photo-upload-2">
                            <input type="file" id="pet-photo-input-2" name="pet_photo_2" accept="image/*" style="display: none;">
                            <div class="upload-placeholder">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Upload Photo 2</span>
                            </div>
                        </div>
                        <div class="pet-photo-upload-box" id="pet-photo-upload-3">
                            <input type="file" id="pet-photo-input-3" name="pet_photo_3" accept="image/*" style="display: none;">
                            <div class="upload-placeholder">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Upload Photo 3</span>
                            </div>
                        </div>
                    </div>
                    <div class="pet-photo-preview" id="pet-photo-preview"></div>
                    <p class="upload-hint">Upload up to 3 photos of your pets</p>
                    </div>

                    <div class="search-row pet-size-row">
                        <label>My Dog Size</label>
                        <div class="pet-size-options">
                            <label><input type="radio" name="dog_size" value="small"> Small <span>0-15 lbs</span></label>
                            <label><input type="radio" name="dog_size" value="medium"> Medium <span>16-40 lbs</span></label>
                            <label><input type="radio" name="dog_size" value="large"> Large <span>41-100 lbs</span></label>
                            <label><input type="radio" name="dog_size" value="giant"> Giant <span>101+ lbs</span></label>
                        </div>
                    </div>

                    <button type="submit" class="search-button">Submit</button>
                    
                <!-- <div class="dog-training-promo">
                        <span>Dog Training</span> 1-1 virtual dog training through GoodPup, the newest member of the Velvet Leash Co. family.
                        <a href="<?php echo home_url('/dog-training/'); ?>" class="start-free-trial">Start your free trial</a>
                </div> -->
                </form>
        </div>
    </section>

    <!-- Services for every dog and cat -->
    <section class="services-overview">
        <div class="container">
            <h2 class="section-title">Services for every dog and cat</h2>
            <div class="services-grid-small">
                <div class="service-item">
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=100&h=100&fit=crop" alt="Boarding Icon" class="service-icon">
                    <h3>Boarding</h3>
                    <p>Your pets stay overnight in your sitter's home. They'll be treated like part of the family in a comfortable environment.</p>
                </div>
                <div class="service-item">
                    <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=100&h=100&fit=crop" alt="House Sitting Icon" class="service-icon">
                    <h3>House Sitting</h3>
                    <p>Your sitter takes care of your pets and your house. Your pets will get all the attention they need from the comfort of home.</p>
                </div>
                <div class="service-item">
                    <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=100&h=100&fit=crop" alt="Dog Walking Icon" class="service-icon">
                    <h3>Dog Walking</h3>
                    <p>Your dog gets a walk around your neighborhood. Perfect for busy days and dogs with extra energy to burn.</p>
                </div>
                <div class="service-item">
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=100&h=100&fit=crop" alt="Doggy Day Care Icon" class="service-icon">
                    <h3>Doggy Day Care</h3>
                    <p>Your dog spends the day at your sitter's home. Drop them off in the morning and pick up a happy pup in the evening.</p>
                </div>
                <div class="service-item">
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=100&h=100&fit=crop" alt="Drop-In Visits Icon" class="service-icon">
                    <h3>Drop-In Visits</h3>
                    <p>Your sitter drops by your home to play with your pets, offer food, and give potty breaks or clean the litter box.</p>
                </div>
                <!-- <div class="service-item">
                    <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=100&h=100&fit=crop" alt="Dog Training Icon" class="service-icon">
                    <h3>Dog Training through GoodPup</h3>
                    <p>Private, virtual dog training through GoodPup. Train from the comfort of your home through 1-1 video chat.</p>
                </div> -->
            </div>
        </div>
    </section>

    <!-- RoverProtect Section -->
    <section class="rover-protect-section">
        <div class="container">
            <div class="rover-protect-content">
                <h2 class="section-title">🐶 Velvet Leash Co. Protect</h2>
                <h3>Find peace of mind with every booking.</h3>
                <ul>
                    <li>Screened pet sitters have already passed a third-party background check and show verified reviews from other pet parents, like you.</li>
                    <li>Messaging & photo updates from your sitter during each stay.</li>
                    <li>The Velvet Leash Co. Guarantee can protect you and your pet for up to $25,000 in eligible vet care. <a href="#">Learn more</a></li>
                    <li>24/7 support from the Velvet Leash Co. team—here to help if you ever need someone to talk to.</li>
                </ul>
                <a href="#" class="button primary">Book a local sitter</a>
                <br>
                <a href="#" class="button secondary">Learn more about Velvet Leash Co. Protect</a>
                <p class="disclaimer">Services booked on Velvet Leash Co. are backed by Velvet Leash Co. Protect and reservation protection. Modified terms apply to bookings with day care carets. GoodPup not included.</p>
            </div>
            <div class="rover-protect-image">
                <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=800&h=600&fit=crop" alt="Velvet Leash Co. Protect Image">
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="testimonial-card">
                <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=200&h=200&fit=crop" alt="Testimonial Image 1" class="testimonial-image">
                <p class="testimonial-text">I was nervous to leave Sam with strangers, but my worries quickly faded. Going forward Velvet Leash Co. will be my first choice for pet sitting.</p>
                <p class="testimonial-author">- Molly S.</p>
            </div>
            <div class="testimonial-card">
                <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=200&h=200&fit=crop" alt="Testimonial Image 2" class="testimonial-image">
                <p class="testimonial-text">My sitter took great care of my cat, above and beyond my expectations. I would book with Velvet Leash Co. again in a heartbeat!</p>
                <p class="testimonial-author">- Danielle H.</p>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section class="how-it-works-section">
        <div class="container">
            <h2 class="section-title">Meet local sitters who will treat your pets like family</h2>
            <div class="steps-grid">
                <div class="step-item">
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=100&h=100&fit=crop" alt="Search Icon" class="step-icon">
                    <h3>1. Search</h3>
                    <p>Read verified reviews by pet parents like you and choose a screened sitter who's a great match for you and your pets.</p>
                </div>
                <div class="step-item">
                    <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=100&h=100&fit=crop" alt="Book & Pay Icon" class="step-icon">
                    <h3>2. Book & pay</h3>
                    <p>No cash or checks needed—we make it simple to book and make secured payments through our website or app.</p>
                </div>
                <div class="step-item">
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=100&h=100&fit=crop" alt="Relax Icon" class="step-icon">
                    <h3>3. Relax</h3>
                    <p>Stay in touch with photos and messaging. Plus, your booking is backed by Velvet Leash Co. Protect, including 24/7 support and reimbursement for eligible vet care.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- App Download Section -->
    <section class="app-download-section">
        <div class="container">
            <h2 class="section-title">Connect anywhere with the Velvet Leash Co. app</h2>
            <div class="app-stores">
                <a href="#" class="app-store-badge">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="Download on the App Store">
                </a>
                <a href="#" class="app-store-badge">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play">
                </a>
            </div>
            <div class="phone-mockups">
                <img src="https://cdn.pixabay.com/photo/2017/01/22/12/07/imac-1999636_1280.png" alt="Phone Mockup 1" class="phone-mockup-left">
                <img src="https://cdn.pixabay.com/photo/2017/01/22/12/07/imac-1999636_1280.png" alt="Phone Mockup 2" class="phone-mockup-right">
            </div>
        </div>
    </section>

    <!-- States Section -->
    <section class="states-section">
        <div class="container">
            <h2 class="section-title">Thousands of pet sitters across the United States 🇺🇸 </h2>
            <div class="states-grid">
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Alabama</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Alaska</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Arizona</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Arkansas</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">California</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Colorado</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Connecticut</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Delaware</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">District of Columbia</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Florida</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Georgia</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Hawaii</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Idaho</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Illinois</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Indiana</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Iowa</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Kansas</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Kentucky</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Louisiana</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Maine</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Maryland</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Massachusetts</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Michigan</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Minnesota</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Mississippi</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Missouri</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Montana</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Nebraska</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Nevada</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">New Hampshire</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">New Jersey</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">New Mexico</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">New York</a></li>
                    <li class="nc-active"><a href="#">North Carolina</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">North Dakota</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Ohio</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Oklahoma</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Oregon</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Pennsylvania</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Rhode Island</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">South Carolina</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">South Dakota</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Tennessee</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Texas</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Utah</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Vermont</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Virginia</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Washington</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">West Virginia</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Wisconsin</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Wyoming</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- World Section -->
    <section class="world-section">
        <div class="container">
            <h2 class="section-title">Velvet Leash Co. is also in... <span class="globe-emoji">🌎</span></h2>
            <div class="countries-grid">
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Canada</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">United Kingdom</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">France</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Germany</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Italy</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Spain</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Netherlands</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Norway</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Sweden</a></li>
                </ul>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Ireland</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Australia</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/coming-soon/' ) ); ?>">Brazil</a></li>
                </ul>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
