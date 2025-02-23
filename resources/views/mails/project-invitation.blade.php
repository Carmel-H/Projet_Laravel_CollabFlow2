<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation au projet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        .accept {
            background-color: #28a745;
        }

        .decline {
            background-color: #dc3545;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Vous avez été ajouté à un projet !</h2>
        <p>Bonjour {{ $user->first_name }} {{ $user->last_name }},</p>
        <p>Vous avez été ajouté au projet <strong>{{ $project->name }}</strong> en tant que {{ $role }} sur notre plateforme.</p>
        <p>Veuillez accepter ou refuser l'invitation en cliquant sur le boutons ci-dessous :</p>
        <p style="text-align: center;">
            <a href="{{ url(route('notifications.index')) }}" class="button accept">Accepter ou Réfuser</a>
        </p>
        <p style="text-align: center;">Merci de faire partie de notre communauté.</p>
        <div class="footer">
            &copy; {{ date('Y') }} CollabFlow. Tous droits réservés.
        </div>
    </div>
</body>

</html>