<?php
$collapsed = isset($_GET['collapsed']);
$expandableClass = $collapsed ? 'expandable open' : 'expandable';
?>

<div class="<?= $expandableClass ?>">
    <div class="expandable-header" onclick="toggleExpandable(this)">
        Für andere User hinzufügen
        <i class="expandable-chevron fa-solid fa-chevron-down"></i>
    </div>
    <div class="expandable-content-wrapper" style="<?= !$collapsed ? '' : 'max-height: none; opacity: 1;' ?>">
        <div class="content">
            <?php include 'addDrinkForAnotherUserTable.php'; ?>
        </div>
    </div>
</div>

<script>
function toggleExpandable(headerEl) {
    const expandable = headerEl.parentElement;
    const wrapper = expandable.querySelector('.expandable-content-wrapper');

    if (expandable.classList.contains('open')) {
        wrapper.style.maxHeight = wrapper.scrollHeight + 'px';
        requestAnimationFrame(() => {
            wrapper.style.maxHeight = '0';
        });
        expandable.classList.remove('open');
    } else {
        wrapper.style.maxHeight = wrapper.scrollHeight + 'px';
        expandable.classList.add('open');

        wrapper.addEventListener('transitionend', function removeHeight() {
            wrapper.style.maxHeight = 'none';
            wrapper.removeEventListener('transitionend', removeHeight);
        });
    }
}
</script>
