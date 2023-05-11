<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/login.css?time<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<script type=" text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div id="icon" class="fadeIn first">
            <h3>Atribuir</h3>
        </div>

        <!-- Login Form -->
        <form id="login">
            <label>Signatario</label>
            <select name="signers" id="signers"></select>
            <label>Documento</label>
            <select name="signers" id="signers"></select>
            <button type="submit" class="btn btn-primary" value="enviar">Enviar</button>
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="cadastro.php">Criar signatario</a>
        </div>

    </div>
</div>
<script>
    function getSigners() {
        $.ajax({
            url: "sendfile.php?actions=1",
            method: "GET",
            success: function(response) {
                $('#signers').html(`<option value='Default' hidden> Select a Signer</option>`)
                response = JSON.parse(response);

                response.signers.forEach(function(signer) {
                    $('#signers').append(`<option value='${signer.key}'>${signer.name}</option>`);
                    console.log(signer);

                });
            }

        })
    }
    getSigners();
</script>