<?php
/** Expects $userBalance (float). */
$userBalance = isset($userBalance) ? (float) $userBalance : 0.0;
?>
<!-- Subscribe Modal -->
<div id="subscribe-modal" class="fixed inset-0 z-50 hidden">
<div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="subscribe-modal-backdrop"></div>
<div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
<div class="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl w-full max-w-md border border-slate-200 dark:border-zinc-800">
<div class="p-6 border-b border-slate-200 dark:border-zinc-800 flex items-center justify-between">
<h2 class="text-xl font-bold">Subscribe to <span id="modal-plan-name"></span></h2>
<button type="button" id="subscribe-modal-close" class="p-2 hover:bg-surface-container-high rounded-full"><span class="material-symbols-outlined">close</span></button>
</div>
<div class="p-6">
<form id="subscribe-form">
<input type="hidden" id="subscribe-plan-id" name="plan_id"/>
<div class="mb-4">
<label class="block text-xs font-bold text-slate-400 uppercase mb-2">Duration</label>
<p id="subscribe-duration-display" class="text-sm font-semibold text-slate-800 dark:text-slate-200">—</p>
<input type="hidden" id="subscribe-duration" name="duration_days"/>
</div>
<div class="mb-4">
<label class="block text-xs font-bold text-slate-400 uppercase mb-2">Investment Amount (USD)</label>
<input type="number" id="subscribe-amount" step="0.01" min="0" class="w-full bg-slate-50 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm border border-slate-200 dark:border-zinc-700" required/>
<p class="text-xs text-slate-500 mt-1">Available USD Balance: $<span id="available-balance"><?php echo format_usd_amount($userBalance); ?></span></p>
<p class="text-xs text-slate-500 mt-1">Range: $<span id="plan-min"></span> - <span id="plan-max"></span></p>
<p id="subscribe-liquidation-note" class="text-xs text-amber-600 dark:text-amber-400 mt-1 hidden">Early liquidation fee: $<span id="plan-liquidation-fee">0.00</span> (deducted from your USD balance).</p>
<?php if ($userBalance <= 0): ?><p class="text-xs text-amber-600 mt-1">Deposit funds to your wallet first.</p><?php endif; ?>
</div>
<div id="subscribe-error" class="text-sm text-red-500 hidden mb-4"></div>
<div class="flex gap-3">
<button type="button" id="subscribe-cancel-btn" class="flex-1 px-4 py-2 bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-slate-300 font-bold rounded-lg">Cancel</button>
<button type="submit" id="subscribe-submit-btn" class="flex-1 px-4 py-2 bg-primary text-black font-bold rounded-lg disabled:opacity-50 disabled:cursor-not-allowed" <?php echo $userBalance <= 0 ? 'disabled' : ''; ?>>Subscribe</button>
</div>
</form>
</div>
</div>
</div>
</div>

<!-- Success Modal -->
<div id="subscribe-success-modal" class="fixed inset-0 z-[60] hidden">
<div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
<div class="absolute inset-0 flex items-center justify-center p-4">
<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-sm border border-emerald-200 dark:border-emerald-900/50 overflow-hidden">
<div class="p-8 text-center">
<div class="w-20 h-20 mx-auto mb-5 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center">
<span class="material-symbols-outlined text-success text-4xl">check_circle</span>
</div>
<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Subscription Successful!</h3>
<p class="text-slate-600 dark:text-slate-400 text-sm mb-1">You've successfully subscribed to <strong class="text-primary" id="success-plan-name"></strong></p>
<p class="text-slate-500 dark:text-slate-500 text-xs">Redirecting to your dashboard…</p>
</div>
</div>
</div>
</div>
