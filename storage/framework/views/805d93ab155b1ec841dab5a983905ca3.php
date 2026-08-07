<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Create Journal Entry'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startPush('styles'); ?>
    <style>
        .line-item td .form-control, .line-item td .form-select { font-size: 0.875rem; }
        .line-item td { vertical-align: middle; }
    </style>
    <?php $__env->stopPush(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Create Journal Entry</h4><p class="text-muted small mb-0">Create a new balanced journal entry</p></div>
        <a href="<?php echo e(route('admin.finance.journal-entries.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.finance.journal-entries.store')); ?>" id="journalForm">
                <?php echo csrf_field(); ?>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Entry Date <span class="text-danger">*</span></label>
                        <input type="date" name="entry_date" class="form-control <?php $__errorArgs = ['entry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('entry_date', now()->format('Y-m-d'))); ?>" required>
                        <?php $__errorArgs = ['entry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <?php $__currentLoopData = ['standard','adjusting','closing','reversing','opening']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type); ?>" <?php echo e(old('type') === $type ? 'selected' : ''); ?>><?php echo e(ucfirst($type)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Finance Period</label>
                        <select name="finance_period_id" class="form-select">
                            <option value="">—</option>
                            <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($period->id); ?>" <?php echo e(old('finance_period_id') == $period->id ? 'selected' : ''); ?>><?php echo e($period->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="form-check pt-2">
                            <input type="checkbox" name="is_posted" class="form-check-input" value="1" id="isPosted" <?php echo e(old('is_posted', true) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="isPosted">Post immediately</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('description')); ?>" placeholder="Brief description of this entry">
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="2"><?php echo e(old('notes')); ?></textarea>
                        <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Journal Lines</h6>
                    <button type="button" class="btn btn-sm btn-success" onclick="addLine()"><i class="fas fa-plus me-1"></i> Add Line</button>
                </div>
                <?php $__errorArgs = ['items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="alert alert-danger py-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="table-responsive">
                    <table class="table table-bordered" id="linesTable">
                        <thead class="table-light">
                            <tr><th style="width:5%">#</th><th style="width:35%">Account</th><th>Description</th><th style="width:15%">Debit</th><th style="width:15%">Credit</th><th style="width:5%"></th></tr>
                        </thead>
                        <tbody id="linesBody">
                            <tr class="line-item">
                                <td class="text-center">1</td>
                                <td>
                                    <select name="items[0][chart_of_account_id]" class="form-select form-select-sm" required>
                                        <option value="">Select Account</option>
                                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($account->id); ?>"><?php echo e($account->code); ?> - <?php echo e($account->name); ?> (<?php echo e($account->normal_balance); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td><input type="text" name="items[0][description]" class="form-control form-control-sm" placeholder="Optional"></td>
                                <td><input type="number" name="items[0][debit]" class="form-control form-control-sm debit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td><input type="number" name="items[0][credit]" class="form-control form-control-sm credit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLine(this)" disabled><i class="fas fa-times"></i></button></td>
                            </tr>
                            <tr class="line-item">
                                <td class="text-center">2</td>
                                <td>
                                    <select name="items[1][chart_of_account_id]" class="form-select form-select-sm" required>
                                        <option value="">Select Account</option>
                                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($account->id); ?>"><?php echo e($account->code); ?> - <?php echo e($account->name); ?> (<?php echo e($account->normal_balance); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td><input type="text" name="items[1][description]" class="form-control form-control-sm" placeholder="Optional"></td>
                                <td><input type="number" name="items[1][debit]" class="form-control form-control-sm debit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td><input type="number" name="items[1][credit]" class="form-control form-control-sm credit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLine(this)"><i class="fas fa-times"></i></button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-active fw-bold">
                                <td colspan="3" class="text-end">Totals:</td>
                                <td id="totalDebit" class="text-end">0.00</td>
                                <td id="totalCredit" class="text-end">0.00</td>
                                <td></td>
                            </tr>
                            <tr id="balanceRow" class="d-none table-warning">
                                <td colspan="6" id="balanceMessage" class="text-center text-danger fw-bold"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create Entry</button>
                    <a href="<?php echo e(route('admin.finance.journal-entries.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
    let lineIndex = 2;
    const accountOptions = `<?php echo json_encode($accounts->map(fn($a) => ['id' => $a->id, 'code' => e($a->code), 'name' => e($a->name)) ?>`.map(a => `<option value="${a.id}">${a.code} - ${a.name} (${a.normal_balance})</option>`).join('');

    function addLine() {
        const html = `<tr class="line-item">
            <td class="text-center">${lineIndex + 1}</td>
            <td><select name="items[${lineIndex}][chart_of_account_id]" class="form-select form-select-sm" required><option value="">Select Account</option>${accountOptions}</select></td>
            <td><input type="text" name="items[${lineIndex}][description]" class="form-control form-control-sm" placeholder="Optional"></td>
            <td><input type="number" name="items[${lineIndex}][debit]" class="form-control form-control-sm debit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
            <td><input type="number" name="items[${lineIndex}][credit]" class="form-control form-control-sm credit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLine(this)"><i class="fas fa-times"></i></button></td>
        </tr>`;
        document.getElementById('linesBody').insertAdjacentHTML('beforeend', html);
        lineIndex++;
        calculateTotals();
    }

    function removeLine(btn) {
        const row = btn.closest('tr');
        if (document.querySelectorAll('.line-item').length <= 2) return;
        row.remove();
        updateLineNumbers();
        calculateTotals();
    }

    function updateLineNumbers() {
        document.querySelectorAll('.line-item').forEach((row, i) => {
            row.querySelector('td:first-child').textContent = i + 1;
        });
    }

    function calculateTotals() {
        let totalDebit = 0, totalCredit = 0;
        document.querySelectorAll('.debit-input').forEach(inp => totalDebit += parseFloat(inp.value) || 0);
        document.querySelectorAll('.credit-input').forEach(inp => totalCredit += parseFloat(inp.value) || 0);
        document.getElementById('totalDebit').textContent = totalDebit.toFixed(2);
        document.getElementById('totalCredit').textContent = totalCredit.toFixed(2);

        const balanceRow = document.getElementById('balanceRow');
        const balanceMsg = document.getElementById('balanceMessage');
        const diff = Math.abs(totalDebit - totalCredit);
        if (diff > 0.01) {
            balanceRow.classList.remove('d-none');
            balanceMsg.textContent = 'Not balanced! Difference: ' + diff.toFixed(2);
        } else {
            balanceRow.classList.add('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', calculateTotals);

    document.getElementById('journalForm').addEventListener('submit', function(e) {
        let totalDebit = 0, totalCredit = 0;
        document.querySelectorAll('.debit-input').forEach(inp => totalDebit += parseFloat(inp.value) || 0);
        document.querySelectorAll('.credit-input').forEach(inp => totalCredit += parseFloat(inp.value) || 0);
        if (Math.abs(totalDebit - totalCredit) > 0.01) {
            e.preventDefault();
            alert('Journal entry must be balanced. Total debits must equal total credits.');
        }
    });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $attributes = $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $component = $__componentOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\journal-entries\create.blade.php ENDPATH**/ ?>