@extends('layouts.layout')

@section('scripts')
{{ HTML::style('libs/slider/rangeslider.css'); }}
{{ HTML::script('libs/slider/rangeslider.umd.min.js'); }}
{{ HTML::script('js/home.js'); }}
@endsection

<?php
  use App\Http\Controllers\ProductsApiController;
  $API_CONTROLLER = new ProductsApiController();
?>
@section('body')
  <h2>
    Simple Catalog Page
  </h2>
  <div class="row mt-3">
    <div class="col-lg-3">
      <div class="form-group">
        <label for="gender-filter">Gender</label>
        <select class="form-select" id="gender-filter">
          <option value="a">All</option>
          <option value="w">Women</option>
          <option value="m">Men</option>
        </select>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="form-group">
        <label for="price-filter">Price</label>
        <select class="form-select" id="price-filter">
          <option value="mp" selected>Most Popular</option>
          <option value="lth">Low To High</option>
          <option value="htl">High To Low</option>
        </select>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="form-group">
        <label for="subcatg-filter">Subcategory</label>
        <select class="form-select" id="subcatg-filter">
          <?php
            $subcategories = $API_CONTROLLER->getSubcategories();
            echo "<option value=\"all\" selected>All</option>";
            foreach ($subcategories as $catg) {
              echo "<option>$catg</option>";
            }
          ?>
        </select>
      </div> 
    </div>
    <div class="col-lg-3">
      <div class="form-group">
        <label for="price-range-slider" id="price-range-slider-label">Price Range ($1000 - $10000)</label>
        <div id="price-range-slider" class="mt-4">
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-2" id="products">
  </div>
@endsection