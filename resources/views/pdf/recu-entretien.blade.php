<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reçu d'entretien #{{ $entretien->id ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #4a5568;
            margin-bottom: 3px;
        }
        .info-value {
            color: #2d3748;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f7fafc;
            font-weight: bold;
            color: #4a5568;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #718096;
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reçu d'entretien</div>
        <div class="subtitle">N° {{ str_pad($entretien->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="info-grid">
        <div>
            <div class="section">
                <div class="section-title">Informations client</div>
                <div class="info-item">
                    <div class="info-label">Nom</div>
                    <div class="info-value">{{ $entretien->user->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $entretien->user->email }}</div>
                </div>
            </div>
        </div>
        <div>
            <div class="section">
                <div class="section-title">Informations véhicule</div>
                <div class="info-item">
                    <div class="info-label">Véhicule</div>
                    <div class="info-value">{{ $entretien->vehicule->marque }} {{ $entretien->vehicule->modele }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Immatriculation</div>
                    <div class="info-value">{{ $entretien->vehicule->immatriculation }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kilométrage</div>
                    <div class="info-value">{{ number_format($entretien->kilometrage, 0, ',', ' ') }} km</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Détails de l'entretien</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Type d'entretien</th>
                    <th>Date</th>
                    <th class="text-right">Coût des pièces</th>
                    <th class="text-right">Main d'œuvre</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $entretien->type }}</td>
                    <td>{{ \Carbon\Carbon::parse($entretien->date_entretien)->format('d/m/Y') }}</td>
                    <td class="text-right">{{ number_format($entretien->prix_pieces, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($entretien->prix_main_oeuvre, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($entretien->prix, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total TTC</strong></td>
                    <td colspan="2" class="text-right">
                        <span class="total-amount">{{ number_format($entretien->prix, 0, ',', ' ') }} FCFA</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($entretien->note)
    <div class="section">
        <div class="section-title">Notes</div>
        <p>{{ $entretien->note }}</p>
    </div>
    @endif

    <div class="signature">
        <div style="margin-bottom: 50px;">
            Fait à {{ config('app.name') }}, le {{ now()->format('d/m/Y') }}
        </div>
        <div>
            <div style="border-top: 1px solid #000; width: 200px; display: inline-block;"></div>
            <div>Signature</div>
        </div>
    </div>

    <div class="footer">
        <p>{{ config('app.name') }} - {{ config('app.url') }}</p>
        <p>Ce document est un reçu électronique valable sans signature.</p>
    </div>
</body>
</html>
