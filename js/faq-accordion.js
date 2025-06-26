jQuery(document).ready(function($) {
    // Toggle FAQ answer visibility when question is clicked
    $('.faq-question').on('click', function() {
        $(this).parent().toggleClass('active');
    });
}); 