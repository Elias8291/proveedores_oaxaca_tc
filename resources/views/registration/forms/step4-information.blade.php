<div class="form-section" id="form-step-4">
    <div class="form-container">
        <div class="form-column">
            <div class="form-group">
                <h4><i class="fas fa-users"></i> Socios o Accionistas (Persona Moral)</h4>
            </div>
            <div class="form-group">
                <div class="table-container">
                    <table class="socios-table" id="tabla-socios">
                        <thead>
                            <tr>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombre(s)</th>
                                <th>Porcentaje de Acciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Fila de ejemplo -->
                            <tr>
                                <td>
                                    <input type="text" class="form-control" placeholder="Apellido Paterno">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Apellido Materno">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Nombre(s)">
                                </td>
                                <td>
                                    <div class="input-with-suffix">
                                        <input type="text" class="form-control porcentaje-input" placeholder="Ej: 50">
                                        <span class="input-suffix">%</span>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn-delete eliminar-socio">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" id="agregar-socio" class="btn-add mt-2">
                    <i class="fas fa-plus"></i> Agregar Socio
                </button>
            </div>
        </div>
    </div>
</div>