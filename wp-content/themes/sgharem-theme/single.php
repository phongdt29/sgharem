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

<article class="single-post">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <header class="post-header">
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="post-meta">
                <span class="post-date"><?php echo get_the_date(); ?></span>
                <span class="post-author">by <?php the_author(); ?></span>
                <?php if (has_category()) : ?>
                <span class="post-categories">
                    in <?php the_category(', '); ?>
                </span>
                <?php endif; ?>
            </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </div>
        <?php endif; ?>

        <div class="post-content">
            <?php the_content(); ?>
        </div>

        <?php if (has_tag()) : ?>
        <div class="post-tags">
            <strong>Tags:</strong> <?php the_tags('', ', ', ''); ?>
        </div>
        <?php endif; ?>

        <nav class="post-navigation">
            <div class="nav-previous">
                <?php previous_post_link('%link', '« %title'); ?>
            </div>
            <div class="nav-next">
                <?php next_post_link('%link', '%title »'); ?>
            </div>
        </nav>

        <?php endwhile; endif; ?>
    </div>
</article>

<style>
.single-post {
    padding: 60px 0;
    background: #fff;
}
.single-post .container {
    max-width: 800px;
}
.post-header {
    text-align: center;
    margin-bottom: 30px;
}
.post-title {
    font-size: 36px;
    line-height: 1.3;
    margin-bottom: 15px;
    color: #333;
}
.post-meta {
    color: #999;
    font-size: 14px;
}
.post-meta span {
    margin: 0 10px;
}
.post-meta a {
    color: #7E0C0C;
    text-decoration: none;
}
.post-meta a:hover {
    text-decoration: underline;
}
.post-thumbnail {
    margin-bottom: 30px;
    text-align: center;
}
.post-thumbnail img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}
.post-content {
    font-size: 16px;
    line-height: 1.8;
    color: #444;
}
.post-content p {
    margin-bottom: 20px;
}
.post-content h2, .post-content h3, .post-content h4 {
    margin: 30px 0 15px;
    color: #333;
}
.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}
.post-content a {
    color: #7E0C0C;
}
.post-content ul, .post-content ol {
    margin-bottom: 20px;
    padding-left: 30px;
}
.post-content li {
    margin-bottom: 10px;
}
.post-content blockquote {
    margin: 30px 0;
    padding: 20px 30px;
    background: #f8f9fa;
    border-left: 4px solid #7E0C0C;
    font-style: italic;
}
.post-tags {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    font-size: 14px;
}
.post-tags a {
    color: #7E0C0C;
    text-decoration: none;
}
.post-tags a:hover {
    text-decoration: underline;
}
.post-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}
.post-navigation a {
    color: #7E0C0C;
    text-decoration: none;
    font-size: 14px;
}
.post-navigation a:hover {
    text-decoration: underline;
}
.nav-previous, .nav-next {
    max-width: 45%;
}
.nav-next {
    text-align: right;
}

@media (max-width: 576px) {
    .post-title {
        font-size: 28px;
    }
    .post-navigation {
        flex-direction: column;
        gap: 15px;
    }
    .nav-previous, .nav-next {
        max-width: 100%;
        text-align: left;
    }
}
</style>

</main>

<?php get_footer(); ?>
