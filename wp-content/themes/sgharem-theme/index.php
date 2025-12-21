<?php get_header(); ?>
<main id="main">

<!-- Language toggle -->
<?php $languages = sgharem_get_languages(); ?>
<?php if (!empty($languages)) : ?>
<div class="lang-toggle">
    <?php foreach ($languages as $lang) : ?>
    <button class="lang-btn<?php echo $lang['is_default'] === '1' ? ' active' : ''; ?>" data-lang="<?php echo esc_attr($lang['code']); ?>">
        <a href="<?php echo esc_url($lang['url']); ?>"><?php echo esc_html($lang['label']); ?></a>
    </button>
    <?php endforeach; ?>
</div>

<style>
    .lang-toggle a {
        text-decoration: none;
        color: inherit;
        display: block;
    }
</style>
<?php endif; ?>
<!-- Banner is loaded from header.php using Custom Post Type -->

<?php
$gallery_section = sgharem_get_gallery_section();
$gallery_images = sgharem_get_gallery_images();
?>
<?php if ($gallery_section && !empty($gallery_images)) : ?>
<section class="photo-gallery">
    <div class="container">
        <?php if (!empty($gallery_section['heading'])) : ?>
        <h3><?php echo esc_html($gallery_section['heading']); ?></h3>
        <?php endif; ?>
        <div class="gallery-marquee">
            <div class="marquee-track">
                <?php foreach ($gallery_images as $image) : ?>
                <a href="javascript:void(0);" class="gallery-copy-link" data-url="<?php echo esc_url($image['link_url']); ?>" title="Click to copy: <?php echo esc_attr($image['title']); ?>">
                    <img src="<?php echo esc_url($image['image_url']); ?>" alt="<?php echo esc_attr($image['alt_text']); ?>">
                </a>
                <?php endforeach; ?>
                <?php foreach ($gallery_images as $image) : ?>
                <a href="javascript:void(0);" class="gallery-copy-link" data-url="<?php echo esc_url($image['link_url']); ?>" title="Click to copy: <?php echo esc_attr($image['title']); ?>">
                    <img src="<?php echo esc_url($image['image_url']); ?>" alt="<?php echo esc_attr($image['alt_text']); ?>">
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Copy notification -->
<div id="copy-notification" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:rgba(0,0,0,0.85); color:#fff; padding:15px 30px; border-radius:8px; z-index:9999; font-size:14px;">
    Link copied!
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyLinks = document.querySelectorAll('.gallery-copy-link');
    const notification = document.getElementById('copy-notification');

    copyLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');

            if (url && url !== '') {
                navigator.clipboard.writeText(url).then(function() {
                    notification.style.display = 'block';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 1500);
                }).catch(function(err) {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = url;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    notification.style.display = 'block';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 1500);
                });
            }
        });
    });
});
</script>
<?php endif; ?>
<style>
    .link-card img {
        width: 100%;
        height: 398px;
        /* 你可以改成 200px 或 220px */
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }
</style>
<!-- Quick Links -->
<?php
$quicklinks_section = sgharem_get_quicklinks_section();
$quick_links = sgharem_get_quick_links();
?>
<?php if ($quicklinks_section && !empty($quick_links)) : ?>
<section class="quick-links">
    <div class="container">
        <?php if (!empty($quicklinks_section['heading'])) : ?>
        <h3 style="font-size: 32px;color: white;">
            <?php echo esc_html($quicklinks_section['heading']); ?>
        </h3>
        <?php endif; ?>
        <div class="links-grid">
            <?php foreach ($quick_links as $link) : ?>
            <a href="<?php echo esc_url($link['url'] ?: '#'); ?>" class="link-card" target="_blank"
                title="<?php echo esc_attr($link['title']); ?>">
                <?php if (!empty($link['image_url'])) : ?>
                <img src="<?php echo esc_url($link['image_url']); ?>"
                    alt="<?php echo esc_attr($link['title']); ?>" style="width:100%; border-radius: 8px; margin-bottom:10px;">
                <?php endif; ?>
                <h4><?php echo esc_html($link['title']); ?></h4>
                <?php if (!empty($link['description'])) : ?>
                <p><?php echo nl2br(esc_html($link['description'])); ?><br><br>
                    <?php if (!empty($link['button_text'])) : ?>
                    <span style="color:#7E0C0C; font-weight:bold;text-decoration: underline;">
                        <?php echo esc_html($link['button_text']); ?>
                    </span>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Regions -->
<?php
$regions_section = sgharem_get_regions_section();
$regions = sgharem_get_regions();
?>
<?php if ($regions_section && !empty($regions)) : ?>
<section class="regions" id="regions">
    <div class="container">
        <?php if (!empty($regions_section['heading'])) : ?>
        <h3 style="color: white;"><?php echo esc_html($regions_section['heading']); ?></h3>
        <?php endif; ?>
        <?php if (!empty($regions_section['subtitle'])) : ?>
        <p class="regions-subtitle"><?php echo esc_html($regions_section['subtitle']); ?></p>
        <?php endif; ?>
        <div class="regions-grid">
            <?php foreach ($regions as $region) : ?>
            <a href="<?php echo esc_url($region['url'] ?: '#'); ?>" class="region-card" target="_blank"
                title="<?php echo esc_attr($region['title']); ?>" aria-label="<?php echo esc_attr($region['title']); ?>">
                <h4><?php echo esc_html($region['icon']); ?> <?php echo esc_html($region['title']); ?></h4>
                <?php if (!empty($region['description'])) : ?>
                <p><?php echo esc_html($region['description']); ?></p><br>
                <?php endif; ?>
                <?php if (!empty($region['button_text'])) : ?>
                🔗 <span style="color:#7E0C0C; font-weight:bold;text-decoration: underline;">
                    <?php echo esc_html($region['button_text']); ?>
                </span>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Services -->
