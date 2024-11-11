<h1>Nos services</h1>
<ul>
    <?php foreach ($services as $service): ?>
        <li>
            <h2><?php echo $service['name']; ?></h2>
            <p><?php echo $service['description']; ?></p>
        </li>
    <?php endforeach; ?>
</ul>