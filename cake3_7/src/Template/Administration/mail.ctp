<?php echo $this->Session->flash('email'); ?>

<?php echo $this->Session->flash(); ?>

<h2>Paramètre du serveur d'envoi des mails</h2>

<?php

echo $this->Form->create(false, array( 'method' => "post", 'action' => "/mail"));
echo $this->Form->input('port');
echo $this->Form->input('timeout');
echo $this->Form->input('host');
echo $this->Form->end('Sauver les paramètres');

?>