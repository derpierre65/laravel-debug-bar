<template>
  <div id="laravel-debug-bar" :class="{minimized}">
    <div class="ldb-request-info" v-if="!minimized">
      <debug-toolbar-action :value="10" label="ms"/>
      <debug-toolbar-action :value="10" label="MB"/>
      <debug-toolbar-action :value="64">
        <template #icon>
          <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="database"
               class="svg-inline--fa fa-database fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg"
               viewBox="0 0 448 512">
            <path fill="currentColor"
                  d="M448 73.143v45.714C448 159.143 347.667 192 224 192S0 159.143 0 118.857V73.143C0 32.857 100.333 0 224 0s224 32.857 224 73.143zM448 176v102.857C448 319.143 347.667 352 224 352S0 319.143 0 278.857V176c48.125 33.143 136.208 48.572 224 48.572S399.874 209.143 448 176zm0 160v102.857C448 479.143 347.667 512 224 512S0 479.143 0 438.857V336c48.125 33.143 136.208 48.572 224 48.572S399.874 369.143 448 336z"></path>
          </svg>
        </template>

        <div class="ldb-toolbar-info-piece">
          <b>Database Queries</b>
          <span>0</span>
        </div>
        <div class="ldb-toolbar-info-piece">
          <b>Query Timee</b>
          <span>123ms</span>
        </div>
        <div class="ldb-toolbar-info-piece">
          <b>Insert</b>
          <span>123</span>
        </div>
        <div class="ldb-toolbar-info-piece">
          <b>Select</b>
          <span>123</span>
        </div>
        <div class="ldb-toolbar-info-piece">
          <b>Update</b>
          <span>123</span>
        </div>
        <div class="ldb-toolbar-info-piece">
          <b>Delete</b>
          <span>123</span>
        </div>
      </debug-toolbar-action>

      <slot/>
    </div>
    <div class="ldb-system-info">
      <debug-toolbar-action v-if="minimized" @click.native="minimized = !minimized" class="no-hover">
        <template #icon>
          <debug-icon/>
        </template>
      </debug-toolbar-action>
      <template v-else>
        <debug-toolbar-action value="1.0.0">
          <template #icon>
            <debug-icon/>
          </template>
        </debug-toolbar-action>
        <debug-toolbar-action @click.native="minimized = !minimized" class="active">
          <template #icon>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="ldb-icon" role="img"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
              <path fill="currentColor"
                    d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
            </svg>
          </template>
        </debug-toolbar-action>
      </template>
    </div>
  </div>
</template>

<script>
import DebugIcon from './DebugIcon';
import DebugToolbarAction from './DebugToolbarAction';

export default {
  name: 'DebugBar',
  components: {DebugIcon, DebugToolbarAction},
  data() {
    return {
      minimized: false,
    };
  },
};
</script>

<style scoped>
#laravel-debug-bar {
  position: fixed;
  display: flex;
  background-color: #222;
  bottom: 0;
  box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);
  color: #EEE;
  left: 0;
  margin: 0;
  right: 0;
  text-align: left;
  text-transform: none;
  z-index: 99999;
  direction: ltr;
}

#laravel-debug-bar.minimized {
  left: auto;
  right: 0;
}

.ldb-icon {
  width: 16px;
  height: 16px;
}

.ldb-request-info {
  display: flex;
  flex: 1 1 auto;
}

.ldb-system-info {
  display: flex;
  flex: 0 0 auto;
}
</style>