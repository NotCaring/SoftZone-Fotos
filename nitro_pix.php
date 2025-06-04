<?php
// Defina seu token e endpoint
$apiToken = 'vsOYr4JtqCu6MUup007y3bhrsIlU6vYeHNLiyO3YoSQDTQyQouQLDEETWrP8';
$endpoint = 'https://api.nitropagamentos.com/api/public/v1/transactions?api_token=' . $apiToken;

// Recebe o valor enviado pelo bot
$valorRecebido = isset($_POST['valor']) ? intval($_POST['valor']) : 0;

// Se não veio valor ou for inválido
if ($valorRecebido <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Valor inválido ou não informado.'
    ]);
    exit;
}

// Dados para envio
$data = [
    "amount" => $valorRecebido,
    "offer_hash" => "dclbde2eyp",
    "payment_method" => "pix",
    "customer" => [
        "name" => "Sou Painho_Dev",
        "email" => "cliente@teste.com",
        "phone_number" => "87991870287",
        "document" => "64655673000162", // CPF/CNPJ válido
        "street_name" => "Rua Teste",
        "number" => "123",
        "complement" => "Casa",
        "neighborhood" => "Centro",
        "city" => "Rio de Janeiro",
        "state" => "RJ",
        "zip_code" => "20000000"
    ],
    "cart" => [
        [
            "product_hash" => "dmlla7dieo",
            "title" => "Produto comprado no Discord",
            "cover" => null,
            "price" => $valorRecebido,
            "quantity" => 1,
            "operation_type" => 1,
            "tangible" => false
        ]
    ],
    "installments" => 1,
    "expire_in_days" => 1,
    "postback_url" => ""
];

// Inicializa o cURL
$ch = curl_init($endpoint);

// Configurações do cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Executa a requisição
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro na requisição: ' . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Retorna o resultado da API Nitro como JSON
http_response_code($httpCode);
header('Content-Type: application/json');
echo $response;
