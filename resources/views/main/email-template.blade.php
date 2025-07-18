<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>

    <!-- Embed Poppins font via @import inside <style> (for better email compatibility) -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body, table, p, th, td {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>
<body style="background-color: #edf2f7; display: flex; justify-content: center; align-items: center; height: 60vh; margin: 0; padding: 20px; color: black; font-family: 'Poppins', sans-serif;">
<table style="background-color: white; width: 90%; max-width: 600px; border-spacing: 0; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); border-radius: 12px; text-align: left; box-sizing: border-box; margin: auto; font-family: 'Poppins', sans-serif;">
    <tr>
        <th style="text-align: center; padding-bottom: 20px;">
            <img src="https://i.ibb.co/yYynhQ5/logo1.png" alt="Logo" style="max-width: 150px; height: auto;">
        </th>
    </tr>
    <tr>
        <td>
            <p style="font-size: 16px; line-height: 1.5em; margin: 0 0 10px; font-weight: bold;">
                Nauja žinutė nuo: {{ $fromEmail }}
            </p>
            <p style="font-size: 16px; line-height: 1.5em; margin: 0 0 10px;">
                Tema: {{ $subject }}
            </p>
            <p style="font-size: 16px; line-height: 1.5em; margin: 0 0 10px;">
                {{ $body }}
            </p>
            <p style="font-size: 16px; line-height: 1.5em; margin: 0 0 10px;">
                Išsiųsta: {{ now() }}
            </p>
        </td>
    </tr>
</table>
</body>
</html>
