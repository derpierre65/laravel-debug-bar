<template>
	<div class="ldb-toolbar-item" :class="statusColor ? 'ldb-toolbar-status-' + statusColor : ''">
		<div class="ldb-toolbar-item-icon" v-if="$slots.icon || $scopedSlots.icon">
			<slot name="icon" />
		</div>
		<span class="ldb-toolbar-item-value" v-if="value">{{value}}</span>
		<span class="ldb-toolbar-item-label" v-if="label">{{label}}</span>

		<div class="ldb-toolbar-popover" style="left: 0;" v-if="$slots.default || $scopedSlots.default">
			<slot />
		</div>
	</div>
</template>

<script>
export default {
	name: 'DebugToolbarItem',
	props: {
		value: [String, Number],
		label: [String, Number],
		statusColor: String,
	},
	data() {
		return {
			mouseover: false,
		};
	},
};
</script>

<style scoped>
/* toolbar items */
.ldb-toolbar-item {
	position: relative;
	padding: 10px;
	cursor: pointer;
	display: inline-flex;
	align-items: center;
}

.ldb-toolbar-item-icon > svg,
.ldb-toolbar-item-icon > img {
	width: 16px;
	height: 16px;
}

.ldb-toolbar-item-value {
	margin-left: 10px;
	color: #F5F5F5;
}

.ldb-toolbar-item-label {
	margin-left: 4px;
	color: #AAA;
}

.ldb-toolbar-item:not(.no-hover):hover, .ldb-toolbar-item:not(.no-hover).active {
	background: #444;
}

/* popover */
.ldb-toolbar-popover {
	position: absolute;
	display: none;
	bottom: 42px;
	background-color: #444;
	bottom: 36px;
	color: #F5F5F5;
	padding: 9px 0;
	max-width: 520px;
	white-space: nowrap;
	padding: 10px;
	max-height: 400px;
	overflow-y: auto;
}

.ldb-toolbar-item:hover .ldb-toolbar-popover {
	display: blocK;
}

/* popover table */
.ldb-toolbar-table {
	overflow: auto;
}

.ldb-toolbar-table td {
	padding: 4px;
}

.ldb-toolbar-table th {
	background-color: #222;
	border-bottom: 0;
	color: #AAA;
	padding: 4px;
}

/* popover info piece */
.ldb-toolbar-info-piece {
	border-bottom: solid transparent 3px;
	display: table-row;
}

.ldb-toolbar-item a {
	color: #99CDD8 !important;
}

.ldb-toolbar-info-piece > b {
	padding: 3px 6px 3px 0;
}

.ldb-toolbar-info-piece > * {
	display: table-cell;
	padding: 2px 0;
}

/* status colors */
.ldb-toolbar-status {
	padding: 0 4px;
	background-color: #666;
	text-align: center;
	min-width: 16px;
	display: inline-block;
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