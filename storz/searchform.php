<form role="search" method="get" class="storz-search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="storz-search-field"><?php echo esc_html_x('Search for:', 'label', 'storz'); ?></label>
    <input type="search" id="storz-search-field" class="storz-search-input" placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'storz'); ?>" value="<?php echo get_search_query(); ?>" name="s">
    <button type="submit" class="storz-search-button"><?php echo esc_html_x('Search', 'submit button', 'storz'); ?></button>
</form>
