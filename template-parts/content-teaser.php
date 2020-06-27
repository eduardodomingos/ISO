<?php
/**
 * Template part for displaying teasers in lists
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

?>

<?php
    if( !isset($template_type) )
        $template_type ='';
?>
<?php switch ($template_type):
    case 'portfolio': ?>
        <article class="teaser teaser--portfolio teaser--portfolio--3x2">
            <a href="<?php the_permalink(); ?>">
                <!-- thumb aqui! -->
                <h2><?php the_title(); ?></h2>
            </a>
        </article>
    <?php break;?>

    <?php default: ?>
        <article class="teaser">
            <a href="<?php the_permalink(); ?>">
                <!-- thumb aqui! -->
            </a>
            <?php echo iso_get_post_categories(); ?>
            <?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php the_excerpt(); ?>
        </article>
<?php endswitch ?>


