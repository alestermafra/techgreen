<nav class="navbar navbar-light">
	<span class="navbar-brand">Informar Pagamento para Guarderia</span>
</nav>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            Dados da Guarderia
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Proprietário</label>
                    <input type="text" class="form-control" value="<?= $guarderia['nps'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Tipo</label>
                    <input type="text" class="form-control" value="<?= $guarderia['nlinha'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Modelo</label>
                    <input type="text" class="form-control" value="<?= $guarderia['nprod'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Nome</label>
                    <input type="text" class="form-control" value="<?= $guarderia['nome'] ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>