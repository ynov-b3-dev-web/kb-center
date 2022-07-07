@extends('template')
@section('contenu')
    <br>
    <div class="container">
        <div class="row card text-white bg-dark">
            <div class="card-body">
                <form action="{{ route('product.create+') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="name" name="name" id="name" placeholder="Le nom du produit" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                    <input type="price" name="price" id="price" placeholder="Le nom du produit" value="{{ old('price') }}">
                    </div>
                    <button type="submit" class="btn btn-secondary">Creer produit</button>
                </form>
            </div>
        </div>
    </div>
@endsection