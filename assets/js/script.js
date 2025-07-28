// MySQL Backup Tool JavaScript

class BackupTool {
    constructor() {
        this.currentStep = 1;
        this.connectionData = {};
        this.selectedObjects = {
            tables: [],
            views: [],
            triggers: [],
            procedures: [],
            functions: []
        };
        this.backupOptions = {
            includeStructure: true,
            includeData: true,
            tableDataOptions: {}
        };
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateStepDisplay();
    }

    bindEvents() {
        // Navigation events
        $('.menu-item').on('click', (e) => {
            const step = parseInt($(e.currentTarget).data('step'));
            if (step <= this.currentStep) {
                this.goToStep(step);
            }
        });

        // Step navigation buttons
        $('#next-step-1').on('click', () => this.validateAndProceed(1));
        $('#next-step-2').on('click', () => this.validateAndProceed(2));
        $('#next-step-3').on('click', () => this.validateAndProceed(3));
        
        $('#prev-step-2').on('click', () => this.goToStep(1));
        $('#prev-step-3').on('click', () => this.goToStep(2));
        $('#prev-step-4').on('click', () => this.goToStep(3));

        // Connection test
        $('#test-connection').on('click', () => this.testConnection());

        // Object selection events
        $('#select-all-tables').on('change', (e) => this.toggleSelectAll('tables', e.target.checked));
        $('#select-all-views').on('change', (e) => this.toggleSelectAll('views', e.target.checked));
        $('#select-all-triggers').on('change', (e) => this.toggleSelectAll('triggers', e.target.checked));
        $('#select-all-procedures').on('change', (e) => this.toggleSelectAll('procedures', e.target.checked));
        $('#select-all-functions').on('change', (e) => this.toggleSelectAll('functions', e.target.checked));

        // Backup options
        $('#include-structure').on('change', (e) => {
            this.backupOptions.includeStructure = e.target.checked;
        });

        $('#include-data').on('change', (e) => {
            this.backupOptions.includeData = e.target.checked;
            this.toggleDataOptions(e.target.checked);
        });

        // Generate backup
        $('#generate-backup').on('click', () => this.generateBackup());
    }

    goToStep(step) {
        // Hide all steps
        $('.step-content').removeClass('active');
        $('.menu-item').removeClass('active');

        // Show target step
        $(`#step-${step}`).addClass('active');
        $(`.menu-item[data-step="${step}"]`).addClass('active');

        this.currentStep = step;
    }

    updateStepDisplay() {
        $('.step-content').removeClass('active');
        $('.menu-item').removeClass('active');
        
        $(`#step-${this.currentStep}`).addClass('active');
        $(`.menu-item[data-step="${this.currentStep}"]`).addClass('active');
    }

    async validateAndProceed(currentStep) {
        switch(currentStep) {
            case 1:
                if (await this.validateConnection()) {
                    await this.loadDatabaseObjects();
                    this.goToStep(2);
                }
                break;
            case 2:
                if (this.validateObjectSelection()) {
                    this.setupBackupOptions();
                    this.goToStep(3);
                }
                break;
            case 3:
                this.generateBackupSummary();
                this.goToStep(4);
                break;
        }
    }

    async validateConnection() {
        const formData = {
            host: $('#host').val(),
            port: $('#port').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            database: $('#database').val()
        };

        // Basic validation
        if (!formData.host || !formData.username || !formData.database) {
            this.showAlert('danger', 'Harap lengkapi semua field yang diperlukan!');
            return false;
        }

        this.connectionData = formData;
        return true;
    }

    async testConnection() {
        const formData = {
            host: $('#host').val(),
            port: $('#port').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            database: $('#database').val()
        };

        if (!formData.host || !formData.username || !formData.database) {
            this.showAlert('danger', 'Harap lengkapi semua field yang diperlukan!');
            return;
        }

        this.showLoading();

        try {
            const response = await $.ajax({
                url: 'api/test-connection.php',
                method: 'POST',
                data: formData,
                dataType: 'json'
            });

            this.hideLoading();

            if (response.success) {
                this.showAlert('success', 'Koneksi berhasil!');
                this.connectionData = formData;
            } else {
                this.showAlert('danger', `Koneksi gagal: ${response.message}`);
            }
        } catch (error) {
            this.hideLoading();
            this.showAlert('danger', 'Terjadi kesalahan saat menguji koneksi.');
        }
    }

