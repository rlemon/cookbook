<div class="span12 well">
	<div class="pull-left">
		
		<ul class="thumbnails">
		<?php foreach($this->recipes as $recipe): ?>
			<li class="span3">
			<div class="thumbnail">
				<img src="/<?php echo $recipe['picture']; ?>" alt="">
				<div class="caption">
					<h5><?php echo $recipe['name']; ?></h5>
					<p>
						<small>by <a href="#"><?php echo $recipe['owner_id']; ?></a>.</small>
					</p>
					<p>
						<small>tagged:</small>
						<?php foreach( $recipe['tags'] as $tag ): ?>
							<span class="label"><?php echo $tag['name']; ?></span>
						<?php endforeach; ?>
					</p>
					<p class="action-line">
						<a href="#"><i class="ghicon ghicon-fork"></i> Fork</a><a href="#" class="pull-right"><i class="icon-star-empty"></i> Favorite</a>
					</p>
				</div>
			</div>
			</li>
		<?php endforeach; ?>
		</ul>

	</div>
	<!-- Side Menu -->
	<ul class="nav nav-pills nav-stacked span3 pull-right">
		<li class="nav-header">Collection</li>
		<li class="active"><a href="/collection/my_recipes">My Recipes</a></li>
		<li><a href="/collection/new_recipe">New Recipe</a></li>
	</ul>
	<!-- /Side Menu -->
</div>
<!-- /span12 -->
