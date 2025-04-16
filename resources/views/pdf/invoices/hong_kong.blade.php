<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body,
    html {
        margin: 10;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    .header {
        display: block;

    }

    .header img {
        height: 80px;
        width: auto;

    }

    p {
        font-size: 12px;
        line-height: 1.6;
    }

    h1 {
        font-weight: normal
    }

    @page {
        size: 8.5in 11in;

        /* Or set custom size like size: 210mm 297mm; */
        margin: 20mm;
        /* Adjust margins as needed */
    }

</style>

@php
$invoiceDate = \Carbon\Carbon::parse($record->invoice_date)->format('j M Y');
$invoiceDueDate = \Carbon\Carbon::parse($record->invoice_date)->addDays(8)->format('j M Y');
$referenceDate = \Carbon\Carbon::parse($record->invoice_date)->format('m/y');
$referenceName = $record->employee->name;
$invoiceNumber = 'INV-000' . $record->id;
@endphp
<body>
    @include('pdf.invoices.layout.header')
    <main>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>

                <!-- First column -->
                <td style="width: 80%; vertical-align: top; padding-right: 20px; ">
                    <h1>INVOICE</h1>

                    <div style='padding-left: 20px;'>
                        <p>{{ $record->company->name }}<br>

                            {{ $record->company->address }}<br>
                            {{ $record->company->city }}, {{ $record->company->postal }}<br>
                            {{ $record->company->state }} {{ $record->company->country }}<br>
                            {{ $record->company->tax_id}}
                        </p>
                    </div>

                </td>

                <!-- Second column -->
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <!-- Sub-column 1 -->
                            <td style="width: 40%; vertical-align: top;">
                                <div>
                                    <p style="font-weight: bold;">Invoice Date</p>
                                    <p style='margin-top: -15px'>{{$invoiceDate}}</p>
                                </div>
                                <div >
                                    <p style="font-weight: bold;">Invoice Number</p>
                                    <p style='margin-top: -15px'>{{$invoiceNumber}}</p>
                                </div >
                                <div >
                                    <p style="font-weight: bold;">Reference</p>
                                    <p style='margin-top: -15px'>{{$referenceDate}} {{ $referenceName }}</p>
                                </div>

                            </td>

                            <!-- Sub-column 2 -->
                            <td style="width: 60%; vertical-align: top; ">
                                <p style='line-height: 1.7'>INTERMEDIANO HONG KONG LIMITED <br>
                                    Flat A11/F. Cheung Lung <br>
                                    Ind Bldg 10 Cheung Yee ST, <br>
                                    Cheung Sha Wan Hong Kong <br>
                                    TAX ID: 77682459
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px; margin-top: 30px;">
            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th style="text-align: left; padding: 8px;">Description</th>
                    <th style="text-align: right; padding: 8px;">Quantity</th>
                    <th style="text-align: right; padding: 8px;">Unit Price</th>
                    <th style="text-align: right; padding: 8px;">Tax</th>
                    <th style="text-align: right; padding: 8px;">Amount USD</th>
                </tr>
            </thead>
            <tbody>
                @php
                $subtotal = 0;
                @endphp

                @foreach ($record->invoice_items as $invoice_item)
                @php
                $totalAmount = (float)$invoice_item['quantity'] * (float)$invoice_item['unit_price'];
                $subtotal += $totalAmount;
                @endphp
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 8px;">{{ $invoice_item['description'] }}</td>
                    <td style="text-align: right; padding: 8px;">{{ $invoice_item['quantity'] }}</td>
                    <td style="text-align: right; padding: 8px;">{{ number_format($invoice_item['unit_price'], 2) }}</td>
                    <td style="text-align: right; padding: 8px;">{{ $invoice_item['tax'] }}</td>
                    <td style="text-align: right; padding: 8px;">{{ number_format($totalAmount, 2)}}</td>
                </tr>
                @endforeach

                <!-- Subtotal Row -->
                <tr style="border-bottom: 1px solid #ddd;">
                    <td colspan="4" style="text-align: right; padding: 8px; font-weight: bold;">Subtotal</td>
                    <td style="text-align: right; padding: 8px;">{{ number_format($subtotal, 2)  }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; font-size: 14px; border-top: 2px solid #000;">
                    <td colspan="4" style="text-align: right; padding: 8px;">TOTAL USD</td>
                    <td style="text-align: right; padding: 8px;">{{ number_format($subtotal, 2)  }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 30px">

            <div>
                <b>Due Date: {{ $invoiceDueDate }}</b>
                <p>Intermediano Hong Kong Limited</p>
                <p>Beneficiary Bank: DBS BANK (HONG KONG) LIMITED (DHBKHKHHXXX). HONG KONG, HongKong</p>
                <p>beneficiary account: 7950189779</p>
                <p>Intermediate Bank: JPMORGAN CHASE BANK, N.A. (CHASUS33XXX). NEW YORK,NY, EEUU.</p>
            </div>
        </div>
        <div style="border-top: 1px dashed black; margin: 20px 0; position: relative; padding-top: 20px;">
            <div style="position: absolute; top: -11px; left: 0; font-size: 12px;">
                <img src="{{ public_path('images/scissor.png') }}" width="22" height="22">

            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>

                    <!-- First column -->
                    <td style="width: 50%; vertical-align: top; padding-right: 20px; ">
                        <h1>PAYMENT ADVICE</h1>

                        <div style='padding-left: 20px;'>
                            <p style="margin: 5px 0 0; font-size: 12px;">
                                To: {{ $record->company->name }}

                            </p>
                            <p style='padding-left: 20px; line-height: 1.6;'> {{ $record->company->address }}<br>
                                {{ $record->company->city }}, {{ $record->company->postal }}<br>
                                {{ $record->company->state }} {{ $record->company->country }}<br>
                                {{ $record->company->tax_id}}</p>
                        </div>

                    </td>

                    <!-- Second column -->
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse;">

                            <tr style='margin-top: 40px'>
                                <td>
                                    <p style="font-weight: bold; display: inline; ">Customer</p>
                                </td>
                                <td>
                                    <p style="display: inline;">{{ $record->company->name }}</p>
                                </td>
                            </tr>
                            <tr style='padding: 10px; border-bottom: 1px solid #ccc'>
                                <td>
                                    <p style="font-weight: bold; display: inline;">Invoice Number</p>
                                </td>
                                <td>
                                    <p style="display: inline;">{{$invoiceNumber}}</p>
                                </td>
                            </tr>
                            <tr style='padding: 10px;'>
                                <td>
                                    <p style="font-weight: bold; display: inline;">Amount Due</p>
                                </td>
                                <td>
                                    <p style="display: inline; font-weight: bold;">{{ number_format($subtotal, 2) }}</p>
                                </td>
                            </tr>
                            <tr style='padding: 10px; border-bottom: 1px solid #ccc'>
                                <td>
                                    <p style="font-weight: bold; display: inline;">Due Date</p>
                                </td>
                                <td>
                                    <p style="display: inline; font-weight: bold;">{{ $invoiceDueDate }}</p>
                                </td>
                            </tr>
                            <tr style="padding: 10px;">
                                <td style="width: auto; white-space: nowrap;">
                                    <p style="font-weight: bold; display: inline; white-space: nowrap;">Amount Enclosed</p>
                                </td>
                                <td>
                                    <div style='border-bottom: 1px solid #000; width: 100%; margin-top: 20px;'></div>
                                </td>
                            </tr>
                            <tr  style="padding: 10px;">
                                <td>
                                    <p style="font-weight: bold; display: inline;"></p>
                                </td>
                                <td>
                                    <p style="display: inline; margin-top: -20px;">Enter the amount you are paying above</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>

        <div style='text-align: center; position: absolute; bottom: 10;'>
            <p style='font-size: 9px'>Company Registration No: 733087506RC0001.  Registered Office: Attention: Fernando Gutierrez, Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST, Cheung Sha Wan Hong Kong.
            </p>
        </div>

    </main>
</body>
</html>
