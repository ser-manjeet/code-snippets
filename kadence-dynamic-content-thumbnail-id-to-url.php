<?php
/**
 * Kadence: Convert WooCommerce Product Category Thumbnail ID to Image URL
 *
 * This filter modifies the output of the `kadence_dynamic_content_render` hook
 * to return the actual image URL for a product category's thumbnail image,
 * instead of just the attachment ID.
 *
 * Usage:
 * - Set up a Kadence block with dynamic background image.
 * - Use Dynamic Source: Archive Custom Field
 * - Field Name: thumbnail_id
 *
 * Kadence will pass the media ID to this filter, and this code will convert it
 * into a usable image URL (full size).
 */

add_filter( 'kadence_dynamic_content_render', function( $output, $item_id, $origin, $group, $field, $para, $custom ) {
    // Check if we're modifying the correct dynamic custom field
    if ( $field === 'archive_custom_field' && $custom === 'thumbnail_id' ) {

        // Get the media ID stored in term meta
        $thumb_id = get_term_meta( $item_id, 'thumbnail_id', true );

        // If we have a media ID, convert it to a full-size image URL
        if ( $thumb_id ) {
            $image_src = wp_get_attachment_image_src( $thumb_id, 'full' );
            if ( ! empty( $image_src[0] ) ) {
                return $image_src[0];
            }
        }
    }

    // Return the original output if no modifications were made
    return $output;
}, 10, 7 );
