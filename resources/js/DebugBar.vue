<template>
	<div id="laravel-debug-bar" :class="{minimized}">
		<div class="ldb-request-info" v-if="!minimized">
			<debug-toolbar-item v-if="executionTime" :value="executionTime" label="ms" />
			<debug-toolbar-item v-if="memoryUsage" :value="memoryUsage" :label="memoryUsageLabel" />
			<debug-toolbar-item v-if="queries" :value="queries.all + ' in ' + queryDuration + 'ms'" :status-color="queryColor">
				<template #icon>
					<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="database"
						class="svg-inline--fa fa-database fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 448 512">
						<path fill="currentColor"
							d="M448 73.143v45.714C448 159.143 347.667 192 224 192S0 159.143 0 118.857V73.143C0 32.857 100.333 0 224 0s224 32.857 224 73.143zM448 176v102.857C448 319.143 347.667 352 224 352S0 319.143 0 278.857V176c48.125 33.143 136.208 48.572 224 48.572S399.874 209.143 448 176zm0 160v102.857C448 479.143 347.667 512 224 512S0 479.143 0 438.857V336c48.125 33.143 136.208 48.572 224 48.572S399.874 369.143 448 336z"></path>
					</svg>
				</template>

				<div class="ldb-toolbar-info-piece">
					<b>Query Time</b>
					<span>{{queryDuration}} ms</span>
				</div>
				<div class="ldb-toolbar-info-piece">
					<b>Database Queries</b>
					<span class="ldb-toolbar-status" :class="'ldb-toolbar-status-' + queryColor">{{queries.all}}</span>
				</div>
				<div class="ldb-toolbar-info-piece" v-if="queries.insert">
					<b>Insert</b>
					<span class="ldb-toolbar-status">{{queries.insert}}</span>
				</div>
				<div class="ldb-toolbar-info-piece" v-if="queries.select">
					<b>Select</b>
					<span class="ldb-toolbar-status">{{queries.select}}</span>
				</div>
				<div class="ldb-toolbar-info-piece" v-if="queries.update">
					<b>Update</b>
					<span class="ldb-toolbar-status">{{queries.update}}</span>
				</div>
				<div class="ldb-toolbar-info-piece" v-if="queries.delete">
					<b>Delete</b>
					<span class="ldb-toolbar-status">{{queries.delete}}</span>
				</div>
			</debug-toolbar-item>

			<debug-toolbar-item v-if="xhrs.length" :value="xhrs.length">
				<template #icon>
					<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="retweet" class="svg-inline--fa fa-retweet fa-w-20" role="img"
						xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
						<path fill="currentColor"
							d="M629.657 343.598L528.971 444.284c-9.373 9.372-24.568 9.372-33.941 0L394.343 343.598c-9.373-9.373-9.373-24.569 0-33.941l10.823-10.823c9.562-9.562 25.133-9.34 34.419.492L480 342.118V160H292.451a24.005 24.005 0 0 1-16.971-7.029l-16-16C244.361 121.851 255.069 96 276.451 96H520c13.255 0 24 10.745 24 24v222.118l40.416-42.792c9.285-9.831 24.856-10.054 34.419-.492l10.823 10.823c9.372 9.372 9.372 24.569-.001 33.941zm-265.138 15.431A23.999 23.999 0 0 0 347.548 352H160V169.881l40.416 42.792c9.286 9.831 24.856 10.054 34.419.491l10.822-10.822c9.373-9.373 9.373-24.569 0-33.941L144.971 67.716c-9.373-9.373-24.569-9.373-33.941 0L10.343 168.402c-9.373 9.373-9.373 24.569 0 33.941l10.822 10.822c9.562 9.562 25.133 9.34 34.419-.491L96 169.881V392c0 13.255 10.745 24 24 24h243.549c21.382 0 32.09-25.851 16.971-40.971l-16.001-16z"></path>
					</svg>
				</template>

				<span class="ldb-toolbar-header">
					<b class="ldb-toolbar-header-info">{{xhrs.length}} AJAX request</b>
					<b class="ldb-toolbar-header-action">(<a @click="clearXHR">Clear</a>)</b>
				</span>

				<div class="ldb-toolbar-table">
					<table>
						<thead>
						<tr>
							<th>#</th>
							<th>Method</th>
							<th>Status</th>
							<th>URL</th>
							<th>Time</th>
						</tr>
						</thead>
						<tbody class="ldb-toolbar-table-body">
						<tr v-for="(xhr, key) in xhrs">
							<td>{{key + 1}}</td>
							<td>{{xhr.method}}</td>
							<td>
								<span class="ldb-toolbar-status" :class="'ldb-toolbar-status-' + getXHRColor(xhr.status)">{{xhr.status}}</span>
							</td>
							<td class="ldb-toolbar-xhr-url" :title="xhr.url"><a :href="xhr.url">{{xhr.url}}</a></td>
							<td>{{xhr.time}}ms</td>
						</tr>
						</tbody>
					</table>
				</div>

			</debug-toolbar-item>

			<slot />
		</div>
		<div class="ldb-system-info">
			<debug-toolbar-item v-if="minimized" @click.native="minimized = !minimized" class="no-hover">
				<template #icon>
					<debug-icon />
				</template>
			</debug-toolbar-item>
			<template v-else>
				<debug-toolbar-item value="1.0.0">
					<template #icon>
						<debug-icon />
					</template>
				</debug-toolbar-item>
				<debug-toolbar-item @click.native="minimized = !minimized" class="active">
					<template #icon>
						<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="ldb-icon" role="img"
							xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
							<path fill="currentColor"
								d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
						</svg>
					</template>
				</debug-toolbar-item>
			</template>
		</div>
	</div>
