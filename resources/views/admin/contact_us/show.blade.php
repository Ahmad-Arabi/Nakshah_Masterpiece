@extends('layouts.admin')

@section('title', 'View Message')
@section('style')
    <link rel="stylesheet" href="/css/admin.css">    <style>
        :root {
            --accent-color: #4422b2;
            --secondary: #121212;
            --light: #f8f9fa;
            --dark: #343a40;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --gray: #6c757de5;
            --background: #e8e8e8;
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08) !important;
            transition: transform 0.3s;
            border: none;
        }

        body {
            background-color: var(--background) !important;
        }

        .card-header {
            background-color: #0e74db;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
        }
        
        .card-title {
            color: var(--secondary);
            font-weight: 600;
        }
        
        .breadcrumb-item a {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
        
        .breadcrumb-item.active {
            color: var(--gray);
        }
        
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 4px;
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
            border: 1px solid #e9ecef;
        }
        
        .btn-outline-secondary {
            border-color: var(--gray);
            color: var(--gray);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--gray);
            color: #fff;
        }
        
        .btn-success {
            background-color: var(--success);
            border-color: var(--success);
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-danger {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-danger:hover {
            background-color: #e62e2e;
            border-color: #e01f1f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .modal-header.bg-danger {
            background-color: var(--accent-color) !important;
        }
        
        .message-content {
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 3px solid var(--accent-color);
            border-radius: 4px;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 5px;
        }
        
        .info-label i {
            color: var(--accent-color);
        }
        
        .info-value {
            color: var(--dark);
            margin-bottom: 15px;
        }
    </style>
@section('content')
<div class="container-fluid px-4">
    <div class="row my-4">
        <div class="col-12">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                <i class="bi bi-envelope me-2"></i> Message Details
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-12 mx-auto">
            <div class="card mb-4 border-0 shadow">                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">
                        <i class="bi bi-envelope-open me-2"></i>
                        Message from {{ $message->name }}
                    </h5>
                    <div>
                        <a href="{{ route('admin.contact-us.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Messages
                        </a>
                    </div>
                </div>
                <div class="card-body">                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="info-label"><i class="bi bi-person me-2"></i>Name:</p>
                            <p class="info-value">{{ $message->name ?? 'Not Provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="info-label"><i class="bi bi-envelope me-2"></i>Email:</p>
                            <p class="info-value">{{ $message->email ?? 'Not Provided' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="info-label"><i class="bi bi-chat-left-text me-2"></i>Subject:</p>
                            <p class="info-value">{{ $message->subject ?? 'Not Provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="info-label"><i class="bi bi-flag me-2"></i>Status:</p>
                            <p>
                                @if ($message->status === 'resolved')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Resolved</span>
                                @elseif($message->status === 'pending')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="info-label"><i class="bi bi-calendar-event me-2"></i>Received:</p>
                            <p class="info-value">{{ $message->created_at->format('F d, Y - h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($message->status === 'resolved')
                            <p class="info-label"><i class="bi bi-check-square me-2"></i>Resolved:</p>
                            <p class="info-value">{{ $message->updated_at->format('F d, Y - h:i A') }}</p>
                            @endif
                        </div>
                    </div>
                    <hr>                    <div class="row mb-4">
                        <div class="col-12">
                            <p class="info-label"><i class="bi bi-chat-quote me-2"></i>Message Content:</p>
                            <div class="message-content">
                                <p style="white-space: pre-line;">{{ $message->message }}</p>
                            </div>
                        </div>
                    </div>
                </div>                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i> 
                            Message ID: #{{ $message->id }}
                        </div>
                        <div class="d-flex gap-2">
                            @if ($message->status === 'pending')
                                <button type="button" class="btn btn-success resolve-action" 
                                    data-id="{{ $message->id }}" data-info="resolve"
                                    data-type="messages" data-bs-toggle="modal" data-bs-target="#actionModal">
                                    <i class="bi bi-check-circle me-1"></i> Mark as Resolved
                                </button>
                            @endif
                            <button type="button" class="btn btn-danger delete-action"
                                data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                data-id="{{ $message->id }}" data-type="messages">
                                <i class="bi bi-trash me-1"></i> Delete Message
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Are you sure you want to delete this message?</p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i> Cancel
                </button>
                <form id="deleteForm" action="{{ route('admin.contact-us.destroy', $message->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.contact_us.approve')
@endsection