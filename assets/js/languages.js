// Multi-language support for MySQL Backup Tool

const languages = {
    en: {
        // Header
        appTitle: "MySQL Backup Tool",
        appSubtitle: "Professional Database Backup Solution",
        
        // Step Progress
        step1Title: "Database Connection",
        step1Description: "Configure MySQL connection settings",
        step2Title: "Select Objects",
        step2Description: "Choose tables, views, and triggers",
        step3Title: "Backup Options",
        step3Description: "Configure backup preferences",
        step4Title: "Generate Backup",
        step4Description: "Create and download backup file",
        
        // Step 1 - Database Connection
        connectionTitle: "Database Connection",
        hostLabel: "Host",
        portLabel: "Port",
        usernameLabel: "Username",
        passwordLabel: "Password",
        databaseLabel: "Database",
        testConnectionBtn: "Test Connection",
        nextBtn: "Next",
        
        // Step 2 - Select Objects
        selectObjectsTitle: "Select Database Objects",
        tablesLabel: "Tables",
        viewsLabel: "Views",
        triggersLabel: "Triggers",
        proceduresLabel: "Procedures",
        functionsLabel: "Functions",
        selectAllLabel: "Select All",
        backBtn: "Back",
        
        // Step 3 - Backup Options
        backupOptionsTitle: "Backup Options",
        structureTitle: "Database Structure",
        includeStructureLabel: "Include table structure",
        dataTitle: "Table Data",
        includeDataLabel: "Include table data",
        compressionTitle: "File Compression",
        compressBackupLabel: "Compress to ZIP",
        tableDataOptionsTitle: "Table Data Options",
        
        // Step 4 - Generate Backup
        generateBackupTitle: "Generate Backup",
        backupSummaryTitle: "Backup Summary",
        generateBackupBtn: "Generate Backup",
        
        // Messages
        connectionSuccess: "Connection successful!",
        connectionFailed: "Connection failed. Please check your credentials.",
        testingConnection: "Testing connection...",
        loadingObjects: "Loading database objects...",
        generatingBackup: "Generating backup...",
        backupComplete: "Backup completed successfully!",
        downloadReady: "Your backup file is ready for download.",
        
        // Validation Messages
        requiredField: "This field is required",
        selectAtLeastOne: "Please select at least one object",
        invalidPort: "Please enter a valid port number",
        
        // General
        loading: "Loading...",
        error: "Error",
        success: "Success",
        warning: "Warning",
        cancel: "Cancel",
        close: "Close",
        download: "Download",
        
        // Language Selector
        language: "Language",
        english: "English",
        indonesian: "Indonesian"
    },
    
    id: {
        // Header
        appTitle: "MySQL Backup Tool",
        appSubtitle: "Solusi Backup Database Profesional",
        
        // Step Progress
        step1Title: "Koneksi Database",
        step1Description: "Konfigurasi pengaturan koneksi MySQL",
        step2Title: "Pilih Objek",
        step2Description: "Pilih tabel, views, dan triggers",
        step3Title: "Opsi Backup",
        step3Description: "Konfigurasi preferensi backup",
        step4Title: "Generate Backup",
        step4Description: "Buat dan download file backup",
        
        // Step 1 - Database Connection
        connectionTitle: "Koneksi Database",
        hostLabel: "Host",
        portLabel: "Port",
        usernameLabel: "Username",
        passwordLabel: "Password",
        databaseLabel: "Database",
        testConnectionBtn: "Test Koneksi",
        nextBtn: "Lanjut",
        
        // Step 2 - Select Objects
        selectObjectsTitle: "Pilih Objek Database",
        tablesLabel: "Tabel",
        viewsLabel: "Views",
        triggersLabel: "Triggers",
        proceduresLabel: "Procedures",
        functionsLabel: "Functions",
        selectAllLabel: "Pilih Semua",
        backBtn: "Kembali",
        
        // Step 3 - Backup Options
        backupOptionsTitle: "Opsi Backup",
        structureTitle: "Struktur Database",
        includeStructureLabel: "Sertakan struktur tabel",
        dataTitle: "Data Tabel",
        includeDataLabel: "Sertakan data tabel",
        compressionTitle: "Kompresi File",
        compressBackupLabel: "Kompress ke ZIP",
        tableDataOptionsTitle: "Opsi Data Tabel",
        
        // Step 4 - Generate Backup
        generateBackupTitle: "Generate Backup",
        backupSummaryTitle: "Ringkasan Backup",
        generateBackupBtn: "Generate Backup",
        
        // Messages
        connectionSuccess: "Koneksi berhasil!",
        connectionFailed: "Koneksi gagal. Silakan periksa kredensial Anda.",
        testingConnection: "Menguji koneksi...",
        loadingObjects: "Memuat objek database...",
        generatingBackup: "Membuat backup...",
        backupComplete: "Backup berhasil dibuat!",
        downloadReady: "File backup Anda siap untuk didownload.",
        
        // Validation Messages
        requiredField: "Field ini wajib diisi",
        selectAtLeastOne: "Silakan pilih minimal satu objek",
        invalidPort: "Silakan masukkan nomor port yang valid",
        
        // General
        loading: "Memuat...",
        error: "Error",
        success: "Sukses",
        warning: "Peringatan",
        cancel: "Batal",
        close: "Tutup",
        download: "Download",
        
        // Language Selector
        language: "Bahasa",
        english: "English",
        indonesian: "Bahasa Indonesia"
    }
};

