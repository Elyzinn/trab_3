<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'models/Filmes.php';

$filme = new Filmes();

$mensagem = '';
$tipo_mensagem = '';
$editando = false;
$filme_edit = null;

// Verificar ação
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    if ($acao == 'criar') {
        $nome = $_POST['nome'] ?? '';
        $diretor = $_POST['diretor'] ?? '';
        $data_lancamento = $_POST['data_lancamento'] ?? '';
        $nota = $_POST['nota'] ?? '';
        
        if ($nome && $diretor && $data_lancamento && $nota) {
            if ($filme->criar($nome, $diretor, $data_lancamento, $nota)) {
                $mensagem = 'Filme adicionado com sucesso!';
                $tipo_mensagem = 'success';
            } else {
                $mensagem = 'Erro ao adicionar filme.';
                $tipo_mensagem = 'error';
            }
        }
    } elseif ($acao == 'atualizar') {
        $id = $_POST['id'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $diretor = $_POST['diretor'] ?? '';
        $data_lancamento = $_POST['data_lancamento'] ?? '';
        $nota = $_POST['nota'] ?? '';
        
        if ($id && $nome && $diretor && $data_lancamento && $nota) {
            if ($filme->atualizar($id, $nome, $diretor, $data_lancamento, $nota)) {
                $mensagem = 'Filme atualizado com sucesso!';
                $tipo_mensagem = 'success';
            } else {
                $mensagem = 'Erro ao atualizar filme.';
                $tipo_mensagem = 'error';
            }
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $acao = $_GET['acao'] ?? '';
    
    if ($acao == 'deletar') {
        $id = $_GET['id'] ?? '';
        if ($id) {
            if ($filme->deletar($id)) {
                $mensagem = 'Filme deletado com sucesso!';
                $tipo_mensagem = 'success';
            } else {
                $mensagem = 'Erro ao deletar filme.';
                $tipo_mensagem = 'error';
            }
        }
    } elseif ($acao == 'editar') {
        $id = $_GET['id'] ?? '';
        if ($id) {
            $filme_edit = $filme->obterPorId($id);
            if ($filme_edit) {
                $editando = true;
            }
        }
    }
}

$filmes = $filme->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Filmes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>🎬 Gerenciador de Filmes</h1>
        
        <?php if ($mensagem): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2><?php echo $editando ? 'Editar Filme' : 'Adicionar Novo Filme'; ?></h2>
            <form method="POST">
                <input type="hidden" name="acao" value="<?php echo $editando ? 'atualizar' : 'criar'; ?>">
                <?php if ($editando): ?>
                    <input type="hidden" name="id" value="<?php echo $filme_edit['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="nome">Nome do Filme *</label>
                    <input type="text" id="nome" name="nome" required 
                           value="<?php echo $editando ? htmlspecialchars($filme_edit['nome']) : ''; ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="diretor">Diretor *</label>
                        <input type="text" id="diretor" name="diretor" required 
                               value="<?php echo $editando ? htmlspecialchars($filme_edit['diretor']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="data_lancamento">Data de Lançamento *</label>
                        <input type="date" id="data_lancamento" name="data_lancamento" required 
                               value="<?php echo $editando ? $filme_edit['data_lancamento'] : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="nota">Nota (0-10) *</label>
                    <input type="number" id="nota" name="nota" min="0" max="10" step="0.1" required 
                           value="<?php echo $editando ? $filme_edit['nota'] : ''; ?>">
                </div>
                
                <div class="button-group">
                    <button type="submit" class="<?php echo $editando ? 'btn-update' : 'btn-add'; ?>">
                        <?php echo $editando ? 'Atualizar Filme' : 'Adicionar Filme'; ?>
                    </button>
                    <?php if ($editando): ?>
                        <a href="index.php" style="text-decoration: none;">
                            <button type="button" class="btn-cancel" style="width: 100%;">Cancelar</button>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div>
            <?php if (!empty($filmes)): ?>
                <h2 style="color: white; margin-bottom: 20px;">Filmes Cadastrados (<?php echo count($filmes); ?>)</h2>
                <div class="movies-container">
                    <?php foreach ($filmes as $f): ?>
                        <div class="movie-card">
                            <h3><?php echo htmlspecialchars($f['nome']); ?></h3>
                            <div class="movie-info">
                                <strong>Diretor:</strong> <?php echo htmlspecialchars($f['diretor']); ?>
                            </div>
                            <div class="movie-info">
                                <strong>Lançamento:</strong> <?php echo date('d/m/Y', strtotime($f['data_lancamento'])); ?>
                            </div>
                            <div class="movie-nota">
                                ⭐ <?php echo number_format($f['nota'], 1); ?>/10
                            </div>
                            <div class="movie-actions">
                                <a href="index.php?acao=editar&id=<?php echo $f['id']; ?>" style="text-decoration: none;">
                                    <button class="btn-edit">Editar</button>
                                </a>
                                <a href="index.php?acao=deletar&id=<?php echo $f['id']; ?>" 
                                   onclick="return confirm('Tem certeza que deseja deletar este filme?');" 
                                   style="text-decoration: none;">
                                    <button class="btn-delete">Deletar</button>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-movies">
                    Nenhum filme cadastrado. Adicione um novo filme para começar!
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
