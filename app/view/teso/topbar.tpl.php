<nav>
	<ul>
		<li><a href='<?=$this->url->create('login')?>'>Log in <i class="fa fa-sign-in fa-2x"></i></a>
		<li><a href='<?=$this->url->create('logout')?>'>Log out <i class="fa fa-sign-out fa-2x"></i></a>
		<li><a href='<?=isset($this->di->session->get('user')->id) ? $this->url->create('users/id/'.$this->di->session->get('user')->id) : null?>'>Profile <i class="fa fa-user fa-2x"></i></a>
		<li><a href='<?=$this->url->create('users/add')?>'>Register <i class="fa fa-pencil fa-2x"></i></a>
		<?php if(!empty($this->di->session->get('user'))): ?>
		<li class='smallerText'>Logged in as: <?=$this->di->session->get('user')->acronym?>
		<?php endif; ?>
	</ul>
	
</nav>

