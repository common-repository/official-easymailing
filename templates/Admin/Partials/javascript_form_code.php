<?php if($mySuscription) {?>
<!-- Easymailing Universal -->
<script>
    (function (w, d, s, i) {
        var f = d.getElementsByTagName(s)[0], j = d.createElement(s);
        j.async = true;
        j.src = '<?php echo $this->getParameter('universal_javascript_url') ?>' + '?v' + (~~(new Date().getTime() / 1000000));
        f.parentNode.insertBefore(j, f);
        w.__easymsettings = {domain: i};
    })(window, document, 'script', '<?php echo $mySuscription->domain ?>');
    <?php if ($popupForm){ ?>
    window.__easymsettings.popuphash = '<?php echo $popupForm->hash ?>'
    <?php } ?>

</script>
<!-- Easymailing Universal -->
<?php } ?>
