import Chart from 'chart.js/auto';
import ApexCharts from 'apexcharts';
import 'apexcharts/dist/apexcharts.css';

const BRAND = '#F57224';
const Y_AXIS_COLOR = '#9CA3AF';
const GRID_COLOR = 'rgba(229, 231, 235, 0.5)';

let revenueChart = null;
let statusChart = null;
let catChart = null;
let growthChart = null;

// ── Real-data only. Empty DB states render flat zero series, never mock data. ──

function monthLabel(date) {
    return date.toLocaleDateString('en-US', { month: 'short' });
}

function dayLabel(date) {
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

function buildLabels(period) {
    const labels = [];
    const now = new Date();

    if (period === 'year') {
        for (let i = 11; i >= 0; i--) {
            labels.push(monthLabel(new Date(now.getFullYear(), now.getMonth() - i, 1)));
        }
    } else {
        const days = period === 'week' ? 7 : 30;
        for (let i = days - 1; i >= 0; i--) {
            const d = new Date(now);
            d.setDate(d.getDate() - i);
            labels.push(dayLabel(d));
        }
    }

    return labels;
}

function emptySeries(labels) {
    return {
        labels: labels || [],
        values: (labels || []).map(() => 0),
    };
}

function normalizeData(raw, period) {
    const revenueLabels = buildLabels(period);
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const statusLabels = ['Pending', 'Shipping', 'Completed', 'Cancelled'];

    const toSeries = (series, fallbackLabels) => {
        if (series && Array.isArray(series.labels) && Array.isArray(series.values)) {
            return {
                labels: series.labels,
                values: series.values.map((v) => Number(v || 0)),
            };
        }
        return emptySeries(fallbackLabels);
    };

    return {
        period,
        revenue: toSeries(raw && raw.revenue, revenueLabels),
        order_status: toSeries(raw && raw.order_status, statusLabels),
        categories: toSeries(raw && raw.categories, []),
        customer_growth: toSeries(raw && raw.customer_growth, monthLabels),
    };
}

async function loadData(period) {
    let raw = null;

    try {
        const response = await fetch(`/admin/dashboard-data?period=${encodeURIComponent(period)}`);
        const json = await response.json();

        if (json && json.success && json.data) {
            raw = json.data;
        }
    } catch (e) {
        // network/parse failure → empty-state data (flat zero series)
    }

    return {
        data: normalizeData(raw, period),
        kpis: (raw && raw.kpis) || {},
    };
}

// ── KPI stat cards (real values; 0 when DB is empty) ──

function fmtCurrency(value) {
    return '$' + Number(value || 0).toLocaleString('en-US', { maximumFractionDigits: 0 });
}

function applyKpis(kpis) {
    const setText = (id, text) => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = text;
        }
    };

    setText('kpiTotalRevenue', fmtCurrency(kpis.total_revenue));
    setText('kpiTotalProfit', fmtCurrency(kpis.total_profit));
    setText('kpiPendingOrders', Number(kpis.pending_orders || 0).toLocaleString('en-US'));
    setText('kpiConversionRate', Number(kpis.conversion_rate || 0).toFixed(2) + '%');

    [
        ['kpiRevenueTrend', kpis.revenue_trend],
        ['kpiProfitTrend', kpis.profit_trend],
        ['kpiPendingTrend', kpis.pending_trend],
        ['kpiConversionTrend', kpis.conversion_trend],
    ].forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (!el) {
            return;
        }
        const num = Number(value || 0);
        const dir = num > 0 ? 'up' : num < 0 ? 'down' : 'neutral';
        el.className = `stat-trend stat-trend-${dir}`;
        el.innerHTML = num === 0
            ? '<i class="bi bi-dash"></i> 0%'
            : `<i class="bi bi-arrow-${num > 0 ? 'up' : 'down'}-short"></i> ${num > 0 ? '+' : ''}${num}%`;
    });
}

// ── Charts ──

function renderRevenueChart(labels, values) {
    if (revenueChart) {
        revenueChart.destroy();
        revenueChart = null;
    }

    const el = document.getElementById('revenueChart');
    if (!el) {
        return;
    }

    const ctx = el.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(245, 114, 36, 0.35)');
    gradient.addColorStop(1, 'rgba(245, 114, 36, 0.02)');

    revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Revenue',
                    data: values,
                    borderColor: BRAND,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.45,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: BRAND,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { maxTicksLimit: 8, color: Y_AXIS_COLOR, font: { size: 11 } },
                },
                y: {
                    grid: { color: GRID_COLOR },
                    ticks: {
                        color: Y_AXIS_COLOR,
                        font: { size: 11 },
                        callback: (value) => `$${Math.round(value / 1000)}k`,
                    },
                },
            },
        },
    });
}

function renderOrderStatusChart(labels, values) {
    if (statusChart) {
        statusChart.destroy();
        statusChart = null;
    }

    const el = document.getElementById('orderStatusChart');
    if (!el) {
        return;
    }

    statusChart = new ApexCharts(el, {
        chart: { type: 'donut', height: 280 },
        labels,
        series: values,
        colors: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
        legend: { position: 'bottom', fontSize: '12px' },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Orders',
                            color: '#6B7280',
                            formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0),
                        },
                    },
                },
            },
        },
        responsive: [
            {
                breakpoint: 768,
                options: { legend: { position: 'bottom' }, chart: { height: 240 } },
            },
        ],
    });

    statusChart.render();
}

function renderCategoryChart(labels, values) {
    if (catChart) {
        catChart.destroy();
        catChart = null;
    }

    const el = document.getElementById('categoryChart');
    if (!el) {
        return;
    }

    catChart = new ApexCharts(el, {
        chart: { type: 'bar', height: 280 },
        series: [{ name: 'Sales', data: values }],
        plotOptions: { bar: { borderRadius: 6, horizontal: true } },
        colors: [BRAND],
        xaxis: { categories: labels },
        grid: { borderColor: GRID_COLOR },
        dataLabels: { enabled: false },
    });

    catChart.render();
}

function renderCustomerGrowthChart(labels, values) {
    if (growthChart) {
        growthChart.destroy();
        growthChart = null;
    }

    const el = document.getElementById('customerGrowthChart');
    if (!el) {
        return;
    }

    growthChart = new ApexCharts(el, {
        chart: { type: 'area', height: 280 },
        series: [{ name: 'New Customers', data: values }],
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#10B981'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 },
        },
        xaxis: { categories: labels },
        dataLabels: { enabled: false },
        grid: { borderColor: GRID_COLOR },
    });

    growthChart.render();
}

function renderAll(data) {
    renderRevenueChart(data.revenue.labels, data.revenue.values);
    renderOrderStatusChart(data.order_status.labels, data.order_status.values);
    renderCategoryChart(data.categories.labels, data.categories.values);
    renderCustomerGrowthChart(data.customer_growth.labels, data.customer_growth.values);
}

async function loadAndRender(period) {
    const { data, kpis } = await loadData(period);
    applyKpis(kpis);
    renderAll(data);
}

function boot() {
    const buttons = document.querySelectorAll('.chart-period-group .btn');

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            buttons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            loadAndRender(btn.dataset.period || 'month');
        });
    });

    loadAndRender('month');
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
