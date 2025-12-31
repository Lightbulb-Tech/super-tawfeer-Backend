<table class="table table-bordered table-striped align-middle">
    <tbody>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-user me-1 text-info"></i> {{ __("banha.name") }}
        </th>
        <td>{{ $obj->first_name . ' ' . $obj->last_name ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-phone me-1 text-info"></i> {{ __("banha.phone") }}
        </th>
        <td>{{$obj->phone_code .' '. $obj->phone ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-image me-1 text-info"></i> {{ __("banha.image") }}
        </th>
        <td>{!! show_image($obj->image) !!}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-envelope me-1 text-info"></i> {{ __("banha.email") }}
        </th>
        <td>{{ $obj->email ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-star me-1 text-warning"></i> {{ __("banha.points") }}
        </th>
        <td>{{ $obj->points ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-danger">
            <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ __("banha.address") }}
        </th>
        <td>{{ @$obj->address->address ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-danger">
            <i class="fas fa-city me-1 text-danger"></i> {{ __("banha.area") }}
        </th>
        <td>{{ @$obj->address->area->title ?? '-' }}</td>
    </tr>
    </tbody>
</table>
