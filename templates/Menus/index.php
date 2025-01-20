<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu[]|\Cake\Collection\CollectionInterface $menus
 */

// Add these in the head section or where you include your scripts
$this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js', ['block' => true]);
$this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', ['block' => true]);
$this->Html->css('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', ['block' => true]);
?>

<div class="menus index content">
    <h3>Gestion des Menus</h3>
    <?php if ($currentUser && $currentUser->permission >= 2): ?>
        <?= $this->Html->link(__('Nouveau Menu'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Intitulé</th>
                <th>Lien</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="sortable-menus">
            <?php foreach ($menus as $menu): ?>
            <tr data-id="<?= $menu->id ?>" class="sortable-row">
                <td class="handle">
                    <?= $this->Number->format($menu->ordre) ?>
                    <?php if ($currentUser && $currentUser->permission >= 2): ?>
                        <span class="drag-handle" style="cursor: move;">⋮⋮</span>
                    <?php endif; ?>
                </td>
                <td><?= h($menu->intitule) ?></td>
                <td><?= h($menu->lien) ?></td>
                <td class="actions">
                    <?php if ($currentUser && $currentUser->permission >= 2): ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $menu->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), 
                            ['action' => 'delete', $menu->id],
                            ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) 
                        ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->append('script'); ?>
<script>
$(document).ready(function() {
    if ($('#sortable-menus').length) {
        $('#sortable-menus').sortable({
            handle: '.drag-handle',
            axis: 'y',
            update: function(event, ui) {
                var positions = [];
                $('.sortable-row').each(function() {
                    positions.push($(this).data('id'));
                });
                
                // Show loading indicator or disable sorting
                $('#sortable-menus').sortable('disable');
                
                // Send the new order to the server
                $.ajax({
                    url: '<?= $this->Url->build(['action' => 'reorder']) ?>',
                    method: 'POST',
                    data: {
                        positions: positions
                    },
                    headers: {
                        'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>'
                    },
                    success: function(response) {
                        // Reload without showing error message
                        window.location.reload();
                    },
                    error: function() {
                        alert('Une erreur est survenue lors de la réorganisation des menus.');
                        window.location.reload();
                    }
                });
            }
        });
    }
});
</script>
<?php $this->end(); ?>

<style>
.drag-handle {
    color: #666;
    margin-left: 10px;
    font-weight: bold;
    display: inline-block;
}
.sortable-row.ui-sortable-helper {
    display: table;
    border: 1px solid #ccc;
    background: #f9f9f9;
}
</style> 