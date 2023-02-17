@extends('layouts.layout')

@section('body')
  <h2>
    {{ $data['prod_name'] }}
  </h2>

  <div class="row mt-5">
    <div class="col-lg-6">
        <img src="https://source.unsplash.com/user/sabrinnaringquist/1000x1000/?jewelry" class="img-fluid rounded" alt="">
    </div>
    <div class="col-lg-6">
        <h3>
            USD ${{ $data['price'] }}
        </h3>
        <p>
           {{ $data['prod_long_desc'] }}
        </p>
        <p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    Type: {{ $data['prod_type'] }}
                </li>
                <li class="list-group-item">
                    For: {{ $data['prodmeta_section'] }}
                </li>
                <li class="list-group-item">
                    Metal Weight: 
                    @if(!empty($data['prodmeta_metal_weight']))
                        {{ $data['prodmeta_metal_weight'] }}
                    @else     
                        Not Available
                    @endif
                </li>
            </ul>
        </p>
    </div>
  </div>
@endsection