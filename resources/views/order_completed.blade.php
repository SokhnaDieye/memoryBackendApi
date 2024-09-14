<!DOCTYPE html>
<html>
<head>
    <title>Facture de votre paiement</title>
</head>
<body>
<h1>Votre paiement a été reçu avec succès</h1>
<p>Merci pour votre paiement. Veuillez trouver ci-joint la facture de votre projet.</p>

<p>Détails du paiement :</p>
<ul>
    <li>Projet : {{ $order->project->name }}</li>
    <li>Date du paiement : {{ $order->payment_date }}</li>
    <li>Montant reçu : {{ $order->amount_received }} F CFA</li>
</ul>
</body>
</html>
