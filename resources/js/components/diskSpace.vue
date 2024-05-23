<template>
  <div class="card">
    <div class="card-header">Occupied Disk Space</div>
    <div class="card-body">
      <div class="progress progress-micro mb-10">
        <div
          class="progress-bar progress-bar-striped progress-bar-animated bg-indigo-400"
          v-bind:style="{width: diskUseWithPercentage}"
        >
          <span class="sr-only">{{ diskUseWithPercentage }}</span>
        </div>
      </div>
      <span class="pull-right"
        >{{ diskUsedSize }} GB / {{ diskTotalSize }} GB ({{ diskUseWithPercentage }})</span
      >
    </div>
  </div>
</template>

<script>
export default {
  props: ["diskUse", "diskUsedSize", "diskTotalSize"],
  
  data: function () {
    return {
      
    }
  },

    computed: {
        diskUseWithPercentage: function(){
            return this.diskUse + "%";
        }
    }

};
</script>

<style>
</style>