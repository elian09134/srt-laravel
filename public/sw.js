const CACHE_NAME = 'terang-srt-v3';
const urlsToCache = [
  '/offline.html',
  '/images/terang.png',
  '/manifest.json',
  'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css'
];

// Install Service Worker
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Opened cache');
        return cache.addAll(urlsToCache.map(url => new Request(url, {cache: 'reload'})));
      })
      .catch(err => {
        console.log('Cache open failed: ', err);
      })
  );
  self.skipWaiting();
});

// Fetch from cache
self.addEventListener('fetch', event => {
  // Skip non-GET requests
  if (event.request.method !== 'GET') return;
  
  // Skip chrome extensions and other schemes
  if (!event.request.url.startsWith('http')) return;
  
  // DO NOT cache auth pages, login, register, or pages with CSRF tokens
  const url = new URL(event.request.url);
  const skipCachePatterns = [
    '/login',
    '/register',
    '/password',
    '/logout',
    '/auth',
    '/admin',
    '/profile',
    '/dashboard',
    '/api'
  ];
  
  const shouldSkipCache = skipCachePatterns.some(pattern => url.pathname.includes(pattern));
  
  if (shouldSkipCache) {
    // For auth pages, always fetch from network (never cache)
    return event.respondWith(
      fetch(event.request).catch(() => caches.match('/offline.html'))
    );
  }
  
  // Network-first strategy for HTML pages to get fresh auth state
  if (event.request.headers.get('accept') && event.request.headers.get('accept').includes('text/html')) {
    return event.respondWith(
      fetch(event.request)
        .then(response => {
          // Clone and cache successful responses
          if (response && response.status === 200) {
            const responseToCache = response.clone();
            caches.open(CACHE_NAME).then(cache => {
              cache.put(event.request, responseToCache);
            });
          }
          return response;
        })
        .catch(() => {
          // Fallback to cache if network fails
          return caches.match(event.request)
            .then(response => response || caches.match('/offline.html'));
        })
    );
  }

  // Cache-first for static assets
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Cache hit - return response
        if (response) {
          return response;
        }

        return fetch(event.request).then(
          response => {
            // Check if valid response
            if(!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // Clone response
            const responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(cache => {
                cache.put(event.request, responseToCache);
              });

            return response;
          }
        );
      })
      .catch(() => {
        // Return offline page if available
        return caches.match('/offline.html');
      })
  );
});

// Activate Service Worker
self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Background sync for offline form submissions
self.addEventListener('sync', event => {
  if (event.tag === 'sync-forms') {
    event.waitUntil(syncForms());
  }
});

async function syncForms() {
  // Implement background sync logic here
  console.log('Syncing forms...');
}

// Push notifications
self.addEventListener('push', event => {
  const options = {
    body: event.data ? event.data.text() : 'Notifikasi baru dari TERANG By SRT',
    icon: '/images/icon-192x192.png',
    badge: '/images/icon-72x72.png',
    vibrate: [200, 100, 200],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1
    },
    actions: [
      {
        action: 'explore',
        title: 'Lihat',
        icon: '/images/checkmark.png'
      },
      {
        action: 'close',
        title: 'Tutup',
        icon: '/images/close.png'
      }
    ]
  };

  event.waitUntil(
    self.registration.showNotification('TERANG By SRT', options)
  );
});

// Notification click handler
self.addEventListener('notificationclick', event => {
  event.notification.close();

  if (event.action === 'explore') {
    event.waitUntil(
      clients.openWindow('/')
    );
  }
});
