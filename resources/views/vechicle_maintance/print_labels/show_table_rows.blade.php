@if(isset($arr_parts_data) && sizeof($arr_parts_data)>0)
@forelse ($arr_parts_data as $product)
    <tr>
        <td>
            {{$product['part']['commodity_name'] ?? ''}} - {{$product['part_no'] ?? 0}}

            <input type="hidden" name="products[{{$loop->index + $index}}][part_id]" value="{{$product['part_id'] ?? 0}}">
            <input type="hidden" name="products[{{$loop->index + $index}}][part_no]" value="{{$product['part_no'] ?? 0}}">
        </td>
        <td>
            <input style="width:100px;" type="number" class="form-control" min=1
            name="products[{{$loop->index + $index}}][quantity]" value="@if(isset($product->quantity)){{$product->quantity}}@else{{1}}@endif">
        </td>
    </tr>
@empty


@endforelse
@endif