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
        <?php 
            $image = get_field('teaser_image');
            if( $image ) {
                $image_meta = wp_get_attachment_metadata($image);
                $aspect_ratio = iso_aspect_ratio($image_meta['width'] / $image_meta['height']);
                if($aspect_ratio === '1 1/2' || $aspect_ratio === '2/3' ) : ?>
                    <article class="teaser teaser--portfolio teaser--portfolio--<?php echo $aspect_ratio === '2/3' ? '2x3': '3x2'; ?>">
                    <a href="<?php the_permalink(); ?>">
                         <?php echo preg_replace('/(height|width)="\d*"\s/', "", wp_get_attachment_image( $image, 'medium_large' )); ?>
                        <h2><?php the_title(); ?></h2>
                    </a>
                    </article>
                <?php endif;
            }        
        ?>
    <?php break;?>
    <?php 
    case 'location': ?>
        <article class="teaser teaser--location">
            <a href="<?php echo esc_url(get_term_link($term)); ?>">
                <!-- thumb aqui! -->
                <h2><?php echo $term ->name; ?></h2>
            </a>
        </article>
    <?php break;?>

    <?php default: ?>
        <article class="teaser">
            <a class="teaser__media" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large'); ?>
            </a>
            <div class="teaser__text">
                <?php echo iso_get_post_categories(); ?>
                <?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                <?php the_excerpt(); ?>
            </div>
        </article>
<?php endswitch ?>


