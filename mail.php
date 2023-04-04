<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($email) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Por favor vuelve a llenar el formulario.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "jeorhg.maeglin@hotmail.com";

        // Set the email subject.
        $subject = "Alguien se ha puesto en contacto // $name";

        // Build the email content.
        $email_content = "Nombre: $name\n<br>";
        $email_content .= "Email: $email\n\n<br>";
        $email_content .= "Mensaje:\n$message\n<br>";

        // Build the email headers.
        $email_headers = "From: $name <$email>";
        // Activa la condificacción utf-8
        $email_headers = "MIME-Version: 1.0" . "\r\n";
        $email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Gracias por ponerte en contacto. <a href='http://www.jeorhg-desu.com/'>Regresar =></a>";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Paso un error. :/";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "No se puede enviar, intenta de nuevo.";
    }

?>
