<div class="keywords">
    <label><?php echo __d('powiadomienia', "LC_POWIADOMIENIA_GRUPY_USER") ?>:</label>
    <button class="btn btn-success btn-sm addphrase pull-right">+</button>
    <ul>
        <?php echo $this->element('Powiadomienia.groups', array('groups' => $groups)); ?>
    </ul>
</div>