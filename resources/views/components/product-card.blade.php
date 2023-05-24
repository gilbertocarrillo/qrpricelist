@props(['product'])

<div {{$attributes->merge(['class' => 'card mb-3 p-0'])}} >
    <div class="row g-0">
        <div class="col-md-5 d-none d-md-block">
            <div class="" style="height: 15rem;">
                <img src="{{ Storage::url($product->photo) }}" width="100%" height="100%" class=" rounded-start">
            </div>
        </div>
        <div class="col-md-7">
            <div class="card-body d-flex flex-column justify-content-between h-100">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->description }}</p>
                <p class="card-text text-primary">{{ $product->category->pricelist->currency }} {{ $product->price }}</p>
            </div>
        </div>
    </div>
</div>
