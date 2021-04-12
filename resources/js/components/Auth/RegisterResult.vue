<template>
  <a-result
    status="success"
    title="Successfully registered!"
    sub-title="We need to know if you're not a robot, please confirm you email."
  >
    <template #extra>
      <router-link to="/register" class="nav-item nav-link">
        <a-button key="console" type="primary">
          Go Back
        </a-button>
      </router-link>
      <router-link to="/login" class="nav-item nav-link">
        <a-button key="buy">
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
