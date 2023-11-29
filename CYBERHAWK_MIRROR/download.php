<?php
        include '/var/clients/config_clients.php';

        if (isset($_GET["ID"]))
        {
                $id = $_GET["ID"];

                if (isset($_ENV[$id]["NAME"]))
                {
                        if (file_exists("/var/clients/" . $_ENV[$id]["NAME"] . "/encrypted.data")) {
                            ignore_user_abort(true);
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename="encrypted.data"');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize("/var/clients/" . $_ENV[$id]["NAME"] . "/encrypted.data"));
                            readfile("/var/clients/" . $_ENV[$id]["NAME"] . "/encrypted.data");
							system("echo '" .$_ENV[$id]["NAME"] . ";" . date("H:i:s") . "' >> /var/clients/download.log");
                            exit;
                        }
                }
        }
?>

