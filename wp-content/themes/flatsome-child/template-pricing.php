<?php
/*
Template name: Page - Princing template
*/
get_header(); 
do_action( 'flatsome_before_page' ); 

?>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

<div id="content" class="main-container" role="main">
	<div class="components-section header-section">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','pageHeader'); 
			?>
		</div>
	</div>
	<div class="components-section bg-grey">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','tabs'); 
			?>
			</div>
	</div>
	<div class="components-section bg-grey">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','table'); 
			?>
			</div>
	</div>
	<div class="components-section">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','plansInclude'); 
			?>
			</div>
	</div>
	<div class="components-section bg-grey-2">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','planBestPlan'); 
			?>
			</div>
	</div>
	<div class="components-section bg-grey-3">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','whyDacast'); 
			?>
			</div>
	</div>
	<div class="components-section">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','faq'); 
			?>
			</div>
	</div>
	<div class="components-section bg-grey">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','questions'); 
			?>
			</div>
	</div>
	<div class="components-section">
		<div class="components-container">
			<?php 
			get_template_part( 'template-parts/content','carrousel'); 
			?>
			</div>
	</div>
	<div class="components-section bg-footer-image">
		<div class="">
			<?php 
			get_template_part( 'template-parts/content','footerBanner'); 
			?>
			</div>
	</div>
</div>

<?php
do_action( 'flatsome_after_page' ); ?>

<?php 

get_footer(); ?>
