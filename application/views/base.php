<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $titulo ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/style/main.css" type="text/css" />
</head>
<body>
    <div id="painel" class="container-fluid">
        <div class="row">
            <div id="menu" class="col-md-2">
                <ul class="list-group">
                    <menu-item v-for="item in menuItens" v-bind:item="item" v-bind:key="item.id"></menu-item>
                </ul>
            </div>
            <div class="col-md-10">
                <?php
                    $dados['chave_primaria'] = $chave_primaria;
                    if(isset($query)){
                        $dados['query'] = $query;
                    }
                    $this->load->view($pagina, $dados);
                ?>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/vue"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        var base_url = "<?= base_url(); ?>";
        var query = <?= json_encode($query); ?>;
    </script>
    <script src="<?= base_url(); ?>assets/script/main.js"></script>
</body>
</html>