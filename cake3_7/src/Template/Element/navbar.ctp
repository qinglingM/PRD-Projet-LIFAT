<?php

use App\Model\Entity\Membre;

?>
<?php
if (!empty($user)) {
	echo '<div class="text-right">';
	echo "Connecté en tant que : " . $user['prenom'] . ' ' . $user['nom'] . ' (';
	if ($user['actif'] === true) {
		echo $user['role'];
		if ($user['permanent'] === true && $user['role'] != Membre::ADMIN) {
			echo " permanent";
		}
	} else {
		echo "Compte désactivé";
	}
	echo ") ";
	echo "</div>";
}
?>


<div id="menu">
	<ul>
		<?php if (!empty($user)): ?>                <!--	Si user non connecté : il ne peut faire que Connexion et Inscription	-->
			<?php if ($user['actif'] === true): ?>    <!--	Si user non activé : il ne peut faire que Mon Profil et Déconnexion	-->
				<li class="nav-item">
					<?= $this->Html->link(__('Membres'), ['controller' => 'membres', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Équipes'), ['controller' => 'equipes', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Missions'), ['controller' => 'missions', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Projets'), ['controller' => 'projets', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Thèses'), ['controller' => 'theses', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Lieux de travail'), ['controller' => 'lieu-travails', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Financements'), ['controller' => 'financements', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Export'), ['controller' => 'export', 'action' => 'index']) ?>
				</li>
				<li class="nav-item">
					<?= $this->Html->link(__('Fichiers'), ['controller' => 'fichiers', 'action' => 'index']) ?>
				</li>
			<?php endif; ?>
			<li class="nav-item">
				<?= $this->Html->link(__('Mon Profil'), ['controller' => 'membres', 'action' => 'view', $user['id']]) ?>
			</li>
			<li class="nav-item">
				<?= $this->Html->link(__('Déconnexion'), ['controller' => 'membres', 'action' => 'logout']) ?>
			</li>
		<?php else: ?>
			<li class="nav-item"><?= $this->Html->link(__('Connexion'), ['controller' => 'membres', 'action' => 'login']) ?></li>
			<li class="nav-item"><?= $this->Html->link(__('Inscription'), ['controller' => 'membres', 'action' => 'register']) ?></li>
		<?php endif; ?>
	</ul>
</div>