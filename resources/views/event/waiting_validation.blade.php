<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    @if(isset($nomorTiket) && $nomorTiket)
                        {{-- Payment Validated - Success State --}}
                        <div class="text-center mb-8">
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Tervalidasi!</h2>
                            <p class="text-gray-600">Selamat! Pendaftaran event Anda telah berhasil divalidasi oleh admin.</p>
                        </div>

                        {{-- Ticket Information --}}
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-green-800 mb-1">Tiket Anda</h3>
                                    <p class="text-2xl font-bold text-green-700 tracking-wide">{{ $nomorTiket }}</p>
                                    <p class="text-sm text-green-600 mt-1">Simpan nomor tiket ini untuk keperluan check-in</p>
                                </div>
                                <div class="text-green-600">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Next Steps --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h4 class="font-semibold text-blue-800 mb-2">Langkah Selanjutnya:</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li class="flex items-start">
                                    <span class="inline-block w-2 h-2 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    Screenshot atau catat nomor tiket Anda
                                </li>
                                <li class="flex items-start">
                                    <span class="inline-block w-2 h-2 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    Tunjukkan nomor tiket saat check-in event
                                </li>
                                <li class="flex items-start">
                                    <span class="inline-block w-2 h-2 bg-blue-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    Datang 15 menit sebelum event dimulai
                                </li>
                            </ul>
                        </div>

                    @else
                        {{-- Payment Pending - Waiting State --}}
                        <div class="text-center mb-8">
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                                <svg class="h-8 w-8 text-yellow-600 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Menunggu Validasi</h2>
                            <p class="text-gray-600">Bukti pembayaran Anda sedang diproses oleh tim admin.</p>
                        </div>

                        {{-- Status Information --}}
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-6 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-yellow-600 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-yellow-800 mb-1">📋 Status Pendaftaran</h3>
                                    <p class="text-yellow-700 mb-2">Bukti pembayaran Anda telah berhasil dikirim dan sedang dalam proses validasi.</p>
                                    <div class="flex items-center text-sm text-yellow-600">
                                        <div class="flex items-center space-x-1">
                                            <span>Estimasi validasi: 1-24 jam</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        @if(isset($nomorTiket) && $nomorTiket)
                            {{-- Success State Buttons --}}
                            <button onclick="downloadTicket()" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium transition">
                                Download Tiket
                            </button>
                            <button onclick="copyTicketNumber()" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-medium transition">
                                Copy Nomor Tiket
                            </button>
                        @else
                            {{-- Waiting State Buttons --}}
                            <button onclick="window.location.reload()" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-200 font-medium transition">
                                Refresh Status
                            </button>
                        @endif
                        
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring-4 focus:ring-gray-200 font-medium transition">
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Copy ticket number to clipboard
        function copyTicketNumber() {
            @if(isset($nomorTiket) && $nomorTiket)
                const ticketNumber = '{{ $nomorTiket }}';
                navigator.clipboard.writeText(ticketNumber).then(function() {
                    showNotification('Nomor tiket berhasil disalin!', 'success');
                }, function() {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = ticketNumber;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    showNotification('Nomor tiket berhasil disalin!', 'success');
                });
            @endif
        }

        // Download ticket as image/PDF
        function downloadTicket() {
            @if(isset($nomorTiket) && $nomorTiket)
                // Create a simple ticket image
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                canvas.width = 800;
                canvas.height = 400;
                
                // Background
                ctx.fillStyle = '#f0f9ff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Border
                ctx.strokeStyle = '#3b82f6';
                ctx.lineWidth = 4;
                ctx.strokeRect(10, 10, canvas.width - 20, canvas.height - 20);
                
                // Title
                ctx.fillStyle = '#1e40af';
                ctx.font = 'bold 36px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('EVENT TICKET', canvas.width / 2, 80);
                
                // Ticket Number
                ctx.fillStyle = '#059669';
                ctx.font = 'bold 48px Arial';
                ctx.fillText('{{ $nomorTiket }}', canvas.width / 2, 180);
                
                // Instructions
                ctx.fillStyle = '#374151';
                ctx.font = '20px Arial';
                ctx.fillText('Tunjukkan tiket ini saat check-in event', canvas.width / 2, 240);
                ctx.fillText('Simpan gambar ini sebagai bukti pendaftaran', canvas.width / 2, 270);
                
                // Date
                ctx.fillStyle = '#6b7280';
                ctx.font = '16px Arial';
                ctx.fillText('Diterbitkan: ' + new Date().toLocaleDateString('id-ID'), canvas.width / 2, 320);
                
                // Download
                const link = document.createElement('a');
                link.download = 'tiket-{{ $nomorTiket }}.png';
                link.href = canvas.toDataURL();
                link.click();
                
                showNotification('Tiket berhasil didownload!', 'success');
            @endif
        }

        // Show notification
        function showNotification(message, type = 'info') {
            // Remove existing notification
            const existing = document.querySelector('.notification-toast');
            if (existing) existing.remove();

            const notification = document.createElement('div');
            notification.className = `notification-toast fixed top-4 right-4 max-w-sm p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full`;
            
            if (type === 'success') {
                notification.classList.add('bg-green-500', 'text-white');
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
            } else {
                notification.classList.add('bg-blue-500', 'text-white');
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
            }

            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto hide
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Auto refresh every 30 seconds if waiting
        @if(!isset($nomorTiket) || !$nomorTiket)
            let refreshInterval = setInterval(function() {
                window.location.reload();
            }, 30000); // 30 seconds

            // Stop auto refresh when user becomes inactive
            let lastActivity = Date.now();
            
            document.addEventListener('mousemove', () => lastActivity = Date.now());
            document.addEventListener('keypress', () => lastActivity = Date.now());
            
            setInterval(function() {
                if (Date.now() - lastActivity > 300000) { // 5 minutes
                    clearInterval(refreshInterval);
                }
            }, 60000);
        @endif
    </script>
</x-app-layout>