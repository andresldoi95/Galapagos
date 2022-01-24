<template>
  <div>
    <div class="section">
      <div class="columns">
        <div class="column">
          <ul>
            <li>
              <b-icon icon="minus-box" size="is-large" type="is-primary">
              </b-icon>
              <strong>{{ $t("message.calidad_tecnica") }}</strong>
            </li>
            <li>
              <b-icon icon="dog" size="is-large" type="is-primary"> </b-icon>
              <strong>{{ $t("message.brigada_canina") }}</strong>
            </li>
            <li>
              <b-icon icon="airplane" size="is-large" type="is-primary">
              </b-icon>
              <strong>{{ $t("message.inspeccion_cuarentena") }}</strong>
            </li>
            <li>
              <b-icon icon="submarine" size="is-large" type="is-primary">
              </b-icon>
              <strong>{{ $t("message.unidad_marina") }}</strong>
            </li>
            <li>
              <b-icon icon="flower" size="is-large" type="is-primary"> </b-icon>
              <strong>{{ $t("message.vigilancia_fitosanitaria") }}</strong>
            </li>
            <li>
              <b-icon icon="cow" size="is-large" type="is-primary"> </b-icon>
              <strong>{{ $t("message.vigilancia_zoosanitaria") }}</strong>
            </li>
          </ul>
        </div>
        <div class="column">
          <b-carousel :indicator-inside="false">
            <b-carousel-item>
              <b-image
                ratio="16by9"
                class="image"
                src="/img/galapagos-2.jpg"
              ></b-image>
            </b-carousel-item>
            <b-carousel-item>
              <b-image
                ratio="16by9"
                class="image"
                src="/img/galapagos.jpg"
              ></b-image>
            </b-carousel-item>
          </b-carousel>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="columns">
        <div class="column">
          <figure class="image">
            <img class="is-rounded" src="/img/mision-y-vision.jpg" />
          </figure>
        </div>
        <div class="column">
          <section class="hero is-small is-primary">
            <div class="hero-body">
              <p class="title">{{ $t("title.mision") }}</p>
              <p class="subtitle">{{ $t("message.mision") }}</p>
            </div>
          </section>
          <section class="mt-2 hero is-small is-info">
            <div class="hero-body">
              <p class="title">{{ $t("title.vision") }}</p>
              <p class="subtitle">{{ $t("message.vision") }}</p>
            </div>
          </section>
        </div>
      </div>
    </div>
    <section class="mt-2 hero">
      <div class="hero-body">
        <p class="title">{{ $t("title.organigrama") }}</p>
      </div>
      <div class="container">
        <div class="columns">
          <div class="column">
            <b-image
              src="/img/organigrama.jpg"
              placeholder="Organigrama"
              ratio="is-square"
            ></b-image>
          </div>
        </div>
      </div>
    </section>
    <section class="mt-2 hero">
      <div class="hero-body">
        <p class="title">{{ $t("title.objetivos") }}</p>
      </div>
      <div class="container">
        <div class="columns">
          <div class="column">
            <figure class="image">
              <img src="/img/planificacion-institucional.jpg" />
            </figure>
          </div>
          <div class="column">
            <ol>
              <li>
                {{ $t("message.objetivo1") }}
              </li>
              <li>
                {{ $t("message.objetivo2") }}
              </li>
              <li>
                {{ $t("message.objetivo3") }}
              </li>
              <li>
                {{ $t("message.objetivo4") }}
              </li>
            </ol>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {};
</script>
