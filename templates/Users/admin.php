<div class="users view">
    <h3>Admin Dashboard</h3>
    <p>Welcome, <?= h($user->username) ?></p>
    <?= $this->Html->link("Logout", ['action' => 'logout']) ?>
</div> 