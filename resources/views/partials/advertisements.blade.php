@php
    $advertisements = \App\Models\Advertisement::currentlyActive()->where('placement', $placement)->get();

    foreach ($advertisements as $advertisement) {
        $advertisement->increment('impressions');
    }
@endphp

@if ($advertisements->isNotEmpty())
    <div class="elora-ads-container">
        @foreach ($advertisements as $advertisement)
            <div class="elora-ad-item" data-ad-id="{{ $advertisement->id }}"
                data-ad-click-url="{{ route('advertisement.click', $advertisement) }}">
                {!! $advertisement->ad_code !!}
            </div>
        @endforeach
    </div>
@endif
