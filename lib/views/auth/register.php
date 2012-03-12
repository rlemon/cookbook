<?php
	function set_value($value) {
		if( isset($value) && !empty($value) ) {
			echo 'value="'. $value . '"';
		}
	}
?>
<form class="well form-horizontal" method="post" action="/auth/register">
	<input type="hidden" name="identity" <?php set_value($_GET['identity']);?>>
	<h1>Opps! This is embarrassing</h1>
	<h1><small>but we need a bit more information to continue...</small></h1>
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="username">Username</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="username" name="username" <?php set_value($_GET['nickname']);?> placeholder="Must be unique...">
        <p class="help-block" id="username-help-block"></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="fullname">Full Name</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="fullname" name="fullname" <?php set_value($_GET['fullname']);?> placeholder="Firstname, Lastname">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="email">Email</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="email" name="email" <?php set_value($_GET['email']);?> placeholder="john.smith@gmail.com">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="dob">Date of Birth</label>
      <div class="controls">
        <select class="input-medium" id="dob" name="dob-month">
			<option selected="selected">Month</option>
			<option value="1">January</option>
			<option value="2">February</option>
			<option value="3">March</option>
			<option value="4">April</option>
			<option value="5">May</option>
			<option value="6">June</option>
			<option value="7">July</option>
			<option value="8">August</option>
			<option value="9">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
        </select>
        <select class="input-mini" id="dob" name="dob-day">
			<option selected="selected">Day</option>
			<?php for($i = 1; $i <= 31; $i++):?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
			<?php endfor;?>
        </select>
        <input type="text" class="input-mini" name="dob-year" placeholder="Year...">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="gender">Gender</label>
      <div class="controls">
        <input type="text" class="input-large" id="gender" name="gender" <?php set_value($_GET['gender']);?> placeholder="Male/Female/?">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="location">Location</label>
      <div class="controls">
        <input type="text" class="input-medium" id="location" name="country" <?php set_value($_GET['country']);?> placeholder="Current Country...">
        <input type="text" class="input-small" id="location" name="postcode" <?php set_value($_GET['postcode']);?> placeholder="Post/Zip code...">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="language">Language</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="location" <?php set_value($_GET['language']);?> name="language" placeholder="Languages spoken...">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="timezone">Timezone</label>
      <div class="controls">
        <input type="text" class="input-medium" id="timezone" <?php set_value($_GET['timezone']);?> name="timezone" placeholder="GMT -5...">
      </div>
    </div>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary" name="register">Continue</button>
		<button class="btn">Cancel</button>
	</div>
  </fieldset>
</form>
