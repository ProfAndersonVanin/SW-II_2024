<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            getClient($_GET['id']);
        } else {
            getClients();
        }
        break;

    case 'POST':
        createClient();
        break;

    case 'PUT':
        updateClient();
        break;

    case 'DELETE':
        deleteClient();
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Método não permitido']);
        break;
}

function getClients() {
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM clientes");
    $clients = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($clients);
}

function getClient($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    echo json_encode($client);
}

function createClient() {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $mysqli->prepare("INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $data['nome'], $data['email'], $data['telefone']);
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(['message' => 'Cliente criado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao criar cliente']);
    }
}

function updateClient() {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $mysqli->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ? WHERE id = ?");
    $stmt->bind_param('sssi', $data['nome'], $data['email'], $data['telefone'], $data['id']);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Cliente atualizado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao atualizar cliente']);
    }
}

function deleteClient() {
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $mysqli->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->bind_param('i', $data['id']);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Cliente deletado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao deletar cliente']);
    }
}
?>
