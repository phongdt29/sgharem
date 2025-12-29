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

<article class="page-content">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <div class="page-body">
            <?php the_content(); ?>
        </div>

        <?php endwhile; endif; ?>
    </div>
</article>

<style>
.page-content {
    padding: 60px 0;
    background: #fff;
    min-height: 60vh;
}
.page-content .container {
    max-width: 900px;
}
.page-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}
.page-title {
    font-size: 36px;
    color: #333;
    margin: 0;
}
.page-body {
    font-size: 16px;
    line-height: 1.8;
    color: #444;
}
.page-body p {
    margin-bottom: 20px;
}
.page-body h2 {
    font-size: 24px;
    margin: 40px 0 20px;
    color: #333;
}
.page-body h3 {
    font-size: 20px;
    margin: 30px 0 15px;
    color: #333;
}
.page-body h4 {
    font-size: 18px;
    margin: 25px 0 10px;
    color: #333;
}
.page-body ul, .page-body ol {
    margin-bottom: 20px;
    padding-left: 30px;
}
.page-body li {
    margin-bottom: 10px;
}
.page-body a {
    color: #7E0C0C;
    text-decoration: none;
}
.page-body a:hover {
    text-decoration: underline;
}
.page-body blockquote {
    margin: 30px 0;
    padding: 20px 30px;
    background: #f8f9fa;
    border-left: 4px solid #7E0C0C;
    font-style: italic;
}
.page-body img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}
.page-body table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.page-body table th,
.page-body table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}
.page-body table th {
    background: #f8f9fa;
}

@media (max-width: 576px) {
    .page-title {
        font-size: 28px;
    }
    .page-body {
        font-size: 15px;
    }
}
</style>

</main>

<?php get_footer(); ?>
