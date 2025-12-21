<?php
function sgharem_assets() {
    wp_enqueue_style('sgharem-style', get_stylesheet_uri(), [], '1.0');
}
add_action('wp_enqueue_scripts', 'sgharem_assets');

// Register Banner Custom Post Type
function sgharem_register_banner_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Banners',
            'singular_name' => 'Banner',
            'add_new' => 'Add New Banner',
            'add_new_item' => 'Add New Banner',
            'edit_item' => 'Edit Banner',
            'all_items' => 'All Banners',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-format-image',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => false,
    );
    register_post_type('banner', $args);
}
add_action('init', 'sgharem_register_banner_cpt');

// Add Banner Meta Boxes
function sgharem_banner_meta_boxes() {
    add_meta_box(
        'banner_settings',
        'Banner Settings',
        'sgharem_banner_meta_callback',
        'banner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_banner_meta_boxes');

function sgharem_banner_meta_callback($post) {
    wp_nonce_field('sgharem_banner_nonce', 'banner_nonce');

    $heading = get_post_meta($post->ID, '_banner_heading', true);
    $description = get_post_meta($post->ID, '_banner_description', true);
    $button_text = get_post_meta($post->ID, '_banner_button_text', true);
    $button_url = get_post_meta($post->ID, '_banner_button_url', true);
    $is_active = get_post_meta($post->ID, '_banner_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="banner_active">Active</label></th>
            <td><input type="checkbox" id="banner_active" name="banner_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="banner_heading">Heading</label></th>
            <td><input type="text" id="banner_heading" name="banner_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="banner_description">Description</label></th>
            <td><textarea id="banner_description" name="banner_description" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="banner_button_text">Button Text</label></th>
            <td><input type="text" id="banner_button_text" name="banner_button_text" value="<?php echo esc_attr($button_text); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="banner_button_url">Button URL</label></th>
            <td><input type="url" id="banner_button_url" name="banner_button_url" value="<?php echo esc_url($button_url); ?>" class="regular-text"></td>
        </tr>
    </table>
    <p class="description">Use "Featured Image" (on the right sidebar) to upload the banner background image.</p>
    <?php
}

function sgharem_save_banner_meta($post_id) {
    if (!isset($_POST['banner_nonce']) || !wp_verify_nonce($_POST['banner_nonce'], 'sgharem_banner_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('banner_heading', 'banner_description', 'banner_button_text', 'banner_button_url');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }

    $is_active = isset($_POST['banner_active']) ? '1' : '0';
    update_post_meta($post_id, '_banner_active', $is_active);
}
add_action('save_post_banner', 'sgharem_save_banner_meta');

// Get Active Banner
function sgharem_get_active_banner() {
    $banners = get_posts(array(
        'post_type' => 'banner',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_banner_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($banners)) {
        $banner = $banners[0];
        return array(
            'heading' => get_post_meta($banner->ID, '_banner_heading', true),
            'description' => get_post_meta($banner->ID, '_banner_description', true),
            'button_text' => get_post_meta($banner->ID, '_banner_button_text', true),
            'button_url' => get_post_meta($banner->ID, '_banner_button_url', true),
            'image_url' => get_the_post_thumbnail_url($banner->ID, 'full'),
        );
    }
    return false;
}

// Register SEO Text Custom Post Type
function sgharem_register_seotext_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'SEO Texts',
            'singular_name' => 'SEO Text',
            'add_new' => 'Add New SEO Text',
            'add_new_item' => 'Add New SEO Text',
            'edit_item' => 'Edit SEO Text',
            'all_items' => 'All SEO Texts',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-editor-paragraph',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('seo_text', $args);
}
add_action('init', 'sgharem_register_seotext_cpt');

// Add SEO Text Meta Boxes
function sgharem_seotext_meta_boxes() {
    add_meta_box(
        'seotext_settings',
        'SEO Text Settings',
        'sgharem_seotext_meta_callback',
        'seo_text',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_seotext_meta_boxes');

function sgharem_seotext_meta_callback($post) {
    wp_nonce_field('sgharem_seotext_nonce', 'seotext_nonce');

    $heading = get_post_meta($post->ID, '_seotext_heading', true);
    $content = get_post_meta($post->ID, '_seotext_content', true);
    $is_active = get_post_meta($post->ID, '_seotext_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="seotext_active">Active</label></th>
            <td><input type="checkbox" id="seotext_active" name="seotext_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="seotext_heading">Heading</label></th>
            <td><input type="text" id="seotext_heading" name="seotext_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="seotext_content">Content</label></th>
            <td><textarea id="seotext_content" name="seotext_content" rows="5" class="large-text"><?php echo esc_textarea($content); ?></textarea></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_seotext_meta($post_id) {
    if (!isset($_POST['seotext_nonce']) || !wp_verify_nonce($_POST['seotext_nonce'], 'sgharem_seotext_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['seotext_heading'])) {
        update_post_meta($post_id, '_seotext_heading', sanitize_text_field($_POST['seotext_heading']));
    }
    if (isset($_POST['seotext_content'])) {
        update_post_meta($post_id, '_seotext_content', sanitize_textarea_field($_POST['seotext_content']));
    }

    $is_active = isset($_POST['seotext_active']) ? '1' : '0';
    update_post_meta($post_id, '_seotext_active', $is_active);
}
add_action('save_post_seo_text', 'sgharem_save_seotext_meta');

// Get Active SEO Text
function sgharem_get_active_seotext() {
    $seotexts = get_posts(array(
        'post_type' => 'seo_text',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_seotext_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($seotexts)) {
        $seotext = $seotexts[0];
        return array(
            'heading' => get_post_meta($seotext->ID, '_seotext_heading', true),
            'content' => get_post_meta($seotext->ID, '_seotext_content', true),
        );
    }
    return false;
}

// Register Gallery Custom Post Type
function sgharem_register_gallery_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Gallery',
            'singular_name' => 'Gallery Image',
            'add_new' => 'Add New Image',
            'add_new_item' => 'Add New Gallery Image',
            'edit_item' => 'Edit Gallery Image',
            'all_items' => 'All Gallery Images',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => false,
    );
    register_post_type('gallery', $args);
}
add_action('init', 'sgharem_register_gallery_cpt');

// Add Gallery Meta Boxes
function sgharem_gallery_meta_boxes() {
    add_meta_box(
        'gallery_settings',
        'Gallery Settings',
        'sgharem_gallery_meta_callback',
        'gallery',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_gallery_meta_boxes');

function sgharem_gallery_meta_callback($post) {
    wp_nonce_field('sgharem_gallery_nonce', 'gallery_nonce');

    $link_url = get_post_meta($post->ID, '_gallery_link_url', true);
    $alt_text = get_post_meta($post->ID, '_gallery_alt_text', true);
    $is_active = get_post_meta($post->ID, '_gallery_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="gallery_active">Active</label></th>
            <td><input type="checkbox" id="gallery_active" name="gallery_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="gallery_link_url">Link URL</label></th>
            <td>
                <input type="url" id="gallery_link_url" name="gallery_link_url" value="<?php echo esc_url($link_url); ?>" class="regular-text">
                <?php if (!empty($link_url)) : ?>
                <button type="button" class="button gallery-copy-btn" data-url="<?php echo esc_url($link_url); ?>" style="margin-left:5px;">Copy</button>
                <span class="gallery-copy-msg" style="display:none; color:green; margin-left:10px;">Copied!</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label for="gallery_alt_text">Alt Text</label></th>
            <td><input type="text" id="gallery_alt_text" name="gallery_alt_text" value="<?php echo esc_attr($alt_text); ?>" class="regular-text"></td>
        </tr>
    </table>
    <p class="description">Use "Featured Image" (on the right sidebar) to upload the gallery image.</p>
    <script>
    jQuery(document).ready(function($) {
        $('.gallery-copy-btn').on('click', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var url = $btn.attr('data-url');
            var $msg = $btn.next('.gallery-copy-msg');

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    $msg.fadeIn().delay(1500).fadeOut();
                }).catch(function() {
                    galleryCopyFallback(url, $msg);
                });
            } else {
                galleryCopyFallback(url, $msg);
            }
        });

        function galleryCopyFallback(text, $msg) {
            var textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-9999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                $msg.fadeIn().delay(1500).fadeOut();
            } catch (err) {
                alert('Copy failed. Please copy manually: ' + text);
            }
            document.body.removeChild(textArea);
        }
    });
    </script>
    <?php
}

function sgharem_save_gallery_meta($post_id) {
    if (!isset($_POST['gallery_nonce']) || !wp_verify_nonce($_POST['gallery_nonce'], 'sgharem_gallery_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['gallery_link_url'])) {
        update_post_meta($post_id, '_gallery_link_url', esc_url_raw($_POST['gallery_link_url']));
    }
    if (isset($_POST['gallery_alt_text'])) {
        update_post_meta($post_id, '_gallery_alt_text', sanitize_text_field($_POST['gallery_alt_text']));
    }

    $is_active = isset($_POST['gallery_active']) ? '1' : '0';
    update_post_meta($post_id, '_gallery_active', $is_active);
}
add_action('save_post_gallery', 'sgharem_save_gallery_meta');

// Add custom columns to Gallery list
function sgharem_gallery_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['gallery_link'] = 'Link URL';
            $new_columns['gallery_copy'] = 'Copy';
        }
    }
    return $new_columns;
}
add_filter('manage_gallery_posts_columns', 'sgharem_gallery_columns');

function sgharem_gallery_column_content($column, $post_id) {
    if ($column === 'gallery_link') {
        $link_url = get_post_meta($post_id, '_gallery_link_url', true);
        if (!empty($link_url)) {
            echo '<code style="font-size:11px;max-width:200px;display:inline-block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' . esc_html($link_url) . '</code>';
        } else {
            echo '—';
        }
    }
    if ($column === 'gallery_copy') {
        $link_url = get_post_meta($post_id, '_gallery_link_url', true);
        if (!empty($link_url)) {
            echo '<button type="button" class="button button-small gallery-list-copy" data-url="' . esc_url($link_url) . '">Copy</button>';
        } else {
            echo '—';
        }
    }
}
add_action('manage_gallery_posts_custom_column', 'sgharem_gallery_column_content', 10, 2);

// Add copy script to Gallery list page
function sgharem_gallery_admin_scripts() {
    global $post_type, $pagenow;
    if ($pagenow === 'edit.php' && $post_type === 'gallery') {
        ?>
        <script>
        jQuery(document).ready(function($) {
            $('.gallery-list-copy').on('click', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var url = $btn.attr('data-url');

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(function() {
                        $btn.text('Copied!').css('color', 'green');
                        setTimeout(function() {
                            $btn.text('Copy').css('color', '');
                        }, 1500);
                    }).catch(function() {
                        fallbackCopy(url, $btn);
                    });
                } else {
                    fallbackCopy(url, $btn);
                }
            });

            function fallbackCopy(text, $btn) {
                var textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-9999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    $btn.text('Copied!').css('color', 'green');
                    setTimeout(function() {
                        $btn.text('Copy').css('color', '');
                    }, 1500);
                } catch (err) {
                    alert('Copy failed. Please copy manually: ' + text);
                }
                document.body.removeChild(textArea);
            }
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'sgharem_gallery_admin_scripts');

// Add Duplicate link to Gallery row actions
function sgharem_gallery_row_actions($actions, $post) {
    if ($post->post_type === 'gallery') {
        $duplicate_url = wp_nonce_url(
            admin_url('admin.php?action=sgharem_duplicate_gallery&post=' . $post->ID),
            'sgharem_duplicate_gallery_' . $post->ID
        );
        $actions['duplicate'] = '<a href="' . esc_url($duplicate_url) . '" title="Duplicate this item">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'sgharem_gallery_row_actions', 10, 2);

// Handle Gallery duplicate action
function sgharem_duplicate_gallery_action() {
    if (!isset($_GET['post']) || !isset($_GET['_wpnonce'])) {
        wp_die('Invalid request.');
    }

    $post_id = intval($_GET['post']);

    if (!wp_verify_nonce($_GET['_wpnonce'], 'sgharem_duplicate_gallery_' . $post_id)) {
        wp_die('Security check failed.');
    }

    if (!current_user_can('edit_posts')) {
        wp_die('You do not have permission to duplicate posts.');
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'gallery') {
        wp_die('Post not found.');
    }

    // Create duplicate post
    $new_post = array(
        'post_title'   => $post->post_title . ' (Copy)',
        'post_status'  => 'draft',
        'post_type'    => $post->post_type,
        'post_author'  => get_current_user_id(),
    );

    $new_post_id = wp_insert_post($new_post);

    if ($new_post_id) {
        // Copy all meta data
        $meta_keys = array('_gallery_link_url', '_gallery_alt_text', '_gallery_active');
        foreach ($meta_keys as $key) {
            $value = get_post_meta($post_id, $key, true);
            if ($value) {
                update_post_meta($new_post_id, $key, $value);
            }
        }

        // Copy featured image
        $thumbnail_id = get_post_thumbnail_id($post_id);
        if ($thumbnail_id) {
            set_post_thumbnail($new_post_id, $thumbnail_id);
        }

        // Redirect to edit the new post
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    }

    wp_redirect(admin_url('edit.php?post_type=gallery'));
    exit;
}
add_action('admin_action_sgharem_duplicate_gallery', 'sgharem_duplicate_gallery_action');

// Get Active Gallery Images
function sgharem_get_gallery_images() {
    $images = get_posts(array(
        'post_type' => 'gallery',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_gallery_active',
                'value' => '1',
            )
        )
    ));

    $gallery = array();
    foreach ($images as $image) {
        $thumbnail_id = get_post_thumbnail_id($image->ID);
        if ($thumbnail_id) {
            $gallery[] = array(
                'image_url' => get_the_post_thumbnail_url($image->ID, 'large'),
                'link_url' => get_post_meta($image->ID, '_gallery_link_url', true),
                'alt_text' => get_post_meta($image->ID, '_gallery_alt_text', true),
                'title' => get_the_title($image->ID),
            );
        }
    }
    return $gallery;
}

// Get Gallery Section Settings
function sgharem_register_gallery_section_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Gallery Section',
            'singular_name' => 'Gallery Section',
            'add_new' => 'Add Gallery Section',
            'edit_item' => 'Edit Gallery Section',
            'all_items' => 'Gallery Section Settings',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=gallery',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('gallery_section', $args);
}
add_action('init', 'sgharem_register_gallery_section_cpt');

function sgharem_gallery_section_meta_boxes() {
    add_meta_box(
        'gallery_section_settings',
        'Section Settings',
        'sgharem_gallery_section_meta_callback',
        'gallery_section',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_gallery_section_meta_boxes');

function sgharem_gallery_section_meta_callback($post) {
    wp_nonce_field('sgharem_gallery_section_nonce', 'gallery_section_nonce');
    $heading = get_post_meta($post->ID, '_gallery_section_heading', true);
    $is_active = get_post_meta($post->ID, '_gallery_section_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="gallery_section_active">Active</label></th>
            <td><input type="checkbox" id="gallery_section_active" name="gallery_section_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="gallery_section_heading">Section Heading</label></th>
            <td><input type="text" id="gallery_section_heading" name="gallery_section_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_gallery_section_meta($post_id) {
    if (!isset($_POST['gallery_section_nonce']) || !wp_verify_nonce($_POST['gallery_section_nonce'], 'sgharem_gallery_section_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['gallery_section_heading'])) {
        update_post_meta($post_id, '_gallery_section_heading', sanitize_text_field($_POST['gallery_section_heading']));
    }
    $is_active = isset($_POST['gallery_section_active']) ? '1' : '0';
    update_post_meta($post_id, '_gallery_section_active', $is_active);
}
add_action('save_post_gallery_section', 'sgharem_save_gallery_section_meta');

function sgharem_get_gallery_section() {
    $sections = get_posts(array(
        'post_type' => 'gallery_section',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_gallery_section_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($sections)) {
        return array(
            'heading' => get_post_meta($sections[0]->ID, '_gallery_section_heading', true),
        );
    }
    return false;
}

// Enable featured image support
add_theme_support('post-thumbnails');

// Register Quick Links Custom Post Type
function sgharem_register_quicklinks_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Quick Links',
            'singular_name' => 'Quick Link',
            'add_new' => 'Add New Link',
            'add_new_item' => 'Add New Quick Link',
            'edit_item' => 'Edit Quick Link',
            'all_items' => 'All Quick Links',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-admin-links',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => false,
    );
    register_post_type('quick_link', $args);
}
add_action('init', 'sgharem_register_quicklinks_cpt');

// Add Quick Links Meta Boxes
function sgharem_quicklinks_meta_boxes() {
    add_meta_box(
        'quicklink_settings',
        'Quick Link Settings',
        'sgharem_quicklinks_meta_callback',
        'quick_link',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_quicklinks_meta_boxes');

function sgharem_quicklinks_meta_callback($post) {
    wp_nonce_field('sgharem_quicklink_nonce', 'quicklink_nonce');

    $link_url = get_post_meta($post->ID, '_quicklink_url', true);
    $description = get_post_meta($post->ID, '_quicklink_description', true);
    $button_text = get_post_meta($post->ID, '_quicklink_button_text', true);
    $is_active = get_post_meta($post->ID, '_quicklink_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="quicklink_active">Active</label></th>
            <td><input type="checkbox" id="quicklink_active" name="quicklink_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="quicklink_url">Link URL</label></th>
            <td><input type="url" id="quicklink_url" name="quicklink_url" value="<?php echo esc_url($link_url); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="quicklink_description">Description</label></th>
            <td><textarea id="quicklink_description" name="quicklink_description" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="quicklink_button_text">Button Text</label></th>
            <td><input type="text" id="quicklink_button_text" name="quicklink_button_text" value="<?php echo esc_attr($button_text); ?>" class="regular-text" placeholder="e.g. Website"></td>
        </tr>
    </table>
    <p class="description">Use "Featured Image" to set the card image.</p>
    <?php
}

function sgharem_save_quicklink_meta($post_id) {
    if (!isset($_POST['quicklink_nonce']) || !wp_verify_nonce($_POST['quicklink_nonce'], 'sgharem_quicklink_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['quicklink_url'])) {
        update_post_meta($post_id, '_quicklink_url', esc_url_raw($_POST['quicklink_url']));
    }
    if (isset($_POST['quicklink_description'])) {
        update_post_meta($post_id, '_quicklink_description', sanitize_textarea_field($_POST['quicklink_description']));
    }
    if (isset($_POST['quicklink_button_text'])) {
        update_post_meta($post_id, '_quicklink_button_text', sanitize_text_field($_POST['quicklink_button_text']));
    }

    $is_active = isset($_POST['quicklink_active']) ? '1' : '0';
    update_post_meta($post_id, '_quicklink_active', $is_active);
}
add_action('save_post_quick_link', 'sgharem_save_quicklink_meta');

// Add Duplicate link to Quick Link row actions
function sgharem_quicklink_row_actions($actions, $post) {
    if ($post->post_type === 'quick_link') {
        $duplicate_url = wp_nonce_url(
            admin_url('admin.php?action=sgharem_duplicate_quicklink&post=' . $post->ID),
            'sgharem_duplicate_quicklink_' . $post->ID
        );
        $actions['duplicate'] = '<a href="' . esc_url($duplicate_url) . '" title="Duplicate this item">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'sgharem_quicklink_row_actions', 10, 2);

// Handle Quick Link duplicate action
function sgharem_duplicate_quicklink_action() {
    if (!isset($_GET['post']) || !isset($_GET['_wpnonce'])) {
        wp_die('Invalid request.');
    }

    $post_id = intval($_GET['post']);

    if (!wp_verify_nonce($_GET['_wpnonce'], 'sgharem_duplicate_quicklink_' . $post_id)) {
        wp_die('Security check failed.');
    }

    if (!current_user_can('edit_posts')) {
        wp_die('You do not have permission to duplicate posts.');
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'quick_link') {
        wp_die('Post not found.');
    }

    // Create duplicate post
    $new_post = array(
        'post_title'   => $post->post_title . ' (Copy)',
        'post_status'  => 'draft',
        'post_type'    => $post->post_type,
        'post_author'  => get_current_user_id(),
        'menu_order'   => $post->menu_order,
    );

    $new_post_id = wp_insert_post($new_post);

    if ($new_post_id) {
        // Copy all meta data
        $meta_keys = array('_quicklink_url', '_quicklink_description', '_quicklink_button_text', '_quicklink_active');
        foreach ($meta_keys as $key) {
            $value = get_post_meta($post_id, $key, true);
            if ($value) {
                update_post_meta($new_post_id, $key, $value);
            }
        }

        // Copy featured image
        $thumbnail_id = get_post_thumbnail_id($post_id);
        if ($thumbnail_id) {
            set_post_thumbnail($new_post_id, $thumbnail_id);
        }

        // Redirect to edit the new post
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    }

    wp_redirect(admin_url('edit.php?post_type=quick_link'));
    exit;
}
add_action('admin_action_sgharem_duplicate_quicklink', 'sgharem_duplicate_quicklink_action');

// Get Active Quick Links
function sgharem_get_quick_links() {
    $links = get_posts(array(
        'post_type' => 'quick_link',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_quicklink_active',
                'value' => '1',
            )
        )
    ));

    $quick_links = array();
    foreach ($links as $link) {
        $quick_links[] = array(
            'title' => get_the_title($link->ID),
            'url' => get_post_meta($link->ID, '_quicklink_url', true),
            'description' => get_post_meta($link->ID, '_quicklink_description', true),
            'button_text' => get_post_meta($link->ID, '_quicklink_button_text', true),
            'image_url' => get_the_post_thumbnail_url($link->ID, 'medium'),
        );
    }
    return $quick_links;
}

// Quick Links Section Settings
function sgharem_register_quicklinks_section_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Section Settings',
            'singular_name' => 'Section Settings',
            'add_new' => 'Add Section Settings',
            'edit_item' => 'Edit Section Settings',
            'all_items' => 'Section Settings',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=quick_link',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('quicklink_section', $args);
}
add_action('init', 'sgharem_register_quicklinks_section_cpt');

function sgharem_quicklinks_section_meta_boxes() {
    add_meta_box(
        'quicklink_section_settings',
        'Section Settings',
        'sgharem_quicklinks_section_meta_callback',
        'quicklink_section',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_quicklinks_section_meta_boxes');

function sgharem_quicklinks_section_meta_callback($post) {
    wp_nonce_field('sgharem_quicklink_section_nonce', 'quicklink_section_nonce');
    $heading = get_post_meta($post->ID, '_quicklink_section_heading', true);
    $is_active = get_post_meta($post->ID, '_quicklink_section_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="quicklink_section_active">Active</label></th>
            <td><input type="checkbox" id="quicklink_section_active" name="quicklink_section_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="quicklink_section_heading">Section Heading</label></th>
            <td><input type="text" id="quicklink_section_heading" name="quicklink_section_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_quicklinks_section_meta($post_id) {
    if (!isset($_POST['quicklink_section_nonce']) || !wp_verify_nonce($_POST['quicklink_section_nonce'], 'sgharem_quicklink_section_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['quicklink_section_heading'])) {
        update_post_meta($post_id, '_quicklink_section_heading', sanitize_text_field($_POST['quicklink_section_heading']));
    }
    $is_active = isset($_POST['quicklink_section_active']) ? '1' : '0';
    update_post_meta($post_id, '_quicklink_section_active', $is_active);
}
add_action('save_post_quicklink_section', 'sgharem_save_quicklinks_section_meta');

function sgharem_get_quicklinks_section() {
    $sections = get_posts(array(
        'post_type' => 'quicklink_section',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_quicklink_section_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($sections)) {
        return array(
            'heading' => get_post_meta($sections[0]->ID, '_quicklink_section_heading', true),
        );
    }
    return false;
}

// Register Regions Custom Post Type
function sgharem_register_regions_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Regions',
            'singular_name' => 'Region',
            'add_new' => 'Add New Region',
            'add_new_item' => 'Add New Region',
            'edit_item' => 'Edit Region',
            'all_items' => 'All Regions',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-location',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('region', $args);
}
add_action('init', 'sgharem_register_regions_cpt');

// Add Regions Meta Boxes
function sgharem_regions_meta_boxes() {
    add_meta_box(
        'region_settings',
        'Region Settings',
        'sgharem_regions_meta_callback',
        'region',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_regions_meta_boxes');

function sgharem_regions_meta_callback($post) {
    wp_nonce_field('sgharem_region_nonce', 'region_nonce');

    $link_url = get_post_meta($post->ID, '_region_url', true);
    $description = get_post_meta($post->ID, '_region_description', true);
    $button_text = get_post_meta($post->ID, '_region_button_text', true);
    $icon = get_post_meta($post->ID, '_region_icon', true);
    $is_active = get_post_meta($post->ID, '_region_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="region_active">Active</label></th>
            <td><input type="checkbox" id="region_active" name="region_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="region_icon">Icon (emoji)</label></th>
            <td><input type="text" id="region_icon" name="region_icon" value="<?php echo esc_attr($icon); ?>" class="regular-text" placeholder="e.g. 🏙️"></td>
        </tr>
        <tr>
            <th><label for="region_url">Link URL</label></th>
            <td><input type="url" id="region_url" name="region_url" value="<?php echo esc_url($link_url); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="region_description">Description</label></th>
            <td><textarea id="region_description" name="region_description" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="region_button_text">Button Text</label></th>
            <td><input type="text" id="region_button_text" name="region_button_text" value="<?php echo esc_attr($button_text); ?>" class="regular-text" placeholder="e.g. View Region"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_region_meta($post_id) {
    if (!isset($_POST['region_nonce']) || !wp_verify_nonce($_POST['region_nonce'], 'sgharem_region_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('region_url', 'region_description', 'region_button_text', 'region_icon');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'region_url') {
                update_post_meta($post_id, '_' . $field, esc_url_raw($_POST[$field]));
            } elseif ($field === 'region_description') {
                update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
            } else {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    $is_active = isset($_POST['region_active']) ? '1' : '0';
    update_post_meta($post_id, '_region_active', $is_active);
}
add_action('save_post_region', 'sgharem_save_region_meta');

// Add Duplicate link to Region row actions
function sgharem_region_row_actions($actions, $post) {
    if ($post->post_type === 'region') {
        $duplicate_url = wp_nonce_url(
            admin_url('admin.php?action=sgharem_duplicate_region&post=' . $post->ID),
            'sgharem_duplicate_region_' . $post->ID
        );
        $actions['duplicate'] = '<a href="' . esc_url($duplicate_url) . '" title="Duplicate this item">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'sgharem_region_row_actions', 10, 2);

// Handle Region duplicate action
function sgharem_duplicate_region_action() {
    if (!isset($_GET['post']) || !isset($_GET['_wpnonce'])) {
        wp_die('Invalid request.');
    }

    $post_id = intval($_GET['post']);

    if (!wp_verify_nonce($_GET['_wpnonce'], 'sgharem_duplicate_region_' . $post_id)) {
        wp_die('Security check failed.');
    }

    if (!current_user_can('edit_posts')) {
        wp_die('You do not have permission to duplicate posts.');
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'region') {
        wp_die('Post not found.');
    }

    // Create duplicate post
    $new_post = array(
        'post_title'   => $post->post_title . ' (Copy)',
        'post_status'  => 'draft',
        'post_type'    => $post->post_type,
        'post_author'  => get_current_user_id(),
        'menu_order'   => $post->menu_order,
    );

    $new_post_id = wp_insert_post($new_post);

    if ($new_post_id) {
        // Copy all meta data
        $meta_keys = array('_region_url', '_region_description', '_region_button_text', '_region_icon', '_region_active');
        foreach ($meta_keys as $key) {
            $value = get_post_meta($post_id, $key, true);
            if ($value) {
                update_post_meta($new_post_id, $key, $value);
            }
        }

        // Redirect to edit the new post
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    }

    wp_redirect(admin_url('edit.php?post_type=region'));
    exit;
}
add_action('admin_action_sgharem_duplicate_region', 'sgharem_duplicate_region_action');

// Get Active Regions
function sgharem_get_regions() {
    $regions = get_posts(array(
        'post_type' => 'region',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_region_active',
                'value' => '1',
            )
        )
    ));

    $items = array();
    foreach ($regions as $region) {
        $items[] = array(
            'title' => get_the_title($region->ID),
            'url' => get_post_meta($region->ID, '_region_url', true),
            'description' => get_post_meta($region->ID, '_region_description', true),
            'button_text' => get_post_meta($region->ID, '_region_button_text', true),
            'icon' => get_post_meta($region->ID, '_region_icon', true),
        );
    }
    return $items;
}

// Regions Section Settings
function sgharem_register_regions_section_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Section Settings',
            'singular_name' => 'Section Settings',
            'add_new' => 'Add Section Settings',
            'edit_item' => 'Edit Section Settings',
            'all_items' => 'Section Settings',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=region',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('region_section', $args);
}
add_action('init', 'sgharem_register_regions_section_cpt');

function sgharem_regions_section_meta_boxes() {
    add_meta_box(
        'region_section_settings',
        'Section Settings',
        'sgharem_regions_section_meta_callback',
        'region_section',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_regions_section_meta_boxes');

function sgharem_regions_section_meta_callback($post) {
    wp_nonce_field('sgharem_region_section_nonce', 'region_section_nonce');
    $heading = get_post_meta($post->ID, '_region_section_heading', true);
    $subtitle = get_post_meta($post->ID, '_region_section_subtitle', true);
    $is_active = get_post_meta($post->ID, '_region_section_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="region_section_active">Active</label></th>
            <td><input type="checkbox" id="region_section_active" name="region_section_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="region_section_heading">Section Heading</label></th>
            <td><input type="text" id="region_section_heading" name="region_section_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="region_section_subtitle">Section Subtitle</label></th>
            <td><input type="text" id="region_section_subtitle" name="region_section_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_regions_section_meta($post_id) {
    if (!isset($_POST['region_section_nonce']) || !wp_verify_nonce($_POST['region_section_nonce'], 'sgharem_region_section_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['region_section_heading'])) {
        update_post_meta($post_id, '_region_section_heading', sanitize_text_field($_POST['region_section_heading']));
    }
    if (isset($_POST['region_section_subtitle'])) {
        update_post_meta($post_id, '_region_section_subtitle', sanitize_text_field($_POST['region_section_subtitle']));
    }
    $is_active = isset($_POST['region_section_active']) ? '1' : '0';
    update_post_meta($post_id, '_region_section_active', $is_active);
}
add_action('save_post_region_section', 'sgharem_save_regions_section_meta');

function sgharem_get_regions_section() {
    $sections = get_posts(array(
        'post_type' => 'region_section',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_region_section_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($sections)) {
        return array(
            'heading' => get_post_meta($sections[0]->ID, '_region_section_heading', true),
            'subtitle' => get_post_meta($sections[0]->ID, '_region_section_subtitle', true),
        );
    }
    return false;
}

// Register Services Custom Post Type
function sgharem_register_services_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new' => 'Add New Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'all_items' => 'All Services',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-hammer',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => false,
    );
    register_post_type('service', $args);
}
add_action('init', 'sgharem_register_services_cpt');

// Add Services Meta Boxes
function sgharem_services_meta_boxes() {
    add_meta_box(
        'service_settings',
        'Service Settings',
        'sgharem_services_meta_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_services_meta_boxes');

function sgharem_services_meta_callback($post) {
    wp_nonce_field('sgharem_service_nonce', 'service_nonce');

    $link_url = get_post_meta($post->ID, '_service_url', true);
    $description = get_post_meta($post->ID, '_service_description', true);
    $button_text = get_post_meta($post->ID, '_service_button_text', true);
    $is_active = get_post_meta($post->ID, '_service_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="service_active">Active</label></th>
            <td><input type="checkbox" id="service_active" name="service_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="service_url">Link URL</label></th>
            <td><input type="url" id="service_url" name="service_url" value="<?php echo esc_url($link_url); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="service_description">Description</label></th>
            <td><textarea id="service_description" name="service_description" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="service_button_text">Button Text</label></th>
            <td><input type="text" id="service_button_text" name="service_button_text" value="<?php echo esc_attr($button_text); ?>" class="regular-text" placeholder="e.g. View Service"></td>
        </tr>
    </table>
    <p class="description">Use "Featured Image" to set the service image.</p>
    <?php
}

function sgharem_save_service_meta($post_id) {
    if (!isset($_POST['service_nonce']) || !wp_verify_nonce($_POST['service_nonce'], 'sgharem_service_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['service_url'])) {
        update_post_meta($post_id, '_service_url', esc_url_raw($_POST['service_url']));
    }
    if (isset($_POST['service_description'])) {
        update_post_meta($post_id, '_service_description', sanitize_textarea_field($_POST['service_description']));
    }
    if (isset($_POST['service_button_text'])) {
        update_post_meta($post_id, '_service_button_text', sanitize_text_field($_POST['service_button_text']));
    }

    $is_active = isset($_POST['service_active']) ? '1' : '0';
    update_post_meta($post_id, '_service_active', $is_active);
}
add_action('save_post_service', 'sgharem_save_service_meta');

// Add Duplicate link to Service row actions
function sgharem_service_row_actions($actions, $post) {
    if ($post->post_type === 'service') {
        $duplicate_url = wp_nonce_url(
            admin_url('admin.php?action=sgharem_duplicate_service&post=' . $post->ID),
            'sgharem_duplicate_service_' . $post->ID
        );
        $actions['duplicate'] = '<a href="' . esc_url($duplicate_url) . '" title="Duplicate this item">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'sgharem_service_row_actions', 10, 2);

// Handle Service duplicate action
function sgharem_duplicate_service_action() {
    if (!isset($_GET['post']) || !isset($_GET['_wpnonce'])) {
        wp_die('Invalid request.');
    }

    $post_id = intval($_GET['post']);

    if (!wp_verify_nonce($_GET['_wpnonce'], 'sgharem_duplicate_service_' . $post_id)) {
        wp_die('Security check failed.');
    }

    if (!current_user_can('edit_posts')) {
        wp_die('You do not have permission to duplicate posts.');
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'service') {
        wp_die('Post not found.');
    }

    // Create duplicate post
    $new_post = array(
        'post_title'   => $post->post_title . ' (Copy)',
        'post_status'  => 'draft',
        'post_type'    => $post->post_type,
        'post_author'  => get_current_user_id(),
        'menu_order'   => $post->menu_order,
    );

    $new_post_id = wp_insert_post($new_post);

    if ($new_post_id) {
        // Copy all meta data
        $meta_keys = array('_service_url', '_service_description', '_service_button_text', '_service_active');
        foreach ($meta_keys as $key) {
            $value = get_post_meta($post_id, $key, true);
            if ($value) {
                update_post_meta($new_post_id, $key, $value);
            }
        }

        // Copy featured image
        $thumbnail_id = get_post_thumbnail_id($post_id);
        if ($thumbnail_id) {
            set_post_thumbnail($new_post_id, $thumbnail_id);
        }

        // Redirect to edit the new post
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    }

    wp_redirect(admin_url('edit.php?post_type=service'));
    exit;
}
add_action('admin_action_sgharem_duplicate_service', 'sgharem_duplicate_service_action');

// Get Active Services
function sgharem_get_services() {
    $services = get_posts(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_service_active',
                'value' => '1',
            )
        )
    ));

    $items = array();
    foreach ($services as $service) {
        $items[] = array(
            'title' => get_the_title($service->ID),
            'url' => get_post_meta($service->ID, '_service_url', true),
            'description' => get_post_meta($service->ID, '_service_description', true),
            'button_text' => get_post_meta($service->ID, '_service_button_text', true),
            'image_url' => get_the_post_thumbnail_url($service->ID, 'medium'),
        );
    }
    return $items;
}

// Services Section Settings
function sgharem_register_services_section_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Section Settings',
            'singular_name' => 'Section Settings',
            'add_new' => 'Add Section Settings',
            'edit_item' => 'Edit Section Settings',
            'all_items' => 'Section Settings',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=service',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('service_section', $args);
}
add_action('init', 'sgharem_register_services_section_cpt');

function sgharem_services_section_meta_boxes() {
    add_meta_box(
        'service_section_settings',
        'Section Settings',
        'sgharem_services_section_meta_callback',
        'service_section',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_services_section_meta_boxes');

function sgharem_services_section_meta_callback($post) {
    wp_nonce_field('sgharem_service_section_nonce', 'service_section_nonce');
    $heading = get_post_meta($post->ID, '_service_section_heading', true);
    $subtitle = get_post_meta($post->ID, '_service_section_subtitle', true);
    $is_active = get_post_meta($post->ID, '_service_section_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="service_section_active">Active</label></th>
            <td><input type="checkbox" id="service_section_active" name="service_section_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="service_section_heading">Section Heading</label></th>
            <td><input type="text" id="service_section_heading" name="service_section_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="service_section_subtitle">Section Subtitle</label></th>
            <td><input type="text" id="service_section_subtitle" name="service_section_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_services_section_meta($post_id) {
    if (!isset($_POST['service_section_nonce']) || !wp_verify_nonce($_POST['service_section_nonce'], 'sgharem_service_section_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['service_section_heading'])) {
        update_post_meta($post_id, '_service_section_heading', sanitize_text_field($_POST['service_section_heading']));
    }
    if (isset($_POST['service_section_subtitle'])) {
        update_post_meta($post_id, '_service_section_subtitle', sanitize_text_field($_POST['service_section_subtitle']));
    }
    $is_active = isset($_POST['service_section_active']) ? '1' : '0';
    update_post_meta($post_id, '_service_section_active', $is_active);
}
add_action('save_post_service_section', 'sgharem_save_services_section_meta');

function sgharem_get_services_section() {
    $sections = get_posts(array(
        'post_type' => 'service_section',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_service_section_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($sections)) {
        return array(
            'heading' => get_post_meta($sections[0]->ID, '_service_section_heading', true),
            'subtitle' => get_post_meta($sections[0]->ID, '_service_section_subtitle', true),
        );
    }
    return false;
}

// Register Contact Custom Post Type
function sgharem_register_contact_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Contact',
            'singular_name' => 'Contact',
            'add_new' => 'Add Contact',
            'add_new_item' => 'Add New Contact',
            'edit_item' => 'Edit Contact',
            'all_items' => 'All Contacts',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('contact', $args);
}
add_action('init', 'sgharem_register_contact_cpt');

// Add Contact Meta Boxes
function sgharem_contact_meta_boxes() {
    add_meta_box(
        'contact_settings',
        'Contact Settings',
        'sgharem_contact_meta_callback',
        'contact',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_contact_meta_boxes');

function sgharem_contact_meta_callback($post) {
    wp_nonce_field('sgharem_contact_nonce', 'contact_nonce');

    $heading = get_post_meta($post->ID, '_contact_heading', true);
    $description = get_post_meta($post->ID, '_contact_description', true);
    $btn1_icon = get_post_meta($post->ID, '_contact_btn1_icon', true);
    $btn1_text = get_post_meta($post->ID, '_contact_btn1_text', true);
    $btn1_url = get_post_meta($post->ID, '_contact_btn1_url', true);
    $btn2_icon = get_post_meta($post->ID, '_contact_btn2_icon', true);
    $btn2_text = get_post_meta($post->ID, '_contact_btn2_text', true);
    $btn2_url = get_post_meta($post->ID, '_contact_btn2_url', true);
    $is_active = get_post_meta($post->ID, '_contact_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="contact_active">Active</label></th>
            <td><input type="checkbox" id="contact_active" name="contact_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="contact_heading">Heading</label></th>
            <td><input type="text" id="contact_heading" name="contact_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="contact_description">Description</label></th>
            <td><textarea id="contact_description" name="contact_description" rows="2" class="large-text"><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
        <tr>
            <th colspan="2"><h3>Button 1 (Website)</h3></th>
        </tr>
        <tr>
            <th><label for="contact_btn1_icon">Icon (emoji)</label></th>
            <td><input type="text" id="contact_btn1_icon" name="contact_btn1_icon" value="<?php echo esc_attr($btn1_icon); ?>" class="regular-text" placeholder="e.g. 🌐"></td>
        </tr>
        <tr>
            <th><label for="contact_btn1_text">Button Text</label></th>
            <td><input type="text" id="contact_btn1_text" name="contact_btn1_text" value="<?php echo esc_attr($btn1_text); ?>" class="regular-text" placeholder="e.g. Enter SGHarem"></td>
        </tr>
        <tr>
            <th><label for="contact_btn1_url">Button URL</label></th>
            <td><input type="url" id="contact_btn1_url" name="contact_btn1_url" value="<?php echo esc_url($btn1_url); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th colspan="2"><h3>Button 2 (Telegram)</h3></th>
        </tr>
        <tr>
            <th><label for="contact_btn2_icon">Icon (emoji)</label></th>
            <td><input type="text" id="contact_btn2_icon" name="contact_btn2_icon" value="<?php echo esc_attr($btn2_icon); ?>" class="regular-text" placeholder="e.g. 📱"></td>
        </tr>
        <tr>
            <th><label for="contact_btn2_text">Button Text</label></th>
            <td><input type="text" id="contact_btn2_text" name="contact_btn2_text" value="<?php echo esc_attr($btn2_text); ?>" class="regular-text" placeholder="e.g. Join Telegram"></td>
        </tr>
        <tr>
            <th><label for="contact_btn2_url">Button URL</label></th>
            <td><input type="url" id="contact_btn2_url" name="contact_btn2_url" value="<?php echo esc_url($btn2_url); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_contact_meta($post_id) {
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'sgharem_contact_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['contact_heading'])) {
        update_post_meta($post_id, '_contact_heading', sanitize_text_field($_POST['contact_heading']));
    }
    if (isset($_POST['contact_description'])) {
        update_post_meta($post_id, '_contact_description', sanitize_textarea_field($_POST['contact_description']));
    }

    // Button 1
    $btn1_fields = array('contact_btn1_icon', 'contact_btn1_text');
    foreach ($btn1_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    if (isset($_POST['contact_btn1_url'])) {
        update_post_meta($post_id, '_contact_btn1_url', esc_url_raw($_POST['contact_btn1_url']));
    }

    // Button 2
    $btn2_fields = array('contact_btn2_icon', 'contact_btn2_text');
    foreach ($btn2_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    if (isset($_POST['contact_btn2_url'])) {
        update_post_meta($post_id, '_contact_btn2_url', esc_url_raw($_POST['contact_btn2_url']));
    }

    $is_active = isset($_POST['contact_active']) ? '1' : '0';
    update_post_meta($post_id, '_contact_active', $is_active);
}
add_action('save_post_contact', 'sgharem_save_contact_meta');

// Get Active Contact
function sgharem_get_contact() {
    $contacts = get_posts(array(
        'post_type' => 'contact',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_contact_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($contacts)) {
        $contact = $contacts[0];
        return array(
            'heading' => get_post_meta($contact->ID, '_contact_heading', true),
            'description' => get_post_meta($contact->ID, '_contact_description', true),
            'btn1_icon' => get_post_meta($contact->ID, '_contact_btn1_icon', true),
            'btn1_text' => get_post_meta($contact->ID, '_contact_btn1_text', true),
            'btn1_url' => get_post_meta($contact->ID, '_contact_btn1_url', true),
            'btn2_icon' => get_post_meta($contact->ID, '_contact_btn2_icon', true),
            'btn2_text' => get_post_meta($contact->ID, '_contact_btn2_text', true),
            'btn2_url' => get_post_meta($contact->ID, '_contact_btn2_url', true),
        );
    }
    return false;
}

// Register FAQ Custom Post Type
function sgharem_register_faq_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'FAQs',
            'singular_name' => 'FAQ',
            'add_new' => 'Add New FAQ',
            'add_new_item' => 'Add New FAQ',
            'edit_item' => 'Edit FAQ',
            'all_items' => 'All FAQs',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('faq', $args);
}
add_action('init', 'sgharem_register_faq_cpt');

// Add FAQ Meta Boxes
function sgharem_faq_meta_boxes() {
    add_meta_box(
        'faq_settings',
        'FAQ Settings',
        'sgharem_faq_meta_callback',
        'faq',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_faq_meta_boxes');

function sgharem_faq_meta_callback($post) {
    wp_nonce_field('sgharem_faq_nonce', 'faq_nonce');

    $question = get_post_meta($post->ID, '_faq_question', true);
    $answer = get_post_meta($post->ID, '_faq_answer', true);
    $link_text = get_post_meta($post->ID, '_faq_link_text', true);
    $link_url = get_post_meta($post->ID, '_faq_link_url', true);
    $is_active = get_post_meta($post->ID, '_faq_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="faq_active">Active</label></th>
            <td><input type="checkbox" id="faq_active" name="faq_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="faq_question">Question</label></th>
            <td><input type="text" id="faq_question" name="faq_question" value="<?php echo esc_attr($question); ?>" class="large-text"></td>
        </tr>
        <tr>
            <th><label for="faq_answer">Answer</label></th>
            <td><textarea id="faq_answer" name="faq_answer" rows="4" class="large-text"><?php echo esc_textarea($answer); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="faq_link_text">Link Text (optional)</label></th>
            <td><input type="text" id="faq_link_text" name="faq_link_text" value="<?php echo esc_attr($link_text); ?>" class="regular-text" placeholder="e.g. Website"></td>
        </tr>
        <tr>
            <th><label for="faq_link_url">Link URL (optional)</label></th>
            <td><input type="url" id="faq_link_url" name="faq_link_url" value="<?php echo esc_url($link_url); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_faq_meta($post_id) {
    if (!isset($_POST['faq_nonce']) || !wp_verify_nonce($_POST['faq_nonce'], 'sgharem_faq_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['faq_question'])) {
        update_post_meta($post_id, '_faq_question', sanitize_text_field($_POST['faq_question']));
    }
    if (isset($_POST['faq_answer'])) {
        update_post_meta($post_id, '_faq_answer', sanitize_textarea_field($_POST['faq_answer']));
    }
    if (isset($_POST['faq_link_text'])) {
        update_post_meta($post_id, '_faq_link_text', sanitize_text_field($_POST['faq_link_text']));
    }
    if (isset($_POST['faq_link_url'])) {
        update_post_meta($post_id, '_faq_link_url', esc_url_raw($_POST['faq_link_url']));
    }

    $is_active = isset($_POST['faq_active']) ? '1' : '0';
    update_post_meta($post_id, '_faq_active', $is_active);
}
add_action('save_post_faq', 'sgharem_save_faq_meta');

// Add Duplicate link to FAQ row actions
function sgharem_faq_row_actions($actions, $post) {
    if ($post->post_type === 'faq') {
        $duplicate_url = wp_nonce_url(
            admin_url('admin.php?action=sgharem_duplicate_faq&post=' . $post->ID),
            'sgharem_duplicate_faq_' . $post->ID
        );
        $actions['duplicate'] = '<a href="' . esc_url($duplicate_url) . '" title="Duplicate this item">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'sgharem_faq_row_actions', 10, 2);

// Handle FAQ duplicate action
function sgharem_duplicate_faq_action() {
    if (!isset($_GET['post']) || !isset($_GET['_wpnonce'])) {
        wp_die('Invalid request.');
    }

    $post_id = intval($_GET['post']);

    if (!wp_verify_nonce($_GET['_wpnonce'], 'sgharem_duplicate_faq_' . $post_id)) {
        wp_die('Security check failed.');
    }

    if (!current_user_can('edit_posts')) {
        wp_die('You do not have permission to duplicate posts.');
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'faq') {
        wp_die('Post not found.');
    }

    // Create duplicate post
    $new_post = array(
        'post_title'   => $post->post_title . ' (Copy)',
        'post_status'  => 'draft',
        'post_type'    => $post->post_type,
        'post_author'  => get_current_user_id(),
        'menu_order'   => $post->menu_order,
    );

    $new_post_id = wp_insert_post($new_post);

    if ($new_post_id) {
        // Copy all meta data
        $meta_keys = array('_faq_question', '_faq_answer', '_faq_link_text', '_faq_link_url', '_faq_active');
        foreach ($meta_keys as $key) {
            $value = get_post_meta($post_id, $key, true);
            if ($value) {
                update_post_meta($new_post_id, $key, $value);
            }
        }

        // Redirect to edit the new post
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    }

    wp_redirect(admin_url('edit.php?post_type=faq'));
    exit;
}
add_action('admin_action_sgharem_duplicate_faq', 'sgharem_duplicate_faq_action');

// Get Active FAQs
function sgharem_get_faqs() {
    $faqs = get_posts(array(
        'post_type' => 'faq',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_faq_active',
                'value' => '1',
            )
        )
    ));

    $items = array();
    foreach ($faqs as $faq) {
        $items[] = array(
            'question' => get_post_meta($faq->ID, '_faq_question', true),
            'answer' => get_post_meta($faq->ID, '_faq_answer', true),
            'link_text' => get_post_meta($faq->ID, '_faq_link_text', true),
            'link_url' => get_post_meta($faq->ID, '_faq_link_url', true),
        );
    }
    return $items;
}

// FAQ Section Settings
function sgharem_register_faq_section_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Section Settings',
            'singular_name' => 'Section Settings',
            'add_new' => 'Add Section Settings',
            'edit_item' => 'Edit Section Settings',
            'all_items' => 'Section Settings',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=faq',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('faq_section', $args);
}
add_action('init', 'sgharem_register_faq_section_cpt');

function sgharem_faq_section_meta_boxes() {
    add_meta_box(
        'faq_section_settings',
        'Section Settings',
        'sgharem_faq_section_meta_callback',
        'faq_section',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_faq_section_meta_boxes');

function sgharem_faq_section_meta_callback($post) {
    wp_nonce_field('sgharem_faq_section_nonce', 'faq_section_nonce');
    $heading = get_post_meta($post->ID, '_faq_section_heading', true);
    $is_active = get_post_meta($post->ID, '_faq_section_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="faq_section_active">Active</label></th>
            <td><input type="checkbox" id="faq_section_active" name="faq_section_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="faq_section_heading">Section Heading</label></th>
            <td><input type="text" id="faq_section_heading" name="faq_section_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_faq_section_meta($post_id) {
    if (!isset($_POST['faq_section_nonce']) || !wp_verify_nonce($_POST['faq_section_nonce'], 'sgharem_faq_section_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['faq_section_heading'])) {
        update_post_meta($post_id, '_faq_section_heading', sanitize_text_field($_POST['faq_section_heading']));
    }
    $is_active = isset($_POST['faq_section_active']) ? '1' : '0';
    update_post_meta($post_id, '_faq_section_active', $is_active);
}
add_action('save_post_faq_section', 'sgharem_save_faq_section_meta');

function sgharem_get_faq_section() {
    $sections = get_posts(array(
        'post_type' => 'faq_section',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_faq_section_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($sections)) {
        return array(
            'heading' => get_post_meta($sections[0]->ID, '_faq_section_heading', true),
        );
    }
    return false;
}

// Register Footer Links Custom Post Type
function sgharem_register_footer_link_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Footer',
            'singular_name' => 'Footer Link',
            'add_new' => 'Add New Link',
            'add_new_item' => 'Add New Footer Link',
            'edit_item' => 'Edit Footer Link',
            'all_items' => 'All Footer Links',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-editor-kitchensink',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('footer_link', $args);
}
add_action('init', 'sgharem_register_footer_link_cpt');

// Add Footer Link Meta Boxes
function sgharem_footer_link_meta_boxes() {
    add_meta_box(
        'footer_link_settings',
        'Footer Link Settings',
        'sgharem_footer_link_meta_callback',
        'footer_link',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_footer_link_meta_boxes');

function sgharem_footer_link_meta_callback($post) {
    wp_nonce_field('sgharem_footer_link_nonce', 'footer_link_nonce');

    $link_url = get_post_meta($post->ID, '_footer_link_url', true);
    $target_blank = get_post_meta($post->ID, '_footer_link_target_blank', true);
    $is_active = get_post_meta($post->ID, '_footer_link_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="footer_link_active">Active</label></th>
            <td><input type="checkbox" id="footer_link_active" name="footer_link_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="footer_link_url">Link URL</label></th>
            <td><input type="text" id="footer_link_url" name="footer_link_url" value="<?php echo esc_attr($link_url); ?>" class="regular-text" placeholder="e.g. #regions or https://..."></td>
        </tr>
        <tr>
            <th><label for="footer_link_target_blank">Open in New Tab</label></th>
            <td><input type="checkbox" id="footer_link_target_blank" name="footer_link_target_blank" value="1" <?php checked($target_blank, '1'); ?>></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_footer_link_meta($post_id) {
    if (!isset($_POST['footer_link_nonce']) || !wp_verify_nonce($_POST['footer_link_nonce'], 'sgharem_footer_link_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['footer_link_url'])) {
        update_post_meta($post_id, '_footer_link_url', sanitize_text_field($_POST['footer_link_url']));
    }

    $target_blank = isset($_POST['footer_link_target_blank']) ? '1' : '0';
    update_post_meta($post_id, '_footer_link_target_blank', $target_blank);

    $is_active = isset($_POST['footer_link_active']) ? '1' : '0';
    update_post_meta($post_id, '_footer_link_active', $is_active);
}
add_action('save_post_footer_link', 'sgharem_save_footer_link_meta');

// Get Active Footer Links
function sgharem_get_footer_links() {
    $links = get_posts(array(
        'post_type' => 'footer_link',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_footer_link_active',
                'value' => '1',
            )
        )
    ));

    $items = array();
    foreach ($links as $link) {
        $items[] = array(
            'title' => get_the_title($link->ID),
            'url' => get_post_meta($link->ID, '_footer_link_url', true),
            'target_blank' => get_post_meta($link->ID, '_footer_link_target_blank', true),
        );
    }
    return $items;
}

// Footer Settings CPT
function sgharem_register_footer_settings_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Footer Settings',
            'singular_name' => 'Footer Settings',
            'add_new' => 'Add Footer Settings',
            'edit_item' => 'Edit Footer Settings',
            'all_items' => 'Footer Settings',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=footer_link',
        'supports' => array('title'),
        'has_archive' => false,
    );
    register_post_type('footer_settings', $args);
}
add_action('init', 'sgharem_register_footer_settings_cpt');

function sgharem_footer_settings_meta_boxes() {
    add_meta_box(
        'footer_settings_box',
        'Footer Settings',
        'sgharem_footer_settings_meta_callback',
        'footer_settings',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_footer_settings_meta_boxes');

function sgharem_footer_settings_meta_callback($post) {
    wp_nonce_field('sgharem_footer_settings_nonce', 'footer_settings_nonce');
    $copyright = get_post_meta($post->ID, '_footer_copyright', true);
    $is_active = get_post_meta($post->ID, '_footer_settings_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="footer_settings_active">Active</label></th>
            <td><input type="checkbox" id="footer_settings_active" name="footer_settings_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="footer_copyright">Copyright Text</label></th>
            <td><textarea id="footer_copyright" name="footer_copyright" rows="3" class="large-text"><?php echo esc_textarea($copyright); ?></textarea></td>
        </tr>
    </table>
    <?php
}

function sgharem_save_footer_settings_meta($post_id) {
    if (!isset($_POST['footer_settings_nonce']) || !wp_verify_nonce($_POST['footer_settings_nonce'], 'sgharem_footer_settings_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['footer_copyright'])) {
        update_post_meta($post_id, '_footer_copyright', sanitize_textarea_field($_POST['footer_copyright']));
    }
    $is_active = isset($_POST['footer_settings_active']) ? '1' : '0';
    update_post_meta($post_id, '_footer_settings_active', $is_active);
}
add_action('save_post_footer_settings', 'sgharem_save_footer_settings_meta');

function sgharem_get_footer_settings() {
    $settings = get_posts(array(
        'post_type' => 'footer_settings',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_footer_settings_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($settings)) {
        return array(
            'copyright' => get_post_meta($settings[0]->ID, '_footer_copyright', true),
        );
    }
    return false;
}

// Register Header Settings Custom Post Type
function sgharem_register_header_settings_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Header Settings',
            'singular_name' => 'Header Settings',
            'add_new' => 'Add Header Settings',
            'add_new_item' => 'Add New Header Settings',
            'edit_item' => 'Edit Header Settings',
            'all_items' => 'All Header Settings',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-admin-customizer',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => false,
    );
    register_post_type('header_settings', $args);
}
add_action('init', 'sgharem_register_header_settings_cpt');

// Add Header Settings Meta Boxes
function sgharem_header_settings_meta_boxes() {
    add_meta_box(
        'header_settings_box',
        'Header Settings',
        'sgharem_header_settings_meta_callback',
        'header_settings',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_header_settings_meta_boxes');

function sgharem_header_settings_meta_callback($post) {
    wp_nonce_field('sgharem_header_settings_nonce', 'header_settings_nonce');

    $btn1_text = get_post_meta($post->ID, '_header_btn1_text', true);
    $btn1_url = get_post_meta($post->ID, '_header_btn1_url', true);
    $btn1_icon = get_post_meta($post->ID, '_header_btn1_icon', true);
    $btn2_text = get_post_meta($post->ID, '_header_btn2_text', true);
    $btn2_url = get_post_meta($post->ID, '_header_btn2_url', true);
    $btn2_icon = get_post_meta($post->ID, '_header_btn2_icon', true);
    $is_active = get_post_meta($post->ID, '_header_settings_active', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="header_settings_active">Active</label></th>
            <td><input type="checkbox" id="header_settings_active" name="header_settings_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th colspan="2"><h3>Button 1 (Website)</h3></th>
        </tr>
        <tr>
            <th><label for="header_btn1_icon">Icon (emoji)</label></th>
            <td><input type="text" id="header_btn1_icon" name="header_btn1_icon" value="<?php echo esc_attr($btn1_icon); ?>" class="regular-text" placeholder="e.g. 🌐"></td>
        </tr>
        <tr>
            <th><label for="header_btn1_text">Button Text</label></th>
            <td><input type="text" id="header_btn1_text" name="header_btn1_text" value="<?php echo esc_attr($btn1_text); ?>" class="regular-text" placeholder="e.g. Website"></td>
        </tr>
        <tr>
            <th><label for="header_btn1_url">Button URL</label></th>
            <td><input type="url" id="header_btn1_url" name="header_btn1_url" value="<?php echo esc_url($btn1_url); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th colspan="2"><h3>Button 2 (Telegram)</h3></th>
        </tr>
        <tr>
            <th><label for="header_btn2_icon">Icon (emoji)</label></th>
            <td><input type="text" id="header_btn2_icon" name="header_btn2_icon" value="<?php echo esc_attr($btn2_icon); ?>" class="regular-text" placeholder="e.g. 📱"></td>
        </tr>
        <tr>
            <th><label for="header_btn2_text">Button Text</label></th>
            <td><input type="text" id="header_btn2_text" name="header_btn2_text" value="<?php echo esc_attr($btn2_text); ?>" class="regular-text" placeholder="e.g. Telegram"></td>
        </tr>
        <tr>
            <th><label for="header_btn2_url">Button URL</label></th>
            <td><input type="url" id="header_btn2_url" name="header_btn2_url" value="<?php echo esc_url($btn2_url); ?>" class="regular-text"></td>
        </tr>
    </table>
    <p class="description">Use "Featured Image" to set the logo.</p>
    <?php
}

function sgharem_save_header_settings_meta($post_id) {
    if (!isset($_POST['header_settings_nonce']) || !wp_verify_nonce($_POST['header_settings_nonce'], 'sgharem_header_settings_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('header_btn1_text', 'header_btn1_icon', 'header_btn2_text', 'header_btn2_icon');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }

    if (isset($_POST['header_btn1_url'])) {
        update_post_meta($post_id, '_header_btn1_url', esc_url_raw($_POST['header_btn1_url']));
    }
    if (isset($_POST['header_btn2_url'])) {
        update_post_meta($post_id, '_header_btn2_url', esc_url_raw($_POST['header_btn2_url']));
    }

    $is_active = isset($_POST['header_settings_active']) ? '1' : '0';
    update_post_meta($post_id, '_header_settings_active', $is_active);
}
add_action('save_post_header_settings', 'sgharem_save_header_settings_meta');

// Get Active Header Settings
function sgharem_get_header_settings() {
    $settings = get_posts(array(
        'post_type' => 'header_settings',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_header_settings_active',
                'value' => '1',
            )
        )
    ));

    if (!empty($settings)) {
        $post_id = $settings[0]->ID;
        return array(
            'logo_url' => get_the_post_thumbnail_url($post_id, 'full'),
            'btn1_icon' => get_post_meta($post_id, '_header_btn1_icon', true),
            'btn1_text' => get_post_meta($post_id, '_header_btn1_text', true),
            'btn1_url' => get_post_meta($post_id, '_header_btn1_url', true),
            'btn2_icon' => get_post_meta($post_id, '_header_btn2_icon', true),
            'btn2_text' => get_post_meta($post_id, '_header_btn2_text', true),
            'btn2_url' => get_post_meta($post_id, '_header_btn2_url', true),
        );
    }
    return false;
}

// Register Language Custom Post Type
function sgharem_register_language_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Languages',
            'singular_name' => 'Language',
            'add_new' => 'Add New Language',
            'add_new_item' => 'Add New Language',
            'edit_item' => 'Edit Language',
            'all_items' => 'All Languages',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-translation',
        'supports' => array('title', 'page-attributes'),
        'has_archive' => false,
    );
    register_post_type('language', $args);
}
add_action('init', 'sgharem_register_language_cpt');

// Add Language Meta Boxes
function sgharem_language_meta_boxes() {
    add_meta_box(
        'language_settings',
        'Language Settings',
        'sgharem_language_meta_callback',
        'language',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sgharem_language_meta_boxes');

function sgharem_language_meta_callback($post) {
    wp_nonce_field('sgharem_language_nonce', 'language_nonce');

    $code = get_post_meta($post->ID, '_language_code', true);
    $label = get_post_meta($post->ID, '_language_label', true);
    $url = get_post_meta($post->ID, '_language_url', true);
    $is_active = get_post_meta($post->ID, '_language_active', true);
    $is_default = get_post_meta($post->ID, '_language_default', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="language_active">Active</label></th>
            <td><input type="checkbox" id="language_active" name="language_active" value="1" <?php checked($is_active, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="language_default">Default Language</label></th>
            <td><input type="checkbox" id="language_default" name="language_default" value="1" <?php checked($is_default, '1'); ?>></td>
        </tr>
        <tr>
            <th><label for="language_code">Language Code</label></th>
            <td><input type="text" id="language_code" name="language_code" value="<?php echo esc_attr($code); ?>" class="regular-text" placeholder="e.g. en, zh, vi"></td>
        </tr>
        <tr>
            <th><label for="language_label">Display Label</label></th>
            <td><input type="text" id="language_label" name="language_label" value="<?php echo esc_attr($label); ?>" class="regular-text" placeholder="e.g. EN, 中文, VI"></td>
        </tr>
        <tr>
            <th><label for="language_url">URL</label></th>
            <td><input type="text" id="language_url" name="language_url" value="<?php echo esc_attr($url); ?>" class="regular-text" placeholder="e.g. / or https://cn.example.com/"></td>
        </tr>
    </table>
    <p class="description">Use "Order" field to set the display order (lower number = first).</p>
    <?php
}

function sgharem_save_language_meta($post_id) {
    if (!isset($_POST['language_nonce']) || !wp_verify_nonce($_POST['language_nonce'], 'sgharem_language_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['language_code'])) {
        update_post_meta($post_id, '_language_code', sanitize_text_field($_POST['language_code']));
    }
    if (isset($_POST['language_label'])) {
        update_post_meta($post_id, '_language_label', sanitize_text_field($_POST['language_label']));
    }
    if (isset($_POST['language_url'])) {
        update_post_meta($post_id, '_language_url', esc_url_raw($_POST['language_url']));
    }

    $is_active = isset($_POST['language_active']) ? '1' : '0';
    update_post_meta($post_id, '_language_active', $is_active);

    $is_default = isset($_POST['language_default']) ? '1' : '0';
    update_post_meta($post_id, '_language_default', $is_default);
}
add_action('save_post_language', 'sgharem_save_language_meta');

// Get Active Languages
function sgharem_get_languages() {
    $languages = get_posts(array(
        'post_type' => 'language',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_language_active',
                'value' => '1',
            )
        )
    ));

    $items = array();
    foreach ($languages as $lang) {
        $items[] = array(
            'code' => get_post_meta($lang->ID, '_language_code', true),
            'label' => get_post_meta($lang->ID, '_language_label', true),
            'url' => get_post_meta($lang->ID, '_language_url', true),
            'is_default' => get_post_meta($lang->ID, '_language_default', true),
        );
    }
    return $items;
}
