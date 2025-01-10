<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Mot de passe oublié</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('email', ['label' => 'Votre adresse email']) ?>
    </fieldset>
    <?= $this->Form->button(__('Réinitialiser le mot de passe')); ?>
    <?= $this->Form->end() ?>
    
    <div class="actions">
        <?= $this->Html->link("Retour à la connexion", ['action' => 'login']) ?>
    </div>
</div> 