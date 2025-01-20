<div class="users view">
    <h3>User Dashboard</h3>
    <p>Welcome, <?= h($user->username) ?></p>
    <?= $this->Html->link("Logout", ['action' => 'logout']) ?>
</div> 