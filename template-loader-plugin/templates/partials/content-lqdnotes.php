<?php
/**
 * Template for Displaying Content of WP Notes CPT Post.
 *
 * Based off of Twenty Seventeen Theme template-parts\post\content.php
 *
 * @since 0.0.1
 */
?>

<article id=""post-<?php the_ID(); ?>" <?php post_class(); ?>>

<header class="entry-header">
    <?php
    if( 'lqdnotes' === get_post_type() ) {
        echo '<div class="entry-meta">';
        echo '</div>';
    }

    if ( is_single() ) {
        the_title( '<h1 class="entry-title">', '</h1>' );
    } else
        the_title( '<h2 class="entry-title"><a href="' . esc_url(get_permalink() ) . '" rel="bookmark">', '</a></h2>');
    ?>
</header>

<div class="entry-content">
    <?php
    the_content(
        sprintf(
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'lqdnotes' ),
            get_the_title()
        )
    );
    ?>
</div>

</article>

<?php the_ID; ?>