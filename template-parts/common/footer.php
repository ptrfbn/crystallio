
<footer class="footer">
    <div class="container">
        <span class="text-muted">Copyright &copy; <?=date('Y')?> Crystallio</span>
    </div>
</footer>

<?php foreach ($this->getJsAssets() as $js_asset): ?>
<script src="/assets/js/<?=$js_asset?>.js"></script>
<?php endforeach;?>

</body>

</html>
