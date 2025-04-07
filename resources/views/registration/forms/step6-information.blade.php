<div id="section-6" class="form-section">
    <div class="form-container">
        <!-- Columna única -->
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-file-pdf"></i> Documentación Requerida</h4>
            </div>

            <!-- Documentos Personales -->
            <div class="document-category">
                <h5 class="document-category-title"><i class="fas fa-user"></i> Documentos Personales</h5>
                <div class="file-upload-grid">
                    <!-- Constancia de Situación Fiscal -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-receipt"></i>
                            <h6>Constancia de Situación Fiscal</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="constancia_situacion_fiscal" name="constancia_situacion_fiscal" class="file-upload-input" accept=".pdf" required>
                            <label for="constancia_situacion_fiscal" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Documento vigente emitido por el SAT
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- Identificación Oficial -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-id-card"></i>
                            <h6>Identificación Oficial</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="identificacion_oficial" name="identificacion_oficial" class="file-upload-input" accept=".pdf" required>
                            <label for="identificacion_oficial" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> INE, pasaporte o cédula profesional
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- Curriculum -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-file-alt"></i>
                            <h6>Curriculum Actualizado</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="curriculum" name="curriculum" class="file-upload-input" accept=".pdf" required>
                            <label for="curriculum" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Versión actualizada con datos de contacto
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- Comprobante de Domicilio -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-home"></i>
                            <h6>Comprobante de Domicilio</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="comprobante_domicilio" name="comprobante_domicilio" class="file-upload-input" accept=".pdf" required>
                            <label for="comprobante_domicilio" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> No mayor a 3 meses de antigüedad
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- Acta de Nacimiento -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-certificate"></i>
                            <h6>Acta de Nacimiento</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="acta_nacimiento" name="acta_nacimiento" class="file-upload-input" accept=".pdf" required>
                            <label for="acta_nacimiento" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Copia legible y completa
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- CURP -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-id-badge"></i>
                            <h6>CURP</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="curp" name="curp" class="file-upload-input" accept=".pdf" required>
                            <label for="curp" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Formato actualizado
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos Fiscales -->
            <div class="document-category">
                <h5 class="document-category-title"><i class="fas fa-file-invoice-dollar"></i> Documentos Fiscales</h5>
                <div class="file-upload-grid">
                    <!-- Carta Poder -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-file-contract"></i>
                            <h6>Carta Poder Simple</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="carta_poder" name="carta_poder" class="file-upload-input" accept=".pdf" required>
                            <label for="carta_poder" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Incluir identificación del representante
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- Acuse de Recibo -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-receipt"></i>
                            <h6>Acuse de Recibo</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="acuse_recibo" name="acuse_recibo" class="file-upload-input" accept=".pdf" required>
                            <label for="acuse_recibo" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Última declaración anual
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos Personas Morales -->
            <div class="document-category">
                <h5 class="document-category-title"><i class="fas fa-building"></i> Documentos para Personas Morales</h5>
                <div class="file-upload-grid">
                    <!-- Acta Constitutiva -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-file-signature"></i>
                            <h6>Acta Constitutiva</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="acta_constitutiva" name="acta_constitutiva" class="file-upload-input" accept=".pdf">
                            <label for="acta_constitutiva" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Inscrita en el Registro Público
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- Modificaciones al Acta -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-file-contract"></i>
                            <h6>Modificaciones al Acta</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="modificaciones_acta" name="modificaciones_acta" class="file-upload-input" accept=".pdf">
                            <label for="modificaciones_acta" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Solo si aplica
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>

                    <!-- Poder Notariado -->
                    <div class="file-upload-card">
                        <div class="file-upload-header">
                            <i class="fas fa-stamp"></i>
                            <h6>Poder Notariado</h6>
                            <span class="file-type-badge">PDF</span>
                        </div>
                        <div class="file-upload-body">
                            <input type="file" id="poder_notariado" name="poder_notariado" class="file-upload-input" accept=".pdf">
                            <label for="poder_notariado" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                            </label>
                            <div class="file-upload-help">
                                <i class="fas fa-info-circle"></i> Del representante legal
                            </div>
                        </div>
                        <div class="file-upload-state" data-status="pending">
                            <span class="file-status-icon"><i class="fas fa-clock"></i></span>
                            <span class="file-status-text">Pendiente</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
