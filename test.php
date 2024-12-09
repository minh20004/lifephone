<form action="{{ route('order.store') }}" method="POST" class="needs-validation" novalidate>
  @csrf
  <div class="row pt-1 pt-sm-3 pt-lg-4 pb-2 pb-md-3 pb-lg-4 pb-xl-5">
    
      <!-- Delivery info (Step 1) -->
      <div class="col-lg-8 col-xl-7 mb-5 mb-lg-0">
      
        <div class="d-flex flex-column gap-5 pe-lg-4 pe-xl-0">
          
            {{-- <div class="d-flex align-items-start">
              <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">1</div>
              <div class="flex-grow-0 flex-shrink-0 ps-3 ps-md-4" style="width: calc(100% - 2rem)">
                <h1 class="h5 mb-md-4">Thông tin giao hàng</h1>
                <div class="ms-n5 ms-sm-0">
                  <h3 class="h6 border-bottom pb-4 mb-0">Chọn phương thức vận chuyển</h3>
                  <div class="mb-lg-4" id="shippingMethod" role="list">

                    <!-- Giao hàng chuyển phát nhanh -->
                    <div class="border-bottom">
                      <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#courier" aria-expanded="true" aria-controls="courier">
                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold py-4">
                          <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method" checked="">
                          Giao hàng chuyển phát nhanh
                          <span class="fw-normal ms-auto">35.000 đ</span>
                        </label>
                      </div>
                      
                    </div>

                    <!-- nhận từ store -->
                    <div class="border-bottom">
                      <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#pickup" aria-expanded="false" aria-controls="pickup">
                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold py-4">
                          <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method">
                          Nhận hàng từ cửa hàng
                          <span class="fw-normal ms-auto">Miễn phí</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}

            <!-- Shipping address -->
          <div class="d-flex align-items-start">
            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">1</div>
            <div class="w-100 ps-3 ps-md-4">
                <div class="d-flex justify-content-between">
                  <h1 class="h5 mb-md-4">Địa chỉ giao hàng</h1>
                  <a type="button" class="text-decoration-none fs-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Thay Đổi
                  </a>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 g-3 g-sm-4 mb-4">
                    <div class="col">
                        <label for="shipping-name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="shipping-name" name="name" 
                            value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->name : '' }}" 
                            readonly required>
                    </div>
                    <div class="col">
                        <label for="shipping-phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="shipping-phone" name="phone" 
                            value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->phone_number : '' }}" 
                            readonly required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="shipping-email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-lg" id="shipping-email" name="email" 
                        value="{{ auth('customer')->check() ? auth('customer')->user()->email : '' }}" 
                        readonly required>
                </div>
                <div class="mb-3">
                    <label for="shipping-address" class="form-label">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg" id="shipping-address" name="address" 
                        value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->address : '' }}" 
                        readonly required>
                </div>
                
        
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Địa chỉ của tôi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="d-flex list-group ">
                                    @foreach ($addresses as $address)
                                        <li class=" d-flex gap-3 list-group-item border-bottom border-danger">
                                          <input type="radio" class="btn btn-primary btn-sm mt-2 change-address-btn" 
                                              name="selected_address"
                                              data-name="{{ $address->name }}" 
                                              data-phone="{{ $address->phone_number }}" 
                                              data-address="{{ $address->address }}" style="width: 20px;height: 20px;accent-color: red; font-size: 26px;"> 
    
    
                                            <div>
                                              <strong>{{ $address->name }}</strong> | {{ $address->phone_number }}<br>
                                              {{ $address->address }}
                                          </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirm-address-btn">Xác Nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
            <!-- Payment -->
            <div class="d-flex align-items-start">
              <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">2</div>
              <div class="w-100 ps-3 ps-md-4">
                <h2 class="h5 mb-0">Phương thức thanh toán</h2>
                <div class="mb-4" id="paymentMethod" role="list">

                  <!-- Cash on delivery -->
                  <div class="mt-4">
                    <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#cash" aria-expanded="false" aria-controls="cash">
                      <label class="form-check-label w-100 text-dark-emphasis fw-semibold">
                        <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="COD">
                        Thanh toán khi nhận hàng (COD)
                      </label>
                    </div>
                    
                  </div>


                  <!-- Thanh toán online -->
                  <div class="mt-4">
                    <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#paypal" aria-expanded="false" aria-controls="paypal">
                      <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                        <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="Online">
                        Thanh Toán Online
                      </label>
                    </div>
                    <div class="collapse" id="paypal" data-bs-parent="#paymentMethod"></div>
                  </div>

                </div>

                <!-- Add promo code button -->
                <div class="nav pb-3 mb-2 mb-sm-3">
                  <a class="nav-link animate-underline p-0" href="#!">
                    <i class="ci-plus-circle fs-xl ms-a me-2"></i>
                    <span class="animate-target">Thêm mã khuyến mại hoặc thẻ quà tặng</span>
                  </a>
                </div>

                <!-- Nội dung -->
                <textarea class="form-control form-control-lg mb-4" rows="3" name="description" placeholder="Nội dung"></textarea>

                <button type="submit" class="btn btn-lg btn-primary w-100 d-none d-lg-flex" >Đặt Hàng</button>
              </div>
            </div>
        </div>
      </div>


        <!-- Order summary (sticky sidebar) -->
        <aside class="col-lg-4 offset-xl-1" style="margin-top: -100px">
          <div class="position-sticky top-0" style="padding-top: 100px">
            <div class="bg-body-tertiary rounded-5 p-4 mb-3">
              <div class="p-sm-2 p-lg-0 p-xl-2">
                <div class="border-bottom pb-4 mb-4">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                    <div class="nav">
                      <a class="nav-link text-decoration-underline p-0" href="{{route('cart.index')}}">Sửa</a>
                    </div>
                  </div>
                  
                        <a class="d-flex align-items-center gap-2 text-decoration-none " href="#orderPreview" data-bs-toggle="offcanvas">
                          @foreach ($cart as $product)
                            @foreach ($product as $model)
                                @foreach ($model as $item)
                                  <div class="ratio ratio-1x1 " style="max-width: 64px">
                                    <div class="">
                                      <img src="{{ asset('storage/' . $item['image_url']) }}" class="d-block p-1" alt="iPhone" style="width: 70px; height:70px;">
                                    </div>
                                  </div>
                                @endforeach
                             @endforeach
                          @endforeach
                  <i class="ci-chevron-right text-body fs-xl p-0 ms-auto"></i>
                        </a>
                      </div>
                      
                  <ul class="list-unstyled fs-sm gap-3 mb-0">
                    <li class="d-flex justify-content-between">
                      Tổng cộng ({{ $totalQuantity }} sản phẩm):
                      <span class="text-dark-emphasis fw-medium">{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
                    </li>
                    <li class="d-flex justify-content-between">
                      Giảm giá:
                      <span class="text-danger fw-medium">{{ number_format($discount, 0, ',', '.') }} đ</span>
                    </li>
                  </ul>
                  <div class="border-top pt-4 mt-4">
                    <div class="d-flex justify-content-between mb-3">
                      <span class="fs-sm">Tổng ước tính:</span>
                      <span class="h5 mb-0">{{ number_format($estimatedTotal, 0, ',', '.') }} đ</span>
                    </div>
                  </div>
                      
              </div>
            </div>
            <div class="bg-body-tertiary rounded-5 p-4">
              <div class="d-flex align-items-center px-sm-2 px-lg-0 px-xl-2">
                <svg class="text-warning flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"><path d="M1.333 9.667H7.5V16h-5c-.64 0-1.167-.527-1.167-1.167V9.667zm13.334 0v5.167c0 .64-.527 1.167-1.167 1.167h-5V9.667h6.167zM0 5.833V7.5c0 .64.527 1.167 1.167 1.167h.167H7.5v-1-3H1.167C.527 4.667 0 5.193 0 5.833zm14.833-1.166H8.5v3 1h6.167.167C15.473 8.667 16 8.14 16 7.5V5.833c0-.64-.527-1.167-1.167-1.167z"></path><path d="M8 5.363a.5.5 0 0 1-.495-.573C7.752 3.123 9.054-.03 12.219-.03c1.807.001 2.447.977 2.447 1.813 0 1.486-2.069 3.58-6.667 3.58zM12.219.971c-2.388 0-3.295 2.27-3.595 3.377 1.884-.088 3.072-.565 3.756-.971.949-.563 1.287-1.193 1.287-1.595 0-.599-.747-.811-1.447-.811z"></path><path d="M8.001 5.363c-4.598 0-6.667-2.094-6.667-3.58 0-.836.641-1.812 2.448-1.812 3.165 0 4.467 3.153 4.713 4.819a.5.5 0 0 1-.495.573zM3.782.971c-.7 0-1.448.213-1.448.812 0 .851 1.489 2.403 5.042 2.566C7.076 3.241 6.169.971 3.782.971z"></path></svg>
                <div class="text-dark-emphasis fs-sm ps-2 ms-1">Xin chúc mừng! Bạn đã kiếm được <span class="fw-semibold">240 tiền thưởng</span></div>
              </div>
            </div>
          </div>
        </aside>
        
  
  </div>
</form>



public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $totalQuantity = 0;
        $totalPrice = 0;

        // Lấy ID sản phẩm từ giỏ hàng
        $productIds = array_keys($cart);

        // Lấy thông tin sản phẩm và biến thể
        $products = Product::findMany($productIds);
        $variants = ProductVariant::whereIn('product_id', $productIds)->with(['capacity', 'color'])->get()->keyBy(function ($variant) {
            return "{$variant->product_id}-{$variant->capacity_id}-{$variant->color_id}";
        });

        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colorModels) {
                foreach ($colorModels as $colorId => $item) {
                    $product = $products->find($productId);
                    $variantKey = "{$productId}-{$modelId}-{$colorId}";
                    $variant = $variants->get($variantKey);

                    if ($product && $variant) {
                        $itemTotal = $item['quantity'] * $item['price'];
                        $totalPrice += $itemTotal;
                        $totalQuantity += $item['quantity'];

                        $cartItems[] = [
                            'product' => $product,
                            'capacity' => $variant->capacity,
                            'color' => $variant->color,
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'itemTotal' => $itemTotal,
                            'image_url' => $item['image_url'] ?? '',
                        ];
                    }
                }
            }
        }
        session()->put('cart', $cart);

        // Tính lại giảm giá nếu có mã voucher
        $voucher = session()->get('voucher', []);
        if ($voucher && !empty($voucher['code'])) {
            $this->recalculateVoucher();
        }
        // Tính toán giảm giá và tổng cộng
        $voucher = session()->get('voucher', []);
        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $totalPrice - $discount;

        return view('client.page.cart.index', compact('cartItems', 'totalQuantity', 'totalPrice', 'discount', 'totalAfterDiscount'));
    }
    
    cart ổn 
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'model-options' => 'required|integer|exists:capacities,id',
            'color-options' => 'required|integer|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ],[
            'color-options' => 'Màu sắc không được để trống'
        ]);

        $productId = $request->input('product_id');
        $modelId = $request->input('model-options');
        $colorId = $request->input('color-options');
        $quantity = $request->input('quantity');

        $variant = ProductVariant::where('product_id', $productId)
            ->where('capacity_id', $modelId)
            ->where('color_id', $colorId)
            ->with(['capacity', 'color'])
            ->firstOrFail();
        
        // Kiểm tra xem người dùng có vuwowth quá sl không
        if ($quantity > $variant->stock) {
            return back()->withErrors(['quantity' => 'Số lượng không được vượt quá số lượng tồn kho ('.$variant->stock_quantity.' sản phẩm).']);
        }
        // Kiểm tra xem trong giỏ hàng đã có sản phẩm này chưa và số lượng đã có trong giỏ hàng
        $cart = session()->get('cart', []);
        $existingQuantity = 0;
        if (isset($cart[$productId][$modelId][$colorId])) {
            $existingQuantity = $cart[$productId][$modelId][$colorId]['quantity'];
        }

        // Kiểm tra xem tổng số lượng trong giỏ hàng có vượt quá số lượng tồn kho không
        $totalQuantity = $existingQuantity + $quantity;
        if ($totalQuantity > $variant->stock) {
            return back()->withErrors(['quantity' => 'Số lượng trong giỏ hàng không thể vượt quá số lượng tồn kho ('.$variant->stock.' sản phẩm).']);
        }

        $price = $variant->product->price + $variant->price_difference;

        $cartItem = [
            'id' => $productId,
            'model_id' => $modelId,
            'color_id' => $colorId,
            'variant_id' => $variant->id, 
            'quantity' => $quantity,
            'price' => $price,
            'image_url' => $variant->product->image_url,
        ];

        $cart = session()->get('cart', []);
        if (isset($cart[$productId][$modelId][$colorId])) {
            $cart[$productId][$modelId][$colorId]['quantity'] += $quantity;
        } else {
            $cart[$productId][$modelId][$colorId] = $cartItem;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    public function updateQuantity(Request $request)
    {
        $productId = $request->input('productId');
        $modelId = $request->input('modelId');
        $colorId = $request->input('colorId');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        // Cập nhật hoặc xóa sản phẩm trong giỏ hàng
        if (isset($cart[$productId][$modelId][$colorId])) {
            if ($quantity > 0) {
                $cart[$productId][$modelId][$colorId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId][$modelId][$colorId]);
                if (empty($cart[$productId][$modelId])) {
                    unset($cart[$productId][$modelId]);
                }
                if (empty($cart[$productId])) {
                    unset($cart[$productId]);
                }
            }
        }
        
        
        session()->put('cart', $cart);

        // Tính tổng tiền và tổng số lượng
        $totalPrice = 0;
        $totalQuantity = 0;
        $itemTotal = 0;

        foreach ($cart as $pid => $product) {
            foreach ($product as $mid => $model) {
                foreach ($model as $cid => $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                    $totalQuantity += $color['quantity'];

                    // Tính giá trị của sản phẩm hiện tại
                    if ($pid == $productId && $mid == $modelId && $cid == $colorId) {
                        $itemTotal = $color['price'] * $color['quantity'];
                    }
                }
            }
        }

        // Tính giảm giá nếu có voucher
        $discount = 0;
        $totalAfterDiscount = $totalPrice; // Tổng tiền sau giảm giá
        if ($voucher = session()->get('voucher')) {
            if (!empty($voucher['discount'])) {
                $discount = $voucher['discount'];
            }

            if (!empty($voucher['code'])) {
                $voucherModel = Voucher::where('code', $voucher['code'])->first();
                if ($voucherModel) {
                    if ($voucherModel->discount_percentage) {
                        $discount = ($totalPrice * $voucherModel->discount_percentage) / 100;
                    } elseif ($voucherModel->discount_amount) {
                        $discount = $voucherModel->discount_amount;
                    }
                    $discount = min($discount, $totalPrice);
                    $totalAfterDiscount = $totalPrice - $discount;
                    session()->put('voucher', [
                        'code' => $voucherModel->code,
                        'discount' => $discount,
                        'totalAfterDiscount' => $totalAfterDiscount,
                    ]);
                }
            }
        }

        return response()->json([
            'itemTotal' => number_format($itemTotal, 0, ',', '.') . ' đ', // Giá trị tổng của sản phẩm
            'totalPrice' => number_format($totalPrice, 0, ',', '.') . ' đ',
            'totalQuantity' => $totalQuantity,
            'totalAfterDiscount' => number_format($totalAfterDiscount, 0, ',', '.') . ' đ',
            'discount' => number_format($discount, 0, ',', '.') . ' đ',
        ]);
    }
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string|exists:vouchers,code',
        ]);

        $voucherCode = $request->input('voucher_code');
        $voucher = Voucher::where('code', $voucherCode)->first();

        // Lấy giỏ hàng
        $cart = session()->get('cart', []);

        // Nếu giỏ hàng rỗng
        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Giỏ hàng của bạn đang trống, không thể áp dụng mã giảm giá.');
        }

        // Kiểm tra mã voucher
        if (!$voucher || now()->lt($voucher->start_date) || now()->gt($voucher->end_date) || $voucher->usage_limit <= 0) {
            return redirect()->route('cart.index')->withErrors('Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        // Tính tổng giá trị giỏ hàng
        $totalPrice = 0;
        foreach ($cart as $product) {
            foreach ($product as $model) {
                foreach ($model as $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                }
            }
        }

        // Kiểm tra giá trị tối thiểu để áp dụng voucher
        if ($totalPrice < $voucher->min_order_value) {
            return redirect()->route('cart.index')->withErrors('Giá trị đơn hàng chưa đạt mức tối thiểu để áp dụng mã giảm giá.');
        }

        // Tính toán giảm giá
        $discount = 0;
        if ($voucher->discount_percentage) {
            $discount = ($totalPrice * $voucher->discount_percentage) / 100;
        } elseif ($voucher->discount_amount) {
            $discount = $voucher->discount_amount;
        }

        $discount = min($discount, $totalPrice);
        $totalAfterDiscount = $totalPrice - $discount;

        // Lưu voucher vào session
        session()->put('voucher', [
            'code' => $voucherCode,
            'discount' => $discount,
            'totalAfterDiscount' => $totalAfterDiscount,
        ]);
        if ($request->input('remove_voucher')) {
            session()->forget('voucher');
            return redirect()->route('cart.index')->with('success', 'Mã giảm giá đã được xóa!');
        }
        
        // Giảm số lần sử dụng còn lại của voucher
        $voucher->decrement('usage_limit');

        return redirect()->route('cart.index')->with('success', 'Mã giảm giá đã được áp dụng!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $voucher = session()->get('voucher', []);

        $totalPrice = 0;
        $totalQuantity = 0;
        $discount = $voucher['discount'] ?? 0;
        $outOfStockItems = [];  
        $cart = [];

        // Kiểm tra khách hàng đã đăng nhập hay chưa
        if (auth('customer')->check()) {
            // Với khách hàng đã đăng nhập, lấy giỏ hàng từ bảng Cart (mảng các đối tượng)
            $customerId = auth('customer')->id();
            $cart = Cart::where('customer_id', $customerId)->get();
        } else {
            // Với khách hàng chưa đăng nhập, lấy giỏ hàng từ session (mảng)
            $cart = session()->get('cart', []);
        }

        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    // Tìm variant sản phẩm (sản phẩm, dung lượng, màu sắc)
                    $variant = ProductVariant::where('product_id', $productId)
                        ->where('capacity_id', $modelId)
                        ->where('color_id', $colorId)
                        ->with(['capacity', 'color'])
                        ->first();

                    // Kiểm tra nếu không tìm thấy variant sản phẩm
                    if (!$variant) {
                        $outOfStockItems[] = 'Sản phẩm không hợp lệ hoặc không tồn tại.';
                        continue;
                    }

                    // Kiểm tra nếu số lượng yêu cầu vượt quá số lượng tồn kho
                    if ($item['quantity'] > $variant->stock) {
                        // Thêm thông báo lỗi vào mảng lỗi
                        $outOfStockItems[] = 'Số lượng của sản phẩm "' . $variant->product->name . '" vượt quá số lượng tồn kho. Tồn kho hiện tại: ' . $variant->stock . ' sản phẩm.';
                    }

                    // Tính tổng giá trị vad tổng số lượng
                    $totalPrice += $item['price'] * $item['quantity'];
                    $totalQuantity += $item['quantity'];
                }
            }
        }
        $customer = auth('customer')->user();

        $addresses = $customer ? $customer->addresses : collect(); // Trả về nếu chưa đăng nhập
        $defaultAddress = $customer ? $addresses->firstWhere('is_default', 1) : null;

        $customer = auth('customer')->check() ? auth('customer')->user() : null;
        
        // baos lỗi khi vượt qua
        if (!empty($outOfStockItems)) {
            return back()->withErrors(['quantity' => $outOfStockItems]);
        }
        

        $totalAfterDiscount = $totalPrice - $discount;

        $estimatedTotal = $totalAfterDiscount;

        return view('client.page.checkout.index', compact(
            'cart', 'totalPrice', 'totalQuantity', 'discount', 'estimatedTotal','defaultAddress','addresses'
        ));
    } 