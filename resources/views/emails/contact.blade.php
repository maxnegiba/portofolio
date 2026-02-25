<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Mesaj de contact</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; background-color: #ffffff; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; text-align: center; }
        .label { font-weight: bold; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Mesaj nou de pe portofoliu</h2>
        </div>
        <div class="content">
            <p><span class="label">Nume:</span> {{ $name }}</p>
            <p><span class="label">Email:</span> {{ $email }}</p>
            <p><span class="label">Subiect:</span> {{ $subject }}</p>
            
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">
            
            <p><span class="label">Mesaj:</span></p>
            <p style="white-space: pre-wrap;">{{ $userMessage }}</p>
        </div>
        <div class="footer">
            <p>Acest mesaj a fost trimis prin formularul de contact de pe portofoliul tău.</p>
        </div>
    </div>
</body>
</html>
