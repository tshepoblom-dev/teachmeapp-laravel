<?php if (isset($component)) { $__componentOriginalde7351e060091d622377605e583428b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde7351e060091d622377605e583428b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.layout','data' => ['subject' => __('KYC application update')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subject' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('KYC application update'))]); ?>
    <p class="greeting">Identity verification update</p>
    <p class="intro">Unfortunately your KYC application was not approved at this time.</p>

    <?php if($rejectionReason): ?>
    <div class="card">
        <div class="card-row">
            <span class="card-label">Reason</span>
            <span class="card-value"><?php echo e($rejectionReason); ?></span>
        </div>
    </div>
    <?php endif; ?>

    <p class="intro" style="margin-bottom:24px;">
        You're welcome to re-submit with the correct documentation. If you believe this is an error, please contact support.
    </p>

    <div class="btn-wrap">
        <a class="btn" href="<?php echo e(config('app.url')); ?>/kyc">Re-submit Application</a>
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
<?php endif; ?><?php /**PATH C:\teachmeapp-laravel\resources\views\emails\kyc-rejected.blade.php ENDPATH**/ ?>