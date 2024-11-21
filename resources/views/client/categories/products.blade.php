

@foreach ($products as $product)
  <div class="product-item">
    <h4>{{ $product->name }}</h4>
    <p>{{ $product->description }}</p>
    <p>Giá: {{ $product->price }}</p>
  </div>
@endforeach