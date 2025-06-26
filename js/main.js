
jQuery(document).ready(function($) {
    // Automatically add AOS attributes for scroll animation to main content elements
    $('[class*="col"], .service-card, section, article, .widget, .footer-column, .header-container, .site-logo, .site-header, .site-footer, .main, main, .container, .content, .entry, .post, .page').each(function(){
        if (!$(this).attr('data-aos')) {
            $(this).attr('data-aos', 'fade-up');
        }
    });
    // Search form enhancements
    $('.search-form').on('submit', function(e) {
        var location = $('#location').val();
        var serviceType = $('#service_type').val();
        
        if (!location && !serviceType) {
            e.preventDefault();
            alert('Please enter a location or select a service type to search.');
            return false;
        }
    });
    
    // Service card hover effects
    $('.service-card').hover(
        function() {
            $(this).addClass('hovered');
        },
        function() {
            $(this).removeClass('hovered');
        }
    );
    
    // Date picker minimum date
    var today = new Date().toISOString().split('T')[0];
    $('#check_in, #check_out').attr('min', today);
    
    // Ensure check-out is after check-in
    $('#check_in').on('change', function() {
        var checkinDate = $(this).val();
        $('#check_out').attr('min', checkinDate);
    });
    
    // Smooth scrolling for internal links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Mobile menu toggle (if needed)
    $('.mobile-menu-toggle').on('click', function() {
        $('.main-navigation').toggleClass('open');
    });
    
    // Filter animations
    $('.search-field input, .search-field select').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
});
