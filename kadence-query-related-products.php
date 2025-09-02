<?php
/**
 * Override Kadence Query Block: Show related WooCommerce products for specific Query ID.
 *
 * Hook: `pre_render_block`
 * Target: Kadence `kadence/query` block with a specific ID (e.g., 463)
 * Result: Overrides the REST response with custom related products data
 */

add_filter( 'pre_render_block', 'hrt_override_kadence_query_block_with_related_products', 1, 3 );

function hrt_override_kadence_query_block_with_related_products( $pre_render, $block, $parent_block ) {
	if (
		isset( $block['blockName'], $block['attrs']['id'] ) &&
		$block['blockName'] === 'kadence/query' &&
		(int) $block['attrs']['id'] === 463
	) {
		global $kb_query_rest_responses;

		$query_id = $block['attrs']['id'];

		// Default posts output
		$posts = array();

		// Get Kadence query template content if class exists
		[ $ql_post, $qlc_post ] = class_exists( 'Kadence_Blocks_Pro_Abstract_Query_Block' )
			? Kadence_Blocks_Pro_Abstract_Query_Block::get_q_posts( $query_id )
			: [ null, null ];

		$template_content_base = hrt_get_kadence_template_content( $qlc_post );

		// Get related WooCommerce products
		$product_id  = get_the_ID();
		$related_ids = wc_get_related_products( $product_id, 3 );

		if( empty( $related_ids ) ) {
            return $pre_render;
        }

		$args = array(
			'post_type' => 'product',
			'post__in'  => $related_ids,
			'orderby'   => 'post__in',
		);

		$related_query = new WP_Query( $args );

		while ( $related_query->have_posts() ) {
			$related_query->the_post();

			$post_id   = get_the_ID();
			$post_type = get_post_type();

			// Temporarily override block rendering context
			$filter_block_context = static function ( $context ) use ( $post_id, $post_type ) {
				$context['postType'] = $post_type;
				$context['postId']   = $post_id;
				return $context;
			};
			add_filter( 'render_block_context', $filter_block_context );

			// Render the block content for this related product
			global $wp_embed;
			$template_content = $wp_embed->run_shortcode( $template_content_base );
			$template_content = $wp_embed->autoembed( $template_content );
			$template_content = do_blocks( $template_content );
			$template_content = do_shortcode( $template_content );

			remove_filter( 'render_block_context', $filter_block_context );

			$post_classes        = implode( ' ', get_post_class( 'kb-query-block-post' ) );
			$outer_wrapper_start = '<li class="kb-query-item ' . esc_attr( $post_classes ) . '"><div class="kb-query-item-flip-back"></div>';
			$outer_wrapper_end   = '</li>';

			$posts[] = $outer_wrapper_start . $template_content . $outer_wrapper_end;
		}
		wp_reset_postdata();

		// Create REST-style response to override default
		$response_data = array(
			'posts'       => $posts,
			'page'        => 1,
			'perPage'     => 3,
			'postCount'   => count( $posts ),
			'foundPosts'  => count( $posts ),
			'postTypes'   => array( 'product' ),
			'maxNumPages' => 1,
		);

		$response = new WP_REST_Response();
		$response->set_data( $response_data );
		$response->set_status( 200 );

		// Override Kadence REST response for this Query ID
		$kb_query_rest_responses[ $query_id ] = $response;
	}

	return $pre_render;
}

/**
 * Get processed Kadence Query Loop template content.
 *
 * Removes the inner "query-card" blocks to avoid nested rendering.
 * Sets `inQueryBlock` attribute recursively for Kadence blocks to behave properly.
 *
 * @param WP_Post|null $qlc_post Query loop content post object.
 * @return string Cleaned block content.
 */
function hrt_get_kadence_template_content( $qlc_post ) {
	if ( ! isset( $qlc_post->post_content ) ) {
		return '';
	}

	$template_content = $qlc_post->post_content;

	// Strip kadence/query-card block wrappers
	$template_content = preg_replace( '/<!-- wp:kadence\/query-card {.*?} -->/', '', $template_content );
	$template_content = str_replace(
		array(
			'<!-- wp:kadence/query-card  -->',
			'<!-- wp:kadence/query-card -->',
			'<!-- /wp:kadence/query-card -->',
		),
		'',
		$template_content
	);

	// For element/woo template types, restore inQueryBlock attribute
	if ( in_array( $qlc_post->post_type, array( 'kadence_element', 'kadence_wootemplate' ), true ) ) {
		$blocks = parse_blocks( $template_content );
		if ( ! empty( $blocks ) ) {
			hrt_kadence_set_in_query_block_recursive( $blocks );
			$template_content = serialize_blocks( $blocks );
		}
	}

	return $template_content;
}

/**
 * Recursively sets `inQueryBlock` attribute on Kadence blocks.
 *
 * @param array &$blocks Parsed blocks array (by reference).
 */
function hrt_kadence_set_in_query_block_recursive( &$blocks ) {
	foreach ( $blocks as &$block ) {
		if ( isset( $block['blockName'] ) && strpos( $block['blockName'], 'kadence/' ) === 0 ) {
			if ( ! isset( $block['attrs'] ) ) {
				$block['attrs'] = array();
			}
			$block['attrs']['inQueryBlock'] = true;
		}
		if ( ! empty( $block['innerBlocks'] ) ) {
			hrt_kadence_set_in_query_block_recursive( $block['innerBlocks'] );
		}
	}
	unset( $block );
}
