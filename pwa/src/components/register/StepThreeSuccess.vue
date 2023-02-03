<template>
  <div class="space-y-4 mb-8">
    <div class="text-center">
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>
        <h1 class="text-3xl text-slate-800 font-bold mb-8">Votre comptes a été bien créer</h1>
      <router-link class="btn bg-indigo-500 hover:bg-indigo-600 text-white" to="/login">Go to login -&gt;</router-link>
    </div>
  </div>
</template>

<script>
import successMessageView from '../../views/successMessageView.vue';

  export default {
  components: {
    successMessageView
  }
  }
</script>
