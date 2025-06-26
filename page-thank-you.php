<?php
/**
 * Template Name: Thank You Page
 */
get_header();
?>

<main class="main-content">
    <section class="thank-you-section">
        <div class="container">
            <h1 class="page-title">Thank You!</h1>
            
            <div class="thank-you-message">
                <p>Your pet service request has been submitted successfully.</p>
                <p>We have received your information and will contact you shortly.</p>
                
                <?php if (get_transient('form_submission_success')): ?>
                    <div class="success-message">
                        <p>An email with your request details has been sent to our team.</p>
                    </div>
                    <?php delete_transient('form_submission_success'); ?>
                <?php elseif (get_transient('form_submission_error')): ?>
                    <div class="error-message">
                        <p>There was an issue sending the email. Please try again or contact us directly.</p>
                    </div>
                    <?php delete_transient('form_submission_error'); ?>
                <?php endif; ?>
                
                <div class="return-home">
                    <a href="<?php echo home_url(); ?>" class="button primary">Return to Home</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>