<div id="content" role="main">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo get_post_meta( get_the_ID(), 'projectmap-description', true)?></p>
		<p><b>Kategorie: <?php echo get_post_meta( get_the_ID(), 'projectmap-category', true)?></b></p>

		<a href="<?php echo get_post_meta( get_the_ID(), 'projectmap-link', true)?>"><?php echo get_post_meta( get_the_ID(), 'projectmap-link', true)?></a>
		
		<h3>GeoJSON</h3>
		<p><?php echo get_post_meta( get_the_ID(), 'projectmap-geojson', true)?> </p>
        
    </div>
    <?php endwhile; endif; ?>
</div>
