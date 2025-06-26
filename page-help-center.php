<?php
/**
 * Template Name: Help Center Page
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="help-center-section">
        <div class="container">
            <h1 class="section-title">How Can We Help You?</h1>
            <div class="help-content">
                <p class="intro-text">Welcome to the Velvet Leash Co. Help Center. Here you'll find answers to common questions and resources to assist you.</p>
                
                <div class="help-cards-grid">
                    <div class="help-card">
                        <h3>For Pet Parents</h3>
                        <p>Find answers to common questions about booking services, managing payments, and ensuring your pet's safety.</p>
                        <ul>
                            <?php
                            $help_center_id = get_the_ID(); // Get the ID of the current Help Center page
                            $pet_parent_pages = get_children( array(
                                'post_parent' => $help_center_id,
                                'post_type'   => 'page',
                                'post_status' => 'publish',
                                'orderby'     => 'menu_order',
                                'order'       => 'ASC',
                            ) );

                            $pet_parent_topics = array(
                                'Booking & Payments',
                                'Pet Safety & Guarantee',
                                'Account Management',
                            );

                            foreach ( $pet_parent_pages as $page ) {
                                if ( in_array( $page->post_title, $pet_parent_topics ) ) {
                                    $permalink = esc_url( get_permalink( $page->ID ) );
                                    echo '<li><a href="' . $permalink . '">' . esc_html( $page->post_title ) . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="help-card">
                        <h3>For Sitters</h3>
                        <p>Resources for sitters, including information on managing profiles, bookings, and earnings.</p>
                        <ul>
                            <?php
                            $sitter_topics = array(
                                'For Sitters',
                                // Add other relevant sitter topics if they were created as sub-pages
                            );
                            foreach ( $pet_parent_pages as $page ) { // Re-using $pet_parent_pages as it contains all children
                                if ( in_array( $page->post_title, $sitter_topics ) ) {
                                    $permalink = esc_url( get_permalink( $page->ID ) );
                                    echo '<li><a href="' . $permalink . '">' . esc_html( $page->post_title ) . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="help-card">
                        <h3>Contact Support</h3>
                        <p>Can't find what you're looking for? Our support team is here to help.</p>
                        <a href="#" class="button secondary">Contact Us</a>
                    </div>
                </div>

                <p class="browse-faq-text">Or, <a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">browse our Frequently Asked Questions (FAQ)</a> section.</p>

            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?> 