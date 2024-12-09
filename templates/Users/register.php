<div class="users form form-container">
    <?= $this->Flash->render() ?>
    <h3>Register</h3>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Register')); ?>
    <?= $this->Form->end() ?>
    
    <?= $this->Html->link("Back to Login", ['action' => 'login']) ?>
</div> 