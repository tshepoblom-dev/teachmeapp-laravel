<?php if (isset($component)) { $__componentOriginalde7351e060091d622377605e583428b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde7351e060091d622377605e583428b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.layout','data' => ['subject' => __('Payout failed — funds returned to wallet')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subject' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payout failed — funds returned to wallet'))]); ?>
    <p class="greeting">Payout failed</p>
    <p class="intro"><?php echo e($message); ?></p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Reference</span>
            <span class="card-value"><?php echo e($reference); ?></span>
        </div>
        <div class="card-row">
            <span class="card-label">Amount</span>
            <span class="card-value">R<?php echo e($amount); ?></span>
        </div>
        <?php if($failureReason): ?>
        <div class="card-row">
            <span class="card-label">Reason</span>
            <span class="card-value"><?php echo e($failureReason); ?></span>
        </div>
        <?php endif; ?>
    </div>

    <div class="alert" style="border-left-color: #dc2626; background: #fef2f2; color: #991b1b;">
        The full amount has been returned to your wallet. Please check your payout account details and try again, or contact support if the problem persists.
    </div>

    <div class="btn-wrap">
        <a class="btn" href="<?php echo e(config('app.url')); ?>/tutor/wallet/payouts">View Payouts</a>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalde7351e060091d622377605e583428b9)): ?>
<?php $attributes = $__attributesOriginalde7351e060091d622377605e583428b9; ?>
<?php unset($__attributesOriginalde7351e060091d622377605e583428b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalde7351e060091d622377605e583428b9)): ?>
<?php $component = $__componentOriginalde7351e060091d622377605e583428b9; ?>
<?php unset($__componentOriginalde7351e060091d622377605e583428b9); ?>
<?php endif; ?>
<?php /**PATH C:\teachmeapp-laravel\resources\views\emails\payout-failed.blade.php ENDPATH**/ ?>