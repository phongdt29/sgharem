<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
    <h3 class="comments-title">
        <?php
        $comments_count = get_comments_number();
        printf(
            _n('%d Comment', '%d Comments', $comments_count),
            $comments_count
        );
        ?>
    </h3>

    <ol class="comment-list">
        <?php
        wp_list_comments(array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 50,
            'callback'    => 'sgharem_comment_template',
        ));
        ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
    <nav class="comment-navigation">
        <div class="nav-previous"><?php previous_comments_link('« Older Comments'); ?></div>
        <div class="nav-next"><?php next_comments_link('Newer Comments »'); ?></div>
    </nav>
    <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="no-comments">Comments are closed.</p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => 'Leave a Comment',
        'title_reply_to'       => 'Reply to %s',
        'cancel_reply_link'    => 'Cancel Reply',
        'label_submit'         => 'Post Comment',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">Comment</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
        'class_submit'         => 'submit-btn',
    ));
    ?>
</div>

<style>
.comments-area {
    margin-top: 50px;
    padding-top: 40px;
    border-top: 1px solid #eee;
}
.comments-title {
    font-size: 24px;
    margin-bottom: 30px;
    color: #333;
}
.comment-list {
    list-style: none;
    padding: 0;
    margin: 0 0 40px;
}
.comment-list .comment {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}
.comment-list .children {
    list-style: none;
    padding-left: 50px;
    margin-top: 20px;
}
.comment-body {
    display: flex;
    gap: 15px;
}
.comment-avatar img {
    border-radius: 50%;
}
.comment-content {
    flex: 1;
}
.comment-author {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}
.comment-meta {
    font-size: 13px;
    color: #999;
    margin-bottom: 10px;
}
.comment-meta a {
    color: #999;
    text-decoration: none;
}
.comment-text {
    color: #555;
    line-height: 1.6;
}
.comment-text p {
    margin-bottom: 10px;
}
.comment-reply-link {
    color: #7E0C0C;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
}
.comment-reply-link:hover {
    text-decoration: underline;
}
.comment-navigation {
    display: flex;
    justify-content: space-between;
    margin-bottom: 40px;
}
.comment-navigation a {
    color: #7E0C0C;
    text-decoration: none;
}
.no-comments {
    color: #666;
    font-style: italic;
}

/* Comment Form */
.comment-respond {
    margin-top: 40px;
}
.comment-reply-title {
    font-size: 22px;
    margin-bottom: 20px;
    color: #333;
}
.comment-reply-title small {
    font-size: 14px;
    margin-left: 10px;
}
.comment-reply-title small a {
    color: #7E0C0C;
    text-decoration: none;
}
.comment-form p {
    margin-bottom: 20px;
}
.comment-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}
.comment-form input[type="text"],
.comment-form input[type="email"],
.comment-form input[type="url"],
.comment-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 15px;
}
.comment-form input:focus,
.comment-form textarea:focus {
    outline: none;
    border-color: #7E0C0C;
}
.comment-form textarea {
    resize: vertical;
    min-height: 150px;
}
.submit-btn {
    display: inline-block;
    padding: 12px 30px;
    background: #7E0C0C;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}
.submit-btn:hover {
    background: #5a0909;
}
.comment-notes,
.logged-in-as {
    font-size: 14px;
    color: #666;
}
.logged-in-as a {
    color: #7E0C0C;
}

@media (max-width: 576px) {
    .comment-list .children {
        padding-left: 20px;
    }
    .comment-body {
        flex-direction: column;
    }
}
</style>
