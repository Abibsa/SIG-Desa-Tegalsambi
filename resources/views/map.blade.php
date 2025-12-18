@extends('layouts.webgis')

@section('content')
    <div class="relative w-full h-screen overflow-hidden font-sans">

        <!-- Navbar Overlay -->
        <nav
            class="absolute top-0 left-0 w-full z-[1000] px-4 md:px-6 py-4 flex justify-between items-center pointer-events-none">
            <div
                class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-full shadow-lg pointer-events-auto flex items-center gap-3 border border-white/50">
                <!-- Logo -->
                <div
                    class="w-8 h-8 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-gray-800 text-sm leading-tight">SIG DESA TEGALSAMBI</h1>
                    <p class="text-[10px] text-gray-500 font-medium tracking-wider">WEBGIS INFORMASI & STATISTIK</p>
                </div>
            </div>

            <div class="pointer-events-auto">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-gray-900 hover:bg-black text-white px-5 py-2 rounded-full text-sm font-medium transition shadow-lg backdrop-blur-md flex items-center gap-2">
                        <span>Dashboard Admin</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full text-sm font-medium transition shadow-lg flex items-center gap-2">
                        <span>Masuk</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </a>
                @endauth
            </div>
        </nav>

        <!-- Floating Sidebar (Kiri) -->
        <div class="absolute top-24 left-4 md:left-6 z-[999] w-80 flex flex-col gap-4 pointer-events-none transition-all duration-300 transform"
            id="sidebar-panel">

            <!-- Search Bar -->
            <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-2 pointer-events-auto border border-white/20 relative group z-50">
                <div class="flex items-center gap-2 pl-2">
                     <div class="w-8 h-8 flex items-center justify-center bg-gray-50 rounded-full text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                     </div>
                     <input type="text" id="map-search" class="w-full bg-transparent border-none focus:ring-0 text-sm placeholder-gray-400 h-10" placeholder="Cari RW atau Lokasi..." disabled autocomplete="off">
                     <button id="clear-search" class="hidden p-2 text-gray-400 hover:text-red-500 rounded-full hover:bg-red-50 transition">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                     </button>
                </div>
                <!-- Search Results -->
                <div id="search-results" class="hidden absolute top-full left-0 w-full mt-2 bg-white rounded-xl shadow-xl overflow-hidden pointer-events-auto z-[1001] max-h-[60vh] overflow-y-auto"></div>
            </div>

            <!-- Info Panel -->
            <div
                class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl overflow-hidden pointer-events-auto border border-white/20">
                <div class="p-4 bg-gradient-to-r from-gray-900 to-gray-800 text-white flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <h2 class="font-bold text-sm tracking-wide">STATISTIK WILAYAH</h2>
                    </div>
                    <!-- Reset Button -->
                    <button onclick="loadDesaStats()" title="Reset ke Desa"
                        class="text-xs bg-white/10 hover:bg-white/20 px-2 py-1 rounded text-white transition">Reset</button>
                </div>

                <div id="info-content" class="p-4 max-h-[55vh] overflow-y-auto custom-scrollbar">
                    <!-- Konten Dinamis -->
                    <div class="flex flex-col items-center justify-center py-8 space-y-3">
                        <div class="w-8 h-8 border-2 border-gray-200 border-t-red-600 rounded-full animate-spin"></div>
                        <span class="text-xs text-gray-400">Memuat data...</span>
                    </div>
                </div>
            </div>

            <!-- Layer Control -->
            <div class="bg-white/90 backdrop-blur-md rounded-xl shadow-lg p-4 pointer-events-auto border border-white/20">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Layer Peta</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 text-sm text-gray-700 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" checked onchange="window.toggleLayer('rw')"
                                class="peer h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500 transition cursor-pointer">
                        </div>
                        <span class="group-hover:text-red-700 transition font-medium">Choropleth RW</span>
                        <div class="ml-auto w-3 h-3 rounded-full bg-red-500 shadow-sm"></div>
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-700 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" checked onchange="window.toggleLayer('poi')"
                                class="peer h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500 transition cursor-pointer">
                        </div>
                        <span class="group-hover:text-red-700 transition font-medium">Point of Interest</span>
                        <div class="ml-auto w-3 h-3 rounded-full bg-blue-500 shadow-sm"></div>
                    </label>
                </div>

                <!-- Legend Kepadatan RW -->
                <div class="mt-4 pt-3 border-t border-gray-100" id="legend-mini">
                    <p class="text-[10px] font-semibold text-gray-600 mb-2">Kepadatan Penduduk</p>
                    <div class="flex items-center justify-between text-[10px] text-gray-500">
                        <span>Rendah</span>
                        <div class="w-full h-1.5 mx-2 rounded-full bg-gradient-to-r from-red-100 via-red-300 to-red-600">
                        </div>
                        <span>Tinggi</span>
                    </div>
                </div>

                <!-- POI Legend -->
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <p class="text-[10px] font-semibold text-gray-600 mb-3">Kategori POI</p>
                    <div class="grid grid-cols-2 gap-2 text-[10px]">
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🕌</span>
                            <span class="text-gray-600">Masjid</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🕌</span>
                            <span class="text-gray-600">Musholla</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🏛️</span>
                            <span class="text-gray-600">Pemda</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🏫</span>
                            <span class="text-gray-600">Sekolah</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🏥</span>
                            <span class="text-gray-600">Kesehatan</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🏪</span>
                            <span class="text-gray-600">Dagang</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🎓</span>
                            <span class="text-gray-600">Pendidikan</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🤲</span>
                            <span class="text-gray-600">Agama</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm">🏠</span>
                            <span class="text-gray-600">Rumah</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Map Container -->
        <div id="map" class="w-full h-full z-0 bg-gray-100"></div>

        <!-- Layer Switcher (Top Right) -->
        <div class="absolute z-[998] flex flex-col gap-2" style="top: 6rem; right: 1.5rem;">
            <div class="bg-white/90 backdrop-blur-md p-1.5 rounded-xl shadow-lg border border-white/20 flex flex-col gap-1">
                <button onclick="setBaseLayer('roadmap')" class="p-2 hover:bg-gray-100 rounded-lg transition group" title="Mode Jalan">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                </button>
                <div class="h-px w-full bg-gray-200"></div>
                <button onclick="setBaseLayer('satellite')" class="p-2 hover:bg-gray-100 rounded-lg transition group" title="Mode Satelit">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
            </div>
        </div>

        <!-- Floating Map Controls (Bottom Right) -->
        <div class="absolute bottom-6 right-6 z-[998] flex flex-col gap-2">

            <!-- Fullscreen Button -->
            <button id="fullscreen-btn" onclick="toggleFullscreen()"
                class="bg-white/90 backdrop-blur-md hover:bg-white p-3 rounded-xl shadow-lg border border-white/20 transition-all duration-200 hover:scale-110 group"
                title="Toggle Fullscreen">
                <svg id="fullscreen-icon" class="w-5 h-5 text-gray-700 group-hover:text-red-600 transition" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                    </path>
                </svg>
            </button>

            <!-- Geolocation Button -->
            <button id="geolocation-btn" onclick="findMyLocation()"
                class="bg-white/90 backdrop-blur-md hover:bg-white p-3 rounded-xl shadow-lg border border-white/20 transition-all duration-200 hover:scale-110 group"
                title="Find My Location">
                <svg class="w-5 h-5 text-gray-700 group-hover:text-blue-600 transition" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </button>
        </div>

        <!-- Info Box (Bottom Center) -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-[998] pointer-events-none">
            <div
                class="bg-white/90 backdrop-blur-md rounded-xl shadow-lg px-4 py-2 border border-white/20 pointer-events-auto">
                <div class="flex items-center gap-3 text-xs text-gray-600">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Klik pada wilayah atau POI untuk info detail</span>
                    </div>
                    <div class="h-3 w-px bg-gray-300"></div>
                    <div class="flex items-center gap-1">
                        <span class="text-gray-400">©</span>
                        <span>Google Maps via Leaflet</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loading"
            class="absolute inset-0 z-[2000] bg-white flex flex-col items-center justify-center transition-opacity duration-500">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-gray-100 border-t-red-600 rounded-full animate-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-2 h-2 bg-red-600 rounded-full"></div>
                </div>
            </div>
            <p class="mt-4 text-gray-800 font-bold tracking-widest text-sm animate-pulse">MEMUAT PETA...</p>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Fix Leaflet Path Outline Issues */
        path.leaflet-interactive {
            outline: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: stroke-width 0.2s, stroke 0.2s, fill-opacity 0.2s;
        }

        /* Custom POI Marker Styling */
        .custom-poi-marker {
            background: transparent !important;
            border: none !important;
        }
        
        /* Smooth animation for ping effect */
        @keyframes ping {
            75%, 100% {
                transform: scale(2);
                opacity: 0;
            }
        }
        .animate-ping {
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        /* Leaflet Controls Customization */
        .leaflet-control-zoom {
            border: none !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            border-radius: 0.75rem !important;
            overflow: hidden;
            margin-bottom: 1.5rem !important;
            margin-right: 1.5rem !important;
        }
        .leaflet-control-zoom a {
            background-color: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(8px);
            color: #374151 !important;
            border-bottom: 1px solid rgba(255,255,255,0.2) !important;
            width: 36px !important;
            height: 36px !important;
            line-height: 36px !important;
            font-size: 16px !important;
        }
        .leaflet-control-zoom a:hover {
            background: #fff !important;
            color: #ef4444 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loading = document.getElementById('loading');
            
            // --- 1. Initialize Leaflet Map ---
            const map = L.map('map', {
                center: [-6.6175, 110.6525], // Desa Tegalsambi
                zoom: 15,
                zoomControl: false, // We'll move it
                attributionControl: false
            });

            // Adjust zoom control position
            L.control.zoom({ position: 'bottomright' }).addTo(map);

            // --- 2. Google Maps Tile Layers (HTTPS) ---
            const googleRoadmap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
            
            const googleSatellite = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
            
            // Set default layer
            googleRoadmap.addTo(map);
            let currentBaseLayer = googleRoadmap;

            // Global function to switch base layers
            window.setBaseLayer = function(type) {
                map.removeLayer(currentBaseLayer);
                if (type === 'roadmap') {
                    currentBaseLayer = googleRoadmap;
                } else {
                    currentBaseLayer = googleSatellite;
                }
                currentBaseLayer.addTo(map);
            };

            // --- 3. Layer Groups ---
            const rwLayerGroup = L.layerGroup().addTo(map);
            const poiLayerGroup = L.layerGroup().addTo(map);

            let layersLoaded = { rw: false, poi: false };

            function checkLayersLoaded() {
                if (layersLoaded.rw && layersLoaded.poi) {
                    // Hide loading
                    setTimeout(() => {
                        loading.style.opacity = '0';
                        setTimeout(() => loading.style.display = 'none', 500);
                    }, 500);
                    
                    // Build Search
                    buildSearchIndex();
                    document.getElementById('map-search').disabled = false;
                }
            }

            // --- 4. Load RW GeoJSON (Choropleth) ---
            function getColor(total) {
                return total > 1500 ? '#b91c1c' : 
                       total > 1300 ? '#ef4444' : 
                       total > 1000 ? '#fca5a5' : 
                                      '#fee2e2'; 
            }

            function styleRW(feature) {
                return {
                    fillColor: getColor(feature.properties.total || 0),
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.6
                };
            }

            function highlightFeature(e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 3,
                    color: '#666',
                    dashArray: '',
                    fillOpacity: 0.8
                });
                layer.bringToFront();
            }

            function resetHighlight(e) {
                // We access the original GeoJSON layer to reset style
                // Ideally we keep a reference to the GeoJSON layer instance
                // But for now, just resetting to default style function logic works if stateless
                const layer = e.target;
                const feature = layer.feature; // Access feature data attached by L.geoJSON
                if(feature) {
                     layer.setStyle(styleRW(feature));
                }
            }

            function onRwClick(e) {
                const props = e.target.feature.properties;
                window.updateSidebarRW(props);
                map.fitBounds(e.target.getBounds());
            }

            // Store feature reference for search zooming
            let rwFeaturesSearch = [];

            fetch('{{ route('api.rw.geojson') }}')
                .then(r => r.json())
                .then(data => {
                    const rwGeoJson = L.geoJSON(data, {
                        style: styleRW,
                        onEachFeature: function(feature, layer) {
                            // Store for search
                            rwFeaturesSearch.push({ feature, layer });
                            
                            layer.on({
                                mouseover: highlightFeature,
                                mouseout: resetHighlight,
                                click: onRwClick
                            });
                        }
                    });
                    rwLayerGroup.addLayer(rwGeoJson);
                    layersLoaded.rw = true;
                    checkLayersLoaded();
                })
                .catch(e => {
                    console.error("RW Error:", e);
                    layersLoaded.rw = true;
                    checkLayersLoaded();
                });


            // --- 5. Load POI GeoJSON (Custom Markers) ---
            let poiFeaturesSearch = [];

            fetch('{{ route('api.poi.geojson') }}')
                .then(r => r.json())
                .then(data => {
                    L.geoJSON(data, {
                        pointToLayer: function(feature, latlng) {
                            const props = feature.properties;
                            const kategori = (props.kategori || '').trim();
                            
                            // Default Style
                            let c = 'blue';
                            let svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>'; // Map Pin

                            // Category Logic (Matching Admin Panel)
                            if(kategori === 'Masjid' || kategori.includes('Mushola')) { 
                                c = 'green'; 
                                svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>'; // Building
                            }
                            else if(kategori === 'Pemerintahan') { 
                                c = 'gray'; 
                                svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>'; // Office
                            }
                            else if(kategori === 'Sekolah' || kategori === 'Pendidikan') { 
                                c = 'blue'; 
                                svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>'; // Academic Cap
                            }
                            else if(kategori === 'Kesehatan') { 
                                c = 'red'; 
                                svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>'; // Heart
                            }
                            else if(kategori === 'Perdagangan') { 
                                c = 'purple'; 
                                svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>'; // Shopping Cart
                            }
                            else if(kategori === 'Lapangan' || kategori === 'Olahraga') {
                                c = 'orange';
                                svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M3 21h18M5 21v-8a2 2 0 00-2-2m2 7h14m-14 3h16m-2-12l-1.5 8M10 9a3 3 0 100-6 3 3 0 000 6z"></path>'; // Flag
                            }
                            else if(kategori === 'Agama') { 
                                c = 'teal'; 
                                svgIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>'; // Same as Mosque for general religion
                            }

                            // 1. Setup Warna (Hex Codes untuk SVG Gradients)
                            const colors = {
                                'blue':   { light: '#60a5fa', dark: '#2563eb', ring: '#93c5fd' }, // Sekolah
                                'green':  { light: '#34d399', dark: '#059669', ring: '#6ee7b7' }, // Masjid
                                'red':    { light: '#f87171', dark: '#dc2626', ring: '#fca5a5' }, // Kesehatan
                                'gray':   { light: '#94a3b8', dark: '#475569', ring: '#cbd5e1' }, // Pemerintahan
                                'purple': { light: '#a78bfa', dark: '#7c3aed', ring: '#c4b5fd' }, // Perdagangan
                                'orange': { light: '#fbbf24', dark: '#d97706', ring: '#fcd34d' }, // Lapangan
                                'teal':   { light: '#2dd4bf', dark: '#0d9488', ring: '#5eead4' }, // Agama
                                'pink':   { light: '#f472b6', dark: '#db2777', ring: '#f9a8d4' }, // Lainnya
                                'indigo': { light: '#818cf8', dark: '#4f46e5', ring: '#a5b4fc' }  // Default
                            };
                            
                            const t = colors[c] || colors['blue'];
                            
                            // 2. Ikon Solid (Filled) untuk Realisme Lebih Baik
                            let iconPath = '';
                            const lowerKat = kategori.toLowerCase(); // Normalisasi agar tidak sensitif case

                            if(lowerKat.includes('masjid') || lowerKat.includes('mush') || lowerKat.includes('langgar') || lowerKat.includes('surau') || lowerKat.includes('ibadah') || lowerKat.includes('agama')) { 
                                // Masjid Realistis (Kubah + Bulan Sabit) - Mencakup Musholla/Mushola/Langgar
                                iconPath = '<path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2Zm0 7a5 5 0 0 0-5 5h10a5 5 0 0 0-5-5Zm-5.8 7H6v4h.2v-4Zm11.6 0H18v4h-.2v-4Z"/>'; 
                            }
                            else if(lowerKat.includes('pemerinta') || lowerKat.includes('kantor') || lowerKat.includes('balai')) { 
                                // Gedung (Solid)
                                iconPath = '<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 3a1 1 0 011-1h2a1 1 0 011 1v1H6V7zm1 3a1 1 0 100 2h2a1 1 0 100-2H7zm5-3a1 1 0 011-1h2a1 1 0 011 1v1h-4V7zm1 3a1 1 0 100 2h2a1 1 0 100-2h-2z" clip-rule="evenodd" />'; 
                            }
                            else if(lowerKat.includes('sekolah') || lowerKat.includes('pendidikan') || lowerKat.includes('tk') || lowerKat.includes('sd') || lowerKat.includes('smp') || lowerKat.includes('sma') || lowerKat.includes('mi') || lowerKat.includes('mts')) { 
                                // Topi Sekolah (Solid)
                                iconPath = '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 000-2"/>'; 
                            }
                            else if(lowerKat.includes('sehat') || lowerKat.includes('sakit') || lowerKat.includes('medis') || lowerKat.includes('klinik') || lowerKat.includes('puskesmas') || lowerKat.includes('posyandu')) { 
                                // Simbol Medis (Cross/Plus Tebal)
                                iconPath = '<path fill-rule="evenodd" d="M10 2a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V3a1 1 0 011-1z" clip-rule="evenodd" />'; 
                            }
                            else if(lowerKat.includes('dagang') || lowerKat.includes('toko') || lowerKat.includes('warung') || lowerKat.includes('pasar') || lowerKat.includes('bisnis') || lowerKat.includes('umkm')) { 
                                // Keranjang (Solid)
                                iconPath = '<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />'; 
                            }
                            else if(lowerKat.includes('lapangan') || lowerKat.includes('olahraga') || lowerKat.includes('sport') || lowerKat.includes('gor')) {
                                // Bendera (Solid)
                                iconPath = '<path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />'; 
                            }
                            else { 
                                // Pin standar (Solid)
                                iconPath = '<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />';
                            }

                            // 3. Render HTML dengan SVG Murni (Realistis)
                            // ID unik untuk setiap gradient berdasarkan kategori (agar tidak conflict)
                            const gradId = `grad-${c}`;
                            const shadowId = `shadow-${c}`;

                            const html = `
                                <div class="relative group cursor-pointer" style="width: 50px; height: 50px;">
                                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" class="filter drop-shadow-lg transition-transform duration-300 group-hover:-translate-y-2">
                                        <defs>
                                            <radialGradient id="${gradId}" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(25 21) rotate(90) scale(21)">
                                                <stop stop-color="${t.light}" />
                                                <stop offset="1" stop-color="${t.dark}" />
                                            </radialGradient>
                                            <filter id="${shadowId}" x="0" y="0" width="50" height="50" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                <feOffset dy="4"/>
                                                <feGaussianBlur stdDeviation="2"/>
                                                <feComposite in2="hardAlpha" operator="out"/>
                                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
                                            </filter>
                                        </defs>
                                        
                                        <!-- Pin Shape (Teardrop) with Radial Gradient -->
                                        <g filter="url(#${shadowId})">
                                            <path d="M25 43C25 43 10 30.5 10 19C10 10.7157 16.7157 4 25 4C33.2843 4 40 10.7157 40 19C40 30.5 25 43 25 43Z" fill="url(#${gradId})"/>
                                            <path d="M25 43C25 43 10 30.5 10 19C10 10.7157 16.7157 4 25 4C33.2843 4 40 10.7157 40 19C40 30.5 25 43 25 43Z" stroke="white" stroke-opacity="0.2" stroke-width="1.5"/>
                                        </g>
                                        
                                        <!-- Reflection / Highlight (Glossy Effect) -->
                                        <ellipse cx="25" cy="12.5" rx="8" ry="4" fill="white" fill-opacity="0.25"/>
                                        
                                        <!-- Inner Icon (White, Centered) -->
                                        <g transform="translate(15, 9) scale(1)">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="white">
                                                ${iconPath}
                                            </svg>
                                        </g>
                                    </svg>

                                    <!-- Tooltip on Hover -->
                                    <div class="absolute bottom-full mb-1 left-1/2 transform -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-xl whitespace-nowrap z-[1002] tracking-wide border border-gray-700">
                                        ${props.nama}
                                        <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45 transform border-r border-b border-gray-700"></div>
                                    </div>
                                </div>
                            `;

                            return L.marker(latlng, {
                                icon: L.divIcon({
                                    className: 'custom-poi-real',
                                    html: html,
                                    iconSize: [50, 50],
                                    iconAnchor: [25, 43], // Tip at the very bottom point of the SVG
                                    popupAnchor: [0, -45]
                                })
                            });
                        },
                        onEachFeature: function(feature, layer) {
                            poiFeaturesSearch.push({ feature, layer });
                            
                            const props = feature.properties;
                            const popupContent = `
                                <div class="min-w-[200px] font-sans">
                                    <h3 class="font-bold text-gray-800 text-sm mb-1 pb-1 border-b">${props.nama}</h3>
                                    <div class="flex items-center gap-1 mb-1">
                                        <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-600 border border-gray-200 font-medium tracking-wide uppercase">${props.kategori}</span>
                                    </div>
                                    ${props.alamat ? `<p class="text-xs text-gray-500 leading-relaxed"><span class="font-semibold block text-[10px] text-gray-400 uppercase mt-2 mb-0.5">Alamat:</span>${props.alamat}</p>` : ''}
                                </div>
                            `;
                            layer.bindPopup(popupContent);
                        }
                    }).addTo(poiLayerGroup);

                    layersLoaded.poi = true;
                    checkLayersLoaded();
                })
                .catch(e => {
                    console.error("POI Error:", e);
                    layersLoaded.poi = true;
                    checkLayersLoaded();
                });


            // --- 6. Layer Control Toggles ---
            window.toggleLayer = function(name) {
                if (name === 'rw') {
                    if (map.hasLayer(rwLayerGroup)) map.removeLayer(rwLayerGroup);
                    else map.addLayer(rwLayerGroup);
                } else if (name === 'poi') {
                    if (map.hasLayer(poiLayerGroup)) map.removeLayer(poiLayerGroup);
                    else map.addLayer(poiLayerGroup);
                }
            };
            
            // --- 7. Geolocation ---
            let userMarker = null;
            window.findMyLocation = function() {
                 showToast('Mencari lokasi...', 'info');
                 map.locate({setView: true, maxZoom: 17});
            };

            map.on('locationfound', function(e) {
                if(userMarker) map.removeLayer(userMarker);
                
                const userHtml = `
                    <div class="relative flex items-center justify-center w-12 h-12">
                        <div class="absolute w-12 h-12 bg-blue-500 rounded-full opacity-20 animate-ping"></div>
                        <div class="relative w-4 h-4 bg-blue-600 border-2 border-white rounded-full shadow-lg"></div>
                    </div>`;

                userMarker = L.marker(e.latlng, {
                    icon: L.divIcon({
                        className: 'custom-poi-marker',
                        html: userHtml,
                        iconSize: [48, 48],
                        iconAnchor: [24, 24]
                    })
                }).addTo(map);
                
                showToast('Lokasi ditemukan!', 'success');
            });

            map.on('locationerror', function(e) {
                showToast('Gagal menemukan lokasi.', 'error');
            });


            // --- 8. Search Logic ---
            const searchInput = document.getElementById('map-search');
            const searchResults = document.getElementById('search-results');
            const clearBtn = document.getElementById('clear-search');
            let searchIndex = [];
            let searchTimeout;

            function buildSearchIndex() {
                searchIndex = [];
                // Add RW
                rwFeaturesSearch.forEach(item => {
                    searchIndex.push({
                        name: item.feature.properties.nama,
                        type: 'RW',
                        geo: item.layer, // The Leaflet layer
                        props: item.feature.properties
                    });
                });
                // Add POI
                poiFeaturesSearch.forEach(item => {
                    searchIndex.push({
                        name: item.feature.properties.nama,
                        kategori: item.feature.properties.kategori,
                        type: 'POI',
                        geo: item.layer,
                        props: item.feature.properties
                    });
                });
            }

            if(searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const q = e.target.value.toLowerCase().trim();
                    if(clearBtn) clearBtn.classList.toggle('hidden', !q);
                    clearTimeout(searchTimeout);
                    if(q.length < 2) { if(searchResults) searchResults.classList.add('hidden'); return; }
                    searchTimeout = setTimeout(() => performSearch(q), 300);
                });
            }

            function performSearch(q) {
                const res = searchIndex.filter(item => {
                    return item.name.toLowerCase().includes(q) || (item.kategori && item.kategori.toLowerCase().includes(q));
                });

                if(!res.length) {
                    searchResults.innerHTML = '<div class="p-4 text-center text-sm text-gray-500">Tidak ada hasil</div>';
                    searchResults.classList.remove('hidden');
                    return;
                }

                searchResults.innerHTML = `
                     <div class="max-h-60 overflow-y-auto">
                        <div class="px-3 py-2 text-xs font-semibold bg-gray-50 text-gray-500 border-b">Hasil Pencarian</div>
                        ${res.map((item, index) => `
                            <div class="p-3 border-b hover:bg-gray-50 cursor-pointer flex items-center gap-3 transition"
                                 onclick="window.searchSelect(${index})">
                                 <div class="w-8 h-8 rounded-lg flex items-center justify-center ${item.type === 'RW' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'}">
                                    ${item.type === 'RW' ? '🗺️' : '📍'}
                                 </div>
                                 <div class="overflow-hidden">
                                     <div class="text-sm font-semibold text-gray-800 truncate">${item.name}</div>
                                     <div class="text-xs text-gray-500">${item.type} ${item.kategori ? '- ' + item.kategori : ''}</div>
                                 </div>
                            </div>
                        `).join('')}
                    </div>
                `;
                searchResults.classList.remove('hidden');
                
                // Expose selection function
                window.searchSelect = function(index) {
                    const item = res[index];
                    if(item.type === 'RW') {
                        map.fitBounds(item.geo.getBounds());
                        item.geo.fire('click'); // Trigger sidebar
                    } else {
                        map.flyTo(item.geo.getLatLng(), 18);
                        item.geo.openPopup();
                    }
                    searchInput.value = '';
                    searchResults.classList.add('hidden');
                    clearBtn.classList.add('hidden');
                };
            }
            
            if(clearBtn) clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                searchResults.classList.add('hidden');
                clearBtn.classList.add('hidden');
            });
            
             // Close search results when clicking outside
            document.addEventListener('click', function (e) {
                if (searchResults && !searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });


            // --- Toast Polyfill ---
            if (typeof window.showToast === 'undefined') {
                window.showToast = function(message, type = 'info') {
                     let container = document.getElementById('toast-container');
                    if (!container) {
                        container = document.createElement('div');
                        container.id = 'toast-container';
                        container.className = 'fixed bottom-24 left-1/2 transform -translate-x-1/2 z-[3000] flex flex-col gap-2 pointer-events-none w-max max-w-sm';
                        document.body.appendChild(container);
                    }
                    const toast = document.createElement('div');
                    const c = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-gray-800';
                    toast.className = `${c} text-white px-4 py-2 rounded-full shadow-lg backdrop-blur-md transition-all duration-300 opacity-0 translate-y-4 flex items-center gap-2`;
                    toast.innerHTML = `<span class="text-xs font-medium">${message}</span>`;
                    container.appendChild(toast);
                    requestAnimationFrame(() => toast.classList.remove('opacity-0', 'translate-y-4'));
                    setTimeout(() => { toast.classList.add('opacity-0', 'translate-y-4'); setTimeout(() => toast.remove(), 300); }, 3000);
                };
            }
        });
        
        // --- Sidebar Logic (Preserved) ---
         let rwChart = null;
        window.updateSidebarRW = function (props) {
                const infoDiv = document.getElementById('info-content');
                if(!infoDiv) return;
                
                infoDiv.innerHTML = `
                    <div class="space-y-4 animate-fadeIn">
                        <div class="bg-gradient-to-br from-red-50 to-white p-4 rounded-xl border border-red-100 shadow-sm">
                            <h4 class="font-bold text-red-600 mb-2 text-sm uppercase">${props.nama}</h4>
                            <p class="text-xs text-gray-500 mb-3">STATISTIK RW</p>
                            <div class="grid grid-cols-2 gap-3">
                                <div><div class="text-xs text-gray-500">Total</div><div class="font-bold text-xl text-gray-800">${props.total}</div></div>
                                <div><div class="text-xs text-gray-500">KK</div><div class="font-bold text-xl text-gray-700">${props.kk}</div></div>
                            </div>
                            <div class="flex gap-2 text-xs mt-3 pt-2 border-t border-red-100">
                                <div class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-gray-800"></div> L: ${props.laki}</div>
                                <div class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-red-500"></div> P: ${props.perempuan}</div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-700 mb-2 text-xs uppercase">Rasio Gender</h4>
                            <div class="relative h-[150px]">
                                <canvas id="chartGender"></canvas>
                            </div>
                        </div>
                    </div>
                `;

                if (rwChart) rwChart.destroy();
                const ctx = document.getElementById('chartGender').getContext('2d');
                rwChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [Number(props.laki), Number(props.perempuan)],
                            backgroundColor: ['#1f2937', '#dc2626'],
                            borderWidth: 0
                        }]
                    },
                    options: { maintainAspectRatio: false, cutout: '60%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } } }
                });
        };
        
        window.loadDesaStats = function () {
             if (rwChart) { rwChart.destroy(); rwChart = null; }
             const infoDiv = document.getElementById('info-content');
             if(!infoDiv) return;
             infoDiv.innerHTML = `<div class="animate-pulse space-y-3"><div class="h-20 bg-gray-100 rounded-lg"></div><div class="h-40 bg-gray-50 rounded-lg"></div></div>`;
             
             fetch('{{ route('api.desa.stats') }}')
                .then(r => r.json())
                .then(data => {
                     // Stats Building Logic (Same as before)
                     const labelsPendn = data.pendidikan.map(x => x.label);
                     const valsPendn = data.pendidikan.map(x => x.value);
                     const labelsPekerjaan = data.pekerjaan.map(x => x.label);
                     const valsPekerjaan = data.pekerjaan.map(x => x.value);
                     const labelsAgama = data.agama.map(x => x.label);
                     const valsAgama = data.agama.map(x => x.value);
                     const labelsUmur = data.umur.map(x => x.label);
                     const valsUmur = data.umur.map(x => x.value);

                     infoDiv.innerHTML = `
                                 <div class="space-y-6 animate-fadeIn pb-4">
                                     <div class="bg-gradient-to-br from-blue-50 to-white p-4 rounded-xl border border-blue-100 shadow-sm">
                                         <h4 class="font-bold text-gray-800 mb-3 text-sm uppercase tracking-wide">Populasi Desa</h4>
                                         <div class="grid grid-cols-2 gap-3 mb-2">
                                             <div><div class="text-xs text-gray-500">Penduduk</div><div class="font-bold text-xl text-blue-600">${data.penduduk.total.toLocaleString()}</div></div>
                                             <div><div class="text-xs text-gray-500">Kepala Keluarga</div><div class="font-bold text-xl text-gray-700">${data.penduduk.kk.toLocaleString()}</div></div>
                                         </div>
                                         <div class="flex gap-2 text-xs mt-2 pt-2 border-t border-blue-100">
                                             <div class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-gray-800"></div> L: ${data.penduduk.laki}</div>
                                             <div class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-red-500"></div> P: ${data.penduduk.perempuan}</div>
                                         </div>
                                     </div>
                                     <div>
                                         <h4 class="font-bold text-gray-700 mb-2 text-xs uppercase border-b pb-1">Tingkat Pendidikan</h4>
                                         <div class="relative h-48">
                                             <canvas id="chartPendidikan"></canvas>
                                         </div>
                                     </div>
                                     <div>
                                         <h4 class="font-bold text-gray-700 mb-2 text-xs uppercase border-b pb-1">Pekerjaan (Top 10)</h4>
                                         <div class="relative h-48">
                                             <canvas id="chartPekerjaan"></canvas>
                                         </div>
                                     </div>
                                     <div>
                                         <h4 class="font-bold text-gray-700 mb-2 text-xs uppercase border-b pb-1">Agama</h4>
                                         <div class="relative h-40">
                                             <canvas id="chartAgama"></canvas>
                                         </div>
                                     </div>
                                     <div>
                                         <h4 class="font-bold text-gray-700 mb-2 text-xs uppercase border-b pb-1">Rentang Umur</h4>
                                         <div class="relative h-48">
                                             <canvas id="chartUmur"></canvas>
                                         </div>
                                     </div>
                                 </div>`;

                    new Chart(document.getElementById('chartPendidikan'), { type: 'bar', data: { labels: labelsPendn, datasets: [{ label: 'Jml', data: valsPendn, backgroundColor: '#3b82f6', borderRadius: 4 }] }, options: { indexAxis: 'y', maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { display: false }, y: { grid: { display: false }, ticks: { font: { size: 10 } } } } } });
                    new Chart(document.getElementById('chartPekerjaan'), { type: 'doughnut', data: { labels: labelsPekerjaan, datasets: [{ data: valsPekerjaan, backgroundColor: ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#10b981', '#06b6d4', '#3b82f6', '#6366f1', '#8b5cf6', '#d946ef'], borderWidth: 0 }] }, options: { maintainAspectRatio: false, cutout: '60%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 8, font: { size: 9 }, padding: 10 } } } } });
                    new Chart(document.getElementById('chartAgama'), { type: 'pie', data: { labels: labelsAgama, datasets: [{ data: valsAgama, backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#dc2626', '#8b5cf6'], borderWidth: 0 }] }, options: { maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { boxWidth: 8, font: { size: 10 } } } } } });
                    new Chart(document.getElementById('chartUmur'), { type: 'bar', data: { labels: labelsUmur, datasets: [{ label: 'Jiwa', data: valsUmur, backgroundColor: '#6366f1', borderRadius: 4 }] }, options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { display: false }, x: { grid: { display: false }, ticks: { font: { size: 9 }, maxRotation: 45, minRotation: 45 } } } } });
                })
                .catch(console.error);
        };
        // Init
        loadDesaStats();
        
        window.toggleFullscreen = function () {
            if (!document.fullscreenElement) document.documentElement.requestFullscreen();
            else document.exitFullscreen();
        };
    </script>
@endpush