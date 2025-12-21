<?php
$footer_links = sgharem_get_footer_links();
$footer_settings = sgharem_get_footer_settings();
?>
<?php if (!empty($footer_links) || $footer_settings) : ?>
<footer class="footer">
    <div class="container">
        <?php if (!empty($footer_links)) : ?>
        <div class="footer-links">
            <?php foreach ($footer_links as $link) : ?>
            <a href="<?php echo esc_attr($link['url'] ?: '#'); ?>"<?php echo $link['target_blank'] ? ' target="_blank"' : ''; ?>>
                <?php echo esc_html($link['title']); ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if ($footer_settings && !empty($footer_settings['copyright'])) : ?>
        <div class="copyright">
            <?php echo nl2br(esc_html($footer_settings['copyright'])); ?>
        </div>
        <?php endif; ?>
    </div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
