<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bulma.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>visualizar</title>
</head>

<body>

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2">
        <h1 class="display-5 mb-2">Bem vindo a consulta</h1>
        <div class="d-flex" style="gap: 10px; 		margin-right: 10px;">
            <a class="text-decoration-none " style="color: white;" href="cadastro.php"><button class=" btn btn-danger btn-md">Cadastrar Signatario</button></a>
            <a class="text-decoration-none " style="color: white;" href="login.php"> <button class=" btn btn-danger btn-md">Vincular Signatario</button></a>
            <a class="text-decoration-none " style="color: white;" href="index.php"> <button class=" btn btn-danger btn-md">Home</button></a>
        </div>

    </div>
    </div>
    <table id="Visualizar" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>FullName</th>
                <th>Cpf</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Nascimento</th>
            </tr>
        </thead>
        <tfoot>
            <th>FullName</th>
            <th>Cpf</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Nascimento</th>
        </tfoot>
</body>
<script>
    let datatable = $('#Visualizar').DataTable({
        "deferRender": true,
        "ajax": "datatablesgay.php",
        "columns": [{
                "data": "FullName"
            },
            {
                "data": "Cpf"
            },
            {
                "data": "Email"
            },
            {
                "data": "Telefone"
            },
            {
                "data": "Nascimento"
            }
        ]
    });
</script>

</html>