class LanguageManager {
    constructor() {
        this.currentLanguage = localStorage.getItem('selectedLanguage') || 'en';
        this.init();
    }
    
    init() {
        this.createLanguageSelector();
        this.applyLanguage(this.currentLanguage);
        this.bindEvents();
    }
    
    createLanguageSelector() {
        const headerActions = document.querySelector('.header-actions');
        if (headerActions) {
            const languageSelector = document.createElement('div');
            languageSelector.className = 'language-selector';
            languageSelector.innerHTML = `
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i> <span id="current-language">EN</span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="#" data-lang="en">
                            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTUiIHZpZXdCb3g9IjAgMCAyMCAxNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjE1IiBmaWxsPSIjMDEyMTY5Ii8+CjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBkPSJNMCAwSDIwVjFIMFYwWk0wIDJIMjBWM0gwVjJaTTAgNEgyMFY1SDBWNFpNMCA2SDIwVjdIMFY2Wk0wIDhIMjBWOUgwVjhaTTAgMTBIMjBWMTFIMFYxMFpNMCAxMkgyMFYxM0gwVjEyWiIgZmlsbD0iI0ZGRiIvPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI3IiBmaWxsPSIjMDEyMTY5Ii8+Cjwvc3ZnPgo=" alt="EN" class="flag-icon"> English
                        </a></li>
                        <li><a class="dropdown-item" href="#" data-lang="id">
                            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTUiIHZpZXdCb3g9IjAgMCAyMCAxNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjcuNSIgZmlsbD0iI0ZGMDAwMCIvPgo8cmVjdCB5PSI3LjUiIHdpZHRoPSIyMCIgaGVpZ2h0PSI3LjUiIGZpbGw9IiNGRkZGRkYiLz4KPC9zdmc+" alt="ID" class="flag-icon"> Bahasa Indonesia
                        </a></li>
                    </ul>
                </div>
            `;
            
            // Insert before version badge
            const versionBadge = headerActions.querySelector('.version-badge');
            headerActions.insertBefore(languageSelector, versionBadge);
        }
    }
    
    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-lang]')) {
                e.preventDefault();
                const lang = e.target.closest('[data-lang]').getAttribute('data-lang');
                this.changeLanguage(lang);
            }
        });
    }
    
    changeLanguage(lang) {
        this.currentLanguage = lang;
        localStorage.setItem('selectedLanguage', lang);
        this.applyLanguage(lang);
        
        // Update current language display
        const currentLangElement = document.getElementById('current-language');
        if (currentLangElement) {
            currentLangElement.textContent = lang.toUpperCase();
        }
    }
    
    applyLanguage(lang) {
        const translations = languages[lang] || languages.en;
        
        // Update all elements with data-translate attribute
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (translations[key]) {
                if (element.tagName === 'INPUT' && element.type !== 'button') {
                    element.placeholder = translations[key];
                } else {
                    element.textContent = translations[key];
                }
            }
        });
        
        // Update specific elements
        this.updateSpecificElements(translations);
    }
    
    updateSpecificElements(translations) {
        // Update app title and subtitle
        const appTitle = document.querySelector('.brand-title');
        const appSubtitle = document.querySelector('.brand-subtitle');
        
        if (appTitle) appTitle.textContent = translations.appTitle;
        if (appSubtitle) appSubtitle.textContent = translations.appSubtitle;
        
        // Update step titles and descriptions
        for (let i = 1; i <= 4; i++) {
            const stepTitle = document.querySelector(`[data-step="${i}"] .step-title`);
            const stepDescription = document.querySelector(`[data-step="${i}"] .step-description`);
            
            if (stepTitle) stepTitle.textContent = translations[`step${i}Title`];
            if (stepDescription) stepDescription.textContent = translations[`step${i}Description`];
        }
    }
    
    t(key) {
        const translations = languages[this.currentLanguage] || languages.en;
        return translations[key] || key;
    }
}

// Initialize language manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.languageManager = new LanguageManager();
});