<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input, textarea, button {
            padding: 10px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .info {
            margin-top: 30px;
        }
        iframe {
            width: 100%;
            height: 400px;
            border: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contactez-nous</h1>
       
        <form>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="message" rows="5" placeholder="Votre message..." required></textarea>
            <button type="submit">Envoyer</button>
        </form>
 
        <div class="info">
            <h2>Informations sur l'entreprise</h2>
            <p><strong>Nom :</strong> Guestbook</p>
            <p><strong>Adresse :</strong> 30-32 Avenue de la République, 94800 Villejuif, France</p>
            <p><strong>Téléphone :</strong> +33 1 23 45 67 89</p>
            <p><strong>Email :</strong> guestbook@yopmail.com</p>
        </div>
 
        <div class="map">
            <h2>Nous trouver :</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2628.644183143825!2d2.36179865183716!3d48.78868285718452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e673e24e04a9c3%3A0xc55cb3e676f95321!2sEfrei!5e0!3m2!1sfr!2sfr!4v1732785175546!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <p><a href="https://www.google.com/maps?q=30-32+Avenue+de+la+République,94800+Villejuif,France" target="_blank">Voir sur Google Maps</a></p>
        </div>
    </div>
</body>
</html>