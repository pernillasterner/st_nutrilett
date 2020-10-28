@extends('layouts.app')

@section('content')

<section class="section has-breadcrumbs is-small-bottom section-half-text">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-6">
        <h2 class="h2">Frakt og retur</h2>
        <div class="lead">Det er kjapt, enkelt og trygt å handle hos oss. Nutrilett.no leverer over hele fastlands-Norge, men ikke til Svalbard. Posten Norge leverer våre pakker og brev til kundene. Vi har normalt 3-5 virkedagers leveringstid.</div>
      </div>
    </div>
  </div>
</section>

@include('sections.section-address-sidebar-static')

@include('sections.section-newsletter-small-static')

@endsection