<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="search-input-wrap">
        <input type="search" class="search-input" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>
    </div>
</form>

<style>
.search-form {
    width: 100%;
}
.search-input-wrap {
    display: flex;
    border: 2px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    background: #fff;
}
.search-input {
    flex: 1;
    padding: 12px 15px;
    border: none;
    font-size: 16px;
    outline: none;
}
.search-input:focus {
    outline: none;
}
.search-submit {
    padding: 12px 20px;
    background: #7E0C0C;
    border: none;
    color: #fff;
    cursor: pointer;
    transition: background 0.3s ease;
}
.search-submit:hover {
    background: #5a0909;
}
.search-input-wrap:focus-within {
    border-color: #7E0C0C;
}
</style>
