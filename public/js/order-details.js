document.addEventListener('DOMContentLoaded', function() {
    const orderItems = document.querySelectorAll('.order-item');
    const orderDetailsModal = new bootstrap.Modal(document.getElementById('order-details-modal'));
    const orderDetailsContent = document.getElementById('order-details-content');
    
    orderItems.forEach(item => {
        item.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            // Show loading indicator
            orderDetailsContent.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border" style="color: var(--accent);" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading order details...</p>
                </div>
            `;
            orderDetailsModal.show();
            
            // Fetch order details via AJAX
            fetch(`/orders/${orderId}/details`)
                .then(response => response.json())
                .then(data => {
                    // Fill the modal with order details
                    let itemsHtml = '';
                    data.items.forEach(item => {
                        // Ensure price is a number
                        const itemPrice = parseFloat(item.price);
                        const itemTotal = parseFloat(item.total);
                          // Check for custom options
                        const hasCustomText = item.options.custom_text && item.options.custom_text.trim() !== '';
                        const hasCustomImage = item.options.custom_image && item.options.custom_image.trim() !== '';
                        
                        itemsHtml += `
                            <div class="border-bottom py-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-sm-3 mb-2 mb-md-0">
                                        <img src="${item.thumbnail}" alt="${item.product_name}" class="img-fluid rounded" style="max-height: 60px;">
                                    </div>
                                    <div class="col-md-6 col-sm-9 mb-2 mb-md-0">
                                        <h6 class="mb-0">${item.product_name}</h6>
                                        <div class="mt-1 small text-muted">
                                            ${item.options.size ? `<span class="me-2">Size: ${item.options.size}</span>` : ''}
                                            ${item.options.color ? `<span class="me-2">Color: ${item.options.color}</span>` : ''}
                                            ${hasCustomText ? `<div class="mt-1">Custom Text: ${item.options.custom_text}</div>` : ''}
                                        </div>
                                        ${hasCustomImage ? `
                                        <div class="custom-image-container ">
                                            <span class="small text-muted">Custom Design:</span>
                                            <img src="${item.options.custom_image}" alt="Custom Design" class="img-fluid rounded mt-1" style="max-height: 60px; border: 1px solid #ddd;">
                                        </div>` : ''}
                                    </div>
                                    <div class="col-md-2 col-6 text-md-center">
                                        <span class="small text-muted d-block">Quantity:</span>
                                        <span>${item.quantity}</span>
                                    </div>
                                    <div class="col-md-2 col-6 text-end">
                                        <span class="small text-muted d-block d-md-none">Price:</span>
                                        <span class="fw-medium">${itemTotal.toFixed(2)} JOD</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    // Ensure all monetary values are numbers
                    const subtotal = parseFloat(data.order.subtotal);
                    const shipping = data.order.shipping_fees;
                    const discount = parseFloat(data.order.discount || 0);
                    const total = parseFloat(data.order.total_price);
                    
                    // Get payment method and status
                    const paymentMethod = data.order.payment_method || 'Cash on Delivery';
                    
                    let statusBadgeClass = '';
                    switch(data.order.status.toLowerCase()) {
                        case 'delivered':
                            statusBadgeClass = 'bg-success';
                            break;
                        case 'processing':
                            statusBadgeClass = 'bg-primary';
                            break;
                        case 'shipped':
                            statusBadgeClass = 'bg-warning text-dark';
                            break;
                        case 'pending':
                            statusBadgeClass = 'bg-info';
                            break;
                        default:
                            statusBadgeClass = 'bg-secondary';
                    }

                    
                    orderDetailsContent.innerHTML = `
                        <div class="border-bottom pb-3 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <h6 class="fw-bold" style="color: var(--accent);">Order #${data.order.id}</h6>
                                    <p class="text-muted mb-0">Placed on ${data.order.date}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge ${statusBadgeClass} me-2">${data.order.status}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="small fw-bold">Delivery Address</h6>
                                    <p class="small mb-0">${data.order.delivery_address || 'No address provided'}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="small fw-bold">Payment Information</h6>
                                    <p class="small mb-0">Method: ${paymentMethod}</p>
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="fw-medium mb-3" style="color: var(--accent);">Order Items</h6>
                        <div class="mb-4">
                            ${itemsHtml}
                        </div>
                        
                        <div class="border-top pt-3 mt-3">
                            <div class="row mb-1">
                                <div class="col-6">
                                    <span class="text-muted">Subtotal</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span>${subtotal.toFixed(2)} JOD</span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <span class="text-muted">Shipping</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span>${shipping}</span>
                                </div>
                            </div>
                            ${discount > 0 ? `
                            <div class="row mb-1">
                                <div class="col-6">
                                    <span class="text-muted">Discount</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-success">-${discount.toFixed(2)} JOD</span>
                                </div>
                            </div>
                            ` : ''}
                            <div class="row mt-2 pt-2 border-top">
                                <div class="col-6">
                                    <span class="fw-bold" style="color: var(--accent);">Total</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-bold" style="color: var(--accent);">${total.toFixed(2)} JOD</span>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    orderDetailsContent.innerHTML = '<div class="alert alert-danger">Error loading order details. Please try again.</div>';
                });
        });
    });
});
