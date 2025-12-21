<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel='stylesheet' href='/theme/index.css'>

<?php wp_head(); ?>

<style>
    .lang-toggle {
        position: fixed;
        top: 12px;
        right: 10px;
        display: inline-flex;
        border: 1px solid #ccc;
        border-radius: 999px;
        overflow: hidden;
        font-family: Arial, sans-serif;
        z-index: 1000;
    }

    .lang-toggle button {
        padding: 3px 14px;
        border: none;
        background: #f8f8f8;
        cursor: pointer;
        font-size: 10px;
        transition: background 0.2s, color 0.2s;
    }

    .lang-toggle button.active {
        background: #000;
        color: #fff;
    }

    .lang-toggle button:not(.active):hover {
        background: #eee;
    }
</style>


</head>
<body <?php body_class(); ?>>

<?php $header = sgharem_get_header_settings(); ?>
<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo home_url(); ?>" class="logo" style="font-size: 22px;">
                <?php if ($header && !empty($header['logo_url'])) : ?>
                <img alt="<?php bloginfo('name'); ?> logo" style="width: 160px;"
                    src="<?php echo esc_url($header['logo_url']); ?>">
                <?php else : ?>
                <img alt="<?php bloginfo('name'); ?> logo" style="width: 160px;"
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png">
                <?php endif; ?>
            </a>

            <div class="header-buttons no-bg">
                <?php if ($header && !empty($header['btn1_text'])) : ?>
                <a href="<?php echo esc_url($header['btn1_url'] ?: home_url()); ?>" class="btn" target="_blank"
                    style="font-size: 12px;color: rgb(255, 248, 248);"
                    title="<?php echo esc_attr($header['btn1_text']); ?>">
                    <?php echo esc_html($header['btn1_icon']); ?>
                    <?php echo esc_html($header['btn1_text']); ?>
                </a>
                <?php endif; ?>
                <?php if ($header && !empty($header['btn2_text'])) : ?>
                <a href="<?php echo esc_url($header['btn2_url'] ?: '#'); ?>" class="btn" target="_blank"
                    title="<?php echo esc_attr($header['btn2_text']); ?>"
                    aria-label="<?php echo esc_attr($header['btn2_text']); ?>" style="font-size: 12px;">
                    <?php echo esc_html($header['btn2_icon']); ?>
                    <?php echo esc_html($header['btn2_text']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<?php $banner = sgharem_get_active_banner(); ?>
<?php if ($banner) : ?>
<section class="banner"<?php if (!empty($banner['image_url'])) : ?> style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3)), url('<?php echo esc_url($banner['image_url']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
    <div class="container">
        <?php if (!empty($banner['heading'])) : ?>
        <h2 style="font-size: 28px;">
            <a href="<?php echo home_url(); ?>" style="color: white;text-decoration: none;">
                <?php echo esc_html($banner['heading']); ?>
            </a>
        </h2>
        <?php endif; ?>

        <?php if (!empty($banner['description'])) : ?>
        <p style="font-size: 16px;"><?php echo esc_html($banner['description']); ?></p>
        <?php endif; ?>

        <?php if (!empty($banner['button_text']) && !empty($banner['button_url'])) : ?>
        <div class="banner-buttons">
            <a href="<?php echo esc_url($banner['button_url']); ?>" class="btn btn-large" target="_blank"
                title="<?php bloginfo('name'); ?> Website" style="color: white; font-size: 14px;">
                <?php echo esc_html($banner['button_text']); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
