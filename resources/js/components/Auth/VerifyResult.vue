<template>
  <a-result status="404" title="404" sub-title="Sorry, the page you visited does not exist or it's Expired.">
    <template #extra>
      <router-link to="/login" class="nav-item nav-link" >
        <a-button key="buy" type="primary" icon="login">
          login
        </a-button>
      </router-link>
    </template>
  </a-result>
</template>
<script>
export default {
  data() {
    return {};
  },
};
</script>
