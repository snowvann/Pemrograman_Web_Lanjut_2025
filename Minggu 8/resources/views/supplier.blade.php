<!DOCTYPE html>
    <html>
        <head>
            <title>Data Supplier</title>
        </head>

        <body>
            <h1>Data Supplier</h1>
            <table border="1" cellpadding="2" cellspacing="0">
                <tr>
                    <td>ID</td>
                    <td>Supplier Kode</td>
                    <td>Supplier Nama</td>
                    <td>Alamat Supplier</td>
                </tr>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $d->supplier_id }}</td>
                    <td>{{ $d->supplier_kode }}</td>
                    <td>{{ $d->supplier_nama}}</td>
                    <td>{{ $d->alamat_supplier }}</td>
                </tr>
                @endforeach
            </table>
        </body>
    </html>