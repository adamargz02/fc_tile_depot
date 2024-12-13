// Files to cache
const OFFLINE_URL = 'http://127.0.0.1:5500/libs/pageoffline/offline.html';

const FILES_TO_CACHE = [
    'D:\Data of Apps\Xammp\htdocs\fc_tile_depot\libs\pageoffline\offline.html', // Replace with the static HTML version of your homepage
    'D:\Data of Apps\Xammp\htdocs\fc_tile_depot\libs\js\app.js',
    'D:\Data of Apps\Xammp\htdocs\fc_tile_depot\libs\pageoffline\offline.html', // Ensure the offline page is accessible
    'uploads\logo\tile_logo.jpg', // Corrected path
];

// Install event: Cache resources
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(FILES_TO_CACHE))
            .then(() => self.skipWaiting())
    );
});

// Activate event: Clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames =>
            Promise.all(
                cacheNames.map(cache => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            )
        )
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request).catch(() => {
                if (event.request.mode === 'navigate') {
                    return caches.match(OFFLINE_URL);
                }
            });
        })
    );
});
