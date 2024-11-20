@foreach ($products as $product)
<div class="col">
    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
        <div class="position-relative">
            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="{{ route('product.show', $product->id) }}">
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                </div>
            </a>
        </div>
        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
            <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('product.show', $product->id) }}">
                    <span class="animate-target">{{ $product->name }}</span>
                </a>
            </h3>
            <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">{{ $product->price }} <del class="text-body-tertiary fs-sm fw-normal">$430.00</del></div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                    <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach
