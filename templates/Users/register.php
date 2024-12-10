<div class="users form form-container">
    <?= $this->Flash->render() ?>
    <h3>Register</h3>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Please Register') ?></legend>
        <?= $this->Form->control('firstname', ['required' => true]) ?>
        <?= $this->Form->control('lastname', ['required' => true]) ?>
        <?= $this->Form->control('username', ['required' => true]) ?>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->button(__('Register')); ?>
    <?= $this->Form->end() ?>
    
    <?= $this->Html->link("Back to Login", ['action' => 'login']) ?>
</div> 