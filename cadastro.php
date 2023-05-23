<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/login.css?php echo time(); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<script type=" text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css
" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/0.9.0/jquery.mask.min.js" integrity="sha512-oJCa6FS2+zO3EitUSj+xeiEN9UTr+AjqlBZO58OPadb2RfqwxHpjTU8ckIC8F4nKvom7iru2s8Jwdo+Z8zm0Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>





<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="d-flex justify-content-end">
            <a href="index.php" style="text-decoration: none;"> <i class="bi bi-box-arrow-in-left"></i></a>
        </div>
        <div id="icon" class="fadeIn first d-flex justify-content-center">

            <h3> Signatario </h3>
        </div>
        <br>
        <form id="signer-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control Email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Telefone:</label>
                <input type="text" class="form-control Telefone" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="documentation">Documento:</label>
                <input type="text" class="form-control Cpf" id="documentation" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="birthday">Data de Nascimento:</label>
                <input type="text" class="form-control Nascimento" id="birthday" name="nascimento" required>
            </div>
            <div class=" form-group">
                <label for="auths">Autorizações:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="auths-email" value="email" name="auth" checked>
                    <label class="form-check-label" for="auths-email">
                        Email
                    </label>
                </div>
                <input class="form-check-input" type="radio" id="auths-zap" value="WhatsApp" name="auth">
                <label class="form-check-label" for="auths-zap">
                    Zap
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <div id="formFooter">
            <a class="underlineHover" href="login.php">Atribuir</a>
        </div>

    </div>
    <script>
        $('.Cpf').mask('000.000.000-00', {
            reverse: true
        });
        $('.Telefone').mask('(00) 00000-0000');
        $('.Cep').mask('00000-000');
        $('.Nascimento').mask('00/00/0000');

        $(document).ready(function() {
            $('#signer-form').submit(function(event) {
                event.preventDefault();
                let form = $("#signer-form").serialize();
                $.ajax({
                    url: 'sendfile.php',
                    method: 'post',
                    data: form,
                    success: function(response) {
                        console.log(response);
                        response = JSON.parse(response);
                        if (Array.isArray(response.errors)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'firma ta forte',
                                text: 'signatario criado ',
                            })
                        }
                    },
                });
            });
        });
    </script>
</div>