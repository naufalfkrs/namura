<?php include_once("views/layouts/header.php"); ?>
<h1><?= $title ?></h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Sponsor</th>
            <th>Logo</th>
            <th>Kontribusi</th>
            <th>Event</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sponsors as $index => $sponsor): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($sponsor['name']) ?></td>
                <td><img src="<?= htmlspecialchars($sponsor['logo_url']) ?>" alt="Logo" width="100"></td>
                <td><?= htmlspecialchars($sponsor['contribution']) ?></td>
                <td><?= htmlspecialchars($sponsor['event_name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_once("views/layouts/footer.php"); ?>
