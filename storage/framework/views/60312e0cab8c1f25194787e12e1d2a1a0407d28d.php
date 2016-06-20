<footer class="footer">
    <div class="container-fluid">
        <div class="footer-content">
            <ul>
                <li>
                    <p><?php echo e(trans('footer.brand')); ?></p>
                </li>
                <li>
                    <a href="<?php echo e(action('PageController@contact')); ?>"><?php echo e(trans('footer.contact')); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(action('PageController@terms')); ?>"><?php echo e(trans('footer.terms')); ?></a>
                </li>
            </ul>
        </div>
    </div>
</footer>