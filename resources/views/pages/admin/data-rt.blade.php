@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">📋 Data RT</h2>

    {{-- Tombol Tambah RT --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i> Tambah RT
    </button>

    {{-- Tabel Data RT --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor RT</th>
                        <th>Nama RT (Warga)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataRT as $index => $rt)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rt->nomor_rt }}</td>
                        <td>{{ $rt->warga->nama_lengkap ?? '-' }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $rt->id }}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>

                            {{-- Delete Form --}}
                            <form action="{{ route('admin.data-rt.destroy', $rt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus RT ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Edit RT --}}
                    <div class="modal fade" id="modalEdit{{ $rt->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $rt->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <form action="{{ route('admin.data-rt.update', $rt->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalEditLabel{{ $rt->id }}">Edit RT</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label class="form-label">Nomor RT</label>
                                      <input type="text" name="nomor_rt" value="{{ $rt->nomor_rt }}" class="form-control" required>
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Nama RT (Warga)</label>
                                      <select name="id_warga" class="form-select" required>
                                          <option value="" disabled>Pilih Warga</option>
                                          @foreach($warga as $w)
                                              <option value="{{ $w->id }}" {{ $rt->id_warga == $w->id ? 'selected' : '' }}>
                                                  {{ $w->nama_lengkap }}
                                              </option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">RW</label>
                                      <select name="id_rw" class="form-select" required>
                                          <option value="" disabled>Pilih RW</option>
                                          @foreach($rwList as $rw)
                                              <option value="{{ $rw->id }}" {{ $rt->id_rw == $rw->id ? 'selected' : '' }}>
                                                  {{ $rw->id }}
                                              </option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                              </div>
                            </div>
                        </form>
                      </div>
                    </div>

                    @endforeach

                    @if(count($dataRT) == 0)
                    <tr>
                        <td colspan="4" class="text-center">Data RT belum tersedia.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah RT --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.data-rt.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahLabel">Tambah RT</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Nomor RT</label>
                  <input type="text" name="nomor_rt" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Nama RT (Warga)</label>
                  <select name="id_warga" class="form-select" required>
                      <option value="" selected disabled>Pilih Warga</option>
                      @foreach($warga as $w)
                          <option value="{{ $w->id }}">{{ $w->nama_lengkap }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="mb-3">
                  <label class="form-label">RW</label>
                  <select name="id_rw" class="form-select" required>
                      <option value="" selected disabled>Pilih RW</option>
                      @foreach($rwList as $rw)
                          <option value="{{ $rw->id }}">{{ $rw->id }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endsection
    