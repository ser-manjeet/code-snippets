<?php
/**
 * Replaces WooCommerce pagination arrows with custom SVG icons
 * 
 * Features:
 * - Replaces default '« Previous' and 'Next »' text with SVG chevrons
 * - Uses inline SVG for better control over icon appearance
 * - Maintains theme color compatibility through currentColor
 * 
 * @param array $args Original pagination arguments
 * @return array Modified pagination arguments
 */
add_filter('woocommerce_pagination_args', function($args) {
    
    // Custom SVG icons
    $left_chevron = '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.41 10.59L2.83 6L7.41 1.41L6 0L0 6L6 12L7.41 10.59Z" fill="currentColor"/>
    </svg>';
    
    $right_chevron = '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.590088 10.59L5.17009 6L0.590088 1.41L2.00009 0L8.00009 6L2.00009 12L0.590088 10.59Z" fill="currentColor"/>
    </svg>';

    // Replace navigation text with SVG icons
    $args['prev_text'] = $left_chevron;   // Left-pointing chevron
    $args['next_text'] = $right_chevron;  // Right-pointing chevron

    return $args;
});

/* ==========================================================================
   NOTES FOR IMPLEMENTATION
   --------------------------------------------------------------------------
   1. Add to theme's functions.php file or custom plugin
   2. Icons will automatically inherit link color via currentColor
   3. SVG dimensions can be modified by changing width/height attributes
   4. Arrow appearance can be adjusted by modifying path data
   5. Works with default WooCommerce pagination styles
   ========================================================================== */

// Optional: Add CSS customization for better icon alignment
/*
.woocommerce-pagination .page-numbers li a svg {
    vertical-align: middle;
    margin: -2px 0 0;
}
*/
