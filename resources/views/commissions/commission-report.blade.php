<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Commission Report</title>

    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            /* text-align: center; */
            /* border: 1px solid #ddd; */
            font-size: 12px;
        }

        .invoice_tab td {
            text-align: center;
        }
    </style>

</head>

<body style="margin-bottom: 0;margin-top: 0">
    <h2 style="margin-top: 0; margin-bottom: 0;text-align:center">Alpha Digital</h2>
    <p style="margin-top: 2; margin-bottom: 0;text-align:center">Contact: 03477844223, Email: info@alpha.edu.com</p>
    <p style="margin-top: 2; margin-bottom: 0;text-align:center">Address: Mustafa Plaza , Ring Road Peshawar</p>
    <table style="margin-bottom: 0;margin-top: 10px">
        <tr>
            <td align="left" style="border-top:1px solid;border-bottom:1px solid;">
                <p style="text-align:center;margin-top:0;margin-bottom:0">Commissions Report</p>
            </td>
        </tr>

    </table>

    <table>
        <td>From Date : 11-10-22</td>
        <td style="text-align: right"> To Date :11-10-22</td>
    </table>
    <table class="invoice_tab " style="margin-top: 10px">
        <thead>
            <tr style="background-color:#e4e6eb;">
                <th>#</th>
                <th>Date</th>
                <th>Employee</th>
                <th>Commiion Type</th>
                <th>Status</th>
                <th>Amount</th>

            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach ($commissions as $com)
                <tr>
                    <td>{{$counter}}</td>
                    <td>{{$com->earned_date}}</td>
                    <td>{{$com->user->name}}</td>
                    <td>{{$com->commission_type==1?"Sale": "Recovery"}}</td>
                    <td>{{$com->status?"paid":"Not Paid"}}</td>
                    <td>{{$com->amount}}</td>
                   
                   
                </tr>
                @php
                $counter = $counter + 1;
                @endphp
            @endforeach

            <tr style="margin-bottom:0;margin-top:0">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <p> <span style="font-weight: bold"> Total Amount: </span>{{$commissions->sum('amount')}} PKR </p>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
