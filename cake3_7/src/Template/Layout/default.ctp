<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>
		<?= $this->fetch('title') ?>
	</title>

	<?= $this->Html->meta('icon') ?>

	<?= $this->Html->css('base.css') ?>
	<?= $this->Html->css('style-ok.css') ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body>
<?= $this->Flash->render() ?>
<div id="main">
	<!-- Header -->
	<?php
	// titre du site (banniere)
	echo $this->Html->div('', null, array('id' => 'header'));
	echo $this->Html->link('<h1>LIFAT Manager</h1>', ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]);
	echo '</div>';
	?>

	<!-- Navbar -->
	<?php
	echo $this->element('navbar');
	?>

	<!-- Contenu -->
	<div id="content">
		<div class="container clearfix">
			<?= $this->fetch('content') ?>
		</div>
	</div>

	<!-- Pied de page -->
	<?php
	echo $this->Html->div('', null, array('id' => 'footer'));
	echo $this->Html->para('', 'Site réalisé à l\'initiative du Laboratoire d\'Informatique de l\'université François Rabelais');
	echo '</div>';
	?>
</div>
</body>
</html>