<?php
$services_section = sgharem_get_services_section();
$services = sgharem_get_services();
?>
<?php if ($services_section && !empty($services)) : ?>
<section class="services" id="services">
    <div class="container">
        <?php if (!empty($services_section['heading'])) : ?>
        <h3 style="color: white;"><?php echo esc_html($services_section['heading']); ?></h3>
        <?php endif; ?>
        <?php if (!empty($services_section['subtitle'])) : ?>
        <p class="services-subtitle" style="color: white;">
            <?php echo esc_html($services_section['subtitle']); ?>
        </p>
        <?php endif; ?>
        <div class="services-grid">
            <?php foreach ($services as $service) : ?>
            <a href="<?php echo esc_url($service['url'] ?: '#'); ?>" style="text-decoration: none;" class="service-card"
                target="_blank" title="<?php echo esc_attr($service['title']); ?>"
                aria-label="<?php echo esc_attr($service['title']); ?>">
                <?php if (!empty($service['image_url'])) : ?>
                <img src="<?php echo esc_url($service['image_url']); ?>"
                    alt="<?php echo esc_attr($service['title']); ?>" style="width:100%; border-radius:8px; margin-bottom:10px;">
                <?php endif; ?>
                <h4><?php echo esc_html($service['title']); ?></h4>
                <?php if (!empty($service['description'])) : ?>
                <p><?php echo nl2br(esc_html($service['description'])); ?></p><br>
                <?php endif; ?>
                <?php if (!empty($service['button_text'])) : ?>
                🔗<span style="color:#7E0C0C; font-weight:bold;text-decoration: underline;">
                    <?php echo esc_html($service['button_text']); ?>
                </span>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<?php $seotext = sgharem_get_active_seotext(); ?>
<?php if ($seotext) : ?>
<section class="seo-text">
    <div class="container">
        <?php if (!empty($seotext['heading'])) : ?>
        <h2><?php echo esc_html($seotext['heading']); ?></h2>
        <?php endif; ?>

        <?php if (!empty($seotext['content'])) : ?>
        <p><?php echo nl2br(esc_html($seotext['content'])); ?></p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php $contact = sgharem_get_contact(); ?>
<?php if ($contact) : ?>
<section class="contact">
    <div class="container">
        <?php if (!empty($contact['heading'])) : ?>
        <h3><?php echo esc_html($contact['heading']); ?></h3>
        <?php endif; ?>
        <?php if (!empty($contact['description'])) : ?>
        <p style="font-size: 18px; "><?php echo esc_html($contact['description']); ?></p>
        <?php endif; ?>
        <div class="contact-buttons">
            <?php if (!empty($contact['btn1_text']) && !empty($contact['btn1_url'])) : ?>
            <a href="<?php echo esc_url($contact['btn1_url']); ?>" class="btn btn-large" target="_blank"
                style="font-size: 12px; color: white;"
                aria-label="<?php echo esc_attr($contact['btn1_text']); ?>"
                title="<?php echo esc_attr($contact['btn1_text']); ?>">
                <?php echo esc_html($contact['btn1_icon']); ?> <?php echo esc_html($contact['btn1_text']); ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($contact['btn2_text']) && !empty($contact['btn2_url'])) : ?>
            <a href="<?php echo esc_url($contact['btn2_url']); ?>" class="btn btn-large btn-telegram" target="_blank"
                style="font-size: 12px;"
                aria-label="<?php echo esc_attr($contact['btn2_text']); ?>"
                title="<?php echo esc_attr($contact['btn2_text']); ?>">
                <?php echo esc_html($contact['btn2_icon']); ?> <?php echo esc_html($contact['btn2_text']); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>



</main>

<?php
$faq_section = sgharem_get_faq_section();
$faqs = sgharem_get_faqs();
?>
<?php if ($faq_section && !empty($faqs)) : ?>
<!-- FAQ / Q&A -->
<section class="faq" id="faq" style="background: linear-gradient(135deg, #000000 0%, #660000 100%);">
    <div class="container">
        <?php if (!empty($faq_section['heading'])) : ?>
        <h3 style="color: white;"><?php echo esc_html($faq_section['heading']); ?></h3>
        <?php endif; ?>
        <div class="faq-card"
            style="background: linear-gradient(135deg, #000000 0%, #660000 100%); padding: 22px; border-radius: 8px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); margin: 28px 0;">
            <?php foreach ($faqs as $key => $faq) : ?>
            <details <?php if($key == 0){ ?> open <?php } ?> style="margin-bottom:12px; padding:12px; border-radius:6px; background:#ffffff;" itemscope
                itemprop="mainEntity" itemtype="https://schema.org/Question">
                <summary style="font-weight:700; cursor:pointer;" itemprop="name"
                    title="<?php echo esc_attr($faq['question']); ?>">
                    <?php echo esc_html($faq['question']); ?></summary>
                <p style="margin-top:8px; color:#333;" itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
                    <span itemprop="text">
                        <?php echo nl2br(esc_html($faq['answer'])); ?>
                        <?php if (!empty($faq['link_text']) && !empty($faq['link_url'])) : ?>
                        <a href="<?php echo esc_url($faq['link_url']); ?>" target="_blank"
                            title="<?php echo esc_attr($faq['link_text']); ?>"><?php echo esc_html($faq['link_text']); ?></a>
                        <?php endif; ?>
                    </span>
                </p>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php get_footer(); ?>
