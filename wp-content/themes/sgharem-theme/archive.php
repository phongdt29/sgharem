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

<section class="archive-section">
    <div class="container">
        <div class="archive-header">
            <?php if (is_category()) : ?>
            <h1 class="archive-title"><?php single_cat_title(); ?></h1>
            <?php if (category_description()) : ?>
            <p class="archive-description"><?php echo category_description(); ?></p>
            <?php endif; ?>
            <?php elseif (is_tag()) : ?>
            <h1 class="archive-title">Tag: <?php single_tag_title(); ?></h1>
            <?php elseif (is_author()) : ?>
            <h1 class="archive-title">Author: <?php the_author(); ?></h1>
            <?php elseif (is_date()) : ?>
            <h1 class="archive-title">
                <?php if (is_day()) : ?>
                    <?php echo get_the_date(); ?>
                <?php elseif (is_month()) : ?>
                    <?php echo get_the_date('F Y'); ?>
                <?php elseif (is_year()) : ?>
                    <?php echo get_the_date('Y'); ?>
                <?php endif; ?>
            </h1>
            <?php else : ?>
            <h1 class="archive-title">Archives</h1>
            <?php endif; ?>
        </div>

        <?php if (have_posts()) : ?>
        <div class="blog-grid">
            <?php while (have_posts()) : the_post(); ?>
            <div class="blog-card">
                <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>" class="blog-image">
                </a>
                <?php endif; ?>
                <div class="blog-content">
                    <h2 class="blog-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="blog-meta">
                        <span class="blog-date"><?php echo get_the_date(); ?></span>
                    </div>
                    <p class="blog-description">
                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="blog-btn">
                        Read More →
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            $pagination = paginate_links(array(
                'prev_text' => '« Previous',
                'next_text' => 'Next »',
                'type' => 'array',
            ));

            if ($pagination) :
                echo '<ul class="pagination-list">';
                foreach ($pagination as $page) {
                    echo '<li class="pagination-item">' . $page . '</li>';
                }
                echo '</ul>';
            endif;
            ?>
        </div>

        <?php else : ?>
        <div class="no-posts">
            <p>No posts found.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.archive-section {
    padding: 60px 0;
    background: #f8f9fa;
    min-height: 60vh;
}
.archive-header {
    text-align: center;
    margin-bottom: 40px;
}
.archive-title {
    font-size: 32px;
    margin-bottom: 10px;
    color: #333;
}
.archive-description {
    color: #666;
    font-size: 16px;
}
.blog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 40px;
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
.blog-meta {
    margin-bottom: 10px;
}
.blog-date {
    color: #999;
    font-size: 13px;
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

/* Pagination */
.pagination {
    text-align: center;
    margin-top: 40px;
}
.pagination-list {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
}
.pagination-item {

}
.pagination-item a,
.pagination-item span {
    display: inline-block;
    padding: 10px 15px;
    background: #fff;
    border: 1px solid #ddd;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}
.pagination-item a:hover {
    background: #7E0C0C;
    border-color: #7E0C0C;
    color: #fff;
}
.pagination-item span.current {
    background: #7E0C0C;
    border-color: #7E0C0C;
    color: #fff;
}
.pagination-item .dots {
    background: transparent;
    border: none;
}

.no-posts {
    text-align: center;
    padding: 60px 0;
    color: #666;
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
    .pagination-item a,
    .pagination-item span {
        padding: 8px 12px;
        font-size: 14px;
    }
}
</style>

</main>

<?php get_footer(); ?>