    async loadDatabaseObjects() {
        this.showLoading();

        try {
            const response = await $.ajax({
                url: 'api/get-objects.php',
                method: 'POST',
                data: this.connectionData,
                dataType: 'json'
            });

            this.hideLoading();

            if (response.success) {
                this.populateObjectLists(response.data);
            } else {
                this.showAlert('danger', `Gagal memuat objek database: ${response.message}`);
            }
        } catch (error) {
            this.hideLoading();
            this.showAlert('danger', 'Terjadi kesalahan saat memuat objek database: ' + error.message);
        }
    }

    populateObjectLists(data) {
        // Ensure data exists and has proper structure
        if (!data) {
            this.showAlert('danger', 'Tidak ada data yang diterima dari server');
            return;
        }

        // Initialize arrays if they don't exist
        data.tables = data.tables || [];
        data.views = data.views || [];
        data.triggers = data.triggers || [];
        data.procedures = data.procedures || [];
        data.functions = data.functions || [];
        
        // Populate tables
        if (data.tables && data.tables.length > 0) {
            const tablesHtml = data.tables.map(table => `
                <div class="form-check object-item">
                    <input class="form-check-input table-checkbox" type="checkbox" value="${table.name || ''}" id="table-${table.name || 'unknown'}">
                    <label class="form-check-label" for="table-${table.name || 'unknown'}">
                        <i class="fas fa-table text-primary me-2"></i>
                        <strong>${table.name || 'Unknown Table'}</strong>
                        <br>
                        <small class="text-muted">
                            ${formatNumber(table.rows || 0)} rows | ${formatBytes(table.size || 0)}
                            ${table.comment ? ' | ' + table.comment : ''}
                        </small>
                    </label>
                </div>
            `).join('');
            $('#tables-list').html(tablesHtml);
        } else {
            $('#tables-list').html('<p class="text-muted text-center py-3"><i class="fas fa-info-circle"></i> Tidak ada tabel ditemukan</p>');
        }

        // Populate views
        if (data.views && data.views.length > 0) {
            const viewsHtml = data.views.map(view => `
                <div class="form-check object-item">
                    <input class="form-check-input view-checkbox" type="checkbox" value="${view.name}" id="view-${view.name}">
                    <label class="form-check-label" for="view-${view.name}">
                        <i class="fas fa-eye text-info me-2"></i>
                        <strong>${view.name}</strong>
                        <br>
                        <small class="text-muted">
                            ${view.is_updatable === 'YES' ? 'Updatable' : 'Read-only'} view
                        </small>
                    </label>
                </div>
            `).join('');
            $('#views-list').html(viewsHtml);
        } else {
            $('#views-list').html('<p class="text-muted text-center py-3"><i class="fas fa-info-circle"></i> Tidak ada view ditemukan</p>');
        }

        // Populate triggers
        if (data.triggers && data.triggers.length > 0) {
            const triggersHtml = data.triggers.map(trigger => `
                <div class="form-check object-item">
                    <input class="form-check-input trigger-checkbox" type="checkbox" value="${trigger.name}" id="trigger-${trigger.name}">
                    <label class="form-check-label" for="trigger-${trigger.name}">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        <strong>${trigger.name}</strong>
                        <br>
                        <small class="text-muted">
                            ${trigger.timing} ${trigger.event} on ${trigger.table}
                        </small>
                    </label>
                </div>
            `).join('');
            $('#triggers-list').html(triggersHtml);
        } else {
            $('#triggers-list').html('<p class="text-muted text-center py-3"><i class="fas fa-info-circle"></i> Tidak ada trigger ditemukan</p>');
        }

        // Populate procedures
        if (data.procedures && data.procedures.length > 0) {
            const proceduresHtml = data.procedures.map(procedure => `
                <div class="form-check object-item">
                    <input class="form-check-input procedure-checkbox" type="checkbox" value="${procedure.name}" id="procedure-${procedure.name}">
                    <label class="form-check-label" for="procedure-${procedure.name}">
                        <i class="fas fa-cogs text-success me-2"></i>
                        <strong>${procedure.name}</strong>
                        <br>
                        <small class="text-muted">
                            Stored ${procedure.type.toLowerCase()}
                        </small>
                    </label>
                </div>
            `).join('');
            $('#procedures-list').html(proceduresHtml);
        } else {
            $('#procedures-list').html('<p class="text-muted text-center py-3"><i class="fas fa-info-circle"></i> Tidak ada procedure ditemukan</p>');
        }

        // Populate functions
        if (data.functions && data.functions.length > 0) {
            const functionsHtml = data.functions.map(func => `
                <div class="form-check object-item">
                    <input class="form-check-input function-checkbox" type="checkbox" value="${func.name}" id="function-${func.name}">
                    <label class="form-check-label" for="function-${func.name}">
                        <i class="fas fa-code text-danger me-2"></i>
                        <strong>${func.name}</strong>
                        <br>
                        <small class="text-muted">
                            Returns ${func.data_type}
                        </small>
                    </label>
                </div>
            `).join('');
            $('#functions-list').html(functionsHtml);
        } else {
            $('#functions-list').html('<p class="text-muted text-center py-3"><i class="fas fa-info-circle"></i> Tidak ada function ditemukan</p>');
        }

        // Store data for later use
        this.databaseObjects = data;
        
        // Show summary
        this.showObjectSummary(data);
    }

