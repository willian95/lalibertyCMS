<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th style="width: 30px;">Nombre</th>
            <th style="width: 30px;">Tamaño</th>
            <th style="width: 30px;">Color</th>
            <th style="width: 30px;">Stock</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        @foreach($products as $product)
            <tr>
                <td>
                    {{ $loop->index + 1 }}
                </td>
                <td>
                    {{ $product->product->name }}
                </td>
                <td>
                    {{ $product->size->size }}
                </td>
                <td>
                    {{ $product->color->name }}
                </td>
                <td>
                    {{ $product->stock }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>