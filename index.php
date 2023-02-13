?php

date_default_timezone_set("America/Sao_Paulo");

include('models/TicketModel.php');


$statusSelect = [
    [
        'id' => 1,
        'descricao' => 'Em andamento',
    ],
    [
        'id' => 2,
        'descricao' => 'Enviado para teste',
    ],
    [
        'id' => 3,
        'descricao' => 'Finalizado',
    ],
];

$semanaSelect = [
    [
        'id' => 1,
        'descricao' => 'Segunda-Feira',
    ],
    [
        'id' => 2,
        'descricao' => 'Terça-Feira',
    ],
    [
        'id' => 3,
        'descricao' => 'Quarta-Feira',
    ],
    [
        'id' => 4,
        'descricao' => 'Quinta-Feira',
    ],
    [
        'id' => 5,
        'descricao' => 'Sexta-Feira',
    ],
];

$ticket = null;
$status = null;
$dia_semana = null;
$hora_inicio = null;
$hora_final = null;
$descricao = null;
$msg = '';


if (!empty($_POST)) {
    $ticket = $_POST['ticket'];
    $status = $_POST['status'];
    $dia_semana = $_POST['dia_semana'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_final = $_POST['hora_final'];
    $descricao = $_POST['descricao'];
}


$servername = "localhost";
$username = "lucas";
$password = "123456";
$dbname = "relatorios_semanais";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($_POST)) {
    $sql = "INSERT INTO ticket (id, status, dia_semana, hora_inicio, hora_final, descricao) 
    VALUES ('$ticket','$status','$dia_semana','$hora_inicio','$hora_final','$descricao')";

    if (mysqli_query($conn, $sql)) {
        $msg = "New record created successfully";
    } else {
        $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<?php include('components/head.php') ?>

<body>
    <div class="container">
        <?php include 'components/header.php'; ?>

        <div class="row justify-content-center">
            <div class="col-6">
                <form method="post" action="index.php">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label" for="ticket">Ticket</label><br />
                            <input maxlength="7" class="form-control" required id="ticket" name="ticket" type="text" />
                        </div>
                        <div class="col-5">
                            <label class="form-label" for="status">Status</label><br />
                            <select class="form-select" required name="status" id="status">
                                <option value="">Selecione</option>
                                <?php foreach ($statusSelect as $item => $value) : ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['descricao'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="dia_semana">Dia da Semana</label><br />
                            <select class="form-select" required name="dia_semana" id="dia_semana">
                                <option value="">Selecione</option>
                                <?php foreach ($semanaSelect as $item => $value) : ?>
                                    <option <?= date('w') == $value['id'] ? 'selected'  : ''; ?> value="<?= $value['id'] ?>"><?= $value['descricao'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="hora_inicio">Hora Início</label>
                            <input value="<?= date("H:i") ?>" class="form-control" required type="time" name="hora_inicio" id="hora_inicio" />
                        </div>
                        <div class="col">
                            <label class="form-label" for="hora_final">Hora Final</label>
                            <input value="<?= date("H:i") ?>" class="form-control" required type="time" name="hora_final" id="hora_final" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="descricao">Descrição</label><br />
                        <textarea class="form-control" name="descricao" id="descricao"></textarea>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" id="submit">Enviar</button>
                    </div>
                    <span><?= $msg ?></span>
                </form>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>