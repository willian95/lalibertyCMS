@foreach($payments as $payment)


        <table class="table" style="font-size: 12px;">
            <tbody style="font-size: 12px;">
                <tr>
                    <td style="width: 30px;"><strong>Orden:</strong> {{ $payment->order_id }}</td>
                    <td style="width: 30px;"><strong>Usuario:</strong>{{ $payment->guestUser->name }} - {{ $payment->guestUser->email }}</td>
                </tr>
                <tr>
                    <td style="width: 30px;"><strong>Total:</strong>$ {{ number_format($payment->total, 0, ",", ".") }}</td>
                    <td style="width: 30px;"><strong>Tracking: </strong>{{ $payment->tracking }}</td>
                    <td style="width: 30px;"><strong>Dirección: </strong> {{ $payment->guestUser->address }}</td>
                    <td style="width: 30px;"><strong>Status: </strong>{{ $payment->status }}</td>
                </tr>
                <tr>
                    <td style="width: 30px;"><strong>Fecha: </strong>{{ $payment->created_at->format("d-m-Y") }}</td>
                    <td style="width: 30px;"></td>
                    <td style="width: 30px;"></td>
                </tr>
            </tbody>
        
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Tamaño</th>
                    <th>Color</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payment->productPurchases as $purchase)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>@if($purchase->productColorSize)
                                @if($purchase->productColorSize->product)
                                    {{ $purchase->productColorSize->product->name }}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($purchase->productColorSize)
                                @if($purchase->productColorSize->size)
                                    {{ $purchase->productColorSize->size->size }}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($purchase->productColorSize)
                                @if($purchase->productColorSize->color)
                                    {{ $purchase->productColorSize->color->name }}
                                @endif
                            @endif
                        </td>
                        <td>$ {{ number_format($purchase->price, 0, ",", ".") }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endforeach