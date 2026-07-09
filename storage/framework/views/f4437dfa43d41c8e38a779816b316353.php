<?php if (isset($component)) { $__componentOriginalde7351e060091d622377605e583428b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde7351e060091d622377605e583428b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.layout','data' => ['subject' => __('You received a new review')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subject' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('You received a new review'))]); ?>
    <p class="greeting">New review ⭐</p>
    <p class="intro"><?php echo e($message); ?></p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">From</span>
            <span class="card-value"><?php echo e($reviewerName); ?></span>
        </div>
        <div class="card-row">
            <span class="card-label">Rating</span>
            <span class="card-value"><?php echo e($stars); ?> (<?php echo e($rating); ?>/5)</span>
        </div>
        <?php if($comment): ?>
        <div class="card-row">
            <span class="card-label">Comment</span>
            <span class="card-value"><?php echo e($comment); ?></span>
        </div>
        <?php endif; ?>
    </div>

    <div class="btn-wrap">
        <a class="btn" href="<?php echo e(config('app.url')); ?>/bookings/<?php echo e($bookingId); ?>">View Booking</a>
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
<?php /**PATH C:\teachmeapp-laravel\resources\views\emails\review-received.blade.php ENDPATH**/ ?>