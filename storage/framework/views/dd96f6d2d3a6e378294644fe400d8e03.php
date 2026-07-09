<?php if (isset($component)) { $__componentOriginalde7351e060091d622377605e583428b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde7351e060091d622377605e583428b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.layout','data' => ['subject' => __('Session complete — invoice attached')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subject' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Session complete — invoice attached'))]); ?>
    <p class="greeting">Session complete!</p>
    <p class="intro"><?php echo e($message); ?></p>

    <?php if($netEarned): ?>
    <div class="alert">
        R<?php echo e(number_format($netEarned, 2)); ?> has been added to your wallet.
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Subject</span>
            <span class="card-value"><?php echo e($subject); ?></span>
        </div>
        <div class="card-row">
            <span class="card-label">Status</span>
            <span class="card-value">Completed</span>
        </div>
    </div>

    <div class="btn-wrap">
        <?php if($recipient === 'student'): ?>
            <a class="btn" href="<?php echo e(config('app.url')); ?>/bookings/<?php echo e($bookingId); ?>/review">Leave a Review</a>
        <?php else: ?>
            <a class="btn" href="<?php echo e(config('app.url')); ?>/wallet">View Wallet</a>
        <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\teachmeapp-laravel\resources\views\emails\booking-completed.blade.php ENDPATH**/ ?>