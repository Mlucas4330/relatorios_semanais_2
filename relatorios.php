<?php

$servername = "localhost";
$username = "lucas";
$password = "123456";
$dbname = "relatorios_semanais";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT *, t.descricao as descricao, st.descricao as status, ds.descricao as dia_semana FROM ticket t LEFT JOIN status as st ON t.status = st.id
LEFT JOIN dia_semana ds ON t.dia_semana = ds.id";

$result = mysqli_query($conn, $sql);

$tickets = mysqli_fetch_all($result, MYSQLI_ASSOC);

$conn->close();

?>

<!doctype html>
<html lang="en">
<?php include('components/head.php') ?>

<body>
    <div class="container">
        <?php include 'components/header.php'; ?>

        <button onclick="gerarPDF()" class="btn btn-info mb-3">Gerar PDF</button>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Ticket</th>
                        <th scope="col">Status</th>
                        <th scope="col">Dia da Semana</th>
                        <th scope="col">Horário</th>
                        <th scope="col">Descrição</th>
                        <th colspan="2" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $item => $valor) : ?>
                        <tr>
                            <td width="5%"><?= $valor['id'] ?></td>
                            <td width="12%"><?= $valor['status'] ?></td>
                            <td width="12%"><?= $valor['dia_semana'] ?></td>
                            <td class="text-center" width="14%"><?= $valor['hora_inicio'] ?> - <?= $valor['hora_final'] ?></td>
                            <td width="40%" style="word-break: break-all;"><?= $valor['descricao'] ?></td>

                            <td class="text-center" width="15%">
                                <Button onclick="editar()" class="btn btn-info">Editar</Button>
                                <Button onclick="excluir()" class="btn btn-danger">Excluir</Button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function editar() {
            alert('Registro editado');
        }

        function excluir() {
            alert('Registro excluido');
        }

        function gerarPDF() {
            alert('PDF gerado');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>