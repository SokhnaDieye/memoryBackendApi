<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .invoice-box {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background-color: #fff;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            margin: 10px 0;
            font-size: 24px;
            color: #007bff;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-details p {
            margin: 5px 0;
        }

        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-items th, .invoice-items td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .invoice-items th {
            background-color: #007bff;
            color: #fff;
        }

        .invoice-total {
            text-align: right;
            margin-bottom: 20px;
        }

        .invoice-total p {
            font-size: 18px;
            margin: 5px 0;
        }

        .invoice-footer {
            text-align: center;
            color: #777;
            margin-top: 30px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="invoice-header">
        <h1>Facture pour {{ $client->name }}</h1>
    </div>

    <div class="invoice-details">
        <p><strong>Date de paiement:</strong> {{ $payment->payment_date }}</p>
        <p><strong>Référence de transaction:</strong> {{ $payment->transaction_reference }}</p>
    </div>

    <table class="invoice-items">
        <thead>
        <tr>
            <th>Projet</th>
            <th>Montant</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $project->name }}</td>
            <td>{{ $payment->amount_received }} F CFA</td>
        </tr>
        </tbody>
    </table>

    <div class="invoice-total">
        <p><strong>Total: {{ $payment->amount_received }} F CFA</strong></p>
    </div>

    <div class="invoice-footer">
        <p>Merci pour votre paiement!</p>
    </div>
</div>
</body>
</html>
