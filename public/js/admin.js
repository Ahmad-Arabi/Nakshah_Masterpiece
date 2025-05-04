"use strict";

//timeout for alert
setTimeout(function () {
    let alertElement = document.querySelector(".alertDelete");
    if (alertElement) {
        alertElement.classList.remove("show"); // Hide it
        alertElement.classList.add("fade"); // Add fade effect
        setTimeout(() => {
            alertElement.remove(); // Remove it from the DOM completely
        }, 500); // Allow some time for fade-out animation before removal (300ms)
    }
}, 3000); // Trigger the hiding process after 3 seconds

//edit form for users
document.addEventListener("click", function (e) {
    // Check if the clicked element has the class "edit-user-link"
    if (e.target.classList.contains("edit-user-link")) {
        e.preventDefault();

        // Get the user ID from the data-id attribute
        var userId = e.target.getAttribute("data-id");

        // Make an AJAX request to fetch the modal content
        fetch("/admin/users/" + userId + "/edit", {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error("Failed to fetch modal content.");
                }
                return response.json();
            })
            .then(function (data) {
                // Inject the modal content into the container
                var modalContainer = document.getElementById(
                    "ajaxEditModalContainer"
                );
                modalContainer.innerHTML = data.html;

                // Show the modal using Bootstrap's modal API
                var editModal = new bootstrap.Modal(
                    document.getElementById("editUserModal")
                );
                editModal.show();
            })
            .catch(function (error) {
                console.error("Error fetching modal content:", error);
            });
    }
});

//edit form for coupons
document.addEventListener("click", function (e) {
    // Check if the clicked element has the class "edit-coupon-link"
    if (e.target.classList.contains("edit-coupon-link")) {
        e.preventDefault();

        // Get the coupon ID from the data-id attribute
        var couponId = e.target.getAttribute("data-id");

        // Make an AJAX request to fetch the modal content
        fetch("/admin/coupons/" + couponId + "/edit", {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error("Failed to fetch modal content.");
                }
                return response.json();
            })
            .then(function (data) {
                // Inject the modal content into the container
                var modalContainer = document.getElementById(
                    "ajaxEditModalCoupon"
                );
                modalContainer.innerHTML = data.html;

                // Show the modal using Bootstrap's modal API
                var editModal = new bootstrap.Modal(
                    document.getElementById("editCouponModal")
                );
                editModal.show();
            })
            .catch(function (error) {
                console.error("Error fetching modal content:", error);
            });
    }
});

//edit form for categeories
document.addEventListener("click", function (e) {
    // Check if the clicked element has the class "edit-category-link"
    if (e.target.classList.contains("edit-category-link")) {
        e.preventDefault();

        // Get the category ID from the data-id attribute
        var categoryId = e.target.getAttribute("data-id");
        // Make an AJAX request to fetch the modal content
        fetch("/admin/categories/" + categoryId + "/edit", {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error("Failed to fetch modal content.");
                }
                return response.json();
            })
            .then(function (data) {
                // Inject the modal content into the container
                var modalContainer = document.getElementById(
                    "ajaxEditModalCategory"
                );
                modalContainer.innerHTML = data.html;
                // Show the modal using Bootstrap's modal API
                var editModal = new bootstrap.Modal(
                    document.getElementById("editCategoryModal")
                );
                editModal.show();
            })
            .catch(function (error) {
                console.error("Error fetching modal content:", error);
            });
    }
});

//edit form for products
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("edit-product-link")) {
        e.preventDefault();

        var productId = e.target.getAttribute("data-id");

        fetch("/admin/products/" + productId + "/edit", {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error("Failed to fetch modal content.");
            }
            return response.json();
        })
        .then(function (data) {
            var modalContainer = document.getElementById("ajaxEditModalProduct");
            modalContainer.innerHTML = data.html;

            var editModal = new bootstrap.Modal(document.getElementById("editProductModal"));
            editModal.show();

            //  Attach listeners ONLY after modal is loaded via AJAX
            setTimeout(() => {
                const modal = document.getElementById("editProductModal"); // Ensure modal exists
                attachSizeListeners(modal);
            }, 300);
        })
        .catch(function (error) {
            console.error("Error fetching modal content:", error);
        });
    }
});

