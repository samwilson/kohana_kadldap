<h2>Kadldap Configuration &amp Connection Test</h2>

<?php if ($message): ?>
<p style="border: 3px double #911; padding:0.3em; font-size:1.3em; font-weight:bolder">
		<?php echo $message ?>
</p>
<?php endif ?>


<?php if (!auth::instance()->logged_in()): ?>

<script type="text/javascript">
	$().ready(function() {
		$('input[name="username"]').focus();
	});
</script>

<p>Here you can test your Kadldap configuration.</p>

	<?php echo form::open() ?>
<p><?php echo form::label('username', 'Username:')?>
		<?php echo form::input('username', '', array('id'=>'focus-me')) ?></p>
<p><?php echo form::label('password', 'Password:')?>
		<?php echo form::password('password') ?></p>
<p><?php echo form::submit('login', 'Login') ?></p>
	<?php echo form::close() ?>

<?php else: ?>

<p>
		You are now logged in as
		<?php echo auth::instance()->get_user().$kadldap->get_account_suffix() ?>
		<?php echo html::anchor('kadldap/logout', '[Log out]') ?>
</p>
<!--p>Some information about your account:</p-->
	<?php //$userinfo = $kadldap->user_info(auth::instance()->get_user()) ?>
<!--ul>
	<li>Department: <?php //echo $userinfo['department'] ?></li>
</ul-->
<!--p>User in 'admin'? <?php //echo auth::instance()->logged_in('admin') ?></p-->

<!--h2>What information is available from the LDAP Auth driver?</h2>
<dl>

</dl-->

<h2>What information is available from the Kadldap class?</h2>

<p><em>This section is not yet complete.</em></p>

<dl>
	<dt>Kadldap::all_contacts()</dt>
	<dd><?php echo kohana::debug($kadldap->all_contacts()) ?></dd>
	<dt>all_distribution_groups</dt>
	<dd><?php echo kohana::debug($kadldap->all_distribution_groups()) ?></dd>
	<dt>get_account_suffix</dt>
	<dd><?php echo kohana::debug($kadldap->get_account_suffix()) ?></dd>
	<dt>Kadldap::user_info($username)</dt>
	<dd><?php echo kohana::debug($kadldap->user_info(auth::instance()->get_user())) ?></dd>
	<dt>Kadldap::user_groups($username)</dt>
	<dd><?php echo kohana::debug($kadldap->user_groups(auth::instance()->get_user())) ?></dd>
</dl>

<?php endif ?>
