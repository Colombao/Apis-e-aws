<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/login.css?time<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<script type=" text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
<!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">




<div class=" wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div id="icon" class="fadeIn first">
            <div class="d-flex justify-content-end">
                <a href="index.php" style="text-decoration: none;"> <i class="bi bi-box-arrow-in-left"></i></a>
            </div>
            <h3>CSV</h3>
        </div>

        <!-- Login Form -->
        <div class="text-center">
            <input type="file" id="csv" name="csv" class="form-control-file">
            <button id="sendCsv" class="btn btn-primary">Enviar</button>
        </div>
        <!-- <form method="post" enctype="multipart/form-data" action="sendfile.php">
            <input type="file" name="csvFile">
            <input type="submit" value="Importar">
        </form> -->

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="visualizar.php">Visualizar</a>
        </div>

    </div>
</div>
<script>
    $('#sendCsv').click(function() {
        var formData = new FormData();
        formData.append('csv', $('#csv').prop("files")[0]);
        $.ajax({
            url: 'sendfile.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.includes('enviado')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        html: data,
                        showConfirmButton: true,
                    })
                } else if (data.includes('adicionado')) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Nem certo nem errado 👀',
                        html: data,
                        showConfirmButton: true,
                    })

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: data,
                        showConfirmButton: true,
                    })
                }
            }
        })
    })
</script>