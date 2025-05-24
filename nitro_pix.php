<?php
// Defina seu token e endpoint
// TROCAR API DO TOLEM
$apiToken = 'vsOYr4JtqCu6MUup007y3bhrsIlU6vYeHNLiyO3YoSQDTQyQouQLDEETWrP8';
$endpoint = 'https://api.nitropagamentos.com/api/public/v1/transactions?api_token=' . $apiToken;

// Dados que você vai receber (exemplo fixo aqui, substitua pelo seu input)
$data = [
    "amount" => 1790,
    //TROCAR ID DO PRODUTO
    "offer_hash" => "dclbde2eyp",
    //
    "payment_method" => "pix",
    "customer" => [
        "name" => "Sou Painho_Dev",
        "email" => "cliente@teste.com",
        "phone_number" => "87991870287",
        "document" => "12345678900",
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
            //TROCAR O HASH DO PRODUTO SERIA O BAGULHO DO CODIGO DO SITE DE PAGAMENTO
            "product_hash" => "xyszoxbng1",
            "title" => "Produto Teste API Publica",
            "cover" => null,
            "price" => 1790,
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
    // Erro na requisição cURL
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