</template>

<script>
import DebugIcon from './DebugIcon';
import DebugToolbarItem from './DebugToolbarItem';
import {xhrs} from './LaravelDebugBar';

export default {
	name: 'DebugBar',
	components: { DebugIcon, DebugToolbarItem },
	props: {
		queryColorFunction: Function,
	},
	data() {
		return {
			minimized: false,

			xhrs,
			memoryUsage: null,
			memoryUsageLabel: '',
			executionTime: null,
			queries: null,
			queryLog: [],
		};
	},
	created() {
		this.updateXHR();
	},
	watch: {
		xhrs() {
			this.updateXHR();
		},
		memoryUsage(newValue) {
			if (typeof newValue === 'string') {
				return;
			}

			let symbol = 'Byte';
			if (newValue >= 1000) {
				newValue /= 1000;
				symbol = 'kB';
			}
			if (newValue >= 1000) {
				newValue /= 1000;
				symbol = 'MB';
			}
			if (newValue >= 1000) {
				newValue /= 1000;
				symbol = 'GB';
			}
			if (newValue >= 1000) {
				newValue /= 1000;
				symbol = 'TB';
			}

			this.memoryUsage = newValue.toFixed(2);
			this.memoryUsageLabel = symbol;
		},
	},
	computed: {
		queryDuration() {
			let time = 0;
			for (let query of this.queryLog) {
				time += query.time;
			}

			return time.toFixed(2);
		},
		queryColor() {
			if (this.queries.all <= 50) {
				return 'green';
			}
			else if (this.queries.all <= 100) {
				return 'yellow';
			}

			return 'red';
		},
	},
	methods: {
		getXHRColor(status) {
			let statusCode = status.toString().substr(0, 1); // get first number of status code (200 = 2)
			if (statusCode === '2') {
				return 'green';
			}

			return 'red';
		},
		clearXHR() {
			this.xhrs.splice(0, this.xhrs.length);
		},
		updateXHR() {
			if (this.xhrs.length === 0) {
				return;
			}

			let lastXHR = this.xhrs[0];
			for (let key of ['memoryUsage', 'executionTime', 'queries', 'queryLog']) {
				if (lastXHR[key]) {
					this[key] = lastXHR[key];
				}
			}
		},
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

.ldb-toolbar-xhr-url {
	max-width: 200px;
	overflow: hidden;
	text-overflow: ellipsis;
}
</style>