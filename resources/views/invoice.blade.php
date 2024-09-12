<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .heading { font-size: 24px; font-weight: bold; }
        .total { font-size: 20px; font-weight: bold; text-align: right; }
    </style>
</head>
<body>
<div class="invoice-box">
    <h2>Facture pour {{ $client->name }}</h2>
    <p>Date: {{ $payment->payment_date }}</p>
    <p>Référence de transaction: {{ $payment->transaction_reference }}</p>

    <table width="100%">
        <tr>
            <td>Projet: {{ $project->name }}</td>
            <td>Montant: {{ $payment->amount_received }} F CFA</td>
        </tr>
    </table>

    <div class="total">
        Total: {{ $payment->amount_received }} F CFA
    </div>
</div>
</body>
</html>
