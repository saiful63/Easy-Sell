<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Report</title>
</head>
<body>
<table>
    <h4>Summary</h4>
    <thead>
      <tr>
          <th>Report</th>
          <th>Date range</th>
          <th>Total</th>
          <th>Discount</th>
          <th>Vat</th>
          <th>Payable</th>
      </tr>
    </thead>
    <tbody>
     @foreach($invoices as $invoice)
        <tr>
            <td>Sales Report</td>
            <td>{{ $start }}-{{ $end }}</td>
            <td>{{ $invoice->total }}</td>
            <td>{{ $invoice->discount }}</td>
            <td>{{ $invoice->vat }}</td>
            <td>{{ $invoice->payable }}</td>
        </tr>
     @endforeach
    </tbody>
</table>
<hr>
<table>
    <h4>Details</h4>
    <thead>
      <tr>
          <th>Customer</th>
          <th>Phone</th>
          <th>Total</th>
          <th>Discount</th>
          <th>Vat</th>
          <th>Payable</th>
          <th>Date</th>
      </tr>
    </thead>
    <tbody>
     @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->customer['name'] }}</td>
            <td>{{ $invoice->customer['phone']  }}</td>/td>
            <td>{{ $invoice->total }}</td>
            <td>{{ $invoice->discount }}</td>
            <td>{{ $invoice->vat }}</td>
            <td>{{ $invoice->payable }}</td>
            <td>{{ $invoice->created_at }}</td>
        </tr>
     @endforeach
    </tbody>
</table>
</body>
</html>
