<?php get_header(); ?>
<main id="main">

<section class="error-404">
    <div class="container">
        <div class="error-content">
            <h1 class="error-code">404</h1>
            <h2 class="error-title">Page Not Found</h2>
            <p class="error-message">Sorry, the page you are looking for doesn't exist or has been moved.</p>
            <div class="error-actions">
                <a href="<?php echo home_url(); ?>" class="btn btn-primary">Back to Homepage</a>
            </div>
            <div class="error-search">
                <p>Or try searching:</p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</section>

<style>
.error-404 {
    padding: 100px 0;
    background: #f8f9fa;
    min-height: 60vh;
    display: flex;
    align-items: center;
}
.error-content {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}
.error-code {
    font-size: 120px;
    font-weight: bold;
    color: #7E0C0C;
    margin: 0;
    line-height: 1;
}
.error-title {
    font-size: 32px;
    color: #333;
    margin: 20px 0;
}
.error-message {
    font-size: 16px;
    color: #666;
    margin-bottom: 30px;
}
.error-actions {
    margin-bottom: 40px;
}
.btn-primary {
    display: inline-block;
    padding: 12px 30px;
    background: #7E0C0C;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s ease;
}
.btn-primary:hover {
    background: #5a0909;
}
.error-search {
    padding-top: 30px;
    border-top: 1px solid #ddd;
}
.error-search p {
    color: #666;
    margin-bottom: 15px;
}
</style>

</main>

<?php get_footer(); ?>
