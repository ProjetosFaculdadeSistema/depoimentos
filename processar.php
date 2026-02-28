<?php
$nome       = htmlspecialchars(trim($_POST['nome']       ?? ''));
$email      = htmlspecialchars(trim($_POST['email']      ?? ''));
$curso      = htmlspecialchars(trim($_POST['curso']      ?? ''));
$depoimento = htmlspecialchars(trim($_POST['depoimento'] ?? ''));

if (empty($nome) || empty($email)) {
    header('Location: formulario.html');
    exit;
}

// Conecta ao banco
$conn = new mysqli('127.0.0.1', 'root', '', 'depoimentos', 33306);

if ($conn->connect_error) {
    die('Erro ao conectar: ' . $conn->connect_error);
}

// Salva no banco
$sql = "INSERT INTO depoimentos (nome, email, curso, depoimento) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $nome, $email, $curso, $depoimento);
$stmt->execute();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Enviado</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 500px; margin: 60px auto; padding: 0 1rem; color: #222; }
    p { margin-bottom: 0.6rem; }
    a { color: #333; }
  </style>
</head>
<body>

  <h1>Depoimento recebido!</h1>

  <p><strong>Nome:</strong> <?= $nome ?></p>
  <p><strong>E-mail:</strong> <?= $email ?></p>
  <p><strong>Curso:</strong> <?= $curso ?: 'Não informado' ?></p>
  <p><strong>Depoimento:</strong> <?= $depoimento ?: 'Não informado' ?></p>

  <br>
  <a href="formulario.html">← Voltar</a>

</body>
</html>
