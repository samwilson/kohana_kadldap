<div style="margin-left:40px">

<h2>Kadldap Configuration &amp; Connection Test</h2>
<p>Here you can test your Kadldap configuration.</p>

<?php if ($message) echo '<p class="note">'.$message.'</p>' ?>

<?php if (!Auth::instance()->logged_in()): ?>
<script type="text/javascript">
	$().ready(function() {
		$('input[name="username"]').focus();
	});
</script>
<?php echo form::open() ?>
<p>
	<?php echo form::label('username', 'Username:')?>
	<?php echo form::input('username', '', array('id'=>'focus-me')) ?>
	<code><?php echo $kadldap->getAccountSuffix() ?></code>
</p>
<p><?php echo form::label('password', 'Password:')?>
		<?php echo form::password('password') ?></p>
<p><?php echo form::submit('login', 'Login') ?></p>
	<?php echo form::close() ?>

<?php else: // if (!Auth::instance()->logged_in()): ?>

<p>
		You are logged in as
		<code><?php echo Auth::instance()->get_user() ?></code>
		<?php echo html::anchor('kadldap/logout', '[Log out]') ?>
</p>

<h2>User Values</h2>
<table>
	<?php foreach ($userinfo as $label => $info) {
		if (!is_array($info)) continue;
	?>
	<tr>
		<th><code><?php echo $label ?></code></th>
		<td><?php 
			if ($info['count']==1)
			{
				echo $info[0];
			} else
			{
				unset($info['count']);
				echo join ('<br />', $info);
			}
			?>
		</td>
	</tr>
	<?php } // foreach ($userinfo as $label => $info) ?>
</table>
<?php endif ?>

</div>