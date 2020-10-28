{{--
  Template Name: Size Guide Template
--}}

@extends('layouts.app')

@section('content')

  <section class="section text-button has-pt">
    <div class="container">
        <h1 class="title h2">Storleksguide</h1>
        <div class="preamble">Så här mäter du:
          (det är dina egna mått du mäter som du sedan jämför i tabellen nedan
          och ser vilken storlek du ska ha )
        </div>
        <div class="size-guide d-md-flex">
          <div class="size-guide-image m-auto text-center">
            <img src="@asset('images/temp/size-guide.png')" />
          </div>
          <div class="size-guide-table">
            <div class="d-table">
              <div class="d-table-row row-head">
                  <div class="d-table-cell text-center text-uppercase head"></div>
                  <div class="d-table-cell text-center text-uppercase head">Bystvidd</div>
                  <div class="d-table-cell text-center text-uppercase head">Midjevidd</div>
                  <div class="d-table-cell text-center text-uppercase head">Stussvidd</div>
              </div>
              <div class="d-table-row">
                <div class="d-table-cell size text-right text-right">
                  XS
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
              </div>
              <div class="d-table-row spacer"></div>
              <div class="d-table-row">
                <div class="d-table-cell size text-right">
                  S
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
              </div>
              <div class="d-table-row spacer"></div>
              <div class="d-table-row">
                <div class="d-table-cell size text-right">
                  M
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
              </div>
              <div class="d-table-row spacer"></div>
              <div class="d-table-row">
                <div class="d-table-cell size text-right">
                  L
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
              </div>
              <div class="d-table-row spacer"></div>
              <div class="d-table-row">
                <div class="d-table-cell size text-right">
                  XL
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
              </div>
              <div class="d-table-row spacer"></div>
              <div class="d-table-row">
                <div class="d-table-cell size text-right">
                  XXL
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
              </div>
              <div class="d-table-row spacer"></div>
              <div class="d-table-row">
                <div class="d-table-cell size text-right">
                  XXXL
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
                <div class="d-table-cell text-center">
                  <div>78-82</div>
                  <div>62-66</div>
                  <div>96-90</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="content clearfix">
          <p>Dessa mått anger ungefärlig storleksguide, mät dig enligt våra mätanvisningar så får du "passa in" dina mått och hitta storlek som passar dig.</p>
          <p>När du mäter dina mått för att köpa en kjol så är STUSSVIDD-måttet det viktigaste. Midjan kommer
          kännas lite stor på vissa men "det är alltid lättare att ta in än att lägga ut"!</p>
        </div>
    </div>
  </section>

  @include('sections.section-text-and-image')
  @include('sections.section-popular-products')

@endsection
