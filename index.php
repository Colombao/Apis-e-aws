<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="
https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css
" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?time<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="css/fonts-icones.css">
    <link rel="shortcut icon" href="https://www.loopnerd.com.br/img/favicon.png" type="image/ico" />

    <title>Composer</title>
</head>

<body>
    <div class="d-flex justify-content-between">
        <h1>Envio de arquivo</h1>
        <div class="d-flex" style="gap: 10px; 		margin-right: 10px;">
            <button class=" btn btn-danger btn-md"><a class="text-decoration-none " style="color: white;" href="cadastro.php">Cadastrar Signatario</button></a>
            <button class=" btn btn-danger btn-md"><a class="text-decoration-none " style="color: white;" href="login.php">Vincular Signatario</button></a>
        </div>
    </div>
    <div class="form-group">
        <label for="file">Selecionar arquivo:</label>
        <input type="file" id="file" name="file" class="form-control-file">
        <button id="enviar" class="btn btn-primary">Enviar</button>
        <label for="file2">Selecionar arquivo:</label>
        <input type="file" id="file2" name="file2" class="form-control-file">
        <button class="btn btn-primary btn-md" id="create-document-button">Criar Documento</button>
    </div>
    <div id="bonito">
        <button id="visualizar" class="btn btn-primary btn-md">Visualizar</button>
        <button class=" btn btn-primary btn-md" id="botao-chat">Iniciar Chat</button>
        <button class="btn btn-primary btn-md" id="botao-gato">Obter 9 gatos aleatórios</button>
        <label>Documentos</label>
        <select name="documents" id="documents" class="form-select"></select>
        <br>
        <button class="btn btn-primary btn-sm" id="baixar-pdf">Baixar</button>
    </div>

    <div id="response-container"></div>
    <div id="catImageContainer"></div>
    <div id="gallery-container">
    </div>
    <div id="gallery-pdf">
    </div>
    <div hidden id=" pergunta"></div>


    <script type=" text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>

    <script>
        $('#baixar-pdf').on('click', function(e) {
            let url = $('#documents').val();
            let file_name = $('#documents :selected').text();
            const pdfDownload = () => {
                const link = document.createElement('a');
                link.href = `sendfile.php?url=${encodeURIComponent(url)}&file_name=${file_name}&action=downloadSignedDocument`;
                link.target = '_blank';
                link.click();
            };
            Swal.fire({
                title: 'Voce tem certeza?',
                html: '<iframe src="' + url + '"></iframe>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Vou baixa '
            }).then((result) => {
                if (result.isConfirmed) {
                    pdfDownload();
                }
            })

            // Chama a função para iniciar o download
        })

        function listar() {
            $.ajax({
                url: "sendfile.php?pdf=1",
                method: "get",
                processData: false,
                contentType: false,
                success: function(response) {

                    $('#documents').html(`<option value='Default' hidden> Select a documents</option>`)
                    const files = response.split('**');

                    files.map(file => {
                        const file_name = file
                        const temporary = file.split(".")
                        const file_extension = temporary.pop()

                        if (file_extension.toLowerCase() == "pdf") {
                            $.ajax({
                                url: `sendfile.php?file=${file}`,
                                type: 'GET',
                                success: (data) => {

                                    const file_name = file;
                                    const f_name = file_name.split("/").pop()
                                    $('#documents').append(`<option value='${data}'>${f_name}</option>`);


                                }
                            })
                        }
                    })
                }

            });
        }

        listar();
        $('#create-document-button').click(function() {
            if ($('#file2').get(0).files.length === 0) {
                alert('Selecione um arquivo para enviar.');
                return false;
            }

            var formData = new FormData();
            formData.append('file2', $('#file2').prop("files")[0]);

            $.ajax({
                url: 'sendfile.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#response-container').html(response);
                },
                error: function(xhr, status, error) {
                    alert('Erro ao criar documento: ' + error);
                }
            });
        });



        $('#botao-gato').click(function() {
            $.ajax({
                url: `sendfile.php?gato=1`,
                method: 'GET',
                contentType: false,
                processData: false,
                success: function(response) {
                    const fotosgatos = response.split("**").slice(0, -2);
                    fotosgatos.map(function(foto) {
                        let title = `<button onclick=enviar('${foto}') class='btn btn-primary'>Enviar</button>`
                        $('#gallery-container').append(`<div class="gallery-item"><a href="${foto}" title="${title}" ><img src="${foto}" style="max-width: 100%; max-height: 300px; object-fit: cover;"></a></div>`);
                        $('#gallery-container a').magnificPopup({
                            type: 'image',
                            gallery: {
                                enabled: true
                            },
                            image: {
                                titleSrc: function(item) {
                                    return item.el.attr('title');
                                }
                            },
                            zoom: {
                                enabled: true,
                                duration: 300,
                                easing: 'ease-in-out'
                            },
                            mainClass: 'mfp-with-zoom mfp-fade',
                            removalDelay: 300
                        });

                    })

                }
            })
        })
        $('#botao-chat').click(async function() {
            const {
                value: text
            } = await Swal.fire({
                input: 'textarea',
                inputLabel: 'Message',
                inputPlaceholder: 'Type your message here...',
                inputAttributes: {
                    'aria-label': 'Type your message here'
                },
                showCancelButton: true
            })
            if (text) {
                Swal.fire(text)
                $.ajax({
                    url: `sendfile.php?api=1&text=${text}`,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire(response)
                    }
                })
            }
        })

        function apagar(file) {
            const fto = file;
            $.ajax({
                url: `sendfile.php?apagar=1&fto=${fto}`,
                method: 'GET',
                contentType: false,
                processData: false,
                success: function(data) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    })

                }
            })
        }

        function visualizar() {}
        $('#visualizar').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'sendfile.php?visualizar=1',
                method: 'GET',
                contentType: false,
                processData: false,
                success: function(data) {
                    data = data.split("**");
                    var html = '';

                    data.map((file) => {
                        const extensao = file.split('.').pop();
                        if (extensao.toLowerCase() == 'jpeg' || extensao.toLowerCase() == 'png' || extensao.toLowerCase() == 'jpg') {
                            $.ajax({
                                url: `sendfile.php?file=${file}`,
                                type: 'GET',
                                success: (data) => {
                                    let title = `<button class='btn btn-primary'><a style='text-decoration: none; color: inherit;' href='${data}'>Baixar Imagem</a></button>
                        <button class='btn btn-danger' onclick=apagar('${file}')>Apagar foto</button `;
                                    $('#gallery-container').append('<div class="gallery-item"><a href="' + data + '" title="' + title + '"><img src="' + data + '" style="max-width: 100%; max-height: 300px; object-fit: cover;"></a></div>');
                                    $('#gallery-container a').magnificPopup({
                                        type: 'image',
                                        gallery: {
                                            enabled: true
                                        },
                                        image: {
                                            titleSrc: function(item) {
                                                return item.el.attr('title');
                                            }
                                        },
                                        zoom: {
                                            enabled: true,
                                            duration: 300,
                                            easing: 'ease-in-out'
                                        },
                                        mainClass: 'mfp-with-zoom mfp-fade',
                                        removalDelay: 300
                                    });

                                }
                            })
                        }
                    });
                },
                error: function(data) {
                    console.log('Erro ao buscar lista de arquivos');
                }
            });
        });
        $('#visualizar').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'sendfile.php?pdf=1',
                method: 'GET',
                contentType: false,
                processData: false,
                success: function(data) {
                    data = data.split("**");

                    data.map((file) => {
                        const extensao = file.split('.').pop().toLowerCase();
                        if (extensao === 'pdf') {
                            $.ajax({
                                url: `sendfile.php?file=${file}`,
                                type: 'GET',
                                success: (data) => {
                                    let title = `<button class='btn btn-primary'><a style='text-decoration: none; color: inherit;' href='${data}'>Baixar Imagem</a></button>
                                    <button class='btn btn-danger' onclick=apagar('${file}')>Apagar foto</button>`;
                                    $('#gallery-pdf').append('<div class="gallery-item"><a href="' + data + '"><object id="iframe" data="' + data + '" src="' + data + '" type="application/pdf style="max-width: 100%; max-height: 300px; object-fit: cover;"></object></a></div>');
                                    $('#gallery-pdf a').magnificPopup({
                                        type: 'object',
                                        gallery: {
                                            enabled: true
                                        },
                                        mainClass: 'mfp-with-zoom mfp-fade',
                                        removalDelay: 300

                                    });

                                }
                            })
                        }
                    });
                },
                error: function(data) {
                    console.log('Erro ao buscar lista de arquivos');
                }
            });
        });


        $('#enviar').click(function() {
            var formData = new FormData();
            formData.append('file', $('#file').prop("files")[0]);
            $.ajax({
                url: 'sendfile.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == 'Deu boa') {
                        Swal.fire({
                            title: 'Voce tem certeza?',
                            html: '<iframe src="' + file + '"></iframe>',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Vou enviar '
                        }).then((result) => {
                            if (result.isConfirmed) {
                                swal.fire(enviado);
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                },
            });
        });
    </script>


</body>

</html>