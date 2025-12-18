// Small IntersectionObserver to reveal elements on scroll with optional stagger
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            const el = entry.target;
            if (el.classList.contains('reveal-stagger')) {
                // reveal children with stagger
                const children = Array.from(el.children);
                children.forEach((child, idx) => {
                    setTimeout(() => {
                        child.style.transitionDelay = (idx * 80) + 'ms';
                        child.classList.add('reveal-visible');
                    }, idx * 80);
                });
                el.classList.add('reveal-visible');
            } else {
                el.classList.add('reveal-visible');
            }
            revealObserver.unobserve(el);
        }
    });
}, { threshold: 0.15 });

window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.reveal, .reveal-stagger').forEach((el) => {
        // ensure children start hidden when using stagger
        if (el.classList.contains('reveal-stagger')) {
            Array.from(el.children).forEach((c) => c.classList.add('reveal'));
        }
        revealObserver.observe(el);
    });

    // --- Job search (debounced) ---
    const jobSearch = document.getElementById('job-search');
    let searchTimer = null;
    if (jobSearch) {
        jobSearch.addEventListener('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(async () => {
                try {
                    const q = jobSearch.value.trim();
                    const res = await window.axios.get('/api/jobs/search', { params: { q } });
                    const jobs = res.data.data;
                    const container = document.getElementById('jobs-list');
                    if (!container) return;
                    if (jobs.length === 0) {
                        container.innerHTML = '<p class="col-span-3 text-center text-gray-500">Tidak ada hasil.</p>';
                        return;
                    }
                    container.innerHTML = jobs.map(job => `
                        <div class="group bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200">
                            <div class="p-4 bg-gradient-to-r from-blue-500 to-blue-600">
                                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold rounded-full">${job.type}</span>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">${job.title}</h3>
                                <p class="text-blue-600 text-sm font-medium mt-1">${job.location}</p>
                                <div class="mt-4 space-y-2">
                                    ${job.salary_range ? `<p class="text-gray-600 text-sm flex items-center"><i class="fas fa-money-bill-wave mr-2 text-blue-500"></i>${job.salary_range}</p>` : ''}
                                </div>
                                <a href="#" data-job-id="${job.id}" class="job-detail-btn mt-6 inline-flex items-center font-semibold text-blue-600 hover:text-blue-700 group">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    `).join('');
                } catch (e) {
                    console.error(e);
                }
            }, 350);
        });
    }

    // --- Admin: toggle job active state ---
    document.querySelectorAll('[data-toggle-job]').forEach(btn => {
        btn.addEventListener('click', async (ev) => {
            const id = btn.getAttribute('data-toggle-job');
            try {
                const res = await window.axios.patch(`/admin/jobs/${id}/toggle-active`);
                const isActive = res.data.is_active;
                const stateSpan = document.querySelector(`[data-job-id-state="${id}"]`);
                if (stateSpan) {
                    stateSpan.innerHTML = isActive ? '<span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>' : '<span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Tidak Aktif</span>';
                }
            } catch (err) {
                console.error(err);
                alert('Gagal toggle status.');
            }
        });
    });

    // --- Lightbox for gallery images ---
    const lightbox = document.createElement('div');
    lightbox.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-6';
    lightbox.innerHTML = '<div class="max-w-4xl w-full"><img class="w-full rounded-lg shadow-lg" src="" alt="preview"><div class="text-right mt-4"><button class="px-4 py-2 bg-white rounded" id="lightbox-close">Close</button></div></div>';
    document.body.appendChild(lightbox);
    document.body.addEventListener('click', (e) => {
        const target = e.target.closest('.gallery-item img');
        if (target) {
            const img = lightbox.querySelector('img');
            img.src = target.src;
            lightbox.classList.remove('hidden');
        }
    });
    document.getElementById('lightbox-close')?.addEventListener('click', () => {
        lightbox.classList.add('hidden');
    });
});

export default revealObserver;
