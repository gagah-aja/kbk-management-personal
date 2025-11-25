                                 @if ($p->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->is_active)
                                                <form action="{{ route('admin.penghuni.destroy', $p->id) }}" method="POST"
                                                    class="form-hapus-penghuni">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        data-nama="{{ $p->warga->nama_lengkap }}" title="Hapus Penghuni">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Sudah keluar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- 📱 Mobile: Card View --}}
                    <div class="mobile-cards p-3">
                        @foreach ($penghuni as $index => $p)
                            <div class="penghuni-card">
                                <div class="penghuni-card-header">
                                    <div style="flex:1;">
                                        <h6 class="penghuni-nama">{{ $p->warga->nama_lengkap }}</h6>
                                        <div class="penghuni-nik">NIK: {{ $p->warga->nik }}</div>
                                    </div>
                                    @if ($p->is_active)
                                        <form action="{{ route('admin.penghuni.destroy', $p->id) }}" method="POST"
                                            class="form-hapus-penghuni">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                data-nama="{{ $p->warga->nama_lengkap }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="penghuni-detail">
                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Tipe</span>
                                        @if ($p->tipe_penghuni == 'Pemilik')
                                            <span class="badge-pemilik">🏠 Pemilik</span>
                                        @else
                                            <span class="badge-penyewa">🏘️ Penyewa</span>
                                        @endif
                                    </div>

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Status</span>
                                        @php
                                            $badgeClass = [
                                                'Kepala Keluarga' => 'badge-kk',
                                                'Istri' => 'badge-istri',
                                                'Suami' => 'badge-suami',
                                                'Anak' => 'badge-anak',
                                                'Orang Tua' => 'badge-ortu',
                                                'Keluarga Lainnya' => 'badge-lainnya',
                                            ];
                                        @endphp
                                        <span class="{{ $badgeClass[$p->status_penghuni] ?? 'badge-lainnya' }}">
                                            {{ $p->status_penghuni }}
                                        </span>
                                    </div>

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Jenis Kelamin</span>
                                        <span class="penghuni-detail-value">{{ $p->warga->jenis_kelamin }}</span>
                                    </div>

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Tanggal Masuk</span>
                                        <span class="penghuni-detail-value">{{ $p->tanggal_masuk->format('d/m/Y') }}</span>
                                    </div>

                                    @if ($p->tanggal_keluar)
                                        <div class="penghuni-detail-item">
                                            <span class="penghuni-detail-label">Tanggal Keluar</span>
                                            <span
                                                class="penghuni-detail-value">{{ $p->tanggal_keluar->format('d/m/Y') }}</span>
                                        </div>
                                    @endif

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Status</span>
                                        @if ($p->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Info Tambahan --}}
                    <div class="p-3 bg-light border-top">
                        <div class="row summary-stats">
                            <div class="col-md-3">
                                <strong>Total Penghuni:</strong> {{ $penghuni->count() }} orang
                            </div>
                            <div class="col-md-3">
                                <strong>Pemilik:</strong>
                                {{ $penghuni->where('is_active', true)->where('tipe_penghuni', 'Pemilik')->count() }} orang
                            </div>
                            <div class="col-md-3">
                                <strong>Penyewa:</strong>
                                {{ $penghuni->where('is_active', true)->where('tipe_penghuni', 'Penyewa')->count() }} orang
                            </div>
                            <div class="col-md-3">
                                <strong>Sudah Keluar:</strong> {{ $penghuni->where('is_active', false)->count() }} orang
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-people" style="font-size:3rem; color:#cbd5e1;"></i>
                        <h5 class="mt-3">Belum Ada Penghuni</h5>
                        <p class="text-muted">Mulai tambahkan penghuni untuk rumah ini</p>
                        <a href="{{ route('admin.rumah.penghuni.create', $rumah->id) }}" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Tambah Penghuni
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}'
                });
            @endif

            // Konfirmasi Hapus Penghuni
            document.querySelectorAll('.form-hapus-penghuni').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const nama = this.querySelector('button').dataset.nama;
                    Swal.fire({
                        title: 'Hapus Penghuni?',
                        html: `<strong>${nama}</strong> akan dihapus dari daftar penghuni rumah ini.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then(res => {
                        if (res.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>

@endsection
