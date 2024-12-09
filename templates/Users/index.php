<div class="users index content">
    <h3>Utilisateurs</h3>
    <table>
        <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->firstname) ?></td>
                <td><?= h($user->lastname) ?></td>
                <td><?= $user->created->format('d/m/Y') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> 