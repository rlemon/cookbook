<div class="span12 well">
	<div class="pull-left span8">
		<form enctype="multipart/form-data" method="post" class="form-horizontal">
		<fieldset>
			<legend>General Information</legend>
			<div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="name" name="name">
					<p class="help-block">Avoid common names like 'Apple Pie', 'MeatLoaf', ect.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="description">Description</label>
				<div class="controls">
					<textarea class="input-xlarge" id="description" name="description" rows="3"></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="picture">Picture</label>
				<div class="controls">
					<input class="input-file" id="picture" name="picture" type="file">
					<p class="help-block">Image must be at least 260*180. PNG, JPEG, or GIF only.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="tags">Tags</label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="tags" name="tags">
					<p class="help-block">Type your tags separated by spaces.</p>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<label class="checkbox">
					<input type="checkbox" id="is_private" name="is_private" value="1">
					I want to make this recipe private.
					</label>
				</div>
			</div>


			<legend>Ingredients</legend>
			<div class="control-group">
				<div class="controls">
					<a href="#" class="btn btn-small"><i class="icon-plus"></i> Add Ingredient</a> 
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">1.</label>
				<div class="controls">
					<input type="text" class="span1" name="ingredient-amount-1">
					<select class="span1" name="ingredient-unit-1">
						<option></option>
						<option value="tsp">tsp</option>
						<option value="tbsp">tbsp</option>
						<option value="cup">cup</option>
						<option value="ml">ml</option>
						<option value="l">litre</option>
						<option value="g">gram</option>
						<option value="kg">kg</option>
					</select>
					<input class="span3" type="text" name="ingredient-1">
						<a href="#" class="btn btn-mini btn-inverse"><i class="icon-remove icon-white"></i> remove</a>
					<p class="help-inline">
					</p>
				</div>
			</div>
			
			<legend>Directions</legend>
			<div class="control-group">
				<label class="control-label">Prep Time</label>
				<div class="controls">
					<input class="span1" type="text" name="prep-hours"><span class="help-inline">hrs </span>
					<input class="span1" type="text" name="prep-minutes"><span class="help-inline">mins </span>
				</div>
			</div>
			<div class="control-group form-inline">
				<label class="control-label">Cook Time</label>
				<div class="controls">
					<input class="span1" type="text" name="cook-hours"><span class="help-inline">hrs </span>
					<input class="span1" type="text" name="cook-minutes"><span class="help-inline">mins </span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="prep-directions">Prep Directions</label>
				<div class="controls">
					<textarea class="input-xlarge" id="prep-directions" name="prep-directions" rows="6"></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="directions">Cooking Directions</label>
				<div class="controls">
					<textarea class="input-xlarge" id="directions" name="directions" rows="8"></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="post-directions">After Cooking</label>
				<div class="controls">
					<textarea class="input-xlarge" id="post-directions" name="post-directions" rows="3"></textarea>
				</div>
			</div>
			
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button class="btn">Cancel</button>
			</div>
		</fieldset>
		</form>
	</div>
	<!-- Side Menu -->
	<ul class="nav nav-pills nav-stacked span3 pull-right">
		<li class="nav-header">Collection</li>
		<li><a href="/collection/my_recipes">My Recipes</a></li>
		<li class="active"><a href="/collection/new_recipe">New Recipe</a></li>
	</ul>
	<!-- /Side Menu -->
</div>
<!-- /span12 -->
