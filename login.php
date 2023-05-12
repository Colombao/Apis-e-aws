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
        <form id="form">
            <label>Signatario</label>
            <select name="signers" id="signers"></select>
            <br>
            <label>Documento</label>
            <select name="documents" id="documents"></select>
            <br>
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
                    $('#signers').append(`<option value='${signer.key}'>${signer.name}[${signer.auths}]</option>`);


                });
            }

        })
    }
    getSigners();

    function getDocuments() {
        $.ajax({
            url: "sendfile.php?objects=1",
            method: "GET",
            success: function(response) {
                $('#documents').html(`<option value='Default' hidden> Select a documents</option>`)
                response = JSON.parse(response);
                response.documents.forEach(function(documents) {
                    $('#documents').append(`<option value='${documents.key}'>${documents.filename}[${documents.status}]</option>`);


                });
            }

        })
    }
    getDocuments();
    $('#form').submit((e) => {
        e.preventDefault();
        let form = $("#form").serialize();
        $.ajax({
            url: "sendfile.php",
            method: "POST",
            data: form,
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
                const request_signature_key = response.list.request_signature_key;
                if ($('#signers :selected').text().includes('whats')) {
                    $.ajax({
                        url: "sendfile.php?action=zap",
                        method: "POST",
                        data: `request_signature_key=${request_signature_key}`,
                        success: function(response) {



                        }
                    })
                } else {
                    $.ajax({
                        url: "sendfile.php?action=email",
                        method: "POST",
                        data: `request_signature_key=${request_signature_key}`,
                        success: function(response) {

                        }
                    });
                }
                // if (Array.isArray(response.errors)) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Oops...',
                //         text: 'Something went wrong!',
                //     })

                // } else {
                //     Swal.fire({
                //         icon: 'success',
                //         title: 'firma ta forte',
                //         text: 'signatario vinculado ',
                //     })
                // }
            },


        })
    })
</script>