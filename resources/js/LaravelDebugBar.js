export let xhrs = [];

export function addXmlHttpRequest({ url, method, status, headers, time = 0 }) {
	xhrs.unshift({
		url,
		method,
		headers,
		status,
		time,
		memoryUsage: headers['x-debug-memory'] ? parseInt(headers['x-debug-memory']) : null,
		executionTime: headers['x-debug-execution-time'] ? parseFloat(headers['x-debug-execution-time']) : null,
		queries: headers['x-debug-queries'] ? JSON.parse(headers['x-debug-queries']) : null,
		queryLog: headers['x-debug-query-log'] ? JSON.parse(headers['x-debug-query-log']) : null,
	});
}