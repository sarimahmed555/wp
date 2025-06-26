<?php
/**
 * Template Name: Help Center Sub Page
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="help-center-sub-section">
        <div class="container">
            <div class="help-center-breadcrumb">
                <a href="<?php echo esc_url(home_url('/help-center/')); ?>">Help Center</a> &gt; <?php the_title(); ?>
            </div>
            
            <div class="help-center-content">
                <h1 class="section-title"><?php the_title(); ?></h1>
                
                <div class="help-center-main-content">
                    <?php the_content(); ?>
                </div>

                <div class="help-center-navigation">
                    <div class="back-to-help">
                        <a href="<?php echo esc_url(home_url('/help-center/')); ?>" class="button secondary">
                            &larr; Back to Help Center
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?> 