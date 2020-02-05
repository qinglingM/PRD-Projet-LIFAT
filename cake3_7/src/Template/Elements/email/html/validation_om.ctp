<?php $this->Html->docType(); ?>

<html>
<body>

<p><?=$secretarieName?>,</p>

<p>L’ordre de mission ci-joint a été saisi par <?=$first_name?> <?=$name?> et validé par le responsable d’équipe. Il s’agit d’un déplacement qui aura lieu du <?=$date_d?> à <?=$date_r?> et qui a comme intitulé « <?=$motif?> ».</p>

<p>Pour information, la liste des Ordres de Mission reste consultable en ligne sur le site de gestion des Ordres de Mission.</p>

<p>Pour mettre à jour le document excel, vous pouvez copier/coller la ligne suivante :
<?php echo $first_name."\t".$name."\t".$equipe."\t\t\t".$date_d."\t".$lieu."\t".$motif ?></p>

<p>Bonne reception.</p>

<p>PS : ceci est un email envoyé automatiquement par le site de gestion des Ordres de Mission</p>

</body>
</html>
