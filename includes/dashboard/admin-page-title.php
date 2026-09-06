<?php
if (empty($pageHeading)) return;
?>
<header class="mb-8 md:mb-10">
<h2 class="dash-page-title font-headline-lg text-headline-lg tracking-tight"><?php echo htmlspecialchars($pageHeading); ?></h2>
<?php if (!empty($pageSubtitle)): ?>
<p class="text-text-secondary mt-1"><?php echo htmlspecialchars($pageSubtitle); ?></p>
<?php endif; ?>
</header>
