<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<footer>

    <div class="environment">
        <?php if (ENVIRONMENT === 'development'): ?>
            <p>Page rendered in {elapsed_time} seconds</p>
            <p>Environment: <?= ENVIRONMENT ?></p>
        <?php endif; ?>
    </div>

    <div class="copyrights">
        <p>&copy; <?= date('Y') ?> Custom Content</p>
    </div>

</footer>

<!-- SCRIPTS -->

<script {csp-script-nonce}>
    document.getElementById("menuToggle").addEventListener('click', toggleMenu);
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>

<?php if (isset($hasTabelas) && $hasTabelas): ?>
    <!-- inclusão de JS de tabelas -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
    <script src="/js/tabelas.js"></script>
<?php endif; ?>

<!-- -->

</body>
</html>
