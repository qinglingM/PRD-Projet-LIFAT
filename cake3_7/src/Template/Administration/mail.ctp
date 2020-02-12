

<h2>Paramètre du serveur d'envoi des mails</h2>

<?php

echo $this->Form->create(false, array( 'method' => "post", 'action' => "mail"));
echo $this->Form->control('port');
echo $this->Form->control('timeout');
echo $this->Form->control('host');
echo $this->Form->button(__('Sauvegarder les paramètres')); 
echo $this->Form->end();

?>