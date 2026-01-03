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
    .lang-toggle a { text-decoration: none; color: inherit; display: block; }
</style>
<?php endif; ?>

<section class="search-section">
    <div class="container">
        <div class="search-header">
            <h1 class="search-title">
                Search Results for: <span>"<?php echo get_search_query(); ?>"</span>
            </h1>
            <div class="search-form-wrap">
                <?php get_search_form(); ?>
            </div>
        </div>

        <?php if (have_posts()) : ?>
        <p class="search-count"><?php printf('Found %d results', $wp_query->found_posts); ?></p>

        <div class="search-results">
            <?php while (have_posts()) : the_post(); ?>
            <article class="search-item">
                <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="search-thumb">
                    <?php the_post_thumbnail('large'); ?>
                </a>
                <?php endif; ?>
                <div class="search-content">
                    <h2 class="search-item-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="search-meta">
                        <span class="search-date"><?php echo get_the_date(); ?></span>
                        <span class="search-type"><?php echo get_post_type(); ?></span>
                    </div>
                    <p class="search-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="read-more">Read More →</a>
                </div>
            </article>
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
        <div class="no-results">
            <h2>No Results Found</h2>
            <p>Sorry, no posts matched your search. Try different keywords.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.search-section {
    padding: 60px 0;
    background: #f8f9fa;
    min-height: 60vh;
}
.search-header {
    text-align: center;
    margin-bottom: 40px;
}
.search-title {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}
.search-title span {
    color: #7E0C0C;
}
.search-form-wrap {
    max-width: 500px;
    margin: 0 auto;
}
.search-count {
    color: #666;
    margin-bottom: 30px;
}
.search-results {
    margin-bottom: 40px;
}
.search-item {
    display: flex;
    gap: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.search-thumb {
    flex-shrink: 0;
}
.search-thumb img {
    width: 150px;
    height: 100px;
    object-fit: contain;
    border-radius: 5px;
}
.search-content {
    flex: 1;
}
.search-item-title {
    font-size: 20px;
    margin-bottom: 8px;
}
.search-item-title a {
    color: #333;
    text-decoration: none;
}
.search-item-title a:hover {
    color: #7E0C0C;
}
.search-meta {
    font-size: 13px;
    color: #999;
    margin-bottom: 10px;
}
.search-meta span {
    margin-right: 15px;
}
.search-type {
    background: #eee;
    padding: 2px 8px;
    border-radius: 3px;
    text-transform: capitalize;
}
.search-excerpt {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 10px;
}
.read-more {
    color: #7E0C0C;
    font-weight: bold;
    text-decoration: none;
    font-size: 14px;
}
.read-more:hover {
    text-decoration: underline;
}
.no-results {
    text-align: center;
    padding: 60px 0;
}
.no-results h2 {
    color: #333;
    margin-bottom: 10px;
}
.no-results p {
    color: #666;
}
.pagination {
    text-align: center;
}
.pagination-list {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
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
}
.pagination-item a:hover,
.pagination-item span.current {
    background: #7E0C0C;
    border-color: #7E0C0C;
    color: #fff;
}
@media (max-width: 576px) {
    .search-item {
        flex-direction: column;
    }
    .search-thumb img {
        width: 100%;
        height: 150px;
    }
}
</style>

</main>

<?php get_footer(); ?>
