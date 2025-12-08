@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-primary fw-bold display-6">Registered Service Units</h1>
            
                <a href="{{ route('units.create') }}" class="btn btn-primary shadow-lg px-4 py-2 rounded-pill">
                    <i class="fas fa-plus-circle me-2"></i> Register New Unit
                </a>
            </div>
            
            <!-- Success Message Display -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-xl border-0">
                <div class="card-header bg-gradient-info text-white fw-bold py-3 rounded-top-lg">
                    <h5 class="mb-0 text-white">List of All Complaint Handling Units</h5>
                </div>
                
                <div class="card-body p-0">
                    @if ($units->isEmpty())
                        <div class="alert alert-warning m-4 text-center border-0 bg-light-warning shadow-sm">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Currently, no units have been registered in the system. Please click the "Register New Unit" button to add service units.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-light text-muted text-uppercase small">
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 25%;">Unit Name (Amharic)</th>
                                        <th style="width: 25%;">Unit Name (English)</th>
                                        <th style="width: 15%;">Code</th>
                                        <th style="width: 20%;">Contact Email</th>
                                        <th style="width: 10%;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr>
                                            <td class="text-center fw-bold">{{ $unit->id }}</td>
                                            <td>{{ $unit->name_am }}</td>
                                            <td>{{ $unit->name_en }}</td>
                                            <td class="fw-bold text-primary">{{ $unit->code }}</td>
                                            <td><a href="mailto:{{ $unit->email }}" class="text-decoration-none">{{ $unit->email }}</a></td>
                                            <td class="text-center">
                                                <!-- Edit Button (Updated Link) -->
                                                <a href="{{ route('units.edit', $unit) }}" class="btn btn-sm btn-info text-white me-1 rounded-circle shadow-sm" title="Edit Unit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <!-- Delete Form (Added Form for DELETE method) -->
                                                <form action="{{ route('units.destroy', $unit) }}" method="POST" class="d-inline-block" 
                                                      onsubmit="return confirm('Are you sure you want to delete the unit: {{ $unit->name_en }}? This action is irreversible and may delete associated users.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow-sm" title="Delete Unit">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                
                <!-- Card Footer for future pagination -->
                <div class="card-footer text-muted text-center small py-3">
                    Displaying {{ $units->count() }} out of {{ $units->count() }} total units.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection