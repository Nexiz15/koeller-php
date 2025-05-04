<?php
$collapsed = isset($_GET['collapsed']);
$expandableClass = $collapsed ? 'expandable open' : 'expandable';
?>

<div class="<?= $expandableClass ?>">
    <div class="expandable-header" onclick="toggleExpandable(this)">
        <span class="expandable-header-text">Für andere User hinzufügen</span>
        <i class="expandable-chevron fa-solid fa-chevron-down"></i>
    </div>
    <div class="expandable-content-wrapper" style="<?= !$collapsed ? '' : 'max-height: none; opacity: 1;' ?>">
        <div class="expandable-content">
            <?php include 'addDrinkForAnotherUserTable.php'; ?>
            <?php include 'drinkForAnotherUserTable.php'; ?>
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
<style>
    .expandable-content {
        background-color: #ecf4f7;
    }

    .expandable-content-wrapper {
        background-color: #ecf4f7;
    }

    .expandable-table {
        background-color: #ecf4f7;
    }

    .expandable-table th,
    .expandable-table td {
        background-color: #ecf4f7;
    }

    .expandable-content .basic-input {
        border: none;
        outline: none;
        border-bottom: 1px solid #05212a;
        margin-bottom: 10px;
        margin-right: 25px;
        border-radius: 0;
        width: 30px;
        background-color: #ecf4f7;
    }
</style>
