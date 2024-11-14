<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Services</title>
    <link rel="stylesheet" href="../../components/css/manage_services.css">
</head>
<body>
    <h2>Gestion des Services du Zoo</h2>

    <!-- Assurez-vous que $services est toujours un tableau, même s'il est vide -->
    <?php if (!isset($services) || !is_array($services)) { $services = []; } ?>

    <form action="index.php?action=updateService" method="post">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Service</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($services) > 0): ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo $service['id']; ?></td>
                            <td><input type="text" name="service_name_<?php echo $service['id']; ?>" value="<?php echo $service['name']; ?>"></td>
                            <td><input type="text" name="service_description_<?php echo $service['id']; ?>" value="<?php echo $service['description']; ?>"></td>
                            <td>
                                <input type="submit" value="Modifier" name="submit_<?php echo $service['id']; ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun service disponible.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</body>
</html>