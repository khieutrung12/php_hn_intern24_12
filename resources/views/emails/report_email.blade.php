<div style="width: 600px; margin: 0 auto;">
    <div style="text-align: center;">
        <h1 style="text-align: center;">
            WEEK SALES REPORT
        </h1>
        <p style="text-align: center;">
            Time from {{ date('d-m-Y', strtotime('-1 week', strtotime(date('d-m-Y')))) }} to {{ date('d-m-Y') }}
        </p>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Code</th>
                    <th>Total order value</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 0;
                @endphp
                @foreach ($data as $order)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->code }}</td>
                        <td>{{ $order->sum_price }}</td>
                    </tr>
                    @php
                        $index++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
