<table class="table table-bordered table-striped align-middle">
    <tbody>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-heading me-1 text-info"></i> {{ __("banha.title") }}
        </th>
        <td>{{ $obj->title ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-align-left me-1 text-info"></i> {{ __("banha.description") }}
        </th>
        <td>{{ $obj->description ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-image me-1 text-info"></i> {{ __("banha.image") }}
        </th>
        <td>{!! show_image($obj->image) !!}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-folder me-1 text-info"></i> {{ __("banha.main_category") }}
        </th>
        <td>{{ $obj->mainCategory->title ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-folder-open me-1 text-info"></i> {{ __("banha.sub_category") }}
        </th>
        <td>{{ $obj->subCategory->title ?? '-' }}</td>
    </tr>

    <tr>
        <th class="w-25 text-center text-danger">
            <i class="fas fa-tag me-1 text-danger"></i> {{ __("banha.price") }}
        </th>
        <td>{{ $obj->price ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-danger">
            <i class="fas fa-boxes-stacked me-1 text-danger"></i> {{ __("banha.amount") }}
        </th>
        <td>{{ $obj->amount ?? '-' }}</td>
    </tr>
    <tr>
        <th class="w-25 text-center text-danger">
            <i class="fas fa-boxes-stacked me-1 text-danger"></i> {{ __("banha.points") }}
        </th>
        <td>{{ $obj->points ?? '-' }}</td>
    </tr>

    <tr>
        <th class="w-25 text-center text-warning">
            <i class="fas fa-star me-1 text-warning"></i> {{ __("banha.our_products") }}
        </th>
        <td>{{ $obj->our_products == 'yes' ? __("banha.yes") : __('banha.no') ?? '-' }}</td>
    </tr>

    <tr>
        <th class="w-25 text-center text-primary">
            <i class="fas fa-flag me-1 text-primary"></i> {{ __("banha.made_in_egypt") }}
        </th>
        <td>{{ $obj->made_in_egypt == 'yes' ? __("banha.yes") : __('banha.no') ?? '-' }}</td>
    </tr>

    <tr>
        <th class="w-25 text-center text-secondary">
            <i class="fas fa-images me-1 text-secondary"></i> {{ __("banha.images") }}
        </th>
        <td>
            @forelse($obj->images as $image)
                <span class="d-inline-block me-2 mb-2">
                    {!! show_image($image->image) !!}
                </span>
            @empty
                <span class="text-muted">{{ __('banha.no_images_found') }}</span>
            @endforelse
        </td>
    </tr>
    <tr>
        <th class="w-25 text-center text-info">
            <i class="fas fa-list me-1 text-primary"></i> {{ __("banha.product_attributes") }}
        </th>
        <td>
            @if($obj->productAttributes->count())
                <table class="table table-bordered mb-0">
                    <thead>
                    <tr>
                        @foreach (config('translatable.locales') as $locale)
                            <th class="text-center">
                                {{__('banha.attribute_name')}}  {!! getFieldLanguage($locale) !!}
                            </th>
                        @endforeach
                        <th class="text-center">
                            {{__('banha.attribute_value')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($obj->productAttributes as $attribute)
                        <tr>
                            @foreach (config('translatable.locales') as $locale)
                                <td class="text-center">
                                    {{ $attribute->translate($locale)->attribute_name }}
                                </td>
                            @endforeach
                            <td class="text-center">
                                {{ $attribute->attribute_value }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <span class="text-muted">{{ __('banha.no_attributes_found') }}</span>
            @endif
        </td>
    </tr>
    </tbody>
</table>
