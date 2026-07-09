<?php if (isset($component)) { $__componentOriginalde7351e060091d622377605e583428b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde7351e060091d622377605e583428b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.layout','data' => ['subject' => $title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subject' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title)]); ?>

    <p class="greeting"><?php echo e($title); ?></p>

    <div class="alert">
        This is a message from the TeachMe App team.
    </div>

    <p class="intro" style="white-space: pre-line;"><?php echo e($body); ?></p>

    <hr class="divider" />

    <p style="font-size:12px;color:#9ca3af;">
        You received this email because you have an account on TeachMe App.
        To manage your notification preferences, visit your
        <a href="<?php echo e(config('app.url')); ?>/settings/notifications" style="color:#007B43;">notification settings</a>.
    </p>

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
<?php /**PATH C:\teachmeapp-laravel\resources\views\emails\admin-broadcast.blade.php ENDPATH**/ ?>