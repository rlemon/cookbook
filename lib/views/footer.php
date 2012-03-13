
<footer class="span12">
	<p class="pull-left">© Robert Lemon 2012 - <a href="http://rlemon.com">rlemon.com</a> 
	<p class="pull-right">stay current | <a href="http://blog.rlemon.com">blog</a> | <a href="http://twitter.com/thegreatrupert">twitter</a> | <a href="http://github.com/rlemon">github</a> </p>
</footer>
</div>

<script type="text/javascript" src="/assets/js/common.js"></script>
<?php if( isset( $this->scripts ) ): ?>
<?php foreach($this->scripts as $script): ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>
</body>
</html>
