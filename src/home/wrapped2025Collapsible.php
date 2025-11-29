<?php
$collapsed = isset($_GET['collapsed']);
$expandableClass = $collapsed ? 'expandable open' : 'expandable';

$today      = new DateTime();
$startDate  = DateTime::createFromFormat('d.m.Y', '29.11.2025');
$endDate    = DateTime::createFromFormat('d.m.Y', '10.01.2026');

if ($today >= $startDate && $today <= $endDate):
?>
    <div class="<?= $expandableClass ?>">
        <div class="expandable-header" onclick="toggleExpandable(this)">
            <span class="expandable-header-text">Dein Kölla Wrapped 2025</span>
            <i class="expandable-chevron fa-solid fa-chevron-down"></i>
        </div>
        <div class="expandable-content-wrapper" style="<?= !$collapsed ? '' : 'max-height: none; opacity: 1;' ?>">
            <div class="expandable-content">
                <?php include 'wrapped2025Info.php'; ?>
            </div>
        </div>
    </div>
<?php
endif;
?>

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
    .expandable {
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .expandable-header {
        padding: 5px 20px 5px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        background-color: #05212a;
        color: white;
    }

    .expandable-header-text {
        @media (max-width: 767px) {
            margin: 0 auto;
        }
    }

    .expandable-chevron {
        transition: transform 0.3s ease;
    }

    .expandable.open .expandable-chevron {
        transform: rotate(180deg);
    }

    .expandable-content-wrapper {
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.4s ease, opacity 0.4s ease;
    }

    .expandable.open .expandable-content-wrapper {
        opacity: 1;
    }

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

    .text-break-word {
        word-break: break-word;
        hyphens: auto;
    }
</style>
