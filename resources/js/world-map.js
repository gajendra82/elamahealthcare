import jsVectorMap from 'jsvectormap';
import 'jsvectormap/dist/jsvectormap.css';
import 'jsvectormap/dist/maps/world.js';

export function initWorldMap(root) {
    if (!root || root.dataset.mapInitialized === 'true') {
        return root?._worldMap ?? null;
    }

    const canvas = root.querySelector('.world-map-canvas');

    if (!canvas) {
        return null;
    }

    const countries = JSON.parse(root.dataset.countries || '{}');
    const codes = Object.keys(countries);
    const values = {};

    codes.forEach((code) => {
        values[code] = countries[code]?.type === 'hq' ? 2 : 1;
    });

    const map = new jsVectorMap({
        selector: canvas,
        map: 'world',
        backgroundColor: 'transparent',
        zoomOnScroll: false,
        zoomButtons: true,
        regionsSelectable: true,
        regionStyle: {
            initial: {
                fill: '#E2E8F0',
                fillOpacity: 1,
                stroke: '#FFFFFF',
                strokeWidth: 0.5,
            },
            hover: {
                fillOpacity: 0.85,
                cursor: 'pointer',
            },
        },
        series: {
            regions: [
                {
                    attribute: 'fill',
                    scale: ['#3B8DD4', '#0B4F8C', '#062F54'],
                    values,
                    min: 1,
                    max: 2,
                },
            ],
        },
        onRegionClick(event, code) {
            if (!countries[code]) {
                return;
            }

            root.dispatchEvent(new CustomEvent('world-map-region', {
                detail: { code },
                bubbles: true,
            }));
        },
        onRegionTipShow(event, tooltip, code) {
            const country = countries[code];

            if (!country) {
                event.preventDefault();
                return;
            }

            tooltip.text(
                `<div class="world-map-tooltip"><strong>${country.name}</strong><span>${country.region}${country.type === 'hq' ? ' · Headquarters' : ''}</span></div>`,
                true
            );
        },
    });

    root.addEventListener('highlight-region', (event) => {
        const code = event.detail?.code;

        if (code && countries[code]) {
            map.setSelectedRegions([code]);
        }
    });

    root.dataset.mapInitialized = 'true';
    root._worldMap = map;

    return map;
}

export function initWorldMaps() {
    document.querySelectorAll('[data-world-map]').forEach((root) => {
        initWorldMap(root);
    });
}
