<?php if (isset($component)) { $__componentOriginalde7351e060091d622377605e583428b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde7351e060091d622377605e583428b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.layout','data' => ['subject' => __('Reset your TeachMe App password')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subject' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Reset your TeachMe App password'))]); ?>

    <p class="greeting">Reset your password</p>
    <p class="intro">
        We received a request to reset the password for your TeachMe App account.
        Click the button below to choose a new one.
    </p>

    <div class="btn-wrap">
        <a href="<?php echo e($url); ?>" class="btn">Reset my password</a>
    </div>

    <p style="font-size:13px;color:#6b7280;margin-bottom:20px;">
        This link expires in <strong>60 minutes</strong>. If you didn't request a password reset,
        you can safely ignore this email — your password won't change.
    </p>

    <hr class="divider" />

    <p style="font-size:12px;color:#9ca3af;">
        Can't click the button? Copy and paste this URL into your browser:<br>
        <a href="<?php echo e($url); ?>" style="color:#007B43;word-break:break-all;"><?php echo e($url); ?></a>
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
<?php /**PATH C:\teachmeapp-laravel\resources\views\emails\reset-password.blade.php ENDPATH**/ ?>