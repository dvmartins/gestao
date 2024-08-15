<!DOCTYPE html>
<html>
<head>
    <title>Notas Fiscais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand" href="#">Sistema de Notas</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('invoices.index') }}">Notas Fiscais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('invoices.create') }}">Upload XML</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1>Notas Fiscais</h1>
    <form method="GET" action="{{ route('invoices.index') }}" class="mb-4">
        <div class="row">
            <div class="col">
                <input type="text" name="invoice_number" class="form-control" placeholder="Número da Nota">
            </div>
            <div class="col">
                <input type="text" name="emitter_cnpj" class="form-control" placeholder="CNPJ do Emitente">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Número</th>
                <th>Data</th>
                <th>Emitente</th>
                <th>Destinatário</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ $invoice->emitter_cnpj }}</td>
                    <td>{{ $invoice->receiver_cnpj }}</td>
                    <td>{{ $invoice->total_value }}</td>
                    <td>
                        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success btn-sm">Download</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
