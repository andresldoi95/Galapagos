<template>
  <footer class="footer">
    <div class="content has-text-centered">
      <p>
        <strong>{{ appName }}</strong>,
        <a :href="linkAuthor">{{ appAuthor }}</a>
        , &copy; {{ new Date().getFullYear() }}. {{ $t('message.derechosReservados') }}.
      </p>
    </div>
  </footer>
</template>

<script>
export default {
  data: function() {
    return {
      appName: process.env.MIX_APP_NAME,
      appAuthor: process.env.MIX_APP_AUTHOR,
      linkAuthor: process.env.MIX_LINK_AUTHOR
    };
  }
};
</script>
