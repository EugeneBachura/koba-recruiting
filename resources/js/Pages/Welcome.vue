<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<template>
  <Head title="Welcome" />

  <div
    class="
      relative
      flex
      items-top
      justify-center
      min-h-screen
      bg-gray-100
      dark:bg-gray-900
      sm:items-center sm:pt-0
    "
  >
    <div v-if="canLogin" class="btn-link-container">
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="text-xl text-gray-700 dark:text-gray-500 underline button-6"
        >Dashboard</Link
      >

      <template v-else>
        <Link
          :href="route('login')"
          class="text-xl text-gray-700 dark:text-gray-500 underline button-6"
          >Log in</Link
        >

        <Link
          v-if="canRegister"
          :href="route('register')"
          class="
            ml-4
            text-xl text-gray-700
            dark:text-gray-500
            underline
            button-6
          "
          >Register</Link
        >
      </template>
    </div>
  </div>
</template>

<style>
.btn-link-container {
  width: 100vw;
  display: flex;
  align-items: center;
  justify-content: center;
}

.button-6 {
  align-items: center;
  background-color: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 0.25rem;
  box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
  box-sizing: border-box;
  color: rgba(0, 0, 0, 0.85);
  cursor: pointer;
  display: inline-flex;
  font-family: system-ui, -apple-system, system-ui, "Helvetica Neue", Helvetica,
    Arial, sans-serif;
  font-size: 16px;
  font-weight: 600;
  justify-content: center;
  line-height: 1.25;
  margin: 0;
  margin-right: 15px;
  margin-left: 15px;
  min-height: 3rem;
  padding: calc(0.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: auto;
}

.button-6:hover,
.button-6:focus {
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
  color: rgba(0, 0, 0, 0.65);
}

.button-6:hover {
  transform: translateY(-1px);
}

.button-6:active {
  background-color: #f0f0f1;
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
  color: rgba(0, 0, 0, 0.65);
  transform: translateY(0);
}
iframe {
  width: 100vw;
  height: 100vh;
  position: absolute;
  top: 0;
  left: 0;
  border-radius: 0 !important;
}
</style>