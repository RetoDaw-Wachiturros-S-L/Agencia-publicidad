<?php
namespace AgenciaPublicidad\Controllers;

use AgenciaPublicidad\Models\dataBase\DBFunctions;
use AgenciaPublicidad\Models\dataBase\DBUser;
use AgenciaPublicidad\Models\UsuarioRegistrado;
use AgenciaPublicidad\Models\Comerciante;
use AgenciaPublicidad\Models\TipoPersonaEnum;
use function Agenciapublicidad\Utils\isAdmin;

require_once __DIR__ . '/../models/dataBase/DBFunctions.php';
require_once __DIR__ . '/../models/dataBase/DBUser.php';
require_once __DIR__ . '/../models/UsuarioRegistrado.php';
require_once __DIR__ . '/../models/Comerciante.php';
require_once __DIR__ . '/../models/TipoPersonaEnum.php';
require_once __DIR__ . '/../utils/auth_helper.php';

class AdminController {
    
    public function createUser() {
        // Verificar que el usuario esté autenticado y sea admin
        if (!isAdmin()) {
            header('Location: ' . BASE_URL . '/views/errors/403.php');
            exit;
        }

        // Mostrar vista del formulario de creación
        require_once __DIR__ . '/../views/admin/createUser.php';
    }

    public function storeUser() {
        // Verificar que el usuario esté autenticado y sea admin
        if (!isAdmin()) {
            header('Location: ' . BASE_URL . '/views/errors/403.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['contrasena'] ?? '';
            $tipo = $_POST['tipo'] ?? 'VISITANTE';

            // Validaciones básicas
            if (empty($nombre) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Nombre, email y contraseña son obligatorios';
                header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=createUser');
                exit;
            }

            // Validar que las contraseñas coincidan
            if (isset($_POST['contrasena2']) && $password !== $_POST['contrasena2']) {
                $_SESSION['error'] = 'Las contraseñas no coinciden';
                header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=createUser');
                exit;
            }

            try {
                $dbUser = new DBUser();
                $tipoEnum = TipoPersonaEnum::from($tipo);

                // Si es comerciante, crear un objeto Comerciante
                if ($tipo === 'COMERCIANTE') {
                    $nombreEmpresa = $_POST['nombreEmpresa'] ?? '';
                    $nifEmpresa = $_POST['nifEmpresa'] ?? '';
                    $comentarioEmpresa = $_POST['comentarioEmpresa'] ?? null;
                    $telefonoEmpresa = $_POST['telefonoEmpresa'] ?? null;

                    // Validar datos de comerciante
                    if (empty($nombreEmpresa) || empty($nifEmpresa)) {
                        $_SESSION['error'] = 'Nombre de empresa y NIF son obligatorios para comerciantes';
                        header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=createUser');
                        exit;
                    }

                    $comerciante = new Comerciante(
                        null,           // idComerciante
                        null,           // id_usuario
                        $nombre,
                        $apellido,
                        $email,
                        $password,
                        null,           // fotoPerfil
                        $nombreEmpresa,
                        $nifEmpresa,
                        $comentarioEmpresa,
                        $telefonoEmpresa
                    );

                    $resultado = $dbUser->guardarComerciante($comerciante);
                } else {
                    // Crear usuario normal (VISITANTE o ADMIN)
                    $usuario = new UsuarioRegistrado(
                        null,
                        $nombre,
                        $apellido,
                        $email,
                        $password,
                        new \DateTime(),
                        null,
                        $tipoEnum
                    );

                    $resultado = $dbUser->guardarUsuario($usuario);
                }

                if ($resultado) {
                    $_SESSION['success'] = 'Usuario creado exitosamente';
                    header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=modifyUser');
                } else {
                    $_SESSION['error'] = 'Error al crear el usuario';
                    header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=createUser');
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Error: ' . $e->getMessage();
                header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=createUser');
            }
            exit;
        }
    }

    public function modifyUser() {
        // Verificar que el usuario esté autenticado y sea admin
        if (!isAdmin()) {
            header('Location: ' . BASE_URL . '/views/errors/403.php');
            exit;
        }

        // Obtener todos los usuarios
        $dbFunctions = new DBFunctions();
        $usuarios = $dbFunctions->getAll();

        // Mostrar vista de gestión de usuarios
        require_once __DIR__ . '/../views/admin/modifyUser.php';
    }

    public function editUser() {
        // Verificar que el usuario esté autenticado y sea admin
        if (!isAdmin()) {
            header('Location: ' . BASE_URL . '/views/errors/403.php');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=modifyUser');
            exit;
        }

        // Obtener el usuario
        $dbFunctions = new DBFunctions();
        $usuario = $dbFunctions->getById($id);

        if (!$usuario) {
            $_SESSION['error'] = 'Usuario no encontrado';
            header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=modifyUser');
            exit;
        }

        // Mostrar vista de edición
        require_once __DIR__ . '/../views/admin/editUser.php';
    }

    public function updateUser() {
        // Verificar que el usuario esté autenticado y sea admin
        if (!isAdmin()) {
            header('Location: ' . BASE_URL . '/views/errors/403.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $tipo = $_POST['tipo'] ?? 'VISITANTE';

            if (!$id || empty($nombre) || empty($email)) {
                $_SESSION['error'] = 'Datos incompletos';
                header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=modifyUser');
                exit;
            }

            try {
                $tipoEnum = TipoPersonaEnum::from($tipo);
                $usuario = new UsuarioRegistrado(
                    $id,
                    $nombre,
                    $apellido,
                    $email,
                    $password, // Solo se actualizará si no está vacío
                    new \DateTime(),
                    null,
                    $tipoEnum
                );

                $dbFunctions = new DBFunctions();
                $resultado = $dbFunctions->update($id, $usuario);

                if ($resultado) {
                    $_SESSION['success'] = 'Usuario actualizado exitosamente';
                } else {
                    $_SESSION['error'] = 'Error al actualizar el usuario';
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Error: ' . $e->getMessage();
            }

            header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=modifyUser');
            exit;
        }
    }

    public function deleteUser() {
        // Verificar que el usuario esté autenticado y sea admin
        if (!isAdmin()) {
            header('Location: ' . BASE_URL . '/views/errors/403.php');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=modifyUser');
            echo "Acabas de dar una vuelta";
            exit;
        }

        try {
            $DBUser = new DBUser();
            $resultado = $DBUser->delete($id);
            echo $resultado;
            if ($resultado) {
                $_SESSION['success'] = 'Usuario eliminado exitosamente';
            } else {
                $_SESSION['error'] = 'Error al eliminar el usuario';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/index.php?controller=AdminController&accion=modifyUser');
        exit;
    }
}
?>
