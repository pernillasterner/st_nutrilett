{{--
  Template Name: Bootstrap Icon Template
--}}

@extends('layouts.app')

@section('content')

<section class="section has-breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h2>ICON LISTS</h2>
        <h3 class="h5">Instructions:</h3>
        <p>look for _icon.scss on how to add color</p>
        <ul class="list-group icon-lists">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Biceps - <em>&#64;include('icons.biceps')</em></span>
            @include('icons.biceps')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Bowl - <em>&#64;include('icons.bowl')</em></span>
            @include('icons.bowl')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Box 3d - <em>&#64;include('icons.box-3d')</em></span>
            @include('icons.box-3d')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span> Check - <em>&#64;include('icons.check')</em></span>
            @include('icons.check')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Chocolate - <em>&#64;include('icons.chocolate')</em></span>
            @include('icons.chocolate')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Crisp Arrow Bottom - <em>&#64;include('icons.crisp-arrow-bottom')</em></span>
            @include('icons.crisp-arrow-bottom')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Cross - <em>&#64;include('icons.cross')</em></span>
            @include('icons.cross')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Download - <em>&#64;include('icons.download')</em></span>
            <div class="fill-stroke">
              @include('icons.download')
            </div>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Finger Snap - <em>&#64;include('icons.finger-snap')</em></span>
            @include('icons.finger-snap')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span> Gallery Layout - add parent div.icon-fill.no-stroke <em>&#64;include('icons.gallery-layout')</em></span>
            <div class="icon-fill no-stroke">
              @include('icons.gallery-layout')
            </div>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>I delete - <em>&#64;include('icons.i-delete')</em></span>
            <div class="icon-fill">
              @include('icons.i-delete')
            </div>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Measuring Cup - <em>&#64;include('icons.measuring-cup')</em></span>
            @include('icons.measuring-cup')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Nutrition - <em>&#64;include('icons.nutrition')</em></span>
            @include('icons.nutrition')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Recipe Book - <em>&#64;include('icons.recipe-book')</em></span>
            @include('icons.recipe-book')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Right Arrow - <em>&#64;include('icons.right-arrow')</em></span>
            @include('icons.right-arrow')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Salad - <em>&#64;include('icons.salad')</em></span>
            @include('icons.salad')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Shaker - <em>&#64;include('icons.shaker')</em></span>
            @include('icons.shaker')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Shopping Bag - <em>&#64;include('icons.shopping-bag')</em></span>
            @include('icons.shopping-bag')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Smoothie - <em>&#64;include('icons.smoothie')</em></span>
            @include('icons.smoothie')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Star - <em>&#64;include('icons.star')</em></span>
            @include('icons.star')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Star Fill - add parent div.icon-fill <em>&#64;include('icons.star')</em></span>
            <div class="icon-fill">
              @include('icons.star')
            </div>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Trash Can - <em>&#64;include('icons.trash-can')</em></span>
            @include('icons.trash-can')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Virtual Assistant - <em>&#64;include('icons.virtual-assistant')</em></span>
            @include('icons.virtual-assistant')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Wand - <em>&#64;include('icons.wand')</em></span>
            @include('icons.wand')
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Zoom - <em>&#64;include('icons.zoom')</em></span>
            @include('icons.zoom')
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection