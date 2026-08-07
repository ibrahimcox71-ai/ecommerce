@props(['rating' => 0, 'size' => 'sm'])
<div class="star-rating d-inline-flex gap-1" role="img" aria-label="{{ number_format($rating, 1) }} out of 5 stars">
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= floor($rating))
            <i class="fas fa-star text-warning fa-{{ $size }}" aria-hidden="true"></i>
        @elseif ($i - 0.5 <= $rating)
            <i class="fas fa-star-half-alt text-warning fa-{{ $size }}" aria-hidden="true"></i>
        @else
            <i class="far fa-star text-gray-300 fa-{{ $size }}" aria-hidden="true"></i>
        @endif
    @endfor
</div>
