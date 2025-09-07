const cacheVersion = 'v2';
const CACHE_PREFIX = "pwa-qrexOrder"; // Prefix for cache names
const OFFLINE_URL = 'offline'; // Offline page URL

// Define the files to cache
const filesToCache = [
  'assets/frontend/css/style.css',
  'uploads/pwa/logo.png',
];

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(getCacheName())
      .then(cache => {
        return cache.addAll(filesToCache);
      })
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.filter(cacheName => cacheName.startsWith(CACHE_PREFIX) && cacheName !== getCacheName())
          .map(cacheName => caches.delete(cacheName))
      );
    })
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response; // Return the cached response if present
        }

        // If the request is not cached, fetch it from the network
        return fetch(event.request)
          .then(response => {
            // Cache the fetched response for future use
            return caches.open(getCacheName())
              .then(cache => {
                cache.put(event.request, response.clone());
                return response;
              });
          })
          .catch(() => {
            // If fetching fails, respond with the offline page
            return caches.match(OFFLINE_URL);
          });
      })
  );
});

function getCacheName() {
  // Dynamically generate cache name based on the current slug
  const queryString = self.location.search;
  const urlParams = new URLSearchParams(queryString);
  const slug = urlParams.get('slug');
  return `${CACHE_PREFIX}-${slug}-${cacheVersion}`;
}
