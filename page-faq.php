<?php
/**
 * Template Name: FAQ Page
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="faq-section">
        <div class="container">
            <h1 class="section-title">Frequently Asked Questions</h1>
            <div class="faq-content">
                <!-- Example FAQ Item 1 -->
                <div class="faq-item">
                    <h3 class="faq-question">How do I book a pet sitter?</h3>
                    <div class="faq-answer">
                        <p>Booking a pet sitter is easy! Simply use the search bar on our homepage to find sitters in your area. You can filter by service type, dates, and pet size. Once you find a sitter you like, send them a message to discuss your needs and then proceed with booking.</p>
                    </div>
                </div>

                <!-- Example FAQ Item 2 -->
                <div class="faq-item">
                    <h3 class="faq-question">What is Velvet Leash Co. Protect?</h3>
                    <div class="faq-answer">
                        <p>Velvet Leash Co. Protect is our comprehensive safety and support program that includes veterinary care reimbursement, 24/7 support, and secure online payments. It's designed to give you peace of mind with every booking.</p>
                    </div>
                </div>

                <!-- Example FAQ Item 3 -->
                <div class="faq-item">
                    <h3 class="faq-question">How do payments work?</h3>
                    <div class="faq-answer">
                        <p>All payments are processed securely through the Velvet Leash Co. platform. You can pay with a credit card, and funds are only released to the sitter 48 hours after the service is completed, ensuring your satisfaction.</p>
                    </div>
                </div>

                <!-- Additional FAQ Items from Rover's typical topics -->

                <div class="faq-item">
                    <h3 class="faq-question">What if my pet has a medical emergency during a booking?</h3>
                    <div class="faq-answer">
                        <p>In case of a medical emergency during a booking, our sitters are instructed to contact you immediately. If you're unreachable, they will take your pet to the nearest emergency vet clinic. The Velvet Leash Co. Guarantee may cover eligible vet care costs.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h3 class="faq-question">How do I update my profile or pet information?</h3>
                    <div class="faq-answer">
                        <p>You can easily update your profile and pet information by logging into your account and navigating to the 'Profile' or 'Pets' section. Remember to save any changes you make.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h3 class="faq-question">Can I meet the sitter before booking?</h3>
                    <div class="faq-answer">
                        <p>Yes, we highly recommend scheduling a free Meet & Greet with your potential sitter before confirming a booking. This allows you and your pet to get to know the sitter and discuss any specific needs.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h3 class="faq-question">What are the cancellation policies?</h3>
                    <div class="faq-answer">
                        <p>Cancellation policies vary by sitter and service. You can find the specific cancellation policy for each booking on the sitter's profile and during the booking process. We recommend reviewing it carefully before confirming.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <h3 class="faq-question">Is the Velvet Leash Co. app available for my phone?</h3>
                    <div class="faq-answer">
                        <p>Yes, the Velvet Leash Co. app is available for both iOS and Android devices. You can download it from the App Store or Google Play Store to manage your bookings, communicate with sitters, and receive updates on the go.</p>
                    </div>
                </div>

                <p class="contact-faq-text">Still have questions? Visit our <a href="<?php echo esc_url( home_url( '/help-center/' ) ); ?>">Help Center</a> or contact our support team.</p>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?> 