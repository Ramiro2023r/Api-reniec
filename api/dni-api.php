<?php
// Recibir un JSON
$inputJSON = file_get_contents('php://input');

if ($inputJSON) {
    $data = json_decode($inputJSON, true);

    // Verificar si el JSON tiene un dato válido
    if ($data === null) {
        echo json_encode(['error' => true, 'message' => 'JSON inválido']);
        exit();
    }

    if (isset($data['dato']) && strlen($data['dato']) === 8 && ctype_digit($data['dato'])) {
        // Datos
        $token = 'apis-token-11260.PVTzHs4t39i5qda5PWi4mCR5TJQC38e4'; // Genera tu propio token en apis.net.pe
        $dni = $data['dato'];

        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar dni
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo json_encode(['error' => true, 'message' => 'Error en la llamada a la API: ' . curl_error($curl)]);
        } else {
            echo $response;
        }
        curl_close($curl);

    } else {
        // Respuesta DNI para datos faltantes o incorrectos
        $response = array('error' => true, 'message' => 'El dni recibido no contiene 8 dígitos');
        echo json_encode($response);
    }
} else {
    // En caso de que no se reciba ningún DNI
    $response = array('error' => true, 'message' => 'No se recibió un JSON');
    echo json_encode($response);
}