    showObjectSummary(data) {
        const summary = `
            <div class="alert alert-info mt-3">
                <h6><i class="fas fa-info-circle"></i> Ringkasan Database</h6>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li><strong>Tabel:</strong> ${data.tables ? data.tables.length : 0}</li>
                            <li><strong>Views:</strong> ${data.views ? data.views.length : 0}</li>
                            <li><strong>Triggers:</strong> ${data.triggers ? data.triggers.length : 0}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li><strong>Procedures:</strong> ${data.procedures ? data.procedures.length : 0}</li>
                            <li><strong>Functions:</strong> ${data.functions ? data.functions.length : 0}</li>
                            <li><strong>Database:</strong> ${this.connectionData.database}</li>
                        </ul>
                    </div>
                </div>
            </div>
        `;
        
        // Add summary after the object selection area
        if ($('.object-summary').length === 0) {
            $('#step-2 .card-body').append('<div class="object-summary">' + summary + '</div>');
        } else {
            $('.object-summary').html(summary);
        }
    }

    toggleSelectAll(type, checked) {
        $(`.${type.slice(0, -1)}-checkbox`).prop('checked', checked);
    }

    validateObjectSelection() {
        const selectedTables = $('.table-checkbox:checked').map((i, el) => el.value).get();
        const selectedViews = $('.view-checkbox:checked').map((i, el) => el.value).get();
        const selectedTriggers = $('.trigger-checkbox:checked').map((i, el) => el.value).get();
        const selectedProcedures = $('.procedure-checkbox:checked').map((i, el) => el.value).get();
        const selectedFunctions = $('.function-checkbox:checked').map((i, el) => el.value).get();

        if (selectedTables.length === 0 && selectedViews.length === 0 && selectedTriggers.length === 0 && 
            selectedProcedures.length === 0 && selectedFunctions.length === 0) {
            this.showAlert('warning', 'Harap pilih minimal satu objek untuk di-backup!');
            return false;
        }

        this.selectedObjects = {
            tables: selectedTables,
            views: selectedViews,
            triggers: selectedTriggers,
            procedures: selectedProcedures,
            functions: selectedFunctions
        };

        return true;
    }

    setupBackupOptions() {
        if (this.selectedObjects.tables.length > 0) {
            const tableOptionsHtml = this.selectedObjects.tables.map(tableName => {
                const tableData = this.databaseObjects.tables.find(t => t.name === tableName);
                return `
                    <div class="table-option">
                        <h6><i class="fas fa-table"></i> ${tableName}</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="data-option-${tableName}" value="all" id="all-${tableName}" checked>
                                    <label class="form-check-label" for="all-${tableName}">
                                        Semua data (${formatNumber(tableData.rows)} rows)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="data-option-${tableName}" value="limit" id="limit-${tableName}">
                                    <label class="form-check-label" for="limit-${tableName}">
                                        Batasi jumlah
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 limit-input" style="display: none;">
                            <label class="form-label small text-muted">Jumlah rows (default: ${Math.min(10, tableData.rows)})</label>
                            <input type="number" class="form-control" placeholder="Masukkan jumlah rows" min="1" max="${tableData.rows}" value="${Math.min(10, tableData.rows)}" id="limit-value-${tableName}">
                            <small class="text-muted">Maksimal: ${formatNumber(tableData.rows)} rows</small>
                        </div>
                    </div>
                `;
            }).join('');

            $('#table-data-options').html(tableOptionsHtml);

            // Handle limit option toggle
            $('input[type="radio"][value="limit"]').on('change', function() {
                const tableName = this.name.replace('data-option-', '');
                $(`#limit-value-${tableName}`).closest('.limit-input').show();
            });

            $('input[type="radio"][value="all"]').on('change', function() {
                const tableName = this.name.replace('data-option-', '');
                $(`#limit-value-${tableName}`).closest('.limit-input').hide();
            });
        }
    }

