<?php

namespace Services;

class EmailService
{
    public function sendServiceResolved(
        string $email,
        string $name,
        int $serviceId
    ): bool {
        $subject = 'Serviço finalizado';

        $message = "
            <html>
                <body>
                    <h2>Serviço finalizado</h2>
                    <p>Olá, " . htmlspecialchars($name) . ".</p>
                    <p>
                        O serviço <strong>#{$serviceId}</strong>
                        foi finalizado com sucesso.
                    </p>
                </body>
            </html>
        ";

        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: Titan OS <tms.42@hotmail.com>';


        return mail(
            $email,
            $subject,
            $message,
            implode("\r\n", $headers)
        );
    }
}
