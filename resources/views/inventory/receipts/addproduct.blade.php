@extends('layouts.app', ['page' => 'Add Product', 'pageSlug' => 'receipt', 'section' => 'inventory'])

@section('content')
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Add Product</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('receipts.show', $receipt) }}" class="btn btn-sm btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('receipts.product.store', $receipt) }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
                                <input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-product">Product</label>
                                    <select name="product_id" id="input-product" class="form-select form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($products as $product)
                                            @if($product['id'] == old('product_id'))
                                                <option value="{{$product['id']}}" selected>[{{ $product->category->name }}] {{ $product->name }}</option>
                                            @else
                                                <option value="{{$product['id']}}">{{ $product->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>

                                <div class="form-group{{ $errors->has('store') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-store">Store</label>
                                    <input type="number" name="store" id="input-store" class="form-control form-control-alternative{{ $errors->has('store') ? ' is-invalid' : '' }}" value="0" required>
                                    @include('alerts.feedback', ['field' => 'store'])
                                </div>

                                <div class="form-group{{ $errors->has('store_defective') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-store_defective">Defective Store</label>
                                    <input type="number" name="store_defective" id="input-store_defective" class="form-control form-control-alternative{{ $errors->has('store_defective') ? ' is-invalid' : '' }}" value="0" required>
                                    @include('alerts.feedback', ['field' => 'store_defective'])
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('js')
    <script>
        new SlimSelect({
            select: '.form-select'
        });
    </script>
@endpush
