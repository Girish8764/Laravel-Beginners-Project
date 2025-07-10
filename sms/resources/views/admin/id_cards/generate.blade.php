@include('admin.header')
@include('admin.sidebar')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generate ID Cards</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="generateForm">
                        @csrf
                        <div class="row">
                            <!-- Template Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="card_type">Select ID Card Type</label>
                                    <select class="form-control" id="card_type" name="type" required>
                                        <option value="">Choose Card Type</option>
                                        <option value="student">Student ID Cards</option>
                                        <option value="staff">Staff ID Cards</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Template Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="template_id">Select Template</label>
                                    <select class="form-control" id="template_id" name="template_id" required disabled>
                                        <option value="">Choose Template</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Template Preview -->
                        <div class="row" id="template_preview" style="display: none;">
                            <div class="col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h4 class="card-title">Template Preview</h4>
                                    </div>
                                    <div class="card-body text-center">
                                        <div id="preview_container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Records Selection -->
                        <div class="row" id="records_section" style="display: none;">
                            <div class="col-12">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h4 class="card-title">Select Records</h4>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-sm btn-secondary" id="select_all">
                                                Select All
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" id="deselect_all">
                                                Deselect All
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="search_records" placeholder="Search records...">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="form-control" id="filter_class" style="display: none;">
                                                        <option value="">All Classes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="records_table">
                                                <thead>
                                                    <tr>
                                                        <th width="40px">
                                                            <input type="checkbox" id="select_all_checkbox">
                                                        </th>
                                                        <th>Name</th>
                                                        <th id="dynamic_column_1">Class</th>
                                                        <th id="dynamic_column_2">Session</th>
                                                        <th id="dynamic_column_3">Roll Number</th>
                                                        <th>Mobile</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="records_tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Generate Button -->
                        <div class="row" id="generate_section" style="display: none;">
                            <div class="col-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-print"></i> Generate ID Cards
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3">Generating ID Cards...</p>
            </div>
        </div>
    </div>
</div>
</div>
@include('admin.footer')