    toggleDataOptions(show) {
        if (show) {
            $('#data-options').show();
        } else {
            $('#data-options').hide();
        }
    }

    generateBackupSummary() {
        const summary = {
            tables: this.selectedObjects.tables.length,
            views: this.selectedObjects.views.length,
            triggers: this.selectedObjects.triggers.length,
            procedures: this.selectedObjects.procedures.length,
            functions: this.selectedObjects.functions.length,
            includeStructure: this.backupOptions.includeStructure,
            includeData: this.backupOptions.includeData
        };

        const summaryHtml = `
            <div class="summary-item">
                <span class="summary-label">Database:</span>
                <span class="summary-value">${this.connectionData.database}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Tabel:</span>
                <span class="summary-value">${summary.tables}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Views:</span>
                <span class="summary-value">${summary.views}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Triggers:</span>
                <span class="summary-value">${summary.triggers}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Procedures:</span>
                <span class="summary-value">${summary.procedures}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Functions:</span>
                <span class="summary-value">${summary.functions}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Sertakan Struktur:</span>
                <span class="summary-value">${summary.includeStructure ? 'Ya' : 'Tidak'}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Sertakan Data:</span>
                <span class="summary-value">${summary.includeData ? 'Ya' : 'Tidak'}</span>
            </div>
        `;

        $('#backup-summary-content').html(summaryHtml);
    }

    async generateBackup() {
        // Collect table data options
        const tableDataOptions = {};
        this.selectedObjects.tables.forEach(tableName => {
            const option = $(`input[name="data-option-${tableName}"]:checked`).val();
            if (option === 'limit') {
                const limitValue = $(`#limit-value-${tableName}`).val();
                const tableData = this.databaseObjects.tables.find(t => t.name === tableName);
                const defaultValue = Math.min(10, tableData ? tableData.rows : 10);
                tableDataOptions[tableName] = {
                    type: 'limit',
                    value: parseInt(limitValue) || defaultValue
                };
            } else {
                tableDataOptions[tableName] = {
                    type: 'all'
                };
            }
        });

        const backupData = {
            connection: this.connectionData,
            objects: this.selectedObjects,
            options: {
                includeStructure: this.backupOptions.includeStructure,
                includeData: this.backupOptions.includeData,
                tableDataOptions: tableDataOptions
            }
        };

        this.showProgress();

        try {
            const response = await $.ajax({
                url: 'api/generate-backup.php',
                method: 'POST',
                data: JSON.stringify(backupData),
                contentType: 'application/json',
                dataType: 'json',
                xhr: () => {
                    const xhr = new window.XMLHttpRequest();
                    xhr.addEventListener('progress', (evt) => {
                        if (evt.lengthComputable) {
                            const percentComplete = (evt.loaded / evt.total) * 100;
                            this.updateProgress(percentComplete);
                        }
                    });
                    return xhr;
                }
            });

            this.hideProgress();

            if (response.success) {
                this.showSuccessState(response.filename);
            } else {
                this.showAlert('danger', `Gagal generate backup: ${response.message}`);
            }
        } catch (error) {
            this.hideProgress();
            this.showAlert('danger', 'Terjadi kesalahan saat generate backup.');
        }
    }

    showProgress() {
        $('.progress-container').show();
        $('#generate-backup').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generating...');
    }

    hideProgress() {
        $('.progress-container').hide();
        $('#generate-backup').prop('disabled', false).html('<i class="fas fa-download"></i> Generate Backup');
    }

    updateProgress(percent) {
        $('.progress-bar').css('width', `${percent}%`);
        $('.progress-text').text(`${Math.round(percent)}% Complete`);
    }

    showSuccessState(filename) {
        const successHtml = `
            <div class="success-state">
                <i class="fas fa-check-circle"></i>
                <h4>Backup Berhasil!</h4>
                <p>File backup telah berhasil dibuat.</p>
                <a href="downloads/${filename}" class="btn btn-success" download>
                    <i class="fas fa-download"></i> Download Backup
                </a>
            </div>
        `;
        
        $('#step-4 .card-body').html(successHtml);
    }

    showLoading() {
        $('#loadingModal').modal('show');
    }

    hideLoading() {
        $('#loadingModal').modal('hide');
    }

    showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert to current step
        $(`.step-content.active .card-body`).prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }
}

// Initialize the application
$(document).ready(() => {
    new BackupTool();
});

// Utility functions
function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}