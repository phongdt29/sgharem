<?php get_header(); ?>
<main id="main">

<!-- Google Translate Buttons -->
<div class="lang-toggle">
    <button class="lang-btn active" onclick="changeLanguage('en')">English</button>
    <button class="lang-btn" onclick="changeLanguage('zh-CN')">中文</button>
</div>

<div id="google_translate_element" style="display:none;"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,zh-CN',
        autoDisplay: false
    }, 'google_translate_element');
}

function changeLanguage(lang) {
    var selectField = document.querySelector('.goog-te-combo');
    if (selectField) {
        selectField.value = lang;
        selectField.dispatchEvent(new Event('change'));

        // Update active button
        document.querySelectorAll('.lang-toggle .lang-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<style>
    .lang-toggle {
        padding: 10px 0;
    }
    /* .lang-toggle .lang-btn {
        padding: 8px 16px;
        margin-right: 5px;
        border: 1px solid #ccc;
        background: transparent;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    .lang-toggle .lang-btn:hover {
        background: #f0f0f0;
    }
    .lang-toggle .lang-btn.active {
        background: #7E0C0C;
        color: #fff;
        border-color: #7E0C0C;
    } */
    /* Hide Google Translate bar */
    .skiptranslate iframe {
        display: none !important;
    }
    body {
        top: 0 !important;
    }
    .goog-te-banner-frame {
        display: none !important;
    }
</style>
<!-- Banner is loaded from header.php using Custom Post Type -->

<?php
$gallery_section = sgharem_get_gallery_section();
$gallery_images = sgharem_get_gallery_images();
?>
<?php if ($gallery_section && !empty($gallery_images)) : ?>
<section id="photo-gallery" class="photo-gallery">
    <div class="container">
        <?php if (!empty($gallery_section['heading'])) : ?>
        <h2><?php echo esc_html($gallery_section['heading']); ?></h2>
        <?php endif; ?>
        <div class="gallery-marquee">
            <div class="marquee-track">
                <?php foreach ($gallery_images as $image) : ?>
                <a href="<?php echo esc_url($image['link_url']); ?>" title="<?php echo esc_attr($image['title']); ?>">
                    <img src="<?php echo esc_url($image['image_url']); ?>" alt="<?php echo esc_attr($image['alt_text']); ?>">
                </a>
                <?php endforeach; ?>
                <?php foreach ($gallery_images as $image) : ?>
                <a href="<?php echo esc_url($image['link_url']); ?>" title="<?php echo esc_attr($image['title']); ?>">
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

<!-- <script>
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
</script> -->
<?php endif; ?>
<style>
    .link-card img {
        width: 100%;
        height: auto;
        object-fit: contain;
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
<section id="quick-links" class="quick-links">
    <div class="container">
        <?php if (!empty($quicklinks_section['heading'])) : ?>
        <h2 style="font-size: 32px;color: white;">
            <?php echo esc_html($quicklinks_section['heading']); ?>
        </h2>
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
        <h2 style="color: white;"><?php echo esc_html($regions_section['heading']); ?></h2>
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
        <h2 style="color: white;"><?php echo esc_html($services_section['heading']); ?></h2>
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
<section id="seo-text" class="seo-text">
    <div class="container">
        <?php if (!empty($seotext['heading'])) : ?>
        <h2><?php echo esc_html($seotext['heading']); ?></h2>
        <?php endif; ?>

        <?php if (!empty($seotext['content'])) : ?>
        <p><?php echo nl2br(esc_html($seotext['content'])); ?></p>
        <?php endif; ?>

        <?php if (!empty($seotext['content_more'])) : ?>
        <div class="seotext-more-content" id="seotext-more" style="display: none;">
            <p><?php echo nl2br(esc_html($seotext['content_more'])); ?></p>
        </div>
        <button type="button" class="btn btn-view-more" id="seotext-toggle">
            <?php echo esc_html($seotext['button_text'] ?: 'Show More'); ?> <span class="toggle-icon">▼</span>
        </button>
        <script>
        document.getElementById('seotext-toggle').addEventListener('click', function() {
            var content = document.getElementById('seotext-more');
            var btn = this;
            var icon = btn.querySelector('.toggle-icon');
            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.textContent = '▲';
                btn.childNodes[0].textContent = 'Show Less ';
            } else {
                content.style.display = 'none';
                icon.textContent = '▼';
                btn.childNodes[0].textContent = '<?php echo esc_js($seotext['button_text'] ?: 'Show More'); ?> ';
            }
        });
        </script>
        <style>
        .seotext-more-content {
            margin-top: 15px;
        }
        .seotext-toggle-btn {
            margin-top: 20px;
            padding: 10px 25px;
            background: transparent;
            border: 2px solid #7E0C0C;
            color: #7E0C0C;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .seotext-toggle-btn:hover {
            background: #7E0C0C;
            color: #fff;
        }
        .toggle-icon {
            margin-left: 5px;
            font-size: 12px;
        }
        </style>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>


<!-- Blog start -->
<?php
$blog_section = sgharem_get_blog_section();
$blogs = sgharem_get_blogs();
?>
<?php if ($blog_section && !empty($blogs)) : ?>
<section id="blog-section" class="blog-section">
    <div class="container">
        <?php if (!empty($blog_section['heading'])) : ?>
        <h2 class="section-title"><?php echo esc_html($blog_section['heading']); ?></h2>
        <?php endif; ?>
        <?php if (!empty($blog_section['subtitle'])) : ?>
        <p class="section-subtitle"><?php echo esc_html($blog_section['subtitle']); ?></p>
        <?php endif; ?>
        <div class="blog-grid">
            <?php foreach ($blogs as $blog) : ?>
            <div class="blog-card">
                <?php if (!empty($blog['image_url'])) : ?>
                <a href="<?php echo esc_url($blog['url'] ?: '#'); ?>" target="_blank">
                    <img src="<?php echo esc_url($blog['image_url']); ?>" alt="<?php echo esc_attr($blog['title']); ?>" class="blog-image">
                </a>
                <?php endif; ?>
                <div class="blog-content">
                    <h2 class="blog-title">
                        <a href="<?php echo esc_url($blog['url'] ?: '#'); ?>" target="_blank"><?php echo esc_html($blog['title']); ?></a>
                    </h2>
                    <?php if (!empty($blog['description'])) : ?>
                    <p class="blog-description"><?php echo esc_html($blog['description']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($blog['button_text']) && !empty($blog['url'])) : ?>
                    <a href="<?php echo esc_url($blog['url']); ?>" class="blog-btn" target="_blank">
                        <?php echo esc_html($blog['button_text']); ?> →
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($blog_section['button_text']) && !empty($blog_section['button_url'])) : ?>
        <div class="blog-view-more">
            <a href="<?php echo esc_url($blog_section['button_url']); ?>" class="btn btn-view-more" target="_blank">
                <?php echo esc_html($blog_section['button_text']); ?>
            </a>
        </div>
        <?php endif; ?>

        <!-- Latest Posts from WordPress -->
        <?php
        $latest_posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        ?>
        <?php if ($latest_posts->have_posts()) : ?>
        <h2 class="section-title" style="margin-top: 50px;">Bài viết mới nhất</h2>
        <div class="blog-grid">
            <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
            <div class="blog-card">
                <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title_attribute(); ?>" class="blog-image">
                </a>
                <?php endif; ?>
                <div class="blog-content">
                    <h3 class="blog-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="blog-meta">
                        <span class="blog-date"><?php echo get_the_date(); ?></span>
                    </div>
                    <p class="blog-description">
                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="blog-btn">
                        View more →
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.blog-meta {
    margin-bottom: 10px;
}
.blog-date {
    color: #999;
    font-size: 13px;
}
.blog-section {
    padding: 60px 0;
    background: #f8f9fa;
}
.blog-section .section-title {
    text-align: center;
    margin-bottom: 10px;
    font-size: 28px;
}
.blog-section .section-subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 40px;
}
.blog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}
.blog-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}
.blog-card:hover {
    transform: translateY(-5px);
}
.blog-image {
    width: 100%;
    height: 200px;
    object-fit: contain;
}
.blog-content {
    padding: 20px;
}
.blog-title {
    font-size: 18px;
    margin-bottom: 10px;
}
.blog-title a {
    color: #333;
    text-decoration: none;
}
.blog-title a:hover {
    color: #7E0C0C;
}
.blog-description {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 15px;
}
.blog-btn {
    display: inline-block;
    color: #7E0C0C;
    font-weight: bold;
    text-decoration: none;
    font-size: 14px;
}
.blog-btn:hover {
    text-decoration: underline;
}
.blog-view-more {
    text-align: center;
    margin-top: 40px;
}
.btn-view-more {
    display: inline-block;
    padding: 12px 30px;
    background: #7E0C0C;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s ease;
}
.btn-view-more:hover {
    background: #5a0909;
}
@media (max-width: 992px) {
    .blog-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 576px) {
    .blog-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?php endif; ?>
<!-- Blog end -->

<?php $contact = sgharem_get_contact(); ?>
<?php if ($contact) : ?>
<section id="contact" class="contact">
    <div class="container">
        <?php if (!empty($contact['heading'])) : ?>
        <h2><?php echo esc_html($contact['heading']); ?></h2>
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
        <h2 style="color: white;"><?php echo esc_html($faq_section['heading']); ?></h2>
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
