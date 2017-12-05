
        </div>
    </div>

    
    <script src="https://unpkg.com/vue"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        var baseUrl = '<?= base_url(); ?>';
        var url = "<?= isset($url) ? $url : 'null' ?>";
        var urlEdit = "<?= isset($urlEdit) ? $urlEdit : 'null' ?>";
        var urlDel = "<?= isset($urlDel) ? $urlDel : 'null' ?>";
        var query = <?= isset($query) ? json_encode($query) : 'null'; ?>;
    </script>
    <script src="<?= base_url(); ?>assets/script/jquery.mask.min.js"></script>
    <script src="<?= base_url(); ?>assets/script/main.js"></script>
    <!-- Chatbot -->
    <script>
      !function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
      arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
      d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
      insertBefore(d,q)}(window,document,'script','_gs');
    
      _gs('GSN-033615-C');
    </script>
</body>
</html>