//edit form for orders
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("edit-order-link")) {
        e.preventDefault();

        var orderId = e.target.getAttribute("data-id");

        fetch("/admin/orders/" + orderId + "/edit", {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error("Failed to fetch modal content.");
            }
            return response.json();
        })
        .then(function (data) {
            var modalContainer = document.getElementById("ajaxEditModalOrder");
            modalContainer.innerHTML = data.html;

            var editModal = new bootstrap.Modal(document.getElementById("editOrderModal"));
            editModal.show();

            //  Attach listeners ONLY after modal is loaded via AJAX
            setTimeout(() => {
                const modal = document.getElementById("editOrderModal"); // Ensure modal exists
                attachSizeListeners(modal);
            }, 300);
        })
        .catch(function (error) {
            console.error("Error fetching modal content:", error);
        });
    }
});

function attachSizeListeners(modal) {
    const container = modal.querySelector("#sizesContainer");
    const addSizeButton = modal.querySelector(".add-size");

    if (!container || !addSizeButton) {
        console.error("sizesContainer or add-size button not found inside the correct modal.");
        return;
    }

    // ✅Remove any old event listeners before attaching a new one
    addSizeButton.replaceWith(addSizeButton.cloneNode(true));
    const newAddSizeButton = modal.querySelector(".add-size");

    newAddSizeButton.addEventListener("click", function () {
        const index = container.children.length;
        const newSize = `
            <div class="input-group mb-2">
                <input type="text" name="sizes[${index}][size]" class="form-control" placeholder="Size (e.g., S, M, L)" required>
                <input type="number" name="sizes[${index}][stock]" class="form-control" placeholder="Stock" required>
                <button type="button" class="btn btn-danger remove-size">Remove</button>
            </div>`;
        container.insertAdjacentHTML("beforeend", newSize);

    });

    container.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-size")) {
            event.target.closest(".input-group").remove();
            console.log(` Size removed. Remaining count:`, container.children.length);
        }
    });


}

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-size")) {
            const modal = event.target.closest(".modal"); // Detect active modal
            const container = modal.querySelector("#sizesContainer"); // Get size container inside the correct modal
            
            event.target.closest(".input-group").remove();
        }
    });


    document.addEventListener("DOMContentLoaded", function () {
        const spinner = document.getElementById("spinner");
        const tableContainer = document.querySelector(".table-responsive");
        const tableBody = document.querySelector(".dynamic-table-body"); // Ensure correct selector
        const paginationContainer = document.getElementById("paginationLinks");
    
        // Initial load visibility
        setTimeout(() => {
            spinner.style.display = "none";
            tableContainer.style.display = "block";
        }, 1500);
    
        // Debounce function to limit excessive requests
        function debounce(func, delay) {
            let timer;
            return function (...args) {
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(this, args), delay);
            };
        }
    
        // Filter event listeners
        document.querySelectorAll(".table-filter").forEach((input) => {
            input.addEventListener("input", debounce(function () {
                fetchFilteredData();
            }, 1000)); // ✅ Reduces excessive updates
        });
    
        // Pagination Handling with Filters (Fixed duplicate event issue)
        document.addEventListener("click", function (e) {
            if (e.target.tagName === "A" && e.target.closest("#paginationLinks")) {
                e.preventDefault();
                let url = new URL(e.target.href);
                let params = new URLSearchParams(url.search);
    
                // Retain filters when paginating
                document.querySelectorAll(".table-filter").forEach((input) => {
                    if (input.value.trim()) {
                        params.set(input.dataset.filter, input.value.trim());
                    }
                });
    
                // ✅ Introduce delay before fetching the new page data
                spinner.style.display = "block";
                tableContainer.style.opacity = "0.5";
    
                setTimeout(() => {
                    fetchFilteredData(`${url.pathname}?${params.toString()}`);
                }, 900); // ✅ Adjust delay (milliseconds)
            }
        });
    
        function fetchFilteredData(url = window.location.href) {
            let params = new URLSearchParams(url.includes("?") ? url.split("?")[1] : "");
    
            // Collect filters dynamically
            document.querySelectorAll(".table-filter").forEach((input) => {
                if (input.value.trim()) {
                    params.set(input.dataset.filter, input.value.trim());
                }
            });
    
            url = `${window.location.pathname}?${params.toString()}`;
    
            // Show spinner, hide table content
            spinner.style.display = "block";
            tableContainer.style.opacity = "0.5";
    
            fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
                .then((response) => {
                    if (!response.ok) throw new Error("Failed to fetch data");
                    return response.text();
                })
                .then((html) => {
                    const parsedHTML = new DOMParser().parseFromString(html, "text/html");
    
                    // ✅ Ensure table rows update correctly
                    const newTableBody = parsedHTML.querySelector(".dynamic-table-body")?.innerHTML;
                    const newPagination = parsedHTML.querySelector("#paginationLinks")?.innerHTML;
    
                    if (newTableBody) {
                        tableBody.innerHTML = newTableBody; // ✅ Replace only rows
                    }
    
                    if (newPagination) {
                        paginationContainer.innerHTML = newPagination; // ✅ Update pagination
                    }
    
                    spinner.style.display = "none";
                    tableContainer.style.opacity = "1"; // ✅ Restore table visibility
                })
                .catch((error) => {
                    spinner.style.display = "none";
                    tableContainer.style.opacity = "1"; // ✅ Ensure table shows if error occurs
                    console.error(error);
                });
        }
    });

