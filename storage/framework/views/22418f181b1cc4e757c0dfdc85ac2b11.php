<?php if (isset($component)) { $__componentOriginalde7351e060091d622377605e583428b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde7351e060091d622377605e583428b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.layout','data' => ['subject' => __('KYC approved — you\'re ready to teach')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subject' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('KYC approved — you\'re ready to teach'))]); ?>
    <p class="greeting">You're verified! 🎉</p>
    <p class="intro"><?php echo e($message); ?></p>

    <div class="alert">
        Your profile is now live and students can book sessions with you.
    </div>

    <div class="btn-wrap">
        <a class="btn" href="<?php echo e(config('app.url')); ?>/dashboard">Go to Dashboard</a>
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
<?php endif; ?><?php /**PATH C:\teachmeapp-laravel\resources\views\emails\kyc-approved.blade.php ENDPATH**/ ?>