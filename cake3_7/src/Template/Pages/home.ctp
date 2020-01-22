<?php

$this->assign('title', 'Lifat manager');

echo $this->Html->tag('h2', 'Présentation du site');
echo $this->Html->para('', 'Ce site permet la gestion du laboratoire d\'informatique de l\'université de Tours.');

echo $this->Html->para('', 'Vous avez la possibilité de créer un compte sur notre site.');

echo $this->Html->tag('h2', 'Inscription et connexion');
echo '<p>Si vous n\'avez jamais utilisé le site, il faut vous inscrire en ';
echo $this->Html->link('cliquant ici', array('controller' => 'membres', 'action' => 'edit'));
echo '.</p>';
echo '<p>Si vous possédez déjà un compte, vous pouvez vous connecter par ici : ';

echo $this->Html->link('Connexion par mot de passe', array('controller' => 'membres', 'action' => 'login'));
echo '.</p>';

?>