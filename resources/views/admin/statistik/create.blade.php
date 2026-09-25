@extends('layouts.app', ['title' => 'Create Statistik'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-plus-circle"></i> CREATE STATISTIK
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.statistik.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PENGGUNA <span class="text-danger">*</span></label>
                                    <input type="number" name="pengguna" value="{{ old('pengguna') }}"
                                           class="form-control @error('pengguna') is-invalid @enderror">
                                    @error('pengguna')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ASSESMEN <span class="text-danger">*</span></label>
                                    <input type="number" name="assesmen" value="{{ old('assesmen') }}"
                                           class="form-control @error('assesmen') is-invalid @enderror">
                                    @error('assesmen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PSIKOLOGI <span class="text-danger">*</span></label>
                                    <input type="number" name="psikologi" value="{{ old('psikologi') }}"
                                           class="form-control @error('psikologi') is-invalid @enderror">
                                    @error('psikologi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>KONSELOR <span class="text-danger">*</span></label>
                                    <input type="number" name="konselor" value="{{ old('konselor') }}"
                                           class="form-control @error('konselor') is-invalid @enderror">
                                    @error('konselor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> SAVE
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-redo"></i> RESET
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
