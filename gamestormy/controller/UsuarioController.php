<?php
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioController {
    public function index() {
        redirect('?page=login');
    }

    public function login() {
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $u = new Usuario();
            $user = $u->getByEmail($email);
            if ($user && password_verify($senha, $user['senha'])) {
                if ($user['status'] !== 'ativo') {
                    $erro = 'Conta inativa ou banida.';
                } else {
                    $_SESSION['usuario_id'] = $user['id_usuario'];
                    $_SESSION['usuario_nome'] = $user['nome_usuario'];
                    setFlash('success', 'Bem-vindo, ' . htmlspecialchars($user['nome_usuario']) . '!');
                    redirect('');
                }
            } else {
                $erro = 'E-mail ou senha incorretos.';
            }
        }
        require __DIR__ . '/../view/login.php';
    }

    public function register() {
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $nick = trim($_POST['nickname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $confirma = $_POST['confirma'] ?? '';
            $dia = $_POST['dia'] ?? '';
            $mes = $_POST['mes'] ?? '';
            $ano = $_POST['ano'] ?? '';

            if (!$nome || !$nick || !$email || !$senha || !$dia || !$mes || !$ano) {
                $erro = 'Preencha todos os campos.';
            } elseif ($senha !== $confirma) {
                $erro = 'As senhas não conferem.';
            } elseif (strlen($senha) < 4) {
                $erro = 'Senha muito curta (mínimo 4 caracteres).';
            } else {
                $data_nasc = "$ano-$mes-$dia";
                $u = new Usuario();
                if ($u->getByEmail($email)) {
                    $erro = 'E-mail já cadastrado.';
                } elseif ($u->getByNickname($nick)) {
                    $erro = 'Nickname já em uso.';
                } else {
                    $u->create($nome, $nick, $email, $senha, $data_nasc);
                    setFlash('success', 'Conta criada! Faça login.');
                    redirect('?page=login');
                }
            }
        }
        require __DIR__ . '/../view/register.php';
    }

    public function logout() {
        session_destroy();
        redirect('');
    }

    public function perfil() {
        if (!authCheck()) redirect('?page=login');
        $u = new Usuario();
        $usuario = $u->getById($_SESSION['usuario_id']);
        $erro = '';
        $success = '';
        $debug = ''; // Para debug de upload

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $nick = trim($_POST['nickname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $data_nasc = $_POST['data_nascimento'] ?? '';
            $novaSenha = $_POST['nova_senha'] ?? '';

            $foto = $usuario['foto_perfil'];

            // Debug info
            $debug .= "FILES: " . print_r($_FILES, true) . "\n";

            if (!empty($_FILES['foto']['tmp_name'])) {
                $file = $_FILES['foto'];
                $debug .= "Arquivo recebido: " . $file['name'] . "\n";
                $debug .= "Tamanho: " . $file['size'] . " bytes\n";
                $debug .= "Tipo: " . $file['type'] . "\n";
                $debug .= "Erro upload: " . $file['error'] . "\n";
                $debug .= "Temp: " . $file['tmp_name'] . "\n";

                // Verificar erro de upload
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $erro = 'Erro no upload da imagem (código: ' . $file['error'] . '). Verifique o tamanho máximo permitido.';
                } else {
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $permitidas = ['jpg','jpeg','png','gif','webp'];

                    if (!in_array($ext, $permitidas)) {
                        $erro = 'Formato de imagem não permitido. Use: jpg, png, gif, webp. (Enviado: ' . $ext . ')';
                    } else {
                        // Criar diretório se não existir
                        $uploadDir = __DIR__ . '/../assets/uploads/avatares/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $nomeArquivo = 'avatar_' . $usuario['id_usuario'] . '_' . time() . '.' . $ext;
                        $destino = $uploadDir . $nomeArquivo;
                        $debug .= "Destino: " . $destino . "\n";
                        $debug .= "Diretório existe: " . (is_dir($uploadDir) ? 'SIM' : 'NÃO') . "\n";
                        $debug .= "Diretório escrita: " . (is_writable($uploadDir) ? 'SIM' : 'NÃO') . "\n";

                        if (move_uploaded_file($file['tmp_name'], $destino)) {
                            $foto = 'assets/uploads/avatares/' . $nomeArquivo;
                            $debug .= "Upload OK! Caminho: " . $foto . "\n";

                            // Apagar foto antiga se existir
                            if (!empty($usuario['foto_perfil']) && file_exists(__DIR__ . '/../' . $usuario['foto_perfil'])) {
                                unlink(__DIR__ . '/../' . $usuario['foto_perfil']);
                            }
                        } else {
                            $erro = 'Falha ao mover o arquivo para o servidor. Verifique permissões da pasta assets/uploads/avatares/';
                            $debug .= "FALHA no move_uploaded_file\n";
                        }
                    }
                }
            }

            if (!$erro) {
                $u->update($usuario['id_usuario'], $nome, $nick, $email, $data_nasc, $foto);
                if ($novaSenha) {
                    $u->updateSenha($usuario['id_usuario'], $novaSenha);
                }
                $success = 'Perfil atualizado com sucesso!';
                $usuario = $u->getById($_SESSION['usuario_id']);
                $_SESSION['usuario_nome'] = $usuario['nome_usuario'];
            }
        }

        require __DIR__ . '/../view/perfil.php';
    }
}
?>