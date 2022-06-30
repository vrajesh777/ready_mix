<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Card</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border-spacing: 30px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        #parts_table {
            margin-top: 30px;
        }
        .bold{font-weight: bold;}
    </style>
</head>

<body style="max-width: 700px;margin:auto">
    <h2 style="text-align: center;">JOB CARD</h2>
    <table>
        <tr>
            <td>Job Card No.</td>
            <td>Door No.</td>
            <td>Hour Meter</td>
            <td>Date</td>
        </tr>
        <tr>
            <td>{{$arr_data['jobcard_no']?? ''}}</td>
            <td>{{$arr_data['door_no']?? ''}}</td>
            <td>{{$arr_data['hours_meter']?? ''}}</td>
            <td>{{$arr_data['delivery_date']?? ''}}</td>
        </tr>
        <tr>
            <td>Model</td>
            <td colspan="2">Chassis No.</td>
            <td>Time</td>
        </tr>
        <tr>
            <td>
            @if(isset($arr_data['vechicle_details']) && sizeof($arr_data['vechicle_details'])>0)
                @if(isset($arr_model) && sizeof($arr_model)>0)
                    @foreach($arr_model as $model)
                        @if($model['id'] == $arr_data['vechicle_details']['model'])
                            <span>{{ $model['model_name'] ?? 0 }}</span>
                        @endif
                    @endforeach
                @endif
                @endif
            </td>
            <td colspan="2" rowspan="3">{{$arr_data['vechicle_details']['chasis_no']?? ''}}</td>
            <td>{{$arr_data['time']?? ''}}</td>
        </tr>
        <tr>
            <td>Plate No.</td>
            <td>KM Count</td>
        </tr>
        <tr>
            <td>{{$arr_data['vechicle_details']['plate_no']?? ''}}</td>
            <td>{{$arr_data['km_count']?? ''}}</td>
        </tr>
        <tr>
            <td colspan="4"><span class="bold">Complaint:</span> <br/> {{$arr_data['complaint']?? ''}}</td>
        </tr>
        <tr>
            <td colspan="4"><span class="bold">Diagnosis:</span> <br/> {{$arr_data['diagnosis']?? ''}}</td>
        </tr>
        <tr>
            <td colspan="4"><span class="bold">Action:</span> <br/> {{$arr_data['action']?? ''}}</td>
        </tr>
    </table>
    <!-- parts table -->
    <table id="parts_table">
        <tr>
            <td colspan="5">Parts Used:-</td>
        </tr>
        <tr>
            <td>SN</td>
            <td>Part No.</td>
            <td>Part Name</td>
            <td>Qyt.</td>
        </tr>
        @if(isset($arr_parts) && count($arr_parts) > 0 )
        @foreach($arr_parts as $index => $part)
        @php
            $item = $part['item'] ?? [];
            $unit_detail = $item['unit_detail'] ?? [];
        @endphp
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $item['commodity_code'] ?? '' }}</td>
            <td>{{ $item['commodity_name'] ?? '' }}</td>
            <td>{{ $part['quantity'] ?? 0 }} ({{ $unit_detail['unit_symbol'] ?? '' }})</td>
        </tr>
        @endforeach
        @endif
    </table>
</body>

</html>