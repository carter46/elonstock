<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('subscribe-modal');
    if (!modal) return;

    var backdrop = document.getElementById('subscribe-modal-backdrop');
    var closeBtn = document.getElementById('subscribe-modal-close');
    var cancelBtn = document.getElementById('subscribe-cancel-btn');
    var subscribeBtns = document.querySelectorAll('.subscribe-plan-btn');
    var form = document.getElementById('subscribe-form');
    var planMinEl = document.getElementById('plan-min');
    var planMaxEl = document.getElementById('plan-max');
    var planNameEl = document.getElementById('modal-plan-name');
    var planIdEl = document.getElementById('subscribe-plan-id');
    var amountEl = document.getElementById('subscribe-amount');
    var errorEl = document.getElementById('subscribe-error');
    var balanceEl = document.getElementById('available-balance');
    var availableBalance = balanceEl ? parseFloat(balanceEl.textContent.replace(/,/g, '')) || 0 : 0;
    var currentPlanMin = 0;
    var currentPlanMax = 0;
    var durationInput = document.getElementById('subscribe-duration');
    var durationDisplay = document.getElementById('subscribe-duration-display');
    var currentPlanDays = 7;
    var liqNoteEl = document.getElementById('subscribe-liquidation-note');
    var liqFeeEl = document.getElementById('plan-liquidation-fee');

    function openModal(planId, planName, planMin, planMax, planDays, liquidationFee) {
        planIdEl.value = planId;
        planNameEl.textContent = planName;
        currentPlanMin = planMin;
        currentPlanMax = planMax;
        currentPlanDays = planDays || 7;
        planMinEl.textContent = planMin.toLocaleString();
        planMaxEl.textContent = planMax > 0 ? planMax.toLocaleString() : 'Unlimited';
        if (durationDisplay) durationDisplay.textContent = currentPlanDays + ' Days';
        if (durationInput) durationInput.value = currentPlanDays;
        if (liqFeeEl) liqFeeEl.textContent = (liquidationFee || 0).toFixed(2);
        if (liqNoteEl) {
            if (liquidationFee > 0) liqNoteEl.classList.remove('hidden');
            else liqNoteEl.classList.add('hidden');
        }
        amountEl.value = '';
        amountEl.min = planMin;
        amountEl.max = planMax > 0 ? planMax : '';
        errorEl.classList.add('hidden');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    subscribeBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var planId = this.getAttribute('data-plan-id');
            var planName = this.getAttribute('data-plan-name');
            var planMin = parseFloat(this.getAttribute('data-plan-min'));
            var planMax = parseFloat(this.getAttribute('data-plan-max')) || 0;
            var planDays = parseInt(this.getAttribute('data-plan-days'), 10) || 7;
            var liquidationFee = parseFloat(this.getAttribute('data-plan-liquidation-fee')) || 0;
            openModal(planId, planName, planMin, planMax, planDays, liquidationFee);
        });
    });

    if (backdrop) backdrop.addEventListener('click', closeModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var planId = parseInt(planIdEl.value, 10);
        var amount = parseFloat(amountEl.value) || 0;

        errorEl.classList.add('hidden');

        if (amount < currentPlanMin) {
            errorEl.textContent = 'Amount must be at least $' + currentPlanMin.toLocaleString();
            errorEl.classList.remove('hidden');
            return;
        }

        if (currentPlanMax > 0 && amount > currentPlanMax) {
            errorEl.textContent = 'Amount cannot exceed $' + currentPlanMax.toLocaleString();
            errorEl.classList.remove('hidden');
            return;
        }

        var duration = parseInt(durationInput ? durationInput.value : 0, 10) || currentPlanDays;
        if (duration !== currentPlanDays) {
            errorEl.textContent = 'This plan has a fixed duration of ' + currentPlanDays + ' days';
            errorEl.classList.remove('hidden');
            return;
        }

        if (amount > availableBalance) {
            errorEl.textContent = 'Insufficient USD balance. Available: $' + availableBalance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            errorEl.classList.remove('hidden');
            return;
        }

        fetch('/api/user/subscribe-plan.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ plan_id: planId, amount: amount, duration_days: duration })
        }).then(function(r){ return r.json(); }).then(function(res){
            if (res.success) {
                modal.classList.add('hidden');
                var successModal = document.getElementById('subscribe-success-modal');
                var successPlanEl = document.getElementById('success-plan-name');
                if (successPlanEl) successPlanEl.textContent = planNameEl.textContent || 'the plan';
                if (successModal) successModal.classList.remove('hidden');
                setTimeout(function(){ window.location.href = '/dashboard/user/dashboard'; }, 2200);
            } else {
                errorEl.textContent = res.error || 'Failed to subscribe';
                errorEl.classList.remove('hidden');
            }
        }).catch(function(){ errorEl.textContent = 'Request failed'; errorEl.classList.remove('hidden'); });
    });

    var autoOpen = document.querySelector('.subscribe-plan-btn[data-auto-open="1"]');
    if (autoOpen) autoOpen.click();
});
</script>
