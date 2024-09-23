<!DOCTYPE html>
<html>
<head>
    <title>Relance de Paiement en retard</title>
</head>
<body>
<h1>Bonjour {{ $client->name }},</h1>

<p>Nous vous rappelons que le paiement pour le projet <strong>{{ $project->name }}</strong> est en retard.</p>

<p><strong>Montant dû :</strong> {{ $totalAmountDue }} F CFA</p>
<p><strong>Date d'échéance :</strong> {{ $project->end_date->format('d/m/Y') }}</p>

<p>Veuillez effectuer le paiement dès que possible.</p>

<p>Merci de votre confiance,</p>
<p>L'équipe de SEN FACTURIX </p>
</body>
</html>
