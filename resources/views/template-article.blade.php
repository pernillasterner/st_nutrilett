{{--
  Template Name: Single Article Page Template
--}}

@extends('layouts.app')

@section('content')

<section class="section has-breadcrumbs has-image section-article-page">
  <div class="container article-hero">
    <div class="article-image">
      {{-- article image / banner --}}
      <figure>
        <img src="@asset('images/temp/hero_image_2.jpg')" alt="">
      </figure>
    </div>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        {{-- section title --}}
        <h1 class="h1">
          Veganer og vegetarianer — hva er forskjellen?
        </h1>
        {{-- lead text  --}}
        <div class="lead">
          Det er stadig flere som bytter over til et vegetarisk kosthold,
          men vet du hva alle de forskjellige benevnelsene betyr og hva som er forskjell på
          vegetarianere og veganere? Her kan du lese mer om de ulike typene innen vegetarisme,
          og hva man kan spise – samt tips til gode og inspirerende oppskrifter.
        </div>
        {{-- editor output  --}}
        <div class="editor-output">
          <h2>
            Hva er egentlig forskjell?
          </h2>
          <p>
            Vegetarisme er et kosthold som ekskluderer kjøtt og fisk,
            og i noen tilfeller andre animalske matvarer.
            Det finnes flere typer kosthold under paraplyen vegetarisme,
            hvor forskjellige animalske varer er inkludert eller ekskludert.
          </p>
          <h4>
            Vegansks livsstil
          </h4>
          <p>
            Veganere sitt kosthold eksluderer alle animalske produkter, som kjøtt, fisk, skalldyr, egg, melk og honning,
            i tillegg kan veganisme sees på som en etisk livsstil hvor man utelater animalske produkter
            fra livet sitt så godt det lar seg gjøre. Det finnes flere grunner til at man velger å bli veganer,
            slik som for eksempel miljø, helse, religion, etikk, moral og økonomiske grunner – og alle disse
            begrunnelsene
            gjelder for alle de ulike typene du kan lese mer om nedenfor
          </p>
          <h4>
            Lakto-vegetarianer
          </h4>
          <p>
            Så har vi lakto-vegetarianere som spiser melkeprodukter, men ikke egg, fisk eller kjøtt.
          </p>
          <h4>
            Ovo-vegetarianer
          </h4>
          <p>
            Ovo-vegetarianere spiser egg, men ikke fisk eller kjøtt.
          </p>
          <h4>
            Lakto-ovo-vegetarianer
          </h4>
          <p>
            Lakto-ovo-vegetarianere spiser både egg og melkeprodukter,
            men ikke fisk eller kjøtt. Dette er kanskje den mest utbredte
            typen av vegetarianisme.
          </p>
          <h4>
            Andre lignende typer kosthold som ikke går under vegetarisme
          </h4>
          <p>
            Det finnes også andre typer kosthold som kan minne om, eller ofte blandes med, vegetarisme.
            Her har vi for eksempel fleksitarianere som spiser vegetarisk noen dager i uken,
            eller pescetarianere som spiser fisk, men ikke kjøtt, egg eller melkeprodukter, fruktianisme,
            hvor man ønsker å unngå å skade planter. Innen fruktianisme spiser man derfor kun frukter, bær, nøtter og
            frø.
          </p>
          <p>
            Videre har vi også tilhengere av levende mat prinsipper, som går ut på at man ikke skal varmebehandle maten
            man spiser.
            De ønsker å spise vegetabiler som er nærmest mulig sin naturlige tilstand, nemlig rå. Olivenolje er i deres
            øyne separert
            fra sin naturlige tilstand, så det holder man seg unna.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- section for the product slider --}}
