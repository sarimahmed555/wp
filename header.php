<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>

<header class="site-header header-full-width">
    <div class="header-container">
        
        
        <!-- <nav class="main-navigation">
            <ul>
                <li><a href="<?php echo home_url('/search/'); ?>" class="has-icon"><img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=24&h=24&fit=crop" alt="Search"><span>Search Sitters</span></a></li>
                <li><a href="<?php echo home_url('/become-sitter/'); ?>" class="has-icon"><img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=24&h=24&fit=crop" alt="Become a Sitter"><span>Become a Sitter</span></a></li>
                <li class="menu-item-has-children"><a href="#" class="has-icon"><img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=24&h=24&fit=crop" alt="Services"><span>Our Services</span></a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo home_url('/service/dog-boarding/'); ?>">Dog Boarding</a></li>
                        <li><a href="<?php echo home_url('/service/house-sitting/'); ?>">House Sitting</a></li>
                        <li><a href="<?php echo home_url('/service/drop-in-visits/'); ?>">Drop-In Visits</a></li>
                        <li><a href="<?php echo home_url('/service/doggy-day-care/'); ?>">Doggy Day Care</a></li>
                        <li><a href="<?php echo home_url('/service/dog-walking/'); ?>">Dog Walking</a></li>
                        <li><a href="<?php echo home_url('/service/dog-training/'); ?>">Dog Training <span class="new-badge">NEW</span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
-->
    <!--    <div class="header-actions">
            <a href="<?php echo wp_registration_url(); ?>" class="header-link">Sign Up</a>
            <a href="<?php echo wp_login_url(); ?>" class="header-link">Sign In</a>
            <a href="<?php echo home_url('/help/'); ?>" class="header-link">Help</a>
            <a href="<?php echo home_url('/search/'); ?>" class="button primary find-sitter-button">Find a Sitter</a>
            <?php if (is_user_logged_in()): ?>
                <div class="user-menu">
                    <button class="user-menu-button">
                        <span class="user-avatar">
                            <?php echo get_avatar(get_current_user_id(), 32); ?>
                        </span>
                    </button>
                    <div class="user-dropdown">
                        <a href="<?php echo home_url('/my-account/'); ?>">My Account</a>
                        <a href="<?php echo home_url('/my-bookings/'); ?>">My Bookings</a>
                        <a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>-->
</header>

<div class="mobile-header-actions">
    <!-- Removed for mobile: Find a Sitter button and user/auth actions -->
</div>
