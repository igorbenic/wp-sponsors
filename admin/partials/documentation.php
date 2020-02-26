<?php
/**
 * Documentation Page
 */
?>
<div class="wrap">
	<h1><?php echo get_admin_page_title(); ?></h1>
	<h2><?php esc_html_e( 'Shortcodes', 'wp-sponsors' ); ?></h2>
	<h3><?php esc_html_e( 'Sponsors', 'wp-sponsors' ); ?></h3>
	<p><strong>[sponsors]</strong></p>
	<table class="form-table fixed striped">
		<thead>
			<tr>
				<td style="background:rgba( 0, 0, 0, 0.15);"><?php esc_html_e( 'Attribute', 'wp-sponsors' ); ?></td>
				<td style="background:rgba( 0, 0, 0, 0.15);"><?php esc_html_e( 'Description', 'wp-sponsors' ); ?></td>
				<td style="background:rgba( 0, 0, 0, 0.15);"><?php esc_html_e( 'Value', 'wp-sponsors' ); ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><code>images</code></td>
				<td><?php esc_html_e( 'Display or not the images', 'wp-sponsors' ); ?></td>
				<td>
					<p>
					<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
					yes, no
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>yes</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>image_size</code></td>
				<td><?php esc_html_e( 'Which image size will the images be', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						medium|full|thumbnail|large|[<?php esc_html_e( 'any registered image size', 'wp-sponsors' ); ?>]
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>medium</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>description</code></td>
				<td><?php esc_html_e( 'Display or not the description', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						yes, no
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>no</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>max</code></td>
				<td><?php esc_html_e( 'How many sponsors will we show', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'any number', 'wp-sponsors' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong><?php esc_html_e( 'none, showing all sponsors', 'wp-sponsors' ); ?></strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>title</code></td>
				<td><?php esc_html_e( 'Display or not the title of the sponsor', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						yes, no
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>no</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>category</code></td>
				<td><?php esc_html_e( 'Show sponsors under a specific category', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'Any category slug', 'wp-sponsors' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>all</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>with_categories</code></td>
				<td><?php esc_html_e( 'Display sponsors with categories. It will separate sponsors by categories.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						yes, no
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>no</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>category_title</code></td>
				<td><?php esc_html_e( 'HTML tag for the category title', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'Any HTML tag', 'wp-sponsors' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>h3</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>style</code></td>
				<td><?php esc_html_e( 'Style of showing the sponsors.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						list, grid, slider
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>list</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>order</code></td>
				<td><?php esc_html_e( 'How will we order the sponsors.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						ASC, DESC
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>ASC</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>orderby</code></td>
				<td><?php esc_html_e( 'What data are we using to order.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						menu_order, post_title, post_content, ...
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>menu_order</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>adaptiveheight</code></td>
				<td><?php esc_html_e( 'Adaptive Height when using slider layout.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						1, 0
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>1</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>autoplay</code></td>
				<td><?php esc_html_e( 'Autoplay the slides when using slider layout.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						1, 0
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>1</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>autoplayspeed</code></td>
				<td><?php esc_html_e( 'Speed of the autoplay of slides when using slider layout.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'any number. Represents miliseconds.', 'wp-sponsors' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>3000</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>arrows</code></td>
				<td><?php esc_html_e( 'Showing slider arrows.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						1, 0
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>1</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>centermode</code></td>
				<td><?php esc_html_e( 'Center the slides.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						1, 0
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>0</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>dots</code></td>
				<td><?php esc_html_e( 'Using slider dots.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						1, 0
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>0</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>infinite</code></td>
				<td><?php esc_html_e( 'Should the slider be infinite or not.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						1, 0
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>1</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>slidestoshow</code></td>
				<td><?php esc_html_e( 'How many slides are going to be shown.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'any number.', 'wp-sponsors' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>1</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>slidestoscroll</code></td>
				<td><?php esc_html_e( 'How many slides are going to be scrolled.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'any number.', 'wp-sponsors' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>1</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>variablewidth</code></td>
				<td><?php esc_html_e( 'Should the slide width represent the image/content width.', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						0, 1
					</p>
					<p>
						<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
						<strong>0</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td><code>breakpoints</code></td>
				<td><?php esc_html_e( 'Adding responsive breakpoints to define how many images will be shown and slide', 'wp-sponsors' ); ?></td>
				<td>
					<p>
						<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'string in format screen_size_px;images_to_show;images_to_slide.', 'wp-sponsors' ); ?>
						<?php esc_html_e( 'To define multiple breakpoints separate them by |.', 'wp-sponsors' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'No Default Value.', 'wp-sponsors' ); ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<p><strong><?php esc_html_e( 'Example of using breakpoints attribute:', 'wp-sponsors' ); ?></strong></p>
	<p><?php esc_html_e( 'For example, we want to show 3 images on large screens and slide 3 images on click. Then on 640px view, we want to show 2 and slide 2 images. And on 480px view, we want only 1 image and 1 image to slide.', 'wp-sponsors' ); ?></p>
	<p><?php esc_html_e( 'We would use the shortcode like this:', 'wp-sponsors' ); ?></p>

	<code>[sponsors style=slider arrows=1 image_size=full slidestoscroll=3 slidestoshow=3 breakpoints=480;1;1|640;2;2]</code>

	<p><?php esc_html_e( 'The attribute **breakpoints** uses format "screen_px;images_to_show;images_to_slide". Then for multiple breakpoints, we separate them by "|".', 'wp-sponsors' ); ?></p>
	<p><?php esc_html_e( 'In the above example we have separated 2 breakpoints 480px and 640px.', 'wp-sponsors' ); ?></p>
	<p><?php esc_html_e( 'For 480px, we set 1 for images to show and 1 for images to slide.', 'wp-sponsors' ); ?></p>
	<p><?php esc_html_e( 'For 640px, we set 2 for images to show and 2 for images to slide.', 'wp-sponsors' ); ?></p>

<hr/>
	<h3><?php esc_html_e( 'Form', 'wp-sponsors' ); ?></h3>
	<p><strong>[sponsors_acquisition_form]</strong></p>

	<p><?php esc_html_e( 'This shortcode will display a form so potential sponsors can submit their information.', 'wp-sponsors' ); ?></p>
	<p><?php esc_html_e( 'Each Sponsor entered with that form will become a Draft so they won\'t be displayed immediately.', 'wp-sponsors' ); ?></p>
	<p><?php esc_html_e( 'You can publish them, or send them an email to get their logo as well.', 'wp-sponsors' ); ?></p>

	<p><?php esc_html_e( 'Fields that are displayed:', 'wp-sponsors' ); ?></p>
	<ul>
		<li><?php esc_html_e( 'Name', 'wp-sponsors' ); ?></li>
		<li><?php esc_html_e( 'Email (so you can email them about their submission)', 'wp-sponsors' ); ?></li>
		<li><?php esc_html_e( 'Description', 'wp-sponsors' ); ?></li>
		<li><?php esc_html_e( 'Link', 'wp-sponsors' ); ?></li>
	</ul>
	<table class="form-table fixed striped">
		<thead>
		<tr>
			<td style="background:rgba( 0, 0, 0, 0.15);"><?php esc_html_e( 'Attribute', 'wp-sponsors' ); ?></td>
			<td style="background:rgba( 0, 0, 0, 0.15);"><?php esc_html_e( 'Description', 'wp-sponsors' ); ?></td>
			<td style="background:rgba( 0, 0, 0, 0.15);"><?php esc_html_e( 'Value', 'wp-sponsors' ); ?></td>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><code>fields</code></td>
			<td><?php esc_html_e( 'Additional Fields to be added', 'wp-sponsors' ); ?></td>
			<td>
				<p>
					<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
					<?php esc_html_e( 'any field keys separated by comma.', 'wp-sponsors' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'No Default Value.', 'wp-sponsors' ); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td><code>fields_labels</code></td>
			<td><?php esc_html_e( 'Labels for Additional Fields', 'wp-sponsors' ); ?></td>
			<td>
				<p>
					<?php esc_html_e( 'Possible Values:', 'wp-sponsors' ); ?>
					<?php esc_html_e( 'labels separated by comma in the same order as fields.', 'wp-sponsors' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'No Default Value.', 'wp-sponsors' ); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td><code>button</code></td>
			<td><?php esc_html_e( 'Form button text', 'wp-sponsors' ); ?></td>
			<td>
				<p>
					<?php esc_html_e( 'Default Value:', 'wp-sponsors' ); ?>
					Submit
				</p>
			</td>
		</tr>
		</tbody>
	</table>
	<p><?php esc_html_e( 'Each defined field will be a textarea. For example, you can add more fields like this:', 'wp-sponsors' ); ?></p>

	<code>[sponsors_acquisition_form fields=about,what fields_labels=About,What?]</code>
</div>
