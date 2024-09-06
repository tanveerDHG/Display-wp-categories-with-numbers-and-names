// just numbers cats
function display_numeric_slug_categories_shortcode($atts) {
    // Shortcode attributes
    $atts = shortcode_atts(
        array(
            'number' => '', // Optional: Number of categories to display (empty for all)
        ),
        $atts,
        'display_numeric_slug_categories'
    );

    // Prepare the query arguments
    $args = array(
        'orderby'    => 'name', // Order by category name
        'order'      => 'ASC',  // Ascending order
        'hide_empty' => true,   // Hide empty categories
    );

    // Get all categories
    $all_categories = get_categories($args);

    // Filter categories with numeric slugs
    $numeric_categories = array_filter($all_categories, function($category) {
        return is_numeric($category->slug);
    });

    // Optionally limit the number of categories
    if (!empty($atts['number'])) {
        $numeric_categories = array_slice($numeric_categories, 0, intval($atts['number']));
    }

    // Start output buffering
    ob_start();

    // Check if there are categories
    if (!empty($numeric_categories)) {
        echo '<ul>';

        // Loop through categories
        foreach ($numeric_categories as $category) {
			$post_count = $category->count;
            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a> (' . esc_html($post_count) . ') </li>';
        }

        echo '</ul>';
    } else {
        echo 'No categories with numeric slugs found.';
    }

    // Return the output
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('display_numeric_slug_categories', 'display_numeric_slug_categories_shortcode');

// non numbers
function display_non_numeric_slug_categories_with_count_shortcode($atts) {
    // Shortcode attributes
    $atts = shortcode_atts(
        array(
            'number' => '', // Optional: Number of categories to display (empty for all)
        ),
        $atts,
        'display_non_numeric_slug_categories_with_count'
    );

    // Prepare the query arguments
    $args = array(
        'orderby'    => 'name', // Order by category name
        'order'      => 'ASC',  // Ascending order
        'hide_empty' => true,   // Hide empty categories
    );

    // Get all categories
    $all_categories = get_categories($args);

    // Filter categories with non-numeric slugs
    $non_numeric_categories = array_filter($all_categories, function($category) {
        return !is_numeric($category->slug);
    });

    // Optionally limit the number of categories
    if (!empty($atts['number'])) {
        $non_numeric_categories = array_slice($non_numeric_categories, 0, intval($atts['number']));
    }

    // Start output buffering
    ob_start();

    // Check if there are categories
    if (!empty($non_numeric_categories)) {
        echo '<ul>';

        // Loop through categories
        foreach ($non_numeric_categories as $category) {
            $post_count = $category->count;
            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a> (' . esc_html($post_count) . ')</li>';
        }

        echo '</ul>';
    } else {
        echo 'No categories with non-numeric slugs found.';
    }

    // Return the output
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('display_non_numeric_slug_categories_with_count','display_non_numeric_slug_categories_with_count_shortcode');
