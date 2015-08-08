<form method="post">
	<div class="form-group">
		<label for="auth_login">Логин</label>
		<input id="auth_login" class="form-control" type="text" name="auth_login" placeholder="Логин"
			   value="<?= $_SESSION['msg']['auth']['login'] ?>"/><br>

		<label for="auth_password">Пароль</label>
		<input id="auth_password" class="form-control" type="password" name="auth_password" placeholder="Пароль"
			   value="<?= $_SESSION['msg']['auth']['password'] ?>"/>

		<div class="checkbox">
			<label for="remember">
				<input type="checkbox" name="remember" id="remember"/>Запомнить меня
			</label>
		</div>

		<input type="submit" name="auth" class="btn btn-primary" value="Войти"/>
		<br />
		<br />
		<p><a href="?action=registration">Регистрация</a> | <a href="?action=restorepass">Восстановить пароль</a></p>
	</div>
</form>