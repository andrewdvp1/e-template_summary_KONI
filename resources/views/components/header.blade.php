@props(['breadcrumb' => null, 'title' => null])
<header class="h-16 flex items-center justify-between px-6 bg-white dark:bg-[#1a2233] border-b border-[#e7ebf3] dark:border-gray-800 shrink-0">
    <div class="flex items-center gap-4 flex-1">
        @if($breadcrumb)
            <x-breadcrumb :items="$breadcrumb" />
        @else
            <h2 class="text-xl font-bold text-[#0f172a] dark:text-white">{{ $title }}</h2>
        @endif
    </div>
    <div class="flex items-center gap-4">
        <div class="hidden md:flex items-center h-10 bg-gray-50 dark:bg-gray-800 rounded-lg px-4 gap-3 border border-gray-200 dark:border-gray-700">
            <span class="material-symbols-outlined text-black-500 text-[20px]">calendar_today</span>
            <div class="flex items-center gap-2 text-sm">
                <span id="currentDate" class="text-slate-700 dark:text-slate-300 font-medium"></span>
                <span class="text-slate-300 dark:text-slate-600">|</span>
                <span id="currentTime" class="text-slate-900 dark:text-white font-bold"></span>
            </div>
        </div>
        <script>
            function updateDateTime() {
                const now = new Date();
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                
                const dayName = days[now.getDay()];
                const date = now.getDate();
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                
                document.getElementById('currentDate').textContent = `${dayName}, ${date} ${month} ${year}`;
                document.getElementById('currentTime').textContent = `${hours}:${minutes}`;
            }
            
            updateDateTime();
            setInterval(updateDateTime, 1000);
        </script>
    </div>
</header>