<script>
$(document).ready(function() {
    let allRecords = [];
    let filteredRecords = [];
    
    // Template data for student and staff
    const studentTemplates = @json($studentTemplates);
    const staffTemplates = @json($staffTemplates);

    // Handle card type change
    $('#card_type').change(function() {
        const type = $(this).val();
        const templateSelect = $('#template_id');
        
        templateSelect.empty().append('<option value="">Choose Template</option>');
        
        if (type === 'student') {
            studentTemplates.forEach(template => {
                templateSelect.append(`<option value="${template.id}">${template.name}</option>`);
            });
            updateTableHeaders('student');
        } else if (type === 'staff') {
            staffTemplates.forEach(template => {
                templateSelect.append(`<option value="${template.id}">${template.name}</option>`);
            });
            updateTableHeaders('staff');
        }
        
        templateSelect.prop('disabled', type === '');
        $('#template_preview, #records_section, #generate_section').hide();
    });

    // Handle template selection
    $('#template_id').change(function() {
        const templateId = $(this).val();
        const type = $('#card_type').val();
        
        if (templateId) {
            showTemplatePreview(templateId, type);
            loadRecords(type);
        } else {
            $('#template_preview, #records_section, #generate_section').hide();
        }
    });

    // Search functionality
    $('#search_records').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterRecords(searchTerm);
    });

    // Class filter for students
    $('#filter_class').change(function() {
        const selectedClass = $(this).val();
        const searchTerm = $('#search_records').val().toLowerCase();
        filterRecords(searchTerm, selectedClass);
    });

    // Select all/deselect all
    $('#select_all').click(function() {
        $('#records_tbody input[type="checkbox"]').prop('checked', true);
        updateGenerateButton();
    });

    $('#deselect_all').click(function() {
        $('#records_tbody input[type="checkbox"]').prop('checked', false);
        updateGenerateButton();
    });

    // Master checkbox
    $('#select_all_checkbox').change(function() {
        const isChecked = $(this).prop('checked');
        $('#records_tbody input[type="checkbox"]').prop('checked', isChecked);
        updateGenerateButton();
    });

    // Individual checkbox change
    $(document).on('change', '#records_tbody input[type="checkbox"]', function() {
        updateGenerateButton();
        updateMasterCheckbox();
    });

    // Form submission
    $('#generateForm').submit(function(e) {
        e.preventDefault();
        
        const selectedIds = [];
        $('#records_tbody input[type="checkbox"]:checked').each(function() {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length === 0) {
            alert('Please select at least one record to generate ID cards.');
            return;
        }
        
        $('#loadingModal').modal('show');
        
        $.ajax({
            url: '{{ route("id-cards.generate-cards") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                template_id: $('#template_id').val(),
                type: $('#card_type').val(),
                selected_ids: selectedIds
            },
            success: function(response) {
                $('#loadingModal').modal('hide');
                // Open the generated cards in a new window
                const newWindow = window.open('', '_blank');
                newWindow.document.write(response);
                newWindow.document.close();
            },
            error: function(xhr) {
                $('#loadingModal').modal('hide');
                alert('Error generating ID cards. Please try again.');
                console.error(xhr.responseText);
            }
        });
    });

    // Helper functions
    function updateTableHeaders(type) {
        if (type === 'student') {
            $('#dynamic_column_1').text('Class');
            $('#dynamic_column_2').text('Section');
            $('#dynamic_column_3').text('Roll Number');
            $('#filter_class').show();
        } else if (type === 'staff') {
            $('#dynamic_column_1').text('Subject');
            $('#dynamic_column_2').text('Email');
            $('#dynamic_column_3').text('Joining Date');
            $('#filter_class').hide();
        }
    }

    function showTemplatePreview(templateId, type) {
        const templates = type === 'student' ? studentTemplates : staffTemplates;
        const template = templates.find(t => t.id == templateId);
        
        if (template) {
            const previewHtml = `
                <div class="template-preview" style="border: 1px solid #ddd; padding: 10px; display: inline-block;">
                    <h5>${template.name}</h5>
                    <p><strong>Type:</strong> ${template.type}</p>
                    <p><strong>Orientation:</strong> ${template.orientation}</p>
                    <p><strong>Dimensions:</strong> ${template.width}px × ${template.height}px</p>
                </div>
            `;
            $('#preview_container').html(previewHtml);
            $('#template_preview').show();
        }
    }

    function loadRecords(type) {
        const url = type === 'student' ? '{{ route("id-cards.get-students") }}' : '{{ route("id-cards.get-staff") }}';
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                allRecords = response;
                filteredRecords = response;
                
                if (type === 'student') {
                    populateClassFilter(response);
                }
                
                displayRecords(response);
                $('#records_section').show();
            },
            error: function(xhr) {
                console.error('Error loading records:', xhr.responseText);
                alert('Error loading records. Please try again.');
            }
        });
    }

    function populateClassFilter(students) {
        const classes = [...new Set(students.map(s => s.class))].sort();
        const classSelect = $('#filter_class');
        classSelect.empty().append('<option value="">All Classes</option>');
        
        classes.forEach(cls => {
            classSelect.append(`<option value="${cls}">${cls}</option>`);
        });
    }

    function displayRecords(records) {
        const tbody = $('#records_tbody');
        tbody.empty();
        
        const type = $('#card_type').val();
        
        records.forEach(record => {
            let row = `
                <tr>
                    <td>
                        <input type="checkbox" value="${record.id}" class="record-checkbox">
                    </td>
                    <td>${record.name}</td>
            `;
            
            if (type === 'student') {
                row += `
                    <td>${record.class || ''}</td>
                    <td>${record.section || ''}</td>
                    <td>${record.roll_number || ''}</td>
                `;
            } else {
                row += `
                    <td>${record.subject || ''}</td>
                    <td>${record.email || ''}</td>
                    <td>${record.joining || ''}</td>
                `;
            }
            
            row += `
                    <td>${record.mobile || ''}</td>
                </tr>
            `;
            
            tbody.append(row);
        });
    }

    function filterRecords(searchTerm, selectedClass = '') {
        const type = $('#card_type').val();
        
        filteredRecords = allRecords.filter(record => {
            const matchesSearch = record.name.toLowerCase().includes(searchTerm) ||
                                (record.mobile && record.mobile.includes(searchTerm)) ||
                                (type === 'student' && record.roll_number && record.roll_number.toString().includes(searchTerm)) ||
                                (type === 'staff' && record.email && record.email.toLowerCase().includes(searchTerm));
            
            const matchesClass = selectedClass === '' || (type === 'student' && record.class === selectedClass);
            
            return matchesSearch && matchesClass;
        });
        
        displayRecords(filteredRecords);
    }

    function updateGenerateButton() {
        const checkedCount = $('#records_tbody input[type="checkbox"]:checked').length;
        if (checkedCount > 0) {
            $('#generate_section').show();
        } else {
            $('#generate_section').hide();
        }
    }

    function updateMasterCheckbox() {
        const totalCheckboxes = $('#records_tbody input[type="checkbox"]').length;
        const checkedCheckboxes = $('#records_tbody input[type="checkbox"]:checked').length;
        
        if (checkedCheckboxes === 0) {
            $('#select_all_checkbox').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $('#select_all_checkbox').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#select_all_checkbox').prop('indeterminate', true);
        }
    }
});
</script>



<style>
.template-preview {
    background: #f8f9fa;
    border-radius: 5px;
    margin: 10px 0;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

.card-tools .btn {
    margin-left: 5px;
}

#records_table th {
    position: sticky;
    top: 0;
    background-color: #f8f9fa;
    z-index: 10;
}

.record-checkbox {
    cursor: pointer;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.125rem;
}

.modal-content {
    border-radius: 10px;
}

.card-outline {
    border-top: 3px solid;
}

.card-outline.card-info {
    border-top-color: #17a2b8;
}

.card-outline.card-success {
    border-top-color: #28a745;
}
</style>
