<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar DNI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/16454e4b22.js" crossorigin="anonymous"></script>
</head>

<body>
    <center>
        <h3>Consulta por DNI</h3>
        <div class="btn-group">
            <input type="text" class="form-control" id="documento" placeholder="Ingresa DNI">
            <button type="button" class="btn btn-dark" id="buscar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        <br>
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <input type="text" class="form-control" id="numeroDocumento" placeholder="Número de Documento" disabled>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nombres" placeholder="Nombre" disabled>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-sm-6">
                <input type="text" class="form-control" id="apellidoPaterno" placeholder="Apellido Paterno" disabled>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-sm-6">
                <input type="text" class="form-control" id="apellidoMaterno" placeholder="Apellido Materno" disabled>
            </div>
        </div>
       
    </center>

    <script>
        $('#buscar').click(function() {
            var dni = $('#documento').val().trim();

            // Validar si el DNI tiene 8 dígitos
            if (dni.length !== 8 || !/^\d+$/.test(dni)) {
                alert("El DNI debe tener exactamente 8 dígitos numéricos.");
                return;
            }

            var data = {
                dato: dni
            };

            $.ajax({
                url: 'http://localhost:8080/consumo-de-api-dni-reniec-main/api/dni-api.php', // Coloca la dirección de tu API
                type: 'post',
                data: JSON.stringify(data),
                contentType: 'application/json',
                dataType: 'json',
                success: function(r) {
                    if (r.numeroDocumento) {
                        $('#numeroDocumento').val(r.numeroDocumento);
                        $('#nombres').val(r.nombres);
                        $('#apellidoPaterno').val(r.apellidoPaterno);
                        $('#apellidoMaterno').val(r.apellidoMaterno);
                    } else if (r.error) {
                        alert(r.message || 'Error en la respuesta de la API');
                    }
                    console.log(r);
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud:", xhr.responseText);
                    alert("Hubo un error en la consulta. Por favor, intenta nuevamente.");
                }
            });
        });
    </script>
</body>

</html>