<section class="section section-article-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        {{-- editor output  --}}
        <div class="editor-output">
          <h2>
            Slik unngår man mangel på vitaminer og mineraler
          </h2>
          <p>
            Det finnes flere gunstige helseeffekter ved å bli
            vegetarianer eller veganer, som for eksempel lavere kolesterol,
            lavere blodtrykk, redusert risiko for diabetes, samt hjerte- og karsykdommer.
            Samtidig må man passe på at man får i seg alt man trenger av proteiner, sunt fett,
            vitaminer og mineraler, det er ikke alltid like lett.
          </p>
          <p>
            Når man spiser etter et vegansk
            eller vegetarisk kosthold er det utrolig viktig at man passer på at man får i seg alle
            de næringsstoffene som kroppen trenger. Ikke bare gjennom kostholdet, men at man prøver
            seg frem og finner ut hva man også trenger tilskudd av. Tilskudd kan man ta i form av matvarer
            med tilskudd eller kosttilskudd tabletter.
          </p>
          <p>Det er spesielt behovet for B12, jod, vitamin D, omega-3
            og kalsium som kan være vanselig å mette, så her er det spesielt viktig at man finner ut, gjerne sammen
            med en lege, hvordan man skal få i seg det kroppen trenger hver dag. For å dekke behovet for B12 kan
            man spise rikelig med mandler, nøtter, frø, linser, bønner og grove kornprodukter. Ønsker du å få i
            deg B6 kan du spise avokado, paprika, grønnkål, spinat og asparges.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-article-page">
  <div class="container article-hero">
    <div class="article-image">
      {{-- article image / banner --}}
      <figure>
        <img src="@asset('images/temp/hero_image_3.jpg')" alt="">
      </figure>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        {{-- section title --}}
        <h1 class="h1">
          Vegansk snickerskake
        </h1>
        {{-- lead text  --}}
        <div class="lead">
          Hvis du liker snickers vil denne oppskriften på vegansk snickerskake treffe midt i
          blinken! Den er vegansk og en enkel «no bake» kake som tar ca 1 time å lage,
          30 minutter forberedelser og 35 minutter i fryseren, og vipps er den klar til servering
        </div>

        {{-- add is-first to this first info list element only in order to add the margin bottom differently --}}
        <div class="info-list is-first">
          <div class="info-bar">
            <div class="info-bar-item">
              {{ $site_translate->recipe['yield'] }}: 12
            </div>
            <div class="info-bar-item">
              Tilberedelsestid: 35 min
            </div>
            <div class="info-bar-item">
              Kalorier: 280
            </div>
          </div>
        </div>

        {{-- editor-output  --}}
        <div class="editor-output">
          <h3>
            Ingredienser
          </h3>
          {{-- product ingredients  --}}
          {{-- the info-list class is main container for the 3 different markups, ul, ol, tabulation --}}
          {{-- the info-list can be use outside the editor-ouput class but limited only to section article --}}
          {{-- for product ingredients, kindly use the markup below --}}
          <div class="info-list">
            <ul>
              <li>36 stk dadler</li>
              <li>6 ss peanøttsmør</li>
              <li>3 ss vegansk vaniljeproteinpulver</li>
              <li>4,5 g salt</li>
              <li>6 ss vann</li>
              <li>3 dl havregryn</li>
              <li>1,5 dl peanøtter</li>
              <li>150 g</li>
              <li>70 % Lindt sjokolade</li>
            </ul>
          </div>

          <h3>
            Fremgangsmåte
          </h3>
          {{-- product list ordered list  --}}
          {{-- for ordered list or recipe instructions, use the markup below --}}
          <div class="info-list">
            <ol>
              <li>Bland dadler, peanøttsmør, proteinpulver, salt og vann i en kjøkkenmaskin til en glatt «karamell».
                Sett til side. Kjør havregryn i en kjøkkenmaskin til dethar lbitt fint mel.
                Tilsett halvparten av karamellen i havremelet og kjør videre til det har blandet seg.
                Trykk utover i en brødform med bakepapir og sett 5 minutter i fryseren.
              </li>
              <li>Smelt sjokoladen. Ta ut bunnen av fryseren, bre karamellen utover,
                topp med peanøtter og bre til slutt den smeltede sjokoladen utover.
                Sett 30 minutter i fryseren.
              </li>
              <li>
                Ta ut, del opp og server.
              </li>
            </ol>
          </div>

          <h3>
            Næringsinnhold
          </h3>
          {{-- product nutrients list  --}}
          {{-- for nutrients content, follow the markup below  --}}
          <div class="info-list">
            <div class="tabulation"> {{-- container --}}
              <div class="tabulation-row"> {{-- row --}}
                <div class="tabulation-header">Kalorier:</div> {{-- header --}}
                <div class="tabulation-info">280,1</div> {{-- info --}}
              </div>
              <div class="tabulation-row">
                <div class="tabulation-header">Fiber:</div>
                <div class="tabulation-info">9,5 g</div>
              </div>
              <div class="tabulation-row">
                <div class="tabulation-header">Proteiner:</div>
                <div class="tabulation-info">8,3 g</div>
              </div>
              <div class="tabulation-row">
                <div class="tabulation-header">Fett:</div>
                <div class="tabulation-info">15 g</div>
              </div>
              <div class="tabulation-row">
                <div class="tabulation-header">Karbohydrater:</div>
                <div class="tabulation-info">26 g</div>
              </div>
              <div class="tabulation-row">
                <div class="tabulation-header">Sukker:</div>
                <div class="tabulation-info">17,5 g</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

@include('partials.content-page')
@endsection
