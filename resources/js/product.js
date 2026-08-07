(function() {
    'use strict';

    // ==============================
    // Dropzone (Drag & Drop Upload)
    // ==============================

    function initDropzone() {
        var dropzones = document.querySelectorAll('.product-dropzone');

        dropzones.forEach(function(dz) {
            var fileInput = dz.querySelector('input[type="file"]') ||
                document.getElementById('fileInput-' + dz.dataset.name);
            if (!fileInput) return;

            var wrapper = dz.closest('.product-dropzone-wrapper') || dz.parentElement;

            dz.addEventListener('click', function(e) {
                if (e.target.closest('.product-image-item') ||
                    e.target.closest('.image-actions')) return;
                fileInput.click();
            });

            fileInput.addEventListener('change', function() {
                handleFiles(this.files, dz);
            });

            dz.addEventListener('dragover', function(e) {
                e.preventDefault(); e.stopPropagation();
                dz.classList.add('drag-over');
            });

            dz.addEventListener('dragleave', function(e) {
                e.preventDefault(); e.stopPropagation();
                dz.classList.remove('drag-over');
            });

            dz.addEventListener('drop', function(e) {
                e.preventDefault(); e.stopPropagation();
                dz.classList.remove('drag-over');
                var files = e.dataTransfer.files;
                if (files.length > 0) handleFiles(files, dz);
            });
        });
    }

    function handleFiles(files, dz) {
        var preview = dz.querySelector('.dropzone-preview') ||
            dz.querySelector('#preview-' + dz.dataset.name);
        if (!preview) return;

        var isMultiple = dz.dataset.multiple !== 'false';
        if (!isMultiple) preview.innerHTML = '';

        var fileInput = document.getElementById('fileInput-' + dz.dataset.name);
        var dt = new DataTransfer();

        if (fileInput && fileInput.files) {
            for (var i = 0; i < fileInput.files.length; i++) {
                dt.items.add(fileInput.files[i]);
            }
        }

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.match('image.*')) continue;

            if (!isMultiple && i === 0) {
                dt.items.clear();
                var existing = preview.querySelectorAll('.product-image-item');
                existing.forEach(function(el) { el.remove(); });
            }

            dt.items.add(file);

            var reader = new FileReader();
            reader.onload = (function(f) {
                return function(e) {
                    var col = document.createElement('div');
                    col.className = 'col-auto';

                    var item = document.createElement('div');
                    item.className = 'product-image-item';
                    item.dataset.file = f.name;

                    var img = document.createElement('img');
                    img.src = e.target.result;

                    var actions = document.createElement('div');
                    actions.className = 'image-actions';

                    var removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-danger remove-image';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.addEventListener('click', function() {
                        col.remove();
                        updateFileInput(fileInput, preview);
                    });

                    actions.appendChild(removeBtn);
                    item.appendChild(img);
                    item.appendChild(actions);
                    col.appendChild(item);
                    preview.appendChild(col);
                };
            })(file);

            reader.readAsDataURL(file);
        }

        if (fileInput) fileInput.files = dt.files;
    }

    function updateFileInput(fileInput, preview) {
        var dt = new DataTransfer();
        if (fileInput && fileInput.files) {
            var fileNames = [];
            preview.querySelectorAll('.product-image-item[data-file]').forEach(function(el) {
                fileNames.push(el.dataset.file);
            });
            for (var i = 0; i < fileInput.files.length; i++) {
                if (fileNames.indexOf(fileInput.files[i].name) !== -1) {
                    dt.items.add(fileInput.files[i]);
                }
            }
            fileInput.files = dt.files;
        }
    }

    // ==============================
    // Image Reorder (Drag & Drop)
    // ==============================

    function initImageReorder() {
        var previews = document.querySelectorAll('.dropzone-preview');

        previews.forEach(function(container) {
            var items = container.querySelectorAll('.product-image-item');
            var dragSrcEl = null;

            function handleDragStart(e) {
                dragSrcEl = this;
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', this.outerHTML);
            }

            function handleDragOver(e) {
                if (e.preventDefault) e.preventDefault();
                this.classList.add('drag-over-me');
                e.dataTransfer.dropEffect = 'move';
                return false;
            }

            function handleDragLeave(e) {
                this.classList.remove('drag-over-me');
            }

            function handleDrop(e) {
                e.stopPropagation();
                if (dragSrcEl !== this) {
                    var parent = this.parentNode;
                    var items = parent.querySelectorAll('.product-image-item');
                    var dragIndex = Array.from(items).indexOf(dragSrcEl);
                    var dropIndex = Array.from(items).indexOf(this);

                    if (dragIndex < dropIndex) {
                        this.parentNode.insertBefore(dragSrcEl, this.nextSibling);
                    } else {
                        this.parentNode.insertBefore(dragSrcEl, this);
                    }
                    updateSortOrder(container);
                }
                this.classList.remove('drag-over-me');
                return false;
            }

            function handleDragEnd(e) {
                this.classList.remove('dragging');
                items.forEach(function(item) {
                    item.classList.remove('drag-over-me');
                });
            }

            items.forEach(function(item) {
                item.setAttribute('draggable', 'true');
                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragover', handleDragOver);
                item.addEventListener('dragleave', handleDragLeave);
                item.addEventListener('drop', handleDrop);
                item.addEventListener('dragend', handleDragEnd);
            });
        });
    }

    function updateSortOrder(container) {
        var items = container.querySelectorAll('.product-image-item');
        items.forEach(function(item, index) {
            var sortInput = item.querySelector('input[name*="[sort_order]"]');
            if (sortInput) sortInput.value = index;
        });
    }

    // ==============================
    // Variant Add / Remove
    // ==============================

    function initVariants() {
        var addBtn = document.getElementById('addVariantBtn');
        var container = document.getElementById('variantsContainer');
        var noMsg = document.getElementById('noVariantsMsg');

        if (!addBtn || !container) return;

        container.addEventListener('click', function(e) {
            var btn = e.target.closest('.remove-variant');
            if (btn) {
                var row = btn.closest('.variant-item');
                if (row) {
                    row.remove();
                    updateVariantNumbers();
                    toggleNoVariantsMsg();
                }
            }
        });

        addBtn.addEventListener('click', function() {
            var index = container.querySelectorAll('.variant-item').length;
            addVariantRow(index);
            toggleNoVariantsMsg();
        });

        if (container.querySelectorAll('.variant-item').length > 0) {
            noMsg.style.display = 'none';
        }
    }

    function addVariantRow(index) {
        var container = document.getElementById('variantsContainer');
        if (!container) return;

        var template = document.createElement('div');
        template.className = 'variant-row card mb-2 variant-item';
        template.dataset.index = index;
        template.innerHTML =
            '<div class="card-body py-2">' +
            '    <div class="d-flex align-items-center justify-content-between mb-2">' +
            '        <span class="fw-semibold variant-number">Variant #' + (index + 1) + '</span>' +
            '        <button type="button" class="btn btn-sm btn-outline-danger remove-variant">' +
            '            <i class="fas fa-times"></i> Remove' +
            '        </button>' +
            '    </div>' +
            '    <div class="row g-2">' +
            '        <div class="col-md-3">' +
            '            <label class="form-label small">Variant Name <span class="text-danger">*</span></label>' +
            '            <input type="text" name="variants[' + index + '][name]" class="form-control form-control-sm" placeholder="e.g. Red, Large">' +
            '        </div>' +
            '        <div class="col-md-2">' +
            '            <label class="form-label small">SKU</label>' +
            '            <input type="text" name="variants[' + index + '][sku]" class="form-control form-control-sm" placeholder="Auto">' +
            '        </div>' +
            '        <div class="col-md-2">' +
            '            <label class="form-label small">Price</label>' +
            '            <input type="number" name="variants[' + index + '][price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="Inherit">' +
            '        </div>' +
            '        <div class="col-md-2">' +
            '            <label class="form-label small">Stock</label>' +
            '            <input type="number" name="variants[' + index + '][stock]" class="form-control form-control-sm" value="0" min="0">' +
            '        </div>' +
            '        <div class="col-md-1">' +
            '            <label class="form-label small">Active</label>' +
            '            <div class="form-check form-switch mt-1">' +
            '                <input type="checkbox" class="form-check-input" name="variants[' + index + '][status]" value="1" checked>' +
            '            </div>' +
            '        </div>' +
            '        <div class="col-md-2">' +
            '            <label class="form-label small">Image</label>' +
            '            <input type="file" name="variants[' + index + '][image_file]" class="form-control form-control-sm" accept="image/*">' +
            '        </div>' +
            '    </div>' +
            '</div>';

        container.appendChild(template);

        var existingVariants = container.querySelectorAll('.variant-item');
        if (existingVariants.length > 1) {
            var first = existingVariants[0];
            var attrSelects = first.querySelectorAll('select[name*="[attribute_values]"]');
            if (attrSelects.length > 0) {
                var newAttrHtml = '';
                attrSelects.forEach(function(sel) {
                    var clone = sel.cloneNode(true);
                    clone.name = 'variants[' + index + '][attribute_values][]';
                    clone.selectedIndex = 0;
                    newAttrHtml += '<div class="col-auto">' + clone.outerHTML + '</div>';
                });
                var attrRow = document.createElement('div');
                attrRow.className = 'row g-2 mt-2';
                attrRow.innerHTML = '<div class="col-12"><label class="form-label small text-muted">Attribute Values</label></div>' + newAttrHtml;
                template.querySelector('.card-body').appendChild(attrRow);
            }
        }
    }

    function updateVariantNumbers() {
        var items = document.querySelectorAll('.variant-item');
        items.forEach(function(item, index) {
            item.dataset.index = index;
            var num = item.querySelector('.variant-number');
            if (num) num.textContent = 'Variant #' + (index + 1);

            item.querySelectorAll('input, select').forEach(function(input) {
                var name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/variants\[\d+\]/, 'variants[' + index + ']'));
                }
            });
        });
    }

    function toggleNoVariantsMsg() {
        var container = document.getElementById('variantsContainer');
        var noMsg = document.getElementById('noVariantsMsg');
        if (!noMsg) return;
        var count = container ? container.querySelectorAll('.variant-item').length : 0;
        noMsg.style.display = count > 0 ? 'none' : 'block';
    }

    // ==============================
    // Set Primary Image
    // ==============================

    function initPrimaryImage() {
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.set-primary');
            if (!btn) return;

            var item = btn.closest('.product-image-item');
            if (!item) return;

            var container = item.closest('.dropzone-preview');
            if (!container) return;

            container.querySelectorAll('.product-image-item').forEach(function(el) {
                el.classList.remove('primary');
                var badge = el.querySelector('.primary-badge');
                if (badge) badge.remove();
                var input = el.querySelector('input[name*="[is_primary]"]');
                if (input) input.value = '0';
            });

            item.classList.add('primary');
            var badge = document.createElement('div');
            badge.className = 'primary-badge';
            badge.textContent = 'Primary';
            item.appendChild(badge);

            var isPrimaryInput = item.querySelector('input[name*="[is_primary]"]');
            if (isPrimaryInput) isPrimaryInput.value = '1';

            var setBtn = item.querySelector('.set-primary');
            if (setBtn) setBtn.remove();
        });
    }

    // ==============================
    // Remove Image from dropzone
    // ==============================

    function initRemoveImage() {
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.remove-image');
            if (!btn) return;

            var item = btn.closest('.product-image-item');
            if (!item) return;

            var col = item.closest('.col-auto');
            if (!col) return;

            var existingId = col.querySelector('input[name*="[id]"]')?.value;
            var isExisting = existingId && parseInt(existingId) > 0;
            var productId = document.getElementById('productForm')?.dataset?.productId;

            if (isExisting && productId) {
                if (!confirm('Remove this image?')) return;

                var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                fetch('/admin/products/' + productId + '/remove-image/' + existingId, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(function(r) {
                    if (r.ok || r.redirected) col.remove();
                });
            } else {
                col.remove();
                var dz = col.closest('.product-dropzone');
                var preview = col.closest('.dropzone-preview');
                if (dz && preview) {
                    var fileInput = document.getElementById('fileInput-' + dz.dataset.name);
                    if (fileInput) updateFileInput(fileInput, preview);
                }
            }
        });
    }

    // ==============================
    // Init
    // ==============================

    document.addEventListener('DOMContentLoaded', function() {
        initDropzone();
        initImageReorder();
        initVariants();
        initPrimaryImage();
        initRemoveImage();
    });

})();
