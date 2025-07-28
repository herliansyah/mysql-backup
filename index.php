<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL Database Backup Tool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="container">
            <div class="header-content">
                <div class="app-brand">
                    <div class="brand-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="brand-text">
                        <h1 class="brand-title">MySQL Backup Tool</h1>
                        <p class="brand-subtitle">Professional Database Backup Solution</p>
                    </div>
                </div>
                <div class="header-actions">
                    <span class="version-badge">v1.0.0</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Modern Step Progress -->
    <section class="step-progress-section">
        <div class="container">
            <div class="step-progress-wrapper">
                <div class="step-progress">
                    <div class="step-item active" data-step="1">
                        <div class="step-number">
                            <span class="step-icon">
                                <i class="fas fa-server"></i>
                            </span>
                            <span class="step-count">1</span>
                        </div>
                        <div class="step-info">
                            <h3 class="step-title">Database Connection</h3>
                            <p class="step-description">Configure MySQL connection settings</p>
                        </div>
                        <div class="step-status">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    
                    <div class="step-connector">
                        <div class="connector-line"></div>
                    </div>
                    
                    <div class="step-item" data-step="2">
                        <div class="step-number">
                            <span class="step-icon">
                                <i class="fas fa-table"></i>
                            </span>
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-info">
                            <h3 class="step-title">Select Objects</h3>
                            <p class="step-description">Choose tables, views, and triggers</p>
                        </div>
                        <div class="step-status">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    
                    <div class="step-connector">
                        <div class="connector-line"></div>
                    </div>
                    
                    <div class="step-item" data-step="3">
                        <div class="step-number">
                            <span class="step-icon">
                                <i class="fas fa-cog"></i>
                            </span>
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-info">
                            <h3 class="step-title">Backup Options</h3>
                            <p class="step-description">Configure backup preferences</p>
                        </div>
                        <div class="step-status">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    
                    <div class="step-connector">
                        <div class="connector-line"></div>
                    </div>
                    
                    <div class="step-item" data-step="4">
                        <div class="step-number">
                            <span class="step-icon">
                                <i class="fas fa-download"></i>
                            </span>
                            <span class="step-count">4</span>
                        </div>
                        <div class="step-info">
                            <h3 class="step-title">Generate Backup</h3>
                            <p class="step-description">Create and download backup file</p>
                        </div>
                        <div class="step-status">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="main-content">
        <div class="container">

                <!-- Step 1: Database Connection -->
                <div class="step-content active" id="step-1">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-server"></i> Koneksi Database</h5>
                        </div>
                        <div class="card-body">
                            <form id="connection-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="host" class="form-label">Host</label>
                                            <input type="text" class="form-control" id="host" name="host" value="localhost" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="port" class="form-label">Port</label>
                                            <input type="number" class="form-control" id="port" name="port" value="3306" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="database" class="form-label">Database</label>
                                    <input type="text" class="form-control" id="database" name="database" required>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-primary" id="test-connection">
                                        <i class="fas fa-plug"></i> Test Koneksi
                                    </button>
                                    <button type="button" class="btn btn-primary" id="next-step-1">
                                        Lanjut <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Select Objects -->
                <div class="step-content" id="step-2">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-table"></i> Pilih Objek Database</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="object-type-card">
                                        <h6><i class="fas fa-table"></i> Tabel</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all-tables">
                                            <label class="form-check-label" for="select-all-tables">
                                                Pilih Semua
                                            </label>
                                        </div>
                                        <div id="tables-list" class="object-list">
                                            <!-- Tables will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="object-type-card">
                                        <h6><i class="fas fa-eye"></i> Views</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all-views">
                                            <label class="form-check-label" for="select-all-views">
                                                Pilih Semua
                                            </label>
                                        </div>
                                        <div id="views-list" class="object-list">
                                            <!-- Views will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="object-type-card">
                                        <h6><i class="fas fa-bolt"></i> Triggers</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all-triggers">
                                            <label class="form-check-label" for="select-all-triggers">
                                                Pilih Semua
                                            </label>
                                        </div>
                                        <div id="triggers-list" class="object-list">
                                            <!-- Triggers will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="object-type-card">
                                        <h6><i class="fas fa-cogs"></i> Procedures</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all-procedures">
                                            <label class="form-check-label" for="select-all-procedures">
                                                Pilih Semua
                                            </label>
                                        </div>
                                        <div id="procedures-list" class="object-list">
                                            <!-- Procedures will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="object-type-card">
                                        <h6><i class="fas fa-code"></i> Functions</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all-functions">
                                            <label class="form-check-label" for="select-all-functions">
                                                Pilih Semua
                                            </label>
                                        </div>
                                        <div id="functions-list" class="object-list">
                                            <!-- Functions will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-outline-secondary" id="prev-step-2">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                                <button type="button" class="btn btn-primary" id="next-step-2">
                                    Lanjut <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Backup Options -->
                <div class="step-content" id="step-3">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-cog"></i> Opsi Backup</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="option-card">
                                        <h6>Struktur Database</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="include-structure" checked>
                                            <label class="form-check-label" for="include-structure">
                                                Sertakan struktur tabel
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="option-card">
                                        <h6>Data Tabel</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="include-data" checked>
                                            <label class="form-check-label" for="include-data">
                                                Sertakan data tabel
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="option-card">
                                        <h6>Kompresi File</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="compress-backup">
                                            <label class="form-check-label" for="compress-backup">
                                                Kompress ke ZIP
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="data-options" class="mt-4">
                                <h6>Opsi Data Tabel</h6>
                                <div id="table-data-options">
                                    <!-- Table data options will be loaded here -->
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-outline-secondary" id="prev-step-3">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                                <button type="button" class="btn btn-primary" id="next-step-3">
                                    Lanjut <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Generate Backup -->
                <div class="step-content" id="step-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-download"></i> Generate Backup</h5>
                        </div>
                        <div class="card-body">
                            <div class="backup-summary">
                                <h6>Ringkasan Backup</h6>
                                <div id="backup-summary-content">
                                    <!-- Summary will be loaded here -->
                                </div>
                            </div>

                            <div class="progress-container mt-4" style="display: none;">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <div class="progress-text mt-2"></div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-outline-secondary" id="prev-step-4">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                                <button type="button" class="btn btn-success" id="generate-backup">
                                    <i class="fas fa-download"></i> Generate Backup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Memproses...</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>