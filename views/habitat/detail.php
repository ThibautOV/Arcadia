<h1>Détails de l'habitat : <?php echo $habitat['name']; ?></h1>
<p><?php echo $habitat['description']; ?></p>
<h2>Animaux présents :</h2>
<ul>
    <?php foreach ($habitat['animals'] as $animal): ?>
        <li>
            <h3><?php echo $animal['name']; ?> (<?php echo $animal['species']; ?>)</h3>
            <p>État : <?php echo $animal['state']; ?></p>
            <img src="/public/images/<?php echo $animal['images'][0]; ?>" alt="<?php echo $animal['name']; ?>">
        </li>
    <?php endforeach; ?>
</ul>