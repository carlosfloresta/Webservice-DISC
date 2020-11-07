 <?php
    header('Content-Type: application/json charset=utf-8');
    $response = array();
    $response["erro"] = true;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        include 'conexao.php';
        mysqli_set_charset($conn, "utf8");

        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = mysqli_query($conn, "SELECT usuario.id, usuario.nome, usuario.email, usuario.telefone FROM usuario INNER JOIN teste ON usuario.id = teste.id_usuario INNER JOIN rh ON teste.id_empresa = rh.id where rh.id_login = '$id' ORDER BY usuario.id DESC");

        if ($sql->num_rows > 0) {

            $candidatos = array();

            $response["erro"] = false;

            while ($row = mysqli_fetch_array($sql)) {

                $candidato  = array();
                $candidato["id"] = $row['id'];
                $candidato["nome"] = $row['nome'];
                $candidato["email"] = $row['email'];
                $candidato["telefone"] = $row['telefone'];

                array_push($candidatos, $candidato);
            }

            $response["data"] = $candidatos;
        } else {

            $response["mensagem"] = "Nada encontrado";
        }

        $conn->close();
    }
    echo json_encode($response);
    ?>