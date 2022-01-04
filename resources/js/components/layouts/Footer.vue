<template>
  <footer class="footer">
    <section>
      <b-image src="/img/footer.png" alt="Footer" responsive></b-image>
    </section>
    <div class="content has-text-centered">
      <p>
        <strong>{{ appName }}</strong
        >,
        <a :href="linkAuthor">{{ appAuthor }}</a>
        , &copy; {{ new Date().getFullYear() }}.
        {{ $t("message.derechosReservados") }}.
      </p>
    </div>
  </footer>
</template>

<script>
export default {
  data: function () {
    return {
      appName: process.env.MIX_APP_NAME,
      appAuthor: process.env.MIX_APP_AUTHOR,
      linkAuthor: process.env.MIX_LINK_AUTHOR,
    };
  },
};
</script>
