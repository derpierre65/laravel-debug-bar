# Laravel Debug Bar

Laravel Debug Bar for Laravel, with a Vue component.


## Installation

```
composer require derpierre65/laravel-debug-bar
```

## Configuration

soon

## Usage

Add the Service Provider `LaravelDebugBarServiceProvider`.
Import the Vue Component DebugBar.vue to your project like:

```vue
<template>
  <div>
    your content...
    
    <debug-bar />
  </div>
</template>

<script>
import DebugBar from '../../vendor/derpierre65/laravel-debug-bar/resources/js/DebugBar.vue';

export default {
  components: {DebugBar},
}
</script>
```

### Extend the Debug Bar

```vue
<template>
  <div>
    your content...
    
    <debug-bar>
      <!-- value only item -->
      <debug-toolbar-action :value="123" />

      <!-- value and label only item -->
      <debug-toolbar-action :value="123" label="Requests" />

      <!-- add an icon to your item -->
      <debug-toolbar-action :value="123" label="Requests">
        <template #icon>
          my icon svg/img tag
        </template>
      </debug-toolbar-action>

      <!-- add a custom popover to your item-->
      <debug-toolbar-action :value="123" label="Requests">
        <template #icon>
          my icon svg/img tag
        </template>

        <div class="ldb-toolbar-info-piece">
          <b>Nice Popover</b>
          <span>12345</span>
        </div>
      </debug-toolbar-action>
    </debug-bar>
  </div>
</template>

<script>
import DebugBar from '../../vendor/derpierre65/laravel-debug-bar/resources/js/DebugBar.vue';
import DebugToolbarAction from '../../vendor/derpierre65/laravel-debug-bar/resources/js/DebugToolbarAction.vue';

export default {
  components: {DebugBar, DebugToolbarAction},
}
</script>
```