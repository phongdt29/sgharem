<?php if (is_active_sidebar('sidebar-1')) : ?>
<aside id="sidebar" class="sidebar">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>

<style>
.sidebar {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}
.sidebar .widget {
    margin-bottom: 30px;
}
.sidebar .widget:last-child {
    margin-bottom: 0;
}
.sidebar .widget-title {
    font-size: 18px;
    color: #333;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #7E0C0C;
}
.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar ul li {
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
.sidebar ul li:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.sidebar ul li a {
    color: #555;
    text-decoration: none;
    transition: color 0.3s ease;
}
.sidebar ul li a:hover {
    color: #7E0C0C;
}
.sidebar .search-form {
    margin-bottom: 0;
}
</style>
<?php endif; ?>