// Handle the form confirmation on delete 
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-action").forEach(button => {
        button.addEventListener("click", function () {
            const dataId = this.dataset.id; // Get review ID from button
            const dataType = this.dataset.type; // Get review type from button
            const deleteForm = document.getElementById("deleteForm");

            if (deleteForm) {
                deleteForm.action = `/admin/${dataType}/${dataId}`; // Set action dynamically
            }
        });
    });
});


// Handle the form confirmation on approve/reject for reviews
document.addEventListener("DOMContentLoaded", function () {
    const actionModal = document.getElementById("actionModal");

 
    document.addEventListener("click", function (event) {
        const button = event.target.closest("button"); 
        if (!button) return;

        if (button.classList.contains("approve-action") || button.classList.contains("reject-action")) {
            const reviewId = button.getAttribute("data-id");
            const actionType = button.getAttribute("data-info");

            if (!reviewId || !actionType) {
                console.error("Missing data attributes on button.");
                return;
            }

            const modalReviewId = document.getElementById("modalReviewId");
            const modalActionType = document.getElementById("modalActionType");
            const actionText = document.getElementById("actionText");
            const buttonText = document.getElementById("buttonText");
            const modalMessage = document.getElementById("modalMessage");
            const actionForm = document.getElementById("actionForm");

            if (modalReviewId && modalActionType && actionText && buttonText && modalMessage && actionForm) {
                modalReviewId.value = reviewId;
                modalActionType.value = actionType;
                actionText.innerText = actionType === "approve" ? "Approve" : "Reject";
                buttonText.innerText = actionType === "approve" ? "Approve" : "Reject";
                modalMessage.innerText = `Are you sure you want to ${actionType} this review?`;
                actionForm.action = `/admin/reviews/${reviewId}/${actionType}`;
            } else {
                console.error(" One or more modal elements are missing.");
            }
        }
    });


});
// <!-- Sidebar Toggle Script -->

// document.addEventListener('DOMContentLoaded', function() {
//     const sidebarCollapse = document.getElementById('sidebarCollapse');
//     const sidebar = document.getElementById('sidebar');
//     const content = document.getElementById('content');

//     sidebarCollapse.addEventListener('click', function() {
//         sidebar.classList.toggle('active');
//         if (sidebar.classList.contains('active')) {
//             content.style.marginLeft = '280px';
//             content.style.width = 'calc(100% - 280px)';
//         } else {
//             content.style.marginLeft = '0';
//             content.style.width = '100%';
//         }
//     });

//     // Check window size on load and resize
//     function checkSize() {
//         if (window.innerWidth <= 768) {
//             sidebar.classList.remove('active');
//             content.style.marginLeft = '0';
//             content.style.width = '100%';
//         } else {
//             sidebar.classList.add('active');
//             content.style.marginLeft = '280px';
//             content.style.width = 'calc(100% - 280px)';
//         }
//     }

//     // Initial check
//     checkSize();

//     // Listen for window resize
//     window.addEventListener('resize', checkSize);

//     // Make sure all tables are wrapped in table-responsive
//     document.querySelectorAll('table').forEach(function(table) {
//         if (!table.parentElement.classList.contains('table-responsive')) {
//             const wrapper = document.createElement('div');
//             wrapper.classList.add('table-responsive');
//             table.parentNode.insertBefore(wrapper, table);
//             wrapper.appendChild(table);
//         }
//     });
// });

