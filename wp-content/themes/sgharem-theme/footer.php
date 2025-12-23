<?php
$footer_widgets = sgharem_get_footer_widgets();
$footer_settings = sgharem_get_footer_settings();
?>
<?php if (!empty($footer_widgets) || $footer_settings) : ?>
<footer class="footer">
    <div class="container">
        <?php if (!empty($footer_widgets)) : ?>
        <div class="footer-widgets">
            <?php foreach ($footer_widgets as $widget) : ?>
            <div class="footer-widget">
                <?php if (!empty($widget['title'])) : ?>
                <h4 class="widget-title"><?php echo esc_html($widget['title']); ?></h4>
                <?php endif; ?>
                <?php if (!empty($widget['content'])) : ?>
                <div class="widget-content">
                    <?php echo wp_kses_post($widget['content']); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if ($footer_settings && !empty($footer_settings['copyright'])) : ?>
        <div class="footer-bottom">
            <div class="copyright">
                <?php echo nl2br(esc_html($footer_settings['copyright'])); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</footer>

<style>
.footer {
    background: #1a1a1a;
    color: #ccc;
    padding: 50px 0 0;
}
.footer-widgets {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    padding-bottom: 40px;
    border-bottom: 1px solid #333;
}
.footer-widget {

}
.widget-title {
    color: #fff;
    font-size: 18px;
    margin-bottom: 20px;
    font-weight: bold;
}
.widget-content {
    font-size: 14px;
    line-height: 1.8;
}
.widget-content a {
    color: #ccc;
    text-decoration: none;
    display: block;
    margin-bottom: 8px;
    transition: color 0.3s ease;
}
.widget-content a:hover {
    color: #fff;
}
.widget-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.widget-content ul li {
    margin-bottom: 8px;
}
.widget-content ul li a {
    display: inline;
}
.widget-content p {
    margin-bottom: 10px;
}
.footer-bottom {
    padding: 20px 0;
    text-align: center;
}
.copyright {
    font-size: 13px;
    color: #888;
}
@media (max-width: 992px) {
    .footer-widgets {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 576px) {
    .footer-widgets {
        grid-template-columns: 1fr;
    }
}
</style>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
