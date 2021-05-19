<template>
  <div class="ldb-toolbar-action">
    <div class="ldb-toolbar-action-icon">
      <slot name="icon"/>
    </div>
    <span class="ldb-toolbar-action-value" v-if="value">{{ value }}</span>
    <span class="ldb-toolbar-action-label" v-if="label">{{ label }}</span>

    <div class="ldb-toolbar-info" style="left: 0px;" v-if="$slots.default || $scopedSlots.default">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DebugToolbarAction',
  props: {
    value: [String, Number],
    label: [String, Number],
  },
  data() {
    return {
      mouseover: false,
    };
  },
};
</script>

<style scoped>
.ldb-toolbar-action {
  position: relative;
  padding: 10px;
  cursor: pointer;
  display: inline-flex;
}

.ldb-toolbar-action-value {
  margin-left: 10px;
  color: #F5F5F5;
}

.ldb-toolbar-action-label {
  margin-left: 4px;
  color: #AAA;
}

.ldb-toolbar-action:not(.no-hover):hover, .ldb-toolbar-action:not(.no-hover).active {
  background: #444;
}

.ldb-toolbar-info {
  position: absolute;
  display: none;
  bottom: 42px;
  background-color: #444;
  bottom: 36px;
  color: #F5F5F5;
  padding: 9px 0;
  max-width: 480px;
  white-space: nowrap;
  padding: 10px;
}

.ldb-toolbar-action:hover .ldb-toolbar-info {
  display: blocK;
}

.ldb-toolbar-info-piece {
  border-bottom: solid transparent 3px;
  display: table-row;
}

.ldb-toolbar-info-piece > b {
  padding-right: 6px;
}

.ldb-toolbar-info-piece > * {
  display: table-cell;
  padding: 2px 0 2px 0;
}

.ldb-toolbar-status-green {
  background-color: #4F805D;
}

.ldb-toolbar-status-yellow {
  background-color: #A46A1F;
}

.ldb-toolbar-status-red {
  background-color: #B0413E;
}

</style>